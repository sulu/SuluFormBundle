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
use Sulu\Component\Rest\ListBuilder\CollectionRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class BrevoListSelectController
{
    private const PAGE_SIZE = 100;

    public const RESOURCE_KEY = 'brevo_list_select';

    public function __construct(private Brevo $api)
    {
    }

    /**
     * Returns array of Brevo lists of given account defined by the API key.
     */
    public function cgetAction(): JsonResponse
    {
        $offset = 0;
        $listObjects = [];

        while (true) {
            $response = $this->api->contacts->getLists(
                new GetListsRequest(['limit' => self::PAGE_SIZE, 'offset' => $offset]),
            );

            if (null === $response || 0 === $response->count) {
                break;
            }

            $listObjects = [...$listObjects, ...($response->lists ?? [])];
            $offset += self::PAGE_SIZE;
        }

        $lists = [];
        foreach ($listObjects as $list) {
            $lists[] = [
                'id' => $list->id,
                'title' => $list->name,
            ];
        }

        return new JsonResponse((new CollectionRepresentation($lists, self::RESOURCE_KEY))->toArray());
    }

    public function getAction(int $id): JsonResponse
    {
        try {
            $response = $this->api->contacts->getList($id);
            \assert(null !== $response);

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
