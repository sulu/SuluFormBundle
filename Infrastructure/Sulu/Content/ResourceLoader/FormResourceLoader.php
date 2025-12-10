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

use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderInterface;

class FormResourceLoader implements ResourceLoaderInterface
{
    public const RESOURCE_LOADER_KEY = 'form';

    public function __construct(
        private FormRepository $formRepository,
    ) {
    }

    public function load(array $ids, ?string $locale, array $params = []): array
    {
        $intIds = \array_map(static fn ($id) => (int) $id, $ids);
        $result = $this->formRepository->loadByIds($intIds, $locale);

        $mappedResult = [];
        foreach ($result as $form) {
            $mappedResult[$form->getId()] = $form;
        }

        return $mappedResult;
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
