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
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Date form field type.
 */
class DateType implements FormFieldTypeInterface
{
    public function getConfiguration(): FormFieldTypeConfiguration
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.date',
            __DIR__ . '/../../Resources/config/form-fields/field_date.xml',
            'basic'
        );
    }

    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        $type = TypeDateType::class;
        $translation = $field->getTranslation($locale);
        if ($translation && $translation->getOption('birthday')) {
            $type = BirthdayType::class;
        }
        $options['format'] = \IntlDateFormatter::LONG;
        $options['input'] = 'string';
        $builder->add($field->getKey(), $type, $options);
    }

    public function getDefaultValue(FormField $field, string $locale)
    {
        $value = $field->getTranslation($locale)->getDefaultValue();

        return $value;
    }
}
