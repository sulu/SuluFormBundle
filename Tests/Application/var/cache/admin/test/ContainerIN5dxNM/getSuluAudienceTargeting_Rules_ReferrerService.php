<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_audience_targeting.rules.referrer' shared service.

return $this->privates['sulu_audience_targeting.rules.referrer'] = new \Sulu\Bundle\AudienceTargetingBundle\Rule\ReferrerRule(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->services['translator'] ?? $this->getTranslatorService()), 'X-Forwarded-Referrer');
