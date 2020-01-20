<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form\Type;

interface TypeInterface
{
    /**
     * @param mixed[] $attributes
     */
    public function setAttributes(array $attributes): void;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerSubject(array $formData = []): ?string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifySubject(array $formData = []): ?string;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerMail(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifyMail(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerFromMailAddress(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerToMailAddress(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerReplyToMailAddress(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifyFromMailAddress(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifyToMailAddress(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifyReplyToMailAddress(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifySendAttachments(array $formData = []): bool;

    /**
     * @param mixed[] $formData
     */
    public function getNotifyDeactivateMails(array $formData = []): bool;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerDeactivateMails(array $formData = []): bool;

    /**
     * @param mixed[] $formData
     */
    public function getMailText(array $formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getSuccessText(array $formData = []): string;

    /**
     * @return string
     * @deprecated
     *
     */
    public function getDefaultIntention(): string;

    /**
     * @return string[]
     */
    public function getFileFields(): array;

    public function getCollectionId(): ?int;
}
