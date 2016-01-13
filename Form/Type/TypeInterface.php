<?php

namespace L91\Sulu\Bundle\FormBundle\Form\Type;

interface TypeInterface
{
    /**
     * @param array
     */
    public function setAttributes($attributes);

    /**
     * @param $formData
     * @return string
     */
    public function getCustomerSubject($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getNotifySubject($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getCustomerMail($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getNotifyMail($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getCustomerFromMailAddress($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getCustomerToMailAddress($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getCustomerReplyToMailAddress($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getNotifyFromMailAddress($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getNotifyToMailAddress($formData = array());

    /**
     * @param $formData
     * @return string
     */
    public function getNotifyReplyToMailAddress($formData = array());

    /**
     * @return string
     */
    public function getDefaultIntention();
}