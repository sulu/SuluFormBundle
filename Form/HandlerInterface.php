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
use Sulu\Bundle\FormBundle\SpamChecker\SpamCheckerInterface;
use Symfony\Component\Form\FormInterface;

interface HandlerInterface
{
    /**
     * @deprecated
     * @see FormSavePreEvent::NAME
     */
    const EVENT_FORM_SAVE = FormSavePreEvent::NAME;

    /**
     * @deprecated
     * @see FormSavePostEvent::NAME
     */
    const EVENT_FORM_SAVED = FormSavePostEvent::NAME;

    /**
     * @deprecated
     * @see SpamCheckerInterface::SPAM_STRATEGY_NO_SAVE
     */
    const HONEY_POT_STRATEGY_NO_SAVE = SpamCheckerInterface::SPAM_STRATEGY_NO_SAVE;

    /**
     * @deprecated
     * @see SpamCheckerInterface::SPAM_STRATEGY_NO_EMAIL
     */
    const HONEY_POT_STRATEGY_NO_EMAIL = SpamCheckerInterface::SPAM_STRATEGY_NO_EMAIL;

    /**
     * @deprecated
     * @see SpamCheckerInterface::SPAM_STRATEGY_SPAM
     */
    const HONEY_POT_STRATEGY_SPAM = SpamCheckerInterface::SPAM_STRATEGY_SPAM;

    public function handle(FormInterface $form, FormConfigurationInterface $configuration): bool;
}
