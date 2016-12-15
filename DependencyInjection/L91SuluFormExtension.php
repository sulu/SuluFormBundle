<?php

namespace L91\Sulu\Bundle\FormBundle\DependencyInjection;

use L91\Sulu\Bundle\FormBundle\Admin\DynamicListNavigationProvider;
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
class L91SuluFormExtension extends Extension implements PrependExtensionInterface
{
    const SYSTEM_COLLECTION_ROOT = 'l91_sulu_form';
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

        $container->setParameter('l91.sulu.form.mail.from', $config['mail_helper']['from']);
        $container->setParameter('l91.sulu.form.mail.to', $config['mail_helper']['to']);
        $container->setParameter('l91.sulu.form.ajax_templates', $config['ajax_templates']);
        $container->setParameter('l91.sulu.form.mailchimp_api_key', $config['mailchimp_api_key']);
        $container->setParameter('l91.sulu.form.dynamic_default_view', $config['dynamic_default_view']);
        $container->setParameter('l91.sulu.form.dynamic_lists.config', $config['dynamic_lists']);
        $container->setParameter('l91.sulu.form.media_collection_strategy', $config['media_collection_strategy']);

        // Default Media Collection Strategy
        $container->setAlias(
            'l91_sulu_form.media_collection_strategy.default',
            'l91_sulu_form.media_collection_strategy.' . $config['media_collection_strategy']
        );

        // add dynamic lists
        foreach ($config['dynamic_lists'] as $key => $value) {
            $parameter = 'l91.sulu.form.dynamic_lists.' . $key . '.config';
            $container->setParameter($parameter, $value);

            $definition = new Definition(DynamicListNavigationProvider::class);
            $definition->addArgument('%' . $parameter . '%');
            $definition->addArgument($key);
            $definition->setClass(DynamicListNavigationProvider::class);
            $definition->addTag('sulu_admin.content_navigation', ['alias' => $key]);
            $definition->addTag('sulu.context', ['context' => 'admin']);
            $container->setDefinition('l91_sulu_form.navigation_provider.' . $key . '.dynamic_list', $definition);
        }

        // Dynamic List Builder
        $container->setParameter(
            'l91.sulu.form.dynamic_list_builder.default',
            $config['dynamic_list_builder']['default']
        );

        $container->setParameter(
            'l91.sulu.form.dynamic_list_builder.delimiter',
            $config['dynamic_list_builder']['delimiter']
        );

        // Load services
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if ($config['mailchimp_api_key']) {
            $loader->load('mailchimp_services.xml');
        }
    }
}
