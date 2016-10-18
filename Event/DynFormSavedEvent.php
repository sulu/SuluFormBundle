<?php

namespace L91\Sulu\Bundle\FormBundle\Event;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Component\EventDispatcher\Event;

class DynFormSavedEvent extends Event
{
    const NAME = 'l91.dynform.saved';

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
     * @param Dynamic $dynamic will be required in the future
     */
    public function __construct($data, $dynamic = null)
    {
        $this->data = $data;
        $this->dynamic = $dynamic;
    }

    /**
     * Get FormSelect.
     *
     * @deprecated use the getData function
     *
     * @return array
     */
    public function getFormSelect()
    {
        return $this->data;
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get dynamic.
     *
     * @return Dynamic|null
     */
    public function getDynamic()
    {
        return $this->dynamic;
    }
}
