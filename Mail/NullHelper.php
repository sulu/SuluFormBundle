<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Mail;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class NullHelper implements HelperInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct($logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function sendMail(
        $subject,
        $body,
        $toMail = null,
        $fromMail = null,
        $html = true,
        $replyTo = null,
        $attachments = [],
        $ccMail = [],
        $bccMail = []
    ) {
        $this->logger->info(sprintf(
            'SuluFormBundle NullMailHelper: ' . PHP_EOL .
            '   From: %s' . PHP_EOL .
            '   To: %s' . PHP_EOL .
            '   Reply to: %s' . PHP_EOL .
            '   Subject: %s' . PHP_EOL .
            '   CC: %s' . PHP_EOL .
            '   BCC: %s' . PHP_EOL,
            is_string($fromMail) ? $fromMail : serialize($fromMail),
            is_string($toMail) ? $toMail : serialize($toMail),
            is_string($replyTo) ? $replyTo : serialize($toMail),
            is_string($subject) ? $subject : serialize($subject),
            is_string($ccMail) ? $ccMail : serialize($ccMail),
            is_string($bccMail) ? $bccMail : serialize($bccMail)
        ));
    }
}
