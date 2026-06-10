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
use Sulu\Bundle\FormBundle\Controller\SelectApi\BrevoListSelectController;
use Sulu\Bundle\FormBundle\Controller\SelectApi\BrevoMailTemplateSelectController;
use Sulu\Bundle\FormBundle\Controller\SelectApi\MailchimpListSelectController;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

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
            $additionalResources = [];
            $additionalSelections = [];

            if (\class_exists(\DrewM\MailChimp\MailChimp::class)) {
                $additionalResources[MailchimpListSelectController::RESOURCE_KEY] = [
                    'routes' => [
                        'list' => 'sulu_form.get_mail_chimp_values',
                        'detail' => 'sulu_form.get_mail_chimp_value',
                    ],
                ];

                $additionalSelections['single_mail_chimp_selection'] = [
                    'default_type' => 'auto_complete',
                    'resource_key' => MailchimpListSelectController::RESOURCE_KEY,
                    'types' => [
                        'auto_complete' => [
                            'display_property' => 'title',
                            'search_properties' => ['title'],
                        ],
                        'list_overlay' => [
                            'adapter' => 'table',
                            'list_key' => MailchimpListSelectController::RESOURCE_KEY,
                            'display_properties' => ['title'],
                            'empty_text' => 'sulu_form.mailchimp_list_selection.empty_text',
                            'icon' => 'su-th-list',
                            'overlay_title' => 'sulu_form.mailchimp_list_selection.overlay_title',
                        ],
                    ],
                ];
            }

            if (\class_exists(\Brevo\Types\Configuration::class)) {
                $additionalResources[BrevoListSelectController::RESOURCE_KEY] = [
                    'routes' => [
                        'list' => 'sulu_form.get_brevo_values',
                        'detail' => 'sulu_form.get_brevo_value',
                    ],
                ];
                $additionalResources[BrevoMailTemplateSelectController::RESOURCE_KEY] = [
                    'routes' => [
                        'list' => 'sulu_form.get_brevo_mail_templates',
                        'detail' => 'sulu_form.get_brevo_mail_template',
                    ],
                ];

                $additionalSelections['single_brevo_list_selection'] = [
                    'default_type' => 'auto_complete',
                    'resource_key' => BrevoListSelectController::RESOURCE_KEY,
                    'types' => [
                        'auto_complete' => [
                            'display_property' => 'title',
                            'search_properties' => ['title'],
                        ],
                        'list_overlay' => [
                            'adapter' => 'table',
                            'list_key' => BrevoListSelectController::RESOURCE_KEY,
                            'display_properties' => ['title'],
                            'empty_text' => 'sulu_form.brevo_list_selection.empty_text',
                            'icon' => 'su-th-list',
                            'overlay_title' => 'sulu_form.brevo_list_selection.overlay_title',
                        ],
                    ],
                ];
                $additionalSelections['single_brevo_mail_template_selection'] = [
                    'default_type' => 'auto_complete',
                    'resource_key' => BrevoMailTemplateSelectController::RESOURCE_KEY,
                    'types' => [
                        'auto_complete' => [
                            'display_property' => 'title',
                            'search_properties' => ['title'],
                        ],
                        'list_overlay' => [
                            'adapter' => 'table',
                            'list_key' => BrevoMailTemplateSelectController::RESOURCE_KEY,
                            'display_properties' => ['title'],
                            'empty_text' => 'sulu_form.brevo_mail_template_selection.empty_text',
                            'icon' => 'su-th-list',
                            'overlay_title' => 'sulu_form.brevo_mail_template_selection.overlay_title',
                        ],
                    ],
                ];
            }

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
                        ...$additionalResources,
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
                            ...$additionalSelections,
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

        $mediaCollectionStrategy = $config['media']['collection_strategy'];

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
        $container->setParameter('sulu_form.brevo_api_key', $config['brevo_api_key']);
        $container->setParameter('sulu_form.mailchimp_api_key', $config['mailchimp_api_key']);
        $container->setParameter('sulu_form.mailchimp_subscribe_status', $config['mailchimp_subscribe_status']);
        $container->setParameter('sulu_form.dynamic_lists.config', $config['dynamic_lists']);
        $container->setParameter('sulu_form.media_collection_strategy', $mediaCollectionStrategy);
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
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('mailer.xml');
        $loader->load('types.xml');
        $loader->load('title-providers.xml');

        if ($config['brevo_api_key']) {
            if (
                !\class_exists(\Brevo\Types\Configuration::class)
                || \version_compare(\Composer\InstalledVersions::getVersion('getbrevo/brevo-php') ?? '0', '4.0', '<')
            ) {
                throw new \LogicException('You need to install the "getbrevo/brevo-php" version ^4.0 to use the Brevo type.');
            }

            $loader->load('type_brevo.xml');
        }

        if ($config['mailchimp_api_key']) {
            if (!\class_exists(\DrewM\MailChimp\MailChimp::class)) {
                throw new \LogicException('You need to install the "drewm/mailchimp-api" package to use the mailchimp type.');
            }

            $loader->load('type_mailchimp.xml');
        }

        /** @var array<string, class-string> $bundles */
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
            $container->setAlias(FormTokenController::class, 'sulu_form.form_token_controller')
                ->setPublic(true);
        }

        if ($config['media']['protected']) {
            $loader->load('protected_media.xml');
        }
    }
}
