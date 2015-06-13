<?php

namespace L91\Sulu\Bundle\FormBundle\Form;

use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    const EVENT_FORM_SAVED = 'l91.sulu.form.handler.saved';

    /**
     * @param string $name
     * @param array $attributes
     * @return FormInterface
     */
    public function get($name, $attributes = array());

    /**
     * @param FormInterface $form
     * @param array $attributes
     * @return boolean
     */
    public function handle(FormInterface $form, $attributes = array());

    /**
     * @param $name
     * @return string
     */
    public function getToken($name);
}