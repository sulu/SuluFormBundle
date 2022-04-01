<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Configuration;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Form\Type\AbstractType;
use Sulu\Bundle\FormBundle\Media\CollectionStrategyInterface;

/**
 * Form configuration factory to create form config by form entities and types.
 */
class FormConfigurationFactory
{
    /**
     * @var CollectionStrategyInterface
     */
    private $collectionStrategy;

    /**
     * @var string
     */
    private $mailAdminTemplate;

    /**
     * @var string
     */
    private $mailAdminPlainTextTemplate;

    /**
     * @var string
     */
    private $mailWebsiteTemplate;

    /**
     * @var string
     */
    private $mailWebsitePlainTextTemplate;

    public function __construct(
        CollectionStrategyInterface $collectionStrategy,
        string $mailAdminTemplate,
        string $mailWebsiteTemplate,
        string $mailAdminPlainTextTemplate,
        string $mailWebsitePlainTextTemplate
    ) {
        $this->collectionStrategy = $collectionStrategy;
        $this->mailAdminTemplate = $mailAdminTemplate;
        $this->mailWebsiteTemplate = $mailWebsiteTemplate;
        $this->mailAdminPlainTextTemplate = $mailAdminPlainTextTemplate;
        $this->mailWebsitePlainTextTemplate = $mailWebsitePlainTextTemplate;
    }

    /**
     * Build by dynamic entity.
     */
    public function buildByDynamic(Dynamic $dynamic): FormConfigurationInterface
    {
        $form = $dynamic->getForm();
        $locale = $dynamic->getLocale();
        $translation = $form->getTranslation($locale);

        $config = $this->create($locale);
        $config->setFileFields($this->getFileFieldsByDynamic($dynamic));
        $config->setFileSave(!$translation->getDeactivateAttachmentSave());

        $adminMailConfiguration = $this->buildAdminMailConfigurationByDynamic($dynamic);
        $websiteMailConfiguration = $this->buildWebsiteMailConfigurationByDynamic($dynamic);

        $config->setAdminMailConfiguration($adminMailConfiguration);
        $config->setWebsiteMailConfiguration($websiteMailConfiguration);

        return $config;
    }

    /**
     * Build by type.
     *
     * @param mixed $formData
     * @param mixed[] $attributes
     */
    public function buildByType(AbstractType $type, $formData, string $locale, array $attributes): FormConfigurationInterface
    {
        $config = $this->create($locale);
        $config->setFileFields(\array_fill_keys($type->getFileFields(), $type->getCollectionId()));

        $attributes['form'] = [
            'data' => $formData,
        ];

        $adminMailConfiguration = $this->buildAdminMailConfigurationByTypeAndData(
            $type,
            $formData,
            $locale,
            $attributes
        );
        $websiteMailConfiguration = $this->buildWebsiteMailConfigurationByTypeAndData(
            $type,
            $formData,
            $locale,
            $attributes
        );

        $config->setAdminMailConfiguration($adminMailConfiguration);
        $config->setWebsiteMailConfiguration($websiteMailConfiguration);

        return $config;
    }

    /**
     * Build admin mail configuration by type.
     *
     * @param mixed $formData
     * @param mixed[] $attributes
     */
    private function buildAdminMailConfigurationByTypeAndData(AbstractType $type, $formData, string $locale, array $attributes): ?MailConfiguration
    {
        if ($type->getNotifyDeactivateMails($formData)) {
            return null;
        }

        $adminMailConfiguration = $this->createMailConfiguration($locale);

        $adminMailConfiguration->setSubject($type->getNotifySubject($formData));
        $adminMailConfiguration->setFrom($type->getNotifyFromMailAddress($formData));
        $adminMailConfiguration->setTo($type->getNotifyToMailAddress($formData));
        $adminMailConfiguration->setReplyTo($type->getNotifyReplyToMailAddress($formData));
        $adminMailConfiguration->setAddAttachments($type->getNotifySendAttachments($formData));
        $adminMailConfiguration->setTemplate($type->getNotifyMail($formData));
        $adminMailConfiguration->setPlainTextTemplate($type->getNotifyPlainMail($formData));
        $adminMailConfiguration->setTemplateAttributes($attributes);

        return $adminMailConfiguration;
    }

    /**
     * Build admin mail configuration by type.
     *
     * @param mixed $formData
     * @param mixed[] $attributes
     */
    private function buildWebsiteMailConfigurationByTypeAndData(AbstractType $type, $formData, string $locale, array $attributes): ?MailConfiguration
    {
        if ($type->getCustomerDeactivateMails($formData)) {
            return null;
        }

        $websiteMailConfiguration = $this->createMailConfiguration($locale);

        $websiteMailConfiguration->setSubject($type->getCustomerSubject($formData));
        $websiteMailConfiguration->setFrom($type->getCustomerFromMailAddress($formData));
        $websiteMailConfiguration->setTo($type->getCustomerToMailAddress($formData));
        $websiteMailConfiguration->setReplyTo($type->getCustomerReplyToMailAddress($formData));
        $websiteMailConfiguration->setAddAttachments(false); // Currently not implemented in the AbstractType.
        $websiteMailConfiguration->setTemplate($type->getCustomerMail($formData));
        $websiteMailConfiguration->setPlainTextTemplate($type->getCustomerPlainMail($formData));
        $websiteMailConfiguration->setTemplateAttributes($attributes);

        return $websiteMailConfiguration;
    }

