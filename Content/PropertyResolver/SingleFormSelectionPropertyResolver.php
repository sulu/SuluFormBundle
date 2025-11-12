<?php

namespace Sulu\Bundle\FormBundle\Content\PropertyResolver;

use Sulu\Bundle\FormBundle\Content\ResourceLoader\FormSelectionResourceLoader;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Content\Application\ContentResolver\Value\ContentView;
use Sulu\Content\Application\PropertyResolver\Resolver\PropertyResolverInterface;

final class SingleFormSelectionPropertyResolver implements PropertyResolverInterface
{
    public function resolve(mixed $data, string $locale, array $params = []): ContentView
    {
        if (!is_numeric($data)) {
            return ContentView::create(null, ['id' => null, ...$params]);
        }

        /** @var string $resourceLoaderKey */
        $resourceLoaderKey = $params['resourceLoaderKey'] ?? FormSelectionResourceLoader::getKey();

        return ContentView::createResolvableWithReferences(
            (int) $data,
            $resourceLoaderKey,
            Form::RESOURCE_KEY,
            [
                'id' => $data,
                ...$params
            ]
        );
    }

    public static function getType(): string
    {
        return 'SingleFormSelection';
    }
}
