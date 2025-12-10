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

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Tests\Functional\Mail\Fixtures\LoadFormFixture;
use Sulu\Bundle\FormBundle\Tests\Application\MailerKernel;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class FormDataMailerTest extends SuluTestCase
{
    protected KernelBrowser $client;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        static::$class = MailerKernel::class;

        $this->client = $this->createWebsiteClient();
        $this->purgeDatabase();
        $this->entityManager = $this->getEntityManager();

        $fixture = new LoadFormFixture();
        $fixture->load($this->entityManager);

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testSendsEmailUsingMailerComponent(): void
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

    protected function updateHomePage(?Form $form = null): void
    {
        /* @var $homePage HomeDocument */
        $homePage = $suluDocumentManager->find('/cmf/sulu-io/contents');
        $homePage->setResourceSegment('/');
        $homePage->getStructure()->bind([
            'form' => $form ? $form->getId() : null,
            'url' => '/',
        ]);

        $suluDocumentManager->persist($homePage, 'de');
        $suluDocumentManager->publish($homePage, 'de');
        $suluDocumentManager->flush();
    }

    protected function doSendForm(Form $form): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertHttpStatusCode(200, $this->client->getResponse());

        $formName = \sprintf('dynamic_form%d', $form->getId());
        $formSelector = \sprintf('form[name=%s]', $formName);
        $this->assertEquals(1, $crawler->filter($formSelector)->count());

        $formElm = $crawler->filter($formSelector)->first()->form([
            $formName . '[email]' => '',
            $formName . '[email1]' => '',
        ]);

        $this->client->enableProfiler();
        $crawler = $this->client->submit($formElm);
        $this->assertResponseStatusCodeSame(422);

        $formElm = $crawler->filter($formSelector)->first()->form([
            $formName . '[email]' => 'test@example.org',
            $formName . '[email1]' => 'jon@example.org',
        ]);

        $this->client->submit($formElm);
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('?send=true');
    }
}
