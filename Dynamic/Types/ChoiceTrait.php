<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;

/**
 * Trait for handling multi choice form types.
 */
trait ChoiceTrait
{
    /**
     * @return array<string, string>
     */
    protected function getChoices(FormFieldTranslation $translation): array
    {
        $choicesOption = $translation->getOption('choices');
        $choices = \preg_split('/\r\n|\r|\n/', \is_string($choicesOption) ? $choicesOption : '', -1, \PREG_SPLIT_NO_EMPTY);

        if (false === $choices) {
            return [];
        }

        return \array_combine($choices, $choices);
    }

    /**
     * Returns options for multichoice form type like select, multiple select, radio or checkboxes.
     *
     * @param array<string, mixed> $options
     *
     * @return mixed[]
     */
    private function getChoiceOptions(
        FormFieldTranslation $translation,
        array $options
    ): array {
        if (isset($options['attr'])
            && \is_array($options['attr'])
            && isset($options['attr']['placeholder'])
        ) {
            $options['placeholder'] = $options['attr']['placeholder'];
            unset($options['attr']['placeholder']);
        }

        // Choices.
        $choices = $this->getChoices($translation);
        $options['choices'] = $choices;

        return $options;
    }

    /**
     * Returns default options for multichoice form type.
     *
     * @return string[]
     */
    private function getDefaultOptions(string $value): array
    {
        $options = \preg_split('/\r\n|\r|\n/', $value, -1, \PREG_SPLIT_NO_EMPTY);

        return false === $options ? [] : $options;
    }
}
