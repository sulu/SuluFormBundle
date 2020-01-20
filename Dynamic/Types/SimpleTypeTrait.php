<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Entity\FormField;

/**
 * Trait for handling multi choice form types.
 */
trait SimpleTypeTrait
{
    /**
     * Return the default value.
     *
     * @return mixed
     */
    public function getDefaultValue(FormField $field, string $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
