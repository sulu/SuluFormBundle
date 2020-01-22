<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Configuration;

/**
 * A form configuration.
 */
interface FormConfigurationInterface
{
    /**
     * Get locale.
     */
    public function getLocale(): string;

    /**
     * Should the form data be saved.
     */
    public function getSave(): bool;

    /**
     * Get file fields.
     *
     * @return mixed[]
     */
    public function getFileFields(): array;

    /**
     * Get admin mail configuration.
     */
    public function getAdminMailConfiguration(): ?MailConfigurationInterface;

    /**
     * Get website mail configuration.
     */
    public function getWebsiteMailConfiguration(): ?MailConfigurationInterface;
}
