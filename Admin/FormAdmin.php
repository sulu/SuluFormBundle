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
use Sulu\Bundle\AdminBundle\Admin\Routing\Route;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;
use Sulu\Component\Localization\Localization;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;

/**
 * Admin for form.
 */
class FormAdmin extends Admin
{
    /**
     * @var WebspaceManagerInterface
     */
    private $webspaceManager;

    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;

    /**
     * FormAdmin constructor.
     *
     * @param SecurityCheckerInterface $securityChecker
     * @param string $title
     */
    public function __construct(
        SecurityCheckerInterface $securityChecker,
        WebspaceManagerInterface $webspaceManager,
        $title
    ) {
        $this->securityChecker = $securityChecker;
        $this->webspaceManager = $webspaceManager;

        // set root navigation
        $rootNavigationItem = new NavigationItem($title);

        // parent navigation
        $section = new NavigationItem('navigation.modules');

        // create section
        if ($securityChecker->hasPermission('sulu.form.forms', 'view')) {
            $navigationItem = new NavigationItem('sulu_form.forms');
            $navigationItem->setIcon('magic');
            $navigationItem->setAction('forms');
            $navigationItem->setPosition(10);
            $section->addChild($navigationItem);
            $rootNavigationItem->addChild($section);
        }

        // set navigation
        $this->setNavigation(new Navigation($rootNavigationItem));
    }

    public function getNavigationV2(): Navigation
    {
        $rootNavigationItem = $this->getNavigationItemRoot();

        if ($this->securityChecker->hasPermission('sulu.form.forms', 'view')) {
            $form = new NavigationItem('sulu_form.forms');
            $form->setPosition(40);
            $form->setIcon('su-magic');
            $form->setAction('form/forms');
            $form->setMainRoute('sulu_form.list');

            $rootNavigationItem->addChild($form);
        }

        return new Navigation($rootNavigationItem);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes(): array
    {
        $locales = array_values(
            array_map(
                function(Localization $localization) {
                    return $localization->getLocale();
                },
                $this->webspaceManager->getAllLocalizations()
            )
        );

        return [
            (new Route('sulu_form.list', '/forms/:locale', 'sulu_admin.datagrid'))
                ->addOption('title', 'sulu_form.forms')
                ->addOption('resourceKey', 'forms')
                ->addOption('adapters', ['table'])
                ->addOption('addRoute', 'sulu_form.add_form.detail')
                ->addOption('editRoute', 'sulu_form.edit_form.detail')
                ->addOption('locales', $locales)
                ->addAttributeDefault('locale', $locales[0]),
            (new Route('sulu_form.add_form', '/forms/:locale/add', 'sulu_admin.resource_tabs'))
                ->addOption('resourceKey', 'forms')
                ->addOption('locales', $locales),
            (new Route('sulu_form.add_form.detail', '/details', 'sulu_admin.form'))
                ->addOption('tabTitle', 'sulu_form.details')
                ->addOption('backRoute', 'sulu_form.datagrid')
                ->addOption('editRoute', 'sulu_form.edit_form.detail')
                ->setParent('sulu_form.add_form'),
            (new Route('sulu_form.edit_form', '/forms/:locale/:id', 'sulu_admin.resource_tabs'))
                ->addOption('resourceKey', 'forms')
                ->addOption('locales', $locales),
            (new Route('sulu_form.edit_form.detail', '/details', 'sulu_admin.form'))
                ->addOption('tabTitle', 'sulu_form.details')
                ->addOption('backRoute', 'sulu_form.datagrid')
                ->setParent('sulu_form.edit_form'),
        ];
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

    /**
     * {@inheritdoc}
     */
    public function getSecurityContexts()
    {
        return [
            'Sulu' => [
                'Form' => [
                    'sulu.form.forms',
                ],
            ],
        ];
    }
}
