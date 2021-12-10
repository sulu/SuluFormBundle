<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
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
    public function getCustomerSubject($formData = []): ?string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifySubject($formData = []): ?string;

    /**
     * @param mixed[] $formData
     */
    public function getCustomerMail($formData = []): string;

    /**
     * @param mixed[] $formData
     */
    public function getNotifyMail($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getCustomerPlainMail($formData = []): ?string;

    /**
     * @param mixed $formData
     */
    public function getNotifyPlainMail($formData = []): ?string;

    /**
     * @param mixed $formData
     */
    public function getCustomerFromMailAddress($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getCustomerToMailAddress($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getCustomerReplyToMailAddress($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getNotifyFromMailAddress($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getNotifyToMailAddress($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getNotifyReplyToMailAddress($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getNotifySendAttachments($formData = []): bool;

    /**
     * @param mixed $formData
     */
    public function getNotifyDeactivateMails($formData = []): bool;

    /**
     * @param mixed $formData
     */
    public function getCustomerDeactivateMails($formData = []): bool;

    /**
     * @param mixed $formData
     */
    public function getMailText($formData = []): string;

    /**
     * @param mixed $formData
     */
    public function getSuccessText($formData = []): string;

    /**
     * @deprecated
     */
    public function getDefaultIntention(): string;

    /**
     * @return string[]
     */
    public function getFileFields(): array;

    public function getCollectionId(): ?int;
}
