<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

class FormFieldTranslation
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var int
     */
    private $id;

    /**
     * @var FormField
     */
    private $field;

    /**
     * @var string
     */
    private $placeholder;

    /**
     * @var string
     */
    private $defaultValue;

    /**
     * @param string $title
     *
     * @return FormFieldTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $locale
     *
     * @return FormFieldTranslation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param FormField $field
     *
     * @return FormFieldTranslation
     */
    public function setField(FormField $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return FormField
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param string $defaultValue
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }
}
