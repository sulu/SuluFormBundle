<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class Text implements FormFieldTypeInterface
{
    const TYPE_ALIAS = 'text';

    /**
     * @return string
     */
    public function getAlias()
    {
        return self::TYPE_ALIAS;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'SuluFormBundle:forms:fields/types/text.html.twig';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param FormField $field
     * @param string $locale
     * @param array $options
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $name = $field->getKey();
        $type = TextType::class;

        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * @return array
     */
    public function getViewData()
    {
        return [];
    }
}
