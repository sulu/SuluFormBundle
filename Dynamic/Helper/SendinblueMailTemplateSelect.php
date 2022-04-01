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

use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Configuration;

/**
 * @final
 *
 * @internal
 */
class SendinblueMailTemplateSelect
{
    /**
     * @var TransactionalEmailsApi|null
     */
    private $transactionalEmailsApi;

    public function __construct(?string $apiKey)
    {
        if (!$apiKey) {
            return;
        }

        $config = new Configuration();
        $config->setApiKey('api-key', $apiKey);

        $this->transactionalEmailsApi = new TransactionalEmailsApi(null, $config);
    }

    /**
     * Returns array of Sendinblue mail templates of given account defined by the API key.
     *
     * @return mixed[]
     */
    public function getValues(): array
    {
        if (!$this->transactionalEmailsApi) {
            return [];
        }

        $limit = 50;
        $offset = 0;
        $total = null;
        $mailTemplateObjects = [];

        do {
            $response = $this->transactionalEmailsApi->getSmtpTemplates('true', $limit, $offset);

            if (null === $total) {
                $total = $response->getCount();
            }

            $newMailTemplateObjects = $response->getTemplates();
            if (0 === \count($newMailTemplateObjects)) {
                break;
            }

            $mailTemplateObjects = \array_merge($mailTemplateObjects, $newMailTemplateObjects);
            $offset += $limit;
        } while (\count($mailTemplateObjects) < $total);

        $mailTemplates = [];

        foreach ($mailTemplateObjects as $template) {
            if (($template['tag'] ?? null) !== 'optin') {
                continue;
            }

            $mailTemplates[] = [
                'name' => $template['id'],
                'title' => $template['name'],
            ];
        }

        return $mailTemplates;
    }
}
