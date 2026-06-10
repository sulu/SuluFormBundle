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
use Sulu\Content\Application\ContentResolver\Value\ContentView;
use Sulu\Content\Application\ResourceLoader\Loader\ResourceLoaderContentViewEnhancementInterface;
use Sulu\Content\Domain\Model\DimensionContentInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

class FormResourceLoader implements ResourceLoaderContentViewEnhancementInterface
{
    public const RESOURCE_LOADER_KEY = 'form';

    private const FORM_NAME = 'form';

    /**
     * Maps the plural DimensionContent resourceKey to the singular title-provider
     * key expected by the form Builder. See the design spec
     * docs/superpowers/specs/2026-06-10-form-render-2.6-parity-design.md.
     */
    private const RESOURCE_KEY_MAP = [
        'pages' => 'page',
        'articles' => 'article',
    ];

    public function __construct(
        private FormRepository $formRepository,
        private BuilderInterface $formBuilder,
        private RequestStack $requestStack,
    ) {
    }

    /**
     * @param array<int|string> $ids
     *
     * @return array<int, array{view: FormView|null, entity: array<string, mixed>}>
     */
    public function load(array $ids, ?string $locale, array $params = []): array
    {
        if (null === $locale) {
            return [];
        }

        [$type, $typeId] = $this->resolveSource();

        $intIds = \array_map(static fn ($id) => (int) $id, $ids);
        $mapped = $this->loadForLocale($intIds, $locale, $type, $typeId);

        $missingIds = \array_values(\array_diff($intIds, \array_keys($mapped)));
        $shadowLocale = $params['_shadowLocale'] ?? null;
        if ([] !== $missingIds && \is_string($shadowLocale)) {
            $mapped += $this->loadForLocale($missingIds, $shadowLocale, $type, $typeId);
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
     *
     * @return array<int, array{view: FormView|null, entity: array<string, mixed>}>
     */
    private function loadForLocale(array $ids, string $locale, ?string $type, ?string $typeId): array
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
                'view' => $this->buildView($form, $locale, $type, $typeId),
                'entity' => $form->serializeForLocale($locale),
            ];
        }

        return $mapped;
    }

    private function buildView(Form $form, string $locale, ?string $type, ?string $typeId): ?FormView
    {
        if (null === $type || null === $typeId) {
            return null;
        }

        $id = $form->getId();
        \assert(null !== $id);

        return $this->formBuilder->build($id, $type, $typeId, $locale, self::FORM_NAME)?->createView();
    }

    /**
     * Reads the current DimensionContent from the main request and derives the
     * title-provider key + resource id needed to build the form. Returns
     * [null, null] when no usable DimensionContent is available so loading
     * degrades gracefully (no view built, entity still serialized).
     *
     * @return array{0: string|null, 1: string|null}
     */
    private function resolveSource(): array
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return [null, null];
        }

        $object = $request->attributes->get('object');
        if (!$object instanceof DimensionContentInterface) {
            return [null, null];
        }

        $type = self::RESOURCE_KEY_MAP[$object::getResourceKey()] ?? null;
        if (null === $type) {
            return [null, null];
        }

        return [$type, (string) $object->getResource()->getId()];
    }

    public static function getKey(): string
    {
        return self::RESOURCE_LOADER_KEY;
    }
}
