<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\SpamChecker;

use Sulu\Bundle\FormBundle\Configuration\FormConfigurationInterface;
use Sulu\Bundle\FormBundle\Exception\FormSubmissionIsSpamExceptionInterface;
use Symfony\Component\Form\FormInterface;

interface SpamCheckerInterface
{
    const SPAM_STRATEGY_NO_SAVE = 'no_save';
    const SPAM_STRATEGY_NO_EMAIL = 'no_email';
    const SPAM_STRATEGY_SPAM = 'spam';

    /**
     * @throws FormSubmissionIsSpamExceptionInterface
     */
    public function check(FormInterface $form, FormConfigurationInterface $formConfiguration): void;
}
