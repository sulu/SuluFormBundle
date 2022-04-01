<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Metadata;

use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FieldMetadata;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\FormMetadata;
use Sulu\Bundle\AdminBundle\Metadata\FormMetadata\SectionMetadata;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class DynamicFormMetadataLoaderTest extends SuluTestCase
{
    private $dynamicFormMetadataLoader;

    protected function setUp(): void
    {
        $this->dynamicFormMetadataLoader = $this->getContainer()->get('sulu_form_test.dynamic_form_metadata_loader');
    }

    public function testGetMetadataEnglish(): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'en');

        $this->assertInstanceOf(FormMetadata::class, $formMetadata);
        $this->assertEquals('form_details', $formMetadata->getKey());
        $this->assertCount(5, $formMetadata->getItems());
        $this->assertContains('title', \array_keys($formMetadata->getItems()));
        $this->assertContains('formFields', \array_keys($formMetadata->getItems()));
        $this->assertContains('websiteConfiguration', \array_keys($formMetadata->getItems()));
        $this->assertContains('emailConfiguration', \array_keys($formMetadata->getItems()));
        $this->assertContains('receivers', \array_keys($formMetadata->getItems()));

        $formFields = $formMetadata->getItems()['formFields'];
        $this->assertInstanceOf(SectionMetadata::class, $formFields);
        $this->assertCount(1, $formFields->getItems());
        $this->assertContains('fields', \array_keys($formFields->getItems()));
        $this->assertEquals('section', $formFields->getType());
        $this->assertEquals('formFields', $formFields->getName());
        $this->assertEquals('Form Fields', $formFields->getLabel());

        $fields = $formFields->getItems()['fields'];
        $this->assertInstanceOf(FieldMetadata::class, $fields);
        $this->assertCount(27, $fields->getTypes());
        $this->assertEquals('fields', $fields->getName());
        $this->assertEquals('block', $fields->getType());
        $this->assertEquals('attachment', $fields->getDefaultType());
        $this->assertEquals([
            'attachment',
            'recaptcha',
            'checkbox',
            'checkboxMultiple',
            'city',
            'company',
            'country',
            'date',
            'email',
            'fax',
            'firstName',
            'freeText',
            'function',
            'headline',
            'lastName',
            'textarea',
            'phone',
            'radioButtons',
            'salutation',
            'dropdown',
            'dropdownMultiple',
            'text',
            'spacer',
            'state',
            'street',
            'title',
            'zip',
        ], \array_keys($fields->getTypes()));
    }

    public function testGetMetadataGerman(): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'de');

        $this->assertInstanceOf(FormMetadata::class, $formMetadata);
        $this->assertEquals('form_details', $formMetadata->getKey());
        $this->assertCount(5, $formMetadata->getItems());
        $this->assertContains('title', \array_keys($formMetadata->getItems()));
        $this->assertContains('formFields', \array_keys($formMetadata->getItems()));
        $this->assertContains('websiteConfiguration', \array_keys($formMetadata->getItems()));
        $this->assertContains('emailConfiguration', \array_keys($formMetadata->getItems()));
        $this->assertContains('receivers', \array_keys($formMetadata->getItems()));

        $formFields = $formMetadata->getItems()['formFields'];
        $this->assertInstanceOf(SectionMetadata::class, $formFields);
        $this->assertCount(1, $formFields->getItems());
        $this->assertContains('fields', \array_keys($formFields->getItems()));
        $this->assertEquals('section', $formFields->getType());
        $this->assertEquals('formFields', $formFields->getName());
        $this->assertEquals('Formular Felder', $formFields->getLabel());

        $fields = $formFields->getItems()['fields'];
        $this->assertInstanceOf(FieldMetadata::class, $fields);
        $this->assertCount(27, $fields->getTypes());
        $this->assertEquals('fields', $fields->getName());
        $this->assertEquals('block', $fields->getType());
        $this->assertEquals('attachment', $fields->getDefaultType());
        $this->assertEquals([
            'attachment',
            'salutation',
            'state',
            'recaptcha',
            'checkbox',
            'checkboxMultiple',
            'date',
            'dropdown',
            'dropdownMultiple',
            'email',
            'text',
            'fax',
            'company',
            'freeText',
            'function',
            'country',
            'spacer',
            'textarea',
            'lastName',
            'zip',
            'radioButtons',
            'city',
            'street',
            'phone',
            'title',
            'firstName',
            'headline',
        ], \array_keys($fields->getTypes()));
    }

    public function testGetMetadataLabelsEnglish(): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'en');

        $this->assertInstanceOf(FormMetadata::class, $formMetadata);
        $this->assertEquals('form_details', $formMetadata->getKey());
        $this->assertCount(5, $formMetadata->getItems());
        $this->assertEquals('Title', $formMetadata->getItems()['title']->getLabel());
        $this->assertEquals('Form Fields', $formMetadata->getItems()['formFields']->getLabel());
        $this->assertEquals('Website Configuration', $formMetadata->getItems()['websiteConfiguration']
            ->getLabel());
        $this->assertEquals('E-Mail Configuration', $formMetadata->getItems()['emailConfiguration']->getLabel());
        $this->assertEquals('Receivers', $formMetadata->getItems()['receivers']->getLabel());
    }

    public function testGetMetadataLabelsGerman(): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'de');

        $this->assertInstanceOf(FormMetadata::class, $formMetadata);
        $this->assertEquals('form_details', $formMetadata->getKey());
        $this->assertCount(5, $formMetadata->getItems());
        $this->assertEquals('Titel', $formMetadata->getItems()['title']->getLabel());
        $this->assertEquals('Formular Felder', $formMetadata->getItems()['formFields']->getLabel());
        $this->assertEquals('Website Konfiguration', $formMetadata->getItems()['websiteConfiguration']
            ->getLabel());
        $this->assertEquals('E-Mail Konfiguration', $formMetadata->getItems()['emailConfiguration']->getLabel());
        $this->assertEquals('Empfänger', $formMetadata->getItems()['receivers']->getLabel());
    }

    public function testGetMetadataAttachmentEnglish(): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'en');

        $this->assertInstanceOf(FormMetadata::class, $formMetadata);
        $this->assertCount(5, $formMetadata->getItems());

        $formFields = $formMetadata->getItems()['formFields'];
        $this->assertInstanceOf(SectionMetadata::class, $formFields);
        $this->assertCount(1, $formFields->getItems());

        $fields = $formFields->getItems()['fields'];
        $this->assertInstanceOf(FieldMetadata::class, $fields);
        $this->assertCount(27, $fields->getTypes());

        $attachment = $fields->getTypes()['attachment'];
        $this->assertInstanceOf(FormMetadata::class, $attachment);
        $this->assertEquals('attachment', $attachment->getName());
        $this->assertEquals('Attachment', $attachment->getTitle());
        $this->assertCount(6, $attachment->getItems());

        $this->arrayHasKey('required', $attachment->getItems());
        $this->assertEquals('Required field', $attachment->getItems()['required']->getLabel());
        $this->assertEquals('checkbox', $attachment->getItems()['required']->getType());
        $this->assertEquals(6, $attachment->getItems()['required']->getColspan());

        $this->arrayHasKey('width', $attachment->getItems());
        $this->assertEquals('Width', $attachment->getItems()['width']->getLabel());
        $this->assertEquals('single_select', $attachment->getItems()['width']->getType());
        $this->assertEquals(6, $attachment->getItems()['width']->getColspan());
        $this->assertCount(3, $attachment->getItems()['width']->getOptions());
        $this->arrayHasKey('label', $attachment->getItems()['width']->getOptions());
        $this->arrayHasKey('default_value', $attachment->getItems()['width']->getOptions());
        $this->arrayHasKey('values', $attachment->getItems()['width']->getOptions());
        $this->assertCount(8, $attachment->getItems()['width']->getOptions()['values']->getValue());

        $this->arrayHasKey('title', $attachment->getItems());
        $this->assertEquals('Title', $attachment->getItems()['title']->getLabel());
        $this->assertEquals('text_editor', $attachment->getItems()['title']->getType());
        $this->assertEquals(12, $attachment->getItems()['title']->getColspan());

        $this->arrayHasKey('shortTitle', $attachment->getItems());
        $this->assertEquals('Short title', $attachment->getItems()['shortTitle']->getLabel());
        $this->assertEquals('text_line', $attachment->getItems()['shortTitle']->getType());
        $this->assertEquals(12, $attachment->getItems()['shortTitle']->getColspan());
        $this->assertEquals(
            'Optional title of field, for example in notification mail.',
            $attachment->getItems()['shortTitle']->getDescription()
        );

        $this->arrayHasKey('options/type', $attachment->getItems());
        $this->assertEquals('Restrict file types', $attachment->getItems()['options/type']->getLabel());
        $this->assertEquals('select', $attachment->getItems()['options/type']->getType());
        $this->assertEquals('No choice will allow all file types.', $attachment->getItems()['options/type']
            ->getDescription());
        $this->assertEquals(6, $attachment->getItems()['options/type']->getColspan());
        $this->assertCount(1, $attachment->getItems()['options/type']->getOptions());
        $this->arrayHasKey('values', $attachment->getItems()['options/type']->getOptions());
        $this->assertCount(3, $attachment->getItems()['options/type']->getOptions()['values']->getValue());

        $this->arrayHasKey('options/max', $attachment->getItems());
        $this->assertEquals('Maximum amount', $attachment->getItems()['options/max']->getLabel());
        $this->assertEquals('number', $attachment->getItems()['options/max']->getType());
        $this->assertEquals(6, $attachment->getItems()['options/max']->getColspan());

        $this->assertObjectHasAttribute('schema', $attachment);
        $this->assertObjectHasAttribute('key', $attachment);
    }

    public function testGetMetadataAttachmentGerman(): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'de');

        $this->assertInstanceOf(FormMetadata::class, $formMetadata);
        $this->assertCount(5, $formMetadata->getItems());

        $formFields = $formMetadata->getItems()['formFields'];
        $this->assertInstanceOf(SectionMetadata::class, $formFields);
        $this->assertCount(1, $formFields->getItems());

        $fields = $formFields->getItems()['fields'];
        $this->assertInstanceOf(FieldMetadata::class, $fields);
        $this->assertCount(27, $fields->getTypes());

        $attachment = $fields->getTypes()['attachment'];
        $this->assertInstanceOf(FormMetadata::class, $attachment);
        $this->assertEquals('attachment', $attachment->getName());
        $this->assertEquals('Anhang', $attachment->getTitle());

        $this->arrayHasKey('required', $attachment->getItems());
        $this->assertEquals('Pflichtfeld', $attachment->getItems()['required']->getLabel());
        $this->assertEquals('checkbox', $attachment->getItems()['required']->getType());

        $this->arrayHasKey('width', $attachment->getItems());
        $this->assertEquals('Breite', $attachment->getItems()['width']->getLabel());
        $this->assertEquals('single_select', $attachment->getItems()['width']->getType());

        $this->arrayHasKey('title', $attachment->getItems());
        $this->assertEquals('Titel', $attachment->getItems()['title']->getLabel());
        $this->assertEquals('text_editor', $attachment->getItems()['title']->getType());

        $this->arrayHasKey('shortTitle', $attachment->getItems());
        $this->assertEquals('Kurztitel', $attachment->getItems()['shortTitle']->getLabel());
        $this->assertEquals('text_line', $attachment->getItems()['shortTitle']->getType());
        $this->assertEquals(
            'Optionaler Titel des Feldes, z.B. in der Benachrichtigungs-Email.',
            $attachment->getItems()['shortTitle']->getDescription()
        );

        $this->arrayHasKey('options/type', $attachment->getItems());
        $this->assertEquals('Dateitypen beschränken', $attachment->getItems()['options/type']->getLabel());
        $this->assertEquals('select', $attachment->getItems()['options/type']->getType());
        $this->assertEquals('Bei keiner Auswahl sind alle Dateitypen möglich.', $attachment->
        getItems()['options/type']
            ->getDescription());

        $this->arrayHasKey('options/max', $attachment->getItems());
        $this->assertEquals('Maximale Anzahl', $attachment->getItems()['options/max']->getLabel());
    }
}
