<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\HttpCacheBundle\Cache\CacheManagerInterface;

/**
 * Invalidate references when form is persisted.
 */
class CacheInvalidationListener
{
    /**
     * @var null|CacheManagerInterface
     */
    private $cacheManager;

    public function __construct(?CacheManagerInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function postUpdate(PostUpdateEventArgs|LifecycleEventArgs $eventArgs): void
    {
        $this->invalidateEntity($eventArgs->getObject());
    }

    public function preRemove(PreRemoveEventArgs|LifecycleEventArgs $eventArgs): void
    {
        $this->invalidateEntity($eventArgs->getObject());
    }

    private function invalidateEntity(object $object): void
    {
        if (!$this->cacheManager) {
            return;
        }

        if ($object instanceof Form) {
            $this->cacheManager->invalidateReference('contact', (string) $object->getId());
        } elseif ($object instanceof FormTranslation) {
            $this->invalidateEntity($object->getForm());
        }
    }
}
