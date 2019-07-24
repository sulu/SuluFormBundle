<?php

namespace Sulu\Bundle\FormBundle\Tests\Functional\Dynamic;

use Sulu\Bundle\TestBundle\Testing\SuluTestCase;



class FormFieldTypeProviderTest extends SuluTestCase
{

    private $formFieldTypeProvider;

    
    protected function setUp()
    {
        $this->formFieldTypeProvider = $this->getContainer()->get('sulu_form.metadata.form_field_type_provider');
    }
    
    public function testLoadAllFieldTypes() {
        $fieldTypeMetadata = $this->formFieldTypeProvider->loadAllFieldTypes();

        self::assertEquals(26, count($fieldTypeMetadata));
        $first = $fieldTypeMetadata[0];
        self::assertObjectHasAttribute('resource', $first);
        self::assertObjectHasAttribute('properties', $first);
        self::assertObjectHasAttribute('name', $first);
        self::assertObjectHasAttribute('titles', $first);
        self::assertObjectHasAttribute('descriptions', $first);
        self::assertObjectHasAttribute('tags', $first);
        self::assertObjectHasAttribute('parameters', $first);
        self::assertObjectHasAttribute('children', $first);
        self::assertObjectHasAttribute('disabledCondition', $first);
        self::assertObjectHasAttribute('visibleCondition', $first);

        $this->assertNotNull($fieldTypeMetadata);
    }

    public function testGetMetadata(){
        $metadata = $this->formFieldTypeProvider->getMetadata();
        $this->assertNotNull($metadata);
        self::assertEquals('form_details', $metadata->getKey());

        $properties = $metadata->getProperties();
        self::assertArrayHasKey('fields', $properties);

        $fields = $properties['fields'];
        self::assertObjectHasAttribute('components', $fields);
        self::assertObjectHasAttribute('defaultComponentName', $fields);
        self::assertNotNull($fields->getDefaultComponentName());
        self::assertNotEmpty($fields->getDefaultComponentName());

        $components = $fields->getComponents();
        self::assertNotNull($components);
        self::assertEquals(26, count($components));

        $attachment = $fields->getComponentByName('attachment');
        self::assertNotNull($attachment);
        self::assertEquals('attachment', $attachment->getName());
        self::assertEquals(6, count($attachment->getChildren()));

        $attachmentChildren = $attachment->getChildren();
        self::assertArrayHasKey('required', $attachmentChildren);
        self::assertArrayHasKey('width', $attachmentChildren);
        self::assertArrayHasKey('title', $attachmentChildren);
        self::assertArrayHasKey('shortTitle', $attachmentChildren);
        self::assertArrayHasKey('options/type', $attachmentChildren);
        self::assertArrayHasKey('options/max', $attachmentChildren);

        print_r($attachment);
    }
}
