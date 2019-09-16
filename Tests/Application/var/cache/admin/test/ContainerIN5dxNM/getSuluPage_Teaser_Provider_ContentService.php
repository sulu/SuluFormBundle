<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_page.teaser.provider.content' shared service.

return $this->privates['sulu_page.teaser.provider.content'] = new \Sulu\Bundle\PageBundle\Teaser\PageTeaserProvider(($this->services['massive_search.search_manager'] ?? $this->load('getMassiveSearch_SearchManagerService.php')), ($this->services['translator'] ?? $this->getTranslatorService()));
