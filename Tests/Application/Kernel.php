<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Application;

use Sulu\Bundle\FormBundle\SuluFormBundle;
use Sulu\Bundle\TestBundle\Kernel\SuluTestKernel;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends SuluTestKernel
{
    public function __construct($environment, $debug, $suluContext = self::CONTEXT_ADMIN)
    {
        parent::__construct($environment, $debug, $suluContext);
    }

    public function registerBundles(): iterable
    {
        return \array_merge(
            parent::registerBundles(),
            [
                new SuluFormBundle(),
            ]
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        parent::registerContainerConfiguration($loader);

        $loader->load(__DIR__ . '/config/config_' . $this->getContext() . '.yml');

        $parameters = $this->getKernelParameters();
        if (isset($parameters['kernel.bundles'][SwiftmailerBundle::class])) {
            $loader->load(__DIR__ . '/config/swiftmailer.yml'); // @deprecated
        }
    }

    protected function getKernelParameters(): array
    {
        $parameters = parent::getKernelParameters();

        $gedmoReflection = new \ReflectionClass(\Gedmo\Exception::class);
        $parameters['gedmo_directory'] = \dirname($gedmoReflection->getFileName());

        return $parameters;
    }
}
