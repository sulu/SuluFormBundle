<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'massive_search.reindex.provider.doctrine_orm' shared service.

return $this->privates['massive_search.reindex.provider.doctrine_orm'] = new \Massive\Bundle\SearchBundle\Search\Reindex\Provider\DoctrineOrmProvider(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->privates['massive_search.metadata.factory'] ?? $this->load('getMassiveSearch_Metadata_FactoryService.php')));
