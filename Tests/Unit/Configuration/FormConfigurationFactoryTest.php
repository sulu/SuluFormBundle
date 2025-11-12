<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory;
use Sulu\Bundle\FormBundle\Configuration\MailConfigurationInterface;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\FormBundle\Media\CollectionStrategyInterface;

/**
 * Test for the form configuration factory.
 */
class FormConfigurationFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testBuildByDynamic(): void
    {
        $dynamic = $this->createDynamic();

        $collectionStrategy = $this->prophesize(CollectionStrategyInterface::class);
        $collectionStrategy->getCollectionId(
            1,
            'Form Title',
            'page',
            2,
            'en'
        )->willReturn(10);

        $formConfigurationFactory = new FormConfigurationFactory(
            $collectionStrategy->reveal(),
            '@SuluForm/mails/notify.html.twig',
            '@SuluForm/mails/customer.html.twig',
            '@SuluForm/mails/notify_plain_text.html.twig',
            '@SuluForm/mails/customer_plain_text.html.twig'
        );

        $formConfiguration = $formConfigurationFactory->buildByDynamic($dynamic);

        $this->assertEquals('en', $formConfiguration->getLocale());
        $this->assertTrue($formConfiguration->getSave());
        $this->assertEquals(['attachment' => 10], $formConfiguration->getFileFields());

        $adminMailConfiguration = $formConfiguration->getAdminMailConfiguration();
        $websiteMailConfiguration = $formConfiguration->getWebsiteMailConfiguration();

        $this->assertNotNull($adminMailConfiguration);
        $this->assertNotNull($websiteMailConfiguration);

        $this->assertEquals('en', $adminMailConfiguration->getLocale());
        $this->assertEquals('Subject', $adminMailConfiguration->getSubject());
        $this->assertEquals(['customer@example.dev' => 'customer@example.dev'], $adminMailConfiguration->getReplyTo());
        $this->assertEquals(true, $adminMailConfiguration->getAddAttachments());
        $this->assertEquals(['from@example.dev' => 'From'], $adminMailConfiguration->getFrom());
        $this->assertEquals(['to@example.dev' => 'To', 'to2@example.dev' => 'To2'], $adminMailConfiguration->getTo());
        $this->assertEquals(['cc@example.dev' => 'Cc'], $adminMailConfiguration->getCc());
        $this->assertEquals(['bcc@example.dev' => 'Bcc'], $adminMailConfiguration->getBcc());

        $this->assertEquals('en', $websiteMailConfiguration->getLocale());
        $this->assertEquals('Subject', $websiteMailConfiguration->getSubject());
        $this->assertEquals(null, $websiteMailConfiguration->getReplyTo());
        $this->assertEquals(true, $websiteMailConfiguration->getAddAttachments());
        $this->assertEquals(['from@example.dev' => 'From'], $websiteMailConfiguration->getFrom());
        $this->assertEquals(['customer@example.dev' => 'customer@example.dev'], $websiteMailConfiguration->getTo());
        $this->assertEquals([], $websiteMailConfiguration->getCc());
        $this->assertEquals([], $websiteMailConfiguration->getBcc());
    }

    private function createDynamic(): Dynamic
    {
        /** @var Dynamic $dynamic */
        $dynamic = $this->prophesize(Dynamic::class);
        $dynamic->getLocale()->willReturn('en');
        $dynamic->getType()->willReturn('page');
        $dynamic->getTypeId()->willReturn(2);
        $dynamic->getLocale()->willReturn('en');
        /** @var Form $form */
        $form = $this->prophesize(Form::class);
        $form->getId()->willReturn(1);
        /** @var FormTranslation $formTranslation */
        $formTranslation = $this->prophesize(FormTranslation::class);
        $formTranslation->getTitle()->willReturn('Form Title');
        $formTranslation->getDeactivateNotifyMails()->willReturn(false);
        $formTranslation->getDeactivateCustomerMails()->willReturn(false);
        $formTranslation->getSendAttachments()->willReturn(true);
        $formTranslation->getDeactivateAttachmentSave()->willReturn(false);
        $formTranslation->getReplyTo()->willReturn(true);
        $formTranslation->getSubject()->willReturn('Subject');
        $formTranslation->getFromEmail()->willReturn('from@example.dev');
        $formTranslation->getFromName()->willReturn('From');
        $formTranslation->getToEmail()->willReturn('to@example.dev');
        $formTranslation->getToName()->willReturn('To');
        /** @var FormTranslationReceiver $receiver */
        $toReceiver = $this->prophesize(FormTranslationReceiver::class);
        $toReceiver->getName()->willReturn('To2');
        $toReceiver->getEmail()->willReturn('to2@example.dev');
        $toReceiver->getType()->willReturn(MailConfigurationInterface::TYPE_TO);
        /** @var FormTranslationReceiver $receiver */
        $ccReceiver = $this->prophesize(FormTranslationReceiver::class);
        $ccReceiver->getName()->willReturn('Cc');
        $ccReceiver->getEmail()->willReturn('cc@example.dev');
        $ccReceiver->getType()->willReturn(MailConfigurationInterface::TYPE_CC);
        /** @var FormTranslationReceiver $receiver */
        $bccReceiver = $this->prophesize(FormTranslationReceiver::class);
        $bccReceiver->getName()->willReturn('Bcc');
        $bccReceiver->getEmail()->willReturn('bcc@example.dev');
        $bccReceiver->getType()->willReturn(MailConfigurationInterface::TYPE_BCC);
        $formTranslation->getReceivers()->willReturn([$toReceiver->reveal(), $ccReceiver->reveal(), $bccReceiver->reveal()]);
        $form->getTranslation('en', false, true)->willReturn($formTranslation->reveal());
        $form->getTranslation('en')->willReturn($formTranslation->reveal());
        /** @var FormField $formAttachmentField */
        $formAttachmentField = $this->prophesize(FormField::class);
        $formAttachmentField->getKey()->willReturn('attachment');
        $form->getFieldsByType(Dynamic::TYPE_ATTACHMENT)->willReturn([$formAttachmentField->reveal()]);
        $dynamic->getFieldsByType(Dynamic::TYPE_EMAIL)->willReturn(['email' => 'customer@example.dev']);
        $form->serializeForLocale('en', $dynamic->reveal())->willReturn([]);
        $dynamic->getForm()->willReturn($form->reveal());

        return $dynamic->reveal();
    }
}
