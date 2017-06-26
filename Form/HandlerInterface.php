<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    const EVENT_FORM_SAVED = 'sulu_form.handler.saved';

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
