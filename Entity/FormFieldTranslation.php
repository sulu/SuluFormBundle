<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Entity;

/**
 * Form field translation entity.
 */
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
     * @var string
     */
    private $shortTitle;

    /**
     * @var string
     */
    private $options;

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
        return $this->placeholder ?: false;
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

    /**
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * @param string $shortTitle
     *
     * @return FormFieldTranslation
     */
    public function setShortTitle($shortTitle)
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        if (!$this->options) {
            return [];
        }

        return json_decode($this->options, true);
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions($options)
    {
        if (is_array($options)) {
            $options = json_encode($options);
        }

        $this->options = $options;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getOption($key)
    {
        if (isset($this->getOptions()[$key])) {
            return $this->getOptions()[$key];
        }
    }
}
