<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

class FormTranslation
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
    private $options;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \L91\Sulu\Bundle\FormBundle\Entity\Form
     */
    private $form;


    /**
     * Set title
     *
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subject
     *
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
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set fromEmail
     *
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
     * Get fromEmail
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Set fromName
     *
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
     * Get fromName
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Set toEmail
     *
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
     * Get toEmail
     *
     * @return string
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * Set toName
     *
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
     * Get toName
     *
     * @return string
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * Set options
     *
     * @param string $options
     *
     * @return FormTranslation
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set locale
     *
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
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set form
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\Form $form
     *
     * @return FormTranslation
     */
    public function setForm(\L91\Sulu\Bundle\FormBundle\Entity\Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \L91\Sulu\Bundle\FormBundle\Entity\Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
