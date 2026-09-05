<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sulu\Bundle\FormBundle\TitleProvider\StructureTitleProvider;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPool;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.title_provider.pool', TitleProviderPool::class)
        ->args([[]]);

    $services->set('sulu_form.title_provider.page', StructureTitleProvider::class)
        ->args([new Reference('request_stack')])
        ->tag('sulu_form.title_provider', ['alias' => 'page']);
};
