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

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setField(FormField $field): FormFieldTranslation
    {
        $this->field = $field;

        return $this;
    }

    public function getField(): FormField
    {
        return $this->field;
    }

    /**
     * @return string|bool
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getDefaultValue(): string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getShortTitle(): string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(string $shortTitle): self
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getOptions(): array
    {
        if (!$this->options) {
            return [];
        }

        return json_decode($this->options, true);
    }

    /**
     * @param mixed[] $options
     */
    public function setOptions(array $options): self
    {
        if (is_array($options)) {
            $options = json_encode($options);
        }

        $this->options = $options;

        return $this;
    }

    public function getOption(string $key): ?string
    {
        if (isset($this->getOptions()[$key])) {
            return $this->getOptions()[$key];
        }
    }
}
