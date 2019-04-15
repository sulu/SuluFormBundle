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

    /**
     * MailConfiguration constructor.
     *
     * @param string $locale
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return $this
     */
    public function setSubject($subject)
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
     *
     * @return $this
     */
    public function setFrom($from)
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
     *
     * @return $this
     */
    public function setTo($to)
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
     *
     * @return $this
     */
    public function setCc($cc)
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
     *
     * @return $this
     */
    public function setBcc($bcc)
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
     *
     * @return $this
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddAttachments()
    {
        return $this->addAttachments;
    }

    /**
     * Set addAttachments.
     *
     * @param bool $addAttachments
     *
     * @return $this
     */
    public function setAddAttachments($addAttachments)
    {
        $this->addAttachments = $addAttachments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set template.
     *
     * @param string $template
     *
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainTextTemplate()
    {
        return $this->plainTextTemplate;
    }

    /**
     * Set plain text template.
     *
     * @param string $plainTextTemplate
     *
     * @return $this
     */
    public function setPlainTextTemplate(string $plainTextTemplate)
    {
        $this->plainTextTemplate = $plainTextTemplate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateAttributes()
    {
        return $this->templateAttributes;
    }

    /**
     * Set template attributes.
     *
     * @param array $templateAttributes
     *
     * @return $this
     */
    public function setTemplateAttributes($templateAttributes)
    {
        $this->templateAttributes = $templateAttributes;

        return $this;
    }
}
