<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Unit\Event;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\RequestInterface;
use Sulu\Bundle\FormBundle\Configuration\FormConfiguration;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Event\FormSavePostEvent;
use Sulu\Bundle\FormBundle\Event\SendinblueListSubscriber;
use Sulu\Bundle\MarkupBundle\Markup\Link\LinkItem;
use Sulu\Bundle\MarkupBundle\Markup\Link\LinkProviderInterface;
use Sulu\Bundle\MarkupBundle\Markup\Link\LinkProviderPoolInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SendinblueListSubscriberTest extends TestCase
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ObjectProphecy<ClientInterface>
     */
    private $client;

    /**
     * @var SendinblueListSubscriber
     */
    private $sendinblueListSubscriber;

    /**
     * @var LinkProviderPoolInterface|ObjectProphecy
     */
    private $linkProviderPool;

    public function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $this->linkProviderPool = $this->prophesize(LinkProviderPoolInterface::class);
        $this->client = $this->prophesize(ClientInterface::class);

        $this->sendinblueListSubscriber = new SendinblueListSubscriber(
            $this->requestStack,
            'SOME_KEY',
            $this->client->reveal(),
            $this->linkProviderPool->reveal()
        );
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertSame(
            [
                'sulu_form.handler.saved' => 'listSubscribe',
            ],
            SendinblueListSubscriber::getSubscribedEvents()
        );
    }

    public function testlistSubscribeNotExist(): void
    {
        $this->requestStack->push(Request::create('http://localhost/newsletter', 'POST'));
        $event = $this->createFormSavePostEvent();

        $self = $this;
        $this->client->send(Argument::cetera())->will(function($args) use ($self) {
            /** @var RequestInterface $request */
            $request = $args[0];

            if ('https://api.sendinblue.com/v3/contacts/doubleOptinConfirmation' === $request->getUri()->__toString()) {
                $self->assertSame('POST', $request->getMethod());

                $json = \json_decode($request->getBody()->getContents(), true);

                $self->assertSame([
                    'email' => 'john.doe@example.org',
                    'attributes' => [
                        'firstname' => 'John',
                        'lastname' => 'Doe',
                    ],
                    'includeListIds' => ['789'],
                    'templateId' => 456,
                    'redirectionUrl' => 'http://localhost/newsletter?send=true&subscribe=true',
                ], $json);

                return new Response();
            }

            throw new \RuntimeException('Unexpected request: ' . $request->getUri()->__toString());
        })
            ->shouldBeCalledOnce();

        // act
        $this->sendinblueListSubscriber->listSubscribe($event);

        $this->assertTrue(true);
    }

    public function testlistSubscriberRedirectUrl(): void
    {
        $this->requestStack->push(Request::create('http://localhost/newsletter', 'POST'));
        $event = $this->createFormSavePostEvent(true);

        $self = $this;
        $this->client->send(Argument::cetera())->will(function($args) use ($self) {
            /** @var RequestInterface $request */
            $request = $args[0];

            if ('https://api.sendinblue.com/v3/contacts/doubleOptinConfirmation' === $request->getUri()->__toString()) {
                $self->assertSame('POST', $request->getMethod());

                $json = \json_decode($request->getBody()->getContents(), true);

                $self->assertSame([
                    'email' => 'john.doe@example.org',
                    'attributes' => [
                        'firstname' => 'John',
                        'lastname' => 'Doe',
                    ],
                    'includeListIds' => ['789'],
                    'templateId' => 456,
                    'redirectionUrl' => '/test-page',
                ], $json);

                return new Response();
            }

            throw new \RuntimeException('Unexpected request: ' . $request->getUri()->__toString());
        })
            ->shouldBeCalledOnce();

        /** @var LinkProviderInterface|ObjectProphecy $linkProvider */
        $linkProvider = $this->prophesize(LinkProviderInterface::class);
        $linkItem = new LinkItem('1', 'test-page', '/test-page', true);
        $this->linkProviderPool->getProvider('page')->shouldBeCalled()->willReturn($linkProvider->reveal());
        $linkProvider->preload(['123-123-123'], 'de', true)->shouldBeCalled()->willReturn([$linkItem]);

        // act
        $this->sendinblueListSubscriber->listSubscribe($event);

        $this->assertTrue(true);
    }

    private function createFormSavePostEvent(bool $redirectLink = false): FormSavePostEvent
    {
        $symfonyForm = $this->prophesize(FormInterface::class);
        $formConfiguration = new FormConfiguration('en');
        $form = new Form();
        $form->setDefaultLocale('en');
        $formTranslation = new FormTranslation();
        $formTranslation->setLocale('en');
        $formTranslation->setTitle('Form');
        $form->addTranslation($formTranslation);

        $fields = [
            [
                'type' => 'firstName',
                'required' => true,
            ],
            [
                'type' => 'lastName',
                'required' => true,
            ],
            [
                'type' => 'email',
                'required' => true,
            ],
            [
                'type' => 'sendinblue',
                'options' => [
                    'mailTemplateId' => '456',
                    'listId' => '789',
                ],
            ],
        ];

        if ($redirectLink) {
            $fields[3]['options']['redirectLink'] = [
                'provider' => 'page',
                'href' => '123-123-123',
                'locale' => 'de',
            ];
        }

        foreach ($fields as $key => $field) {
            $formField = new FormField();
            $formField->setForm($form);
            $formField->setDefaultLocale('en');
            $formField->setType($field['type']);
            $formField->setOrder($key);
            $formField->setKey($field['type']);

            $formFieldTranslation = $formField->getTranslation('en', true);
            $formFieldTranslation->setTitle(\ucfirst($field['type']));
            $formFieldTranslation->setOptions($field['options'] ?? []);

            $form->addField($formField);
        }

        $dynamic = new Dynamic(
            'page',
            '123',
            'en',
            $form,
            [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john.doe@example.org',
                'sendinblue' => true,
            ]
        );

        $symfonyForm->getData()->willReturn($dynamic);

        return new FormSavePostEvent($symfonyForm->reveal(), $formConfiguration);
    }
}
