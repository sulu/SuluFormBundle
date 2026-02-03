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
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\ItemMetadata;
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

/**
 * @internal no backwards compatibility promise is given for this class it can be removed at any time
 */
class DynamicFormMetadataLoader implements FormMetadataLoaderInterface, CacheWarmerInterface
{
    /**
     * @param array<string> $locales
     */
    public function __construct(
        private FormFieldTypePool $formFieldTypePool,
        private PropertiesXmlLoader $propertiesXmlLoader,
        private FormXmlLoader $formXmlLoader,
        private TranslatorInterface $translator,
        private string $cacheDir,
        private array $locales,
        private bool $debug
    ) {
        if ([] === $this->locales) {
            $this->locales = ['de', 'en'];
        }
    }

    /**
     * @param string $cacheDir
     */
    public function warmUp($cacheDir, ?string $buildDir = null): array
    {
        $resource = __DIR__ . '/../Resources/config/forms/form_details.xml';
        $formMetadata = $this->formXmlLoader->load($resource);
        $section = new SectionMetadata('formFields');
        foreach ($this->locales as $locale) {
            $section->setLabel($this->translator->trans('sulu_form.form_fields', [], 'admin', $locale), $locale);
        }
        $fields = new FieldMetadata('fields');
        $fields->setType('block');

        $types = $this->formFieldTypePool->all();

        $fieldTypeMetaDataCollection = [];
        foreach ($types as $typeKey => $type) {
            $fieldTypeMetaDataCollection[] = $this->loadFieldTypeMetadata($typeKey, $type);
        }
        Assert::notEmpty($fieldTypeMetaDataCollection, 'No field type metadata loaded');

        foreach ($fieldTypeMetaDataCollection as $fieldTypeMetaData) {
            $fields->addType($fieldTypeMetaData);
        }

        $fields->setDefaultType(\current($fields->getTypes())->getName());
        $section->addItem($fields);

        $formItems = $formMetadata->getItems();
        $formItems =
            \array_slice($formItems, 0, 1, true) + // Slicing out the title
            [$section->getName() => $section] + // Inserting the custom form fields
            \array_slice($formItems, 1, \count($formItems) - 1, true) // Adding the rest of the fields
        ;
        $formMetadata->setItems($formItems);

        $configCache = $this->getConfigCache($formMetadata->getKey());
        $configCache->write(\serialize($formMetadata), [new FileResource($resource)]);

        return [];
    }

    public function getMetadata(string $key, string $locale, array $metadataOptions = []): ?MetadataInterface
    {
        if ('form_details' !== $key) {
            return null;
        }

        $configCache = $this->getConfigCache($key);

        if (!\file_exists($configCache->getPath()) || !$configCache->isFresh()) {
            $this->warmUp($this->cacheDir);
        }

        $form = \unserialize(\file_get_contents($configCache->getPath()));

        return $form;
    }

    private function loadFieldTypeMetadata(string $typeKey, FormFieldTypeInterface $type): FormMetadata
    {
        $form = new FormMetadata();
        $form->setKey($typeKey);

        $configuration = $type->getConfiguration();

        /** @var array<ItemMetadata> $properties */
        $properties = $this->propertiesXmlLoader->load($configuration->getXmlPath());

        foreach ($properties as $property) {
            $form->addItem($property);
        }

        foreach ($this->locales as $locale) {
            $form->setTitle($this->translator->trans($configuration->getTitle(), [], 'admin', $locale), $locale);
        }

        return $form;
    }

    public function isOptional(): bool
    {
        return false;
    }

    private function getConfigCache(string $key): ConfigCache
    {
        return new ConfigCache(\sprintf('%s%s%s', $this->cacheDir, \DIRECTORY_SEPARATOR, $key), $this->debug);
    }
}
