<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Unit\Controller\SelectApi;

use Brevo\Brevo;
use Brevo\Exceptions\BrevoException;
use Brevo\TransactionalEmails\TransactionalEmailsClient;
use Brevo\TransactionalEmails\Types\GetSmtpTemplatesResponse;
use Brevo\Types\GetSmtpTemplateOverview;
use Brevo\Types\GetSmtpTemplateOverviewSender;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Sulu\Bundle\FormBundle\Controller\SelectApi\BrevoMailTemplateSelectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BrevoMailTemplateSelectControllerTest extends TestCase
{
    /**
     * @var TransactionalEmailsClient&MockObject
     */
    private TransactionalEmailsClient $transactionalEmails;

    private BrevoMailTemplateSelectController $controller;

    protected function setUp(): void
    {
        $brevo = new Brevo(apiKey: '');

        // createMock instead of prophecy, which crashes when mocking the client.
        $this->transactionalEmails = $this->createMock(TransactionalEmailsClient::class);
        $brevo->transactionalEmails = $this->transactionalEmails;

        $this->controller = new BrevoMailTemplateSelectController($brevo);
    }

    public function testCgetActionKeepsOnlyOptinTemplates(): void
    {
        $this->transactionalEmails->method('getSmtpTemplates')->willReturnOnConsecutiveCalls(
            new GetSmtpTemplatesResponse(['count' => 3, 'templates' => [
                $this->template(1, 'Welcome', 'optin'),
                $this->template(2, 'Receipt', 'transactional'),
                $this->template(3, 'Confirm', 'optin'),
            ]]),
            new GetSmtpTemplatesResponse(['count' => 3, 'templates' => []]),
        );

        $data = $this->decode($this->controller->cgetAction(new Request()));

        $this->assertSame(2, $data['total']);
        $this->assertSame([
            ['id' => 1, 'title' => 'Welcome'],
            ['id' => 3, 'title' => 'Confirm'],
        ], $data['_embedded'][BrevoMailTemplateSelectController::RESOURCE_KEY]);
    }

    public function testCgetActionFiltersBySearch(): void
    {
        $this->transactionalEmails->method('getSmtpTemplates')->willReturnOnConsecutiveCalls(
            new GetSmtpTemplatesResponse(['count' => 2, 'templates' => [
                $this->template(1, 'Welcome', 'optin'),
                $this->template(3, 'Confirm', 'optin'),
            ]]),
            new GetSmtpTemplatesResponse(['count' => 2, 'templates' => []]),
        );

        $data = $this->decode($this->controller->cgetAction(new Request(['search' => 'confirm'])));

        $this->assertSame(1, $data['total']);
        $this->assertSame(
            [['id' => 3, 'title' => 'Confirm']],
            $data['_embedded'][BrevoMailTemplateSelectController::RESOURCE_KEY]
        );
    }

    public function testCgetActionPropagatesBrevoException(): void
    {
        $this->transactionalEmails->method('getSmtpTemplates')->willThrowException(new BrevoException('boom'));

        $this->expectException(BrevoException::class);
        $this->controller->cgetAction(new Request());
    }

    public function testGetActionReturnsTemplate(): void
    {
        $this->transactionalEmails->method('getSmtpTemplate')->willReturn($this->template(7, 'Welcome', 'optin'));

        $response = $this->controller->getAction(7);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame(['id' => 7, 'title' => 'Welcome'], $this->decode($response));
    }

    public function testGetActionReturnsNotFoundOnClientException(): void
    {
        $previous = $this->createMock(ClientExceptionInterface::class);
        $this->transactionalEmails->method('getSmtpTemplate')
            ->willThrowException(new BrevoException('not found', 0, $previous));

        $response = $this->controller->getAction(99);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testGetActionRethrowsUnexpectedException(): void
    {
        $this->transactionalEmails->method('getSmtpTemplate')->willThrowException(new BrevoException('server error'));

        $this->expectException(BrevoException::class);
        $this->controller->getAction(99);
    }

    private function template(int $id, string $name, string $tag): GetSmtpTemplateOverview
    {
        return new GetSmtpTemplateOverview([
            'createdAt' => '2024-01-01T00:00:00.000Z',
            'htmlContent' => '',
            'id' => $id,
            'isActive' => true,
            'modifiedAt' => '2024-01-01T00:00:00.000Z',
            'name' => $name,
            'replyTo' => 'noreply@example.org',
            'sender' => new GetSmtpTemplateOverviewSender([]),
            'subject' => 'Subject',
            'tag' => $tag,
            'testSent' => false,
            'toField' => '',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function decode(Response $response): array
    {
        $content = $response->getContent();
        $this->assertIsString($content);

        return \json_decode($content, true);
    }
}
