<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Component\EventDispatcher\Event;

/**
 * @deprecated
 */
class DynFormSavedEvent extends Event
{
    const NAME = 'sulu.dynform.saved';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var Dynamic
     */
    protected $dynamic;

    /**
     * DynFormSavedEvent constructor.
     *
     * @param array $data
     * @param Dynamic $dynamic
     */
    public function __construct($data, $dynamic = null)
    {
        $this->data = $data;
        $this->dynamic = $dynamic;
    }

    /**
     * Returns data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns dynamic.
     *
     * @return Dynamic|null
     */
    public function getDynamic()
    {
        return $this->dynamic;
    }
}
