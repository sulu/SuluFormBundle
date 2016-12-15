<?php

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
     * @param bool $expanded
     * @param bool $multiple
     *
     * @return array
     */
    public function getChoiceOptions(FormFieldTranslation $translation, $expanded = false, $multiple = false)
    {
        $options = [];
        if ($translation) {
            // Placeholder.
            $options['placeholder'] = $translation->getPlaceholder();

            // Choices.
            $choices = preg_split('/\r\n|\r|\n/', $translation->getOption('choices'), -1, PREG_SPLIT_NO_EMPTY);

            $options['choices'] = array_combine($choices, $choices);

            // Type.
            $options['expanded'] = $expanded;
            $options['multiple'] = $multiple;
        }

        return $options;
    }

    /**
     * Returns default options for multichoise form type.
     *
     * @param string $value
     *
     * @return string[]
     */
    public function getDefaultOptions($value)
    {
        return preg_split('/\r\n|\r|\n/', $value, -1, PREG_SPLIT_NO_EMPTY);
    }
}
