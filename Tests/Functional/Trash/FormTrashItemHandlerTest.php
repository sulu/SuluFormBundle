<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Trash;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Configuration\MailConfiguration;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\FormBundle\Trash\FormTrashItemHandler;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class FormTrashItemHandlerTest extends SuluTestCase
{
    /**
     * @var FormTrashItemHandler
     */
    private $formTrashItemHandler;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function setUp(): void
    {
        static::purgeDatabase();
        $this->bootKernelAndSetServices();
    }

    public function bootKernelAndSetServices(): void
    {
        static::bootKernel();

        $this->formTrashItemHandler = static::getContainer()->get('sulu_form.form_trash_item_handler');
        $this->entityManager = static::getEntityManager();
    }

    public function testStoreAndRestore(): void
    {
        $form1 = new Form();
        $form1->setDefaultLocale('en');

        $form1TranslationEn = new FormTranslation();
        $form1TranslationEn->setForm($form1);
        $form1->addTranslation($form1TranslationEn);
        $form1TranslationEn->setLocale('en');
        $form1TranslationEn->setTitle('First Form');
        $form1TranslationEn->setSubmitLabel('Submit');
        $form1TranslationEn->setSuccessText('<p>Success</p>');
        $form1TranslationEn->setSubject('Subject');
        $form1TranslationEn->setReplyTo(true);
        $form1TranslationEn->setDeactivateCustomerMails(true);
        $form1TranslationEn->setDeactivateNotifyMails(true);
        $form1TranslationEn->setSendAttachments(true);
        $form1TranslationEn->setDeactivateAttachmentSave(true);
        $form1TranslationEn->setFromEmail('from@example.org');
        $form1TranslationEn->setFromName('From');
        $form1TranslationEn->setToEmail('to@example.org');
        $form1TranslationEn->setToName('To');
        $form1TranslationEn->setMailText('<p>Mail Text</p>');

        $toReceiver = new FormTranslationReceiver();
        $toReceiver->setFormTranslation($form1TranslationEn);
        $form1TranslationEn->addReceiver($toReceiver);
        $toReceiver->setEmail('to-receiver@example.org');
        $toReceiver->setName('To Receiver');
        $toReceiver->setType(MailConfiguration::TYPE_TO);

        $ccReceiver = new FormTranslationReceiver();
        $ccReceiver->setFormTranslation($form1TranslationEn);
        $form1TranslationEn->addReceiver($ccReceiver);
        $ccReceiver->setEmail('cc-receiver@example.org');
        $ccReceiver->setName('Cc Receiver');
        $ccReceiver->setType(MailConfiguration::TYPE_CC);

        $form1TranslationDe = new FormTranslation();
        $form1TranslationDe->setForm($form1);
        $form1->addTranslation($form1TranslationDe);
        $form1TranslationDe->setLocale('de');
        $form1TranslationDe->setTitle('Erstes Formular');
        $form1TranslationDe->setSubmitLabel('Bestätigen');
        $form1TranslationDe->setSuccessText('<p>Erfolg</p>');
        $form1TranslationDe->setSubject('Betreff');
        $form1TranslationDe->setReplyTo(true);
        $form1TranslationDe->setDeactivateCustomerMails(false);
        $form1TranslationDe->setDeactivateNotifyMails(false);
        $form1TranslationDe->setSendAttachments(false);
        $form1TranslationDe->setDeactivateAttachmentSave(true);
        $form1TranslationDe->setFromEmail('from@example.org');
        $form1TranslationDe->setFromName('Von');
        $form1TranslationDe->setToEmail('to@example.org');
        $form1TranslationDe->setToName('Zu');
        $form1TranslationDe->setMailText('<p>Mail Text</p>');

        $formField1 = new FormField();
        $formField1->setForm($form1);
        $form1->addField($formField1);
        $formField1->setDefaultLocale('en');
        $formField1->setKey('email');
        $formField1->setType('email');
        $formField1->setWidth('full');
        $formField1->setRequired(true);
        $formField1->setOrder(1);

        $formField1TranslationEn = new FormFieldTranslation();
        $formField1TranslationEn->setField($formField1);
        $formField1->addTranslation($formField1TranslationEn);
        $formField1TranslationEn->setShortTitle('Short Title');
        $formField1TranslationEn->setTitle('Title');
        $formField1TranslationEn->setPlaceholder('Placeholder');
        $formField1TranslationEn->setDefaultValue('Default Value');
        $formField1TranslationEn->setLocale('en');
        $formField1TranslationEn->setOptions([
            'test-key' => 'test-value',
        ]);

        $formField1TranslationDe = new FormFieldTranslation();
        $formField1TranslationDe->setField($formField1);
        $formField1->addTranslation($formField1TranslationDe);
        $formField1TranslationDe->setShortTitle('Kurzer Titel');
        $formField1TranslationDe->setTitle('Titel');
        $formField1TranslationDe->setPlaceholder('Platzhalter');
        $formField1TranslationDe->setDefaultValue('Standardwert');
        $formField1TranslationDe->setLocale('de');
        $formField1TranslationDe->setOptions([]);

        $formField2 = new FormField();
        $formField2->setForm($form1);
        $form1->addField($formField2);
        $formField2->setDefaultLocale('en');
        $formField2->setKey('email1');
        $formField2->setType('email');
        $formField2->setWidth('full');
        $formField2->setRequired(false);
        $formField2->setOrder(2);

        $formField2Translation = new FormFieldTranslation();
        $formField2Translation->setField($formField2);
        $formField2->addTranslation($formField2Translation);
        $formField2Translation->setShortTitle('Short Title');
        $formField2Translation->setTitle('Title');
        $formField2Translation->setPlaceholder('Placeholder');
        $formField2Translation->setDefaultValue('Default Value');
        $formField2Translation->setLocale('en');
        $formField2Translation->setOptions([]);

        // create second form to check if id of first form is restored correctly
        $form2 = new Form();
        $form2->setDefaultLocale('en');

        $form2TranslationEn = new FormTranslation();
        $form2TranslationEn->setForm($form1);
        $form2->addTranslation($form2TranslationEn);
        $form2TranslationEn->setLocale('en');
        $form2TranslationEn->setTitle('Title');

        $this->entityManager->persist($form1);
        $this->entityManager->persist($form2);
        $this->entityManager->flush();
        $originalFormId = $form1->getId();
        static::assertCount(2, $this->entityManager->getRepository(Form::class)->findAll());

        $trashItem = $this->formTrashItemHandler->store($form1);
        $this->entityManager->remove($form1);
        $this->entityManager->flush();
        static::assertSame($originalFormId, (int) $trashItem->getResourceId());
        static::assertSame('First Form', $trashItem->getResourceTitle());
        static::assertSame('First Form', $trashItem->getResourceTitle('en'));
        static::assertSame('Erstes Formular', $trashItem->getResourceTitle('de'));
        static::assertCount(1, $this->entityManager->getRepository(Form::class)->findAll());

        // the FormTrashItemHandler::restore method changes the id generator for the entity to restore the original id
        // this works only if no entity of the same type was persisted before, because doctrine caches the insert sql
        // to clear the cached insert statement, we need to reboot the kernel of the application
        // this problem does not occur during normal usage because restoring is a separate request with a fresh kernel
        $this->bootKernelAndSetServices();

        /** @var Form $restoredForm */
        $restoredForm = $this->formTrashItemHandler->restore($trashItem, []);
        static::assertCount(2, $this->entityManager->getRepository(Form::class)->findAll());
        static::assertSame($originalFormId, $restoredForm->getId());
        static::assertSame('en', $restoredForm->getDefaultLocale());
        static::assertCount(2, $restoredForm->getTranslations());
        static::assertCount(2, $restoredForm->getFields());

        /** @var FormTranslation $restoredTranslationEn */
        $restoredTranslationEn = $restoredForm->getTranslation('en');
        static::assertSame('First Form', $restoredTranslationEn->getTitle());
        static::assertSame('Subject', $restoredTranslationEn->getSubject());
        static::assertSame('from@example.org', $restoredTranslationEn->getFromEmail());
        static::assertSame('From', $restoredTranslationEn->getFromName());
        static::assertSame('to@example.org', $restoredTranslationEn->getToEmail());
        static::assertSame('To', $restoredTranslationEn->getToName());
        static::assertSame('<p>Mail Text</p>', $restoredTranslationEn->getMailText());
        static::assertSame('Submit', $restoredTranslationEn->getSubmitLabel());
        static::assertSame('<p>Success</p>', $restoredTranslationEn->getSuccessText());
        static::assertSame(true, $restoredTranslationEn->getSendAttachments());
        static::assertSame(true, $restoredTranslationEn->getDeactivateAttachmentSave());
        static::assertSame(true, $restoredTranslationEn->getDeactivateNotifyMails());
        static::assertSame(true, $restoredTranslationEn->getDeactivateCustomerMails());
        static::assertSame(true, $restoredTranslationEn->getReplyTo());
        static::assertCount(2, $restoredTranslationEn->getReceivers());

        /** @var FormTranslationReceiver $restoredReceiver1 */
        $restoredReceiver1 = $restoredTranslationEn->getReceivers()[0];
        static::assertSame(MailConfiguration::TYPE_TO, $restoredReceiver1->getType());
        static::assertSame('to-receiver@example.org', $restoredReceiver1->getEmail());
        static::assertSame('To Receiver', $restoredReceiver1->getName());

        /** @var FormTranslationReceiver $restoredReceiver2 */
        $restoredReceiver2 = $restoredTranslationEn->getReceivers()[1];
        static::assertSame(MailConfiguration::TYPE_CC, $restoredReceiver2->getType());
        static::assertSame('cc-receiver@example.org', $restoredReceiver2->getEmail());
        static::assertSame('Cc Receiver', $restoredReceiver2->getName());

        /** @var FormTranslation $restoredTranslationDe */
        $restoredTranslationDe = $restoredForm->getTranslation('de');
        static::assertSame('Erstes Formular', $restoredTranslationDe->getTitle());
        static::assertSame('Betreff', $restoredTranslationDe->getSubject());
        static::assertSame('from@example.org', $restoredTranslationDe->getFromEmail());
        static::assertSame('Von', $restoredTranslationDe->getFromName());
        static::assertSame('to@example.org', $restoredTranslationDe->getToEmail());
        static::assertSame('Zu', $restoredTranslationDe->getToName());
        static::assertSame('<p>Mail Text</p>', $restoredTranslationDe->getMailText());
        static::assertSame('Bestätigen', $restoredTranslationDe->getSubmitLabel());
        static::assertSame('<p>Erfolg</p>', $restoredTranslationDe->getSuccessText());
        static::assertSame(false, $restoredTranslationDe->getSendAttachments());
        static::assertSame(true, $restoredTranslationDe->getDeactivateAttachmentSave());
        static::assertSame(false, $restoredTranslationDe->getDeactivateNotifyMails());
        static::assertSame(false, $restoredTranslationDe->getDeactivateCustomerMails());
        static::assertSame(true, $restoredTranslationDe->getReplyTo());
        static::assertCount(0, $restoredTranslationDe->getReceivers());

        /** @var FormField $restoredField1 */
        $restoredField1 = $restoredForm->getFields()[0];
        static::assertSame('email', $restoredField1->getKey());
        static::assertSame('email', $restoredField1->getType());
        static::assertSame('full', $restoredField1->getWidth());
        static::assertSame(true, $restoredField1->getRequired());
        static::assertSame(1, $restoredField1->getOrder());
        static::assertSame('en', $restoredField1->getDefaultLocale());
        static::assertCount(2, $restoredField1->getTranslations());

        /** @var FormFieldTranslation $restoredField1TranslationEn */
        $restoredField1TranslationEn = $restoredField1->getTranslation('en');
        static::assertSame('Title', $restoredField1TranslationEn->getTitle());
        static::assertSame('en', $restoredField1TranslationEn->getLocale());
        static::assertSame('Placeholder', $restoredField1TranslationEn->getPlaceholder());
        static::assertSame('Default Value', $restoredField1TranslationEn->getDefaultValue());
        static::assertSame('Short Title', $restoredField1TranslationEn->getShortTitle());
        static::assertSame([
            'test-key' => 'test-value',
        ], $restoredField1TranslationEn->getOptions());

        $restoredField1TranslationDe = $restoredField1->getTranslation('de');
        static::assertSame('Titel', $restoredField1TranslationDe->getTitle());
        static::assertSame('de', $restoredField1TranslationDe->getLocale());
        static::assertSame('Platzhalter', $restoredField1TranslationDe->getPlaceholder());
        static::assertSame('Standardwert', $restoredField1TranslationDe->getDefaultValue());
        static::assertSame('Kurzer Titel', $restoredField1TranslationDe->getShortTitle());
        static::assertSame([], $restoredField1TranslationDe->getOptions());

        /** @var FormField $restoredField2 */
        $restoredField2 = $restoredForm->getFields()[1];
        static::assertSame('email1', $restoredField2->getKey());
        static::assertSame('email', $restoredField2->getType());
        static::assertSame('full', $restoredField2->getWidth());
        static::assertSame(false, $restoredField2->getRequired());
        static::assertSame(2, $restoredField2->getOrder());
        static::assertSame('en', $restoredField2->getDefaultLocale());
        static::assertCount(1, $restoredField2->getTranslations());

        /** @var FormFieldTranslation $restoredField2TranslationEn */
        $restoredField2TranslationEn = $restoredField2->getTranslation('en');
        static::assertSame('Title', $restoredField2TranslationEn->getTitle());
        static::assertSame('en', $restoredField2TranslationEn->getLocale());
        static::assertSame('Placeholder', $restoredField2TranslationEn->getPlaceholder());
        static::assertSame('Default Value', $restoredField2TranslationEn->getDefaultValue());
        static::assertSame('Short Title', $restoredField2TranslationEn->getShortTitle());
        static::assertSame([], $restoredField2TranslationEn->getOptions());
    }
}
