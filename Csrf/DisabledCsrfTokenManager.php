<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Csrf;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DisabledCsrfTokenManager implements CsrfTokenManagerInterface
{
    /**
     * CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function refreshToken(string $tokenId)
    {
        return $this->csrfTokenManager->refreshToken($tokenId);
    }

    public function removeToken(string $tokenId)
    {
        return $this->csrfTokenManager->removeToken($tokenId);
    }

    public function isTokenValid(CsrfToken $token)
    {
        return $this->csrfTokenManager->isTokenValid($token);
    }

    public function getToken(string $tokenId)
    {
        return new CsrfToken('', null);
    }
}
