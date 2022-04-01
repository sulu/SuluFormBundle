<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Mail;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @deprecated
 */
class NullHelper implements HelperInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        @\trigger_error(
            \sprintf('The "%s" is deprecated use the null transport of mailer instead.', __CLASS__),
            \E_USER_DEPRECATED
        );

        $this->logger = $logger ?: new NullLogger();
    }

    public function sendMail(
        $subject,
        $body,
        $toMail = null,
        $fromMail = null,
        bool $html = true,
        $replyTo = null,
        array $attachments = [],
        $ccMail = [],
        $bccMail = [],
        $plainText = null
    ): int {
        $this->logger->info(\sprintf(
            'SuluFormBundle NullMailHelper: ' . \PHP_EOL .
            '   From: %s' . \PHP_EOL .
            '   To: %s' . \PHP_EOL .
            '   Reply to: %s' . \PHP_EOL .
            '   Subject: %s' . \PHP_EOL .
            '   CC: %s' . \PHP_EOL .
            '   BCC: %s' . \PHP_EOL .
            '   Plain text: %s' . \PHP_EOL,
            \is_string($fromMail) ? $fromMail : \serialize($fromMail),
            \is_string($toMail) ? $toMail : \serialize($toMail),
            \is_string($replyTo) ? $replyTo : \serialize($toMail),
            \is_string($subject) ? $subject : \serialize($subject),
            \is_string($ccMail) ? $ccMail : \serialize($ccMail),
            \is_string($bccMail) ? $bccMail : \serialize($bccMail),
            \is_string($plainText) ? $plainText : \serialize($plainText)
        ));

        return 0;
    }
}
