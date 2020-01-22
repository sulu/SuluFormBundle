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

class MailchimpListSelect
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param string|null $apiKey
     */
    public function __construct(?string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Returns array of Mailchimp lists of given account defined by the API key.
     *
     * @return mixed[]
     */
    public function getValues(): array
    {
        $lists = [];

        if (!$this->apiKey) {
            return $lists;
        }

        $mailChimp = new \DrewM\MailChimp\MailChimp($this->apiKey);
        $response = $mailChimp->get('lists', ['count' => 100]);

        if (!isset($response['lists'])) {
            return $lists;
        }

        foreach ($response['lists'] as $list) {
            $lists[] = [
                'name' => $list['id'],
                'title' => $list['name'],
            ];
        }

        return $lists;
    }
}
