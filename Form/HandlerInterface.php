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
use Sulu\Bundle\FormBundle\Event\FormSavePostEvent;
use Sulu\Bundle\FormBundle\Event\FormSavePreEvent;
use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    /** @deprecated use FormSavePreEvent::NAME instead */
    public const EVENT_FORM_SAVE = FormSavePreEvent::NAME;

    /** @deprecated use FormSavePostEvent::NAME instead */
    public const EVENT_FORM_SAVED = FormSavePostEvent::NAME;

    public const HONEY_POT_STRATEGY_NO_SAVE = 'no_save';
    public const HONEY_POT_STRATEGY_NO_EMAIL = 'no_email';
    public const HONEY_POT_STRATEGY_SPAM = 'spam';

    public function handle(FormInterface $form, FormConfigurationInterface $configuration): bool;
}
