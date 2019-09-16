<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_custom_urls.repository' shared service.

return $this->privates['sulu_custom_urls.repository'] = new \Sulu\Component\CustomUrl\Repository\CustomUrlRepository(($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->services['sulu_page.content_repository'] ?? $this->getSuluPage_ContentRepositoryService()), ($this->privates['sulu_custom_urls.domain_generator'] ?? $this->load('getSuluCustomUrls_DomainGeneratorService.php')), ($this->services['sulu_security.user_manager'] ?? $this->load('getSuluSecurity_UserManagerService.php')));
