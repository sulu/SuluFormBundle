<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Form entity.
 */
class Form
{
    public const RESOURCE_KEY = 'forms';

    /**
     * @var null|int
     */
    private $id;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var Collection<int, FormTranslation>
     */
    private $translations;

    /**
     * @var Collection<int, FormField>
     */
    private $fields;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->fields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDefaultLocale(): string
    {
        return $this->defaultLocale;
    }

    public function setDefaultLocale(string $defaultLocale): self
    {
        $this->defaultLocale = $defaultLocale;

        return $this;
    }

    public function addTranslation(FormTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    public function removeTranslation(FormTranslation $translation): self
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    /**
     * Get translations.
     *
     * @return Collection<int, FormTranslation>
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    public function getTranslation(string $locale, bool $create = false, bool $fallback = false): ?FormTranslation
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }

        if ($create) {
            $translation = new FormTranslation();
            $translation->setLocale($locale);
            $this->addTranslation($translation);
            $translation->setForm($this);

            return $translation;
        }

        if ($fallback) {
            return $this->getTranslation($this->getDefaultLocale());
        }

        return null;
    }

    public function addField(FormField $field): self
    {
        $this->fields[] = $field;

        return $this;
    }

    public function removeField(FormField $field): self
    {
        $this->fields->removeElement($field);

        return $this;
    }

    /**
     * @return Collection<int, FormField>
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return FormField[]
     */
    public function getFieldsByType(string $type): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            if ($field->getType() === $type) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    public function getField(?string $key): ?FormField
    {
        foreach ($this->fields as $field) {
            if ($field->getKey() == $key) {
                return $field;
            }
        }

        return null;
    }

    public function getFieldType(string $key): ?string
    {
        $field = $this->getField($key);

        if (!$field) {
            return null;
        }

        return $field->getType();
    }

    /**
     * Get fields not in array.
     *
     * @param string[] $keys
     *
     * @return FormField[]
     */
    public function getFieldsNotInArray(array $keys): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            if (!\in_array($field->getKey(), $keys)) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    /**
     * Return a localized array of the object.
     *
     * @return mixed[]
     */
    public function serializeForLocale(string $locale, ?Dynamic $dynamic = null): array
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $fieldTranslation = $field->getTranslation($locale, false, true);
            $value = null;

            if ($dynamic) {
                $value = $dynamic->getField($field->getKey());
            }

            $fields[$field->getOrder()] = [
                'key' => $field->getKey(),
                'type' => $field->getType(),
                'title' => $fieldTranslation->getTitle(),
                'options' => $fieldTranslation->getOptions(),
                'defaultValue' => $fieldTranslation->getDefaultValue(),
                'placeholder' => $fieldTranslation->getPlaceholder(),
                'shortTitle' => $fieldTranslation->getShortTitle(),
                'value' => $value,
            ];

            \ksort($fields);
        }

        $translation = $this->getTranslation($locale, false, true);

        return [
            'id' => $dynamic ? $dynamic->getId() : null,
            'formId' => $this->getId(),
            'title' => $translation->getTitle(),
            'subject' => $translation->getSubject(),
            'mailText' => $translation->getMailText(),
            'submitLabel' => $translation->getSubmitLabel(),
            'successText' => $translation->getSuccessText(),
            'fromEmail' => $translation->getFromEmail(),
            'fromName' => $translation->getFromName(),
            'toEmail' => $translation->getToEmail(),
            'toName' => $translation->getToName(),
            'fields' => $fields,
            'created' => $dynamic ? $dynamic->getCreated() : null,
        ];
    }
}
