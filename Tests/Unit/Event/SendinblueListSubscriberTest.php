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
use SendinBlue\Client\ApiException;
use Sulu\Bundle\FormBundle\Configuration\FormConfiguration;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Event\FormSavePostEvent;
use Sulu\Bundle\FormBundle\Event\SendinblueListSubscriber;
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

    public function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $this->client = $this->prophesize(ClientInterface::class);

        $this->sendinblueListSubscriber = new SendinblueListSubscriber(
            $this->requestStack,
            'SOME_KEY',
            $this->client->reveal()
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
        $this->requestStack->push(Request::create('http://localhost/', 'POST'));
        $event = $this->createFormSavePostEvent();

        $self = $this;
        $this->client->send(Argument::cetera())->will(function($args) use ($self) {
            /** @var RequestInterface $request */
            $request = $args[0];

            if ('https://api.sendinblue.com/v3/contacts/john.doe%40example.org' === $request->getUri()->__toString()) {
                $self->assertSame('GET', $request->getMethod());

                throw new ApiException('', 404);
            }

            if ('https://api.sendinblue.com/v3/contacts/doubleOptinConfirmation' === $request->getUri()->__toString()) {
                $self->assertSame('POST', $request->getMethod());

                $json = \json_decode($request->getBody()->getContents(), true);

                $self->assertSame([
                    'email' => 'john.doe@example.org',
                    'attributes' => [
                        'FIRST_NAME' => 'John',
                        'LAST_NAME' => 'Doe',
                    ],
                    'includeListIds' => ['789'],
                    'templateId' => 456,
                    'redirectionUrl' => 'http://localhost?subscribe=true',
                ], $json);

                return new Response();
            }

            throw new \RuntimeException('Unexpected request: ' . $request->getUri()->__toString());
        })
            ->shouldBeCalledTimes(2);

        // act
        $this->sendinblueListSubscriber->listSubscribe($event);

        $this->assertTrue(true);
    }

    public function testlistSubscribeAlreadyExist(): void
    {
        $this->requestStack->push(Request::create('http://localhost/', 'POST'));
        $event = $this->createFormSavePostEvent();

        $self = $this;
        $this->client->send(Argument::cetera())->will(function($args) use ($self) {
            /** @var RequestInterface $request */
            $request = $args[0];

            if ('https://api.sendinblue.com/v3/contacts/john.doe%40example.org' === $request->getUri()->__toString()
                && 'GET' === $request->getMethod()
            ) {
                return new Response(200, ['Content-Type' => 'application/json'], \json_encode([
                    'id' => 123,
                    'email' => 'john.doe@example.org',
                    'attributes' => [],
                    'listIds' => [],
                ]));
            }

            if ('https://api.sendinblue.com/v3/contacts/john.doe%40example.org' === $request->getUri()->__toString()
                && 'PUT' === $request->getMethod()
            ) {
                $json = \json_decode($request->getBody()->getContents(), true);

                $self->assertSame([
                    'attributes' => [
                        'FIRST_NAME' => 'John',
                        'LAST_NAME' => 'Doe',
                    ],
                    'listIds' => ['789'],
                ], $json);

                return new Response();
            }

            throw new \RuntimeException('Unexpected request (' . $request->getMethod() . '): ' . $request->getUri()->__toString());
        })
            ->shouldBeCalledTimes(2);

        // act
        $this->sendinblueListSubscriber->listSubscribe($event);

        $this->assertTrue(true);
    }

    private function createFormSavePostEvent(): FormSavePostEvent
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
