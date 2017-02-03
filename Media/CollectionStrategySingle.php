<?php

namespace Sulu\Bundle\FormBundle\Media;

use Sulu\Bundle\FormBundle\DependencyInjection\SuluFormExtension;
use Sulu\Component\Media\SystemCollections\SystemCollectionManagerInterface;

/**
 * Tree strategy to create foreach form and page a collection.
 */
class CollectionStrategySingle implements CollectionStrategyInterface
{
    /**
     * @var SystemCollectionManagerInterface
     */
    protected $systemCollectionManager;

    /**
     * CollectionSingleStrategy constructor.
     *
     * @param SystemCollectionManagerInterface $systemCollectionManager
     */
    public function __construct(
        SystemCollectionManagerInterface $systemCollectionManager
    ) {
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
        return $this->systemCollectionManager->getSystemCollection(
            SuluFormExtension::SYSTEM_COLLECTION_ROOT . '.attachments'
        );
    }
}
