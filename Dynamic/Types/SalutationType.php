<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Salutation form field type.
 */
class SalutationType implements FormFieldTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.salutation',
            'SuluFormBundle:forms:fields/types/salutation.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $type = ChoiceType::class;
        $options['choices'] = [
            'mr' => 'sulu_form.salutation_mr',
            'ms' => 'sulu_form.salutation_ms',
        ];
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
