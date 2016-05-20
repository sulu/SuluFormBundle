<?php

namespace L91\Sulu\Bundle\FormBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Navigation\Navigation;
use Sulu\Bundle\AdminBundle\Navigation\NavigationItem;

class FormAdmin extends Admin
{
    /**
     * FormAdmin constructor.
     *
     * @param $title
     */
    public function __construct($title)
    {
        $rootNavigationItem = new NavigationItem($title);

        $this->setNavigation(new Navigation($rootNavigationItem));
    }

    /**
     * {@inheritdoc}
     */
    public function getJsBundleName()
    {
        return 'l91suluform';
    }
}
