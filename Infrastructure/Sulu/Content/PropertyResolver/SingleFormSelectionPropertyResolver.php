<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\PropertyResolver;

use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\ResourceLoader\FormResourceLoader;
use Sulu\Content\Application\ContentResolver\Value\ContentView;
use Sulu\Content\Application\PropertyResolver\Resolver\PropertyResolverInterface;
use Symfony\Component\Form\FormView;

class SingleFormSelectionPropertyResolver implements PropertyResolverInterface
{
    public function resolve(mixed $data, string $locale, array $params = []): ContentView
    {
        if (!\is_numeric($data)) {
            return ContentView::create(null, ['id' => null, ...$params]);
        }

        /** @var string $resourceLoaderKey */
        $resourceLoaderKey = $params['resourceLoader'] ?? FormResourceLoader::getKey();

        $callback = static function(?array $resource): ?FormView {
            $view = $resource['view'] ?? null;

            return $view instanceof FormView ? $view : null;
        };

        return ContentView::createResolvableWithReferences(
            id: (int) $data,
            resourceLoaderKey: $resourceLoaderKey,
            resourceKey: Form::RESOURCE_KEY,
            view: ['id' => $data, ...$params],
            closure: $callback,
        );
    }

    public static function getType(): string
    {
        return 'single_form_selection';
    }
}
