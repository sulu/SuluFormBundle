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

interface HelperInterface
{
    const MAIL_RECEIVER_TO = 'to';
    const MAIL_RECEIVER_CC = 'cc';
    const MAIL_RECEIVER_BCC = 'bcc';

    /**
     * @param string $subject
     * @param string $body
     * @param string|array $toMail
     * @param string $fromMail
     * @param bool $html
     * @param string $replyTo
     * @param \SplFileInfo[] $attachments
     * @param string|array $ccMail
     * @param string|array $bccMail
     *
     * @return int
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
    );

    /**
     * Returns an array for holding receivers divided by types.
     *
     * @return array
     */
    public function getReceiverTypes();
}
