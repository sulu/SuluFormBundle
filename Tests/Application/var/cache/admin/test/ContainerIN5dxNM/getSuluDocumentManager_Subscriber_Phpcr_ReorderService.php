<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'sulu_document_manager.subscriber.phpcr.reorder' shared service.

return $this->privates['sulu_document_manager.subscriber.phpcr.reorder'] = new \Sulu\Component\DocumentManager\Subscriber\Phpcr\ReorderSubscriber(($this->privates['sulu_document_manager.node_helper'] ?? ($this->privates['sulu_document_manager.node_helper'] = new \Sulu\Component\DocumentManager\NodeHelper())));
