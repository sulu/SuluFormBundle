<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

class Form
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var FormTranslation
     */
    private $defaultTranslation;

    /**
     * @var \Doctrine\Common\Collections\Collection|FormTranslation
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection|FormField
     */
    private $fields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set defaultTranslation
     *
     * @param FormTranslation $defaultTranslation
     *
     * @return Form
     */
    public function setDefaultTranslation(FormTranslation $defaultTranslation = null)
    {
        $this->defaultTranslation = $defaultTranslation;

        return $this;
    }

    /**
     * Get defaultTranslation
     *
     * @return FormTranslation
     */
    public function getDefaultTranslation()
    {
        return $this->defaultTranslation;
    }

    /**
     * Add translation
     *
     * @param FormTranslation $translation
     *
     * @return Form
     */
    public function addTranslation(FormTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param FormTranslation $translation
     */
    public function removeTranslation(FormTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection|FormTranslation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param string $locale
     * @param bool $create
     *
     * @return FormTranslation
     */
    public function getTranslation($locale, $create = false)
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
    }

    /**
     * Add field
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
     * Remove field
     *
     * @param FormField $field
     */
    public function removeField(FormField $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection|FormField[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $key
     * @param bool $create
     *
     * @return FormField
     */
    public function getField($key, $create = false)
    {
        foreach ($this->fields as $field) {
            if ($field->getKey() == $key) {
                return $field;
            }
        }

        if ($create) {
            $field = new FormField();
            $field->setKey($key);

            return $field;
        }
    }
}
