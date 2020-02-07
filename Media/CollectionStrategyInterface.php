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

/**
 * Interface for the collection strategy.
 */
interface CollectionStrategyInterface
{
    /**
     * Get collection id.
     *
     * @return int
     */
    public function getCollectionId(
        int $formId,
        string $formTitle,
        string $type,
        string $typeId,
        string $locale
    ): int;
}
