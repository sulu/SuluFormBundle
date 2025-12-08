<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Service\ResetInterface;

class CachedBuilder implements BuilderInterface, ResetInterface
{
    /** @var array<string, FormInterface|null> */
    private array $cache = [];

    public function __construct(
        private BuilderInterface $inner,
        private RequestStack $requestStack,
    ) {
    }

    public function buildByRequest(Request $request): ?FormInterface
    {
        return $this->inner->buildByRequest($request);
    }

    public function build(int $id, string $type, string $typeId, ?string $locale = null, string $name = 'form'): ?FormInterface
    {
        if (null === $locale) {
            $locale = $this->requestStack->getCurrentRequest()?->getLocale();
        }

        // Check if form was built before and return the cached form.
        $key = $this->getKey($id, $type, $typeId, $locale, $name);

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = $this->inner->build($id, $type, $typeId, $locale, $name);
        }

        return $this->cache[$key];
    }

    private function getKey(int $id, string $type, string $typeId, ?string $locale, string $name): string
    {
        return \implode('__', \func_get_args());
    }

    public function reset(): void
    {
        $this->cache = [];
    }
}
