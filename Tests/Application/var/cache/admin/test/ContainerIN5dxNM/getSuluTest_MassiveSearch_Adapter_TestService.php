<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'sulu_test.massive_search.adapter.test' shared service.

return $this->services['sulu_test.massive_search.adapter.test'] = new \Massive\Bundle\SearchBundle\Search\Adapter\TestAdapter(($this->privates['sulu_search.search.factory'] ?? ($this->privates['sulu_search.search.factory'] = new \Sulu\Bundle\SearchBundle\Search\Factory())));
