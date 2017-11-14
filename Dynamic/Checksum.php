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

    /**
     * Checksum constructor.
     *
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
        $this->encoder = new MessageDigestPasswordEncoder();
    }

    /**
     * Check checksum with given parameters.
     *
     * @param string $checksum
     * @param string $type
     * @param string $typeId
     * @param string $formId
     * @param string $formName
     *
     * @return bool
     */
    public function check($checksum, $type, $typeId, $formId, $formName)
    {
        $checksumRaw = $this->createKey($type, $typeId, $formId, $formName);

        return $this->encoder->isPasswordValid($checksum, $checksumRaw, $this->secret);
    }

    /**
     * Create a key with given parameteres.
     *
     * @param string $type
     * @param string $typeId
     * @param string $formId
     * @param string $formName
     *
     * @return string
     */
    private function createKey($type, $typeId, $formId, $formName)
    {
        return $type . $typeId . $formId . $formName;
    }

    /**
     * Create a checksum and encode with secret and given parameters.
     *
     * @param string $type
     * @param string $typeId
     * @param string $formId
     * @param string $formName
     *
     * @return string
     */
    public function get($type, $typeId, $formId, $formName)
    {
        $checksumRaw = $this->createKey($type, $typeId, $formId, $formName);

        return $this->encoder->encodePassword($checksumRaw, $this->secret);
    }
}
