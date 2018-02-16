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
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Salutation form field type.
 */
class SalutationType extends DropdownType implements FormFieldTypeInterface
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

    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $options['translation_domain'] = 'messages';

        parent::build($builder, $field, $locale, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function getChoices(FormFieldTranslation $translation)
    {
        return [
            'sulu_form.salutation_mr' => 'mr',
            'sulu_form.salutation_ms' => 'ms',
        ];
    }
}
