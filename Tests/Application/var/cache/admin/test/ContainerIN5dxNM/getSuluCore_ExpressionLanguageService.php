<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_core.expression_language' shared service.

return $this->privates['sulu_core.expression_language'] = new \Symfony\Component\ExpressionLanguage\ExpressionLanguage(NULL, [0 => ($this->privates['sulu_core.symfony_expression_language_provider'] ?? ($this->privates['sulu_core.symfony_expression_language_provider'] = new \Sulu\Bundle\CoreBundle\ExpressionLanguage\ContainerExpressionLanguageProvider($this)))]);
