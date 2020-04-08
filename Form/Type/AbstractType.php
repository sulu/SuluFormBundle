<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @deprecated static forms are not longer supported this way
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
     * @var string
     */
    protected $csrfFieldName = '_token';

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes): void
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

        $resolver->setDefaults($defaults);
    }

    public function getDefaultIntention(): string
    {
        return $this->getName();
    }

    /**
     * @return mixed|null
     */
    protected function getAttribute(string $name, string $parent = 'content')
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
    public function getCustomerSubject($formData = []): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifySubject($formData = []): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerMail($formData = []): string
    {
        return '@ClientWebsite/views/form/mail/' . $this->getName() . '/success.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyMail($formData = []): string
    {
        return '@ClientWebsite/views/form/mail/' . $this->getName() . '/notify.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerPlainMail($formData = []): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyPlainMail($formData = []): ?string
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerFromMailAddress($formData = []): string
    {
        return $this->getAttribute('mail_customer_from_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerToMailAddress($formData = []): string
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
    public function getCustomerReplyToMailAddress($formData = []): string
    {
        return $this->getAttribute('mail_customer_replyto_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyFromMailAddress($formData = []): string
    {
        return $this->getAttribute('mail_notify_from_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyToMailAddress($formData = []): string
    {
        return $this->getAttribute('mail_notify_to_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyReplyToMailAddress($formData = []): string
    {
        return $this->getAttribute('mail_notify_replyto_address');
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifySendAttachments($formData = []): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyDeactivateMails($formData = []): bool
    {
        return !$this->getNotifyMail($formData);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerDeactivateMails($formData = []): bool
    {
        return !$this->getCustomerMail($formData);
    }

    /**
     * {@inheritdoc}
     */
    public function getMailText($formData = []): string
    {
        return $this->getAttribute('mail_text');
    }

    /**
     * @param mixed $formData
     */
    public function getSubmitLabel($formData = []): string
    {
        return $this->getAttribute('submit_label');
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessText($formData = []): string
    {
        return $this->getAttribute('success_text');
    }

    /**
     * {@inheritdoc}
     */
    public function getFileFields(): array
    {
        return ['files'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionId(): ?int
    {
        return null;
    }

    /**
     * @see https://github.com/symfony/symfony/blob/2.8/src/Symfony/Component/Form/AbstractType.php
     */
    public function getName(): string
    {
        // As of Symfony 2.8, the name defaults to the fully-qualified class name
        return get_class($this);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefixes default to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @see https://github.com/symfony/symfony/blob/2.8/src/Symfony/Component/Form/AbstractType.php
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix()
    {
        $fqcn = get_class($this);
        $name = $this->getName();
        // For BC: Use the name as block prefix if one is set
        return $name !== $fqcn ? $name : StringUtil::fqcnToBlockPrefix($fqcn);
    }
}
