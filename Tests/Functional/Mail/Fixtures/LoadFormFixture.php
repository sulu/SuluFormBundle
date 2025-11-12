<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Mail\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Sulu\Bundle\FormBundle\Configuration\MailConfiguration;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;

class LoadFormFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $form = new Form();
        $form->setDefaultLocale('de');

        $formTranslation = new FormTranslation();
        $formTranslation->setLocale('de');
        $formTranslation->setTitle('Title');
        $formTranslation->setSubmitLabel('Submit Label');
        $formTranslation->setSuccessText('<p>Success Text</p>');
        // Email Settings
        $formTranslation->setSubject('Subject');
        $formTranslation->setReplyTo(true);
        $formTranslation->setDeactivateCustomerMails(false);
        $formTranslation->setDeactivateNotifyMails(false);
        $formTranslation->setSendAttachments(true);
        $formTranslation->setDeactivateAttachmentSave(true);
        $formTranslation->setFromEmail('from@example.org');
        $formTranslation->setFromName('From');
        $formTranslation->setToEmail('to@example.org');
        $formTranslation->setToName('To');
        $formTranslation->setMailText('<p>Mail Text</p>');
        // Field 1
        $formField = new FormField();
        $formField->setDefaultLocale('de');
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
        $formFieldTranslation->setLocale('de');
        $formFieldTranslation->setOptions([]);

        $formFieldTranslation->setField($formField);
        $formField->addTranslation($formFieldTranslation);

        $formField->setForm($form);
        $form->addField($formField);

        // Field 2
        $formField2 = new FormField();
        $formField2->setDefaultLocale('de');
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
        $formFieldTranslation2->setLocale('de');
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

        $manager->persist($form);
    }
}
