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
use Sulu\Component\Rest\ListBuilder\CollectionRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @internal
 */
class MailchimpListSelectController
{
    private const PAGE_SIZE = 100;

    public const RESOURCE_KEY = 'mailchimp_list_select';

    public function __construct(private ?string $apiKey)
    {
    }

    private function getClient(): MailChimp
    {
        if (!$this->apiKey) {
            throw HttpException::fromStatusCode(
                Response::HTTP_PRECONDITION_FAILED,
                'No API Keys configured for mailchimp',
            );
        }

        return new MailChimp($this->apiKey);
    }

    /**
     * Returns array of Mailchimp lists of given account defined by the API key.
     */
    public function cgetAction(): JsonResponse
    {
        $lists = [];

        $listResponses = [];
        $offset = 0;
        $mailChimp = $this->getClient();

        while (true) {
            $response = $mailChimp->get('lists', ['count' => self::PAGE_SIZE, 'offset' => $offset]);

            if (false === $response) {
                break;
            }

            $mailChimpLists = $response['lists'] ?? [];
            if ([] === $mailChimpLists) {
                break;
            }

            $listResponses = [
                ...$listResponses, ...$mailChimpLists,
            ];
            $offset += self::PAGE_SIZE;
        }

        foreach ($listResponses as $list) {
            $lists[] = [
                'id' => $list['id'],
                'title' => $list['name'],
            ];
        }

        return new JsonResponse((new CollectionRepresentation($lists, self::RESOURCE_KEY))->toArray());
    }

    public function getAction(int $id): JsonResponse
    {
        $response = $this->getClient()->get('lists/' . $id, ['fields' => 'id,name']);
        if (false === $response) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(['id' => $response['id'], 'name' => $response['name']]);
    }
}
