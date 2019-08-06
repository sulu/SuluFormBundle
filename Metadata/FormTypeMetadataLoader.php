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
use Symfony\Component\Config\ConfigCache;
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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(
        FormFieldTypePool $formFieldTypePool,
        PropertiesXmlLoader $propertiesXmlLoader,
        FormXmlLoader $formXmlLoader,
        FormMetadataMapper $formMetadataMapper,
        TranslatorInterface $translator,
        string $cacheDir,
        bool $debug
    ) {
        $this->formFieldTypePool = $formFieldTypePool;
        $this->propertiesXmlLoader = $propertiesXmlLoader;
        $this->formXmlLoader = $formXmlLoader;
        $this->formMetadataMapper = $formMetadataMapper;
        $this->translator = $translator;
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
    }

    public function warmUp($cacheDir)
    {
        $resource = __DIR__ . '/../Resources/config/forms/form_details.xml';
        $formMetadataCollection = $this->formXmlLoader->load($resource);
        foreach ($formMetadataCollection->getItems() as $locale => $formMetadata) {
            $section = new SectionMetadata('formFields');
            $section->setLabel($this->translator->trans('sulu_form.form_fields', [], 'admin', $locale));
            $fields = new FieldMetadata('fields');
            $fields->setType('block');

            $types = $this->formFieldTypePool->all();
            ksort($types);
            foreach ($types as $typeKey => $type) {
                $fields->addType($this->loadFieldTypeMetadata($typeKey, $type, $locale));
            }

            $fields->setDefaultType(current($fields->getTypes())->getName());
            $section->addItem($fields);
            $formItems = $formMetadata->getItems();
            $this->arrayInsertAtPosition($formItems, 1, array($section->getName() => $section));
            $formMetadata->setItems($formItems);
            $configCache = $this->getConfigCache($formMetadata->getKey(), $locale);
            $configCache->write(serialize($formMetadata));
        }
    }

    /**
     * @param string $key
     * @param string $locale
     * @return FormMetadata|null
     */
    public function getMetadata(string $key, string $locale)
    {
        $configCache = $this->getConfigCache($key, $locale);

        if (!$configCache->isFresh()) {
            $this->warmUp($this->cacheDir);
        }

        if (!file_exists($configCache->getPath())) {
            return null;
        }

        $form = unserialize(file_get_contents($configCache->getPath()));

        return $form;
    }

    private function arrayInsertAtPosition(&$array, $pos, $insert)
    {
        $array = array_merge(array_slice($array, 0, $pos), $insert, array_slice($array, $pos));
    }

    private function loadFieldTypeMetadata(string $typeKey, FormFieldTypeInterface $type, string $locale) : FormMetadata
    {
        $form = new FormMetadata();
        $configuration = $type->getConfiguration();
        $properties = $this->propertiesXmlLoader->load($configuration->getXmlPath());
        $this->formMetadataMapper->mapChildren($properties->getProperties(), $form, $locale);

        $form->setName($typeKey);
        $form->setTitle($this->translator->trans($configuration->getTitle(), [], 'admin'));

        return $form;
    }

    public function isOptional()
    {
        return false;
    }

    private function getConfigCache(string $key, string $locale): ConfigCache
    {
        return new ConfigCache(sprintf('%s%s%s.%s', $this->cacheDir, DIRECTORY_SEPARATOR, $key, $locale), $this->debug);
    }
}
