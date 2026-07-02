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

use DrewM\MailChimp\MailChimp;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @final
 *
 * @internal
 */
class MailchimpListSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $subscribeStatus;

    public function __construct(string $apiKey = '', string $subscribeStatus = 'subscribed')
    {
        $this->apiKey = $apiKey;
        $this->subscribeStatus = $subscribeStatus;
    }

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

        $formEntity = $dynamic->getForm();

        $form = $formEntity->serializeForLocale($dynamic->getLocale(), $dynamic);

        $email = '';
        $fname = '';
        $lname = '';
        $listIds = [];

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

            if ('firstName' == $type && !$fname) {
                $fname = \is_string($value) ? $value : '';
            } elseif ('lastName' == $type && !$lname) {
                $lname = \is_string($value) ? $value : '';
            } elseif ('email' == $type && !$email) {
                $email = \is_string($value) ? $value : '';
            } elseif ('mailchimp' == $type && $value) {
                $options = $field['options'] ?? null;
                $options = \is_array($options) ? $options : [];
                $listId = $options['listId'] ?? null;

                if (\is_scalar($listId)) {
                    $listIds[] = (string) $listId;
                }
            }
        }

        if ('' != $email && '' != $this->apiKey && \count($listIds) > 0) {
            $MailChimp = new MailChimp($this->apiKey);
            foreach ($listIds as $listId) {
                if (!$listId) {
                    continue;
                }

                $MailChimp->post('lists/' . $listId . '/members', [
                    'email_address' => $email,
                    'status' => $this->subscribeStatus,
                ]);

                if ('' == $fname && '' == $lname) {
                    continue;
                }

                $subscriber_hash = $MailChimp->subscriberHash($email);
                $MailChimp->patch('lists/' . $listId . '/members/' . $subscriber_hash, [
                    'merge_fields' => [
                        'FNAME' => $fname,
                        'LNAME' => $lname,
                    ],
                ]);
            }
        }
    }
}
