<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Mail;

use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;

/**
 * @deprecated
 */
class HelperTest extends HelperTestCase
{
    public function testSendsEmailUsingSwiftmailer()
    {
        if (!\class_exists(SwiftmailerBundle::class)) {
            $this->markTestSkipped('Swiftmailer is not installed.');
        }

        $formTranslationRepository = $this->entityManager->getRepository(FormTranslation::class);
        /** @var FormTranslation $formTranslation */
        $formTranslation = $formTranslationRepository->findOneBy(['title' => 'Title', 'locale' => 'de']);
        $form = $formTranslation->getForm();

        $this->updateHomePage($form);
        $this->doSendForm($form);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        // 2 messages should be send 1 to admin and 1 to email
        $this->assertSame(2, $mailCollector->getMessageCount());

        $this->assertEmailCount(0);
    }
}
