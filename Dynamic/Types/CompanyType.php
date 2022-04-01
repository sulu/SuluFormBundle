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
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Company form field type.
 */
class CompanyType implements FormFieldTypeInterface
{
    public function getConfiguration(): FormFieldTypeConfiguration
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.company',
            __DIR__ . '/../../Resources/config/form-fields/field_example_default.xml'
        );
    }

    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        $type = TypeTextType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    public function getDefaultValue(FormField $field, string $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
