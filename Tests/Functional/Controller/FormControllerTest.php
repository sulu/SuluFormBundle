<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\ActivityBundle\Domain\Model\ActivityInterface;
use Sulu\Bundle\FormBundle\Configuration\MailConfiguration;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Sulu\Bundle\TrashBundle\Domain\Model\TrashItemInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class FormControllerTest extends SuluTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createAuthenticatedClient();
        $this->purgeDatabase();
        $this->em = $this->getEntityManager();
    }

    public function testListMetadata(): void
    {
        $this->client->request(
            'GET',
            '/admin/metadata/list/forms'
        );

        $this->assertHttpStatusCode(200, $this->client->getResponse());
    }

    public function testFormMetadata(): void
    {
        $this->client->request(
            'GET',
            '/admin/metadata/form/form_details'
        );

        $this->assertHttpStatusCode(200, $this->client->getResponse());
    }

    public function testGetNotFound(): void
    {
        $this->client->request(
            'GET',
            '/admin/api/forms/1'
        );

        $this->assertHttpStatusCode(404, $this->client->getResponse());
    }

    public function testGet(): void
    {
        $form = $this->createFullForm();

        $this->client->request(
            'GET',
            '/admin/api/forms/' . $form->getId()
        );

        $this->assertHttpStatusCode(200, $this->client->getResponse());
        $response = \json_decode($this->client->getResponse()->getContent(), true);

        $this->assertFullForm($response);
    }

    public function testPostMinimal(): void
    {
        $this->client->request(
            'POST',
            '/admin/api/forms',
            [
                'locale' => 'en',
                'title' => 'Title',
                'toEmail' => 'testing@example.com',
                'fromEmail' => 'testing@example.com',
            ]
        );

        $this->assertHttpStatusCode(201, $this->client->getResponse());
        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertMinimalForm($response);

        $activity = $this->em->getRepository(ActivityInterface::class)->findOneBy(['type' => 'created']);
        $this->assertNotNull($activity);
        $this->assertSame((string) $response['id'], $activity->getResourceId());
    }

    public function testPostFull(): void
    {
        $this->client->request(
            'POST',
            '/admin/api/forms',
            $this->getFullFormData()
        );

        $this->assertHttpStatusCode(201, $this->client->getResponse());
        $response = \json_decode($this->client->getResponse()->getContent(), true);

        $this->assertFullForm($response);
    }

    public function testPostTriggerNotFound(): void
    {
        $this->client->request(
            'POST',
            '/admin/api/forms/2?action=copy'
        );

        $this->assertHttpStatusCode(404, $this->client->getResponse());
    }

    public function testPostTriggerInvalidAction(): void
    {
        $form = $this->createMinimalForm();

        $this->client->request(
            'POST',
            '/admin/api/forms/' . $form->getId() . '?action=not-an-action'
        );

        $this->assertHttpStatusCode(400, $this->client->getResponse());
    }

    public function testPostTriggerCopy(): void
    {
        $form = $this->createFullForm();

        $this->client->request(
            'POST',
            '/admin/api/forms/' . $form->getId() . '?action=copy'
        );

        $this->assertHttpStatusCode(200, $this->client->getResponse());
        $response = \json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals('Title (2)', $response['title']);
        $this->assertNotEquals($form->getId(), $response['id']);
        $response['title'] = \str_replace(' (2)', '', $response['title']);

        $this->assertFullForm($response);

        $activity = $this->em->getRepository(ActivityInterface::class)->findOneBy(['type' => 'copied']);
        $this->assertNotNull($activity);
        $this->assertSame((string) $response['id'], $activity->getResourceId());
    }

    public function testPutMinimal(): void
    {
        $form = $this->createFullForm();
        $this->client->request(
            'PUT',
            '/admin/api/forms/' . $form->getId(),
            [
                'locale' => 'en',
                'title' => 'Title',
                'toEmail' => 'testing@example.com',
                'fromEmail' => 'testing@example.com',
            ]
        );

        $this->assertHttpStatusCode(200, $this->client->getResponse());
        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertMinimalForm($response);

        $activity = $this->em->getRepository(ActivityInterface::class)->findOneBy(['type' => 'modified']);
        $this->assertNotNull($activity);
        $this->assertSame((string) $response['id'], $activity->getResourceId());
    }

    public function testPutFull(): void
    {
        $form = $this->createMinimalForm();
        $this->client->request(
            'PUT',
            '/admin/api/forms/' . $form->getId(),
            $this->getFullFormData()
        );

        $this->assertHttpStatusCode(200, $this->client->getResponse());
        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertFullForm($response);
    }

    public function testPutNotExist(): void
    {
        $this->client->request(
            'PUT',
            '/admin/api/forms/2',
            $this->getFullFormData()
        );

        $this->assertHttpStatusCode(404, $this->client->getResponse());
    }

    public function testDelete(): void
    {
        $form = $this->createFullForm();
        $formId = $form->getId();

        $this->client->request(
            'DELETE',
            '/admin/api/forms/' . $formId
        );

        $this->assertHttpStatusCode(204, $this->client->getResponse());

        // Test 404 for removed item
        $this->client->request(
            'GET',
            '/admin/api/forms/1'
        );

        $this->assertHttpStatusCode(404, $this->client->getResponse());

        $activity = $this->em->getRepository(ActivityInterface::class)->findOneBy(['type' => 'removed']);
        $this->assertNotNull($activity);
        $this->assertSame((string) $formId, $activity->getResourceId());

        $trashItemRepository = $this->em->getRepository(TrashItemInterface::class);
        $trashItem = $trashItemRepository->findOneBy(['resourceKey' => Form::RESOURCE_KEY, 'resourceId' => $formId]);
        $this->assertNotNull($trashItem);
    }

    public function testDeleteNotFound(): void
    {
        $this->client->request(
            'DELETE',
            '/admin/api/forms/2'
        );

        $this->assertHttpStatusCode(404, $this->client->getResponse());
    }

    private function assertMinimalForm($response)
    {
        $this->assertNotNull($response['id']);
        $this->assertEquals('en', $response['locale']);
        $this->assertEquals('Title', $response['title']);
        $this->assertNull($response['submitLabel']);
        $this->assertNull($response['successText']);
        // Email Settings
        $this->assertNull($response['subject']);
        $this->assertFalse($response['replyTo']);
        $this->assertFalse($response['deactivateCustomerMails']);
        $this->assertFalse($response['deactivateNotifyMails']);
        $this->assertFalse($response['sendAttachments']);
        $this->assertFalse($response['deactivateAttachmentSave']);
        $this->assertEquals('testing@example.com', $response['fromEmail']);
        $this->assertEquals('testing@example.com', $response['toEmail']);
        $this->assertNull($response['fromName']);
        $this->assertNull($response['toName']);
        $this->assertNull($response['submitLabel']);
        // Fields
        $this->assertCount(0, $response['fields']);
        // Receivers
        $this->assertCount(0, $response['receivers']);
        // Other fields
        $this->assertCountFields(18, $response);
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
        $this->assertTrue($response['deactivateAttachmentSave']);
        $this->assertEquals('from@example.org', $response['fromEmail']);
        $this->assertEquals('to@example.org', $response['toEmail']);
        $this->assertEquals('From', $response['fromName']);
        $this->assertEquals('To', $response['toName']);
        $this->assertEquals('<p>Mail Text</p>', $response['mailText']);
        // Fields
        $expectedFieldTypes = ['email', 'email'];
        $this->assertCount(\count($expectedFieldTypes), $response['fields']);
        foreach ($expectedFieldTypes as $key => $type) {
            $this->assertNotNull($response['fields'][$key]['id']);
            $this->assertEquals($type, $response['fields'][$key]['type']);
            $this->assertStringContainsString($type, $response['fields'][$key]['key']);
            $this->assertTrue($response['fields'][$key]['required']);
            $this->assertEquals($key + 1, $response['fields'][$key]['order']);
            $this->assertEquals('full', $response['fields'][$key]['width']);
            $this->assertEquals('Title', $response['fields'][$key]['title']);
            $this->assertEquals('Short Title', $response['fields'][$key]['shortTitle']);
            $this->assertEquals('Placeholder', $response['fields'][$key]['placeholder']);
            $this->assertEquals('Default Value', $response['fields'][$key]['defaultValue']);
            $this->assertNotNull($response['fields'][$key]['options']);
            $this->assertCountFields(11, $response['fields'][$key]);
        }
        // Receivers
        $this->assertCount(3, $response['receivers']);
        foreach (['to', 'cc', 'bcc'] as $key => $expectedType) {
            $foundExpectedType = false;
            foreach ($response['receivers'] as $receiver) {
                if ($expectedType === $receiver['type']) {
                    $foundExpectedType = true;
                    $this->assertNotNull($receiver['id']);
                    $this->assertEquals(\ucfirst($expectedType) . ' Receiver', $receiver['name']);
                    $this->assertEquals($expectedType . '-receiver@example.org', $receiver['email']);
                    $this->assertEquals($expectedType, $receiver['type']);
                    $this->assertCountFields(4, $receiver);
                }
            }

            $this->assertTrue($foundExpectedType);
        }
        // Other
        $this->assertCountFields(18, $response);
    }

    private function assertCountFields($expectedCount, $haystack): void
    {
        $this->assertCount(
            $expectedCount,
            $haystack,
            'Field missing. Did you forget to add a new fields to the test case?'
        );
    }

    private function createMinimalForm(): Form
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

    private function createFullForm(): Form
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
        $formTranslation->setDeactivateAttachmentSave(true);
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

        $formTranslation->addReceiver($toReceiver);
        $formTranslation->addReceiver($ccReceiver);
        $formTranslation->addReceiver($bccReceiver);

        $formTranslation->setForm($form);
        $form->addTranslation($formTranslation);

        $formField->setForm($form);

        $this->em->persist($form);
        $this->em->flush();
        $this->em->clear();

        return $form;
    }

    private function getFullFormData(): array
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
            'deactivateAttachmentSave' => true,
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
