<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_audience_targeting.target_group_evaluator' shared service.

return $this->privates['sulu_audience_targeting.target_group_evaluator'] = new \Sulu\Bundle\AudienceTargetingBundle\TargetGroup\TargetGroupEvaluator(($this->privates['sulu_audience_targeting.rules_collection'] ?? $this->load('getSuluAudienceTargeting_RulesCollectionService.php')), ($this->services['sulu.repository.target_group'] ?? $this->getSulu_Repository_TargetGroupService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()));
