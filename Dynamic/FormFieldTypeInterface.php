<?php

namespace Sulu\Bundle\FormBundle\Dynamic;

use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\FormBuilderInterface;

interface FormFieldTypeInterface
{
    /**
     * @return string
     */
    public function getAlias();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param FormBuilderInterface $builder
     * @param FormField $field
     * @param string $locale
     * @param array $options
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options);

    /**
     * @return array
     */
    public function getViewData();
}
