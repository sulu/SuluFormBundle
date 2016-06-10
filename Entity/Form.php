<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

class Form
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \L91\Sulu\Bundle\FormBundle\Entity\FormTranslation
     */
    private $defaultTranslation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $fields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormTranslation $defaultTranslation
     *
     * @return Form
     */
    public function setDefaultTranslation(\L91\Sulu\Bundle\FormBundle\Entity\FormTranslation $defaultTranslation = null)
    {
        $this->defaultTranslation = $defaultTranslation;

        return $this;
    }

    /**
     * Get defaultTranslation
     *
     * @return \L91\Sulu\Bundle\FormBundle\Entity\FormTranslation
     */
    public function getDefaultTranslation()
    {
        return $this->defaultTranslation;
    }

    /**
     * Add translation
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormTranslation $translation
     *
     * @return Form
     */
    public function addTranslation(\L91\Sulu\Bundle\FormBundle\Entity\FormTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormTranslation $translation
     */
    public function removeTranslation(\L91\Sulu\Bundle\FormBundle\Entity\FormTranslation $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Add field
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormFields $field
     *
     * @return Form
     */
    public function addField(\L91\Sulu\Bundle\FormBundle\Entity\FormFields $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove field
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormFields $field
     */
    public function removeField(\L91\Sulu\Bundle\FormBundle\Entity\FormFields $field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }
}
