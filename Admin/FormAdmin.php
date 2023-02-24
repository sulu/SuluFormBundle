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
use Sulu\Bundle\AdminBundle\Admin\View\ListItemAction;
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
        if ($this->securityChecker->hasPermission(static::SECURITY_CONTEXT, PermissionTypes::VIEW)) {
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
                static function(Localization $localization) {
                    return $localization->getLocale();
                },
                $this->webspaceManager->getAllLocalizations()
            )
        );
        $formToolbarActions = [
            new ToolbarAction('sulu_admin.save'),
            new ToolbarAction('sulu_admin.delete'),
            new DropdownToolbarAction(
                'sulu_admin.edit',
                'su-pen',
                [
                    new ToolbarAction('sulu_admin.copy'),
                ]
            ),
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
                ->setResourceKey(Form::RESOURCE_KEY)
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
                ->addToolbarActions($formToolbarActions)
                ->setParent(static::ADD_FORM_VIEW)
        );
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
                ->addItemActions([
                    new ListItemAction('sulu_form.dynamic_preview_item_action'),
                ])
                ->setParent(static::EDIT_FORM_VIEW)
        );
        $viewCollection->add(
            $this->viewBuilderFactory->createViewBuilder(
                'sulu_form.edit_form.data_details',
                '/forms/:locale/:formId/data/details/:id',
                'sulu_form.dynamic_preview'
            )
                ->setOption('dataListView', static::LIST_VIEW_DATA)
                ->setOption('dataResourceKey', 'dynamic_forms')
        );
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
