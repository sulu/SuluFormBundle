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
use Sulu\Bundle\FormBundle\Tests\Functional\Mail\Fixtures\LoadFormFixture;
use Sulu\Bundle\TestBundle\Testing\WebsiteTestCase;
use Sulu\Page\Domain\Model\Page;
use Sulu\Page\Tests\Traits\CreatePageTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class HelperTestCase extends WebsiteTestCase
{
    use CreatePageTrait;

    protected static KernelBrowser $client;

    protected static EntityManagerInterface $entityManager;

    protected static Page $homePage;

    public static function setUpBeforeClass(): void
    {
        self::$client = self::createWebsiteClient();
        parent::setUpBeforeClass();
        self::purgeDatabase();
        self::$entityManager = self::getEntityManager();

        $fixture = new LoadFormFixture();
        $fixture->load(self::$entityManager);

        self::$entityManager->flush();
        self::$entityManager->clear();
    }

    protected function createHomePage(?Form $form = null): Page
    {
        $page = self::createPage([
            'de' => [
                'live' => [
                    'template' => 'overview',
                    'title' => 'Homepage',
                    'url' => '/',
                    'form' => $form?->getId(),
                ],
            ],
        ]);

        self::$entityManager->clear();

        return $page;
    }

    protected function doSendForm(Form $form): void
    {
        $crawler = self::$client->request('GET', 'http://sulu.io/');
        $this->assertHttpStatusCode(200, self::$client->getResponse());

        $formName = \sprintf('dynamic_form%d', $form->getId());
        $formSelector = \sprintf('form[name=%s]', $formName);
        $this->assertEquals(1, $crawler->filter($formSelector)->count());

        $formElm = $crawler->filter($formSelector)->first()->form([
            $formName . '[email]' => '',
            $formName . '[email1]' => '',
        ]);

        self::$client->enableProfiler();
        $crawler = self::$client->submit($formElm);
        $this->assertResponseStatusCodeSame(422);

        $formElm = $crawler->filter($formSelector)->first()->form([
            $formName . '[email]' => 'test@example.org',
            $formName . '[email1]' => 'jon@example.org',
        ]);

        self::$client->submit($formElm);
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('?send=true');
    }
}
