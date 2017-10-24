<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit\Configuration;

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
class FormConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildByDynamic()
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
            'SuluFormBundle:mails:notify.html.twig',
            'SuluFormBundle:mails:customer.html.twig'
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
        $this->assertEquals([], $adminMailConfiguration->getBcc());
        $this->assertEquals(['to@example.dev' => 'To'], $adminMailConfiguration->getTo());
        $this->assertEquals([['receiver@example.dev' => 'receiver']], $adminMailConfiguration->getCc());
    }

    private function createDynamic()
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
        $formTranslation->getReplyTo()->willReturn(true);
        $formTranslation->getSubject()->willReturn('Subject');
        $formTranslation->getFromEmail()->willReturn('from@example.dev');
        $formTranslation->getFromName()->willReturn('From');
        $formTranslation->getToEmail()->willReturn('to@example.dev');
        $formTranslation->getToName()->willReturn('To');
        /** @var FormTranslationReceiver $receiver */
        $receiver = $this->prophesize(FormTranslationReceiver::class);
        $receiver->setName('Receiver');
        $receiver->setEmail('receiver@example.dev');
        $receiver->setType(MailConfigurationInterface::TYPE_CC);
        $formTranslation->getReceivers()->willReturn([$receiver]);
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
