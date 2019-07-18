<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Entity;

class FormTranslationReceiver
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var FormTranslation
     */
    private $formTranslation;

    /**
     * Returns id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param int $id
     *
     * @return FormTranslationReceiver
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets type.
     *
     * @param string $type
     *
     * @return FormTranslationReceiver
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * @param string $email
     *
     * @return FormTranslationReceiver
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Returns name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return FormTranslationReceiver
     */
    public function setName($name)
    {
        $name = $name ?: '';
        $this->name = $name;

        return $this;
    }

    /**
     * Returns formTranslation.
     *
     * @return FormTranslation
     */
    public function getFormTranslation()
    {
        return $this->formTranslation;
    }

    /**
     * Sets formTranslation.
     *
     * @param FormTranslation $formTranslation
     *
     * @return FormTranslationReceiver
     */
    public function setFormTranslation($formTranslation)
    {
        $this->formTranslation = $formTranslation;

        return $this;
    }
}
