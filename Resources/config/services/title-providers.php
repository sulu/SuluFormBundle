<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function(ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $services->set('sulu_form.title_provider.pool', Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPool::class)
        ->args([tagged_iterator('sulu_form.title_provider', indexAttribute: 'alias')]);

    $services->set('sulu_form.title_provider.page', Sulu\Bundle\FormBundle\TitleProvider\StructureTitleProvider::class)
        ->args([service('request_stack')])
        ->tag('sulu_form.title_provider', ['alias' => 'page']);
};
