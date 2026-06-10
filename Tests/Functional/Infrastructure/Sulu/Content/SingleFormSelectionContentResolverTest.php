<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Infrastructure\Sulu\Content;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Sulu\Component\Webspace\Analyzer\Attributes\RequestAttributes;
use Sulu\Component\Webspace\Webspace;
use Sulu\Content\Application\ContentAggregator\ContentAggregatorInterface;
use Sulu\Content\Application\ContentResolver\ContentResolverInterface;
use Sulu\Content\Domain\Model\WorkflowInterface;
use Sulu\Messenger\Infrastructure\Symfony\Messenger\FlushMiddleware\EnableFlushStamp;
use Sulu\Page\Application\Message\ApplyWorkflowTransitionPageMessage;
use Sulu\Page\Application\Message\CreatePageMessage;
use Sulu\Page\Application\MessageHandler\CreatePageMessageHandler;
use Sulu\Page\Domain\Model\Page;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * End-to-end test proving the 2.6 form-render parity contract:
 *
 * - content['form'] is a FormView (the form was built and is renderable).
 * - view['form']['entity'] contains the serialized form data including title and successText.
 */
class SingleFormSelectionContentResolverTest extends SuluTestCase
{
    private EntityManagerInterface $entityManager;
    private ContentResolverInterface $contentResolver;
    private ContentAggregatorInterface $contentAggregator;
    private RequestStack $requestStack;

    public function setUp(): void
    {
        static::purgeDatabase();
        static::bootKernel();

        $container = static::getContainer();
        $this->entityManager = static::getEntityManager();

        /** @var ContentResolverInterface $contentResolver */
        $contentResolver = $container->get('sulu_content.content_resolver');
        $this->contentResolver = $contentResolver;

        /** @var ContentAggregatorInterface $contentAggregator */
        $contentAggregator = $container->get('sulu_content.content_aggregator');
        $this->contentAggregator = $contentAggregator;

        /** @var RequestStack $requestStack */
        $requestStack = $container->get('request_stack');
        $this->requestStack = $requestStack;
    }

    public function testContentResolverReturnsFormViewAndEntityData(): void
    {
        $form = new Form();
        $form->setDefaultLocale('de');

        $translation = new FormTranslation();
        $translation->setForm($form);
        $translation->setLocale('de');
        $translation->setTitle('My Test Form');
        $translation->setSuccessText('Thank you!');
        $form->addTranslation($translation);

        $this->entityManager->persist($form);
        $this->entityManager->flush();

        $formId = $form->getId();
        $this->assertNotNull($formId);

        // A homepage root is required before child pages can be created.
        $homepage = new Page();
        $homepage->setWebspaceKey('sulu-io');
        $homepage->setLft(0);
        $homepage->setRgt(1);
        $homepage->setDepth(0);
        $this->entityManager->persist($homepage);
        $this->entityManager->flush();

        $messageBus = static::getContainer()->get('sulu_message_bus');

        $envelope = $messageBus->dispatch(new Envelope(
            new CreatePageMessage(
                webspaceKey: 'sulu-io',
                parentId: CreatePageMessageHandler::HOMEPAGE_PARENT_ID,
                data: [
                    'locale' => 'de',
                    'template' => 'overview',
                    'title' => 'Test Page',
                    'url' => '/test-page',
                    'form' => $formId,
                ],
            ),
            [new EnableFlushStamp()],
        ));

        /** @var HandledStamp[] $handledStamps */
        $handledStamps = $envelope->all(HandledStamp::class);
        $page = $handledStamps[0]->getResult();

        $messageBus->dispatch(new Envelope(
            new ApplyWorkflowTransitionPageMessage(
                identifier: ['uuid' => $page->getUuid()],
                locale: 'de',
                transitionName: WorkflowInterface::WORKFLOW_TRANSITION_PUBLISH,
            ),
            [new EnableFlushStamp()],
        ));

        $dimensionContent = $this->contentAggregator->aggregate($page, ['locale' => 'de', 'stage' => 'live']);

        // 'object' lets FormResourceLoader derive type/typeId; '_sulu' lets Builder resolve the webspace key.
        $webspace = new Webspace();
        $webspace->setKey('sulu-io');

        $suluAttributes = new RequestAttributes(['webspace' => $webspace]);

        $request = Request::create('http://sulu.io/test-page');
        $request->attributes->set('object', $dimensionContent);
        $request->attributes->set('_sulu', $suluAttributes);
        $this->requestStack->push($request);

        try {
            $result = $this->contentResolver->resolve($dimensionContent);
        } finally {
            $this->requestStack->pop();
        }

        $this->assertArrayHasKey('form', $result['content']);
        $this->assertInstanceOf(
            FormView::class,
            $result['content']['form'],
            'content[\'form\'] must be a FormView so templates can call {{ form(content.form) }}'
        );

        $this->assertArrayHasKey('form', $result['view']);
        $formView = $result['view']['form'];
        $this->assertIsArray($formView, 'view[\'form\'] must be an array');
        $this->assertArrayHasKey('entity', $formView, 'view[\'form\'] must have an \'entity\' key');

        $entity = $formView['entity'];
        $this->assertIsArray($entity, 'view[\'form\'][\'entity\'] must be an array');
        $this->assertSame('My Test Form', $entity['title'], 'view[\'form\'][\'entity\'][\'title\'] must match');
        $this->assertSame('Thank you!', $entity['successText'], 'view[\'form\'][\'entity\'][\'successText\'] must match');
    }
}
