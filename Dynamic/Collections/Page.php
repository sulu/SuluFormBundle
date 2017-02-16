<?php
/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Collections;

use Sulu\Bundle\FormBundle\Dynamic\FormCollectionTitleInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The attached structure type.
 */
class Page implements FormCollectionTitleInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTitle($type, $typeId)
    {
        // TODO: Return title with registered service from given type (e.g. structure, event, blog,…)
    }
}
