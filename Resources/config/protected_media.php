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

use Sulu\Bundle\FormBundle\Event\ProtectedMediaSubscriber;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.private_media_subscriber', ProtectedMediaSubscriber::class)
        ->args([
            new Reference('router'),
            new Reference('doctrine.orm.entity_manager'),
            new Reference('sulu_media.format_cache'),
        ])
        ->tag('kernel.event_subscriber');
};
