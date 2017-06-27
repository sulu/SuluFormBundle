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

/**
 * Register new tab for dynamic list to specific template.
 */
class DynamicListNavigationProvider implements ContentNavigationProviderInterface
{
    /**
     * @var string
     */
    private $config;

    /**
     * DynamicListNavigationProvider constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getNavigationItems(array $options = [])
    {
        $items = [];

        foreach ($this->config as $config) {
            $item = new ContentNavigationItem('Formular');
            $item->setAction('form-list');
            $item->setDisplay(['edit']);
            $item->setComponent('dynamics/list@suluform');

            $item->setComponentOptions([
                'property' => $config['property'],
                'view' => isset($config['view']) ? $config['view'] : 'default',
                'type' => isset($config['type']) ? $config['type'] : null,
            ]);

            if (isset($config['template'])) {
                $item->setDisplayConditions(
                    [
                        new DisplayCondition('template', DisplayCondition::OPERATOR_EQUAL, $config['template']),
                    ]
                );
            }

            $items[] = $item;
        }

        return $items;
    }
}
