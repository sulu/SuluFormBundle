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
 * The Multiple Dropdown form field type.
 */
class DropdownMultiple implements FormFieldTypeInterface
{
    use ChoiceTrait;

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(): FormFieldTypeConfiguration
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.dropdownmultiple',
            __DIR__ . '/../../Resources/config/form-fields/default_field_extended.xml',
            'complex'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        $translation = $field->getTranslation($locale);
        $options['expanded'] = false;
        $options['multiple'] = true;
        $options = $this->getChoiceOptions($translation, $options);
        $type = ChoiceType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, string $locale)
    {
        $value = $field->getTranslation($locale)->getDefaultValue();

        return $this->getDefaultOptions($value);
    }
}
