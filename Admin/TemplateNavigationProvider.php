<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Admin;

use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationItem;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationProviderInterface;
use Sulu\Bundle\AdminBundle\Navigation\DisplayCondition;
use Sulu\Bundle\FormBundle\Provider\ListProviderRegistry;

class TemplateNavigationProvider implements ContentNavigationProviderInterface
{
    /**
     * @var ListProviderRegistry
     */
    protected $listProviderRegistry;

    /**
     * TemplateNavigationProvider constructor.
     *
     * @param ListProviderRegistry $listProviderRegistry
     */
    public function __construct(
        ListProviderRegistry $listProviderRegistry
    ) {
        $this->listProviderRegistry = $listProviderRegistry;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function getNavigationItems(array $options = [])
    {
        $items = [];

        foreach ($this->listProviderRegistry->getProviders() as $name => $provider) {
            $item = new ContentNavigationItem('Formular');
            $item->setAction('form-list');
            $item->setDisplay(['edit']);
            $item->setComponent('content/list@suluform');
            $item->setComponentOptions([
                'template' => $name,
            ]);

            $item->setDisplayConditions(
                [
                    new DisplayCondition('template', DisplayCondition::OPERATOR_EQUAL, $name),
                ]
            );

            $items[] = $item;
        }

        return $items;
    }
}
