<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @deprecated
 */
class DynFormSavedEvent extends Event
{
    public const NAME = 'sulu.dynform.saved';

    /**
     * @var mixed[]
     */
    protected $data;

    /**
     * @var Dynamic
     */
    protected $dynamic;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data, Dynamic $dynamic = null)
    {
        $this->data = $data;
        $this->dynamic = $dynamic;
    }

    /**
     * @return mixed[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getDynamic(): ?Dynamic
    {
        return $this->dynamic;
    }
}
