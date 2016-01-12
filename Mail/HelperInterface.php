<?php
/**
 * Created by IntelliJ IDEA.
 * User: Alexander
 * Date: 13.06.2015
 * Time: 17:20
 */
namespace L91\Sulu\Bundle\FormBundle\Mail;

interface HelperInterface
{
    /**
     * @param string $subject
     * @param string $body
     * @param string $toMail
     * @param string $fromMail
     * @param bool $html
     * @return int
     */
    public function sendMail($subject, $body, $toMail = null, $fromMail = null, $html = true, $attachments = array());
}