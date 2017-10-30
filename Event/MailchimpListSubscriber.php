<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use DrewM\MailChimp\MailChimp;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Form\HandlerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailchimpListSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * MailchimpListSubscriber constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey = '')
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            HandlerInterface::EVENT_FORM_SAVED => 'listSubscribe',
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function listSubscribe(FormEvent $event)
    {
        $dynamic = $event->getData();

        if (!$dynamic instanceof Dynamic) {
            return;
        }

        $form = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);

        $email = '';
        $fname = '';
        $lname = '';
        $listIds = [];

        foreach ($form['fields'] as $field) {
            if ('firstName' == $field['type'] && !$fname) {
                $fname = $field['value'];
            } elseif ('lastName' == $field['type'] && !$lname) {
                $lname = $field['value'];
            } elseif ('email' == $field['type'] && !$email) {
                $email = $field['value'];
            } elseif ('mailchimp' == $field['type'] && $field['value']) {
                $listIds[] = $field['options']['listId'];
            }
        }

        if ('' != $email && '' != $this->apiKey && count($listIds) > 0) {
            $MailChimp = new MailChimp($this->apiKey);
            foreach ($listIds as $listId) {
                if (!$listId) {
                    continue;
                }

                $MailChimp->post('lists/' . $listId . '/members', [
                    'email_address' => $email,
                    'status' => 'subscribed',
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
