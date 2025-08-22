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

use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\Loader\AbstractLoader;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\Parser\PropertiesXmlParser;
use Sulu\Component\Content\Metadata\PropertiesMetadata;

class PropertiesXmlLoader extends AbstractLoader
{
    public const SCHEMA_PATH = '/schema/properties-1.0.xsd';

    public const SCHEMA_NAMESPACE_URI = 'http://schemas.sulu.io/template/template';

    /**
     * @var PropertiesXmlParser
     */
    private $propertiesXmlParser;

    public function __construct(
        PropertiesXmlParser $propertiesXmlParser
    ) {
        $this->propertiesXmlParser = $propertiesXmlParser;
        parent::__construct(
            self::SCHEMA_PATH,
            self::SCHEMA_NAMESPACE_URI
        );
    }

    /**
     * @param string $resource
     * @param string $type
     */
    protected function parse($resource, \DOMXPath $xpath, $type): array
    {
        $propertiesMetadata = new PropertiesMetadata();
        $propertiesMetadata->setResource($resource);

        $propertiesNode = $xpath->query('/x:properties')->item(0);
        $properties = $this->propertiesXmlParser->load(
            $xpath,
            $propertiesNode,
        );

        return $properties;
    }
}
