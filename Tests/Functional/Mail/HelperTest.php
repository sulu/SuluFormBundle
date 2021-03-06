<?php


namespace Sulu\Bundle\FormBundle\Tests\Functional\Mail;


use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Tests\Functional\Mail\Fixtures\LoadFormFixture;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class HelperTest extends HelperTestCase
{
    public function testSendsEmailUsingSwiftmailer()
    {
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
