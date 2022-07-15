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

use Sulu\Bundle\FormBundle\Controller\FormTokenController;
use Sulu\Bundle\FormBundle\Controller\FormWebsiteController;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Mailer\MailerInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @internal
 */
class SuluFormExtension extends Extension implements PrependExtensionInterface
{
    public const SYSTEM_COLLECTION_ROOT = 'sulu_form';
    public const MEDIA_COLLECTION_STRATEGY_SINGLE = 'single';
    public const MEDIA_COLLECTION_STRATEGY_TREE = 'tree';

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('fos_js_routing')) {
            $container->prependExtensionConfig(
                'fos_js_routing',
                [
                    'routes_to_expose' => [
                        'sulu_form.get_forms',
                        'sulu_form.get_form',
                        'sulu_form.get_dynamics',
                        'sulu_form.delete_dynamic',
                    ],
                ]
            );
        }

        if ($container->hasExtension('framework')) {
            $container->prependExtensionConfig(
                'framework',
                [
                    'esi' => [
                        'enabled' => true,
                    ],
                ]
            );
        }

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

        if ($container->hasExtension('sulu_admin')) {
            $container->prependExtensionConfig(
                'sulu_admin',
                [
                    'lists' => [
                        'directories' => [
                            __DIR__ . '/../Resources/config/lists',
                        ],
                    ],
                    'resources' => [
                        Form::RESOURCE_KEY => [
                            'routes' => [
                                'list' => 'sulu_form.get_forms',
                                'detail' => 'sulu_form.get_form',
                            ],
                        ],
                        'dynamic_forms' => [
                            'routes' => [
                                'list' => 'sulu_form.get_dynamics',
                                'detail' => 'sulu_form.delete_dynamic',
                            ],
                        ],
                    ],
                    'field_type_options' => [
                        'single_selection' => [
                            'single_form_selection' => [
                                'default_type' => 'list_overlay',
                                'resource_key' => Form::RESOURCE_KEY,
                                'types' => [
                                    'list_overlay' => [
                                        'adapter' => 'table',
                                        'list_key' => 'forms',
                                        'display_properties' => ['title'],
                                        'empty_text' => 'sulu_form.single_form_selection.no_form_selected',
                                        'icon' => 'su-th-list',
                                        'overlay_title' => 'sulu_form.single_form_selection.overlay_title',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            );
        }
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $mediaCollectionStrategy = $config['media_collection_strategy'] ? $config['media_collection_strategy'] : $config['media']['collection_strategy'];

        $container->setParameter('sulu_form.csrf_protection', $config['csrf_protection']);
        $container->setParameter('sulu_form.mail.from', $config['mail']['from']);
        $container->setParameter('sulu_form.mail.to', $config['mail']['to']);
        $container->setParameter('sulu_form.mail.sender', $config['mail']['sender']);
        $container->setParameter('sulu_form.mail.template.notify', $config['mail']['templates']['notify']);
        $container->setParameter('sulu_form.mail.template.notify_plain_text', $config['mail']['templates']['notify_plain_text']);
        $container->setParameter('sulu_form.mail.template.customer', $config['mail']['templates']['customer']);
        $container->setParameter('sulu_form.mail.template.customer_plain_text', $config['mail']['templates']['customer_plain_text']);
        $container->setParameter('sulu_form.ajax_templates', $config['ajax_templates']);
        $container->setParameter('sulu_form.dynamic_widths', $config['dynamic_widths']);
        $container->setParameter('sulu_form.dynamic_auto_title', $config['dynamic_auto_title']);
        $container->setParameter('sulu_form.sendinblue_api_key', $config['sendinblue_api_key']);
        $container->setParameter('sulu_form.mailchimp_api_key', $config['mailchimp_api_key']);
        $container->setParameter('sulu_form.mailchimp_subscribe_status', $config['mailchimp_subscribe_status']);
        $container->setParameter('sulu_form.dynamic_lists.config', $config['dynamic_lists']);
        $container->setParameter('sulu_form.media_collection_strategy', $mediaCollectionStrategy);
        $container->setParameter('sulu_form.static_forms', $config['static_forms']);
        $container->setParameter('sulu_form.dynamic_disabled_types', $config['dynamic_disabled_types']);

        // Default Media Collection Strategy
        $container->setAlias(
            'sulu_form.media_collection_strategy.default',
            'sulu_form.media_collection_strategy.' . $mediaCollectionStrategy
        );

        // Dynamic List Builder
        $container->setParameter(
            'sulu_form.dynamic_list_builder.default',
            $config['dynamic_list_builder']['default']
        );

        $container->setParameter(
            'sulu_form.dynamic_list_builder.delimiter',
            $config['dynamic_list_builder']['delimiter']
        );

        $container->setParameter(
            'sulu_form.honeypot_field',
            $config['honeypot']['field']
        );

        $container->setParameter(
            'sulu_form.honeypot_strategy',
            $config['honeypot']['strategy']
        );

        // Load services
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('types.xml');
        $loader->load('title-providers.xml');

        $definition = $container->getDefinition('sulu_mail.null_helper');

        $reflection = new \ReflectionClass($definition);
        $reflectionMethod = $reflection->getMethod('setDeprecated');

        if (isset($reflectionMethod->getParameters()[1]) && 'version' === $reflectionMethod->getParameters()[1]->getName()) {
            $definition->setDeprecated('sulu/form-bundle', '2.3', 'The "%service_id%" is deprecated use the mailer configuration instead.');
        } else {
            $definition->setDeprecated(true, 'The "%service_id%" is deprecated use the mailer configuration instead.');
        }

        if ($config['sendinblue_api_key']) {
            if (!\class_exists(\SendinBlue\Client\Configuration::class)) {
                throw new \LogicException('You need to install the "sendinblue/api-v3-sdk" package to use the sendinblue type.');
            }

            $loader->load('type_sendinblue.xml');
        }

        if ($config['mailchimp_api_key']) {
            if (!\class_exists(\DrewM\MailChimp\MailChimp::class)) {
                throw new \LogicException('You need to install the "drewm/mailchimp-api" package to use the mailchimp type.');
            }

            $loader->load('type_mailchimp.xml');
        }

        $bundles = $container->getParameter('kernel.bundles');

        if (\array_key_exists('SuluArticleBundle', $bundles)) {
            $loader->load('article.xml');
        }

        if (\array_key_exists('SuluTrashBundle', $bundles)) {
            $loader->load('services_trash.xml');
        }

        if (\class_exists(\EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType::class)) {
            $loader->load('type_recaptcha.xml');
        }

        if (SuluKernel::CONTEXT_WEBSITE === $container->getParameter('sulu.context')) {
            $container->setAlias(FormWebsiteController::class, 'sulu_form.form_website_controller')
                ->setPublic(true);
            $container->setAlias(FormTokenController::class, 'sulu_form.form_token_controller')
                ->setPublic(true);
        }

        $container->setParameter('sulu_mail.mail.helper_name', $config['mail']['helper']);

        if ($config['media']['protected']) {
            $loader->load('protected_media.xml');
        }

        $this->configureHelper($loader, $config, $container);
    }

    /**
     * @param mixed[] $config
     */
    private function configureHelper(Loader\XmlFileLoader $loader, array $config, ContainerBuilder $container): void
    {
        $helper = $config['mail']['helper'];
        if (\method_exists($container, 'resolveEnvPlaceholders')) {
            $helper = $container->resolveEnvPlaceholders($helper, true);
        }

        if (\class_exists(\Swift_Mailer::class)) {
            $helper = $helper ?: 'swift_mailer';
            $loader->load('swift_mailer.xml');
        }

        if (\interface_exists(MailerInterface::class)) {
            $helper = $helper ?: 'mailer';
            $loader->load('mailer.xml');
        }

        if (!$helper) {
            throw new \LogicException('The SuluFormBundle requires "swiftmailer/swiftmailer" or "symfony/mailer" to be installed.');
        }

        $container->setAlias('sulu.mail.helper', 'sulu.mail.' . $helper);
    }
}
