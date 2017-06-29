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
interface FormConfigInterface
{
    /**
     * Get form config translations.
     *
     * @return FormConfigTranslationInterface[]
     */
    public function getTranslations();

    /**
     * Get form config translation.
     *
     * @param string $locale
     *
     * @return FormConfigTranslationInterface
     */
    public function getTranslation($locale);

    /**
     * Get file fields.
     *
     * @return string[]
     */
    public function getFileFields();
}
