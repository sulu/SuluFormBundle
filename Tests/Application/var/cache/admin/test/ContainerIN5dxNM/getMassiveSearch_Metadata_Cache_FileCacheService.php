<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'massive_search.metadata.cache.file_cache' shared service.

return $this->privates['massive_search.metadata.cache.file_cache'] = new \Metadata\Cache\FileCache(($this->targetDirs[0].'/massive-search'));
