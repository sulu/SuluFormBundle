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

return static function(ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $services->set('sulu_form.title_provider.article', Sulu\Bundle\FormBundle\TitleProvider\StructureTitleProvider::class)
        ->args([service('request_stack')])
        ->tag('sulu_form.title_provider', ['alias' => 'article']);
};
