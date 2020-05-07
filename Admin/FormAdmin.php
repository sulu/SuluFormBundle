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
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Component\Localization\Localization;
use Sulu\Component\Security\Authorization\PermissionTypes;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

class FormAdmin extends Admin
{
    const LIST_VIEW = 'sulu_form.list';
    const LIST_VIEW_DATA = 'sulu_form.edit_form.data';
    const ADD_FORM_VIEW = 'sulu_form.add_form';
    const ADD_FORM_DETAILS_VIEW = 'sulu_form.add_form.details';
    const EDIT_FORM_VIEW = 'sulu_form.edit_form';
    const EDIT_FORM_DETAILS_VIEW = 'sulu_form.edit_form.details';

    private $securityChecker;
    private $viewBuilderFactory;
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

    /**
     * {@inheritdoc}
     */
    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        if ($this->securityChecker->hasPermission('sulu.form.forms', PermissionTypes::VIEW)) {
            $navigationItem = new NavigationItem('sulu_form.forms');
            $navigationItem->setIcon('su-magic');
            $navigationItem->setPosition(10);
            $navigationItem->setView(static::LIST_VIEW);

            $navigationItemCollection->add($navigationItem);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureViews(ViewCollection $viewCollection): void
    {
        $formLocales = array_values(
            array_map(
                function(Localization $localization) {
                    return $localization->getLocale();
                },
                $this->webspaceManager->getAllLocalizations()
            )
        );
        $formToolbarActions = [
            new ToolbarAction('sulu_admin.save'),
            new ToolbarAction('sulu_admin.delete'),
        ];
        $listToolbarActions = [
            new ToolbarAction('sulu_admin.add'),
            new ToolbarAction('sulu_admin.delete'),
        ];
        $dataListToolbarActions = [
            new ToolbarAction('sulu_admin.delete'),
            new ToolbarAction('sulu_admin.export'),
        ];

        $viewCollection->add(
            $this->viewBuilderFactory->createListViewBuilder(static::LIST_VIEW, '/forms/:locale')
                ->setResourceKey('forms')
                ->setListKey('forms')
                ->setTitle('sulu_form.forms')
                ->addListAdapters(['table'])
                ->addLocales($formLocales)
                ->setDefaultLocale($formLocales[0])
                ->setAddView(static::ADD_FORM_VIEW)
                ->setEditView(static::EDIT_FORM_VIEW)
                ->enableSearching()
                ->addToolbarActions($listToolbarActions)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createResourceTabViewBuilder(static::ADD_FORM_VIEW, '/forms/:locale/add')
                ->setResourceKey('forms')
                ->addLocales($formLocales)
                ->setBackView(static::LIST_VIEW)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(static::ADD_FORM_DETAILS_VIEW, '/details')
                ->setResourceKey('forms')
                ->setFormKey('form_details')
                ->setTabTitle('sulu_form.general')
                ->setEditView(static::EDIT_FORM_VIEW)
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::ADD_FORM_VIEW)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createResourceTabViewBuilder(static::EDIT_FORM_VIEW, '/forms/:locale/:id')
                ->setResourceKey('forms')
                ->addLocales($formLocales)
                ->setBackView(static::LIST_VIEW)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createFormViewBuilder(static::EDIT_FORM_DETAILS_VIEW, '/details')
                ->setResourceKey('forms')
                ->setFormKey('form_details')
                ->setTabTitle('sulu_form.general')
                ->addToolbarActions($formToolbarActions)
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
