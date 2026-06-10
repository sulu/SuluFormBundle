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
use Brevo\Contacts\ContactsClient;
use Brevo\Contacts\Types\GetListResponse;
use Brevo\Contacts\Types\GetListsResponse;
use Brevo\Contacts\Types\GetListsResponseListsItem;
use Brevo\Exceptions\BrevoException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Sulu\Bundle\FormBundle\Controller\SelectApi\BrevoListSelectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BrevoListSelectControllerTest extends TestCase
{
    /**
     * @var ContactsClient&MockObject
     */
    private ContactsClient $contacts;

    private BrevoListSelectController $controller;

    protected function setUp(): void
    {
        $brevo = new Brevo(apiKey: '');

        // createMock instead of prophecy, which crashes when mocking the ContactsClient.
        $this->contacts = $this->createMock(ContactsClient::class);
        $brevo->contacts = $this->contacts;

        $this->controller = new BrevoListSelectController($brevo);
    }

    public function testCgetActionPaginatesAndMaps(): void
    {
        $this->contacts->method('getLists')->willReturnOnConsecutiveCalls(
            new GetListsResponse(['count' => 3, 'lists' => [
                $this->listItem(1, 'Newsletter'),
                $this->listItem(2, 'Updates'),
            ]]),
            new GetListsResponse(['count' => 3, 'lists' => [
                $this->listItem(3, 'Promotions'),
            ]]),
            new GetListsResponse(['count' => 3, 'lists' => []]),
        );

        $data = $this->decode($this->controller->cgetAction(new Request()));

        $this->assertSame(3, $data['total']);
        $this->assertSame([
            ['id' => 1, 'title' => 'Newsletter'],
            ['id' => 2, 'title' => 'Updates'],
            ['id' => 3, 'title' => 'Promotions'],
        ], $data['_embedded'][BrevoListSelectController::RESOURCE_KEY]);
    }

    public function testCgetActionFiltersBySearch(): void
    {
        $this->contacts->method('getLists')->willReturnOnConsecutiveCalls(
            new GetListsResponse(['count' => 3, 'lists' => [
                $this->listItem(1, 'Newsletter'),
                $this->listItem(2, 'Updates'),
                $this->listItem(3, 'Promotions'),
            ]]),
            new GetListsResponse(['count' => 3, 'lists' => []]),
        );

        $data = $this->decode($this->controller->cgetAction(new Request(['search' => 'promo'])));

        $this->assertSame(1, $data['total']);
        $this->assertSame(
            [['id' => 3, 'title' => 'Promotions']],
            $data['_embedded'][BrevoListSelectController::RESOURCE_KEY]
        );
    }

    public function testCgetActionPaginatesResultSet(): void
    {
        $this->contacts->method('getLists')->willReturnOnConsecutiveCalls(
            new GetListsResponse(['count' => 3, 'lists' => [
                $this->listItem(1, 'Newsletter'),
                $this->listItem(2, 'Updates'),
                $this->listItem(3, 'Promotions'),
            ]]),
            new GetListsResponse(['count' => 3, 'lists' => []]),
        );

        $data = $this->decode($this->controller->cgetAction(new Request(['limit' => '2', 'page' => '2'])));

        $this->assertSame(3, $data['total']);
        $this->assertSame(2, $data['pages']);
        $this->assertSame(
            [['id' => 3, 'title' => 'Promotions']],
            $data['_embedded'][BrevoListSelectController::RESOURCE_KEY]
        );
    }

    public function testCgetActionPropagatesBrevoException(): void
    {
        $this->contacts->method('getLists')->willThrowException(new BrevoException('boom'));

        $this->expectException(BrevoException::class);
        $this->controller->cgetAction(new Request());
    }

    public function testGetActionReturnsList(): void
    {
        $this->contacts->method('getList')->willReturn(new GetListResponse([
            'id' => 5,
            'name' => 'Newsletter',
            'totalBlacklisted' => 0,
            'totalSubscribers' => 0,
            'uniqueSubscribers' => 0,
            'createdAt' => '2024-01-01T00:00:00.000Z',
            'folderId' => 1,
        ]));

        $response = $this->controller->getAction(5);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame(['id' => 5, 'title' => 'Newsletter'], $this->decode($response));
    }

    public function testGetActionReturnsNotFoundOnClientException(): void
    {
        $previous = $this->createMock(ClientExceptionInterface::class);
        $this->contacts->method('getList')->willThrowException(new BrevoException('not found', 0, $previous));

        $response = $this->controller->getAction(99);

        $this->assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testGetActionRethrowsUnexpectedException(): void
    {
        $this->contacts->method('getList')->willThrowException(new BrevoException('server error'));

        $this->expectException(BrevoException::class);
        $this->controller->getAction(99);
    }

    private function listItem(int $id, string $name): GetListsResponseListsItem
    {
        return new GetListsResponseListsItem([
            'id' => $id,
            'name' => $name,
            'totalBlacklisted' => 0,
            'totalSubscribers' => 0,
            'uniqueSubscribers' => 0,
            'folderId' => 1,
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
