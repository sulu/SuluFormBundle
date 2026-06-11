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

namespace Sulu\Bundle\FormBundle\Tests\Functional\Infrastructure\Sulu\Content\ResourceLoader;

use Doctrine\ORM\EntityManagerInterface;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\ResourceLoader\FormResourceLoader;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Sulu\Page\Domain\Model\Page;
use Sulu\Page\Domain\Model\PageDimensionContent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FormResourceLoaderTest extends SuluTestCase
{
    use ProphecyTrait;

    private EntityManagerInterface $entityManager;

    private FormResourceLoader $loader;

    public function setUp(): void
    {
        static::purgeDatabase();
        static::bootKernel();

        $container = static::getContainer();
        /** @var FormRepository $repository */
        $repository = $container->get('sulu_form.repository.form');
        /** @var RequestStack $requestStack */
        $requestStack = $container->get('request_stack');

        $request = new Request();
        $request->attributes->set('object', new PageDimensionContent(new Page('page-1')));
        $requestStack->push($request);

        $this->loader = new FormResourceLoader($repository, $this->createBuilder(), $requestStack);
        $this->entityManager = static::getEntityManager();
    }

    public function testLoadReturnsEmptyWhenLocaleIsNull(): void
    {
        $form = $this->createForm(['en']);
        $this->entityManager->flush();

        $result = $this->loader->load([(string) $form->getId()], null);

        $this->assertSame([], $result);
    }

    public function testLoadReturnsFormsForRequestedLocale(): void
    {
        $formEn = $this->createForm(['en']);
        $formDe = $this->createForm(['de']);
        $formBoth = $this->createForm(['en', 'de']);
        $this->entityManager->flush();

        $ids = [$formEn->getId(), $formDe->getId(), $formBoth->getId()];

        $result = $this->loader->load($ids, 'en');

        $this->assertArrayHasKey($formEn->getId(), $result);
        $this->assertArrayNotHasKey($formDe->getId(), $result);
        $this->assertArrayHasKey($formBoth->getId(), $result);
    }

    public function testLoadFallsBackToShadowLocaleForMissingTranslations(): void
    {
        $formEn = $this->createForm(['en']);
        $formDeOnly = $this->createForm(['de']);
        $this->entityManager->flush();

        $result = $this->loader->load(
            [$formEn->getId(), $formDeOnly->getId()],
            'en',
            ['_shadowLocale' => 'de']
        );

        $this->assertArrayHasKey($formEn->getId(), $result);
        $this->assertArrayHasKey($formDeOnly->getId(), $result);
        $this->assertSame('title-en', $result[$formEn->getId()]['entity']['title']);
        $this->assertSame('title-de', $result[$formDeOnly->getId()]['entity']['title']);
    }

    public function testLoadDoesNotFallBackWhenShadowLocaleAlsoMissing(): void
    {
        $formFr = $this->createForm(['fr']);
        $this->entityManager->flush();

        $result = $this->loader->load(
            [$formFr->getId()],
            'en',
            ['_shadowLocale' => 'de']
        );

        $this->assertSame([], $result);
    }

    public function testLoadDoesNotFallBackWhenShadowLocaleNotProvided(): void
    {
        $formDeOnly = $this->createForm(['de']);
        $this->entityManager->flush();

        $result = $this->loader->load([$formDeOnly->getId()], 'en');

        $this->assertSame([], $result);
    }

    public function testLoadDoesNotFallBackWhenShadowLocaleIsNotString(): void
    {
        $formDeOnly = $this->createForm(['de']);
        $this->entityManager->flush();

        $result = $this->loader->load(
            [$formDeOnly->getId()],
            'en',
            ['_shadowLocale' => null]
        );

        $this->assertSame([], $result);
    }

    public function testShadowDoesNotOverrideExistingPrimaryLocaleEntries(): void
    {
        $form = $this->createForm(['en', 'de']);
        $this->entityManager->flush();

        $result = $this->loader->load(
            [$form->getId()],
            'en',
            ['_shadowLocale' => 'de']
        );

        $this->assertCount(1, $result);
        $this->assertArrayHasKey($form->getId(), $result);
        $this->assertSame('title-en', $result[$form->getId()]['entity']['title']);
    }

    public function testLoadReturnsEmptyWhenNotInRenderRequest(): void
    {
        $form = $this->createForm(['en']);
        $this->entityManager->flush();

        /** @var RequestStack $requestStack */
        $requestStack = static::getContainer()->get('request_stack');
        $requestStack->pop();

        $result = $this->loader->load([(string) $form->getId()], 'en');

        $this->assertSame([], $result);
    }

    public function testLoadCastsStringIdsToInt(): void
    {
        $form = $this->createForm(['en']);
        $this->entityManager->flush();

        $result = $this->loader->load([(string) $form->getId()], 'en');

        $this->assertArrayHasKey($form->getId(), $result);
    }

    public function testGetKey(): void
    {
        $this->assertSame('form', FormResourceLoader::getKey());
    }

    private function createBuilder(): BuilderInterface
    {
        $form = $this->prophesize(FormInterface::class);
        $form->createView()->willReturn(new FormView());

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(\Prophecy\Argument::cetera())->willReturn($form->reveal());

        return $builder->reveal();
    }

    /**
     * @param string[] $locales
     */
    private function createForm(array $locales): Form
    {
        $form = new Form();
        $form->setDefaultLocale($locales[0]);

        foreach ($locales as $locale) {
            $translation = new FormTranslation();
            $translation->setForm($form);
            $translation->setLocale($locale);
            $translation->setTitle('title-' . $locale);
            $form->addTranslation($translation);
        }

        $this->entityManager->persist($form);

        return $form;
    }
}
