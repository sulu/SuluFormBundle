<?php

namespace L91\Sulu\Bundle\FormBundle\Admin;

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

        foreach ($this->config as $templateKey => $config) {
            $item = new ContentNavigationItem('Formular');
            $item->setAction('form-list');
            $item->setDisplay(['edit']);
            $item->setComponent('dynamics/list@l91suluform');
            $item->setComponentOptions([
                'template' => $templateKey,
                'property' => $config['property'],
                'view' => isset($config['view']) ? $config['view'] : 'default',
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
