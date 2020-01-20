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

class BuilderNotFoundException extends \Exception
{
    /**
     * @var string
     */
    private $builder;

    public function __construct(string $formEntityId)
    {
        parent::__construct(sprintf('Builder with the name "%s" not found.', $formEntityId));

        $this->builder = $formEntityId;
    }

    public function getBuilder(): string
    {
        return $this->builder;
    }
}
