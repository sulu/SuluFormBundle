<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

class FormFieldTranslation
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \L91\Sulu\Bundle\FormBundle\Entity\FormField
     */
    private $field;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return FormFieldTranslation
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
     * Set locale
     *
     * @param string $locale
     *
     * @return FormFieldTranslation
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
     * Set field
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\FormField $field
     *
     * @return FormFieldTranslation
     */
    public function setField(\L91\Sulu\Bundle\FormBundle\Entity\FormField $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get field
     *
     * @return \L91\Sulu\Bundle\FormBundle\Entity\FormField
     */
    public function getField()
    {
        return $this->field;
    }
}
