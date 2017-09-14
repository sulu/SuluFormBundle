<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
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
     *
     * @return string
     */
    public function getLocale();

    /**
     * Should the form data be saved.
     *
     * @return bool
     */
    public function getSave();

    /**
     * Get file fields.
     *
     * @return int[]
     */
    public function getFileFields();

    /**
     * Get admin mail configuration.
     *
     * @return MailConfigurationInterface|null
     */
    public function getAdminMailConfiguration();

    /**
     * Get website mail configuration.
     *
     * @return MailConfigurationInterface|null
     */
    public function getWebsiteMailConfiguration();
}
