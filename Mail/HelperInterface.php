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

use Sulu\Bundle\FormBundle\Configuration\MailConfigurationInterface;

interface HelperInterface
{
    public const MAIL_RECEIVER_TO = MailConfigurationInterface::TYPE_TO;
    public const MAIL_RECEIVER_CC = MailConfigurationInterface::TYPE_CC;
    public const MAIL_RECEIVER_BCC = MailConfigurationInterface::TYPE_BCC;

    /**
     * @param string|string[] $subject
     * @param string|string[] $body
     * @param string|string[] $toMail
     * @param string|string[] $fromMail
     * @param string|string[] $replyTo
     * @param \SplFileInfo[] $attachments
     * @param string|string[] $ccMail
     * @param string|string[] $bccMail
     * @param string|string[] $plainText
     */
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
    ): int;
}
