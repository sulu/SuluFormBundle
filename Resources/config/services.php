<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_locator;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $container->import('services/*');

    // Define here your own services:
    $services->set('sulu_form.handler', Sulu\Bundle\FormBundle\Form\Handler::class)
        ->args([
            service('doctrine.orm.entity_manager'),
            service('sulu.mail.helper'),
            service('twig'),
            service('event_dispatcher'),
            service('sulu_media.media_manager'),
            '%sulu_form.honeypot_strategy%',
            '%sulu_form.honeypot_field%',
        ]);

    $services->alias(Sulu\Bundle\FormBundle\Form\HandlerInterface::class, 'sulu_form.handler');

    $services->set('sulu_form.admin', Sulu\Bundle\FormBundle\Admin\FormAdmin::class)
        ->args([
            service('sulu_security.security_checker'),
            service('sulu_admin.view_builder_factory'),
            service('sulu_core.webspace.webspace_manager'),
        ])
        ->tag('sulu.admin')
        ->tag('sulu.context', ['context' => 'admin']);

    $services->set('sulu_form.dynamic_list_admin', Sulu\Bundle\FormBundle\Admin\DynamicListAdmin::class)
        ->args([
            service('sulu_admin.view_builder_factory'),
            '%sulu_form.dynamic_lists.config%',
        ])
        ->tag('sulu.admin', ['priority' => -1024])
        ->tag('sulu.context', ['context' => 'admin']);

    $services->set('sulu.list.provider.registry', Sulu\Bundle\FormBundle\Provider\ListProviderRegistry::class)
        ->args([tagged_locator('sulu_form.list_provider', indexAttribute: 'template')]);

    $services->set('sulu_form.manager.form', Sulu\Bundle\FormBundle\Manager\FormManager::class)
        ->public()
        ->args([
            service('doctrine.orm.entity_manager'),
            service('sulu_form.repository.form'),
            service('sulu_activity.domain_event_collector'),
            service('sulu_trash.trash_manager')->nullOnInvalid(),
        ]);

    $services->set('sulu_form.content_type.single_form_property_resolver', Sulu\Bundle\FormBundle\Content\PropertyResolver\SingleFormSelectionPropertyResolver::class)
        ->args([
            service(Sulu\Bundle\FormBundle\Repository\FormRepository::class)])
        ->tag('sulu_content.property_resolver');

    $services->set('sulu_form.content_type.form_resource_loader', Sulu\Bundle\FormBundle\Content\ResourceLoader\FormResourceLoader::class)
        ->args([
            service(BuilderInterface::class)
        ])
        ->tag('sulu_content.resource_loader', ['type' => 'sulu_form']);

    $services->set('sulu_form.configuration.form_configuration_factory', Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory::class)
        ->args([
            service('sulu_form.media_collection_strategy.default'),
            '%sulu_form.mail.template.notify%',
            '%sulu_form.mail.template.customer%',
            '%sulu_form.mail.template.notify_plain_text%',
            '%sulu_form.mail.template.customer_plain_text%',
        ]);

    $services->alias(Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory::class, 'sulu_form.configuration.form_configuration_factory');

    $services->set('sulu_form.builder', Sulu\Bundle\FormBundle\Form\Builder::class)
        ->args([
            service('request_stack'),
            service('sulu_form.dynamic.form_field_type_pool'),
            service('sulu_form.title_provider.pool'),
            service('sulu_form.repository.form'),
            service('form.factory'),
            service('sulu_form.checksum'),
            service('security.csrf.token_manager'),
            '%sulu_form.csrf_protection%',
        ]);

    $services->alias(Sulu\Bundle\FormBundle\Form\BuilderInterface::class, 'sulu_form.builder');

    $services->set('sulu_form.form_type', Sulu\Bundle\FormBundle\Form\Type\DynamicFormType::class)
        ->args([
            service('sulu_form.dynamic.form_field_type_pool'),
            service('sulu_form.checksum'),
            '%sulu_form.honeypot_field%',
        ])
        ->tag('form.type');

    $services->set('sulu_form.request_listener', Sulu\Bundle\FormBundle\Event\FormDataRequestListener::class)
        ->args([
            service('sulu_form.builder'),
            service('sulu_form.handler'),
            service('sulu_form.configuration.form_configuration_factory'),
            service('event_dispatcher'),
        ])
        ->tag('kernel.event_listener', ['event' => 'kernel.request', 'method' => 'onKernelRequest'])
        ->tag('kernel.event_listener', ['event' => 'kernel.response', 'method' => 'onKernelResponse'])
        ->tag('kernel.reset', ['method' => 'reset']);

    $services->set('sulu_form.list_builder.dynamic_list_factory', Sulu\Bundle\FormBundle\Admin\ListBuilder\DynamicListFactory::class)
        ->args([
            '%sulu_form.dynamic_list_builder.default%',
            tagged_iterator('sulu_form.dynamic_list_builder', indexAttribute: 'alias'),
        ]);

    $services->alias(Sulu\Bundle\FormBundle\Admin\ListBuilder\DynamicListFactoryInterface::class, 'sulu_form.list_builder.dynamic_list_factory');

    $services->set('sulu_form.list_builder.dynamic_list_builder', Sulu\Bundle\FormBundle\Admin\ListBuilder\DynamicListBuilder::class)
        ->args([
            '%sulu_form.dynamic_list_builder.delimiter%',
            service('router'),
        ])
        ->tag('sulu_form.dynamic_list_builder', ['alias' => 'simple']);

    $services->alias(Sulu\Bundle\FormBundle\Admin\ListBuilder\DynamicListBuilderInterface::class, 'sulu_form.list_builder.dynamic_list_builder');

    $services->set('sulu_form.repository.form', Sulu\Bundle\FormBundle\Repository\FormRepository::class)
        ->args([Sulu\Bundle\FormBundle\Entity\Form::class])
        ->factory([service('doctrine.orm.entity_manager'), 'getRepository']);

    $services->alias(Sulu\Bundle\FormBundle\Repository\FormRepository::class, 'sulu_form.repository.form');

    $services->set('sulu_form.repository.dynamic', Sulu\Bundle\FormBundle\Repository\DynamicRepository::class)
        ->args([Sulu\Bundle\FormBundle\Entity\Dynamic::class])
        ->factory([service('doctrine.orm.entity_manager'), 'getRepository']);

    $services->set('sulu_form.media_collection_strategy.tree', Sulu\Bundle\FormBundle\Media\CollectionStrategyTree::class)
        ->args([
            service('sulu_media.collection_manager'),
            service('sulu_media.system_collections.manager'),
            service('sulu_form.title_provider.pool'),
        ]);

    $services->set('sulu_form.media_collection_strategy.single', Sulu\Bundle\FormBundle\Media\CollectionStrategySingle::class)
        ->args([service('sulu_media.system_collections.manager')]);

    $services->set('sulu_form.dynamic.form_field_type_pool', Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool::class)
        ->args([tagged_iterator('sulu_form.dynamic.type', indexAttribute: 'alias')]);

    $services->set('sulu_form.twig_extension', Sulu\Bundle\FormBundle\Twig\FormTwigExtension::class)
        ->args([service('sulu_form.builder')])
        ->tag('twig.extension');

    $services->set('sulu_form.checksum', Sulu\Bundle\FormBundle\Dynamic\Checksum::class)
        ->args(['%kernel.secret%']);

    $services->set('sulu_form.metadata.properties_xml_loader', Sulu\Bundle\FormBundle\Metadata\PropertiesXmlLoader::class)
        ->args([service('sulu_admin.properties_xml_parser')]);

    $services->set('sulu_form.form_token_controller', Sulu\Bundle\FormBundle\Controller\FormTokenController::class)
        ->public()
        ->args([service('security.csrf.token_manager')])
        ->tag('sulu.context', ['context' => 'website']);

    $services->set('sulu_form.metadata.dynamic_list_metadata_loader', Sulu\Bundle\FormBundle\Metadata\DynamicListMetadataLoader::class)
        ->args([
            service('translator'),
            service('sulu_form.manager.form'),
            service('sulu_form.list_builder.dynamic_list_factory'),
        ])
        ->tag('sulu_admin.list_metadata_loader');

    $services->set('sulu_form.cache_invalidation_listener', Sulu\Bundle\FormBundle\Event\CacheInvalidationListener::class)
        ->args([service('sulu_http_cache.cache_manager')->nullOnInvalid()])
        ->tag('doctrine.event_listener', ['event' => 'postUpdate'])
        ->tag('doctrine.event_listener', ['event' => 'preRemove']);

    $services->set('sulu_form.form_generator_command', Sulu\Bundle\FormBundle\Command\FormGeneratorCommand::class)
        ->args([
            service('doctrine.orm.entity_manager'),
            service('sulu_core.webspace.webspace_manager'),
        ])
        ->tag('console.command');
};
