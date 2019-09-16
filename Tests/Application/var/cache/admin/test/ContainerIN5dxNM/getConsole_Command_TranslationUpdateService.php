<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'console.command.translation_update' shared service.

$this->privates['console.command.translation_update'] = $instance = new \Symfony\Bundle\FrameworkBundle\Command\TranslationUpdateCommand(($this->privates['translation.writer'] ?? $this->load('getTranslation_WriterService.php')), ($this->privates['translation.reader'] ?? $this->load('getTranslation_ReaderService.php')), ($this->privates['translation.extractor'] ?? $this->load('getTranslation_ExtractorService.php')), 'en', ($this->targetDirs[4].'/translations'), ($this->targetDirs[4].'/templates'), [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations'], [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bridge/Resources/views/Form', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/framework-bundle/Command/TranslationDebugCommand.php', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Extension/Core/Type/FileType.php', 3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Extension/Core/Type/TransformationFailureExtension.php', 4 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Extension/Validator/Type/UploadValidatorExtension.php', 5 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Extension/Csrf/Type/FormTypeCsrfExtension.php', 6 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Util/LegacyTranslatorProxy.php', 7 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/framework-bundle/CacheWarmer/TranslationsCacheWarmer.php', 8 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bridge/Extension/TranslationExtension.php', 9 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Search/Configuration/IndexConfigurationProvider.php', 10 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Teaser/PageTeaserProvider.php', 11 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Component/Content/Metadata/Parser/PropertiesXmlParser.php', 12 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Markup/Link/PageLinkProvider.php', 13 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Rule/PageRule.php', 14 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/EventListener/UserLocaleListener.php', 15 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/EventListener/TranslatorEventListener.php', 16 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/RouteBundle/Command/UpdateRouteCommand.php', 17 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Rule/LocaleRule.php', 18 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Rule/ReferrerRule.php', 19 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Rule/QueryStringRule.php', 20 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Rule/BrowserRule.php', 21 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Rule/OperatingSystemRule.php', 22 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Rule/DeviceTypeRule.php', 23 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Admin/SecurityAdmin.php', 24 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Admin/Navigation/NavigationRegistry.php', 25 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/jms/serializer/src/JMS/Serializer/Handler/FormErrorHandler.php', 26 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Metadata/DynamicListMetadataLoader.php', 27 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Metadata/DynamicFormMetadataLoader.php']);

$instance->setName('translation:update');

return $instance;
