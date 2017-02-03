<?php

namespace Sulu\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Form
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var \Doctrine\Common\Collections\Collection|FormTranslation[]
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection|FormField[]
     */
    private $fields;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->fields = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get default locale.
     *
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * Set default locale.
     *
     * @param $defaultLocale
     *
     * @return $this
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;

        return $this;
    }

    /**
     * Add translation.
     *
     * @param FormTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(FormTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation.
     *
     * @param FormTranslation $translation
     *
     * @return $this
     */
    public function removeTranslation(FormTranslation $translation)
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    /**
     * Get translations.
     *
     * @return \Doctrine\Common\Collections\Collection|FormTranslation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Get translation.
     *
     * @param string $locale
     * @param bool $create
     * @param bool $fallback
     *
     * @return FormTranslation|null
     */
    public function getTranslation($locale, $create = false, $fallback = false)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }

        if ($create) {
            $translation = new FormTranslation();
            $translation->setLocale($locale);

            return $translation;
        }

        if ($fallback) {
            return $this->getTranslation($this->getDefaultLocale());
        }

        return;
    }

    /**
     * Add field.
     *
     * @param FormField $field
     *
     * @return Form
     */
    public function addField(FormField $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field.
     *
     * @param FormField $field
     *
     * @return $this
     */
    public function removeField(FormField $field)
    {
        $this->fields->removeElement($field);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|FormField[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Get fields by type.
     *
     * @return \Doctrine\Common\Collections\Collection|FormField[]
     */
    public function getFieldsByType($type)
    {
        $fields = [];

        foreach ($this->fields as $field) {
            if ($field->getType() === $type) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    /**
     * Get field by key.
     *
     * @param string $key
     *
     * @return FormField|null
     */
    public function getField($key)
    {
        foreach ($this->fields as $field) {
            if ($field->getKey() == $key) {
                return $field;
            }
        }
    }

    /**
     * Get field type by key.
     *
     * @param string $key
     *
     * @return string|void
     */
    public function getFieldType($key)
    {
        $field = $this->getField($key);

        if (!$field) {
            return;
        }

        return $field->getType();
    }

    /**
     * Get fields not in array.
     *
     * @param $keys
     *
     * @return FormField[]
     */
    public function getFieldsNotInArray($keys)
    {
        $fields = [];

        foreach ($this->fields as $field) {
            if (!in_array($field->getKey(), $keys)) {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    /**
     * Return a localized array of the object.
     *
     * @param $locale
     * @param Dynamic $dynamic
     *
     * @return array
     */
    public function serializeForLocale($locale, Dynamic $dynamic = null)
    {
        $fields = [];

        foreach ($this->fields as $field) {
            $fieldTranslation = $field->getTranslation($locale, false, true);
            $value = null;

            if ($dynamic) {
                $value = $dynamic->{$field->getKey()};
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

            ksort($fields);
        }

        $translation = $this->getTranslation($locale, false, true);

        return [
            'id' => $dynamic ? $dynamic->id : null,
            'formId' => $this->getId(),
            'title' => $translation->getTitle(),
            'subject' => $translation->getSubject(),
            'mailText' => $translation->getMailText(),
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
