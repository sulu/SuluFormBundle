<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\ResourceLoader;

use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderInterface;

class FormResourceLoader implements ResourceLoaderInterface
{
    public const RESOURCE_LOADER_KEY = 'form';

    public function __construct(
        private FormRepository $formRepository,
    ) {
    }

    /**
     * @param array<int|string> $ids
     *
     * @return array<int, Form>
     */
    public function load(array $ids, ?string $locale, array $params = []): array
    {
        if (null === $locale) {
            return [];
        }

        $intIds = \array_map(static fn ($id) => (int) $id, $ids);
        $mapped = $this->loadForLocale($intIds, $locale);

        $missingIds = \array_values(\array_diff($intIds, \array_keys($mapped)));
        $shadowLocale = $params['_shadowLocale'] ?? null;
        if ([] !== $missingIds && \is_string($shadowLocale)) {
            $mapped += $this->loadForLocale($missingIds, $shadowLocale);
        }

        return $mapped;
    }

    /**
     * @param int[] $ids
     *
     * @return array<int, Form>
     */
    private function loadForLocale(array $ids, string $locale): array
    {
        if ([] === $ids) {
            return [];
        }

        $mapped = [];
        foreach ($this->formRepository->loadByIds($ids, $locale) as $form) {
            // loadByIds ignores the locale filter, so check the translation explicitly.
            if (null === $form->getTranslation($locale)) {
                continue;
            }

            $id = $form->getId();
            \assert(null !== $id);
            $mapped[$id] = $form;
        }

        return $mapped;
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
