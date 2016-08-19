<?php

namespace L91\Sulu\Bundle\FormBundle\Event;

use DrewM\MailChimp\MailChimp;
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
            DynFormSavedEvent::NAME => 'listSubscribe',
        ];
    }

    /**
     * @param DynFormSavedEvent $event
     */
    public function listSubscribe(DynFormSavedEvent $event)
    {
        $form = $event->getFormSelect();
        $email = '';
        $fname = '';
        $lname = '';
        $mailchimpFields = [];

        foreach ($form['fields'] as $field) {
            if ($field['type'] == 'firstName' && !$fname) {
                $fname = $field['value'];
            } else if ($field['type'] == 'lastName' && !$lname) {
                $lname = $field['value'];
            } else if ($field['type'] == 'email' && !$email) {
                $email = $field['value'];
            } else if ($field['type'] == 'mailchimp') {
                $mailchimpFields[] = $field;
            }
        }

        if ($email != '' && $this->apiKey != '' && count($mailchimpFields) > 0) {
            $MailChimp = new MailChimp($this->apiKey);
            foreach ($mailchimpFields as $mailchimpField) {
                if (isset($mailchimpField['options']['listId'])
                    || !$mailchimpField['options']['listId'] != ''
                    || !$mailchimpField['value']
                ) {
                    continue;
                }

                $listId = $mailchimpField['options']['listId'];

                $MailChimp->post('lists/' . $listId . '/members', [
                    'email_address' => $email,
                    'status' => 'subscribed',
                ]);

                if ($fname == '' && $lname == '') {
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
