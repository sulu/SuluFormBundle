<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class FormTokenController
{
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function tokenAction(Request $request): Response
    {
        $formName = $request->get('form');
        $csrfToken = $this->csrfTokenManager->getToken($formName)->getValue();

        $content = $csrfToken;

        if ($request->get('html')) {
            $content = \sprintf(
                '<input type="hidden" id="%s__token" name="%s[_token]" value="%s" />',
                $formName,
                $formName,
                $csrfToken
            );
        }

        $response = new Response($content);

        /* Deactivate Cache for this token action */
        $response->setSharedMaxAge(0);
        $response->setMaxAge(0);
        // set shared will set the request to public so it need to be done after shared max set to 0
        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }
}
