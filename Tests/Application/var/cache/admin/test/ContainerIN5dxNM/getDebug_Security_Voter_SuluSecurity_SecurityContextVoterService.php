<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'debug.security.voter.sulu_security.security_context_voter' shared service.

return $this->privates['debug.security.voter.sulu_security.security_context_voter'] = new \Symfony\Component\Security\Core\Authorization\Voter\TraceableVoter(($this->privates['sulu_security.security_context_voter'] ?? $this->load('getSuluSecurity_SecurityContextVoterService.php')), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));
