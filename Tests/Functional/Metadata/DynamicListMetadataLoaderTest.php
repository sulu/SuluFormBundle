<?php

namespace Sulu\Bundle\FormBundle\Tests\Functional\Metadata;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadata;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Metadata\DynamicListMetadataLoader;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class DynamicListMetadataLoaderTest extends SuluTestCase
{
    /**
     * @var DynamicListMetadataLoader
     */
    private $dynamicListMetadataLoader;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    protected function setUp()
    {
        $this->dynamicListMetadataLoader = $this->getContainer()->get('sulu_form.metadata.dynamic_list_metadata_loader');
        parent::setUp();
        $this->purgeDatabase();
        $this->em = $this->getEntityManager();
    }

    public function testGetMetadataEnglish()
    {
        $form = $this->createFormWithFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'en', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertFalse($metadata->isCacheable());
        $this->assertCount(5, $metadata->getFields());

        $this->arrayHasKey('id', $metadata);
        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel());
        $this->assertEquals('string', $metadata->getFields()['id']->getType());
        $this->assertEquals('yes', $metadata->getFields()['id']->getVisibility());
        $this->assertTrue($metadata->getFields()['id']->isSortable());

        $this->arrayHasKey('email', $metadata);
        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail', $metadata->getFields()['email']->getLabel());
        $this->assertEquals('string', $metadata->getFields()['email']->getType());
        $this->assertEquals('yes', $metadata->getFields()['email']->getVisibility());
        $this->assertTrue($metadata->getFields()['email']->isSortable());

        $this->arrayHasKey('attachment', $metadata);
        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Attachment', $metadata->getFields()['attachment']->getLabel());
        $this->assertEquals('string', $metadata->getFields()['attachment']->getType());
        $this->assertEquals('yes', $metadata->getFields()['attachment']->getVisibility());
        $this->assertTrue($metadata->getFields()['attachment']->isSortable());

        $this->arrayHasKey('created', $metadata);
        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Created on', $metadata->getFields()['created']->getLabel());
        $this->assertEquals('datetime', $metadata->getFields()['created']->getType());
        $this->assertEquals('yes', $metadata->getFields()['created']->getVisibility());
        $this->assertTrue($metadata->getFields()['created']->isSortable());

