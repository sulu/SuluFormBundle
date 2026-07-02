<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller\SelectApi;

use Brevo\Brevo;
use Brevo\Contacts\Requests\GetListsRequest;
use Brevo\Exceptions\BrevoException;
use Psr\Http\Client\ClientExceptionInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @final
 *
 * @internal
 */
class BrevoListSelectController
{
    // Brevo's GET /contacts/lists endpoint caps `limit` at 50 (returns "out_of_range" above that).
    private const PAGE_SIZE = 50;

    public const RESOURCE_KEY = 'brevo_list_select';

    public function __construct(private Brevo $api)
    {
    }

    public function cgetAction(Request $request): JsonResponse
    {
        $limit = \max(1, (int) $request->query->get('limit', '100'));
        $page = \max(1, (int) $request->query->get('page', '1'));
        $search = (string) $request->query->get('search', '');

        $all = $this->fetchAll();

        if ('' !== $search) {
            $all = \array_values(\array_filter(
                $all, fn (array $item): bool => false !== \stripos((string) $item['title'], $search)
            ));
        }

        $total = \count($all);
        $items = \array_slice($all, ($page - 1) * $limit, $limit);

        return new JsonResponse(
            (new PaginatedRepresentation($items, self::RESOURCE_KEY, $page, $limit, $total))->toArray()
        );
    }

    /**
     * @return array<array{id: mixed, title: string}>
     */
    private function fetchAll(): array
    {
        $offset = 0;
        $listObjects = [];

        while (true) {
            $response = $this->api->contacts->getLists(
                new GetListsRequest(['limit' => self::PAGE_SIZE, 'offset' => $offset]),
            );

            $lists = $response->lists ?? [];
            if ([] === $lists) {
                break;
            }

            $listObjects = [...$listObjects, ...$lists];
            $offset += self::PAGE_SIZE;
        }

        $lists = [];
        foreach ($listObjects as $list) {
            $lists[] = [
                'id' => $list->id,
                'title' => $list->name,
            ];
        }

        return $lists;
    }

    public function getAction(int $id): JsonResponse
    {
        try {
            $response = $this->api->contacts->getList($id);
            if (null === $response) {
                return new JsonResponse([], Response::HTTP_NOT_FOUND);
            }

            return new JsonResponse(['id' => $response->id, 'title' => $response->name]);
        } catch (BrevoException $e) {
            $previous = $e->getPrevious();
            if ($previous instanceof ClientExceptionInterface) {
                return new JsonResponse([], Response::HTTP_NOT_FOUND);
            }
            throw $e;
        }
    }
}
