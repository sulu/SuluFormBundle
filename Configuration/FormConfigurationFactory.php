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
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
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
        // The form can be null for orphaned submissions (the formId column is set to null
        // via "on-delete=SET NULL" when the form is deleted). A configuration cannot be built then.
        $form = $dynamic->getForm();
        if (null === $form) {
            throw new \RuntimeException('The given dynamic submission is not related to a form anymore.');
        }

        $locale = $dynamic->getLocale();
        $translation = $form->getTranslation($locale);
        if (null === $translation) {
            throw new \RuntimeException(\sprintf('The given form has no translation for locale "%s".', $locale));
        }

        $config = $this->create($locale);
        $config->setFileFields($this->getFileFieldsByDynamic($dynamic, $form));
        $config->setFileSave(!$translation->getDeactivateAttachmentSave());

        $config->setAdminMailConfiguration($this->buildAdminMailConfigurationByDynamic($dynamic, $form, $translation));
        $config->setWebsiteMailConfiguration($this->buildWebsiteMailConfigurationByDynamic($dynamic, $form, $translation));

        return $config;
    }

    /**
     * Build admin mail configuration by dynamic entity.
     */
    private function buildAdminMailConfigurationByDynamic(Dynamic $dynamic, Form $form, FormTranslation $translation): ?MailConfiguration
    {
        $locale = $dynamic->getLocale();

        if ($translation->getDeactivateNotifyMails()) {
            return null;
        }

        $adminMailConfiguration = $this->createMailConfiguration($locale);

        $adminMailConfiguration->setSubject($translation->getSubject());
        $adminMailConfiguration->setFrom(
            $this->getEmail($translation->getFromEmail(), $translation->getFromName()) ?: []
        );

        // Set Receivers for the email.
        $toList = $this->getEmail($translation->getToEmail(), $translation->getToName()) ?: [];
        $ccList = [];
        $bccList = [];

        foreach ($translation->getReceivers() as $receiver) {
            $email = $this->getEmail($receiver->getEmail(), $receiver->getName());

            if (null === $email) {
                continue;
            }

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
            $adminMailConfiguration->setReplyTo($this->getEmailFromDynamic($dynamic) ?: []);
        }

        // Set attachment configuration.
        $adminMailConfiguration->setAddAttachments($translation->getSendAttachments());

        // Set template.
        $adminMailConfiguration->setTemplate($this->mailAdminTemplate);
        $adminMailConfiguration->setPlainTextTemplate($this->mailAdminPlainTextTemplate);
        $adminMailConfiguration->setTemplateAttributes($this->getTemplateAttributesFromDynamic($dynamic, $form));

        return $adminMailConfiguration;
    }

    /**
     * Build website mail configuration by form translation.
     */
    private function buildWebsiteMailConfigurationByDynamic(Dynamic $dynamic, Form $form, FormTranslation $translation): ?MailConfiguration
    {
        $locale = $dynamic->getLocale();

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
            $this->getEmail($translation->getFromEmail(), $translation->getFromName()) ?: []
        );
        $websiteMailConfiguration->setTo($customerEmail);

        // Set attachment configuration.
        $websiteMailConfiguration->setAddAttachments($translation->getSendAttachments());

        // Set template.
        $websiteMailConfiguration->setTemplate($this->mailWebsiteTemplate);
        $websiteMailConfiguration->setPlainTextTemplate($this->mailWebsitePlainTextTemplate);
        $websiteMailConfiguration->setTemplateAttributes($this->getTemplateAttributesFromDynamic($dynamic, $form));

        return $websiteMailConfiguration;
    }

    /**
     * Get file fields by dynamic.
     *
     * @return int[]
     */
    private function getFileFieldsByDynamic(Dynamic $dynamic, Form $form): array
    {
        $fields = $form->getFieldsByType(Dynamic::TYPE_ATTACHMENT);

        if (0 === \count($fields)) {
            return [];
        }

        $collectionId = $this->getCollectionIdByDynamic($dynamic, $form);

        $fileFields = [];
        foreach ($fields as $field) {
            $fileFields[$field->getKey()] = $collectionId;
        }

        return $fileFields;
    }

    /**
     * Get collection id by dynamic.
     */
    private function getCollectionIdByDynamic(Dynamic $dynamic, Form $form): int
    {
        $formId = $form->getId();

        if (null === $formId) {
            throw new \RuntimeException('The given form has no id.');
        }

        // The collection title uses the default-locale fallback translation.
        $translation = $form->getTranslation($dynamic->getLocale(), false, true);
        if (null === $translation) {
            throw new \RuntimeException(\sprintf('The given form has no translation for locale "%s".', $dynamic->getLocale()));
        }

        return $this->collectionStrategy->getCollectionId(
            $formId,
            $translation->getTitle(),
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
    private function getTemplateAttributesFromDynamic(Dynamic $dynamic, Form $form): array
    {
        return [
            // TODO FIXME this is currently overwritten in RequestListener to get the medias correctly for emails.
            'formEntity' => $form->serializeForLocale($dynamic->getLocale(), $dynamic),
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

        return $this->getEmail(\is_string($email) ? $email : null);
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
