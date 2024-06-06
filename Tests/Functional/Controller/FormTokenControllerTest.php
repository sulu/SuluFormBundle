<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Controller;

use Sulu\Bundle\FormBundle\Controller\FormTokenController;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class FormTokenControllerTest extends SuluTestCase
{
    /**
     * @var FormTokenControllerTest
     */
    private $formTokenController;

    protected function setUp(): void
    {
        parent::setUp();
        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfToken = $this->createMock(CsrfToken::class);
        $csrfToken->method('getValue')->willReturn('testToken');
        $csrfTokenManager->method('getToken')->willReturn($csrfToken);
        $this->formTokenController = new FormTokenController($csrfTokenManager);
    }

    public function testTokenAction(): void
    {
        $request = new Request([], [], ['form' => 'testForm', 'html' => true]);
        $response = $this->formTokenController->tokenAction($request);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('testForm', $response->getContent());
    }

    public function testTokenActionWithScript(): void
    {
        $request = new Request([], [], ['form' => '<script>alert(1)</script>', 'html' => true]);
        $response = $this->formTokenController->tokenAction($request);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $response->getContent());
        $this->assertStringNotContainsString('<script>alert(1)</script>', $response->getContent());
    }
}
