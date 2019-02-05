<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form\Type;

use Sulu\Bundle\FormBundle\Dynamic\Checksum;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DynamicFormType extends AbstractType
{
    /**
     * @var FormFieldTypePool
     */
    private $typePool;

    /**
     * @var Checksum
     */
    private $checksum;

    /**
     * DynamicFormType constructor.
     *
     * @param FormFieldTypePool $typePool
     * @param Checksum $checksum
     */
    public function __construct(
        FormFieldTypePool $typePool,
        Checksum $checksum
    ) {
        $this->typePool = $typePool;
        $this->checksum = $checksum;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Form $formEntity */
        $formEntity = $options['formEntity'];
        $locale = $options['locale'];
        $type = $options['type'];
        $typeId = $options['typeId'];
        $name = $options['name'];

        if (!$translation = $formEntity->getTranslation($locale)) {
            throw new \Exception(
                sprintf('The form with the ID "%s" does not exist for the locale "%s"!', $formEntity->getId(), $locale)
            );
        }

        $currentWidthValue = 0;
        $fields = $formEntity->getFields();

        foreach ($fields as $key => $field) {
            $fieldTranslation = $field->getTranslation($locale);

            if (!$fieldTranslation) {
                continue;
            }

            $options = [
                'constraints' => [],
                'attr' => [],
                'translation_domain' => false,
            ];

            $title = $fieldTranslation->getTitle();
            $placeholder = $fieldTranslation->getPlaceholder();
            $width = $field->getWidth() ?: 'full';

            $nextField = null;
            $nextWidth = 'full';
            if (isset($fields[$key + 1])) {
                $nextWidth = $fields[$key + 1]->getWidth();
            }

            $lastWidth = $this->getLastWidth($currentWidthValue, $width, $nextWidth);

            $options['label'] = $title ?: false;
            $options['required'] = $field->getRequired();
            $options['attr']['width'] = $width;
            $options['attr']['widthNumber'] = $this->getItemWidthNumber($width);
            $options['attr']['lastWidth'] = $lastWidth;

            if ($placeholder) {
                $options['attr']['placeholder'] = $placeholder;
            }

            // required
            if ($field->getRequired()) {
                $options['constraints'][] = new NotBlank();
            }

            $this->typePool->get($field->getType())->build($builder, $field, $locale, $options);
        }

        // Add hidden locale. (de, en, ...)
        $builder->add('locale', HiddenType::class, [
            'data' => $locale,
            'mapped' => false,
        ]);

        // Add hidden type field. (page, article, event, blog, ...)
        $builder->add('type', HiddenType::class, [
            'data' => $type,
            'mapped' => false,
        ]);

        // Add hidden typeId field. (UUID, Database id, ...)
        $builder->add('typeId', HiddenType::class, [
            'data' => $typeId,
            'mapped' => false,
        ]);

        // Add hidden formId. (id, uuid,…)
        $builder->add('formId', HiddenType::class, [
            'data' => $formEntity->getId(),
            'mapped' => false,
        ]);

        // Add hidden formName field. (Name of "form_select"-content-type.)
        $builder->add('formName', HiddenType::class, [
            'data' => $name,
            'mapped' => false,
        ]);

        // Add hidden formName field. (Name of "form_select"-content-type.)
        $checksum = $this->checksum->get($type, $typeId, $formEntity->getId(), $name);
        $builder->add('checksum', HiddenType::class, [
            'data' => $checksum,
            'mapped' => false,
        ]);

        // Add submit button.
        $builder->add(
            'submit',
            SubmitType::class,
            [
                'label' => $translation->getSubmitLabel(),
                'translation_domain' => false,
                'attr' => [
                    'width' => 'full',
                    'widthNumber' => $this->getItemWidthNumber('full'),
                    'lastWidth' => true,
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaults = [];

        $defaults['csrf_protection'] = true;
        $defaults['csrf_field_name'] = '_token';
        $defaults['data_class'] = Dynamic::class;

        $resolver->setDefaults($defaults);

        $resolver->setRequired('locale');
        $resolver->setRequired('type');
        $resolver->setRequired('typeId');
        $resolver->setRequired('name');
        $resolver->setRequired('formEntity');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dynamic';
    }

    /**
     * Get item width number.
     *
     * @param string $width
     *
     * @return int
     */
    private function getItemWidthNumber($width)
    {
        switch ($width) {
            case 'one-sixth':
                $itemWidth = 2;
                break;
            case 'five-sixths':
                $itemWidth = 10;
                break;
            case 'one-quarter':
                $itemWidth = 3;
                break;
            case 'three-quarters':
                $itemWidth = 9;
                break;
            case 'one-third':
                $itemWidth = 4;
                break;
            case 'two-thirds':
                $itemWidth = 8;
                break;
            case 'half':
                $itemWidth = 6;
                break;
            case 'full':
                $itemWidth = 12;
                break;
            default:
                $itemWidth = 12;
        }

        return $itemWidth;
    }

    /**
     * Get last width.
     *
     * @param int $currentWidthValue
     * @param string $width
     * @param string $nextWidth
     *
     * @return bool
     */
    private function getLastWidth(&$currentWidthValue, $width, $nextWidth)
    {
        $widthNumber = $this->getItemWidthNumber($width);
        $nextWidthNumber = $this->getItemWidthNumber($nextWidth);

        $currentWidthValue += $widthNumber;

        if (0 == $currentWidthValue % 12) {
            return true;
        }

        // if next item has no space in current row the current item is last
        if (($currentWidthValue % 12) + $nextWidthNumber > 12) {
            $currentWidthValue += 12 - $currentWidthValue % 12;

            return true;
        }

        return false;
    }
}
