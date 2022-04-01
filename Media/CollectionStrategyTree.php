<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Media;

use Sulu\Bundle\FormBundle\DependencyInjection\SuluFormExtension;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Sulu\Bundle\MediaBundle\Api\Collection;
use Sulu\Bundle\MediaBundle\Collection\Manager\CollectionManagerInterface;
use Sulu\Component\Media\SystemCollections\SystemCollectionManagerInterface;

/**
 * Tree strategy to create foreach form and page a collection.
 */
class CollectionStrategyTree implements CollectionStrategyInterface
{
    /**
     * @var CollectionManagerInterface
     */
    protected $collectionManager;

    /**
     * @var SystemCollectionManagerInterface
     */
    protected $systemCollectionManager;

    /**
     * @var TitleProviderPoolInterface
     */
    protected $titleProviderPool;

    /**
     * CollectionTreeStrategy constructor.
     */
    public function __construct(
        CollectionManagerInterface $collectionManager,
        SystemCollectionManagerInterface $systemCollectionManager,
        TitleProviderPoolInterface $titleProviderPool
    ) {
        $this->collectionManager = $collectionManager;
        $this->systemCollectionManager = $systemCollectionManager;
        $this->titleProviderPool = $titleProviderPool;
    }

    public function getCollectionId(
        int $formId,
        string $formTitle,
        string $type,
        string $typeId,
        string $locale
    ): int {
        $title = $this->titleProviderPool->get($type)->getTitle($typeId, $locale);
        $rootCollectionKey = SuluFormExtension::SYSTEM_COLLECTION_ROOT;
        $parentCollectionKey = $rootCollectionKey . '.' . $formId;
        $collectionKey = $parentCollectionKey . '.' . $type . '_' . $typeId;

        $collectionId = $this->loadCollectionId($collectionKey, $locale);

        // Return collection when exists
        if ($collectionId) {
            return $collectionId;
        }

        // Get parent collection
        $parentCollectionId = $this->loadCollectionId($parentCollectionKey, $locale);

        // Create Parent Collection when not exists
        if (!$parentCollectionId) {
            $parentCollectionId = $this->createCollection(
                $formTitle,
                $this->systemCollectionManager->getSystemCollection($rootCollectionKey),
                $parentCollectionKey,
                $locale
            );
        }

        // Create Collection
        return $this->createCollection(
            $title,
            $parentCollectionId,
            $collectionKey,
            $locale
        );
    }

    private function createCollection(string $title, int $parentId, string $collectionKey, string $locale): int
    {
        $parentCollection = $this->collectionManager->save([
            'title' => $title,
            'type' => ['id' => 2],
            'parent' => $parentId,
            'key' => $collectionKey,
            'locale' => $locale,
        ], null);

        return $parentCollection->getId();
    }

    private function loadCollectionId(string $collectionKey, string $locale): ?int
    {
        /** @var null|Collection $collection */
        $collection = $this->collectionManager->getByKey($collectionKey, $locale);
        if (!$collection) {
            return null;
        }

        return $collection->getId();
    }
}
