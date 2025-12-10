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

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadata;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Metadata\DynamicListMetadataLoader;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class DynamicListMetadataLoaderTest extends SuluTestCase
{
    private DynamicListMetadataLoader $dynamicListMetadataLoader;

    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->dynamicListMetadataLoader = $this->getContainer()->get('sulu_form_test.dynamic_list_metadata_loader');
        parent::setUp();
        $this->purgeDatabase();
        $this->em = $this->getEntityManager();
    }

    public function testGetMetadataEnglish(): void
    {
        $form = $this->createFormWithFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'en', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertFalse($metadata->isCacheable());
        $this->assertCount(4, $metadata->getFields());

        $this->arrayHasKey('id', $metadata);
        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel('en'));
        $this->assertEquals('string', $metadata->getFields()['id']->getType());
        $this->assertEquals('no', $metadata->getFields()['id']->getVisibility());
        $this->assertTrue($metadata->getFields()['id']->isSortable());

        $this->arrayHasKey('email', $metadata);
        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail En', $metadata->getFields()['email']->getLabel('en'));
        $this->assertEquals('string', $metadata->getFields()['email']->getType());
        $this->assertEquals('yes', $metadata->getFields()['email']->getVisibility());
        $this->assertFalse($metadata->getFields()['email']->isSortable());

        $this->arrayHasKey('attachment', $metadata);
        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Attachment', $metadata->getFields()['attachment']->getLabel('en'));
        $this->assertEquals('string', $metadata->getFields()['attachment']->getType());
        $this->assertEquals('yes', $metadata->getFields()['attachment']->getVisibility());
        $this->assertFalse($metadata->getFields()['attachment']->isSortable());

        $this->arrayHasKey('created', $metadata);
        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Created on', $metadata->getFields()['created']->getLabel('en'));
        $this->assertEquals('datetime', $metadata->getFields()['created']->getType());
        $this->assertEquals('yes', $metadata->getFields()['created']->getVisibility());
        $this->assertTrue($metadata->getFields()['created']->isSortable());
    }

    public function testGetMetadataGerman()
    {
        $form = $this->createFormWithFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'de', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertFalse($metadata->isCacheable());
        $this->assertCount(4, $metadata->getFields());

        $this->arrayHasKey('id', $metadata);
        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel('de'));
        $this->assertEquals('string', $metadata->getFields()['id']->getType());
        $this->assertEquals('no', $metadata->getFields()['id']->getVisibility());
        $this->assertTrue($metadata->getFields()['id']->isSortable());

        $this->arrayHasKey('email', $metadata);
        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail De', $metadata->getFields()['email']->getLabel('de'));
        $this->assertEquals('string', $metadata->getFields()['email']->getType());
        $this->assertEquals('yes', $metadata->getFields()['email']->getVisibility());
        $this->assertFalse($metadata->getFields()['email']->isSortable());

        $this->arrayHasKey('attachment', $metadata);
        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Anhang', $metadata->getFields()['attachment']->getLabel('de'));
        $this->assertEquals('string', $metadata->getFields()['attachment']->getType());
        $this->assertEquals('yes', $metadata->getFields()['attachment']->getVisibility());
        $this->assertFalse($metadata->getFields()['attachment']->isSortable());

        $this->arrayHasKey('created', $metadata);
        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Erstellt am', $metadata->getFields()['created']->getLabel('de'));
        $this->assertEquals('datetime', $metadata->getFields()['created']->getType());
        $this->assertEquals('yes', $metadata->getFields()['created']->getVisibility());
        $this->assertTrue($metadata->getFields()['created']->isSortable());
    }

    public function testGetMetadataLabelsEnglish(): void
    {
        $form = $this->createFormWithAllFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'en', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertCount(25, $metadata->getFields());

        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel('en'));

        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Attachment', $metadata->getFields()['attachment']->getLabel('en'));

        $this->assertEquals('checkboxMultiple', $metadata->getFields()['checkboxMultiple']->getName());
        $this->assertEquals('Checkboxes', $metadata->getFields()['checkboxMultiple']->getLabel('en'));

        $this->assertEquals('checkbox', $metadata->getFields()['checkbox']->getName());
        $this->assertEquals('Checkbox', $metadata->getFields()['checkbox']->getLabel('en'));

        $this->assertEquals('city', $metadata->getFields()['city']->getName());
        $this->assertEquals('City', $metadata->getFields()['city']->getLabel('en'));

        $this->assertEquals('company', $metadata->getFields()['company']->getName());
        $this->assertEquals('Company', $metadata->getFields()['company']->getLabel('en'));

        $this->assertEquals('country', $metadata->getFields()['country']->getName());
        $this->assertEquals('Country', $metadata->getFields()['country']->getLabel('en'));

        $this->assertEquals('date', $metadata->getFields()['date']->getName());
        $this->assertEquals('Date', $metadata->getFields()['date']->getLabel('en'));

        $this->assertEquals('dropdownMultiple', $metadata->getFields()['dropdownMultiple']->getName());
        $this->assertEquals('Select (multiple)', $metadata->getFields()['dropdownMultiple']->getLabel('en'));

        $this->assertEquals('dropdown', $metadata->getFields()['dropdown']->getName());
        $this->assertEquals('Select', $metadata->getFields()['dropdown']->getLabel('en'));

        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail', $metadata->getFields()['email']->getLabel('en'));

        $this->assertEquals('firstName', $metadata->getFields()['firstName']->getName());
        $this->assertEquals('Firstname', $metadata->getFields()['firstName']->getLabel('en'));

        $this->assertEquals('function', $metadata->getFields()['function']->getName());
        $this->assertEquals('Function', $metadata->getFields()['function']->getLabel('en'));

        $this->assertEquals('lastName', $metadata->getFields()['lastName']->getName());
        $this->assertEquals('Lastname', $metadata->getFields()['lastName']->getLabel('en'));

        $this->assertEquals('phone', $metadata->getFields()['phone']->getName());
        $this->assertEquals('Phone', $metadata->getFields()['phone']->getLabel('en'));

        $this->assertEquals('radioButtons', $metadata->getFields()['radioButtons']->getName());
        $this->assertEquals('Radio Buttons', $metadata->getFields()['radioButtons']->getLabel('en'));

        $this->assertEquals('salutation', $metadata->getFields()['salutation']->getName());
        $this->assertEquals('Salutation', $metadata->getFields()['salutation']->getLabel('en'));

        $this->assertEquals('state', $metadata->getFields()['state']->getName());
        $this->assertEquals('State', $metadata->getFields()['state']->getLabel('en'));

        $this->assertEquals('street', $metadata->getFields()['street']->getName());
        $this->assertEquals('Street', $metadata->getFields()['street']->getLabel('en'));

        $this->assertEquals('textarea', $metadata->getFields()['textarea']->getName());
        $this->assertEquals('Multiline Textfield', $metadata->getFields()['textarea']->getLabel('en'));

        $this->assertEquals('text', $metadata->getFields()['text']->getName());
        $this->assertEquals('Simple Textfield', $metadata->getFields()['text']->getLabel('en'));

        $this->assertEquals('title', $metadata->getFields()['title']->getName());
        $this->assertEquals('Title', $metadata->getFields()['title']->getLabel('en'));

        $this->assertEquals('zip', $metadata->getFields()['zip']->getName());
        $this->assertEquals('Zip', $metadata->getFields()['zip']->getLabel('en'));

        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Created on', $metadata->getFields()['created']->getLabel('en'));
    }

    public function testGetMetadataLabelsGerman(): void
    {
        $form = $this->createFormWithAllFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'de', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertCount(25, $metadata->getFields());

        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel('de'));

        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Anhang', $metadata->getFields()['attachment']->getLabel('de'));

        $this->assertEquals('checkboxMultiple', $metadata->getFields()['checkboxMultiple']->getName());
        $this->assertEquals('Checkboxes', $metadata->getFields()['checkboxMultiple']->getLabel('de'));

        $this->assertEquals('checkbox', $metadata->getFields()['checkbox']->getName());
        $this->assertEquals('Checkbox', $metadata->getFields()['checkbox']->getLabel('de'));

        $this->assertEquals('city', $metadata->getFields()['city']->getName());
        $this->assertEquals('Stadt', $metadata->getFields()['city']->getLabel('de'));

        $this->assertEquals('company', $metadata->getFields()['company']->getName());
        $this->assertEquals('Firma', $metadata->getFields()['company']->getLabel('de'));

        $this->assertEquals('country', $metadata->getFields()['country']->getName());
        $this->assertEquals('Land', $metadata->getFields()['country']->getLabel('de'));

        $this->assertEquals('date', $metadata->getFields()['date']->getName());
        $this->assertEquals('Datum', $metadata->getFields()['date']->getLabel('de'));

        $this->assertEquals('dropdownMultiple', $metadata->getFields()['dropdownMultiple']->getName());
        $this->assertEquals('Dropdown (Mehrfachauswahl)', $metadata->getFields()['dropdownMultiple']->getLabel('de'));

        $this->assertEquals('dropdown', $metadata->getFields()['dropdown']->getName());
        $this->assertEquals('Dropdown', $metadata->getFields()['dropdown']->getLabel('de'));

        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail', $metadata->getFields()['email']->getLabel('de'));

        $this->assertEquals('firstName', $metadata->getFields()['firstName']->getName());
        $this->assertEquals('Vorname', $metadata->getFields()['firstName']->getLabel('de'));

        $this->assertEquals('function', $metadata->getFields()['function']->getName());
        $this->assertEquals('Funktion', $metadata->getFields()['function']->getLabel('de'));

        $this->assertEquals('lastName', $metadata->getFields()['lastName']->getName());
        $this->assertEquals('Nachname', $metadata->getFields()['lastName']->getLabel('de'));

        $this->assertEquals('phone', $metadata->getFields()['phone']->getName());
        $this->assertEquals('Telefon', $metadata->getFields()['phone']->getLabel('de'));

        $this->assertEquals('radioButtons', $metadata->getFields()['radioButtons']->getName());
        $this->assertEquals('Radio Buttons', $metadata->getFields()['radioButtons']->getLabel('de'));

        $this->assertEquals('salutation', $metadata->getFields()['salutation']->getName());
        $this->assertEquals('Anrede', $metadata->getFields()['salutation']->getLabel('de'));

        $this->assertEquals('state', $metadata->getFields()['state']->getName());
        $this->assertEquals('Bundesland', $metadata->getFields()['state']->getLabel('de'));

        $this->assertEquals('street', $metadata->getFields()['street']->getName());
        $this->assertEquals('Straße', $metadata->getFields()['street']->getLabel('de'));

        $this->assertEquals('textarea', $metadata->getFields()['textarea']->getName());
        $this->assertEquals('Mehrzeiliges Textfeld', $metadata->getFields()['textarea']->getLabel('de'));

        $this->assertEquals('text', $metadata->getFields()['text']->getName());
        $this->assertEquals('Einzeiliges Textfeld', $metadata->getFields()['text']->getLabel('de'));

        $this->assertEquals('title', $metadata->getFields()['title']->getName());
        $this->assertEquals('Titel', $metadata->getFields()['title']->getLabel('de'));

        $this->assertEquals('zip', $metadata->getFields()['zip']->getName());
        $this->assertEquals('PLZ', $metadata->getFields()['zip']->getLabel('de'));

        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Erstellt am', $metadata->getFields()['created']->getLabel('de'));
    }

    private function createFormWithFields(): Form
    {
        $form = new Form();
        $form->setDefaultLocale('en');

        $formTranslation = new FormTranslation();
        $formTranslation->setLocale('en');
        $formTranslation->setTitle('Title');

        // Field 1
        $formField = new FormField();
        $formField->setDefaultLocale('en');
        $formField->setKey('email');
        $formField->setType('email');
        $formField->setWidth('full');
        $formField->setRequired(true);
        $formField->setOrder(1);

        $formFieldTranslation = new FormFieldTranslation();
        $formFieldTranslation->setShortTitle('E-Mail En');
        $formFieldTranslation->setLocale('en');
        $formFieldTranslation->setField($formField);
        $formField->addTranslation($formFieldTranslation);

        $formFieldTranslation2 = new FormFieldTranslation();
        $formFieldTranslation2->setShortTitle('E-Mail De');
        $formFieldTranslation2->setLocale('de');
        $formFieldTranslation2->setField($formField);
        $formField->addTranslation($formFieldTranslation2);

        $formField->setForm($form);
        $form->addField($formField);

        // Field 2
        $formField2 = new FormField();
        $formField2->setDefaultLocale('en');
        $formField2->setKey('attachment');
        $formField2->setType('attachment');
        $formField2->setWidth('full');
        $formField2->setRequired(true);
        $formField2->setOrder(2);

        $formFieldTranslation3 = new FormFieldTranslation();
        $formFieldTranslation3->setShortTitle('Attachment');
        $formFieldTranslation3->setLocale('en');
        $formFieldTranslation3->setField($formField2);
        $formField2->addTranslation($formFieldTranslation3);

        $formFieldTranslation4 = new FormFieldTranslation();
        $formFieldTranslation4->setShortTitle('Anhang');
        $formFieldTranslation4->setLocale('de');
        $formFieldTranslation4->setField($formField2);
        $formField2->addTranslation($formFieldTranslation4);

        $formField2->setForm($form);
        $form->addField($formField2);

        $this->em->persist($form);
        $this->em->flush();

        return $form;
    }

    private function createFormWithAllFields(): Form
    {
        $form = new Form();
        $form->setDefaultLocale('en');

        $formTranslation = new FormTranslation();
        $formTranslation->setLocale('en');
        $formTranslation->setTitle('Title');

        $this->addField($form, 'attachment', 'Attachment', 'Anhang');
        $this->addField($form, 'checkboxMultiple', 'Checkboxes', 'Checkboxes');
        $this->addField($form, 'checkbox', 'Checkbox', 'Checkbox');
        $this->addField($form, 'city', 'City', 'Stadt');
        $this->addField($form, 'company', 'Company', 'Firma');
        $this->addField($form, 'country', 'Country', 'Land');
        $this->addField($form, 'date', 'Date', 'Datum');
        $this->addField($form, 'dropdownMultiple', 'Select (multiple)', 'Dropdown (Mehrfachauswahl)');
        $this->addField($form, 'dropdown', 'Select', 'Dropdown');
        $this->addField($form, 'email', 'E-Mail', 'E-Mail');
        $this->addField($form, 'fax', 'Fax', 'Fax');
        $this->addField($form, 'firstName', 'Firstname', 'Vorname');
        $this->addField($form, 'freeText', '', '');
        $this->addField($form, 'function', 'Function', 'Funktion');
        $this->addField($form, 'headline', '', '');
        $this->addField($form, 'lastName', 'Lastname', 'Nachname');
        $this->addField($form, 'phone', 'Phone', 'Telefon');
        $this->addField($form, 'radioButtons', 'Radio Buttons', 'Radio Buttons');
        $this->addField($form, 'salutation', 'Salutation', 'Anrede');
        $this->addField($form, 'spacer', '', '');
        $this->addField($form, 'state', 'State', 'Bundesland');
        $this->addField($form, 'street', 'Street', 'Straße');
        $this->addField($form, 'textarea', 'Multiline Textfield', 'Mehrzeiliges Textfeld');
        $this->addField($form, 'text', 'Simple Textfield', 'Einzeiliges Textfeld');
        $this->addField($form, 'title', 'Title', 'Titel');
        $this->addField($form, 'zip', 'Zip', 'PLZ');

        $this->em->persist($form);
        $this->em->flush();

        return $form;
    }

    private function addField(Form $form, string $type, string $translationEn, string $translationDe): void
    {
        $formField = new FormField();
        $formField->setDefaultLocale('en');
        $formField->setKey($type);
        $formField->setType($type);
        $formField->setWidth('full');
        $formField->setRequired(true);
        $formField->setOrder(\count($form->getFields()) + 1);

        $formFieldTranslation1 = new FormFieldTranslation();
        $formFieldTranslation1->setShortTitle($translationEn);
        $formFieldTranslation1->setLocale('en');
        $formFieldTranslation1->setField($formField);
        $formField->addTranslation($formFieldTranslation1);

        $formFieldTranslation2 = new FormFieldTranslation();
        $formFieldTranslation2->setShortTitle($translationDe);
        $formFieldTranslation2->setLocale('de');
        $formFieldTranslation2->setField($formField);
        $formField->addTranslation($formFieldTranslation2);

        $formField->setForm($form);
        $form->addField($formField);
    }
}
