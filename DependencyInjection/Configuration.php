<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\DependencyInjection;

use Sulu\Bundle\FormBundle\Form\HandlerInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @internal
 */
class Configuration implements ConfigurationInterface
{
    public const SWIFT_MAILER_HELPER = 'swift_mailer';
    public const MAILER_HELPER = 'mailer';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sulu_form');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->booleanNode('csrf_protection')
                ->info('Enable csrf protection for dynamic forms.')
                ->defaultFalse()
            ->end()
            ->scalarNode('sendinblue_api_key')->defaultValue(null)->end()
            ->scalarNode('mailchimp_api_key')->defaultValue(null)->end()
            ->scalarNode('mailchimp_subscribe_status')->defaultValue('subscribed')->end()
            ->enumNode('media_collection_strategy')
                ->values([
                    null,
                    SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE,
                    SuluFormExtension::MEDIA_COLLECTION_STRATEGY_TREE,
                ])
                ->defaultValue(null)
                ->setDeprecated('sulu/form-bundle', '2.2.0')
            ->end()
            ->arrayNode('media')
                ->addDefaultsIfNotSet()
                ->children()
                    ->booleanNode('protected')
                        ->info('Enables the media protection so media are only downloadable from the admin.')
                        ->defaultValue(false)
                    ->end()
                    ->enumNode('collection_strategy')
                        ->values([
                            SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE,
                            SuluFormExtension::MEDIA_COLLECTION_STRATEGY_TREE,
                        ])
                        ->defaultValue(SuluFormExtension::MEDIA_COLLECTION_STRATEGY_SINGLE)
                    ->end()
                ->end()
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
                    ->scalarNode('helper')
                        ->defaultValue(null)
                        ->info('Shipped helper are "swift_mailer" and "mailer", defaults to "swift_mailer" if both exists.')
                    ->end()
                    ->scalarNode('from')->defaultValue(null)->end()
                    ->scalarNode('to')->defaultValue(null)->end()
                    ->scalarNode('sender')->defaultValue(null)->end()
                    ->arrayNode('templates')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('notify')
                                ->defaultValue('@SuluForm/mails/notify.html.twig')
                            ->end()
                            ->scalarNode('notify_plain_text')
                                ->defaultValue('@SuluForm/mails/notify_plain_text.html.twig')
                            ->end()
                            ->scalarNode('customer')
                                ->defaultValue('@SuluForm/mails/customer.html.twig')
                            ->end()
                            ->scalarNode('customer_plain_text')
                                ->defaultValue('@SuluForm/mails/customer_plain_text.html.twig')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('dynamic_list_builder')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('default')->defaultValue('simple')->end()
                    ->scalarNode('delimiter')->defaultValue(\PHP_EOL)->end()
                ->end()
            ->end()
            ->booleanNode('dynamic_auto_title')->defaultValue(true)->end()
            ->arrayNode('dynamic_widths')
                ->normalizeKeys(false)
                ->prototype('scalar')->end()->defaultValue([
                    'full' => 'sulu_form.width.full',
                    'half' => 'sulu_form.width.half',
                    'one-third' => 'sulu_form.width.one-third',
                    'two-thirds' => 'sulu_form.width.two-thirds',
                    'one-quarter' => 'sulu_form.width.one-quarter',
                    'three-quarters' => 'sulu_form.width.three-quarters',
                    'one-sixth' => 'sulu_form.width.one-sixth',
                    'five-sixths' => 'sulu_form.width.five-sixths',
                ])
            ->end()
            ->variableNode('dynamic_lists')->defaultValue([])->end()
            ->arrayNode('ajax_templates')
                ->normalizeKeys(false)
                ->prototype('scalar')->end()->defaultValue([])
            ->end()
            ->arrayNode('honeypot')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('field')->defaultValue(null)->end()
                    ->enumNode('strategy')
                        ->defaultValue(HandlerInterface::HONEY_POT_STRATEGY_SPAM)
                        ->values([
                            HandlerInterface::HONEY_POT_STRATEGY_SPAM,
                            HandlerInterface::HONEY_POT_STRATEGY_NO_EMAIL,
                            HandlerInterface::HONEY_POT_STRATEGY_NO_SAVE,
                        ])
                    ->end()
                ->end()
            ->end()
            ->arrayNode('dynamic_disabled_types')
                ->prototype('scalar')->end()->defaultValue([])
            ->end()
        ;

        return $treeBuilder;
    }
}
