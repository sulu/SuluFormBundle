<?php

namespace Sulu\Bundle\FormBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;

class DynamicListAdmin extends Admin
{
    /**
     * @var ViewBuilderFactoryInterface
     */
    private $viewBuilderFactory;

    /**
     * @var array
     */
    private $config;

    public function __construct(ViewBuilderFactoryInterface $viewBuilderFactory, array $config)
    {
        $this->viewBuilderFactory = $viewBuilderFactory;
        $this->config = $config;
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $action = 'form-list';
        // TODO handle multipage views

        foreach ($this->config as $parent => $sections) {
            foreach ($sections as $key => $config) {
                $name = $parent . '.' . $action . '-key';
                if (isset($config['name'])) {
                    $name = $config['name'];
                }

                $requestParameters = [
                    'type' => $config['type'],
                ];

                $view = $this->viewBuilderFactory->createListViewBuilder($name, '/' . $action)
                    ->setResourceKey('dynamic_forms')
                    ->setListKey('form_data')
                    ->setTabTitle('sulu_form.data')
                    ->addListAdapters(['table'])
                    ->addRouterAttributesToListRequest(['id' => 'typeId'])
                    ->addResourceStorePropertiesToListRequest([$config['property'] => 'form'])
                    ->addResourceStorePropertiesToListMetadata([$config['property'] => 'id'])
                    ->addToolbarActions([
                        new ToolbarAction('sulu_admin.delete'),
                        new ToolbarAction('sulu_admin.export'),
                    ])
                    ->setParent($parent);

                if (isset($config['view'])) {
                    $requestParameters['view'] = $config['view'];
                }

                if (isset($config['position'])) {
                    $view->setTabOrder($config['position']);
                }

                if (isset($config['template'])) {
                    $view->setTabCondition(sprintf('template === "%s"', $config['template']));
                }

                $view->addRequestParameters($requestParameters);

                $viewCollection->add($view);
            }
        }
    }
}