    /**
     * Build admin mail configuration by dynamic entity.
     */
    private function buildAdminMailConfigurationByDynamic(Dynamic $dynamic): ?MailConfiguration
    {
        $form = $dynamic->getForm();
        $locale = $dynamic->getLocale();
        $translation = $form->getTranslation($locale);

        if ($translation->getDeactivateNotifyMails()) {
            return null;
        }

        $adminMailConfiguration = $this->createMailConfiguration($locale);

        $adminMailConfiguration->setSubject($translation->getSubject());
        $adminMailConfiguration->setFrom(
            $this->getEmail($translation->getFromEmail(), $translation->getFromName())
        );

        // Set Receivers for the email.
        $toList = $this->getEmail($translation->getToEmail(), $translation->getToName()) ?: [];
        $ccList = [];
        $bccList = [];

        foreach ($translation->getReceivers() as $receiver) {
            $email = $this->getEmail($receiver->getEmail(), $receiver->getName());

            if (MailConfigurationInterface::TYPE_TO == $receiver->getType()) {
                $toList = \array_merge($toList, $email);
            } elseif (MailConfigurationInterface::TYPE_CC == $receiver->getType()) {
                $ccList = \array_merge($ccList, $email);
            } elseif (MailConfigurationInterface::TYPE_BCC == $receiver->getType()) {
                $bccList = \array_merge($bccList, $email);
            }
        }

        $adminMailConfiguration->setTo(\array_filter($toList));
        $adminMailConfiguration->setCc(\array_filter($ccList));
        $adminMailConfiguration->setBcc(\array_filter($bccList));

        if ($translation->getReplyTo()) {
            $adminMailConfiguration->setReplyTo($this->getEmailFromDynamic($dynamic));
        }

        // Set attachment configuration.
        $adminMailConfiguration->setAddAttachments($translation->getSendAttachments());

        // Set template.
        $adminMailConfiguration->setTemplate($this->mailAdminTemplate);
        $adminMailConfiguration->setPlainTextTemplate($this->mailAdminPlainTextTemplate);
        $adminMailConfiguration->setTemplateAttributes($this->getTemplateAttributesFromDynamic($dynamic));

        return $adminMailConfiguration;
    }

    /**
     * Build website mail configuration by form translation.
     */
    private function buildWebsiteMailConfigurationByDynamic(Dynamic $dynamic): ?MailConfiguration
    {
        $form = $dynamic->getForm();
        $locale = $dynamic->getLocale();
        $translation = $form->getTranslation($locale);

        if ($translation->getDeactivateCustomerMails()) {
            return null;
        }

        $customerEmail = $this->getEmailFromDynamic($dynamic);

        if (!$customerEmail) {
            return null;
        }

        $websiteMailConfiguration = $this->createMailConfiguration($locale);

        $websiteMailConfiguration->setSubject($translation->getSubject());
        $websiteMailConfiguration->setFrom(
            $this->getEmail($translation->getFromEmail(), $translation->getFromName())
        );
        $websiteMailConfiguration->setTo($customerEmail);

        // Set attachment configuration.
        $websiteMailConfiguration->setAddAttachments($translation->getSendAttachments());

        // Set template.
        $websiteMailConfiguration->setTemplate($this->mailWebsiteTemplate);
        $websiteMailConfiguration->setPlainTextTemplate($this->mailWebsitePlainTextTemplate);
        $websiteMailConfiguration->setTemplateAttributes($this->getTemplateAttributesFromDynamic($dynamic));

        return $websiteMailConfiguration;
    }

    /**
     * Get file fields by dynamic.
     *
     * @return int[]
     */
    private function getFileFieldsByDynamic(Dynamic $dynamic): array
    {
        $form = $dynamic->getForm();

        $fields = $form->getFieldsByType(Dynamic::TYPE_ATTACHMENT);

        if (0 === \count($fields)) {
            return [];
        }

        $collectionId = $this->getCollectionIdByDynamic($dynamic);

        $fileFields = [];
        foreach ($fields as $field) {
            $fileFields[$field->getKey()] = $collectionId;
        }

        return $fileFields;
    }

    /**
     * Get collection id by dynamic.
     */
    private function getCollectionIdByDynamic(Dynamic $dynamic): int
    {
        $form = $dynamic->getForm();

        return $this->collectionStrategy->getCollectionId(
            $form->getId(),
            $form->getTranslation($dynamic->getLocale(), false, true)->getTitle(),
            $dynamic->getType(),
            $dynamic->getTypeId(),
            $dynamic->getLocale()
        );
    }

    /**
     * Get template attributes from dynamic.
     *
     * @return mixed[]
     */
    private function getTemplateAttributesFromDynamic(Dynamic $dynamic): array
    {
        return [
            // TODO FIXME this is currently overwritten in RequestListener to get the medias correctly for emails.
            'formEntity' => $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic),
        ];
    }

    /**
     * Get email from dynamic.
     *
     * @return string[]|null
     */
    private function getEmailFromDynamic(Dynamic $dynamic): ?array
    {
        $emails = $dynamic->getFieldsByType(Dynamic::TYPE_EMAIL);
        $email = \reset($emails);

        return $this->getEmail($email);
    }

    /**
     * Get email.
     *
     * @return string[]|null
     */
    private function getEmail(?string $email, ?string $name = null): ?array
    {
        if (!$email) {
            return null;
        }

        if (!$name) {
            $name = $email;
        }

        return [$email => $name];
    }

    /**
     * Create form configuration.
     */
    private function create(string $locale): FormConfiguration
    {
        return new FormConfiguration($locale);
    }

    private function createMailConfiguration(string $locale): MailConfiguration
    {
        return new MailConfiguration($locale);
    }
}
