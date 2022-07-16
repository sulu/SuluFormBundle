<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

use Symfony\Component\PasswordHasher\Hasher\MessageDigestPasswordHasher;
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
     * @var MessageDigestPasswordEncoder|MessageDigestPasswordHasher
     */
    private $encoder;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
        $this->encoder = \class_exists(MessageDigestPasswordEncoder::class)
            ? new MessageDigestPasswordEncoder()
            : new MessageDigestPasswordHasher();
    }

    /**
     * Check checksum with given parameters.
     */
    public function check(string $checksum, string $type, string $typeId, int $formId, string $formName): bool
    {
        $checksumRaw = $this->createKey($type, $typeId, $formId, $formName);

        if (\class_exists(MessageDigestPasswordEncoder::class)) {
            return $this->encoder->isPasswordValid($checksum, $checksumRaw, $this->secret);
        }

        return $this->encoder->verify($checksum, $checksumRaw, $this->secret);
    }

    /**
     * Create a key with given parameteres.
     */
    private function createKey(string $type, string $typeId, int $formId, string $formName): string
    {
        return $type . $typeId . $formId . $formName;
    }

    /**
     * Create a checksum and encode with secret and given parameters.
     */
    public function get(string $type, string $typeId, int $formId, string $formName): string
    {
        $checksumRaw = $this->createKey($type, $typeId, $formId, $formName);

        if (\class_exists(MessageDigestPasswordEncoder::class)) {
            return $this->encoder->encodePassword($checksumRaw, $this->secret);
        }

        return $this->encoder->hash($checksumRaw, $this->secret);
    }
}
