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
     * @var string
     */
    private $type;

    /**
     * DynamicListNavigationProvider constructor.
     *
     * @param array $config
     * @param array $type
     */
    public function __construct(array $config, $type)
    {
        $this->config = $config;
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getNavigationItems(array $options = [])
    {
        $items = [];

        foreach ($this->config as $templateKey => $config) {
            $item = new ContentNavigationItem('Formular');
            $item->setAction('form-list');
            $item->setDisplay(['edit']);
            $item->setComponent('dynamics/list@suluform');

            $item->setComponentOptions([
                'template' => $templateKey,
                'property' => $config['property'],
                'view' => isset($config['view']) ? $config['view'] : 'default',
                'type' => $this->type,
            ]);

            $item->setDisplayConditions(
                [
                    new DisplayCondition('template', DisplayCondition::OPERATOR_EQUAL, $templateKey),
                ]
            );

            $items[] = $item;
        }

        return $items;
    }
}
