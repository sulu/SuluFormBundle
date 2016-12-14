<?php

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
     * @param FormField $field
     * @param string $locale
     *
     * @return mixed
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
