<?php


namespace Sulu\Bundle\FormBundle\Tests\Functional\Mail;


use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Tests\Functional\Mail\Fixtures\LoadFormFixture;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Tests\Application\MailerKernel;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class MailerHelperTest extends HelperTestCase
{
    protected static $class = MailerKernel::class;

    public function testSendsEmailUsingMailerComponent()
    {
        $formTranslationRepository = $this->entityManager->getRepository(FormTranslation::class);
        /** @var FormTranslation $formTranslation */
        $formTranslation = $formTranslationRepository->findOneBy(['title' => 'Title', 'locale' => 'de']);
        $form = $formTranslation->getForm();

        $this->updateHomePage($form);
        $this->doSendForm($form);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        $this->assertSame(0, $mailCollector->getMessageCount());

        $this->assertEmailCount(2);
    }

}
