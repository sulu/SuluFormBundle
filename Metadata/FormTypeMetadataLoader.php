<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Metadata;

use Sulu\Bundle\AdminBundle\FormMetadata\FormMetadataMapper;
use Sulu\Bundle\AdminBundle\FormMetadata\FormXmlLoader;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FieldMetadata;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadata;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadataLoaderInterface;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\SectionMetadata;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\TranslatorInterface;

class FormTypeMetadataLoader implements FormMetadataLoaderInterface
{
    /**
     * @var FormFieldTypePool
     */
    private $formFieldTypePool;

    /**
     * @var PropertiesXmlLoader
     */
    private $propertiesXmlLoader;

    /**
     * @var FormXmlLoader
     */
    private $formXmlLoader;

    /**
     * @var FormMetadataMapper
     */
    private $formMetadataMapper;

    /**
     * @var string[]
     */
    private $locales;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
        FormFieldTypePool $formFieldTypePool,
        PropertiesXmlLoader $propertiesXmlLoader,
        FormXmlLoader $formXmlLoader,
        FormMetadataMapper $formMetadataMapper,
        array $locales,
        TranslatorInterface $translator
    ) {
        $this->formFieldTypePool = $formFieldTypePool;
        $this->propertiesXmlLoader = $propertiesXmlLoader;
        $this->formXmlLoader = $formXmlLoader;
        $this->formMetadataMapper = $formMetadataMapper;
        $this->locales = $locales;
        $this->translator = $translator;
    }

    public function load() : array
    {
        $formMetadata = $this->getMetadata();
        $formKey = $formMetadata->getKey();
        $formsMetadata = [];
        $formsMetadata[$formKey][] = $formMetadata;
        return $formsMetadata;
    }

    private function getMetadata() : FormMetadata
    {
        $resource = __DIR__ . '/../Resources/config/forms/form_details.xml';
        $form = $this->formXmlLoader->load($resource);
        $section = new SectionMetadata('formFields');
        $section->setLabel($this->translator->trans('sulu_form.form_fields', [], 'admin'));
        $fields = new FieldMetadata('fields');
        $fields->setType('block');

        $types = $this->formFieldTypePool->all();
        ksort($types);
        foreach ($types as $typeKey => $type) {
            $fields->addType($this->loadFieldTypeMetadata($typeKey, $type));
        }

        $fields->setDefaultType(current($fields->getTypes())->getName());
        $section->addItem($fields);
        $formItems = $form->getItems();
        $this->arrayInsertAtPosition($formItems, 1, array($section->getName() => $section));
        $form->setItems($formItems);

        foreach ($this->locales as $locale) {
            $configCache = $this->formMetadataMapper->getConfigCache($form->getKey(), $locale);
            $configCache->write(
                serialize($form),
                [new FileResource($resource)]
            );
        }

        return $form;
    }

    private function arrayInsertAtPosition(&$array, $pos, $insert)
    {
        $array = array_merge(array_slice($array, 0, $pos), $insert, array_slice($array, $pos));
    }

    private function loadFieldTypeMetadata(string $typeKey, FormFieldTypeInterface $type) : FormMetadata
    {
        $form = new FormMetadata();
        $configuration = $type->getConfiguration();
        $properties = $this->propertiesXmlLoader->load($configuration->getXmlPath());
        foreach ($this->locales as $locale) {
            $this->formMetadataMapper->mapChildren($properties->getProperties(), $form, $locale);
        }

        $form->setName($typeKey);
        $form->setTitle($this->translator->trans($configuration->getTitle(), [], 'admin'));

        return $form;
    }
}
