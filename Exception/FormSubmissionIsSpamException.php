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

namespace Sulu\Bundle\FormBundle\Exception;

class FormSubmissionIsSpamException extends \Exception implements FormSubmissionIsSpamExceptionInterface
{
    /**
     * @var string
     */
    private $spamStrategy;

    /**
     * @var string
     */
    private $reason;

    /**
     * @see SpamCheckerInterface::SPAM_STRATEGY_SPAM
     * @see SpamCheckerInterface::SPAM_STRATEGY_NO_SAVE
     * @see SpamCheckerInterface::SPAM_STRATEGY_NO_EMAIL
     */
    public function __construct(string $spamStrategy, string $reason)
    {
        $this->spamStrategy = $spamStrategy;
        $this->reason = $reason;

        parent::__construct(
            sprintf('FormSubmission has been marked as spam because of "%s" with strategy "%s"', $reason, $spamStrategy)
        );
    }

    public function getSpamStrategy(): string
    {
        return $this->spamStrategy;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
