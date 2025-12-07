<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
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
    public function __construct(
        private string $title,
        private string $xmlPath,
        private string $group = '',
    ) {
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

    public function getXmlPath(): string
    {
        return $this->xmlPath;
    }

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
