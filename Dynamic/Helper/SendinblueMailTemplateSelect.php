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
 * @internal
 */
class SendinblueMailTemplateSelect
{
    /**
     * @var TransactionalEmailsApi
     */
    private $transactionalEmailsApi;

    public function __construct(?string $apiKey)
    {
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
        $mailTemplates = [];

        $mailTemplateObjects = $this->transactionalEmailsApi->getSmtpTemplates('true')->getTemplates();
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
