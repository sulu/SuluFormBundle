<?php

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
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.date',
            'SuluFormBundle:forms:fields/types/date.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
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

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        $value = $field->getTranslation($locale)->getDefaultValue();

        return new \DateTime($value);
    }
}
