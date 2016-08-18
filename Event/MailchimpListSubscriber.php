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

    public function listSubscribe(DynFormSavedEvent $event) {
        $form = $event->getForm();
        $email = $form->has('email') ? $form->get('email')->getData() : '';
        $mailchimpChecked = false;
        $listId = '';

        if ($form->has('mailchimp')) {
            $mailchimpChecked = $form->get('mailchimp')->getData();
            //$form->get('mailchimp')->getSerializedObject()['fields']['mailchimp']['options'];
        }
        var_dump($form->get('mailchimp')->getConfig()->getOptions());
        exit;

        if ($mailchimpChecked && $email != '' && $listId != '' && $this->mailchimpApiKey != '') {
            $MailChimp = new MailChimp($this->mailchimpApiKey);
            $MailChimp->post('lists/' . $listId . '/members', [
                'email_address' => $email,
                'status'        => 'subscribed',
            ]);
        }
    }
}