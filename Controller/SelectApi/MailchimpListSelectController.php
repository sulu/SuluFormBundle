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

use DrewM\MailChimp\MailChimp;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @final
 *
 * @internal
 */
class MailchimpListSelectController
{
    private const PAGE_SIZE = 100;

    public const RESOURCE_KEY = 'mailchimp_list_select';

    public function __construct(private ?string $apiKey)
    {
    }

    protected function getClient(): MailChimp
    {
        if (!$this->apiKey) {
            throw new HttpException(
                Response::HTTP_PRECONDITION_FAILED,
                'No API Keys configured for mailchimp',
            );
        }

        return new MailChimp($this->apiKey);
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
        $mappedLists = [];
        $offset = 0;
        $mailChimp = $this->getClient();

        while (true) {
            $response = $mailChimp->get('lists', ['count' => self::PAGE_SIZE, 'offset' => $offset]);

            if (!$mailChimp->success() || !\is_array($response)) {
                throw new \RuntimeException(
                    \sprintf('Could not fetch Mailchimp lists: %s', $mailChimp->getLastError() ?: 'unknown error')
                );
            }

            $pageLists = $response['lists'] ?? [];
            if ([] === $pageLists) {
                break;
            }

            foreach ($pageLists as $list) {
                $mappedLists[] = [
                    'id' => $list['id'],
                    'title' => $list['name'],
                ];
            }
            $offset += self::PAGE_SIZE;
        }

        return $mappedLists;
    }

    public function getAction(string $id): JsonResponse
    {
        $client = $this->getClient();
        $response = $client->get('lists/' . $id, ['fields' => 'id,name']);
        if (!$client->success() || !\is_array($response)) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(['id' => $response['id'], 'title' => $response['name']]);
    }
}
