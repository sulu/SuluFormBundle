<?php

namespace L91\Sulu\Bundle\FormBundle\Mail;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Helper implements HelperInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    protected $toMail;

    /**
     * @var string
     */
    protected $fromMail;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param \Swift_Mailer $mailer
     * @param string $fromMail
     * @param string $toMail
     * @param LoggerInterface $logger
     */
    public function __construct(
        \Swift_Mailer $mailer,
        $fromMail,
        $toMail,
        $logger = null
    ) {
        $this->mailer = $mailer;
        $this->toMail = $toMail;
        $this->fromMail = $fromMail;
        $this->logger = $logger ? : new NullLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function sendMail(
        $subject,
        $body,
        $toMail = null,
        $fromMail = null,
        $replayTo = null,
        $html = true
    ) {
        $message = new \Swift_Message(
            $subject,
            $body
        );

        if (!$toMail) {
            $toMail = $this->toMail;
        }

        if (!$fromMail) {
            $fromMail = $this->fromMail;
        }

        if ($html) {
            $message->setContentType('text/html');
        }

        $message->setFrom($fromMail);
        $message->setTo($toMail);

        if ($replayTo != null) {
            $message->setReplyTo($replayTo);
        }

        $this->logger->info(sprintf(
            'Try register mail from L91 FormBundle: ' . PHP_EOL .
            '   From: ' . $fromMail . PHP_EOL .
            '   To: ' . $toMail . PHP_EOL .
            '   Subject: ' . $subject
        ));

        return $this->mailer->send($message);
    }
}
