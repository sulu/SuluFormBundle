<?php

namespace L91\Sulu\Bundle\FormBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Form;

class DynFormSavedEvent extends Event
{
    const NAME = 'l91.dynform.saved';

    protected $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }
}