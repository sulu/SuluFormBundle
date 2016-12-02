<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Recaptcha form field type.
 */
class RecaptchaType implements FormFieldTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.recaptcha',
            'SuluFormBundle:forms:fields/types/recaptcha.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        // Use in this way the recaptcha bundle could maybe not exists.
        $options['mapped'] = false;
        $options['constraints'][] = new \EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue();
        $options['attr']['options'] = [
            'theme' => 'light',
            'type' => 'image',
            'size' => 'normal',
        ];
        $builder->add($field->getKey(), \EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType::class, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
