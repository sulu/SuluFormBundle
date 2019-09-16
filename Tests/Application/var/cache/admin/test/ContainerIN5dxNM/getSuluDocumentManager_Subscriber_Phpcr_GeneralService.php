<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_document_manager.subscriber.phpcr.general' shared service.

return $this->privates['sulu_document_manager.subscriber.phpcr.general'] = new \Sulu\Component\DocumentManager\Subscriber\Phpcr\GeneralSubscriber(($this->privates['sulu_document_manager.document_registry'] ?? ($this->privates['sulu_document_manager.document_registry'] = new \Sulu\Component\DocumentManager\DocumentRegistry('en'))), ($this->privates['sulu_document_manager.node_manager'] ?? $this->getSuluDocumentManager_NodeManagerService()), ($this->privates['sulu_document_manager.node_helper'] ?? ($this->privates['sulu_document_manager.node_helper'] = new \Sulu\Component\DocumentManager\NodeHelper())), ($this->privates['sulu_document_manager.event_dispatcher.standard'] ?? $this->getSuluDocumentManager_EventDispatcher_StandardService()));
