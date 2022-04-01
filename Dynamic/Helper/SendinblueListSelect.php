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

use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;

/**
 * @final
 *
 * @internal
 */
class SendinblueListSelect
{
    /**
     * @var ContactsApi|null
     */
    private $contactsApi;

    public function __construct(?string $apiKey)
    {
        if (!$apiKey) {
            return;
        }

        $config = new Configuration();
        $config->setApiKey('api-key', $apiKey);

        $this->contactsApi = new ContactsApi(null, $config);
    }

    /**
     * Returns array of Sendinblue lists of given account defined by the API key.
     *
     * @return mixed[]
     */
    public function getValues(): array
    {
        if (!$this->contactsApi) {
            return [];
        }

        $limit = 50;
        $offset = 0;
        $total = null;
        $listObjects = [];

        do {
            $response = $this->contactsApi->getLists($limit, $offset);

            if (null === $total) {
                $total = $response->getCount();
            }

            $newListObjects = $response->getLists();
            if (0 === \count($newListObjects)) {
                break;
            }

            $listObjects = \array_merge($listObjects, $newListObjects);
            $offset += $limit;
        } while (\count($listObjects) < $total);

        $lists = [];

        foreach ($listObjects as $list) {
            $lists[] = [
                'name' => $list['id'],
                'title' => $list['name'],
            ];
        }

        return $lists;
    }
}
