<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Sulu\Bundle\FormBundle\SuluFormBundle;
use Sulu\Bundle\TestBundle\Kernel\SuluTestKernel;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends SuluTestKernel
{
    /**
     * {@inheritdoc}
     */
    public function __construct($environment, $debug, $suluContext = self::CONTEXT_ADMIN)
    {
        $this->name = $suluContext;

        parent::__construct($environment, $debug, $suluContext);
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array_merge(
            [
                new SuluFormBundle(),
                new SwiftmailerBundle(),
            ],
            parent::registerBundles()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        parent::registerContainerConfiguration($loader);

        $loader->load(__DIR__ . '/config/config_' . $this->getContext() . '.yml');
    }
}
