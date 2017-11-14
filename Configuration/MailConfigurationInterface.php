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
 * Interface MailConfigurationInterface.
 */
interface MailConfigurationInterface
{
    const TYPE_TO = 'to';
    const TYPE_CC = 'cc';
    const TYPE_BCC = 'bcc';

    /**
     * @return string
     */
    public function getLocale();

    /**
     * Get subject.
     *
     * @return string
     */
    public function getSubject();

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
     *
     * @return bool
     */
    public function getAddAttachments();

    /**
     * Get mail template.
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Get template attributes.
     *
     * @return array
     */
    public function getTemplateAttributes();
}
