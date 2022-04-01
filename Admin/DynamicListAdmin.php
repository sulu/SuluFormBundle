<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\ListViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;

class DynamicListAdmin extends Admin
{
    public static function getPriority(): int
    {
        return -1024;
    }

    /**
     * @var ViewBuilderFactoryInterface
     */
    private $viewBuilderFactory;

    /**
     * @var mixed[]
     */
    private $config;

    /**
     * @param mixed[] $config
     */
    public function __construct(ViewBuilderFactoryInterface $viewBuilderFactory, array $config)
    {
        $this->viewBuilderFactory = $viewBuilderFactory;
        $this->config = $config;
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        /** @var array<string, mixed> $sections */
        foreach ($this->config as $parent => $sections) {
            if (!$viewCollection->has($parent)) {
                continue;
            }

            $counter = 0;

            /** @var mixed[] $config */
            foreach ($sections as $key => $config) {
                ++$counter;

                $action = 'form-list';
                if ($counter > 1) {
                    $action .= '-' . \str_replace('_', '-', $key);
                }

                $name = $parent . '.' . $action . '-key';
                if (isset($config['name'])) {
                    $name = $config['name'];
                }

                if ($viewCollection->has($name)) {
                    throw new \RuntimeException(\sprintf('View "%s" does already exist.', $name));
                }

                $requestParameters = [
                    'type' => $config['type'],
                ];

                /** @var ListViewBuilderInterface $view */
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
                    $view->setTabCondition(\sprintf('template == "%s"', $config['template']));
                }

                $view->addRequestParameters($requestParameters);

                $viewCollection->add($view);
            }
        }
    }
}
