<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_snippet.command.locale_copy' shared service.

$this->privates['sulu_snippet.command.locale_copy'] = $instance = new \Sulu\Bundle\SnippetBundle\Command\SnippetLocaleCopyCommand(($this->services['sulu_snippet.repository'] ?? $this->load('getSuluSnippet_RepositoryService.php')), ($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->services['sulu_test.doctrine_phpcr.default_session'] ?? $this->getSuluTest_DoctrinePhpcr_DefaultSessionService()), ($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), 'i18n');

$instance->setName('sulu:snippet:locale-copy');

return $instance;
