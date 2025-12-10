<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Content\PropertyResolver;

use Sulu\Bundle\FormBundle\Content\ResourceLoader\FormResourceLoader;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Content\Application\ContentResolver\Value\ContentView;
use Sulu\Content\Application\PropertyResolver\Resolver\PropertyResolverInterface;

final class SingleFormSelectionPropertyResolver implements PropertyResolverInterface
{
    public function __construct(private FormRepository $formRepository)
    {
    }

    public function resolve(mixed $data, string $locale, array $params = []): ContentView
    {
        if (!\is_numeric($data)) {
            return ContentView::create(null, ['id' => null, ...$params]);
        }

        if (!\array_key_exists('resourceKey', $params)) {
            throw new \InvalidArgumentException('Missing resource key configuration on the ' . self::getType() . '');
        }

        /** @var string $resourceLoaderKey */
        $resourceLoaderKey = $params['resourceLoaderKey'] ?? FormResourceLoader::getKey();

        return ContentView::createResolvableWithReferences(
            (int) $data,
            $resourceLoaderKey,
            Form::RESOURCE_KEY,
            [
                'id' => $data,
                'entity' => $this->formRepository->find((int) $data)?->serializeForLocale($locale),
                ...$params,
            ],
            metadata: $params
        );
    }

    public static function getType(): string
    {
        return 'single_form_selection';
    }
}
