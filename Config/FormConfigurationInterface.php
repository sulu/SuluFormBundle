<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Config;

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
