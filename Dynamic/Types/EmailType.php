<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\EmailType as TypeEmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

/**
 * The Email form field type.
 */
class EmailType implements FormFieldTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.email',
            'SuluFormBundle:forms:fields/types/email.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $options['constraints'][] = new EmailConstraint();
        $type = TypeEmailType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }
}
