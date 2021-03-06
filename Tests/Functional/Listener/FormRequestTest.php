<?php


namespace Functional\Listener;


use Sulu\Bundle\FormBundle\Configuration\MailConfiguration;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class FormRequestTest extends SuluTestCase
{

    /**
     * @var \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    private $client;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    public function testPageRendersWithoutForm()
    {
        $this->inititalize();

        $this->updateHomePage(null);

        $this->client->request('GET', '/');
//        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertHttpStatusCode(200, $response);
    }

    public function testPageRendersWithSetForm()
    {
        $this->inititalize();

        $form = $this->createFullForm();
        $this->updateHomePage($form);
        $this->doSendForm($form);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        // 2 messages should be send 1 to admin and 1 to email
        $this->assertSame(2, $mailCollector->getMessageCount());

        $this->assertEmailCount(0);
    }

    public function testDoesNotMailWhenNullHandlerSet()
    {
        $_ENV['MAIL_HANDLER'] = 'NullHelper';
        $this->inititalize();

        $form = $this->createFullForm();
        $this->updateHomePage($form);
        $this->doSendForm($form);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        // 2 messages should be send 1 to admin and 1 to email
        $this->assertSame(0, $mailCollector->getMessageCount());

        $this->assertEmailCount(0);
    }

    public function testUsesMailerWhenMailerHandlerSet()
    {
        $_ENV['MAIL_HANDLER'] = 'MailerHelper';
        $this->inititalize();

        $form = $this->createFullForm();
        $this->updateHomePage($form);
        $this->doSendForm($form);

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        $this->assertSame(0, $mailCollector->getMessageCount());

        $this->assertEmailCount(2);
    }
    /**
     * @param Form $form
     * @throws \Sulu\Component\DocumentManager\Exception\DocumentManagerException
     */
    private function updateHomePage(Form $form = null): void
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


    private function createFullForm(): Form
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

        $this->entityManager->persist($form);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $form;
    }

    /**
     * @param Form $form
     */
    private function doSendForm(Form $form): void
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

    private function inititalize(): void
    {
        $this->client = $this->createWebsiteClient();
        $this->purgeDatabase();
        $this->initPhpcr();
        $this->entityManager = $this->getEntityManager();
    }
}
