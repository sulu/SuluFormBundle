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
 * Form field entity.
 */
class FormField
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $width = 'full';

    /**
     * @var bool
     */
    private $required = false;

    /**
     * @var null|int
     */
    private $id;

    /**
     * @var int
     */
    private $order;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var Collection<int, FormFieldTranslation>
     */
    private $translations;

    /**
     * @var Form
     */
    private $form;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
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

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setWidth(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getRequired(): bool
    {
        return $this->required;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return FormFieldTranslation|null
     */
    public function getTranslation(string $locale, bool $create = false, bool $fallback = false)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }

        if ($create) {
            $translation = new FormFieldTranslation();
            $translation->setLocale($locale);
            $this->addTranslation($translation);
            $translation->setField($this);

            return $translation;
        }

        if ($fallback) {
            return $this->getTranslation($this->getDefaultLocale());
        }

        return null;
    }

    public function addTranslation(FormFieldTranslation $translation): self
    {
        $this->translations[] = $translation;

        return $this;
    }

    public function removeTranslation(FormFieldTranslation $translation): void
    {
        $this->translations->removeElement($translation);
    }

    /**
     * @return Collection<int, FormFieldTranslation>
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function getForm(): Form
    {
        return $this->form;
    }
}
