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
use Sulu\Bundle\FormBundle\Tests\Application\MailerKernel;

class MailerHelperTest extends HelperTestCase
{
    protected function setUp(): void
    {
        static::$class = MailerKernel::class;
        static::$kernel = null; // requires as Symfony 4.4 does not unset on tearDown

        parent::setUp();
    }

    public function testSendsEmailUsingMailerComponent()
    {
        $this->assertIsObject(static::$kernel);
        $this->assertSame(MailerKernel::class, \get_class(static::$kernel));

        $formTranslationRepository = $this->entityManager->getRepository(FormTranslation::class);
        /** @var FormTranslation $formTranslation */
        $formTranslation = $formTranslationRepository->findOneBy(['title' => 'Title', 'locale' => 'de']);
        $form = $formTranslation->getForm();

        $this->updateHomePage($form);
        $this->doSendForm($form);

        if ($this->client->getProfile()->hasCollector('swiftmailer')) {
            // @deprecated
            $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
            $this->assertSame(0, $mailCollector->getMessageCount());
        }

        // 2 messages should be sent 1 to admin and 1 to email
        $this->assertEmailCount(2);
    }
}
