<?php

namespace L91\Sulu\Bundle\FormBundle\Media;

use L91\Sulu\Bundle\FormBundle\DependencyInjection\L91SuluFormExtension;
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
     * CollectionTreeStrategy constructor.
     *
     * @param CollectionManagerInterface $collectionManager
     * @param SystemCollectionManagerInterface $systemCollectionManager
     */
    public function __construct(
        CollectionManagerInterface $collectionManager,
        SystemCollectionManagerInterface $systemCollectionManager
    ) {
        $this->collectionManager = $collectionManager;
        $this->systemCollectionManager = $systemCollectionManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionId(
        $formId,
        $formTitle,
        $type,
        $typeId,
        $title,
        $locale
    ) {
        $rootCollectionKey = L91SuluFormExtension::SYSTEM_COLLECTION_ROOT;
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

    /**
     * Create collection.
     *
     * @param string $title
     * @param int $parentId
     * @param string $collectionKey
     * @param string $locale
     *
     * @return int
     */
    private function createCollection($title, $parentId, $collectionKey, $locale)
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

    /**
     * Load collection id.
     *
     * @param string $collectionKey
     * @param string $locale
     *
     * @return int
     */
    private function loadCollectionId(
        $collectionKey,
        $locale
    ) {
        try {
            $collection = $this->collectionManager->getByKey($collectionKey, $locale);

            if (!$collection) {
                return;
            }

            return $collection->getId();
        } catch (\Exception $e) {
            // Catch all exception
        }
    }
}
