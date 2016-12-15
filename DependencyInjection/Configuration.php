<?php

namespace L91\Sulu\Bundle\FormBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('l91_sulu_form');

        $rootNode->children()
            ->scalarNode('mailchimp_api_key')->defaultValue(null)->end()
            ->enumNode('media_collection_strategy')
                ->values([
                    L91SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE,
                    L91SuluFormExtension::MEDIA_COLLECTION_STRATEGY_TREE,
                ])
                ->defaultValue(L91SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE)
            ->end()
            ->arrayNode('mail_helper')
                ->children()
                    ->scalarNode('from')->end()
                    ->scalarNode('to')->end()
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
