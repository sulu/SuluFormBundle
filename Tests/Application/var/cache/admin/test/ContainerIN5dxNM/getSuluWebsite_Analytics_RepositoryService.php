<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_website.analytics.repository' shared service.

$this->privates['sulu_website.analytics.repository'] = $instance = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService())->getRepository('SuluWebsiteBundle:Analytics');

$instance->setEnvironment('test');

return $instance;
