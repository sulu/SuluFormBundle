<?php

namespace Sulu\Bundle\FormBundle\Form;

use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    const EVENT_FORM_SAVED = 'sulu.form.handler.saved';

    /**
     * @param string $name
     * @param array $attributes
     *
     * @return FormInterface
     */
    public function get($name, $attributes = []);

    /**
     * @param FormInterface $form
     * @param array $attributes
     *
     * @return bool
     */
    public function handle(FormInterface $form, $attributes = []);

    /**
     * @param $name
     *
     * @return string
     */
    public function getToken($name);
}
