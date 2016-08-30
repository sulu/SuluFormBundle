<?php

namespace L91\Sulu\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractType extends SymfonyAbstractType implements TypeInterface
{
    /**
     * @var string
     */
    protected $dataClass;

    /**
     * @var bool
     */
    protected $csrfProtection = true;

    /**
     * @var bool
     */
    protected $csrfFieldName = '_token';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaults = [
            'csrf_protection' => $this->csrfProtection,
        ];

        if ($this->csrfProtection) {
            $defaults['csrf_field_name'] = $this->csrfFieldName;
            $defaults['intention'] = $this->getDefaultIntention();
        }

        if ($this->dataClass) {
            $defaults['data_class'] = $this->dataClass;
        }
    }

    /**
     * @return string
     */
    public function getDefaultIntention()
    {
        return $this->getName();
    }

    /**
     * @param $name
     * @param string $parent
     *
     * @return mixed
     */
    protected function getAttribute($name, $parent = 'content')
    {
        if (
            isset($this->attributes[$parent])
            && isset($this->attributes[$parent][$name])
        ) {
            return $this->attributes[$parent][$name];
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerSubject($formData = [])
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifySubject($formData = [])
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerMail($formData = [])
    {
        return 'ClientWebsiteBundle:views:form/mail/' . $this->getName() . '/success.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyMail($formData = [])
    {
        return 'ClientWebsiteBundle:views:form/mail/' . $this->getName() . '/notify.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerFromMailAddress($formData = [])
    {
        return $this->getAttribute('mail_customer_from_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerToMailAddress($formData = [])
    {
        $email = $this->getAttribute('mail_customer_to_address');

        if (is_object($formData)) {
            if (method_exists($formData, 'getEmail')) {
                $email = $formData->getEmail();
            } elseif (isset($formData->email)) {
                $email = $formData->email;
            }
        } elseif (is_array($formData) && isset($formData['email'])) {
            $email = $formData['email'];
        }

        return $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerReplyToMailAddress($formData = [])
    {
        return $this->getAttribute('mail_customer_replyto_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyFromMailAddress($formData = [])
    {
        return $this->getAttribute('mail_notify_from_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyToMailAddress($formData = [])
    {
        return $this->getAttribute('mail_notify_to_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyReplyToMailAddress($formData = [])
    {
        return $this->getAttribute('mail_notify_replyto_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifySendAttachments($formData = [])
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyDeactivateMails($formData = [])
    {
        return (bool) $this->getNotifyMail($formData);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerDeactivateMails($formData = [])
    {
        return (bool) $this->getCustomerMail($formData);
    }

    /**
     * {@inheritdoc}
     */
    public function getMailText($formData = [])
    {
        return $this->getAttribute('mail_text');
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessText($formData = [])
    {
        return $this->getAttribute('success_text');
    }

    /**
     * {@inheritdoc}
     */
    public function getFileFields()
    {
        return ['files'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionId()
    {
        return;
    }
}
