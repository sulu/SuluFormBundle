<?php

namespace L91\Bundle\FormBundle\Form\Type;

interface TypeInterface
{
    /**
     * @param array
     */
    public function setAttributes($attributes);

    /**
     * @return string
     */
    public function getSuccessMail();

    /**
     * @return string
     */
    public function getNotifyMail();
}