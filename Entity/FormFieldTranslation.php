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

/**
 * Form field translation entity.
 */
class FormFieldTranslation
{
    /**
     * @var null|string
     */
    private $title;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var null|int
     */
    private $id;

    /**
     * @var FormField
     */
    private $field;

    /**
     * @var null|string
     */
    private $placeholder;

    /**
     * @var null|string
     */
    private $defaultValue;

    /**
     * @var null|string
     */
    private $shortTitle;

    /**
     * @var string|null
     */
    private $options;

    public function setTitle(?string $title): self
    {
        if ($title) {
            // this is a replacement for enterMode br which does not longer exist in ckeditor 5
            // see also https://github.com/sulu/sulu/issues/5214
            $title = \str_replace(
                ['</p><p>', '<p>', '</p>'],
                ['<br/><br/>', '', ''],
                $title
            );
        }

        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
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

    public function getId(): ?int
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

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed|null $defaultValue
     */
    public function setDefaultValue($defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(?string $shortTitle): self
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

        return \json_decode($this->options, true);
    }

    /**
     * @param mixed[] $options
     */
    public function setOptions(?array $options): self
    {
        if (\is_array($options)) {
            $options = \json_encode($options);
        }

        $this->options = $options;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOption(string $key)
    {
        if (isset($this->getOptions()[$key])) {
            return $this->getOptions()[$key];
        }
    }
}
