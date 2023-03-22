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
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\DropdownToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Component\Localization\Localization;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

class FormAdmin extends Admin
{
    public const SECURITY_CONTEXT = 'sulu.form.forms';
    public const LIST_VIEW = 'sulu_form.list';
    public const LIST_VIEW_DATA = 'sulu_form.edit_form.data';
    public const ADD_FORM_VIEW = 'sulu_form.add_form';
    public const ADD_FORM_DETAILS_VIEW = 'sulu_form.add_form.details';
    public const EDIT_FORM_VIEW = 'sulu_form.edit_form';
    public const EDIT_FORM_DETAILS_VIEW = 'sulu_form.edit_form.details';

    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;

    /**
     * @var ViewBuilderFactoryInterface
     */
    private $viewBuilderFactory;

    /**
     * @var WebspaceManagerInterface
     */
    private $webspaceManager;

    /**
     * FormAdmin constructor.
     */
    public function __construct(
        SecurityCheckerInterface $securityChecker,
        ViewBuilderFactoryInterface $viewBuilderFactory,
        WebspaceManagerInterface $webspaceManager
    ) {
        $this->securityChecker = $securityChecker;
        $this->viewBuilderFactory = $viewBuilderFactory;
        $this->webspaceManager = $webspaceManager;
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::EDIT)) {
            $navigationItem = new NavigationItem('sulu_form.forms');
            $navigationItem->setIcon('su-magic');
            $navigationItem->setPosition(10);
            $navigationItem->setView(static::LIST_VIEW);

            $navigationItemCollection->add($navigationItem);
        }
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $formLocales = \array_values(
            \array_map(
                function(Localization $localization) {
                    return $localization->getLocale();
                },
                $this->webspaceManager->getAllLocalizations()
            )
        );

        $addFormToolbarActions = [];
        $editFormToolbarActions = [];
        $listToolbarActions = [];
        $dataListToolbarActions = [];

        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::ADD)) {
            $addFormToolbarActions[] = new ToolbarAction('sulu_admin.save');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::EDIT)) {
            $editFormToolbarActions[] = new ToolbarAction('sulu_admin.save');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::DELETE)) {
            $editFormToolbarActions[] = new ToolbarAction('sulu_admin.delete');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::ADD)) {
            $editFormToolbarActions[] = new DropdownToolbarAction(
                'sulu_admin.edit',
                'su-pen',
                [
                    new ToolbarAction('sulu_admin.copy'),
                ]
            );
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::ADD)) {
            $listToolbarActions[] = new ToolbarAction('sulu_admin.add');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::DELETE)) {
            $listToolbarActions[] = new ToolbarAction('sulu_admin.delete');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $dataListToolbarActions[] = new ToolbarAction('sulu_admin.export');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::DELETE)) {
            $dataListToolbarActions[] = new ToolbarAction('sulu_admin.delete');
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $listViewBuilder = $this->viewBuilderFactory->createListViewBuilder(static::LIST_VIEW, '/forms/:locale')
                ->setResourceKey(Form::RESOURCE_KEY)
                ->setListKey('forms')
                ->setTitle('sulu_form.forms')
                ->addListAdapters(['table'])
                ->addLocales($formLocales)
                ->setDefaultLocale($formLocales[0])
                ->enableSearching()
                ->addToolbarActions($listToolbarActions)
                ->setEditView(static::EDIT_FORM_VIEW)
            ;
            if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::ADD)) {
                $listViewBuilder->setAddView(static::ADD_FORM_VIEW);
            }
            $viewCollection->add($listViewBuilder);
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::ADD)) {
            $viewCollection->add(
                $this->viewBuilderFactory->createResourceTabViewBuilder(static::ADD_FORM_VIEW, '/forms/:locale/add')
                    ->setResourceKey(Form::RESOURCE_KEY)
                    ->addLocales($formLocales)
                    ->setBackView(static::LIST_VIEW)
            );
            $viewCollection->add(
                $this->viewBuilderFactory->createFormViewBuilder(static::ADD_FORM_DETAILS_VIEW, '/details')
                    ->setResourceKey(Form::RESOURCE_KEY)
                    ->setFormKey('form_details')
                    ->setTabTitle('sulu_form.general')
                    ->setEditView(static::EDIT_FORM_VIEW)
                    ->addToolbarActions($addFormToolbarActions)
                    ->setParent(static::ADD_FORM_VIEW)
            );
        }
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
            $viewCollection->add(
                $this->viewBuilderFactory->createResourceTabViewBuilder(static::EDIT_FORM_VIEW, '/forms/:locale/:id')
                    ->setResourceKey(Form::RESOURCE_KEY)
                    ->addLocales($formLocales)
                    ->setBackView(static::LIST_VIEW)
            );
            $viewCollection->add(
                $this->viewBuilderFactory->createFormViewBuilder(static::EDIT_FORM_DETAILS_VIEW, '/details')
                    ->setResourceKey(Form::RESOURCE_KEY)
                    ->setFormKey('form_details')
                    ->setTabTitle('sulu_form.general')
                    ->addToolbarActions($editFormToolbarActions)
                    ->setParent(static::EDIT_FORM_VIEW)
            );
            $viewCollection->add(
                $this->viewBuilderFactory->createListViewBuilder(static::LIST_VIEW_DATA, '/data')
                    ->setResourceKey('dynamic_forms')
                    ->setListKey('form_data')
                    ->setTabTitle('sulu_form.data')
                    ->addListAdapters(['table'])
                    ->addRouterAttributesToListRequest(['id' => 'form'])
                    ->addRouterAttributesToListMetadata(['id' => 'id'])
                    ->addToolbarActions($dataListToolbarActions)
                    ->setParent(static::EDIT_FORM_VIEW)
            );
        }
    }

    public function getSecurityContexts()
    {
        return [
            'Sulu' => [
                'Form' => [
                    static::SECURITY_CONTEXT => [
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
