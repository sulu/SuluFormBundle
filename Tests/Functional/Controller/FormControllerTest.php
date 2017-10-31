<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Configuration\MailConfiguration;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class FormControllerTest extends SuluTestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    protected function setUp()
    {
        parent::setUp();
        $this->purgeDatabase();
        $this->em = $this->getEntityManager();
    }

    public function testGetNotFound()
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'GET',
            '/api/forms/1'
        );

        $this->assertHttpStatusCode(404, $client->getResponse());
    }

    public function testGet()
    {
        $form = $this->createFullForm();

        $client = $this->createAuthenticatedClient();
        $client->request(
            'GET',
            '/api/forms/' . $form->getId()
        );

        $this->assertHttpStatusCode(200, $client->getResponse());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertFullForm($response);
    }

    public function testPostMinimal()
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/forms',
            [
                'locale' => 'en',
                'title' => 'Title',
            ]
        );

        $this->assertHttpStatusCode(201, $client->getResponse());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertMinimalForm($response);
    }

    public function testPostFull()
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'POST',
            '/api/forms',
            $this->getFullFormData()
        );

        $this->assertHttpStatusCode(201, $client->getResponse());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertFullForm($response);
    }

    public function testPutMinimal()
    {
        $form = $this->createFullForm();
        $client = $this->createAuthenticatedClient();
        $client->request(
            'PUT',
            '/api/forms/' . $form->getId(),
            [
                'locale' => 'en',
                'title' => 'Title',
            ]
        );

        $this->assertHttpStatusCode(200, $client->getResponse());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertMinimalForm($response);
    }

    public function testPutFull()
    {
        $form = $this->createMinimalForm();
        $client = $this->createAuthenticatedClient();
        $client->request(
            'PUT',
            '/api/forms/' . $form->getId(),
            $this->getFullFormData()
        );

        $this->assertHttpStatusCode(200, $client->getResponse());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertFullForm($response);
    }

    public function testPutNotExist()
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'PUT',
            '/api/forms/2',
            $this->getFullFormData()
        );

        $this->assertHttpStatusCode(404, $client->getResponse());
    }

    public function testDelete()
    {
        $form = $this->createFullForm();

        $client = $this->createAuthenticatedClient();
        $client->request(
            'DELETE',
            '/api/forms/' . $form->getId()
        );

        $this->assertHttpStatusCode(204, $client->getResponse());

        // Test 404 for removed item
        $client = $this->createAuthenticatedClient();
        $client->request(
            'GET',
            '/api/forms/1'
        );

        $this->assertHttpStatusCode(404, $client->getResponse());
    }

    public function testDeleteNotFound()
    {
        $client = $this->createAuthenticatedClient();
        $client->request(
            'DELETE',
            '/api/forms/2'
        );

        $this->assertHttpStatusCode(404, $client->getResponse());
    }

    private function assertMinimalForm($response)
    {
        $this->assertNotNull($response['id']);
        $this->assertEquals('en', $response['locale']);
        $this->assertEquals('Title', $response['title']);
        $this->assertArrayNotHasKey('submitLabel', $response);
        $this->assertArrayNotHasKey('successText', $response);
        // Email Settings
        $this->assertArrayNotHasKey('subject', $response);
        $this->assertFalse($response['replyTo']);
        $this->assertFalse($response['deactivateCustomerMails']);
        $this->assertFalse($response['deactivateNotifyMails']);
        $this->assertFalse($response['sendAttachments']);
        $this->assertArrayNotHasKey('fromEmail', $response);
        $this->assertArrayNotHasKey('toEmail', $response);
        $this->assertArrayNotHasKey('fromName', $response);
        $this->assertArrayNotHasKey('toName', $response);
        $this->assertArrayNotHasKey('mailText', $response);
        // Fields
        $this->assertCount(0, $response['fields']);
        // Receivers
        $this->assertCount(0, $response['receivers']);
        // Other fields
        $this->assertCountFields(9, $response);
    }

    private function assertFullForm($response)
    {
        $this->assertNotNull($response['id']);
        $this->assertEquals('en', $response['locale']);
        $this->assertEquals('Title', $response['title']);
        $this->assertEquals('Submit Label', $response['submitLabel']);
        $this->assertEquals('<p>Success Text</p>', $response['successText']);
        // Email Settings
        $this->assertEquals('Subject', $response['subject']);
        $this->assertTrue($response['replyTo']);
        $this->assertTrue($response['deactivateCustomerMails']);
        $this->assertTrue($response['deactivateNotifyMails']);
        $this->assertTrue($response['sendAttachments']);
        $this->assertEquals('from@example.org', $response['fromEmail']);
        $this->assertEquals('to@example.org', $response['toEmail']);
        $this->assertEquals('From', $response['fromName']);
        $this->assertEquals('To', $response['toName']);
        $this->assertEquals('<p>Mail Text</p>', $response['mailText']);
        // Fields
        $expectedFieldTypess = ['email', 'email'];
        $this->assertCount(count($expectedFieldTypess), $response['fields']);
        foreach ($expectedFieldTypess as $key => $type) {
            $this->assertNotNull($response['fields'][$key]['id']);
            $this->assertEquals($type, $response['fields'][$key]['type']);
            $this->assertContains($type, $response['fields'][$key]['key']);
            $this->assertTrue($response['fields'][$key]['required']);
            $this->assertEquals($key + 1, $response['fields'][$key]['order']);
            $this->assertEquals('full', $response['fields'][$key]['width']);
            $this->assertEquals('Title', $response['fields'][$key]['title']);
            $this->assertEquals('Short Title', $response['fields'][$key]['shortTitle']);
            $this->assertEquals('Placeholder', $response['fields'][$key]['placeholder']);
            $this->assertEquals('Default Value', $response['fields'][$key]['defaultValue']);
            $this->assertCountFields(10, $response['fields'][$key]);
        }
        // Receivers
        $this->assertCount(3, $response['receivers']);
        foreach (['to', 'cc', 'bcc'] as $key => $receiver) {
            $this->assertNotNull($response['receivers'][$key]['id']);
            $this->assertEquals(ucfirst($receiver) . ' Receiver', $response['receivers'][$key]['name']);
            $this->assertEquals($receiver . '-receiver@example.org', $response['receivers'][$key]['email']);
            $this->assertEquals($receiver, $response['receivers'][$key]['type']);
            $this->assertCountFields(4, $response['receivers'][$key]);
        }
        // Other
        $this->assertCountFields(17, $response);
    }

    private function assertCountFields($expectedCount, $haystack)
    {
        $this->assertCount(
            $expectedCount,
            $haystack,
            'Field missing. Did you forget to add a new fields to the test case?'
        );
    }

    private function createMinimalForm()
    {
        $form = new Form();
        $form->setDefaultLocale('en');

        $formTranslation = new FormTranslation();
        $formTranslation->setLocale('en');
        $formTranslation->setTitle('Title');

        $this->em->persist($form);
        $this->em->flush();

        return $form;
    }

    private function createFullForm()
    {
        $form = new Form();
        $form->setDefaultLocale('en');

        $formTranslation = new FormTranslation();
        $formTranslation->setLocale('en');
        $formTranslation->setTitle('Title');
        $formTranslation->setSubmitLabel('Submit Label');
        $formTranslation->setSuccessText('<p>Success Text</p>');
        // Email Settings
        $formTranslation->setSubject('Subject');
        $formTranslation->setReplyTo(true);
        $formTranslation->setDeactivateCustomerMails(true);
        $formTranslation->setDeactivateNotifyMails(true);
        $formTranslation->setSendAttachments(true);
        $formTranslation->setFromEmail('from@example.org');
        $formTranslation->setFromName('From');
        $formTranslation->setToEmail('to@example.org');
        $formTranslation->setToName('To');
        $formTranslation->setMailText('<p>Mail Text</p>');
        // Field 1
        $formField = new FormField();
        $formField->setDefaultLocale('en');
        $formField->setKey('email');
        $formField->setType('email');
        $formField->setWidth('full');
        $formField->setRequired(true);
        $formField->setOrder(1);
        $formFieldTranslation = new FormFieldTranslation();
        $formFieldTranslation->setShortTitle('Short Title');
        $formFieldTranslation->setTitle('Title');
        $formFieldTranslation->setPlaceholder('Placeholder');
        $formFieldTranslation->setDefaultValue('Default Value');
        $formFieldTranslation->setLocale('en');
        $formFieldTranslation->setOptions([]);

        $formFieldTranslation->setField($formField);
        $formField->addTranslation($formFieldTranslation);

        $formField->setForm($form);
        $form->addField($formField);

        // Field 2
        $formField2 = new FormField();
        $formField2->setDefaultLocale('en');
        $formField2->setKey('email1');
        $formField2->setType('email');
        $formField2->setWidth('full');
        $formField2->setRequired(true);
        $formField2->setOrder(2);
        $formFieldTranslation2 = new FormFieldTranslation();
        $formFieldTranslation2->setShortTitle('Short Title');
        $formFieldTranslation2->setTitle('Title');
        $formFieldTranslation2->setPlaceholder('Placeholder');
        $formFieldTranslation2->setDefaultValue('Default Value');
        $formFieldTranslation2->setLocale('en');
        $formFieldTranslation2->setOptions([]);

        $formFieldTranslation2->setField($formField2);
        $formField2->addTranslation($formFieldTranslation2);

        $formField2->setForm($form);
        $form->addField($formField2);

        // Receivers
        $toReceiver = new FormTranslationReceiver();
        $toReceiver->setEmail('to-receiver@example.org');
        $toReceiver->setName('To Receiver');
        $toReceiver->setType(MailConfiguration::TYPE_TO);
        $toReceiver->setFormTranslation($formTranslation);

        $ccReceiver = new FormTranslationReceiver();
        $ccReceiver->setEmail('cc-receiver@example.org');
        $ccReceiver->setName('Cc Receiver');
        $ccReceiver->setType(MailConfiguration::TYPE_CC);
        $ccReceiver->setFormTranslation($formTranslation);

        $bccReceiver = new FormTranslationReceiver();
        $bccReceiver->setEmail('bcc-receiver@example.org');
        $bccReceiver->setName('Bcc Receiver');
        $bccReceiver->setType(MailConfiguration::TYPE_BCC);
        $bccReceiver->setFormTranslation($formTranslation);

        $formTranslation->setReceivers([$toReceiver, $ccReceiver, $bccReceiver]);

        $formTranslation->setForm($form);
        $form->addTranslation($formTranslation);

        $formField->setForm($form);
        $form->addField($formField);

        $this->em->persist($form);
        $this->em->flush();

        return $form;
    }

    private function getFullFormData()
    {
        return [
            'locale' => 'en',
            'title' => 'Title',
            'submitLabel' => 'Submit Label',
            'successText' => '<p>Success Text</p>',
            'subject' => 'Subject',
            'replyTo' => true,
            'deactivateCustomerMails' => true,
            'deactivateNotifyMails' => true,
            'sendAttachments' => true,
            'fromEmail' => 'from@example.org',
            'toEmail' => 'to@example.org',
            'fromName' => 'From',
            'toName' => 'To',
            'mailText' => '<p>Mail Text</p>',
            'fields' => [
                [
                    'type' => 'email',
                    'title' => 'Title',
                    'shortTitle' => 'Short Title',
                    'placeholder' => 'Placeholder',
                    'defaultValue' => 'Default Value',
                    'width' => 'full',
                    'required' => true,
                ],
                [
                    'type' => 'email',
                    'title' => 'Title',
                    'shortTitle' => 'Short Title',
                    'placeholder' => 'Placeholder',
                    'defaultValue' => 'Default Value',
                    'width' => 'full',
                    'required' => true,
                ],
            ],
            'receivers' => [
                [
                    'type' => MailConfiguration::TYPE_TO,
                    'name' => 'To Receiver',
                    'email' => 'to-receiver@example.org',
                ],
                [
                    'type' => MailConfiguration::TYPE_CC,
                    'name' => 'Cc Receiver',
                    'email' => 'cc-receiver@example.org',
                ],
                [
                    'type' => MailConfiguration::TYPE_BCC,
                    'name' => 'Bcc Receiver',
                    'email' => 'bcc-receiver@example.org',
                ],
            ],
        ];
    }
}
