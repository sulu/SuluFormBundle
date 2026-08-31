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

use Sulu\Bundle\FormBundle\Admin\DynamicListAdmin;
use Sulu\Bundle\FormBundle\Admin\FormAdmin;
use Sulu\Bundle\FormBundle\Command\FormGeneratorCommand;
use Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory;
use Sulu\Bundle\FormBundle\Content\Types\SingleFormSelection;
use Sulu\Bundle\FormBundle\Controller\DynamicController;
use Sulu\Bundle\FormBundle\Controller\FormController;
use Sulu\Bundle\FormBundle\Controller\FormTokenController;
use Sulu\Bundle\FormBundle\Controller\FormWebsiteController;
use Sulu\Bundle\FormBundle\Controller\ListController;
use Sulu\Bundle\FormBundle\Dynamic\Checksum;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Event\CacheInvalidationListener;
use Sulu\Bundle\FormBundle\Event\RequestListener;
use Sulu\Bundle\FormBundle\Form\Builder;
use Sulu\Bundle\FormBundle\Form\Handler;
use Sulu\Bundle\FormBundle\Form\Type\DynamicFormType;
use Sulu\Bundle\FormBundle\ListBuilder\DynamicListBuilder;
use Sulu\Bundle\FormBundle\ListBuilder\DynamicListFactory;
use Sulu\Bundle\FormBundle\Mail\NullHelper;
use Sulu\Bundle\FormBundle\Manager\FormManager;
use Sulu\Bundle\FormBundle\Media\CollectionStrategySingle;
use Sulu\Bundle\FormBundle\Media\CollectionStrategyTree;
use Sulu\Bundle\FormBundle\Metadata\DynamicFormMetadataLoader;
use Sulu\Bundle\FormBundle\Metadata\DynamicListMetadataLoader;
use Sulu\Bundle\FormBundle\Metadata\PropertiesXmlLoader;
use Sulu\Bundle\FormBundle\Provider\ListProviderRegistry;
use Sulu\Bundle\FormBundle\Repository\DynamicRepository;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\FormBundle\Twig\FormTwigExtension;
use Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStore;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.handler', Handler::class)
        ->args([
            new Reference('doctrine.orm.entity_manager'),
            new Reference('sulu.mail.helper'),
            new Reference('twig'),
            new Reference('event_dispatcher'),
            new Reference('sulu_media.media_manager'),
            '%sulu_form.honeypot_strategy%',
            '%sulu_form.honeypot_field%',
        ]);

    $services->alias(\Sulu\Bundle\FormBundle\Form\HandlerInterface::class, 'sulu_form.handler');

    $services->set('sulu_mail.null_helper', NullHelper::class)
        ->args([new Reference('logger')]);

    $services->set('sulu_form.admin', FormAdmin::class)
        ->args([
            new Reference('sulu_security.security_checker'),
            new Reference('sulu_admin.view_builder_factory'),
            new Reference('sulu_core.webspace.webspace_manager'),
        ])
        ->tag('sulu.admin')
        ->tag('sulu.context', ['context' => 'admin']);

    $services->set('sulu_form.dynamic_list_admin', DynamicListAdmin::class)
        ->args([
            new Reference('sulu_admin.view_builder_factory'),
            '%sulu_form.dynamic_lists.config%',
        ])
        ->tag('sulu.admin')
        ->tag('sulu.context', ['context' => 'admin']);

    $services->set('sulu.list.provider.registry', ListProviderRegistry::class);

    $services->set('sulu_form.manager.form', FormManager::class)
        ->public()
        ->args([
            new Reference('doctrine.orm.entity_manager'),
            new Reference('sulu_form.repository.form'),
            new Reference('sulu_activity.domain_event_collector'),
            new Reference('sulu_trash.trash_manager', ContainerInterface::NULL_ON_INVALID_REFERENCE),
        ]);

    $services->set('sulu_form.content_type.single_form_selection', SingleFormSelection::class)
        ->args([
            new Reference('sulu_form.repository.form'),
            new Reference('sulu_form.builder'),
            new Reference('sulu_form.reference_store.form'),
        ])
        ->tag('sulu.content.type', ['alias' => 'single_form_selection']);

    $services->set('sulu_form.configuration.form_configuration_factory', FormConfigurationFactory::class)
        ->args([
            new Reference('sulu_form.media_collection_strategy.default'),
            '%sulu_form.mail.template.notify%',
            '%sulu_form.mail.template.customer%',
            '%sulu_form.mail.template.notify_plain_text%',
            '%sulu_form.mail.template.customer_plain_text%',
        ]);

    $services->alias(FormConfigurationFactory::class, 'sulu_form.configuration.form_configuration_factory');

    $services->set('sulu_form.builder', Builder::class)
        ->args([
            new Reference('request_stack'),
            new Reference('sulu_form.dynamic.form_field_type_pool'),
            new Reference('sulu_form.title_provider.pool'),
            new Reference('sulu_form.repository.form'),
            new Reference('form.factory'),
            new Reference('sulu_form.checksum'),
            new Reference('security.csrf.token_manager'),
            '%sulu_form.csrf_protection%',
        ]);

    $services->set('sulu_form.form_type', DynamicFormType::class)
        ->args([
            new Reference('sulu_form.dynamic.form_field_type_pool'),
            new Reference('sulu_form.checksum'),
            '%sulu_form.honeypot_field%',
        ])
        ->tag('form.type');

    $services->set('sulu_form.request_listener', RequestListener::class)
        ->args([
            new Reference('sulu_form.builder'),
            new Reference('sulu_form.handler'),
            new Reference('sulu_form.configuration.form_configuration_factory'),
            new Reference('event_dispatcher'),
        ])
        ->tag('kernel.event_listener', ['event' => 'kernel.request', 'method' => 'onKernelRequest'])
        ->tag('kernel.event_listener', ['event' => 'kernel.response', 'method' => 'onKernelResponse'])
        ->tag('kernel.reset', ['method' => 'reset']);

    $services->set('sulu_form.list_builder.dynamic_list_factory', DynamicListFactory::class)
        ->args(['%sulu_form.dynamic_list_builder.default%']);

    $services->set('sulu_form.list_builder.dynamic_list_builder', DynamicListBuilder::class)
        ->args([
            '%sulu_form.dynamic_list_builder.delimiter%',
            new Reference('router'),
        ])
        ->tag('sulu_form.dynamic_list_builder', ['alias' => 'simple']);

    $services->set('sulu_form.repository.form', FormRepository::class)
        ->args([\Sulu\Bundle\FormBundle\Entity\Form::class])
        ->factory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);

    $services->set('sulu_form.repository.dynamic', DynamicRepository::class)
        ->args([\Sulu\Bundle\FormBundle\Entity\Dynamic::class])
        ->factory([new Reference('doctrine.orm.entity_manager'), 'getRepository']);

    $services->set('sulu_form.media_collection_strategy.tree', CollectionStrategyTree::class)
        ->args([
            new Reference('sulu_media.collection_manager'),
            new Reference('sulu_media.system_collections.manager'),
            new Reference('sulu_form.title_provider.pool'),
        ]);

    $services->set('sulu_form.media_collection_strategy.single', CollectionStrategySingle::class)
        ->args([new Reference('sulu_media.system_collections.manager')]);

    $services->set('sulu_form.dynamic.form_field_type_pool', FormFieldTypePool::class)
        ->args([[]]);

    $services->set('sulu_form.twig_extension', FormTwigExtension::class)
        ->args([new Reference('sulu_form.builder')])
        ->tag('twig.extension');

    $services->set('sulu_form.checksum', Checksum::class)
        ->args(['%kernel.secret%']);

    $services->set('sulu_form.reference_store.form', ReferenceStore::class)
        ->tag('sulu_website.reference_store', ['alias' => 'form']);

    $services->set('sulu_form.metadata.properties_xml_loader', PropertiesXmlLoader::class)
        ->args([new Reference('sulu_page.structure.properties_xml_parser')]);

    $services->set('sulu_form.metadata.dynamic_form_metadata_loader', DynamicFormMetadataLoader::class)
        ->args([
            new Reference('sulu_form.dynamic.form_field_type_pool'),
            new Reference('sulu_form.metadata.properties_xml_loader'),
            new Reference('sulu_admin.form_metadata.form_xml_loader'),
            new Reference('sulu_admin.form_metadata.form_metadata_mapper'),
            new Reference('translator'),
            '%kernel.cache_dir%/sulu-form-bundle/forms',
            '%kernel.debug%',
        ])
        ->tag('sulu.context', ['context' => 'admin'])
        ->tag('kernel.cache_warmer')
        ->tag('sulu_admin.form_metadata_loader');

    $services->set('sulu_form.dynamic_controller', DynamicController::class)
        ->public()
        ->args([
            new Reference('sulu_form.repository.dynamic'),
            new Reference('sulu_form.list_builder.dynamic_list_factory'),
            new Reference('sulu_media.media_manager'),
            new Reference('doctrine.orm.entity_manager'),
            new Reference('sulu_form.repository.form'),
            new Reference('fos_rest.view_handler'),
        ]);

    $services->set('sulu_form.form_controller', FormController::class)
        ->public()
        ->args([
            new Reference('fos_rest.view_handler.default'),
            new Reference('security.token_storage'),
            new Reference('sulu_form.manager.form'),
            new Reference('sulu_core.doctrine_rest_helper'),
            new Reference('sulu_core.doctrine_list_builder_factory'),
            new Reference('sulu_core.list_builder.field_descriptor_factory'),
            new Reference('sulu_core.list_rest_helper'),
            new Reference('sulu_activity.domain_event_dispatcher'),
        ])
        ->tag('sulu.context', ['context' => 'admin']);

    $services->set('sulu_form.list_controller', ListController::class)
        ->public()
        ->args([
            new Reference('fos_rest.view_handler.default'),
            new Reference('security.token_storage'),
            new Reference('sulu_core.doctrine_rest_helper'),
            new Reference('sulu_core.doctrine_list_builder_factory'),
            new Reference('sulu.list.provider.registry'),
        ])
        ->tag('sulu.context', ['context' => 'admin']);

    $services->set('sulu_form.form_website_controller', FormWebsiteController::class)
        ->public()
        ->tag('container.service_subscriber')
        ->tag('controller.service_arguments')
        ->tag('sulu.context', ['context' => 'website'])
        ->call('setContainer', [new Reference(\Psr\Container\ContainerInterface::class)]);

    $services->set('sulu_form.form_token_controller', FormTokenController::class)
        ->public()
        ->args([new Reference('security.csrf.token_manager')])
        ->tag('sulu.context', ['context' => 'website']);

    $services->set('sulu_form.metadata.dynamic_list_metadata_loader', DynamicListMetadataLoader::class)
        ->args([
            new Reference('translator'),
            new Reference('sulu_form.manager.form'),
            new Reference('sulu_form.list_builder.dynamic_list_factory'),
        ])
        ->tag('sulu_admin.list_metadata_loader');

    $services->set('sulu_form.cache_invalidation_listener', CacheInvalidationListener::class)
        ->args([new Reference('sulu_http_cache.cache_manager', ContainerInterface::NULL_ON_INVALID_REFERENCE)])
        ->tag('doctrine.event_listener', ['event' => 'postUpdate'])
        ->tag('doctrine.event_listener', ['event' => 'preRemove']);

    $services->set('sulu_form.form_generator_command', FormGeneratorCommand::class)
        ->args([
            new Reference('doctrine.orm.entity_manager'),
            new Reference('sulu_core.webspace.webspace_manager'),
        ])
        ->tag('console.command');
};
