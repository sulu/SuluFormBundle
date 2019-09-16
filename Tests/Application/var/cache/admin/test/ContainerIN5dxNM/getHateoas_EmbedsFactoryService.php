<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'hateoas.embeds_factory' shared service.

return $this->privates['hateoas.embeds_factory'] = new \Hateoas\Factory\EmbeddedsFactory(($this->privates['hateoas.configuration.relations_repository'] ?? $this->getHateoas_Configuration_RelationsRepositoryService()), ($this->privates['hateoas.expression.evaluator'] ?? $this->getHateoas_Expression_EvaluatorService()), ($this->privates['hateoas.serializer.exclusion_manager'] ?? $this->load('getHateoas_Serializer_ExclusionManagerService.php')));
