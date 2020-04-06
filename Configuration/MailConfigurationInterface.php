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
    const TYPE_TO = 'to';
    const TYPE_CC = 'cc';
    const TYPE_BCC = 'bcc';

    public function getLocale(): string;

    public function getSubject(): ?string;

    /**
     * Get from address.
     *
     * @return string|array
     */
    public function getFrom();

    /**
     * Get to addresses.
     *
     * @return string|array
     */
    public function getTo();

    /**
     * Get cc addresses.
     *
     * @return string|array
     */
    public function getCc();

    /**
     * Get bcc addresses.
     *
     * @return string|array
     */
    public function getBcc();

    /**
     * Get reply to.
     *
     * @return string|array
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
