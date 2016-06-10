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
     * @var integer
     */
    private $id;

    /**
     * @var \L91\Sulu\Bundle\FormBundle\Entity\FormField
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
     * Set title
     *
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set locale
     *
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
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
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
     * Set field
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormField $field
     *
     * @return FormFieldTranslation
     */
    public function setField(\L91\Sulu\Bundle\FormBundle\Entity\FormField $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \L91\Sulu\Bundle\FormBundle\Entity\FormField
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
