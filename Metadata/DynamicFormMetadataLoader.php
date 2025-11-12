<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Metadata;

use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FieldMetadata;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadata;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadataLoaderInterface;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\Loader\FormXmlLoader;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\SectionMetadata;
use Sulu\Bundle\AdminBundle\Metadata\MetadataInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

class DynamicFormMetadataLoader implements FormMetadataLoaderInterface, CacheWarmerInterface
{
    public function __construct(
        private FormFieldTypePool $formFieldTypePool,
        private PropertiesXmlLoader $propertiesXmlLoader,
        private FormXmlLoader $formXmlLoader,
        private TranslatorInterface $translator,
        private string $cacheDir,
        private bool $debug
    ) {
    }

    /**
     * @param string $cacheDir
     */
    public function warmUp($cacheDir, ?string $buildDir = null): array
    {
        $resource = __DIR__ . '/../Resources/config/forms/form_details.xml';
        $formMetadataCollection = $this->formXmlLoader->load($resource);
        foreach ($formMetadataCollection->getItems() as $locale => $formMetadata) {
            $section = new SectionMetadata('formFields');
            $section->setLabel($this->translator->trans('sulu_form.form_fields', [], 'admin', $locale), $locale);
            $fields = new FieldMetadata('fields');
            $fields->setType('block');

            $types = $this->formFieldTypePool->all();

            $fieldTypeMetaDataCollection = [];
            foreach ($types as $typeKey => $type) {
                $fieldTypeMetaDataCollection[] = $this->loadFieldTypeMetadata($typeKey, $type, $locale);
            }
            Assert::notEmpty($fieldTypeMetaDataCollection, 'No field type metadata loaded');

            \usort($fieldTypeMetaDataCollection, static function(FormMetadata $a, FormMetadata $b) use ($locale): int {
                return \strcmp($a->getTitle($locale), $b->getTitle($locale));
            });

            foreach ($fieldTypeMetaDataCollection as $fieldTypeMetaData) {
                $fields->addType($fieldTypeMetaData);
            }

            $fields->setDefaultType(\current($fields->getTypes())->getName());
            $section->addItem($fields);

            $formItems = $formMetadata->getItems();
            array_splice($formItems, 1, 0, [$section->getName() => $section]);
            $formMetadata->setItems($formItems);

            $configCache = $this->getConfigCache($formMetadata->getKey(), $locale);
            $configCache->write(\serialize($formMetadata), [new FileResource($resource)]);
        }

        return [];
    }

    public function getMetadata(string $key, string $locale, array $metadataOptions = []): ?MetadataInterface
    {
        $configCache = $this->getConfigCache($key, $locale);

        if (!\file_exists($configCache->getPath())) {
            return null;
        }

        if (!$configCache->isFresh()) {
            $this->warmUp($this->cacheDir);
        }

        $form = \unserialize(\file_get_contents($configCache->getPath()));

        return $form;
    }

    private function loadFieldTypeMetadata(string $typeKey, FormFieldTypeInterface $type, string $locale): FormMetadata
    {
        $form = new FormMetadata();
        $configuration = $type->getConfiguration();

        $properties = $this->propertiesXmlLoader->load($configuration->getXmlPath());

        $form->setItems($properties);
        $form->setKey($typeKey);
        $form->setTitle($this->translator->trans($configuration->getTitle(), [], 'admin', $locale), $locale);

        return $form;
    }

    public function isOptional(): bool
    {
        return false;
    }

    private function getConfigCache(string $key, string $locale): ConfigCache
    {
        return new ConfigCache(\sprintf('%s%s%s.%s', $this->cacheDir, \DIRECTORY_SEPARATOR, $key, $locale), $this->debug);
    }
}
