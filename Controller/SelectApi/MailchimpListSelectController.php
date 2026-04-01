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

use Sulu\Component\Rest\ListBuilder\CollectionRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;

/**
 * @internal
 */
class MailchimpListSelectController
{
    public const RESOURCE_KEY = 'mailchimp_list_select';

    public function __construct(private ?string $apiKey)
    {
    }

    /**
     * Returns array of Mailchimp lists of given account defined by the API key.
     */
    public function cgetAction(): JsonResponse
    {
        $lists = [];

        if (!$this->apiKey) {
            return new JsonResponse(
                ['message' => 'No API Keys configured for mailchimp'],
                Response::HTTP_PRECONDITION_FAILED,
            );
        }

        $mailChimp = new \DrewM\MailChimp\MailChimp($this->apiKey);
        $response = $mailChimp->get('lists', ['count' => 100]);

        foreach ($response['lists'] ?? [] as $list) {
            $lists[] = [
                'id' => $list['id'],
                'title' => $list['name'],
            ];
        }

        return new JsonResponse((new CollectionRepresentation($lists, self::RESOURCE_KEY))->toArray());
    }

    public function getAction(int $id): JsonResponse
    {
        throw new NotImplementedException('Please implement this in ' . self::class . '::' . __METHOD__);
    }
}
