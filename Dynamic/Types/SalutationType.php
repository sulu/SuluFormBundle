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
use Symfony\Component\Translation\TranslatorInterface;

/**
 * The Salutation form field type.
 */
class SalutationType implements FormFieldTypeInterface
{
    use SimpleTypeTrait;

    private $translator;

    public function __construct(TranslatorInterface $translator){
        $this->translator = $translator;
    }
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.salutation',
            'SuluFormBundle/Resources/config/form-fields/default_field.xml'
        );
    }

    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $options['expanded'] = false;
        $options['multiple'] = false;
        $options['choices'] = $this->getChoices($locale);
        $type = ChoiceType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function getChoices($locale)
    {
        return [
            $this->translator->trans('sulu_form.salutation_mr', [], 'admin', $locale) => 'mr',
            $this->translator->trans('sulu_form.salutation_ms', [], 'admin', $locale) => 'ms',
        ];
    }
}
