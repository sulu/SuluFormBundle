<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

/**
 * Holds form field type configurations for displaying in Sulu.
 */
class FormFieldTypeConfiguration
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * FormFieldTypeConfiguration constructor.
     *
     * @param string $titleTranslationKey
     * @param string $template
     * @param array $attributes
     */
    public function __construct($titleTranslationKey, $template, $attributes = [])
    {
        $this->title = $titleTranslationKey;
        $this->template = $template;
        $this->attributes = $attributes;
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return FormFieldTypeConfiguration
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns template.
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets template.
     *
     * @param string $template
     *
     * @return FormFieldTypeConfiguration
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Returns attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets attributes.
     *
     * @param array $attributes
     *
     * @return FormFieldTypeConfiguration
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}
