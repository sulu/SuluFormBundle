<?php


namespace Sulu\Bundle\FormBundle\Tests\Functional\Mail;


use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Tests\Functional\Mail\Fixtures\LoadFormFixture;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class HelperTestCase extends SuluTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createWebsiteClient();
        $this->purgeDatabase();
        $this->initPhpcr();
        $this->entityManager = $this->getEntityManager();

        $fixture = new LoadFormFixture();
        $fixture->load($this->entityManager);
    }

//    public function testPageRendersWithoutForm()
//    {
//        $this->updateHomePage(null);
//
//        $this->client->request('GET', '/');
//        $this->assertResponseIsSuccessful();;
//    }

//    public function testPageRendersWithSetForm()
//    {
//        $formTranslationRepository = $this->entityManager->getRepository(FormTranslation::class);
//        /** @var FormTranslation $formTranslation */
//        $formTranslation = $formTranslationRepository->findOneBy(['title' => 'Title', 'locale' => 'de']);
//        $form = $formTranslation->getForm();
//
//        $this->updateHomePage($form);
//        $this->doSendForm($form);
//
//        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
//        // 2 messages should be send 1 to admin and 1 to email
//        $this->assertSame(2, $mailCollector->getMessageCount());
//
//        $this->assertEmailCount(0);
//    }

    /**
     * @param Form $form
     * @throws \Sulu\Component\DocumentManager\Exception\DocumentManagerException
     */
    protected function updateHomePage(Form $form = null): void
    {
        /* @var $suluDocumentManager \Sulu\Component\DocumentManager\DocumentManagerInterface */
        $suluDocumentManager = static::getContainer()->get('sulu_document_manager.document_manager');

        /* @var $homePage \Sulu\Bundle\PageBundle\Document\HomeDocument */
        $homePage = $suluDocumentManager->find('/cmf/sulu-io/contents');
        $homePage->setResourceSegment('/');
        $homePage->getStructure()->bind([
            'form' => $form ? $form->getId() : null,
            'url' => '/'
        ]);

        $suluDocumentManager->publish($homePage, 'de');
        $suluDocumentManager->persist($homePage, 'de');
        $suluDocumentManager->flush();
    }

    /**
     * @param Form $form
     */
    protected function doSendForm(Form $form): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertHttpStatusCode(200, $this->client->getResponse());

        $formName = sprintf('dynamic_form%d', $form->getId());
        $formSelector = sprintf('form[name=%s]', $formName);
        $this->assertEquals(1, $crawler->filter($formSelector)->count());

        $formElm = $crawler->filter($formSelector)->first()->form([
            $formName . '[email]' => 'test@example.org',
            $formName . '[email1]' => 'jon@example.org',
        ]);

        $this->client->enableProfiler();
        $this->client->submit($formElm);
        $this->assertResponseRedirects('?send=true');
    }
}
