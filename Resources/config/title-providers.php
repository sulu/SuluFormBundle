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

use Sulu\Bundle\FormBundle\TitleProvider\DimensionContentTitleProvider;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPool;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.title_provider.pool', TitleProviderPool::class)
        ->args([tagged_iterator('sulu_form.title_provider', indexAttribute: 'alias')]);

    $services->set('sulu_form.title_provider.page', DimensionContentTitleProvider::class)
        ->args([new Reference('request_stack')])
        ->tag('sulu_form.title_provider', ['alias' => 'pages']);
};
