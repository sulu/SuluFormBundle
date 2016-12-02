<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Radio buttons form field type.
 */
class RadioButtonsType extends AbstractMultiChoice implements FormFieldTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.radiobuttons',
            'SuluFormBundle:forms:fields/types/radiobuttons.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $translation = $field->getTranslation($locale);
        $options = array_merge($options, $this->getChoiceOptions($translation, true));
        $options['attr']['class'] = 'radio-buttons';
        $type = ChoiceType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * Return the default value.
     *
     * @param FormField $field
     * @param string $locale
     *
     * @return string
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
