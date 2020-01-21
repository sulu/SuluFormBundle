<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Component\HttpCache\HandlerInvalidateReferenceInterface;

/**
 * Invalidate references when form is persisted.
 */
class CacheInvalidationListener
{
    /**
     * @var HandlerInvalidateReferenceInterface
     */
    private $invalidationHandler;

    public function __construct(HandlerInvalidateReferenceInterface $invalidationHandler)
    {
        $this->invalidationHandler = $invalidationHandler;
    }

    public function postUpdate(LifecycleEventArgs $eventArgs): void
    {
        $this->invalidateEntity($eventArgs->getObject());
    }

    public function preRemove(LifecycleEventArgs $eventArgs): void
    {
        $this->invalidateEntity($eventArgs->getObject());
    }

    /**
     * @param Form|FormTranslation $object
     */
    private function invalidateEntity($object): void
    {
        if ($object instanceof Form) {
            $this->invalidationHandler->invalidateReference('form', $object->getId());
        } elseif ($object instanceof FormTranslation) {
            $this->invalidateEntity($object->getForm());
        }
    }
}
