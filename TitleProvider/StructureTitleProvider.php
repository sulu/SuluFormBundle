<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\TitleProvider;

use Sulu\Component\Content\Compat\PropertyInterface;
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

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getTitle(string $typeId, ?string $locale = null): ?string
    {
        $request = \method_exists($this->requestStack, 'getMainRequest') ? $this->requestStack->getMainRequest() : $this->requestStack->getMasterRequest();
        $structure = $request->attributes->get('structure');

        if (!$structure instanceof StructureInterface || $structure->getUuid() !== $typeId) {
            return null;
        }

        /** @var PropertyInterface|null $property */
        $property = $structure->getProperty('title');

        if (!$property) {
            return null;
        }

        return $property->getValue();
    }
}
