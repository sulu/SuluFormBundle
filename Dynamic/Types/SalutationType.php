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
 * The Salutation form field type.
 */
class SalutationType implements FormFieldTypeInterface
{
    use SimpleTypeTrait;
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.salutation',
            __DIR__ . '/../../Resources/config/form-fields/default_field.xml'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $options['choice_translation_domain'] = 'messages';
        $options['expanded'] = false;
        $options['multiple'] = false;
        $options['choices'] = $this->getChoices();
        $type = ChoiceType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function getChoices()
    {
        return [
            'sulu_form.salutation_mr' => 'mr',
            'sulu_form.salutation_ms' => 'ms',
        ];
    }
}
