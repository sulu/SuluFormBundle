<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\TitleProvider;

use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * The attached structure type.
 */
class StructureTitleProvider implements TitleProviderInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle($typeId, ?string $locale = null)
    {
        $request = $this->requestStack->getMasterRequest();
        $structure = $request->attributes->get('structure');

        if (!$structure instanceof StructureInterface || $structure->getUuid() !== $typeId) {
            return;
        }

        $property = $structure->getProperty('title');

        if (!$property) {
            return;
        }

        return $property->getValue();
    }
}
