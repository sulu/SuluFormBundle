<?php


namespace Sulu\Bundle\FormBundle\Mail;


interface HelperAwareInterface
{
    public function setHelper(HelperInterface $mailHelper): void;
}
