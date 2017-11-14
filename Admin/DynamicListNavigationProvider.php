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
     * @var array
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

        $page = null;
        $action = 'form-list';
        if (array_key_exists('page', $options)) {
            $page = (int) $options['page'];

            if ($page > 1) {
                $action = 'page:' . $page . '/' . $action;
            }
        }

        foreach ($this->config as $config) {
            $name = 'sulu_form.form';
            if (isset($config['name'])) {
                $name = $config['name'];
            }

            $item = new ContentNavigationItem($name);
            $item->setAction($action);
            $item->setDisplay(['edit']);
            $item->setComponent('dynamics/list@suluform');

            $item->setComponentOptions([
                'page' => $page,
                'property' => $config['property'],
                'view' => isset($config['view']) ? $config['view'] : 'default',
                'type' => isset($config['type']) ? $config['type'] : null,
                'width' => isset($config['width']) ? $config['width'] : 'fixed',
            ]);

            if (isset($config['position'])) {
                $item->setPosition($config['position']);
            }

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
