<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sulu_form');

        $rootNode->children()
            ->scalarNode('mailchimp_api_key')->defaultValue(null)->end()
            ->enumNode('media_collection_strategy')
                ->values([
                    SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE,
                    SuluFormExtension::MEDIA_COLLECTION_STRATEGY_TREE,
                ])
                ->defaultValue(SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE)
            ->end()
            ->arrayNode('static_forms')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->scalarNode('class')->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('mail')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('from')->defaultValue('%sulu_admin.email%')->end()
                    ->scalarNode('to')->defaultValue('%sulu_admin.email%')->end()
                    ->arrayNode('templates')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('notify')
                                ->defaultValue('SuluFormBundle:mails:notify.html.twig')
                            ->end()
                            ->scalarNode('customer')
                                ->defaultValue('SuluFormBundle:mails:customer.html.twig')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('dynamic_list_builder')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('default')->defaultValue('simple')->end()
                    ->scalarNode('delimiter')->defaultValue(PHP_EOL)->end()
                ->end()
            ->end()
            ->scalarNode('dynamic_default_view')->defaultValue('AppBundle:templates:dynamic')->end()
            ->variableNode('dynamic_lists')->defaultValue([])->end()
            ->arrayNode('ajax_templates')
                ->prototype('scalar')->end()->defaultValue([])
            ->end()
        ;

        return $treeBuilder;
    }
}
