<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_document_manager.document.subscriber.shadow_copy_properties' shared service.

return $this->privates['sulu_document_manager.document.subscriber.shadow_copy_properties'] = new \Sulu\Component\Content\Document\Subscriber\ShadowCopyPropertiesSubscriber(($this->services['sulu_document_manager.property_encoder'] ?? $this->getSuluDocumentManager_PropertyEncoderService()));
