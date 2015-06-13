<?php

namespace L91\Sulu\Bundle\FormBundle\Mail;

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
    public function __construct(
        $logger = null
    ) {
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
        $html = true
    ) {
        $this->logger->info(sprintf(
            'L91 FormBundle NullMailHelper: ' . PHP_EOL .
            '   From: ' . $fromMail . PHP_EOL .
            '   To: ' . $toMail . PHP_EOL .
            '   Subject: ' . $subject
        ));
    }
}