<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_page.teaser.provider_pool' shared service.

return $this->privates['sulu_page.teaser.provider_pool'] = new \Sulu\Bundle\PageBundle\Teaser\Provider\TeaserProviderPool(['pages' => ($this->privates['sulu_page.teaser.provider.content'] ?? $this->load('getSuluPage_Teaser_Provider_ContentService.php'))]);
