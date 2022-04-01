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
 * Interface MailConfigurationInterface.
 */
interface MailConfigurationInterface
{
    public const TYPE_TO = 'to';
    public const TYPE_CC = 'cc';
    public const TYPE_BCC = 'bcc';

    public function getLocale(): string;

    public function getSubject(): ?string;

    /**
     * Get from address.
     *
     * @return string|string[]
     */
    public function getFrom();

    /**
     * Get to addresses.
     *
     * @return string|string[]
     */
    public function getTo();

    /**
     * Get cc addresses.
     *
     * @return string|string[]
     */
    public function getCc();

    /**
     * Get bcc addresses.
     *
     * @return string|string[]
     */
    public function getBcc();

    /**
     * Get reply to.
     *
     * @return string|string[]
     */
    public function getReplyTo();

    /**
     * Add attachments.
     */
    public function getAddAttachments(): bool;

    /**
     * Get mail template.
     */
    public function getTemplate(): string;

    /**
     * Get plain text mail template.
     */
    public function getPlainTextTemplate(): ?string;

    /**
     * Get template attributes.
     *
     * @return mixed[]
     */
    public function getTemplateAttributes(): array;
}
