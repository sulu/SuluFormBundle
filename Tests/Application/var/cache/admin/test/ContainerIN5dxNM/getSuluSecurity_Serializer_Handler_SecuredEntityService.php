<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_security.serializer.handler.secured_entity' shared service.

return $this->privates['sulu_security.serializer.handler.secured_entity'] = new \Sulu\Component\Security\Serializer\Subscriber\SecuredEntitySubscriber(($this->privates['sulu_security.access_control_manager'] ?? $this->load('getSuluSecurity_AccessControlManagerService.php')), ($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())));
