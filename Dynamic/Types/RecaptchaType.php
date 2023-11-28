<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Recaptcha form field type.
 */
class RecaptchaType implements FormFieldTypeInterface
{
    use SimpleTypeTrait;

    private ParameterBagInterface $params;

    public function __construct(
        ParameterBagInterface $params
    ) {
        $this->params = $params;
    }

    public function getConfiguration(): FormFieldTypeConfiguration
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.recaptcha',
            __DIR__ . '/../../Resources/config/form-fields/field_recaptcha.xml',
            'special'
        );
    }

    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        // Use in this way the recaptcha bundle could maybe not exists.
        $constraint = new \EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue();
        $type = \EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType::class;

        if ($this->params->has('ewz_recaptcha.version')
            && 3 == $this->params->get('ewz_recaptcha.version')
        ) {
            $constraint = new \EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3();
            $type = \EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type::class;
        }

        $options['mapped'] = false;
        $options['constraints'] = $constraint;
        $options['attr']['options'] = [
            'theme' => 'light',
            'type' => 'image',
            'size' => 'normal',
        ];

        $builder->add($field->getKey(), $type, $options);
    }
}
