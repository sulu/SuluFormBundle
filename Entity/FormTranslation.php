<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sulu\Component\Persistence\Model\AuditableInterface;
use Sulu\Component\Persistence\Model\AuditableTrait;

/**
 * Form translation entity.
 */
class FormTranslation implements AuditableInterface
{
    use AuditableTrait;

    /**
     * @var string
     */
    private $title;

    /**
     * @var null|string
     */
    private $subject;

    /**
     * @var string|null
     */
    private $fromEmail;

    /**
     * @var null|string
     */
    private $fromName;

    /**
     * @var string|null
     */
    private $toEmail;

    /**
     * @var null|string
     */
    private $toName;

    /**
     * @var null|string
     */
    private $mailText;

    /**
     * @var null|string
     */
    private $submitLabel;

    /**
     * @var null|string
     */
    private $successText;

    /**
     * @var bool
     */
    private $sendAttachments = false;

    /**
     * @var bool
     */
    private $deactivateAttachmentSave = false;

    /**
     * @var bool
     */
    private $deactivateNotifyMails = false;

    /**
     * @var bool
     */
    private $deactivateCustomerMails = false;

    /**
     * @var bool
     */
    private $replyTo = false;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var null|int
     */
    private $id;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var Collection<int, FormTranslationReceiver>
     */
    private $receivers;

    public function __construct()
    {
        $this->receivers = new ArrayCollection();
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setFromEmail(?string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    public function setFromName(?string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setToEmail(?string $toEmail): self
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    public function getToEmail(): ?string
    {
        return $this->toEmail;
    }

    public function setToName(?string $toName): self
    {
        $this->toName = $toName;

        return $this;
    }

    public function getToName(): ?string
    {
        return $this->toName;
    }

    public function setMailText(?string $mailText): self
    {
        $this->mailText = $mailText;

        return $this;
    }

    public function getMailText(): ?string
    {
        return $this->mailText;
    }

    public function setSubmitLabel(?string $submitLabel): self
    {
        $this->submitLabel = $submitLabel;

        return $this;
    }

    public function getSubmitLabel(): ?string
    {
        return $this->submitLabel;
    }

    public function setSuccessText(?string $successText): self
    {
        $this->successText = $successText;

        return $this;
    }

    public function getSuccessText(): ?string
    {
        return $this->successText;
    }

    public function setSendAttachments(bool $sendAttachments): self
    {
        $this->sendAttachments = $sendAttachments;

        return $this;
    }

    public function getSendAttachments(): bool
    {
        return $this->sendAttachments;
    }

    public function getDeactivateAttachmentSave(): bool
    {
        return $this->deactivateAttachmentSave;
    }

    public function setDeactivateAttachmentSave(bool $deactivateAttachmentSave): self
    {
        $this->deactivateAttachmentSave = $deactivateAttachmentSave;

        return $this;
    }

    public function setDeactivateNotifyMails(bool $deactivateNotifyMails): self
    {
        $this->deactivateNotifyMails = $deactivateNotifyMails;

        return $this;
    }

    public function getDeactivateNotifyMails(): bool
    {
        return $this->deactivateNotifyMails;
    }

    public function setDeactivateCustomerMails(bool $deactivateCustomerMails): self
    {
        $this->deactivateCustomerMails = $deactivateCustomerMails;

        return $this;
    }

    public function getDeactivateCustomerMails(): bool
    {
        return $this->deactivateCustomerMails;
    }

    public function setReplyTo(bool $replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    public function getReplyTo(): bool
    {
        return $this->replyTo;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setForm(Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * @return Collection<int, FormTranslationReceiver>
     */
    public function getReceivers()
    {
        return $this->receivers;
    }

    public function addReceiver(FormTranslationReceiver $receiver): self
    {
        $this->receivers[] = $receiver;

        return $this;
    }

    public function removeReceiver(FormTranslationReceiver $receiver): self
    {
        $this->receivers->removeElement($receiver);

        return $this;
    }
}
