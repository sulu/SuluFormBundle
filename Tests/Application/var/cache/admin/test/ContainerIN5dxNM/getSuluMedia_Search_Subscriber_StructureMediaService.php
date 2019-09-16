<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_media.search.subscriber.structure_media' shared service.

return $this->privates['sulu_media.search.subscriber.structure_media'] = new \Sulu\Bundle\MediaBundle\Search\Subscriber\StructureMediaSearchSubscriber(($this->services['sulu_media.media_manager'] ?? $this->getSuluMedia_MediaManagerService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), 'sulu-100x100');
