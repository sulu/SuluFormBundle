<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'swiftmailer.mailer.default' shared service.

return $this->services['swiftmailer.mailer.default'] = new \Swift_Mailer(($this->services['swiftmailer.mailer.default.transport'] ?? $this->load('getSwiftmailer_Mailer_Default_TransportService.php')));