        $this->arrayHasKey('changed', $metadata);
        $this->assertEquals('changed', $metadata->getFields()['changed']->getName());
        $this->assertEquals('Changed on', $metadata->getFields()['changed']->getLabel());
        $this->assertEquals('datetime', $metadata->getFields()['changed']->getType());
        $this->assertEquals('no', $metadata->getFields()['changed']->getVisibility());
        $this->assertTrue($metadata->getFields()['changed']->isSortable());
    }

    public function testGetMetadataGerman()
    {
        $form = $this->createFormWithFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'de', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertFalse($metadata->isCacheable());
        $this->assertCount(5, $metadata->getFields());

        $this->arrayHasKey('id', $metadata);
        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel());
        $this->assertEquals('string', $metadata->getFields()['id']->getType());
        $this->assertEquals('yes', $metadata->getFields()['id']->getVisibility());
        $this->assertTrue($metadata->getFields()['id']->isSortable());

        $this->arrayHasKey('email', $metadata);
        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail', $metadata->getFields()['email']->getLabel());
        $this->assertEquals('string', $metadata->getFields()['email']->getType());
        $this->assertEquals('yes', $metadata->getFields()['email']->getVisibility());
        $this->assertTrue($metadata->getFields()['email']->isSortable());

        $this->arrayHasKey('attachment', $metadata);
        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Anhang', $metadata->getFields()['attachment']->getLabel());
        $this->assertEquals('string', $metadata->getFields()['attachment']->getType());
        $this->assertEquals('yes', $metadata->getFields()['attachment']->getVisibility());
        $this->assertTrue($metadata->getFields()['attachment']->isSortable());

        $this->arrayHasKey('created', $metadata);
        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Erstellt am', $metadata->getFields()['created']->getLabel());
        $this->assertEquals('datetime', $metadata->getFields()['created']->getType());
        $this->assertEquals('yes', $metadata->getFields()['created']->getVisibility());
        $this->assertTrue($metadata->getFields()['created']->isSortable());

        $this->arrayHasKey('changed', $metadata);
        $this->assertEquals('changed', $metadata->getFields()['changed']->getName());
        $this->assertEquals('Geändert am', $metadata->getFields()['changed']->getLabel());
        $this->assertEquals('datetime', $metadata->getFields()['changed']->getType());
        $this->assertEquals('no', $metadata->getFields()['changed']->getVisibility());
        $this->assertTrue($metadata->getFields()['changed']->isSortable());
    }

    public function testGetMetadataLabelsEnglish()
    {
        $form = $this->createFormWithAllFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'en', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertCount(29, $metadata->getFields());

        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel());

        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Attachment', $metadata->getFields()['attachment']->getLabel());#

        $this->assertEquals('checkboxMultiple', $metadata->getFields()['checkboxMultiple']->getName());
        $this->assertEquals('Checkboxes', $metadata->getFields()['checkboxMultiple']->getLabel());

        $this->assertEquals('checkbox', $metadata->getFields()['checkbox']->getName());
        $this->assertEquals('Checkbox', $metadata->getFields()['checkbox']->getLabel());

        $this->assertEquals('city', $metadata->getFields()['city']->getName());
        $this->assertEquals('City', $metadata->getFields()['city']->getLabel());

        $this->assertEquals('company', $metadata->getFields()['company']->getName());
        $this->assertEquals('Company', $metadata->getFields()['company']->getLabel());

        $this->assertEquals('country', $metadata->getFields()['country']->getName());
        $this->assertEquals('Country', $metadata->getFields()['country']->getLabel());

        $this->assertEquals('date', $metadata->getFields()['date']->getName());
        $this->assertEquals('Date', $metadata->getFields()['date']->getLabel());

        $this->assertEquals('dropdownMultiple', $metadata->getFields()['dropdownMultiple']->getName());
        $this->assertEquals('Select (multiple)', $metadata->getFields()['dropdownMultiple']->getLabel());

        $this->assertEquals('dropdown', $metadata->getFields()['dropdown']->getName());
        $this->assertEquals('Select', $metadata->getFields()['dropdown']->getLabel());

        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail', $metadata->getFields()['email']->getLabel());

        $this->assertEquals('firstName', $metadata->getFields()['firstName']->getName());
        $this->assertEquals('Firstname', $metadata->getFields()['firstName']->getLabel());

        $this->assertEquals('freeText', $metadata->getFields()['freeText']->getName());
        $this->assertEquals('Free Text', $metadata->getFields()['freeText']->getLabel());

        $this->assertEquals('function', $metadata->getFields()['function']->getName());
        $this->assertEquals('Function', $metadata->getFields()['function']->getLabel());

        $this->assertEquals('headline', $metadata->getFields()['headline']->getName());
        $this->assertEquals('Headline', $metadata->getFields()['headline']->getLabel());

        $this->assertEquals('lastName', $metadata->getFields()['lastName']->getName());
        $this->assertEquals('Lastname', $metadata->getFields()['lastName']->getLabel());

        $this->assertEquals('phone', $metadata->getFields()['phone']->getName());
        $this->assertEquals('Phone', $metadata->getFields()['phone']->getLabel());

        $this->assertEquals('radioButtons', $metadata->getFields()['radioButtons']->getName());
        $this->assertEquals('Radio Buttons', $metadata->getFields()['radioButtons']->getLabel());

        $this->assertEquals('salutation', $metadata->getFields()['salutation']->getName());
        $this->assertEquals('Salutation', $metadata->getFields()['salutation']->getLabel());

        $this->assertEquals('spacer', $metadata->getFields()['spacer']->getName());
        $this->assertEquals('Spacer', $metadata->getFields()['spacer']->getLabel());

        $this->assertEquals('state', $metadata->getFields()['state']->getName());
        $this->assertEquals('State', $metadata->getFields()['state']->getLabel());

        $this->assertEquals('street', $metadata->getFields()['street']->getName());
        $this->assertEquals('Street', $metadata->getFields()['street']->getLabel());

        $this->assertEquals('textarea', $metadata->getFields()['textarea']->getName());
        $this->assertEquals('Multiline Textfield', $metadata->getFields()['textarea']->getLabel());

        $this->assertEquals('text', $metadata->getFields()['text']->getName());
        $this->assertEquals('Simple Textfield', $metadata->getFields()['text']->getLabel());

        $this->assertEquals('title', $metadata->getFields()['title']->getName());
        $this->assertEquals('Title', $metadata->getFields()['title']->getLabel());

        $this->assertEquals('zip', $metadata->getFields()['zip']->getName());
        $this->assertEquals('Zip', $metadata->getFields()['zip']->getLabel());

        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Created on', $metadata->getFields()['created']->getLabel());

        $this->assertEquals('changed', $metadata->getFields()['changed']->getName());
        $this->assertEquals('Changed on', $metadata->getFields()['changed']->getLabel());
    }

    public function testGetMetadataLabelsGerman()
    {
        $form = $this->createFormWithAllFields();

        $metadataOptions = ['id' => $form->getId()];
        $metadata = $this->dynamicListMetadataLoader->getMetadata('form_data', 'de', $metadataOptions);

        $this->assertInstanceOf(ListMetadata::class, $metadata);
        $this->assertCount(29, $metadata->getFields());

        $this->assertEquals('id', $metadata->getFields()['id']->getName());
        $this->assertEquals('ID', $metadata->getFields()['id']->getLabel());

        $this->assertEquals('attachment', $metadata->getFields()['attachment']->getName());
        $this->assertEquals('Anhang', $metadata->getFields()['attachment']->getLabel());#

        $this->assertEquals('checkboxMultiple', $metadata->getFields()['checkboxMultiple']->getName());
        $this->assertEquals('Checkboxes', $metadata->getFields()['checkboxMultiple']->getLabel());

        $this->assertEquals('checkbox', $metadata->getFields()['checkbox']->getName());
        $this->assertEquals('Checkbox', $metadata->getFields()['checkbox']->getLabel());

        $this->assertEquals('city', $metadata->getFields()['city']->getName());
        $this->assertEquals('Stadt', $metadata->getFields()['city']->getLabel());

        $this->assertEquals('company', $metadata->getFields()['company']->getName());
        $this->assertEquals('Firma', $metadata->getFields()['company']->getLabel());

        $this->assertEquals('country', $metadata->getFields()['country']->getName());
        $this->assertEquals('Land', $metadata->getFields()['country']->getLabel());

        $this->assertEquals('date', $metadata->getFields()['date']->getName());
        $this->assertEquals('Datum', $metadata->getFields()['date']->getLabel());

        $this->assertEquals('dropdownMultiple', $metadata->getFields()['dropdownMultiple']->getName());
        $this->assertEquals('Dropdown (Mehrfachauswahl)', $metadata->getFields()['dropdownMultiple']->getLabel());

        $this->assertEquals('dropdown', $metadata->getFields()['dropdown']->getName());
        $this->assertEquals('Dropdown', $metadata->getFields()['dropdown']->getLabel());

        $this->assertEquals('email', $metadata->getFields()['email']->getName());
        $this->assertEquals('E-Mail', $metadata->getFields()['email']->getLabel());

        $this->assertEquals('firstName', $metadata->getFields()['firstName']->getName());
        $this->assertEquals('Vorname', $metadata->getFields()['firstName']->getLabel());

        $this->assertEquals('freeText', $metadata->getFields()['freeText']->getName());
        $this->assertEquals('Freier Text', $metadata->getFields()['freeText']->getLabel());

        $this->assertEquals('function', $metadata->getFields()['function']->getName());
        $this->assertEquals('Funktion', $metadata->getFields()['function']->getLabel());

        $this->assertEquals('headline', $metadata->getFields()['headline']->getName());
        $this->assertEquals('Überschrift', $metadata->getFields()['headline']->getLabel());

        $this->assertEquals('lastName', $metadata->getFields()['lastName']->getName());
        $this->assertEquals('Nachname', $metadata->getFields()['lastName']->getLabel());

        $this->assertEquals('phone', $metadata->getFields()['phone']->getName());
        $this->assertEquals('Telefon', $metadata->getFields()['phone']->getLabel());

        $this->assertEquals('radioButtons', $metadata->getFields()['radioButtons']->getName());
        $this->assertEquals('Radio Buttons', $metadata->getFields()['radioButtons']->getLabel());

        $this->assertEquals('salutation', $metadata->getFields()['salutation']->getName());
        $this->assertEquals('Anrede', $metadata->getFields()['salutation']->getLabel());

        $this->assertEquals('spacer', $metadata->getFields()['spacer']->getName());
        $this->assertEquals('Leerraum', $metadata->getFields()['spacer']->getLabel());

        $this->assertEquals('state', $metadata->getFields()['state']->getName());
        $this->assertEquals('Bundesland', $metadata->getFields()['state']->getLabel());

        $this->assertEquals('street', $metadata->getFields()['street']->getName());
        $this->assertEquals('Straße', $metadata->getFields()['street']->getLabel());

        $this->assertEquals('textarea', $metadata->getFields()['textarea']->getName());
        $this->assertEquals('Mehrzeiliges Textfeld', $metadata->getFields()['textarea']->getLabel());

        $this->assertEquals('text', $metadata->getFields()['text']->getName());
        $this->assertEquals('Einzeiliges Textfeld', $metadata->getFields()['text']->getLabel());

        $this->assertEquals('title', $metadata->getFields()['title']->getName());
        $this->assertEquals('Titel', $metadata->getFields()['title']->getLabel());

        $this->assertEquals('zip', $metadata->getFields()['zip']->getName());
        $this->assertEquals('PLZ', $metadata->getFields()['zip']->getLabel());

        $this->assertEquals('created', $metadata->getFields()['created']->getName());
        $this->assertEquals('Erstellt am', $metadata->getFields()['created']->getLabel());

        $this->assertEquals('changed', $metadata->getFields()['changed']->getName());
        $this->assertEquals('Geändert am', $metadata->getFields()['changed']->getLabel());
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

        $this->addField($form, 'attachment');
        $this->addField($form, 'checkboxMultiple');
        $this->addField($form, 'checkbox');
        $this->addField($form, 'city');
        $this->addField($form, 'company');
        $this->addField($form, 'country');
        $this->addField($form, 'date');
        $this->addField($form, 'dropdownMultiple');
        $this->addField($form, 'dropdown');
        $this->addField($form, 'email');
        $this->addField($form, 'fax');
        $this->addField($form, 'firstName');
        $this->addField($form, 'freeText');
        $this->addField($form, 'function');
        $this->addField($form, 'headline');
        $this->addField($form, 'lastName');
        $this->addField($form, 'phone');
        $this->addField($form, 'radioButtons');
        $this->addField($form, 'salutation');
        $this->addField($form, 'spacer');
        $this->addField($form, 'state');
        $this->addField($form, 'street');
        $this->addField($form, 'textarea');
        $this->addField($form, 'text');
        $this->addField($form, 'title');
        $this->addField($form, 'zip');

        $this->em->persist($form);
        $this->em->flush();

        return $form;
    }

    private function addField(Form $form, string $type)
    {
        $formField = new FormField();
        $formField->setDefaultLocale('en');
        $formField->setKey($type);
        $formField->setType($type);
        $formField->setWidth('full');
        $formField->setRequired(true);
        $formField->setOrder(count($form->getFields()) +1);

        $formField->setForm($form);
        $form->addField($formField);
    }
}
