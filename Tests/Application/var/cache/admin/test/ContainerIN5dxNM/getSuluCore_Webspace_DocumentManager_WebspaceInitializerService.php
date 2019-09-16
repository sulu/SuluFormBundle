<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'sulu_core.webspace.document_manager.webspace_initializer' shared service.

return $this->services['sulu_core.webspace.document_manager.webspace_initializer'] = new \Sulu\Component\Webspace\Document\Initializer\WebspaceInitializer(($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), ($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), ($this->services['sulu_document_manager.document_inspector'] ?? $this->getSuluDocumentManager_DocumentInspectorService()), ($this->privates['sulu_document_manager.path_builder'] ?? $this->load('getSuluDocumentManager_PathBuilderService.php')), ($this->privates['sulu_document_manager.node_manager'] ?? $this->getSuluDocumentManager_NodeManagerService()));
