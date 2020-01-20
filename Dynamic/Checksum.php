<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Checksum.
 */
class Checksum
{
    /**
     * @var string
     */
    private $secret;

    /**
     * @var MessageDigestPasswordEncoder
     */
    private $encoder;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
        $this->encoder = new MessageDigestPasswordEncoder();
    }

    /**
     * Check checksum with given parameters.
     */
    public function check(string $checksum, string $type, string $typeId, string $formId, string $formName): bool
    {
        $checksumRaw = $this->createKey($type, $typeId, $formId, $formName);

        return $this->encoder->isPasswordValid($checksum, $checksumRaw, $this->secret);
    }

    /**
     * Create a key with given parameteres.
     */
    private function createKey(string $type, string $typeId, string $formId, string $formName): string
    {
        return $type . $typeId . $formId . $formName;
    }

    /**
     * Create a checksum and encode with secret and given parameters.
     */
    public function get(string $type, string $typeId, string $formId, string $formName): string
    {
        $checksumRaw = $this->createKey($type, $typeId, $formId, $formName);

        return $this->encoder->encodePassword($checksumRaw, $this->secret);
    }
}
