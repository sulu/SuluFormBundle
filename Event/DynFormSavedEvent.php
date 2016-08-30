<?php

namespace L91\Sulu\Bundle\FormBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class DynFormSavedEvent extends Event
{
    const NAME = 'l91.dynform.saved';

    /**
     * @var array
     */
    protected $formSelect;

    /**
     * DynFormSavedEvent constructor.
     *
     * @param $formSelect
     */
    public function __construct($formSelect)
    {
        $this->formSelect = $formSelect;
    }

    /**
     * Get FormSelect.
     *
     * @return array
     */
    public function getFormSelect()
    {
        return $this->formSelect;
    }
}
