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

    $services->set('sulu_form.form_trash_item_handler', Sulu\Bundle\FormBundle\Trash\FormTrashItemHandler::class)
        ->args([
            service('sulu_trash.trash_item_repository'),
            service('doctrine.orm.entity_manager'),
            service('sulu_trash.doctrine_restore_helper'),
            service('sulu_activity.domain_event_collector'),
        ])
        ->tag('sulu_trash.store_trash_item_handler')
        ->tag('sulu_trash.restore_trash_item_handler')
        ->tag('sulu_trash.restore_configuration_provider');
};
