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

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Radio buttons form field type.
 */
class RadioButtonsType implements FormFieldTypeInterface
{
    use ChoiceTrait;
    use SimpleTypeTrait;

    public function getConfiguration(): FormFieldTypeConfiguration
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.radiobuttons',
            __DIR__ . '/../../Resources/config/form-fields/field_choices.xml',
            'complex'
        );
    }

    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        $translation = $field->getTranslation($locale);
        $options['expanded'] = true;
        $options['multiple'] = false;
        $options = $this->getChoiceOptions($translation, $options);
        $type = ChoiceType::class;

        $builder->add($field->getKey(), $type, $options);
    }
}
