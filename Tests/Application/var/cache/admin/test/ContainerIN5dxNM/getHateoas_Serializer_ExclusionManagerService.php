<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'hateoas.serializer.exclusion_manager' shared service.

return $this->privates['hateoas.serializer.exclusion_manager'] = new \Hateoas\Serializer\ExclusionManager(($this->privates['hateoas.expression.evaluator'] ?? $this->getHateoas_Expression_EvaluatorService()));
