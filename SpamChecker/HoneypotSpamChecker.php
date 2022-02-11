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
use Sulu\Bundle\FormBundle\Exception\FormSubmissionIsSpamException;
use Symfony\Component\Form\FormInterface;

class HoneypotSpamChecker implements SpamCheckerInterface
{
    public const SPAM_REASON_HONEYPOT = 'honeypot';

    /**
     * @var string|null
     */
    private $honeyPotField;

    /**
     * @var string
     */
    private $honeyPotSpamStrategy;

    public function __construct(?string $honeyPotField, ?string $honeyPotSpamStrategy)
    {
        $this->honeyPotField = $honeyPotField;
        $this->honeyPotSpamStrategy = $honeyPotSpamStrategy ?? self::SPAM_STRATEGY_SPAM;
    }

    public function check(FormInterface $form, FormConfigurationInterface $formConfiguration): void
    {
        if (!$this->honeyPotField) {
            return;
        }

        $honeypotFieldName = str_replace(' ', '_', strtolower($this->honeyPotField));

        if (!$form->has($honeypotFieldName)) {
            return;
        }

        $honeypotField = $form->get($honeypotFieldName);

        if (!$honeypotField->getData()) {
            return;
        }

        throw new FormSubmissionIsSpamException($this->honeyPotSpamStrategy, self::SPAM_REASON_HONEYPOT);
    }
}
