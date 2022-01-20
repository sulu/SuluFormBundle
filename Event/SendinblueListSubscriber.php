<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateDoiContact;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SendinblueListSubscriber implements EventSubscriberInterface
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FormSavePostEvent::NAME => 'listSubscribe',
        ];
    }

    public function listSubscribe(FormSavePostEvent $event): void
    {
        $dynamic = $event->getData();

        if (!$dynamic instanceof Dynamic) {
            return;
        }

        $form = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);

        $email = '';
        $firstName = '';
        $lastName = '';
        $listsByMailTemplate = [];

        foreach ($form['fields'] as $field) {
            if ('firstName' === $field['type'] && !$firstName) {
                $firstName = $field['value'];
            } elseif ('lastName' === $field['type'] && !$lastName) {
                $lastName = $field['value'];
            } elseif ('email' === $field['type'] && !$email) {
                $email = $field['value'];
            } elseif ('sendinblue' == $field['type'] && $field['value']) {
                $mailTemplateId = $field['options']['mailTemplateId'] ?? null;
                $listId = $field['options']['listId'] ?? null;
                $redirectionUrl = $field['options']['redirectionUrl'] ?? null;
                $attributeNameFirstName = ($field['options']['attributeNameFirstName'] ?? null) ?: 'FIRST_NAME';
                $attributeNameLastName = ($field['options']['attributeNameLastName'] ?? null) ?: 'LAST_NAME';

                if (!$mailTemplateId || !$listId || !$redirectionUrl) {
                    continue;
                }

                $listsByMailTemplate[$mailTemplateId][] = [
                    'listId' => $listId,
                    'redirectionUrl' => $redirectionUrl,
                    'attributeNameFirstName' => $attributeNameFirstName,
                    'attributeNameLastName' => $attributeNameLastName,
                ];
            }
        }

        if ($email && count($listsByMailTemplate) > 0) {
            foreach ($listsByMailTemplate as $mailTemplateId => $lists) {
                $redirectionUrl = $lists[0]['redirectionUrl'];
                $attributeNameFirstName = $lists[0]['attributeNameFirstName'];
                $attributeNameLastName = $lists[0]['attributeNameLastName'];
                $listIds = \array_map(function($list) {
                    return $list['listId'];
                }, $lists);

                $createDoiContact = new CreateDoiContact([
                    'email' => $email,
                    'templateId' => $mailTemplateId,
                    'includeListIds' => $listIds,
                    'redirectionUrl' => $redirectionUrl,
                    'attributes' => [
                        $attributeNameFirstName => $firstName,
                        $attributeNameLastName => $firstName,
                    ],
                ]);

                $this->contactsApi->createDoiContact($createDoiContact);
            }
        }
    }
}
