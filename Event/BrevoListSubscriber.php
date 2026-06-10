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

use Brevo\Brevo;
use Brevo\Contacts\Requests\CreateDoiContactRequest;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\MarkupBundle\Markup\Link\LinkProviderPoolInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @final
 *
 * @internal
 */
class BrevoListSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private Brevo $api,
        private ?LinkProviderPoolInterface $linkProviderPool = null
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormSavePostEvent::NAME => 'listSubscribe',
        ];
    }

    public function listSubscribe(FormSavePostEvent $event): void
    {
        $dynamic = $event->getData();
        $request = $this->requestStack->getCurrentRequest();

        if (!$dynamic instanceof Dynamic) {
            return;
        }

        if (!$request) {
            return;
        }

        $formEntity = $dynamic->getForm();

        if (null === $formEntity) {
            return;
        }

        $form = $formEntity->serializeForLocale($dynamic->getLocale(), $dynamic);

        $email = '';
        $firstName = '';
        $lastName = '';
        $redirectionUrl = $request->getUriForPath($request->getPathInfo()) . '?send=true&subscribe=true';
        $linkUrl = null;
        $listIdsByMailTemplate = [];

        foreach ($form['fields'] as $field) {
            if ('firstName' === $field['type'] && !$firstName) {
                /** @var string $firstName */
                $firstName = $field['value'];
            } elseif ('lastName' === $field['type'] && !$lastName) {
                /** @var string $lastName */
                $lastName = $field['value'];
            } elseif ('email' === $field['type'] && !$email) {
                $email = $field['value'];
            } elseif ('brevo' == $field['type'] && $field['value']) {
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
            $createDoiContact = new CreateDoiContactRequest([
                'email' => $email,
                'includeListIds' => $listIds,
                'redirectionUrl' => $linkUrl ?? $redirectionUrl,
                'attributes' => [
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                ],
                'templateId' => $mailTemplateId,
            ]);

            $this->api->contacts->createDoiContact($createDoiContact);
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
        $linkItems = \iterator_to_array($linkProvider->preload([$redirectLink['href']], $redirectLink['locale'], true));

        $firstItem = \reset($linkItems);
        if (false === $firstItem) {
            return null;
        }

        $url = $firstItem->getUrl();
        if (isset($redirectLink['query'])) {
            $url = \sprintf('%s?%s', $url, $redirectLink['query']);
        }
        if (isset($redirectLink['anchor'])) {
            $url = \sprintf('%s#%s', $url, $redirectLink['anchor']);
        }

        return $url;
    }
}
