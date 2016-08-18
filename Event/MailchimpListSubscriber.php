<?php

namespace L91\Sulu\Bundle\FormBundle\Event;

use DrewM\MailChimp\MailChimp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailchimpListSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    protected $mailchimpApiKey;

    /**
     * MailchimpListSubscriber constructor.
     *
     * @param string $mailchimpApiKey
     */
    public function __construct($mailchimpApiKey = '')
    {
        $this->mailchimpApiKey = $mailchimpApiKey;
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
    public function listSubscribe(DynFormSavedEvent $event) {
        $form = $event->getFormSelect();
        $email = isset($form['toEmail']) ? $form['toEmail'] : '';
        $mailchimpFields = [];

        foreach($form['fields'] as $field) {
            if (strpos($field['key'], 'mailchimp') !== false) {
                $mailchimpFields[] = $field;
            }
        }

        if ($email != '' && $this->mailchimpApiKey != '' && count($mailchimpFields) > 0) {
            $MailChimp = new MailChimp($this->mailchimpApiKey);
            foreach ($mailchimpFields as $mailchimpField) {
                if (isset($mailchimpField['options']['mailchimpListId'])
                    && $mailchimpField['options']['mailchimpListId'] != ''
                    && $mailchimpField['value']
                ) {
                    $MailChimp->post('lists/' . $mailchimpField['options']['mailchimpListId'] . '/members', [
                        'email_address' => $email,
                        'status'        => 'subscribed',
                    ]);
                }
            }
        }
    }
}