<?php

namespace Sulu\Bundle\FormBundle\Tests\Functional\Dynamic;

use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class FormTypeMetadataLoaderTest extends SuluTestCase
{
    private $formFieldTypeProvider;

    protected function setUp()
    {
        $this->formFieldTypeProvider = $this->getContainer()->get('sulu_form.metadata.form_field_type_provider');
    }

    public function testGetMetadata()
    {
        $formsMetadata = $this->formFieldTypeProvider->load();
        self::assertArrayHasKey('form_details', $formsMetadata);

        $metadata = $formsMetadata['form_details'][0];
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
        var_dump($attachment);
        self::assertNotNull($attachment);
        self::assertEquals('attachment', $attachment->getName());
        self::assertObjectHasAttribute('titles', $attachment);
        self::assertObjectHasAttribute('descriptions', $attachment);
        self::assertObjectHasAttribute('tags', $attachment);
        self::assertObjectHasAttribute('parameters', $attachment);
        self::assertObjectHasAttribute('children', $attachment);
        self::assertObjectHasAttribute('disabledCondition', $attachment);
        self::assertObjectHasAttribute('visibleCondition', $attachment);

        self::assertEquals(6, count($attachment->getChildren()));
        $attachmentChildren = $attachment->getChildren();
        self::assertArrayHasKey('required', $attachmentChildren);
        self::assertArrayHasKey('width', $attachmentChildren);
        self::assertArrayHasKey('title', $attachmentChildren);
        self::assertArrayHasKey('shortTitle', $attachmentChildren);
        self::assertArrayHasKey('options/type', $attachmentChildren);
        self::assertArrayHasKey('options/max', $attachmentChildren);
    }
}
