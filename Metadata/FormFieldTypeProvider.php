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
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadataLoaderInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Component\Content\Metadata\BlockMetadata;
use Sulu\Component\Content\Metadata\SectionMetadata;
use Sulu\Component\Content\Metadata\ComponentMetadata;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;


class FormFieldTypeProvider implements FormMetadataLoaderInterface
{
    private $formFieldTypePool;
    private $propertiesXmlLoader;

    public function __construct(
        FormFieldTypePool $formFieldTypePool,
        PropertiesXmlLoader $propertiesXmlLoader
    )
    {
        $this->formFieldTypePool = $formFieldTypePool;
        $this->propertiesXmlLoader = $propertiesXmlLoader;
    }

    // not used at the moment
    public function loadAllFieldTypes() : array
    {
       $types = $this->formFieldTypePool->all();
       $propertiesMetadata = array();
       foreach ($types as $type) {
           $configuration = $type->getConfiguration();
           array_push($propertiesMetadata, $this->propertiesXmlLoader->load($configuration->getXmlPath()));
       }
       return $propertiesMetadata;
    }

    public function load()
    {
        $formMetadata = $this->getMetadata();
        $formKey = $formMetadata->getKey();
        $formsMetadata = [];
        $formsMetadata[$formKey][] = $this->getMetadata();
        return $formsMetadata;
    }

    public function getMetadata() : FormMetadata
    {
        $form = new FormMetadata();
        $key = 'form_details';
        $form->setKey($key);
        $form->setResource('');

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
        // set first component as default
        $defaultComponent = current($block->getComponents());
        $block->defaultComponentName = $defaultComponent->getName();
        $block->setType('block');
        $section->addChild($block);
        $form->addChild($section);
        $form->burnProperties();
        return $form;
    }


    public function loadFieldTypeMetadata(FormFieldTypeInterface $type) : PropertiesMetadata
    {
        $configuration = $type->getConfiguration();
        return $this->propertiesXmlLoader->load($configuration->getXmlPath());
    }

}