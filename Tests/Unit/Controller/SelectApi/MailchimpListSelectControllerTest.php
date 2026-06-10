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

use DrewM\MailChimp\MailChimp;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\FormBundle\Controller\SelectApi\MailchimpListSelectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MailchimpListSelectControllerTest extends TestCase
{
    /**
     * @var MailChimp&MockObject
     */
    private MailChimp $client;

    private MailchimpListSelectController $controller;

    protected function setUp(): void
    {
        $this->client = $this->createMock(MailChimp::class);
        $this->controller = $this->createController($this->client);
    }

    private function createController(MailChimp $client): MailchimpListSelectController
    {
        return new class('us1-test', $client) extends MailchimpListSelectController {
            public function __construct(?string $apiKey, private MailChimp $client)
            {
                parent::__construct($apiKey);
            }

            protected function getClient(): MailChimp
            {
                return $this->client;
            }
        };
    }

    public function testCgetActionPaginatesAndMaps(): void
    {
        $this->client->method('success')->willReturn(true);
        $this->client->method('get')->willReturnOnConsecutiveCalls(
            ['lists' => [
                ['id' => 'a1', 'name' => 'List A'],
                ['id' => 'b2', 'name' => 'List B'],
            ]],
            ['lists' => []],
        );

        $data = $this->decode($this->controller->cgetAction(new Request()));

        $this->assertSame(2, $data['total']);
        $this->assertSame([
            ['id' => 'a1', 'title' => 'List A'],
            ['id' => 'b2', 'title' => 'List B'],
        ], $data['_embedded'][MailchimpListSelectController::RESOURCE_KEY]);
    }

    public function testCgetActionFiltersBySearch(): void
    {
        $this->client->method('success')->willReturn(true);
        $this->client->method('get')->willReturnOnConsecutiveCalls(
            ['lists' => [
                ['id' => 'a1', 'name' => 'Newsletter'],
                ['id' => 'b2', 'name' => 'Promotions'],
            ]],
            ['lists' => []],
        );

        $data = $this->decode($this->controller->cgetAction(new Request(['search' => 'promo'])));

        $this->assertSame(1, $data['total']);
        $this->assertSame(
            [['id' => 'b2', 'title' => 'Promotions']],
            $data['_embedded'][MailchimpListSelectController::RESOURCE_KEY]
        );
    }

    public function testCgetActionThrowsOnApiError(): void
    {
        $this->client->method('success')->willReturn(false);
        $this->client->method('get')->willReturn(['status' => 401, 'detail' => 'API Key Invalid']);
        $this->client->method('getLastError')->willReturn('401: API Key Invalid');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Could not fetch Mailchimp lists: 401: API Key Invalid');
        $this->controller->cgetAction(new Request());
    }

    public function testCgetActionThrowsWhenNoApiKeyConfigured(): void
    {
        $controller = new MailchimpListSelectController(null);

        try {
            $controller->cgetAction(new Request());
            $this->fail('Expected HttpException was not thrown.');
        } catch (HttpException $exception) {
            $this->assertSame(Response::HTTP_PRECONDITION_FAILED, $exception->getStatusCode());
        }
    }

    public function testGetActionReturnsList(): void
    {
        $this->client->method('success')->willReturn(true);
        $this->client->method('get')->willReturn(['id' => 'a1', 'name' => 'List A']);

        $response = $this->controller->getAction('a1');

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame(['id' => 'a1', 'title' => 'List A'], $this->decode($response));
    }

    public function testGetActionReturnsNotFoundOnApiError(): void
    {
        $this->client->method('success')->willReturn(false);
        $this->client->method('get')->willReturn(['status' => 404, 'detail' => 'Not found']);

        $this->expectException(NotFoundHttpException::class);
        $this->controller->getAction('missing');
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
