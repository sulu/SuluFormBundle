<?php

namespace L91\Sulu\Bundle\FormBundle\Mail;

interface HelperInterface
{
    /**
     * @param string $subject
     * @param string $body
     * @param string $toMail
     * @param string $fromMail
     * @param bool $html
     * @param string $replayTo
     * @param \SplFileInfo[] $attachments
     *
     * @return int
     */
    public function sendMail(
        $subject,
        $body,
        $toMail = null,
        $fromMail = null,
        $html = true,
        $replayTo = null,
        $attachments = []
    );
}
