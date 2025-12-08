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

namespace Sulu\Bundle\FormBundle\Content\ResourceLoader;

use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderInterface;
use Symfony\Component\Form\FormView;

final class FormSelectionResourceLoader implements ResourceLoaderInterface
{
    public const string RESOURCE_LOADER_KEY = 'sulu_form';

    public function __construct(
        private BuilderInterface $formBuilder,
    ) {
    }

    public function load(array $ids, ?string $locale, array $params = []): array
    {
        $data = [];
        foreach ($ids as $id) {
            $data[$id] = $this->loadForm((int) $id, $params['resourceKey'], 'typeId', $locale, 'form');
        }

        return $data;
    }

    private function loadForm(
        int $id,
        string $type,
        string $typeId,
        ?string $locale,
        string $name,
    ): ?FormView {
        $form = $this->formBuilder->build(
            $id,
            $type,
            $typeId,
            $locale,
            $name,
        );

        return $form?->createView();
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
