<?php

namespace L91\Sulu\Bundle\FormBundle\Admin;

use L91\Sulu\Bundle\FormBundle\Provider\ListProviderRegistry;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationItem;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationProviderInterface;
use Sulu\Bundle\AdminBundle\Navigation\DisplayCondition;

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
    public function getNavigationItems(array $options = array())
    {
        $items = [];

        foreach ($this->listProviderRegistry->getProviders() as $name => $provider) {
            $item = new ContentNavigationItem('Formular');
            $item->setAction('form-list');
            $item->setDisplay(array('edit'));
            $item->setComponent('content/list@l91suluform');
            $item->setComponentOptions(array(
                'template' => $name
            ));

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
