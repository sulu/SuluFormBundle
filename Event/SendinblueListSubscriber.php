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

use GuzzleHttp\ClientInterface;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Model\CreateDoiContact;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @final
 *
 * @internal
 */
class SendinblueListSubscriber implements EventSubscriberInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ContactsApi|null
     */
    private $contactsApi;

    public function __construct(
        RequestStack $requestStack,
        ?string $apiKey,
        ?ClientInterface $client = null
    ) {
        $this->requestStack = $requestStack;

        if (!$apiKey) {
            return;
        }

        $config = new Configuration();
        $config->setApiKey('api-key', $apiKey);

        $this->contactsApi = new ContactsApi($client, $config);
    }

    public static function getSubscribedEvents()
    {
        return [
            FormSavePostEvent::NAME => 'listSubscribe',
        ];
    }

    public function listSubscribe(FormSavePostEvent $event): void
    {
        if (!$this->contactsApi) {
            return;
        }

        $dynamic = $event->getData();
        $request = $this->requestStack->getCurrentRequest();

        if (!$dynamic instanceof Dynamic) {
            return;
        }

        if (!$request) {
            return;
        }

        $form = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);

        $email = '';
        $firstName = '';
        $lastName = '';
        $redirectionUrl = $request->getUriForPath('') . '?subscribe=true';
        $listIdsByMailTemplate = [];

        foreach ($form['fields'] as $field) {
            if ('firstName' === $field['type'] && !$firstName) {
                $firstName = $field['value'];
            } elseif ('lastName' === $field['type'] && !$lastName) {
                $lastName = $field['value'];
            } elseif ('email' === $field['type'] && !$email) {
                $email = $field['value'];
            } elseif ('sendinblue' == $field['type'] && $field['value']) {
                /** @var string|int|null $listId */
                $mailTemplateId = $field['options']['mailTemplateId'] ?? null;
                /** @var int|null $listId */
                $listId = $field['options']['listId'] ?? null;

                if (!$mailTemplateId || !$listId) {
                    continue;
                }

                $listIdsByMailTemplate[$mailTemplateId][] = $listId;
            }
        }

        /** @var string $email */
        if (!$email || 0 === \count($listIdsByMailTemplate)) {
            return;
        }

        foreach ($listIdsByMailTemplate as $mailTemplateId => $listIds) {
            $createDoiContact = new CreateDoiContact([
                'email' => $email,
                'templateId' => $mailTemplateId,
                'includeListIds' => $listIds,
                'redirectionUrl' => $redirectionUrl,
                'attributes' => [
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                ],
                'updateEnabled' => true,
            ]);

            $this->contactsApi->createDoiContact($createDoiContact);
        }
    }
}
