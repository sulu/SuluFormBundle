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
use Brevo\TransactionalEmails\Requests\GetSmtpTemplatesRequest;

/**
 * @final
 *
 * @internal
 */
class BrevoMailTemplateSelect
{
    private const PAGE_SIZE = 50;

    public function __construct(private Brevo $api)
    {
    }

    /**
     * Returns array of Brevo mail templates of given account defined by the API key.
     *
     * @return mixed[]
     */
    public function getValues(): array
    {
        $offset = 0;
        $mailTemplateObjects = [];

        while (true) {
            $response = $this->api->transactionalEmails->getSmtpTemplates(
                new GetSmtpTemplatesRequest(['limit' => self::PAGE_SIZE, 'offset' => $offset])
            );

            if (null === $response || 0 === $response->count) {
                break;
            }

            $mailTemplateObjects = [...$mailTemplateObjects, ...($response->templates ?? [])];
            $offset += self::PAGE_SIZE;
        }

        $mailTemplates = [];
        foreach ($mailTemplateObjects as $template) {
            if ('optin' !== $template->tag) {
                continue;
            }

            $mailTemplates[] = [
                'name' => $template->id,
                'title' => $template->name,
            ];
        }

        return $mailTemplates;
    }
}
