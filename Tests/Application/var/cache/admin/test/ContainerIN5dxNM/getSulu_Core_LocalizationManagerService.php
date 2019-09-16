<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'sulu.core.localization_manager' shared service.

$this->services['sulu.core.localization_manager'] = $instance = new \Sulu\Component\Localization\Manager\LocalizationManager();

$instance->addLocalizationProvider(new \Sulu\Component\Webspace\Manager\WebspaceManager(($this->privates['sulu_core.webspace.loader.delegator'] ?? $this->getSuluCore_Webspace_Loader_DelegatorService()), ($this->privates['sulu_core.webspace.webspace_manager.url_replacer'] ?? ($this->privates['sulu_core.webspace.webspace_manager.url_replacer'] = new \Sulu\Component\Webspace\Url\Replacer())), ['config_dir' => ($this->targetDirs[4].'/config/webspaces'), 'cache_dir' => ($this->targetDirs[0].'/sulu'), 'debug' => true, 'cache_class' => 'adminWebspaceCollectionCache', 'base_class' => 'WebspaceCollection']));

return $instance;
