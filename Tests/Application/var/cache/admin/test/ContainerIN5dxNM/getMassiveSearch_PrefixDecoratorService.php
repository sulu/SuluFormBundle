<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'massive_search.prefix_decorator' shared service.

return $this->privates['massive_search.prefix_decorator'] = new \Massive\Bundle\SearchBundle\Search\Decorator\PrefixDecorator(($this->privates['massive_search.localization_decorator'] ?? $this->load('getMassiveSearch_LocalizationDecoratorService.php')), 'massive');
