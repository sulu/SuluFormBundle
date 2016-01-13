<?php

namespace L91\Sulu\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractType
 * @package L91\Sulu\Bundle\FormBundle\Form\Type
 */
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
    protected $attributes = array();

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaults = array(
            'csrf_protection' => $this->csrfProtection
        );

        if ($this->csrfProtection) {
            $defaults['csrf_field_name'] = $this->csrfFieldName;
            $defaults['intention'] = $this->getDefaultIntention();
        }

        if ($this->dataClass) {
            $defaults['data_class'] = $this->dataClass;
        }

        $resolver->setDefaults($defaults);
    }

    /**
     * @return string
     */
    public function getDefaultIntention()
    {
        return md5($this->getName());
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

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerSubject($formData = array())
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifySubject($formData = array())
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerMail($formData = array())
    {
        return 'ClientWebsiteBundle:views:form/mail/' . $this->getName() . '/success.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyMail($formData = array())
    {
        return 'ClientWebsiteBundle:views:form/mail/' . $this->getName() . '/notify.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerFromMailAddress($formData = array())
    {
        return $this->getAttribute('mail_customer_from_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerToMailAddress($formData = array())
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
    public function getCustomerReplyToMailAddress($formData = array())
    {
        return $this->getAttribute('mail_customer_replyto_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyFromMailAddress($formData = array())
    {
        return $this->getAttribute('mail_notify_from_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyToMailAddress($formData = array())
    {
        return $this->getAttribute('mail_notify_to_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyReplyToMailAddress($formData = array())
    {
        return $this->getAttribute('mail_notify_replyto_address');
    }
}