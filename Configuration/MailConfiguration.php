<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
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
     * @var null|string
     */
    private $subject;

    /**
     * @var string|string[]
     */
    private $from;

    /**
     * @var string|string[]
     */
    private $to = [];

    /**
     * @var string|string[]
     */
    private $cc = [];

    /**
     * @var string|string[]
     */
    private $bcc = [];

    /**
     * @var string|string[]
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
     * @var string|null
     */
    private $plainTextTemplate;

    /**
     * @var mixed[]
     */
    private $templateAttributes;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set from address.
     *
     * @param string|string[] $from
     */
    public function setFrom($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set to addresses.
     *
     * @param string|string[] $to
     */
    public function setTo($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Set cc addresses.
     *
     * @param string|string[] $cc
     */
    public function setCc($cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Set bcc addresses.
     *
     * @param string|string[] $bcc
     */
    public function setBcc($bcc): self
    {
        $this->bcc = $bcc;

        return $this;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set reply to.
     *
     * @param string|string[] $replyTo
     */
    public function setReplyTo($replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

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

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getPlainTextTemplate(): ?string
    {
        return $this->plainTextTemplate;
    }

    /**
     * Set plain text template.
     */
    public function setPlainTextTemplate(?string $plainTextTemplate): self
    {
        $this->plainTextTemplate = $plainTextTemplate;

        return $this;
    }

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
