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

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;


class FormFieldTypeProvider
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

    public function loadFieldTypes() : array
    {
       $types = $this->formFieldTypePool->all();
       $propertiesMetadata = array();
       foreach ($types as $type) {
           $configuration = $type->getConfiguration();
           array_push($propertiesMetadata, $this->propertiesXmlLoader->load($configuration->getXmlPath()));
       }
       return $propertiesMetadata;
    }

}