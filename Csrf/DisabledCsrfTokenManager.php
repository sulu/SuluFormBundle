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
    public function refreshToken(string $tokenId)
    {
        throw new \RuntimeException('Should not be called');
    }

    public function removeToken(string $tokenId)
    {
        throw new \RuntimeException('Should not be called');
    }

    public function isTokenValid(CsrfToken $token)
    {
        throw new \RuntimeException('Should not be called');
    }

    public function getToken(string $tokenId)
    {
        return new CsrfToken('', null);
    }
}
