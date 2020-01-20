<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Mail;

use Sulu\Bundle\FormBundle\Configuration\MailConfigurationInterface;

interface HelperInterface
{
    const MAIL_RECEIVER_TO = MailConfigurationInterface::TYPE_TO;
    const MAIL_RECEIVER_CC = MailConfigurationInterface::TYPE_CC;
    const MAIL_RECEIVER_BCC = MailConfigurationInterface::TYPE_BCC;

    /**
     * @param string|string[] $toMail
     * @param \SplFileInfo[] $attachments
     * @param string|string[] $ccMail
     * @param string|string[] $bccMail
     */
    public function sendMail(
        string $subject,
        string $body,
        $toMail = null,
        string $fromMail = null,
        bool $html = true,
        string $replyTo = null,
        array $attachments = [],
        $ccMail = [],
        $bccMail = [],
        string $plainText = null
    ): int;
}
