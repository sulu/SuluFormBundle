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

use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;

/**
 * Trait for handling multi choice form types.
 */
trait MultiChoiceTrait
{
    /**
     * Returns options for multichoice form type like select, multiple select, radio or checkboxes.
     *
     * @param FormFieldTranslation $translation
     * @param array $options
     *
     * @return array
     */
    private function getChoiceOptions(
        FormFieldTranslation $translation,
        $options
    ) {
        if (isset($options['attr']['placeholder'])) {
            $options['placeholder'] = $options['attr']['placeholder'];
            unset($options['attr']['placeholder']);
        }

        // Choices.
        $choices = preg_split('/\r\n|\r|\n/', $translation->getOption('choices'), -1, PREG_SPLIT_NO_EMPTY);
        $options['choices_as_values'] = true;
        $options['choices'] = array_combine($choices, $choices);

        return $options;
    }

    /**
     * Returns default options for multichoice form type.
     *
     * @param string $value
     *
     * @return string[]
     */
    private function getDefaultOptions($value)
    {
        return preg_split('/\r\n|\r|\n/', $value, -1, PREG_SPLIT_NO_EMPTY);
    }
}
