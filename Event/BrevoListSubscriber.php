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

        $form = $formEntity->serializeForLocale($dynamic->getLocale(), $dynamic);

        $email = '';
        $firstName = '';
        $lastName = '';
        $redirectionUrl = $request->getUriForPath($request->getPathInfo()) . '?send=true&subscribe=true';
        $linkUrl = null;
        $listIdsByMailTemplate = [];

        $fields = $form['fields'] ?? [];
        if (!\is_array($fields)) {
            return;
        }

        foreach ($fields as $field) {
            if (!\is_array($field)) {
                continue;
            }

            $type = $field['type'] ?? null;
            $value = $field['value'] ?? null;

            if ('firstName' === $type && !$firstName) {
                $firstName = \is_string($value) ? $value : '';
            } elseif ('lastName' === $type && !$lastName) {
                $lastName = \is_string($value) ? $value : '';
            } elseif ('email' === $type && !$email) {
                $email = \is_string($value) ? $value : '';
            } elseif ('brevo' == $type && $value) {
                $options = $field['options'] ?? null;
                $options = \is_array($options) ? $options : [];

                $mailTemplateId = $options['mailTemplateId'] ?? null;
                $listId = $options['listId'] ?? null;
                $redirectLink = $options['redirectLink'] ?? null;

                if (\is_array($redirectLink)) {
                    $linkUrl = $this->getUrlFromLink($redirectLink);
                }

                if (!\is_numeric($mailTemplateId) || !\is_numeric($listId)) {
                    continue;
                }

                $listIdsByMailTemplate[(int) $mailTemplateId][] = (int) $listId;
            }
        }

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
     * @param array<array-key, mixed> $redirectLink
     */
    private function getUrlFromLink(array $redirectLink): ?string
    {
        $provider = $redirectLink['provider'] ?? null;
        if (!\is_string($provider) || '' === $provider) {
            return null;
        }

        $href = $redirectLink['href'] ?? null;
        $href = \is_string($href) ? $href : null;

        if ('external' === $provider) {
            return $href;
        }

        if (!$this->linkProviderPool) {
            return null;
        }

        if (null === $href || '' === $href) {
            return null;
        }

        $locale = $redirectLink['locale'] ?? null;
        $linkProvider = $this->linkProviderPool->getProvider($provider);
        $linkItems = \iterator_to_array($linkProvider->preload([$href], \is_string($locale) ? $locale : '', true));

        $firstItem = \reset($linkItems);
        if (false === $firstItem) {
            return null;
        }

        $url = $firstItem->getUrl();
        $query = $redirectLink['query'] ?? null;
        if (\is_string($query)) {
            $url = \sprintf('%s?%s', $url, $query);
        }
        $anchor = $redirectLink['anchor'] ?? null;
        if (\is_string($anchor)) {
            $url = \sprintf('%s#%s', $url, $anchor);
        }

        return $url;
    }
}
