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

use Sulu\Bundle\AdminBundle\FormMetadata\FormMetadata;
use Sulu\Bundle\AdminBundle\FormMetadata\FormXmlLoader;
use Sulu\Bundle\AdminBundle\Metadata\PropertiesMetadata\PropertiesXmlLoader;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadataLoaderInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Component\Content\Metadata\BlockMetadata;
use Sulu\Component\Content\Metadata\ComponentMetadata;
use Sulu\Component\Content\Metadata\PropertiesMetadata;
use Sulu\Component\Content\Metadata\SectionMetadata;

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

    public function __construct(
        FormFieldTypePool $formFieldTypePool,
        PropertiesXmlLoader $propertiesXmlLoader,
        FormXmlLoader $formXmlLoader
    ) {
        $this->formFieldTypePool = $formFieldTypePool;
        $this->propertiesXmlLoader = $propertiesXmlLoader;
        $this->formXmlLoader = $formXmlLoader;
    }

    public function load() : array
    {
        $formMetadata = $this->getMetadata();
        $formKey = $formMetadata->getKey();
        $formsMetadata = [];
        $formsMetadata[$formKey][] = $this->getMetadata();
        return $formsMetadata;
    }

    private function getMetadata() : FormMetadata
    {
        $form = $this->formXmlLoader->load(__DIR__ . '/../Resources/config/forms/form_details.xml');
        $section = new SectionMetadata('formFields');
        $block = new BlockMetadata('fields');

        $types = $this->formFieldTypePool->all();
        foreach ($types as $typeKey => $type) {
            $component = new ComponentMetadata();
            $component->setName($typeKey);

            $fieldTypeProperties = $this->loadFieldTypeMetadata($type);
            foreach ($fieldTypeProperties->getChildren() as $children) {
                $component->addChild($children);
            }

            $block->addComponent($component);
        }

        $defaultComponent = current($block->getComponents());
        $block->defaultComponentName = $defaultComponent->getName();
        $block->setType('block');
        $section->addChild($block);
        $form = $this->addFormFieldsSection($form, $section);
        $form->burnProperties();

        return $form;
    }

    private function addFormFieldsSection(FormMetadata $form, SectionMetadata $section) : FormMetadata
    {
        $children = $form->getChildren();
        array_splice($children, 1, 0, array($section));
        $form->setChildren($children);

        return $form;
    }

    private function loadFieldTypeMetadata(FormFieldTypeInterface $type) : PropertiesMetadata
    {
        $configuration = $type->getConfiguration();

        return $this->propertiesXmlLoader->load($configuration->getXmlPath());
    }
}
