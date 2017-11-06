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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Free text form field type.
 */
class FreeTextType implements FormFieldTypeInterface
{
    use SimpleTypeTrait;

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.freetext',
            'SuluFormBundle:forms:fields/types/freetext.html.twig',
            [],
            'additional'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options = [])
    {
        $options['mapped'] = false;
        $options['attr']['type'] = $field->getType();

        $type = HiddenType::class;
        $builder->add($field->getKey(), $type, $options);
    }
}
