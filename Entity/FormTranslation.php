<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

use Sulu\Component\Persistence\Model\AuditableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FormTranslation implements AuditableInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $fromEmail;

    /**
     * @var string
     */
    private $fromName;

    /**
     * @var string
     */
    private $toEmail;

    /**
     * @var string
     */
    private $toName;

    /**
     * @var string
     */
    private $mailText;

    /**
     * @var string
     */
    private $successText;

    /**
     * @var bool
     */
    private $sendAttachments;

    /**
     * @var bool
     */
    private $deactivateNotifyMails;

    /**
     * @var bool
     */
    private $deactivateCustomerMails;

    /**
     * @var bool
     */
    private $replyTo;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var UserInterface
     */
    private $creator;

    /**
     * @var UserInterface
     */
    private $changer;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;

    /**
     * @param string $title
     *
     * @return FormTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $subject
     *
     * @return FormTranslation
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $fromEmail
     *
     * @return FormTranslation
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param string $fromName
     *
     * @return FormTranslation
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $toEmail
     *
     * @return FormTranslation
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * @param string $toName
     *
     * @return FormTranslation
     */
    public function setToName($toName)
    {
        $this->toName = $toName;

        return $this;
    }

    /**
     * @return string
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * @param string $mailText
     *
     * @return FormTranslation
     */
    public function setMailText($mailText)
    {
        $this->mailText = $mailText;

        return $this;
    }

    /**
     * @return string
     */
    public function getMailText()
    {
        return $this->mailText;
    }

    /**
     * @param string $successText
     *
     * @return FormTranslation
     */
    public function setSuccessText($successText)
    {
        $this->successText = $successText;

        return $this;
    }

    /**
     * @return string
     */
    public function getSuccessText()
    {
        return $this->successText;
    }

    /**
     * @param bool $sendAttachments
     *
     * @return $this
     */
    public function setSendAttachments($sendAttachments)
    {
        $this->sendAttachments = $sendAttachments;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSendAttachments()
    {
        return $this->sendAttachments;
    }

    /**
     * Set deactivateNotifyMails.
     *
     * @param bool $deactivateNotifyMails
     *
     * @return FormTranslation
     */
    public function setDeactivateNotifyMails($deactivateNotifyMails)
    {
        $this->deactivateNotifyMails = $deactivateNotifyMails;

        return $this;
    }

    /**
     * Get deactivateNotifyMails.
     *
     * @return bool
     */
    public function getDeactivateNotifyMails()
    {
        return $this->deactivateNotifyMails;
    }

    /**
     * Set deactivateCustomerMails.
     *
     * @param bool $deactivateCustomerMails
     *
     * @return FormTranslation
     */
    public function setDeactivateCustomerMails($deactivateCustomerMails)
    {
        $this->deactivateCustomerMails = $deactivateCustomerMails;

        return $this;
    }

    /**
     * Get deactivateCustomerMails.
     *
     * @return bool
     */
    public function getDeactivateCustomerMails()
    {
        return $this->deactivateCustomerMails;
    }

    /**
     * Set replyTo.
     *
     * @param bool $replyTo
     *
     * @return FormTranslation
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Get replyTo.
     *
     * @return bool
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param string $locale
     *
     * @return FormTranslation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Form $form
     *
     * @return FormTranslation
     */
    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return UserInterface
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param UserInterface $creator
     *
     * @return FormTranslation
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getChanger()
    {
        return $this->changer;
    }

    /**
     * @param UserInterface $changer
     *
     * @return FormTranslation
     */
    public function setChanger($changer)
    {
        $this->changer = $changer;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return FormTranslation
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * @param \DateTime $changed
     *
     * @return FormTranslation
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }
}
