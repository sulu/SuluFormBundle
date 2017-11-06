<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
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
    use MultiChoiceTrait;

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.dropdownmultiple',
            'SuluFormBundle:forms:fields/types/dropdownmultiple.html.twig',
            [],
            'complex'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $translation = $field->getTranslation($locale);
        $options = array_merge($options, $this->getChoiceOptions($translation, false, true));
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
