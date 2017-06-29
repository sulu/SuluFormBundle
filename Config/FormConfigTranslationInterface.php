<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Config;

/**
 * A form config translation.
 */
interface FormConfigTranslationInterface
{
    /**
     * Get locale.
     *
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
     * Get from email.
     *
     * @return string
     */
    public function getFromEmail();

    /**
     * Get from name.
     *
     * @return string
     */
    public function getFromName();

    /**
     * Get to email.
     *
     * @return string
     */
    public function getToEmail();

    /**
     * Get to name.
     *
     * @return string
     */
    public function getToName();

    /**
     * Get mail text.
     *
     * @return string
     */
    public function getMailText();

    /**
     * Should attachment been send.
     *
     * @return bool
     */
    public function getSendAttachments();

    /**
     * Should notify mails been send.
     *
     * @return bool
     */
    public function getDeactivateNotifyMails();

    /**
     * Should customer mails been send.
     *
     * @return bool
     */
    public function getDeactivateCustomerMails();

    /**
     * Should reply to been set.
     *
     * @return bool
     */
    public function getReplyTo();
}
