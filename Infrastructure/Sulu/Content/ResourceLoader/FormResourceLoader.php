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

namespace Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\ResourceLoader;

use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Sulu\Content\Application\ContentResolver\Value\ContentView;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderContentViewEnhancementInterface;
use Sulu\Content\Domain\Model\DimensionContentInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

class FormResourceLoader implements ResourceLoaderContentViewEnhancementInterface
{
    public const RESOURCE_LOADER_KEY = 'form';

    private const FORM_NAME = 'form';

    public function __construct(
        private FormRepository $formRepository,
        private BuilderInterface $formBuilder,
        private TitleProviderPoolInterface $titleProviderPool,
        private RequestStack $requestStack,
    ) {
    }

    /**
     * @param array<int|string> $ids
     *
     * @return array<int, array{view: FormView|null, entity: array<mixed>}>
     */
    public function load(array $ids, ?string $locale, array $params = []): array
    {
        if (null === $locale) {
            return [];
        }

        $source = $this->resolveSource();

        $intIds = \array_map(static fn ($id) => (int) $id, $ids);
        $mapped = $this->loadForLocale($intIds, $locale, $source);

        $missingIds = \array_values(\array_diff($intIds, \array_keys($mapped)));
        $shadowLocale = $params['_shadowLocale'] ?? null;
        if ([] !== $missingIds && \is_string($shadowLocale)) {
            $mapped += $this->loadForLocale($missingIds, $shadowLocale, $source);
        }

        return $mapped;
    }

    public function resolveContentViewEnhancement(mixed $resource): ContentView
    {
        $entity = \is_array($resource) ? ($resource['entity'] ?? []) : [];

        return ContentView::create([], ['entity' => $entity]);
    }

    /**
     * @param int[] $ids
     * @param array{type: string, typeId: string}|null $source
     *
     * @return array<int, array{view: FormView|null, entity: array<mixed>}>
     */
    private function loadForLocale(array $ids, string $locale, ?array $source): array
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
            $mapped[$id] = [
                'view' => $this->buildView($form, $locale, $source),
                'entity' => $form->serializeForLocale($locale),
            ];
        }

        return $mapped;
    }

    /**
     * @param array{type: string, typeId: string}|null $source
     */
    private function buildView(Form $form, string $locale, ?array $source): ?FormView
    {
        if (null === $source) {
            return null;
        }

        $id = $form->getId();
        \assert(null !== $id);

        return $this->formBuilder->build($id, $source['type'], $source['typeId'], $locale, self::FORM_NAME)?->createView();
    }

    /**
     * @return array{type: string, typeId: string}|null
     */
    private function resolveSource(): ?array
    {
        $object = $this->requestStack->getMainRequest()?->attributes->get('object');
        if (!$object instanceof DimensionContentInterface) {
            return null;
        }

        $type = $object::getResourceKey();
        if (!$this->titleProviderPool->has($type)) {
            return null;
        }

        return ['type' => $type, 'typeId' => (string) $object->getResource()->getId()];
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
