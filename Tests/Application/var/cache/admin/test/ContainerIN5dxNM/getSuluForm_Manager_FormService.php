<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'sulu_form.manager.form' shared service.

return $this->services['sulu_form.manager.form'] = new \Sulu\Bundle\FormBundle\Manager\FormManager(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->privates['sulu_form.repository.form'] ?? $this->getSuluForm_Repository_FormService()), NULL);
