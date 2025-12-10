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

    $services->set('sulu_form.private_media_subscriber', Sulu\Bundle\FormBundle\Event\ProtectedMediaSubscriber::class)
        ->args([
            service('router'),
            service('doctrine.orm.entity_manager'),
            service('sulu_media.format_cache'),
        ])
        ->tag('kernel.event_subscriber');
};
