<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Exception;

class InvalidListBuilderValueException extends \Exception
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct(\sprintf('Invalid value ("%s") for list builder.', $value));

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
