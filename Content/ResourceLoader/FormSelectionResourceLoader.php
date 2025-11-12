<?php

declare(strict_types=1);

namespace Sulu\Bundle\FormBundle\Content\ResourceLoader;

use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderInterface;

class FormSelectionResourceLoader implements ResourceLoaderInterface
{
    public const string RESOURCE_LOADER_KEY = 'sulu_form';

    public function __construct(
        private FormRepository $formRepository,
    ) {}

    public function load(array $ids, ?string $locale, array $params = []): array
    {
        $data = [];
        $formEntities = $this->formRepository->loadByIds($ids, $locale);
        foreach ($formEntities as $entity) {
            $data[$entity->getId()] = [
                'entity' => $entity->serializeForLocale($locale),
            ];
        }

        return $data;
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
