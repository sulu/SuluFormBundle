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
     *
     * @return string
     */
    public function getCustomerSubject($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getNotifySubject($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getCustomerMail($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getNotifyMail($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getCustomerFromMailAddress($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getCustomerToMailAddress($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getCustomerReplyToMailAddress($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getNotifyFromMailAddress($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getNotifyToMailAddress($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getNotifyReplyToMailAddress($formData = []);

    /**
     * @param $formData
     *
     * @return bool
     */
    public function getNotifySendAttachments($formData = []);

    /**
     * @param $formData
     *
     * @return bool
     */
    public function getNotifyDeactivateMails($formData = []);

    /**
     * @param $formData
     *
     * @return bool
     */
    public function getCustomerDeactivateMails($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getMailText($formData = []);

    /**
     * @param $formData
     *
     * @return string
     */
    public function getSuccessText($formData = []);

    /**
     * @deprecated
     *
     * @return string
     */
    public function getDefaultIntention();

    /**
     * @return string[]
     */
    public function getFileFields();

    /**
     * @return int
     */
    public function getCollectionId();
}
