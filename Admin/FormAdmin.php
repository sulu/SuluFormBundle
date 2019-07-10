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

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Routing\RouteBuilderFactoryInterface;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;


/**
 * Generated by https://github.com/alexander-schranz/sulu-backend-bundle.
 */
class FormAdmin extends Admin
{
    const LIST_ROUTE = 'sulu_form.list';
    const FORM_ROUTE = 'sulu_form.forms';
    const ADD_FORM_ROUTE = 'sulu_form.add_form';
    const EDIT_FORM_ROUTE = 'sulu_form.edit_form';

    private $securityChecker;
    private $routeBuilderFactory;
    private $title;

    /**
     * FormAdmin constructor.
     *
     * @param SecurityCheckerInterface $securityChecker
     * @param string $title
     */
    public function __construct(
        SecurityCheckerInterface $securityChecker,
        RouteBuilderFactoryInterface $routeBuilderFactory,
        $title
    ) {
        $this->securityChecker = $securityChecker;
        $this->routeBuilderFactory = $routeBuilderFactory;
        $this->title = $title;
    }

    public function getNavigation(): Navigation
    {
        $rootNavigationItem = $this->getNavigationItemRoot();
        $settings = Admin::getNavigationItemSettings();

        if ($this->securityChecker->hasPermission('sulu.form.forms', PermissionTypes::VIEW)) {
            $navigationItem = new NavigationItem('sulu_form.forms', $settings);
            $navigationItem->setIcon('su-magic');
            $navigationItem->setPosition(10);
            $navigationItem->setMainRoute(static::LIST_ROUTE);
            $rootNavigationItem->addChild($navigationItem);
        }

        return new Navigation($rootNavigationItem);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommands()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getJsBundleName()
    {
        return 'suluform';
    }


    public function getRoutes(): array
    {
        $formToolbarActions = [
            'sulu_admin.save',
            'sulu_admin.delete',
        ];
        $listToolbarActions = [
            'sulu_admin.add',
            'sulu_admin.delete'
        ];
        return [
            $this->routeBuilderFactory->createListRouteBuilder(static::LIST_ROUTE, '/forms')
                ->setResourceKey('forms')
                ->setListKey('forms')
                ->setTitle('sulu_form.forms')
                ->addListAdapters(['table'])
                ->setAddRoute(static::ADD_FORM_ROUTE)
                ->setEditRoute(static::EDIT_FORM_ROUTE)
                ->enableSearching()
                ->addToolbarActions($listToolbarActions)
                ->getRoute(),
            $this->routeBuilderFactory->createResourceTabRouteBuilder(static::ADD_FORM_ROUTE, '/forms/add')
                ->setResourceKey('forms')
                ->setBackRoute(static::LIST_ROUTE)
                ->getRoute(),
            ];
    }


    /**
     * {@inheritdoc}
     */
    public function getSecurityContexts()
    {
        return [
            'Sulu' => [
                'Form' => [
                    'sulu.form.forms' => [
                        PermissionTypes::VIEW,
                        PermissionTypes::ADD,
                        PermissionTypes::EDIT,
                        PermissionTypes::DELETE,
                    ],
                ],
            ],
        ];
    }

}
