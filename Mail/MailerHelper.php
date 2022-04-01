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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerHelper implements HelperInterface
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var null|string
     */
    private $toMail;

    /**
     * @var null|string
     */
    private $fromMail;

    /**
     * @var string|null
     */
    private $sender;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        MailerInterface $mailer,
        ?string $fromMail,
        ?string $toMail,
        ?string $sender = null,
        ?LoggerInterface $logger = null
    ) {
        $this->mailer = $mailer;
        $this->toMail = $toMail;
        $this->fromMail = $fromMail;
        $this->sender = $sender;
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
        $message = new Email();

        $this->setHeaders(
            $message,
            $subject ?: '',
            $this->parseToAddresses($fromMail ?: $this->fromMail),
            $this->parseToAddresses($toMail ?: $this->toMail),
            $this->parseToAddresses($replyTo),
            $this->parseToAddresses($ccMail),
            $this->parseToAddresses($bccMail),
            $this->sender ? new Address($this->sender) : null
        );
        $this->setBody($message, $html, $body, $plainText);
        $this->setAttachments($message, $attachments);

        $this->logMessage(
            $fromMail ?: $this->fromMail,
            $toMail ?: $this->toMail,
            $replyTo,
            $subject ?: '',
            $ccMail,
            $bccMail,
            $plainText
        );

        $this->mailer->send($message);

        return 0;
    }

    /**
     * Set the headers of an Email.
     *
     * Must set all headers of an email, like to, from, cc, bcc and subject.
     * Overwrite this to change setting of headers of the Email
     *
     * @param Email $message email message
     * @param string $subject subject of the email
     * @param Address[] $fromMail list of addresses already accounting for the defaults
     * @param Address[] $toMail list of addresses already accounting for the defaults
     * @param Address[] $replyTo list of addresses already accounting for the defaults may be an empty array
     * @param Address[] $ccMail list of addresses already accounting for the defaults may be an empty array
     * @param Address[] $bccMail list of addresses already accounting for the defaults may be an empty array
     * @param Address|null $sender address already accounting for the defaults
     */
    private function setHeaders(
        Email $message,
        string $subject,
        array $fromMail,
        array $toMail,
        array $replyTo,
        array $ccMail,
        array $bccMail,
        ?Address $sender
    ): void {
        $message->subject($subject);
        $message->from(...$fromMail);
        $message->to(...$toMail);

        if ($sender) {
            $message->sender($sender);
        }
        if ($replyTo) {
            $message->replyTo(...$replyTo);
        }
        if ($ccMail) {
            $message->cc(...$ccMail);
        }
        if ($bccMail) {
            $message->bcc(...$bccMail);
        }
    }

    /**
     * @param \SplFileInfo[] $attachments
     */
    private function setAttachments(
        Email $message,
        array $attachments
    ): void {
        foreach ($attachments as $file) {
            if (!($file instanceof \SplFileInfo)) {
                continue;
            }
            $path = $file->getPathname();
            $name = $file->getFilename();

            // if uploadedfile get original name
            if ($file instanceof UploadedFile) {
                $name = $file->getClientOriginalName();
            }
            $message->attachFromPath($path, $name);
        }
    }

    /**
     * @param string $plainText
     */
    private function setBody(
        Email $message,
        bool $html,
        string $body,
        ?string $plainText
    ): void {
        if ($html) {
            $message->html($body);
        } else {
            $message->text($body);
        }

        if ($plainText) {
            $message->text($plainText);
        }
    }

    /**
     * @param string|array<string|int, string> $fromMail
     * @param string|array<string|int, string> $toMail
     * @param string|array<string|int, string> $replyTo
     * @param array<string|int, string> $ccMail
     * @param array<string|int, string> $bccMail
     * @param string $plainText
     */
    private function logMessage(
        $fromMail,
        $toMail,
        $replyTo,
        string $subject,
        array $ccMail,
        array $bccMail,
        ?string $plainText
    ): void {
        $this->logger->info(\sprintf(
            'Try register mail from SuluFormBundle: ' . \PHP_EOL .
            '   From: %s' . \PHP_EOL .
            '   To: %s' . \PHP_EOL .
            '   Reply to: %s' . \PHP_EOL .
            '   Subject: %s' . \PHP_EOL .
            '   CC: %s' . \PHP_EOL .
            '   BCC: %s' . \PHP_EOL .
            '   Plain text: %s' . \PHP_EOL,
            \is_string($fromMail) ? $fromMail ?: $this->fromMail : \serialize($fromMail),
            \is_string($toMail) ? $toMail ?: $this->toMail : \serialize($toMail),
            \is_string($replyTo) ? $replyTo : \serialize($replyTo),
            $subject,
            \serialize($ccMail),
            \serialize($bccMail),
            $plainText
        ));
    }

    /**
     * @param string|array<string|int, string> $fromMail email address or [email-address => name] for muliple named addresses
     *
     * @return Address[]
     */
    private function parseToAddresses($fromMail): array
    {
        if (\is_string($fromMail)) {
            return [Address::create($fromMail)];
        }

        if (!\is_array($fromMail)) {
            return [];
        }

        $result = [];
        foreach ($fromMail as $key => $value) {
            $result[] = new Address($key, $value);
        }

        return $result;
    }
}
