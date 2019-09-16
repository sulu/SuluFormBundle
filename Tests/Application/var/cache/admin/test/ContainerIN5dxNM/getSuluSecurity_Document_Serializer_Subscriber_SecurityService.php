<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_security.document.serializer.subscriber.security' shared service.

return $this->privates['sulu_security.document.serializer.subscriber.security'] = new \Sulu\Bundle\SecurityBundle\Serializer\Subscriber\SecuritySubscriber(($this->privates['sulu_security.access_control_manager'] ?? $this->load('getSuluSecurity_AccessControlManagerService.php')), ($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())));
