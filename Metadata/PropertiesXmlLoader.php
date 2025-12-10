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
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\Loader\AbstractLoader;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\Parser\PropertiesXmlParser;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\SectionMetadata;
use Webmozart\Assert\Assert;

/**
 * @extends AbstractLoader<mixed>
 */
class PropertiesXmlLoader extends AbstractLoader
{
    public const SCHEMA_PATH = '/schema/properties-1.0.xsd';

    public const SCHEMA_NAMESPACE_URI = 'http://schemas.sulu.io/template/template';

    public function __construct(
        private PropertiesXmlParser $propertiesXmlParser
    ) {
        parent::__construct(
            self::SCHEMA_PATH,
            self::SCHEMA_NAMESPACE_URI
        );
    }

    /**
     * @return array<FieldMetadata|SectionMetadata>
     */
    protected function parse(string $resource, \DOMXPath $xpath, ?string $type): array
    {
        $node = $xpath->query('/x:properties')->item(0);
        Assert::notNull($node, 'Resource does not contain an <properties> definition: ' . $resource);

        return $this->propertiesXmlParser->load($xpath, $node);
    }
}
