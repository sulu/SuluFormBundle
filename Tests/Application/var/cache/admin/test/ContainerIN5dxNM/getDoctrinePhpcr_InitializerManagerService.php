<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'doctrine_phpcr.initializer_manager' shared service.

return $this->services['doctrine_phpcr.initializer_manager'] = new \Doctrine\Bundle\PHPCRBundle\Initializer\InitializerManager(($this->services['doctrine_phpcr'] ?? $this->getDoctrinePhpcrService()));
