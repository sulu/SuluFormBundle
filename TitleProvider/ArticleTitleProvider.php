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

use Sulu\Article\Domain\Model\ArticleDimensionContentInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleTitleProvider implements TitleProviderInterface
{
    public function __construct(
        private RequestStack $requestStack
    ) {
    }

    public function getTitle(string $typeId, ?string $locale = null): ?string
    {
        $request = $this->requestStack->getMainRequest();

        $articleDimension = $request->attributes->get('object');

        if (!$articleDimension instanceof ArticleDimensionContentInterface) {
            return null;
        }

        return $articleDimension->getTitle();
    }
}
