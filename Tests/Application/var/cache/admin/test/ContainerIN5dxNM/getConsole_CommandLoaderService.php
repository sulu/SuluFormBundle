<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'console.command_loader' shared service.

return $this->services['console.command_loader'] = new \Symfony\Component\Console\CommandLoader\ContainerCommandLoader(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
    'console.command.about' => ['privates', 'console.command.about', 'getConsole_Command_AboutService.php', true],
    'console.command.assets_install' => ['privates', 'console.command.assets_install', 'getConsole_Command_AssetsInstallService.php', true],
    'console.command.cache_clear' => ['privates', 'console.command.cache_clear', 'getConsole_Command_CacheClearService.php', true],
    'console.command.cache_pool_clear' => ['privates', 'console.command.cache_pool_clear', 'getConsole_Command_CachePoolClearService.php', true],
    'console.command.cache_pool_delete' => ['privates', 'console.command.cache_pool_delete', 'getConsole_Command_CachePoolDeleteService.php', true],
    'console.command.cache_pool_list' => ['privates', 'console.command.cache_pool_list', 'getConsole_Command_CachePoolListService.php', true],
    'console.command.cache_pool_prune' => ['privates', 'console.command.cache_pool_prune', 'getConsole_Command_CachePoolPruneService.php', true],
    'console.command.cache_warmup' => ['privates', 'console.command.cache_warmup', 'getConsole_Command_CacheWarmupService.php', true],
    'console.command.config_debug' => ['privates', 'console.command.config_debug', 'getConsole_Command_ConfigDebugService.php', true],
    'console.command.config_dump_reference' => ['privates', 'console.command.config_dump_reference', 'getConsole_Command_ConfigDumpReferenceService.php', true],
    'console.command.container_debug' => ['privates', 'console.command.container_debug', 'getConsole_Command_ContainerDebugService.php', true],
    'console.command.debug_autowiring' => ['privates', 'console.command.debug_autowiring', 'getConsole_Command_DebugAutowiringService.php', true],
    'console.command.event_dispatcher_debug' => ['privates', 'console.command.event_dispatcher_debug', 'getConsole_Command_EventDispatcherDebugService.php', true],
    'console.command.form_debug' => ['privates', 'console.command.form_debug', 'getConsole_Command_FormDebugService.php', true],
    'console.command.router_debug' => ['privates', 'console.command.router_debug', 'getConsole_Command_RouterDebugService.php', true],
    'console.command.router_match' => ['privates', 'console.command.router_match', 'getConsole_Command_RouterMatchService.php', true],
    'console.command.translation_debug' => ['privates', 'console.command.translation_debug', 'getConsole_Command_TranslationDebugService.php', true],
    'console.command.translation_update' => ['privates', 'console.command.translation_update', 'getConsole_Command_TranslationUpdateService.php', true],
    'console.command.xliff_lint' => ['privates', 'console.command.xliff_lint', 'getConsole_Command_XliffLintService.php', true],
    'console.command.yaml_lint' => ['privates', 'console.command.yaml_lint', 'getConsole_Command_YamlLintService.php', true],
    'doctrine.cache_clear_metadata_command' => ['privates', 'doctrine.cache_clear_metadata_command', 'getDoctrine_CacheClearMetadataCommandService.php', true],
    'doctrine.cache_clear_query_cache_command' => ['privates', 'doctrine.cache_clear_query_cache_command', 'getDoctrine_CacheClearQueryCacheCommandService.php', true],
    'doctrine.cache_clear_result_command' => ['privates', 'doctrine.cache_clear_result_command', 'getDoctrine_CacheClearResultCommandService.php', true],
    'doctrine.cache_collection_region_command' => ['privates', 'doctrine.cache_collection_region_command', 'getDoctrine_CacheCollectionRegionCommandService.php', true],
    'doctrine.clear_entity_region_command' => ['privates', 'doctrine.clear_entity_region_command', 'getDoctrine_ClearEntityRegionCommandService.php', true],
    'doctrine.clear_query_region_command' => ['privates', 'doctrine.clear_query_region_command', 'getDoctrine_ClearQueryRegionCommandService.php', true],
    'doctrine.database_create_command' => ['privates', 'doctrine.database_create_command', 'getDoctrine_DatabaseCreateCommandService.php', true],
    'doctrine.database_drop_command' => ['privates', 'doctrine.database_drop_command', 'getDoctrine_DatabaseDropCommandService.php', true],
    'doctrine.database_import_command' => ['privates', 'doctrine.database_import_command', 'getDoctrine_DatabaseImportCommandService.php', true],
    'doctrine.ensure_production_settings_command' => ['privates', 'doctrine.ensure_production_settings_command', 'getDoctrine_EnsureProductionSettingsCommandService.php', true],
    'doctrine.generate_entities_command' => ['privates', 'doctrine.generate_entities_command', 'getDoctrine_GenerateEntitiesCommandService.php', true],
    'doctrine.mapping_convert_command' => ['privates', 'doctrine.mapping_convert_command', 'getDoctrine_MappingConvertCommandService.php', true],
    'doctrine.mapping_import_command' => ['privates', 'doctrine.mapping_import_command', 'getDoctrine_MappingImportCommandService.php', true],
    'doctrine.mapping_info_command' => ['privates', 'doctrine.mapping_info_command', 'getDoctrine_MappingInfoCommandService.php', true],
    'doctrine.query_dql_command' => ['privates', 'doctrine.query_dql_command', 'getDoctrine_QueryDqlCommandService.php', true],
    'doctrine.query_sql_command' => ['privates', 'doctrine.query_sql_command', 'getDoctrine_QuerySqlCommandService.php', true],
    'doctrine.schema_create_command' => ['privates', 'doctrine.schema_create_command', 'getDoctrine_SchemaCreateCommandService.php', true],
    'doctrine.schema_drop_command' => ['privates', 'doctrine.schema_drop_command', 'getDoctrine_SchemaDropCommandService.php', true],
    'doctrine.schema_update_command' => ['privates', 'doctrine.schema_update_command', 'getDoctrine_SchemaUpdateCommandService.php', true],
    'doctrine.schema_validate_command' => ['privates', 'doctrine.schema_validate_command', 'getDoctrine_SchemaValidateCommandService.php', true],
    'massive_search.command.index_rebuild_deprecated' => ['privates', 'massive_search.command.index_rebuild_deprecated', 'getMassiveSearch_Command_IndexRebuildDeprecatedService.php', true],
    'massive_search.command.init' => ['privates', 'massive_search.command.init', 'getMassiveSearch_Command_InitService.php', true],
    'massive_search.command.purge' => ['privates', 'massive_search.command.purge', 'getMassiveSearch_Command_PurgeService.php', true],
    'massive_search.command.query' => ['privates', 'massive_search.command.query', 'getMassiveSearch_Command_QueryService.php', true],
    'massive_search.command.reindex' => ['privates', 'massive_search.command.reindex', 'getMassiveSearch_Command_ReindexService.php', true],
    'massive_search.command.status' => ['privates', 'massive_search.command.status', 'getMassiveSearch_Command_StatusService.php', true],
    'security.command.user_password_encoder' => ['privates', 'security.command.user_password_encoder', 'getSecurity_Command_UserPasswordEncoderService.php', true],
    'sulu_category.command.recover' => ['privates', 'sulu_category.command.recover', 'getSuluCategory_Command_RecoverService.php', true],
    'sulu_contact.command.recover' => ['privates', 'sulu_contact.command.recover', 'getSuluContact_Command_RecoverService.php', true],
    'sulu_document_manager.command.fixtures_load' => ['privates', 'sulu_document_manager.command.fixtures_load', 'getSuluDocumentManager_Command_FixturesLoadService.php', true],
    'sulu_document_manager.command.initialize' => ['privates', 'sulu_document_manager.command.initialize', 'getSuluDocumentManager_Command_InitializeService.php', true],
    'sulu_document_manager.command.subscriber_debug' => ['privates', 'sulu_document_manager.command.subscriber_debug', 'getSuluDocumentManager_Command_SubscriberDebugService.php', true],
    'sulu_media.command.clear_cache' => ['privates', 'sulu_media.command.clear_cache', 'getSuluMedia_Command_ClearCacheService.php', true],
    'sulu_media.command.format_cache.cleanup' => ['privates', 'sulu_media.command.format_cache.cleanup', 'getSuluMedia_Command_FormatCache_CleanupService.php', true],
    'sulu_media.command.init' => ['privates', 'sulu_media.command.init', 'getSuluMedia_Command_InitService.php', true],
    'sulu_media.command.type_update' => ['privates', 'sulu_media.command.type_update', 'getSuluMedia_Command_TypeUpdateService.php', true],
    'sulu_page.command.cleanup_history' => ['privates', 'sulu_page.command.cleanup_history', 'getSuluPage_Command_CleanupHistoryService.php', true],
    'sulu_page.command.copy_locale' => ['privates', 'sulu_page.command.copy_locale', 'getSuluPage_Command_CopyLocaleService.php', true],
    'sulu_page.command.dump_content_types' => ['privates', 'sulu_page.command.dump_content_types', 'getSuluPage_Command_DumpContentTypesService.php', true],
    'sulu_page.command.maintain_resource_locator' => ['privates', 'sulu_page.command.maintain_resource_locator', 'getSuluPage_Command_MaintainResourceLocatorService.php', true],
    'sulu_page.command.validate_pages' => ['privates', 'sulu_page.command.validate_pages', 'getSuluPage_Command_ValidatePagesService.php', true],
    'sulu_page.command.validate_webspaces' => ['privates', 'sulu_page.command.validate_webspaces', 'getSuluPage_Command_ValidateWebspacesService.php', true],
    'sulu_page.command.webspace_copy' => ['privates', 'sulu_page.command.webspace_copy', 'getSuluPage_Command_WebspaceCopyService.php', true],
    'sulu_page.command.webspace_export' => ['privates', 'sulu_page.command.webspace_export', 'getSuluPage_Command_WebspaceExportService.php', true],
    'sulu_page.command.webspace_import' => ['privates', 'sulu_page.command.webspace_import', 'getSuluPage_Command_WebspaceImportService.php', true],
    'sulu_route.command.update_route' => ['privates', 'sulu_route.command.update_route', 'getSuluRoute_Command_UpdateRouteService.php', true],
    'sulu_security.command.create_role' => ['privates', 'sulu_security.command.create_role', 'getSuluSecurity_Command_CreateRoleService.php', true],
    'sulu_security.command.create_user' => ['privates', 'sulu_security.command.create_user', 'getSuluSecurity_Command_CreateUserService.php', true],
    'sulu_snippet.command.export' => ['privates', 'sulu_snippet.command.export', 'getSuluSnippet_Command_ExportService.php', true],
    'sulu_snippet.command.import' => ['privates', 'sulu_snippet.command.import', 'getSuluSnippet_Command_ImportService.php', true],
    'sulu_snippet.command.locale_copy' => ['privates', 'sulu_snippet.command.locale_copy', 'getSuluSnippet_Command_LocaleCopyService.php', true],
    'sulu_website.command.dump_sitemap' => ['privates', 'sulu_website.command.dump_sitemap', 'getSuluWebsite_Command_DumpSitemapService.php', true],
    'swiftmailer.command.debug' => ['privates', 'swiftmailer.command.debug', 'getSwiftmailer_Command_DebugService.php', true],
    'swiftmailer.command.new_email' => ['privates', 'swiftmailer.command.new_email', 'getSwiftmailer_Command_NewEmailService.php', true],
    'swiftmailer.command.send_email' => ['privates', 'swiftmailer.command.send_email', 'getSwiftmailer_Command_SendEmailService.php', true],
    'twig.command.debug' => ['privates', 'twig.command.debug', 'getTwig_Command_DebugService.php', true],
    'twig.command.lint' => ['privates', 'twig.command.lint', 'getTwig_Command_LintService.php', true],
], [
    'console.command.about' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\AboutCommand',
    'console.command.assets_install' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\AssetsInstallCommand',
    'console.command.cache_clear' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\CacheClearCommand',
    'console.command.cache_pool_clear' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\CachePoolClearCommand',
    'console.command.cache_pool_delete' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\CachePoolDeleteCommand',
    'console.command.cache_pool_list' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\CachePoolListCommand',
    'console.command.cache_pool_prune' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\CachePoolPruneCommand',
    'console.command.cache_warmup' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\CacheWarmupCommand',
    'console.command.config_debug' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\ConfigDebugCommand',
    'console.command.config_dump_reference' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\ConfigDumpReferenceCommand',
    'console.command.container_debug' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\ContainerDebugCommand',
    'console.command.debug_autowiring' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\DebugAutowiringCommand',
    'console.command.event_dispatcher_debug' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\EventDispatcherDebugCommand',
    'console.command.form_debug' => 'Symfony\\Component\\Form\\Command\\DebugCommand',
    'console.command.router_debug' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\RouterDebugCommand',
    'console.command.router_match' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\RouterMatchCommand',
    'console.command.translation_debug' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\TranslationDebugCommand',
    'console.command.translation_update' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\TranslationUpdateCommand',
    'console.command.xliff_lint' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\XliffLintCommand',
    'console.command.yaml_lint' => 'Symfony\\Bundle\\FrameworkBundle\\Command\\YamlLintCommand',
    'doctrine.cache_clear_metadata_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\ClearMetadataCacheDoctrineCommand',
    'doctrine.cache_clear_query_cache_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\ClearQueryCacheDoctrineCommand',
    'doctrine.cache_clear_result_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\ClearResultCacheDoctrineCommand',
    'doctrine.cache_collection_region_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\CollectionRegionDoctrineCommand',
    'doctrine.clear_entity_region_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\EntityRegionCacheDoctrineCommand',
    'doctrine.clear_query_region_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\QueryRegionCacheDoctrineCommand',
    'doctrine.database_create_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\CreateDatabaseDoctrineCommand',
    'doctrine.database_drop_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\DropDatabaseDoctrineCommand',
    'doctrine.database_import_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\ImportDoctrineCommand',
    'doctrine.ensure_production_settings_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\EnsureProductionSettingsDoctrineCommand',
    'doctrine.generate_entities_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\GenerateEntitiesDoctrineCommand',
    'doctrine.mapping_convert_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\ConvertMappingDoctrineCommand',
    'doctrine.mapping_import_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\ImportMappingDoctrineCommand',
    'doctrine.mapping_info_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\InfoDoctrineCommand',
    'doctrine.query_dql_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\RunDqlDoctrineCommand',
    'doctrine.query_sql_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\RunSqlDoctrineCommand',
    'doctrine.schema_create_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\CreateSchemaDoctrineCommand',
    'doctrine.schema_drop_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\DropSchemaDoctrineCommand',
    'doctrine.schema_update_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\UpdateSchemaDoctrineCommand',
    'doctrine.schema_validate_command' => 'Doctrine\\Bundle\\DoctrineBundle\\Command\\Proxy\\ValidateSchemaCommand',
    'massive_search.command.index_rebuild_deprecated' => 'Massive\\Bundle\\SearchBundle\\Command\\IndexRebuildCommand',
    'massive_search.command.init' => 'Massive\\Bundle\\SearchBundle\\Command\\InitCommand',
    'massive_search.command.purge' => 'Massive\\Bundle\\SearchBundle\\Command\\PurgeCommand',
    'massive_search.command.query' => 'Massive\\Bundle\\SearchBundle\\Command\\QueryCommand',
    'massive_search.command.reindex' => 'Massive\\Bundle\\SearchBundle\\Command\\ReindexCommand',
    'massive_search.command.status' => 'Massive\\Bundle\\SearchBundle\\Command\\StatusCommand',
    'security.command.user_password_encoder' => 'Symfony\\Bundle\\SecurityBundle\\Command\\UserPasswordEncoderCommand',
    'sulu_category.command.recover' => 'Sulu\\Bundle\\CategoryBundle\\Command\\RecoverCommand',
    'sulu_contact.command.recover' => 'Sulu\\Bundle\\ContactBundle\\Command\\AccountRecoverCommand',
    'sulu_document_manager.command.fixtures_load' => 'Sulu\\Bundle\\DocumentManagerBundle\\Command\\FixturesLoadCommand',
    'sulu_document_manager.command.initialize' => 'Sulu\\Bundle\\DocumentManagerBundle\\Command\\InitializeCommand',
    'sulu_document_manager.command.subscriber_debug' => 'Sulu\\Bundle\\DocumentManagerBundle\\Command\\SubscriberDebugCommand',
    'sulu_media.command.clear_cache' => 'Sulu\\Bundle\\MediaBundle\\Command\\ClearCacheCommand',
    'sulu_media.command.format_cache.cleanup' => 'Sulu\\Bundle\\MediaBundle\\Command\\FormatCacheCleanupCommand',
    'sulu_media.command.init' => 'Sulu\\Bundle\\MediaBundle\\Command\\InitCommand',
    'sulu_media.command.type_update' => 'Sulu\\Bundle\\MediaBundle\\Command\\MediaTypeUpdateCommand',
    'sulu_page.command.cleanup_history' => 'Sulu\\Bundle\\PageBundle\\Command\\CleanupHistoryCommand',
    'sulu_page.command.copy_locale' => 'Sulu\\Bundle\\PageBundle\\Command\\ContentLocaleCopyCommand',
    'sulu_page.command.dump_content_types' => 'Sulu\\Bundle\\PageBundle\\Command\\ContentTypesDumpCommand',
    'sulu_page.command.maintain_resource_locator' => 'Sulu\\Bundle\\PageBundle\\Command\\MaintainResourceLocatorCommand',
    'sulu_page.command.validate_pages' => 'Sulu\\Bundle\\PageBundle\\Command\\ValidatePagesCommand',
    'sulu_page.command.validate_webspaces' => 'Sulu\\Bundle\\PageBundle\\Command\\ValidateWebspacesCommand',
    'sulu_page.command.webspace_copy' => 'Sulu\\Bundle\\PageBundle\\Command\\WebspaceCopyCommand',
    'sulu_page.command.webspace_export' => 'Sulu\\Bundle\\PageBundle\\Command\\WebspaceExportCommand',
    'sulu_page.command.webspace_import' => 'Sulu\\Bundle\\PageBundle\\Command\\WebspaceImportCommand',
    'sulu_route.command.update_route' => 'Sulu\\Bundle\\RouteBundle\\Command\\UpdateRouteCommand',
    'sulu_security.command.create_role' => 'Sulu\\Bundle\\SecurityBundle\\Command\\CreateRoleCommand',
    'sulu_security.command.create_user' => 'Sulu\\Bundle\\SecurityBundle\\Command\\CreateUserCommand',
    'sulu_snippet.command.export' => 'Sulu\\Bundle\\SnippetBundle\\Command\\SnippetExportCommand',
    'sulu_snippet.command.import' => 'Sulu\\Bundle\\SnippetBundle\\Command\\SnippetImportCommand',
    'sulu_snippet.command.locale_copy' => 'Sulu\\Bundle\\SnippetBundle\\Command\\SnippetLocaleCopyCommand',
    'sulu_website.command.dump_sitemap' => 'Sulu\\Bundle\\WebsiteBundle\\Command\\DumpSitemapCommand',
    'swiftmailer.command.debug' => 'Symfony\\Bundle\\SwiftmailerBundle\\Command\\DebugCommand',
    'swiftmailer.command.new_email' => 'Symfony\\Bundle\\SwiftmailerBundle\\Command\\NewEmailCommand',
    'swiftmailer.command.send_email' => 'Symfony\\Bundle\\SwiftmailerBundle\\Command\\SendEmailCommand',
    'twig.command.debug' => 'Symfony\\Bridge\\Twig\\Command\\DebugCommand',
    'twig.command.lint' => 'Symfony\\Bundle\\TwigBundle\\Command\\LintCommand',
]), ['debug:swiftmailer' => 'swiftmailer.command.debug', 'swiftmailer:email:send' => 'swiftmailer.command.new_email', 'swiftmailer:spool:send' => 'swiftmailer.command.send_email', 'about' => 'console.command.about', 'assets:install' => 'console.command.assets_install', 'cache:clear' => 'console.command.cache_clear', 'cache:pool:clear' => 'console.command.cache_pool_clear', 'cache:pool:prune' => 'console.command.cache_pool_prune', 'cache:pool:delete' => 'console.command.cache_pool_delete', 'cache:pool:list' => 'console.command.cache_pool_list', 'cache:warmup' => 'console.command.cache_warmup', 'debug:config' => 'console.command.config_debug', 'config:dump-reference' => 'console.command.config_dump_reference', 'debug:container' => 'console.command.container_debug', 'debug:autowiring' => 'console.command.debug_autowiring', 'debug:event-dispatcher' => 'console.command.event_dispatcher_debug', 'debug:router' => 'console.command.router_debug', 'router:match' => 'console.command.router_match', 'debug:translation' => 'console.command.translation_debug', 'translation:update' => 'console.command.translation_update', 'lint:xliff' => 'console.command.xliff_lint', 'lint:yaml' => 'console.command.yaml_lint', 'debug:form' => 'console.command.form_debug', 'debug:twig' => 'twig.command.debug', 'lint:twig' => 'twig.command.lint', 'doctrine:database:create' => 'doctrine.database_create_command', 'doctrine:database:drop' => 'doctrine.database_drop_command', 'doctrine:generate:entities' => 'doctrine.generate_entities_command', 'doctrine:query:sql' => 'doctrine.query_sql_command', 'doctrine:cache:clear-metadata' => 'doctrine.cache_clear_metadata_command', 'doctrine:cache:clear-query' => 'doctrine.cache_clear_query_cache_command', 'doctrine:cache:clear-result' => 'doctrine.cache_clear_result_command', 'doctrine:cache:clear-collection-region' => 'doctrine.cache_collection_region_command', 'doctrine:mapping:convert' => 'doctrine.mapping_convert_command', 'doctrine:schema:create' => 'doctrine.schema_create_command', 'doctrine:schema:drop' => 'doctrine.schema_drop_command', 'doctrine:ensure-production-settings' => 'doctrine.ensure_production_settings_command', 'doctrine:cache:clear-entity-region' => 'doctrine.clear_entity_region_command', 'doctrine:database:import' => 'doctrine.database_import_command', 'doctrine:mapping:info' => 'doctrine.mapping_info_command', 'doctrine:cache:clear-query-region' => 'doctrine.clear_query_region_command', 'doctrine:query:dql' => 'doctrine.query_dql_command', 'doctrine:schema:update' => 'doctrine.schema_update_command', 'doctrine:schema:validate' => 'doctrine.schema_validate_command', 'doctrine:mapping:import' => 'doctrine.mapping_import_command', 'massive:search:init' => 'massive_search.command.init', 'massive:search:status' => 'massive_search.command.status', 'massive:search:query' => 'massive_search.command.query', 'massive:search:reindex' => 'massive_search.command.reindex', 'massive:search:index:rebuild' => 'massive_search.command.index_rebuild_deprecated', 'massive:search:purge' => 'massive_search.command.purge', 'sulu:content:resource-locator:maintain' => 'sulu_page.command.maintain_resource_locator', 'sulu:content:cleanup-history' => 'sulu_page.command.cleanup_history', 'sulu:content:locale-copy' => 'sulu_page.command.copy_locale', 'sulu:content:types:dump' => 'sulu_page.command.dump_content_types', 'sulu:content:validate' => 'sulu_page.command.validate_pages', 'sulu:content:validate:webspaces' => 'sulu_page.command.validate_webspaces', 'sulu:webspaces:copy' => 'sulu_page.command.webspace_copy', 'sulu:webspaces:export' => 'sulu_page.command.webspace_export', 'sulu:webspaces:import' => 'sulu_page.command.webspace_import', 'sulu:contacts:accounts:recover' => 'sulu_contact.command.recover', 'sulu:security:role:create' => 'sulu_security.command.create_role', 'sulu:security:user:create' => 'sulu_security.command.create_user', 'sulu:website:dump-sitemap' => 'sulu_website.command.dump_sitemap', 'sulu:media:format:cache:cleanup' => 'sulu_media.command.format_cache.cleanup', 'sulu:media:init' => 'sulu_media.command.init', 'sulu:media:format:cache:clear' => 'sulu_media.command.clear_cache', 'sulu:media:type:update' => 'sulu_media.command.type_update', 'sulu:categories:recover' => 'sulu_category.command.recover', 'sulu:snippet:export' => 'sulu_snippet.command.export', 'sulu:snippet:import' => 'sulu_snippet.command.import', 'sulu:snippet:locale-copy' => 'sulu_snippet.command.locale_copy', 'sulu:document:fixtures:load' => 'sulu_document_manager.command.fixtures_load', 'sulu:document:initialize' => 'sulu_document_manager.command.initialize', 'sulu:document:subscriber:debug' => 'sulu_document_manager.command.subscriber_debug', 'sulu:route:update' => 'sulu_route.command.update_route', 'security:encode-password' => 'security.command.user_password_encoder']);
