<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Function form field type.
 */
class FunctionType implements FormFieldTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.function',
            'SuluFormBundle:forms:fields/types/function.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $type = TypeTextType::class;
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
