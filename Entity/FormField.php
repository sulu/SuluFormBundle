<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class FormField
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $width;

    /**
     * @var bool
     */
    private $required;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $order;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var \Doctrine\Common\Collections\Collection|FormTranslation[]
     */
    private $translations;

    /**
     * @var Form
     */
    private $form;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * @param string $defaultLocale
     *
     * @return FormField
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     *
     * @return FormField
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return FormField
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $type
     *
     * @return FormField
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $width
     *
     * @return FormField
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param bool $required
     *
     * @return FormField
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $locale
     * @param bool $create
     *
     * @return FormFieldTranslation|null
     */
    public function getTranslation($locale, $create = false)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }

        if (!$create) {
            return;
        }

        $translation = new FormFieldTranslation();
        $translation->setLocale($locale);

        return $translation;
    }

    /**
     * @param FormFieldTranslation $translation
     *
     * @return FormField
     */
    public function addTranslation(FormFieldTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * @param FormFieldTranslation $translation
     */
    public function removeTranslation(FormFieldTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|FormFieldTranslation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param Form $form
     *
     * @return FormField
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
}
