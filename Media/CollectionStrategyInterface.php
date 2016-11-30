<?php

namespace L91\Sulu\Bundle\FormBundle\Media;

/**
 * Interface for the collection strategy.
 */
interface CollectionStrategyInterface
{
    /**
     * Get collection id.
     *
     * @param int $formId
     * @param string $formTitle
     * @param string $type
     * @param string $typeId
     * @param string $title
     * @param string $locale
     *
     * @return array|int
     */
    public function getCollectionId(
        $formId,
        $formTitle,
        $type,
        $typeId,
        $title,
        $locale
    );
}
