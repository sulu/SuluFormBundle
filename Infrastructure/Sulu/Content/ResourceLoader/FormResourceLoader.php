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
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Content\Application\ContentResolver\Value\ContentView;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderContentViewEnhancementInterface;
use Sulu\Content\Domain\Model\DimensionContentInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @internal no bc promise is given for this class it can be changed, moved or removed at any time
 *           create your own resource loader instead
 */
class FormResourceLoader implements ResourceLoaderContentViewEnhancementInterface
{
    public const RESOURCE_LOADER_KEY = 'form';

    private const FORM_NAME = 'form';

    public function __construct(
        private FormRepository $formRepository,
        private BuilderInterface $formBuilder,
        private RequestStack $requestStack,
    ) {
    }

    /**
     * @param array<int|string> $ids
     *
     * @return array<int, array{view: FormView, entity: array<mixed>}|null>
     */
    public function load(array $ids, ?string $locale, array $params = []): array
    {
        if (null === $locale) {
            return [];
        }

        $source = $this->resolveSource();
        if (null === $source) {
            return [];
        }

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
     * @param array{type: string, typeId: string} $source
     *
     * @return array<int, array{view: FormView, entity: array<mixed>}|null>
     */
    private function loadForLocale(array $ids, string $locale, array $source): array
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

            $view = $this->buildView($form, $locale, $source);
            $mapped[$id] = null === $view
                ? null
                : ['view' => $view, 'entity' => $form->serializeForLocale($locale)];
        }

        return $mapped;
    }

    /**
     * @param array{type: string, typeId: string} $source
     */
    private function buildView(Form $form, string $locale, array $source): ?FormView
    {
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

        return ['type' => $object::getResourceKey(), 'typeId' => (string) $object->getResource()->getId()];
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
