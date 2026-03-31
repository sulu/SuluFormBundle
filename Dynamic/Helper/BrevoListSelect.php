<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Helper;

use Brevo\Brevo;
use Brevo\Contacts\Requests\GetListsRequest;

/**
 * @final
 *
 * @internal
 */
class BrevoListSelect
{
    private const PAGE_SIZE = 50;

    public function __construct(private Brevo $api)
    {
    }

    /**
     * Returns array of Brevo lists of given account defined by the API key.
     *
     * @return mixed[]
     */
    public function getValues(): array
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
                'name' => $list->id,
                'title' => $list->name,
            ];
        }

        return $lists;
    }
}
