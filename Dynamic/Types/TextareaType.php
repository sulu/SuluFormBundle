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
use Symfony\Component\Form\Extension\Core\Type\TextareaType as TypeTextareaType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Textarea form field type.
 */
class TextareaType implements FormFieldTypeInterface
{
    use SimpleTypeTrait;

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.textarea',
            'SuluFormBundle:forms:fields/types/textarea.html.twig',
            [],
            'basic'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $type = TypeTextareaType::class;
        $builder->add($field->getKey(), $type, $options);
    }
}
