<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Sulu\Bundle\FormBundle\Configuration\FormConfigurationInterface;
use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    const EVENT_FORM_SAVE = 'sulu_form.handler.save';
    const EVENT_FORM_SAVED = 'sulu_form.handler.saved';

    public function handle(FormInterface $form, FormConfigurationInterface $configuration): bool;
}
