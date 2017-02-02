<?php

namespace Sulu\Bundle\FormBundle\DependencyInjection;

use Sulu\Bundle\FormBundle\Admin\DynamicListNavigationProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SuluFormExtension extends Extension implements PrependExtensionInterface
{
    const SYSTEM_COLLECTION_ROOT = 'sulu_form';
    const MEDIA_COLLECTION_STRATEGY_SINGLE = 'single';
    const MEDIA_COLLECTION_STRATEGY_TREE = 'tree';

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        if ($container->hasExtension('sulu_media')) {
            $container->prependExtensionConfig(
                'sulu_media',
                [
                    'system_collections' => [
                        self::SYSTEM_COLLECTION_ROOT => [
                            'meta_title' => ['en' => 'Sulu forms', 'de' => 'Sulu Formulare'],
                            'collections' => [
                                'attachments' => [
                                    'meta_title' => ['en' => 'Attachments', 'de' => 'Anhänge'],
                                ],
                            ],
                        ],
                    ],
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('sulu_form.mail.from', $config['mail']['from']);
        $container->setParameter('sulu_form.mail.to', $config['mail']['to']);
        $container->setParameter('sulu_form.mail.template.notify', $config['mail']['templates']['notify']);
        $container->setParameter('sulu_form.mail.template.customer', $config['mail']['templates']['customer']);
        $container->setParameter('sulu_form.ajax_templates', $config['ajax_templates']);
        $container->setParameter('sulu_form.mailchimp_api_key', $config['mailchimp_api_key']);
        $container->setParameter('sulu_form.dynamic_default_view', $config['dynamic_default_view']);
        $container->setParameter('sulu_form.dynamic_lists.config', $config['dynamic_lists']);
        $container->setParameter('sulu_form.media_collection_strategy', $config['media_collection_strategy']);

        // Default Media Collection Strategy
        $container->setAlias(
            'sulu_form.media_collection_strategy.default',
            'sulu_form.media_collection_strategy.' . $config['media_collection_strategy']
        );

        // add dynamic lists
        foreach ($config['dynamic_lists'] as $key => $value) {
            $parameter = 'sulu_form.dynamic_lists.' . $key . '.config';
            $container->setParameter($parameter, $value);

            $definition = new Definition(DynamicListNavigationProvider::class);
            $definition->addArgument('%' . $parameter . '%');
            $definition->addArgument($key);
            $definition->setClass(DynamicListNavigationProvider::class);
            $definition->addTag('sulu_admin.content_navigation', ['alias' => $key]);
            $definition->addTag('sulu.context', ['context' => 'admin']);
            $container->setDefinition('sulu_form.navigation_provider.' . $key . '.dynamic_list', $definition);
        }

        // Dynamic List Builder
        $container->setParameter(
            'sulu_form.dynamic_list_builder.default',
            $config['dynamic_list_builder']['default']
        );

        $container->setParameter(
            'sulu_form.dynamic_list_builder.delimiter',
            $config['dynamic_list_builder']['delimiter']
        );

        // Load services
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('types.xml');

        if ($config['mailchimp_api_key']) {
            $loader->load('type_mailchimp.xml');
        }

        if (class_exists(\EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType::class)) {
            $loader->load('type_recaptcha.xml');
        }
    }
}
