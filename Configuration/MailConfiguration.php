<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Configuration;

/**
 * Mail config object to hold all data to for a email.
 */
class MailConfiguration implements MailConfigurationInterface
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string|array
     */
    private $from;

    /**
     * @var string|array
     */
    private $to = [];

    /**
     * @var string|array
     */
    private $cc = [];

    /**
     * @var string|array
     */
    private $bcc = [];

    /**
     * @var string|array
     */
    private $replyTo;

    /**
     * @var bool
     */
    private $addAttachments;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $plainTextTemplate;

    /**
     * @var array
     */
    private $templateAttributes;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set from address.
     *
     * @param string|array $from
     */
    public function setFrom($from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set to addresses.
     *
     * @param string|array $to
     */
    public function setTo($to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set cc addresses.
     *
     * @param string|array $cc
     */
    public function setCc($cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set bcc addresses.
     *
     * @param string|array $bcc
     */
    public function setBcc($bcc): self
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set reply to.
     *
     * @param string|array $replyTo
     */
    public function setReplyTo($replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddAttachments(): bool
    {
        return $this->addAttachments;
    }

    /**
     * Set addAttachments.
     */
    public function setAddAttachments(bool $addAttachments): self
    {
        $this->addAttachments = $addAttachments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainTextTemplate(): string
    {
        return $this->plainTextTemplate;
    }

    /**
     * Set plain text template.
     */
    public function setPlainTextTemplate(string $plainTextTemplate): self
    {
        $this->plainTextTemplate = $plainTextTemplate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateAttributes(): array
    {
        return $this->templateAttributes;
    }

    /**
     * Set template attributes.
     *
     * @param mixed[] $templateAttributes
     */
    public function setTemplateAttributes(array $templateAttributes): self
    {
        $this->templateAttributes = $templateAttributes;

        return $this;
    }
}
