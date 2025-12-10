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

use Sulu\Content\Domain\Model\DimensionContentInterface;
use Sulu\Content\Domain\Model\TemplateInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides the title from the current page/article content.
 */
class StructureTitleProvider implements TitleProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function getTitle(string $typeId, ?string $locale = null): ?string
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return null;
        }

        $object = $request->attributes->get('object');

        if (!$object instanceof DimensionContentInterface) {
            return null;
        }

        $resourceId = (string) $object->getResource()->getId();
        if ($resourceId !== $typeId) {
            return null;
        }

        if (!$object instanceof TemplateInterface) {
            return null;
        }

        $templateData = $object->getTemplateData();
        $title = $templateData['title'] ?? null;

        return \is_string($title) ? $title : null;
    }
}
