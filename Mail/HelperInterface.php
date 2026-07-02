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
     * @param string|array<string|int, string>|null $toMail
     * @param string|array<string|int, string>|null $fromMail
     * @param string|array<string|int, string>|null $replyTo
     * @param \SplFileInfo[] $attachments
     * @param string|array<string|int, string> $ccMail
     * @param string|array<string|int, string> $bccMail
     */
    public function sendMail(
        ?string $subject,
        string $body,
        string|array|null $toMail = null,
        string|array|null $fromMail = null,
        bool $html = true,
        string|array|null $replyTo = null,
        array $attachments = [],
        string|array $ccMail = [],
        string|array $bccMail = [],
        ?string $plainText = null
    ): int;
}
