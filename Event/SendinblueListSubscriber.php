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
use Sulu\Bundle\MarkupBundle\Markup\Link\LinkProviderPoolInterface;
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

    /**
     * @var ?LinkProviderPoolInterface
     */
    private $linkProviderPool;

    public function __construct(
        RequestStack $requestStack,
        ?string $apiKey,
        ?ClientInterface $client = null,
        ?LinkProviderPoolInterface $linkProviderPool = null
    ) {
        $this->requestStack = $requestStack;
        $this->linkProviderPool = $linkProviderPool;

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
        $redirectionUrl = $request->getUriForPath($request->getPathInfo()) . '?send=true&subscribe=true';
        $linkUrl = null;
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
                $redirectLink = $field['options']['redirectLink'] ?? null;

                if ($redirectLink) {
                    $linkUrl = $this->getUrlFromLink($redirectLink);
                }

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
                'redirectionUrl' => $linkUrl ?? $redirectionUrl,
                'attributes' => [
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                ],
            ]);

            $this->contactsApi->createDoiContact($createDoiContact);
        }
    }

    /**
     * @param array{
     *     provider: ?string,
     *     target: ?string,
     *     anchor: ?string,
     *     query: ?string,
     *     href: ?string,
     *     title: ?string,
     *     rel: ?string,
     *     locale: ?string,
     * } $redirectLink
     */
    private function getUrlFromLink(array $redirectLink): ?string
    {
        if (!$redirectLink['provider']) {
            return null;
        }

        if ('external' === $redirectLink['provider']) {
            return $redirectLink['href'];
        }

        if (!$this->linkProviderPool) {
            return null;
        }

        $linkProvider = $this->linkProviderPool->getProvider($redirectLink['provider']);
        $linkItems = $linkProvider->preload([$redirectLink['href']], $redirectLink['locale'], true);

        if (0 === \count($linkItems)) {
            return null;
        }

        $url = \reset($linkItems)->getUrl();
        if (isset($redirectLink['query'])) {
            $url = \sprintf('%s?%s', $url, $redirectLink['query']);
        }
        if (isset($redirectLink['anchor'])) {
            $url = \sprintf('%s#%s', $url, $redirectLink['anchor']);
        }

        return $url;
    }
}
