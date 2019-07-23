<?php


namespace Sulu\Bundle\FormBundle\Metadata;

use Sulu\Component\Content\Metadata\Parser\PropertiesXmlParser;
use Sulu\Component\Content\Metadata\Loader\AbstractLoader;

class PropertiesXmlLoader extends AbstractLoader
{
    const SCHEMA_PATH = '/schema/template-1.0.xsd';

    const SCHEMA_NAMESPACE_URI = 'http://schemas.sulu.io/template/template';

    private $propertiesXmlParser;

    public function __construct(
        PropertiesXmlParser $propertiesXmlParser
    )
    {
        $this->propertiesXmlParser = $propertiesXmlParser;
        parent::__construct(
            self::SCHEMA_PATH,
            self::SCHEMA_NAMESPACE_URI
        );
    }

    protected function parse($resource, \DOMXPath $xpath, $type): PropertiesMetadata
    {
        // init running vars
        $tags = [];

        $propertiesMetadata = new PropertiesMetadata();
        $propertiesMetadata->setResource($resource);

        $propertiesNode = $xpath->query('/x:properties')->item(0);
        $properties = $this->propertiesXmlParser->load(
            $tags,
            $xpath,
            $propertiesNode
        );

        foreach ($properties as $property) {
            $propertiesMetadata->addChild($property);
        }
        $propertiesMetadata->burnProperties();

        return $propertiesMetadata;
    }
}