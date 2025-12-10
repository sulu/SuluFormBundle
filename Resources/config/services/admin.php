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

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.metadata.dynamic_form_metadata_loader', Sulu\Bundle\FormBundle\Metadata\DynamicFormMetadataLoader::class)
        ->args([
            service('sulu_form.dynamic.form_field_type_pool'),
            service('sulu_form.metadata.properties_xml_loader'),
            service('sulu_admin.form_metadata.form_xml_loader'),
            service('translator'),
            '%kernel.cache_dir%/sulu-form-bundle/forms',
            '%kernel.enabled_locales%',
            '%kernel.debug%',
        ])
    ;

    $services->set('sulu_form.dynamic_controller', Sulu\Bundle\FormBundle\Admin\Controller\DynamicController::class)
        ->public()
        ->args([
            service('sulu_form.repository.dynamic'),
            service('sulu_form.list_builder.dynamic_list_factory'),
            service('sulu_media.media_manager'),
            service('doctrine.orm.entity_manager'),
            service('sulu_form.repository.form'),
            service('fos_rest.view_handler'),
        ])
    ;

    $services->set('sulu_form.form_controller', Sulu\Bundle\FormBundle\Admin\Controller\FormController::class)
        ->public()
        ->args([
            service('fos_rest.view_handler.default'),
            service(TokenStorageInterface::class),
            service('sulu_form.manager.form'),
            service('sulu_core.doctrine_rest_helper'),
            service('sulu_core.doctrine_list_builder_factory'),
            service('sulu_core.list_builder.field_descriptor_factory'),
            service('sulu_core.list_rest_helper'),
            service('sulu_activity.domain_event_dispatcher'),
        ])
    ;

    $services->set('sulu_form.list_controller', Sulu\Bundle\FormBundle\Admin\Controller\ListController::class)
        ->public()
        ->args([
            service('fos_rest.view_handler.default'),
            service(TokenStorageInterface::class),
            service('sulu_core.doctrine_rest_helper'),
            service('sulu_core.doctrine_list_builder_factory'),
            service('sulu.list.provider.registry'),
        ])
    ;
};
