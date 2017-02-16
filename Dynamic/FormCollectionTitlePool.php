<?php
/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

/**
 * Holds the available Form-Collections Types.
 */
class FormCollectionTitlePool implements FormCollectionTitlePoolInterface{
    /**
     * @var array
     */
    private $types;

    /**
     * FormCollectionTitlePool constructor.
     *
     * @param array $types
     */
    public function __construct($types)
    {
        $this->types = $types;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        return $this->types[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->types;
    }
}
