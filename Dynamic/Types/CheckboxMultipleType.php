<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Multiple checkbox form field type.
 */
class CheckboxMultipleType implements FormFieldTypeInterface
{
    use MultiChoiceTrait;

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.checkboxmultiple',
            'SuluFormBundle:forms:fields/types/checkboxmultiple.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $translation = $field->getTranslation($locale);
        $options = array_merge($options, $this->getChoiceOptions($translation, true, true));
        $type = ChoiceType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        $value = $field->getTranslation($locale)->getDefaultValue();

        return $this->getDefaultOptions($value);
    }
}
