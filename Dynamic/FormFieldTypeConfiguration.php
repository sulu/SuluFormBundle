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
    private $xmlPath;

    /**
     * @var string
     */
    private $group;

    public function __construct(string $titleTranslationKey, string $xmlPath, string $group = '')
    {
        $this->title = $titleTranslationKey;
        $this->xmlPath = $xmlPath;
        $this->group = $group;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns template.
     */
    public function getXmlPath(): string
    {
        return $this->xmlPath;
    }

    /**
     * Sets template.
     *
     * @return FormFieldTypeConfiguration
     */
    public function setXmlPath(string $xmlPath): self
    {
        $this->xmlPath = $xmlPath;

        return $this;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }
}
