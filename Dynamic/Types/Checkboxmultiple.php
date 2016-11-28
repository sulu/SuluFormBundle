<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Multiple checkbox form type.
 */
class Checkboxmultiple extends MultiChoisAbstract implements FormFieldTypeInterface
{
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
        $options = array_merge($options, $this->getChoiseOptions($translation, true, true));
        $type = CheckboxType::class;
        $builder->add($field->getKey(), $type, $options);
    }
}
