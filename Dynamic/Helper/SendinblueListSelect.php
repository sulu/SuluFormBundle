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

class SendinblueListSelect
{
    /**
     * @var ContactsApi
     */
    private $contactsApi;

    public function __construct(?string $apiKey)
    {
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
        $lists = [];

        $listObjects = $this->contactsApi->getLists()->getLists();
        foreach ($listObjects as $list) {
            $lists[] = [
                'name' => $list['id'],
                'title' => $list['name'],
            ];
        }

        return $lists;
    }
}
