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
        $locale
    ) {
        return $this->systemCollectionManager->getSystemCollection(
            SuluFormExtension::SYSTEM_COLLECTION_ROOT . '.attachments'
        );
    }
}
