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

class MailerHelperTest extends HelperTestCase
{
    public function testSendsEmailUsingMailerComponent()
    {

        $formTranslationRepository = self::$entityManager->getRepository(FormTranslation::class);
        /** @var FormTranslation $formTranslation */
        $formTranslation = $formTranslationRepository->findOneBy(['title' => 'Title', 'locale' => 'de']);
        $form = $formTranslation->getForm();

        $this->createHomePage($form);
        $this->doSendForm($form);

        // 2 messages should be sent 1 to admin and 1 to email
        $this->assertEmailCount(2);
    }
}
