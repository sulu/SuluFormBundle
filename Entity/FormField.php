<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

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
     * @var integer
     */
    private $id;

    /**
     * @var FormFieldTranslation
     */
    private $defaultTranslation;

    /**
     * @var \Doctrine\Common\Collections\Collection|FormTranslation
     */
    private $translations;

    /**
     * @var Form
     */
    private $form;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set key
     *
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
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set type
     *
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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set width
     *
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
     * Get width
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set required
     *
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
     * Get required
     *
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
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
     * Set defaultTranslation
     *
     * @param FormFieldTranslation $defaultTranslation
     *
     * @return FormField
     */
    public function setDefaultTranslation(FormFieldTranslation $defaultTranslation = null)
    {
        $this->defaultTranslation = $defaultTranslation;

        return $this;
    }

    /**
     * @param string $locale
     * @param bool $create
     *
     * @return FormFieldTranslation
     */
    public function getTranslation($locale, $create = false)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }

        if ($create) {
            $translation = new FormFieldTranslation();
            $translation->setLocale($locale);

            return $translation;
        }
    }

    /**
     * Get defaultTranslation
     *
     * @return FormFieldTranslation
     */
    public function getDefaultTranslation()
    {
        return $this->defaultTranslation;
    }

    /**
     * Add translation
     *
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
     * Remove translation
     *
     * @param FormFieldTranslation $translation
     */
    public function removeTranslation(FormFieldTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection|FormFieldTranslation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set form
     *
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
     * Get form
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }
}
