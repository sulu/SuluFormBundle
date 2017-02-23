<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Media;

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
     * @param string $locale
     *
     * @return array|int
     */
    public function getCollectionId(
        $formId,
        $formTitle,
        $type,
        $typeId,
        $locale
    );
}
