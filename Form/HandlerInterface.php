<?php

namespace L91\Bundle\FormBundle\Form;

use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    /**
     * @param string $name
     * @param array $attributes
     * @return FormInterface
     */
    public function get($name, $attributes = array());

    /**
     * @param FormInterface $form
     * @return boolean
     */
    public function handle(FormInterface $form);
}