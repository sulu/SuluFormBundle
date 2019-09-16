<?php

namespace ContainerIN5dxNM;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class adminAdminTestDebugProjectContainer extends Container
{
    private $buildParameters;
    private $containerDir;
    private $parameters = [];
    private $targetDirs = [];
    private $getService;

    public function __construct(array $buildParameters = [], $containerDir = __DIR__)
    {
        $this->getService = \Closure::fromCallable([$this, 'getService']);
        $dir = $this->targetDirs[0] = \dirname($containerDir);
        for ($i = 1; $i <= 5; ++$i) {
            $this->targetDirs[$i] = $dir = \dirname($dir);
        }
        $this->buildParameters = $buildParameters;
        $this->containerDir = $containerDir;
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = [];
        $this->syntheticIds = [
            'kernel' => true,
        ];
        $this->methodMap = [
            'cache.app' => 'getCache_AppService',
            'cache.system' => 'getCache_SystemService',
            'doctrine' => 'getDoctrineService',
            'doctrine.dbal.default_connection' => 'getDoctrine_Dbal_DefaultConnectionService',
            'doctrine.orm.default_entity_manager' => 'getDoctrine_Orm_DefaultEntityManagerService',
            'doctrine_cache.providers.doctrine.orm.default_metadata_cache' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultMetadataCacheService',
            'doctrine_cache.providers.doctrine.orm.default_query_cache' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultQueryCacheService',
            'doctrine_cache.providers.doctrine.orm.default_result_cache' => 'getDoctrineCache_Providers_Doctrine_Orm_DefaultResultCacheService',
            'doctrine_phpcr' => 'getDoctrinePhpcrService',
            'event_dispatcher' => 'getEventDispatcherService',
            'filesystem' => 'getFilesystemService',
            'form.factory' => 'getForm_FactoryService',
            'hateoas.generator.registry' => 'getHateoas_Generator_RegistryService',
            'hateoas.helper.link' => 'getHateoas_Helper_LinkService',
            'http_kernel' => 'getHttpKernelService',
            'jms_serializer' => 'getJmsSerializerService',
            'jms_serializer.deserialization_context_factory' => 'getJmsSerializer_DeserializationContextFactoryService',
            'jms_serializer.json_deserialization_visitor' => 'getJmsSerializer_JsonDeserializationVisitorService',
            'jms_serializer.json_serialization_visitor' => 'getJmsSerializer_JsonSerializationVisitorService',
            'jms_serializer.serialization_context_factory' => 'getJmsSerializer_SerializationContextFactoryService',
            'jms_serializer.xml_deserialization_visitor' => 'getJmsSerializer_XmlDeserializationVisitorService',
            'jms_serializer.xml_serialization_visitor' => 'getJmsSerializer_XmlSerializationVisitorService',
            'jms_serializer.yaml_serialization_visitor' => 'getJmsSerializer_YamlSerializationVisitorService',
            'profiler' => 'getProfilerService',
            'request_stack' => 'getRequestStackService',
            'router' => 'getRouterService',
            'security.authorization_checker' => 'getSecurity_AuthorizationCheckerService',
            'security.token_storage' => 'getSecurity_TokenStorageService',
            'sulu.content.localization_finder' => 'getSulu_Content_LocalizationFinderService',
            'sulu.content.mapper' => 'getSulu_Content_MapperService',
            'sulu.content.path_cleaner' => 'getSulu_Content_PathCleanerService',
            'sulu.content.structure_manager' => 'getSulu_Content_StructureManagerService',
            'sulu.content.type_manager' => 'getSulu_Content_TypeManagerService',
            'sulu.phpcr.session' => 'getSulu_Phpcr_SessionService',
            'sulu.repository.category' => 'getSulu_Repository_CategoryService',
            'sulu.repository.category_meta' => 'getSulu_Repository_CategoryMetaService',
            'sulu.repository.category_translation' => 'getSulu_Repository_CategoryTranslationService',
            'sulu.repository.contact' => 'getSulu_Repository_ContactService',
            'sulu.repository.keyword' => 'getSulu_Repository_KeywordService',
            'sulu.repository.media' => 'getSulu_Repository_MediaService',
            'sulu.repository.tag' => 'getSulu_Repository_TagService',
            'sulu.repository.target_group' => 'getSulu_Repository_TargetGroupService',
            'sulu.repository.user' => 'getSulu_Repository_UserService',
            'sulu.util.node_helper' => 'getSulu_Util_NodeHelperService',
            'sulu_category.category_manager' => 'getSuluCategory_CategoryManagerService',
            'sulu_category.keyword_manager' => 'getSuluCategory_KeywordManagerService',
            'sulu_core.webspace.request_analyzer' => 'getSuluCore_Webspace_RequestAnalyzerService',
            'sulu_core.webspace.webspace_manager' => 'getSuluCore_Webspace_WebspaceManagerService',
            'sulu_document_manager.document_inspector' => 'getSuluDocumentManager_DocumentInspectorService',
            'sulu_document_manager.document_manager' => 'getSuluDocumentManager_DocumentManagerService',
            'sulu_document_manager.metadata_factory.base' => 'getSuluDocumentManager_MetadataFactory_BaseService',
            'sulu_document_manager.property_encoder' => 'getSuluDocumentManager_PropertyEncoderService',
            'sulu_markup.parser.html_extractor' => 'getSuluMarkup_Parser_HtmlExtractorService',
            'sulu_media.collection_manager' => 'getSuluMedia_CollectionManagerService',
            'sulu_media.collection_repository' => 'getSuluMedia_CollectionRepositoryService',
            'sulu_media.format_manager' => 'getSuluMedia_FormatManagerService',
            'sulu_media.image.transformation.blur' => 'getSuluMedia_Image_Transformation_BlurService',
            'sulu_media.image.transformation.crop' => 'getSuluMedia_Image_Transformation_CropService',
            'sulu_media.image.transformation.gamma' => 'getSuluMedia_Image_Transformation_GammaService',
            'sulu_media.image.transformation.grayscale' => 'getSuluMedia_Image_Transformation_GrayscaleService',
            'sulu_media.image.transformation.negative' => 'getSuluMedia_Image_Transformation_NegativeService',
            'sulu_media.image.transformation.paste' => 'getSuluMedia_Image_Transformation_PasteService',
            'sulu_media.image.transformation.sharpen' => 'getSuluMedia_Image_Transformation_SharpenService',
            'sulu_media.media_manager' => 'getSuluMedia_MediaManagerService',
            'sulu_media.storage' => 'getSuluMedia_StorageService',
            'sulu_media.system_collections.manager' => 'getSuluMedia_SystemCollections_ManagerService',
            'sulu_page.compat.structure.legacy_property_factory' => 'getSuluPage_Compat_Structure_LegacyPropertyFactoryService',
            'sulu_page.content_repository' => 'getSuluPage_ContentRepositoryService',
            'sulu_page.controller_name_converter' => 'getSuluPage_ControllerNameConverterService',
            'sulu_page.extension.manager' => 'getSuluPage_Extension_ManagerService',
            'sulu_page.structure.factory' => 'getSuluPage_Structure_FactoryService',
            'sulu_security.security_checker' => 'getSuluSecurity_SecurityCheckerService',
            'sulu_snippet.default_snippet.manager' => 'getSuluSnippet_DefaultSnippet_ManagerService',
            'sulu_snippet.resolver' => 'getSuluSnippet_ResolverService',
            'sulu_tag.tag_manager' => 'getSuluTag_TagManagerService',
            'sulu_test.doctrine_phpcr.default_session' => 'getSuluTest_DoctrinePhpcr_DefaultSessionService',
            'sulu_test.doctrine_phpcr.live_session' => 'getSuluTest_DoctrinePhpcr_LiveSessionService',
            'sulu_website.resolver.structure' => 'getSuluWebsite_Resolver_StructureService',
            'translator' => 'getTranslatorService',
            'twig' => 'getTwigService',
            'validator' => 'getValidatorService',
        ];
        $this->fileMap = [
            'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController' => 'getRedirectControllerService.php',
            'Symfony\\Bundle\\FrameworkBundle\\Controller\\TemplateController' => 'getTemplateControllerService.php',
            'cache.app_clearer' => 'getCache_AppClearerService.php',
            'cache.global_clearer' => 'getCache_GlobalClearerService.php',
            'cache.system_clearer' => 'getCache_SystemClearerService.php',
            'cache_clearer' => 'getCacheClearerService.php',
            'cache_warmer' => 'getCacheWarmerService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\LoadFixtureCommand' => 'getLoadFixtureCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\MigratorMigrateCommand' => 'getMigratorMigrateCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeDumpCommand' => 'getNodeDumpCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeMoveCommand' => 'getNodeMoveCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeRemoveCommand' => 'getNodeRemoveCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeTouchCommand' => 'getNodeTouchCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeTypeListCommand' => 'getNodeTypeListCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeTypeRegisterCommand' => 'getNodeTypeRegisterCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodesUpdateCommand' => 'getNodesUpdateCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\PhpcrShellCommand' => 'getPhpcrShellCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\RepositoryInitCommand' => 'getRepositoryInitCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceCreateCommand' => 'getWorkspaceCreateCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceDeleteCommand' => 'getWorkspaceDeleteCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceExportCommand' => 'getWorkspaceExportCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceImportCommand' => 'getWorkspaceImportCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceListCommand' => 'getWorkspaceListCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspacePurgeCommand' => 'getWorkspacePurgeCommandService.php',
            'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceQueryCommand' => 'getWorkspaceQueryCommandService.php',
            'console.command.public_alias.doctrine_cache.contains_command' => 'getConsole_Command_PublicAlias_DoctrineCache_ContainsCommandService.php',
            'console.command.public_alias.doctrine_cache.delete_command' => 'getConsole_Command_PublicAlias_DoctrineCache_DeleteCommandService.php',
            'console.command.public_alias.doctrine_cache.flush_command' => 'getConsole_Command_PublicAlias_DoctrineCache_FlushCommandService.php',
            'console.command.public_alias.doctrine_cache.stats_command' => 'getConsole_Command_PublicAlias_DoctrineCache_StatsCommandService.php',
            'console.command.public_alias.sulu_page.command.workspace_import' => 'getConsole_Command_PublicAlias_SuluPage_Command_WorkspaceImportService.php',
            'console.command_loader' => 'getConsole_CommandLoaderService.php',
            'doctrine_cache.providers.sulu_collaboration_connection' => 'getDoctrineCache_Providers_SuluCollaborationConnectionService.php',
            'doctrine_cache.providers.sulu_collaboration_entity' => 'getDoctrineCache_Providers_SuluCollaborationEntityService.php',
            'doctrine_cache.providers.sulu_preview' => 'getDoctrineCache_Providers_SuluPreviewService.php',
            'doctrine_phpcr.admin.default_session' => 'getDoctrinePhpcr_Admin_DefaultSessionService.php',
            'doctrine_phpcr.admin.live_session' => 'getDoctrinePhpcr_Admin_LiveSessionService.php',
            'doctrine_phpcr.initializer_manager' => 'getDoctrinePhpcr_InitializerManagerService.php',
            'form.type.file' => 'getForm_Type_FileService.php',
            'fos_rest.exception.controller' => 'getFosRest_Exception_ControllerService.php',
            'fos_rest.exception.twig_controller' => 'getFosRest_Exception_TwigControllerService.php',
            'fos_rest.serializer.jms_handler_registry' => 'getFosRest_Serializer_JmsHandlerRegistryService.php',
            'fos_rest.view_handler' => 'getFosRest_ViewHandlerService.php',
            'hateoas.event_subscriber.json' => 'getHateoas_EventSubscriber_JsonService.php',
            'hateoas.event_subscriber.xml' => 'getHateoas_EventSubscriber_XmlService.php',
            'hateoas.expression.link' => 'getHateoas_Expression_LinkService.php',
            'jms_serializer.array_collection_handler' => 'getJmsSerializer_ArrayCollectionHandlerService.php',
            'jms_serializer.constraint_violation_handler' => 'getJmsSerializer_ConstraintViolationHandlerService.php',
            'jms_serializer.datetime_handler' => 'getJmsSerializer_DatetimeHandlerService.php',
            'jms_serializer.doctrine_proxy_subscriber' => 'getJmsSerializer_DoctrineProxySubscriberService.php',
            'jms_serializer.form_error_handler' => 'getJmsSerializer_FormErrorHandlerService.php',
            'jms_serializer.handler_registry' => 'getJmsSerializer_HandlerRegistryService.php',
            'jms_serializer.metadata_driver' => 'getJmsSerializer_MetadataDriverService.php',
            'jms_serializer.object_constructor' => 'getJmsSerializer_ObjectConstructorService.php',
            'jms_serializer.php_collection_handler' => 'getJmsSerializer_PhpCollectionHandlerService.php',
            'jms_serializer.stopwatch_subscriber' => 'getJmsSerializer_StopwatchSubscriberService.php',
            'jms_serializer.twig_extension.serializer_runtime_helper' => 'getJmsSerializer_TwigExtension_SerializerRuntimeHelperService.php',
            'massive_search.adapter.zend_lucene' => 'getMassiveSearch_Adapter_ZendLuceneService.php',
            'massive_search.search_manager' => 'getMassiveSearch_SearchManagerService.php',
            'phpcr_migrations.command.initialize' => 'getPhpcrMigrations_Command_InitializeService.php',
            'phpcr_migrations.command.migrate' => 'getPhpcrMigrations_Command_MigrateService.php',
            'phpcr_migrations.command.status' => 'getPhpcrMigrations_Command_StatusService.php',
            'routing.loader' => 'getRouting_LoaderService.php',
            'security.authentication_utils' => 'getSecurity_AuthenticationUtilsService.php',
            'security.csrf.token_manager' => 'getSecurity_Csrf_TokenManagerService.php',
            'security.password_encoder' => 'getSecurity_PasswordEncoderService.php',
            'serializer' => 'getSerializerService.php',
            'services_resetter' => 'getServicesResetterService.php',
            'session' => 'getSessionService.php',
            'sulu.content.type.block' => 'getSulu_Content_Type_BlockService.php',
            'sulu.content.type.checkbox' => 'getSulu_Content_Type_CheckboxService.php',
            'sulu.content.type.color' => 'getSulu_Content_Type_ColorService.php',
            'sulu.content.type.date' => 'getSulu_Content_Type_DateService.php',
            'sulu.content.type.email' => 'getSulu_Content_Type_EmailService.php',
            'sulu.content.type.number' => 'getSulu_Content_Type_NumberService.php',
            'sulu.content.type.page_selection' => 'getSulu_Content_Type_PageSelectionService.php',
            'sulu.content.type.password' => 'getSulu_Content_Type_PasswordService.php',
            'sulu.content.type.phone' => 'getSulu_Content_Type_PhoneService.php',
            'sulu.content.type.resource_locator' => 'getSulu_Content_Type_ResourceLocatorService.php',
            'sulu.content.type.select' => 'getSulu_Content_Type_SelectService.php',
            'sulu.content.type.single_page_selection' => 'getSulu_Content_Type_SinglePageSelectionService.php',
            'sulu.content.type.single_select' => 'getSulu_Content_Type_SingleSelectService.php',
            'sulu.content.type.text_area' => 'getSulu_Content_Type_TextAreaService.php',
            'sulu.content.type.text_editor' => 'getSulu_Content_Type_TextEditorService.php',
            'sulu.content.type.text_line' => 'getSulu_Content_Type_TextLineService.php',
            'sulu.content.type.time' => 'getSulu_Content_Type_TimeService.php',
            'sulu.content.type.url' => 'getSulu_Content_Type_UrlService.php',
            'sulu.content.webspace_structure_provider' => 'getSulu_Content_WebspaceStructureProviderService.php',
            'sulu.core.localization_manager' => 'getSulu_Core_LocalizationManagerService.php',
            'sulu.repository.access_control' => 'getSulu_Repository_AccessControlService.php',
            'sulu.repository.account' => 'getSulu_Repository_AccountService.php',
            'sulu.repository.role' => 'getSulu_Repository_RoleService.php',
            'sulu.repository.role_setting' => 'getSulu_Repository_RoleSettingService.php',
            'sulu.repository.route' => 'getSulu_Repository_RouteService.php',
            'sulu.repository.target_group_condition' => 'getSulu_Repository_TargetGroupConditionService.php',
            'sulu.repository.target_group_rule' => 'getSulu_Repository_TargetGroupRuleService.php',
            'sulu.repository.target_group_webspace' => 'getSulu_Repository_TargetGroupWebspaceService.php',
            'sulu_admin.admin_controller' => 'getSuluAdmin_AdminControllerService.php',
            'sulu_admin.admin_pool' => 'getSuluAdmin_AdminPoolService.php',
            'sulu_audience_targeting.content.type.target_group_selection' => 'getSuluAudienceTargeting_Content_Type_TargetGroupSelectionService.php',
            'sulu_audience_targeting.target_group_evaluation_controller' => 'getSuluAudienceTargeting_TargetGroupEvaluationControllerService.php',
            'sulu_audience_targeting.target_group_store' => 'getSuluAudienceTargeting_TargetGroupStoreService.php',
            'sulu_audience_targeting.webspace_select_helper' => 'getSuluAudienceTargeting_WebspaceSelectHelperService.php',
            'sulu_category.content.type.category_selection' => 'getSuluCategory_Content_Type_CategorySelectionService.php',
            'sulu_contact.account_factory' => 'getSuluContact_AccountFactoryService.php',
            'sulu_contact.account_manager' => 'getSuluContact_AccountManagerService.php',
            'sulu_contact.contact_manager' => 'getSuluContact_ContactManagerService.php',
            'sulu_contact.content.contact_account_selection' => 'getSuluContact_Content_ContactAccountSelectionService.php',
            'sulu_contact.content.single_account_selection' => 'getSuluContact_Content_SingleAccountSelectionService.php',
            'sulu_contact.content.single_contact_selection' => 'getSuluContact_Content_SingleContactSelectionService.php',
            'sulu_contact.customer_manager' => 'getSuluContact_CustomerManagerService.php',
            'sulu_contact.util.index_comparator' => 'getSuluContact_Util_IndexComparatorService.php',
            'sulu_core.doctrine_list_builder_factory' => 'getSuluCore_DoctrineListBuilderFactoryService.php',
            'sulu_core.doctrine_rest_helper' => 'getSuluCore_DoctrineRestHelperService.php',
            'sulu_core.list_builder.field_descriptor_factory' => 'getSuluCore_ListBuilder_FieldDescriptorFactoryService.php',
            'sulu_core.list_rest_helper' => 'getSuluCore_ListRestHelperService.php',
            'sulu_core.webspace.document_manager.webspace_initializer' => 'getSuluCore_Webspace_DocumentManager_WebspaceInitializerService.php',
            'sulu_custom_urls.initializer' => 'getSuluCustomUrls_InitializerService.php',
            'sulu_custom_urls.manager' => 'getSuluCustomUrls_ManagerService.php',
            'sulu_document_manager.initializer' => 'getSuluDocumentManager_InitializerService.php',
            'sulu_document_manager.initializer.root_path_purge_initializer' => 'getSuluDocumentManager_Initializer_RootPathPurgeInitializerService.php',
            'sulu_document_manager.initializer.workspace' => 'getSuluDocumentManager_Initializer_WorkspaceService.php',
            'sulu_document_manager.serializer.subscriber.proxy' => 'getSuluDocumentManager_Serializer_Subscriber_ProxyService.php',
            'sulu_form.content_type.single_form_selection' => 'getSuluForm_ContentType_SingleFormSelectionService.php',
            'sulu_form.dynamic_controller' => 'getSuluForm_DynamicControllerService.php',
            'sulu_form.manager.form' => 'getSuluForm_Manager_FormService.php',
            'sulu_form_test.dynamic_form_metadata_loader' => 'getSuluFormTest_DynamicFormMetadataLoaderService.php',
            'sulu_form_test.dynamic_list_metadata_loader' => 'getSuluFormTest_DynamicListMetadataLoaderService.php',
            'sulu_hash.request_hash_checker' => 'getSuluHash_RequestHashCheckerService.php',
            'sulu_location.content.type.location' => 'getSuluLocation_Content_Type_LocationService.php',
            'sulu_media.disposition_type.resolver' => 'getSuluMedia_DispositionType_ResolverService.php',
            'sulu_media.format_options_manager' => 'getSuluMedia_FormatOptionsManagerService.php',
            'sulu_media.type.media_selection' => 'getSuluMedia_Type_MediaSelectionService.php',
            'sulu_media.type.single_media_selection' => 'getSuluMedia_Type_SingleMediaSelectionService.php',
            'sulu_page.document_manager.content_initializer' => 'getSuluPage_DocumentManager_ContentInitializerService.php',
            'sulu_page.export.webspace' => 'getSuluPage_Export_WebspaceService.php',
            'sulu_page.import.webspace' => 'getSuluPage_Import_WebspaceService.php',
            'sulu_page.node_repository' => 'getSuluPage_NodeRepositoryService.php',
            'sulu_page.resource_locator_controller' => 'getSuluPage_ResourceLocatorControllerService.php',
            'sulu_page.rl_repository' => 'getSuluPage_RlRepositoryService.php',
            'sulu_page.smart_content.content_type' => 'getSuluPage_SmartContent_ContentTypeService.php',
            'sulu_page.smart_content.data_provider_pool' => 'getSuluPage_SmartContent_DataProviderPoolService.php',
            'sulu_page.teaser.content_type' => 'getSuluPage_Teaser_ContentTypeService.php',
            'sulu_page.teaser_controller' => 'getSuluPage_TeaserControllerService.php',
            'sulu_preview.preview_controller' => 'getSuluPreview_PreviewControllerService.php',
            'sulu_route.content_type' => 'getSuluRoute_ContentTypeService.php',
            'sulu_search.controller.search' => 'getSuluSearch_Controller_SearchService.php',
            'sulu_security.encoder_factory' => 'getSuluSecurity_EncoderFactoryService.php',
            'sulu_security.mask_converter' => 'getSuluSecurity_MaskConverterService.php',
            'sulu_security.permission_controller' => 'getSuluSecurity_PermissionControllerService.php',
            'sulu_security.profile_controller' => 'getSuluSecurity_ProfileControllerService.php',
            'sulu_security.salt_generator' => 'getSuluSecurity_SaltGeneratorService.php',
            'sulu_security.security_systems_select_helper' => 'getSuluSecurity_SecuritySystemsSelectHelperService.php',
            'sulu_security.system_language_select_helper' => 'getSuluSecurity_SystemLanguageSelectHelperService.php',
            'sulu_security.token_generator' => 'getSuluSecurity_TokenGeneratorService.php',
            'sulu_security.user_manager' => 'getSuluSecurity_UserManagerService.php',
            'sulu_security.user_repository' => 'getSuluSecurity_UserRepositoryService.php',
            'sulu_security.user_setting_repository' => 'getSuluSecurity_UserSettingRepositoryService.php',
            'sulu_snippet.content.snippet' => 'getSuluSnippet_Content_SnippetService.php',
            'sulu_snippet.controller.snippet' => 'getSuluSnippet_Controller_SnippetService.php',
            'sulu_snippet.document.snippet_initializer' => 'getSuluSnippet_Document_SnippetInitializerService.php',
            'sulu_snippet.export.snippet' => 'getSuluSnippet_Export_SnippetService.php',
            'sulu_snippet.import.snippet' => 'getSuluSnippet_Import_SnippetService.php',
            'sulu_snippet.reference_store.snippet' => 'getSuluSnippet_ReferenceStore_SnippetService.php',
            'sulu_snippet.repository' => 'getSuluSnippet_RepositoryService.php',
            'sulu_tag.content.type.tag_selection' => 'getSuluTag_Content_Type_TagSelectionService.php',
            'sulu_test.massive_search.adapter.test' => 'getSuluTest_MassiveSearch_Adapter_TestService.php',
            'sulu_website.analytics.manager' => 'getSuluWebsite_Analytics_ManagerService.php',
            'sulu_website.http_cache.clearer' => 'getSuluWebsite_HttpCache_ClearerService.php',
            'sulu_website.resolver.parameter' => 'getSuluWebsite_Resolver_ParameterService.php',
            'sulu_website.resolver.template_attribute' => 'getSuluWebsite_Resolver_TemplateAttributeService.php',
            'sulu_website.sitemap.pool' => 'getSuluWebsite_Sitemap_PoolService.php',
            'sulu_website.sitemap.xml_dumper' => 'getSuluWebsite_Sitemap_XmlDumperService.php',
            'sulu_website.sitemap.xml_renderer' => 'getSuluWebsite_Sitemap_XmlRendererService.php',
            'sulu_website.url_select_helper' => 'getSuluWebsite_UrlSelectHelperService.php',
            'swiftmailer.mailer.default' => 'getSwiftmailer_Mailer_DefaultService.php',
            'swiftmailer.mailer.default.plugin.messagelogger' => 'getSwiftmailer_Mailer_Default_Plugin_MessageloggerService.php',
            'swiftmailer.mailer.default.transport' => 'getSwiftmailer_Mailer_Default_TransportService.php',
            'templating' => 'getTemplatingService.php',
            'templating.loader' => 'getTemplating_LoaderService.php',
            'test.client' => 'getTest_ClientService.php',
            'test.private_services_locator' => 'getTest_PrivateServicesLocatorService.php',
            'test.service_container' => 'getTest_ServiceContainerService.php',
            'test_user_provider' => 'getTestUserProviderService.php',
            'twig.controller.exception' => 'getTwig_Controller_ExceptionService.php',
            'twig.controller.preview_error' => 'getTwig_Controller_PreviewErrorService.php',
        ];
        $this->aliases = [
            'Doctrine\\Bundle\\PHPCRBundle\\ManagerRegistry' => 'doctrine_phpcr',
            'PHPCR\\SessionInterface' => 'sulu_test.doctrine_phpcr.default_session',
            'database_connection' => 'doctrine.dbal.default_connection',
            'doctrine.orm.default_metadata_cache' => 'doctrine_cache.providers.doctrine.orm.default_metadata_cache',
            'doctrine.orm.default_query_cache' => 'doctrine_cache.providers.doctrine.orm.default_query_cache',
            'doctrine.orm.default_result_cache' => 'doctrine_cache.providers.doctrine.orm.default_result_cache',
            'doctrine.orm.entity_manager' => 'doctrine.orm.default_entity_manager',
            'doctrine_phpcr.admin.jackalope_doctrine_dbal.default_connection' => 'doctrine.dbal.default_connection',
            'doctrine_phpcr.admin.jackalope_doctrine_dbal.live_connection' => 'doctrine.dbal.default_connection',
            'doctrine_phpcr.default_session' => 'sulu_test.doctrine_phpcr.default_session',
            'doctrine_phpcr.jackalope_doctrine_dbal.default_connection' => 'doctrine.dbal.default_connection',
            'doctrine_phpcr.jackalope_doctrine_dbal.live_connection' => 'doctrine.dbal.default_connection',
            'doctrine_phpcr.live_session' => 'sulu_test.doctrine_phpcr.live_session',
            'doctrine_phpcr.session' => 'sulu_test.doctrine_phpcr.default_session',
            'mailer' => 'swiftmailer.mailer.default',
            'sulu_document_manager.default_session' => 'sulu_test.doctrine_phpcr.default_session',
            'sulu_document_manager.live_session' => 'sulu_test.doctrine_phpcr.live_session',
            'sulu_preview.preview.cache' => 'doctrine_cache.providers.sulu_preview',
            'sulu_test.doctrine.orm.default_entity_manager' => 'doctrine.orm.default_entity_manager',
            'sulu_test.doctrine_phpcr' => 'doctrine_phpcr',
            'sulu_test.doctrine_phpcr.session' => 'sulu_test.doctrine_phpcr.default_session',
            'sulu_test.massive_search.adapter' => 'massive_search.adapter.zend_lucene',
            'sulu_website.exception.controller' => 'twig.controller.exception',
            'swiftmailer.transport' => 'swiftmailer.mailer.default.transport',
        ];
    }

    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled()
    {
        return true;
    }

    public function getRemovedIds()
    {
        return require $this->containerDir.\DIRECTORY_SEPARATOR.'removed-ids.php';
    }

    protected function load($file, $lazyLoad = true)
    {
        return require $this->containerDir.\DIRECTORY_SEPARATOR.$file;
    }

    protected function createProxy($class, \Closure $factory)
    {
        class_exists($class, false) || $this->load("{$class}.php");

        return $factory();
    }

    /**
     * Gets the public 'cache.app' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_AppService()
    {
        return $this->services['cache.app'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.app.recorder_inner'] ?? $this->getCache_App_RecorderInnerService()));
    }

    /**
     * Gets the public 'cache.system' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_SystemService()
    {
        return $this->services['cache.system'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.system.recorder_inner'] ?? $this->getCache_System_RecorderInnerService()));
    }

    /**
     * Gets the public 'doctrine' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrineService()
    {
        return $this->services['doctrine'] = new \Doctrine\Bundle\DoctrineBundle\Registry($this, $this->parameters['doctrine.connections'], $this->parameters['doctrine.entity_managers'], 'default', 'default');
    }

    /**
     * Gets the public 'doctrine.dbal.default_connection' shared service.
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDoctrine_Dbal_DefaultConnectionService()
    {
        return $this->services['doctrine.dbal.default_connection'] = ($this->privates['doctrine.dbal.connection_factory'] ?? ($this->privates['doctrine.dbal.connection_factory'] = new \Doctrine\Bundle\DoctrineBundle\ConnectionFactory([])))->createConnection(['url' => $this->getEnv('DATABASE_URL'), 'charset' => $this->getEnv('DATABASE_CHARSET'), 'host' => 'localhost', 'port' => NULL, 'user' => 'root', 'password' => NULL, 'driver' => 'pdo_mysql', 'driverOptions' => [], 'defaultTableOptions' => ['charset' => $this->getEnv('DATABASE_CHARSET'), 'collate' => $this->getEnv('DATABASE_COLLATE')]], ($this->privates['doctrine.dbal.default_connection.configuration'] ?? $this->getDoctrine_Dbal_DefaultConnection_ConfigurationService()), ($this->privates['doctrine.dbal.default_connection.event_manager'] ?? $this->getDoctrine_Dbal_DefaultConnection_EventManagerService()), []);
    }

    /**
     * Gets the public 'doctrine.orm.default_entity_manager' shared service.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getDoctrine_Orm_DefaultEntityManagerService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['doctrine.orm.default_entity_manager'] = $this->createProxy('EntityManager_9a5be93', function () {
                return \EntityManager_9a5be93::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getDoctrine_Orm_DefaultEntityManagerService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $instance = \Doctrine\ORM\EntityManager::create(($this->services['doctrine.dbal.default_connection'] ?? $this->getDoctrine_Dbal_DefaultConnectionService()), ($this->privates['doctrine.orm.default_configuration'] ?? $this->getDoctrine_Orm_DefaultConfigurationService()));

        ($this->privates['doctrine.orm.default_manager_configurator'] ?? ($this->privates['doctrine.orm.default_manager_configurator'] = new \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator([], [])))->configure($instance);

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_metadata_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultMetadataCacheService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_metadata_cache'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_cece031ed499e7b68c574164e4ce96709c4cc5690296f676b761dbc3aa7d0285');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_query_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultQueryCacheService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_query_cache'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_cece031ed499e7b68c574164e4ce96709c4cc5690296f676b761dbc3aa7d0285');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_cache.providers.doctrine.orm.default_result_cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getDoctrineCache_Providers_Doctrine_Orm_DefaultResultCacheService()
    {
        $this->services['doctrine_cache.providers.doctrine.orm.default_result_cache'] = $instance = new \Doctrine\Common\Cache\ArrayCache();

        $instance->setNamespace('sf_orm_default_cece031ed499e7b68c574164e4ce96709c4cc5690296f676b761dbc3aa7d0285');

        return $instance;
    }

    /**
     * Gets the public 'doctrine_phpcr' shared service.
     *
     * @return \Doctrine\Bundle\PHPCRBundle\ManagerRegistry
     */
    protected function getDoctrinePhpcrService()
    {
        return $this->services['doctrine_phpcr'] = new \Doctrine\Bundle\PHPCRBundle\ManagerRegistry($this, $this->parameters['doctrine_phpcr.sessions'], [], 'default', '', 'Doctrine\\Common\\Proxy\\Proxy');
    }

    /**
     * Gets the public 'event_dispatcher' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher
     */
    protected function getEventDispatcherService()
    {
        $this->services['event_dispatcher'] = $instance = new \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher(($this->privates['debug.event_dispatcher.inner'] ?? ($this->privates['debug.event_dispatcher.inner'] = new \Symfony\Component\EventDispatcher\EventDispatcher())), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))), ($this->privates['monolog.logger.event'] ?? $this->getMonolog_Logger_EventService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));

        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['sulu_form.request_listener'] ?? $this->getSuluForm_RequestListenerService());
        }, 1 => 'onKernelRequest'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['data_collector.router'] ?? ($this->privates['data_collector.router'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector()));
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('massive_search.index', [0 => function () {
            return ($this->privates['massive_search.events.index_listener'] ?? $this->load('getMassiveSearch_Events_IndexListenerService.php'));
        }, 1 => 'onIndex'], 0);
        $instance->addListener('massive_search.deindex', [0 => function () {
            return ($this->privates['massive_search.events.deindex_listener'] ?? $this->load('getMassiveSearch_Events_DeindexListenerService.php'));
        }, 1 => 'onDeindex'], 0);
        $instance->addListener('massive_search.index_rebuild', [0 => function () {
            return ($this->privates['massive_search.events.zend_rebuild'] ?? $this->load('getMassiveSearch_Events_ZendRebuildService.php'));
        }, 1 => 'onIndexRebuild'], -999);
        $instance->addListener('sulu_security.permission_update', [0 => function () {
            return ($this->privates['sulu_page.permission_listener'] ?? $this->load('getSuluPage_PermissionListenerService.php'));
        }, 1 => 'onPermissionUpdate'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['sulu_security.user_locale_listener'] ?? $this->getSuluSecurity_UserLocaleListenerService());
        }, 1 => 'copyUserLocaleToRequest'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['sulu_security.event_listener.security'] ?? $this->getSuluSecurity_EventListener_SecurityService());
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['sulu_website.routing.request_listener'] ?? $this->getSuluWebsite_Routing_RequestListenerService());
        }, 1 => 'onRequest'], 31);
        $instance->addListener('sulu.preview.pre-render', [0 => function () {
            return ($this->privates['sulu_website.event_listener.translator'] ?? $this->load('getSuluWebsite_EventListener_TranslatorService.php'));
        }, 1 => 'setLocaleOnPreviewPreRender'], 0);
        $instance->addListener('sulu_security.permission_update', [0 => function () {
            return ($this->privates['sulu_media.permission_listener'] ?? $this->load('getSuluMedia_PermissionListenerService.php'));
        }, 1 => 'onPermissionUpdate'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['sulu_markup.response_listener'] ?? $this->getSuluMarkup_ResponseListenerService());
        }, 1 => 'replaceMarkup'], -10);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['fos_rest.body_listener'] ?? $this->getFosRest_BodyListenerService());
        }, 1 => 'onKernelRequest'], 10);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onException'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onTerminate'], 0);
        $instance->addListener('console.error', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onException'], 0);
        $instance->addListener('console.terminate', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onTerminate'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['response_listener'] ?? ($this->privates['response_listener'] = new \Symfony\Component\HttpKernel\EventListener\ResponseListener('UTF-8')));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['streamed_response_listener'] ?? ($this->privates['streamed_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener()));
        }, 1 => 'onKernelResponse'], -1024);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'setDefaultLocale'], 100);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'onKernelRequest'], 16);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'onKernelFinishRequest'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['validate_request_listener'] ?? ($this->privates['validate_request_listener'] = new \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener()));
        }, 1 => 'onKernelRequest'], 256);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['resolve_controller_name_subscriber'] ?? $this->getResolveControllerNameSubscriberService());
        }, 1 => 'onKernelRequest'], 24);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['disallow_search_engine_index_response_listener'] ?? ($this->privates['disallow_search_engine_index_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\DisallowRobotsIndexingListener()));
        }, 1 => 'onResponse'], -255);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['locale_aware_listener'] ?? $this->getLocaleAwareListenerService());
        }, 1 => 'onKernelRequest'], 15);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['locale_aware_listener'] ?? $this->getLocaleAwareListenerService());
        }, 1 => 'onKernelFinishRequest'], -15);
        $instance->addListener('console.error', [0 => function () {
            return ($this->privates['console.error_listener'] ?? $this->load('getConsole_ErrorListenerService.php'));
        }, 1 => 'onConsoleError'], -128);
        $instance->addListener('console.terminate', [0 => function () {
            return ($this->privates['console.error_listener'] ?? $this->load('getConsole_ErrorListenerService.php'));
        }, 1 => 'onConsoleTerminate'], -128);
        $instance->addListener('console.error', [0 => function () {
            return ($this->privates['console.suggest_missing_package_subscriber'] ?? ($this->privates['console.suggest_missing_package_subscriber'] = new \Symfony\Bundle\FrameworkBundle\EventListener\SuggestMissingPackageSubscriber()));
        }, 1 => 'onConsoleError'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['test.session.listener'] ?? $this->getTest_Session_ListenerService());
        }, 1 => 'onKernelRequest'], 192);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['test.session.listener'] ?? $this->getTest_Session_ListenerService());
        }, 1 => 'onKernelResponse'], -128);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['session_listener'] ?? $this->getSessionListenerService());
        }, 1 => 'onKernelRequest'], 128);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['session_listener'] ?? $this->getSessionListenerService());
        }, 1 => 'onKernelResponse'], -1000);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['session_listener'] ?? $this->getSessionListenerService());
        }, 1 => 'onFinishRequest'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['esi_listener'] ?? $this->getEsiListenerService());
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['fragment.listener'] ?? $this->getFragment_ListenerService());
        }, 1 => 'onKernelRequest'], 48);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['profiler_listener'] ?? $this->getProfilerListenerService());
        }, 1 => 'onKernelResponse'], -100);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['profiler_listener'] ?? $this->getProfilerListenerService());
        }, 1 => 'onKernelException'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->privates['profiler_listener'] ?? $this->getProfilerListenerService());
        }, 1 => 'onKernelTerminate'], -1024);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['data_collector.request'] ?? ($this->privates['data_collector.request'] = new \Symfony\Component\HttpKernel\DataCollector\RequestDataCollector()));
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['data_collector.request'] ?? ($this->privates['data_collector.request'] = new \Symfony\Component\HttpKernel\DataCollector\RequestDataCollector()));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'configure'], 2048);
        $instance->addListener('console.command', [0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'configure'], 2048);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'onKernelException'], -2048);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['web_link.add_link_header_listener'] ?? ($this->privates['web_link.add_link_header_listener'] = new \Symfony\Component\WebLink\EventListener\AddLinkHeaderListener()));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['twig.exception_listener'] ?? $this->load('getTwig_ExceptionListenerService.php'));
        }, 1 => 'logKernelException'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['twig.exception_listener'] ?? $this->load('getTwig_ExceptionListenerService.php'));
        }, 1 => 'onKernelException'], -128);
        $instance->addListener('massive_search.index_rebuild', [0 => function () {
            return ($this->privates['massive_search.search.event_subscriber.purge_subscriber'] ?? $this->load('getMassiveSearch_Search_EventSubscriber_PurgeSubscriberService.php'));
        }, 1 => 'purgeIndexes'], 500);
        $instance->addListener('massive_search.pre_index', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.blame_timestamp'] ?? $this->load('getSuluPage_Search_EventSubscriber_BlameTimestampService.php'));
        }, 1 => 'handleBlameTimestamp'], 0);
        $instance->addListener('massive_search.hit', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.blame_timestamp'] ?? $this->load('getSuluPage_Search_EventSubscriber_BlameTimestampService.php'));
        }, 1 => 'handleBlameTimestampHitMapping'], 0);
        $instance->addListener('security.interactive_login', [0 => function () {
            return ($this->privates['sulu_security.last_login_listener'] ?? $this->load('getSuluSecurity_LastLoginListenerService.php'));
        }, 1 => 'onSecurityInteractiveLogin'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['sulu_website.router_listener'] ?? $this->getSuluWebsite_RouterListenerService());
        }, 1 => 'onKernelRequest'], 32);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['sulu_website.router_listener'] ?? $this->getSuluWebsite_RouterListenerService());
        }, 1 => 'onKernelFinishRequest'], 0);
        $instance->addListener('massive_search.pre_index', [0 => function () {
            return ($this->privates['sulu_media.search.subscriber.structure_media'] ?? $this->load('getSuluMedia_Search_Subscriber_StructureMediaService.php'));
        }, 1 => 'handlePreIndex'], 0);
        $instance->addListener('massive_search.pre_index', [0 => function () {
            return ($this->privates['sulu_media.search.subscriber.media'] ?? $this->load('getSuluMedia_Search_Subscriber_MediaService.php'));
        }, 1 => 'handlePreIndex'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['fos_rest.exception_listener'] ?? $this->load('getFosRest_ExceptionListenerService.php'));
        }, 1 => 'onKernelException'], -100);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['security.rememberme.response_listener'] ?? ($this->privates['security.rememberme.response_listener'] = new \Symfony\Component\Security\Http\RememberMe\ResponseListener()));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('debug.security.authorization.vote', [0 => function () {
            return ($this->privates['debug.security.voter.vote_listener'] ?? $this->load('getDebug_Security_Voter_VoteListenerService.php'));
        }, 1 => 'onVoterVote'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['debug.security.firewall'] ?? $this->getDebug_Security_FirewallService());
        }, 1 => 'configureLogoutUrlGenerator'], 8);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['debug.security.firewall'] ?? $this->getDebug_Security_FirewallService());
        }, 1 => 'onKernelRequest'], 8);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['debug.security.firewall'] ?? $this->getDebug_Security_FirewallService());
        }, 1 => 'onKernelFinishRequest'], 0);

        return $instance;
    }

    /**
     * Gets the public 'filesystem' shared service.
     *
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    protected function getFilesystemService()
    {
        return $this->services['filesystem'] = new \Symfony\Component\Filesystem\Filesystem();
    }

    /**
     * Gets the public 'form.factory' shared service.
     *
     * @return \Symfony\Component\Form\FormFactory
     */
    protected function getForm_FactoryService()
    {
        return $this->services['form.factory'] = new \Symfony\Component\Form\FormFactory(($this->privates['form.registry'] ?? $this->getForm_RegistryService()));
    }

    /**
     * Gets the public 'hateoas.generator.registry' shared service.
     *
     * @return \Hateoas\UrlGenerator\UrlGeneratorRegistry
     */
    protected function getHateoas_Generator_RegistryService()
    {
        return $this->services['hateoas.generator.registry'] = new \Hateoas\UrlGenerator\UrlGeneratorRegistry(($this->privates['hateoas.generator.symfony'] ?? $this->getHateoas_Generator_SymfonyService()));
    }

    /**
     * Gets the public 'hateoas.helper.link' shared service.
     *
     * @return \Hateoas\Helper\LinkHelper
     */
    protected function getHateoas_Helper_LinkService()
    {
        return $this->services['hateoas.helper.link'] = new \Hateoas\Helper\LinkHelper(($this->privates['hateoas.link_factory'] ?? $this->getHateoas_LinkFactoryService()), ($this->privates['hateoas.configuration.relations_repository'] ?? $this->getHateoas_Configuration_RelationsRepositoryService()));
    }

    /**
     * Gets the public 'http_kernel' shared service.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernel
     */
    protected function getHttpKernelService()
    {
        return $this->services['http_kernel'] = new \Symfony\Component\HttpKernel\HttpKernel(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->privates['debug.controller_resolver'] ?? $this->getDebug_ControllerResolverService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->privates['debug.argument_resolver'] ?? $this->getDebug_ArgumentResolverService()));
    }

    /**
     * Gets the public 'jms_serializer' shared service.
     *
     * @return \JMS\Serializer\Serializer
     */
    protected function getJmsSerializerService()
    {
        $this->services['jms_serializer'] = $instance = new \JMS\Serializer\Serializer(($this->privates['jms_serializer.metadata_factory'] ?? $this->getJmsSerializer_MetadataFactoryService()), ($this->services['fos_rest.serializer.jms_handler_registry'] ?? $this->load('getFosRest_Serializer_JmsHandlerRegistryService.php')), ($this->privates['jms_serializer.unserialize_object_constructor'] ?? ($this->privates['jms_serializer.unserialize_object_constructor'] = new \JMS\Serializer\Construction\UnserializeObjectConstructor())), new \PhpCollection\Map(['array' => ($this->privates['sulu_core.array_serialization_visitor'] ?? $this->getSuluCore_ArraySerializationVisitorService()), 'json' => ($this->services['jms_serializer.json_serialization_visitor'] ?? $this->getJmsSerializer_JsonSerializationVisitorService()), 'xml' => ($this->services['jms_serializer.xml_serialization_visitor'] ?? $this->getJmsSerializer_XmlSerializationVisitorService()), 'yml' => ($this->services['jms_serializer.yaml_serialization_visitor'] ?? $this->getJmsSerializer_YamlSerializationVisitorService())]), new \PhpCollection\Map(['json' => ($this->services['jms_serializer.json_deserialization_visitor'] ?? $this->getJmsSerializer_JsonDeserializationVisitorService()), 'xml' => ($this->services['jms_serializer.xml_deserialization_visitor'] ?? $this->getJmsSerializer_XmlDeserializationVisitorService())]), ($this->privates['jms_serializer.event_dispatcher'] ?? $this->getJmsSerializer_EventDispatcherService()), NULL, ($this->privates['jms_serializer.expression_evaluator'] ?? $this->getJmsSerializer_ExpressionEvaluatorService()));

        $instance->setSerializationContextFactory(($this->services['jms_serializer.serialization_context_factory'] ?? ($this->services['jms_serializer.serialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory())));
        $instance->setDeserializationContextFactory(($this->services['jms_serializer.deserialization_context_factory'] ?? ($this->services['jms_serializer.deserialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory())));

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.deserialization_context_factory' shared service.
     *
     * @return \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory
     */
    protected function getJmsSerializer_DeserializationContextFactoryService()
    {
        return $this->services['jms_serializer.deserialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory();
    }

    /**
     * Gets the public 'jms_serializer.json_deserialization_visitor' shared service.
     *
     * @return \JMS\Serializer\JsonDeserializationVisitor
     */
    protected function getJmsSerializer_JsonDeserializationVisitorService()
    {
        return $this->services['jms_serializer.json_deserialization_visitor'] = new \JMS\Serializer\JsonDeserializationVisitor(($this->privates['sulu_core.serialize_caching_strategy'] ?? $this->getSuluCore_SerializeCachingStrategyService()));
    }

    /**
     * Gets the public 'jms_serializer.json_serialization_visitor' shared service.
     *
     * @return \JMS\Serializer\JsonSerializationVisitor
     */
    protected function getJmsSerializer_JsonSerializationVisitorService()
    {
        $this->services['jms_serializer.json_serialization_visitor'] = $instance = new \JMS\Serializer\JsonSerializationVisitor(($this->privates['sulu_core.serialize_caching_strategy'] ?? $this->getSuluCore_SerializeCachingStrategyService()), ($this->privates['jms_serializer.accessor_strategy.expression'] ?? $this->getJmsSerializer_AccessorStrategy_ExpressionService()));

        $instance->setOptions(0);

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.serialization_context_factory' shared service.
     *
     * @return \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory
     */
    protected function getJmsSerializer_SerializationContextFactoryService()
    {
        return $this->services['jms_serializer.serialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory();
    }

    /**
     * Gets the public 'jms_serializer.xml_deserialization_visitor' shared service.
     *
     * @return \JMS\Serializer\XmlDeserializationVisitor
     */
    protected function getJmsSerializer_XmlDeserializationVisitorService()
    {
        $this->services['jms_serializer.xml_deserialization_visitor'] = $instance = new \JMS\Serializer\XmlDeserializationVisitor(($this->privates['sulu_core.serialize_caching_strategy'] ?? $this->getSuluCore_SerializeCachingStrategyService()));

        $instance->setDoctypeWhitelist([]);

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.xml_serialization_visitor' shared service.
     *
     * @return \JMS\Serializer\XmlSerializationVisitor
     */
    protected function getJmsSerializer_XmlSerializationVisitorService()
    {
        $this->services['jms_serializer.xml_serialization_visitor'] = $instance = new \JMS\Serializer\XmlSerializationVisitor(($this->privates['sulu_core.serialize_caching_strategy'] ?? $this->getSuluCore_SerializeCachingStrategyService()), ($this->privates['jms_serializer.accessor_strategy.expression'] ?? $this->getJmsSerializer_AccessorStrategy_ExpressionService()));

        $instance->setFormatOutput(true);

        return $instance;
    }

    /**
     * Gets the public 'jms_serializer.yaml_serialization_visitor' shared service.
     *
     * @return \JMS\Serializer\YamlSerializationVisitor
     */
    protected function getJmsSerializer_YamlSerializationVisitorService()
    {
        return $this->services['jms_serializer.yaml_serialization_visitor'] = new \JMS\Serializer\YamlSerializationVisitor(($this->privates['sulu_core.serialize_caching_strategy'] ?? $this->getSuluCore_SerializeCachingStrategyService()), ($this->privates['jms_serializer.accessor_strategy.expression'] ?? $this->getJmsSerializer_AccessorStrategy_ExpressionService()));
    }

    /**
     * Gets the public 'profiler' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Profiler\Profiler
     */
    protected function getProfilerService()
    {
        $this->services['profiler'] = $instance = new \Symfony\Component\HttpKernel\Profiler\Profiler(($this->privates['profiler.storage'] ?? ($this->privates['profiler.storage'] = new \Symfony\Component\HttpKernel\Profiler\FileProfilerStorage(('file:'.$this->targetDirs[0].'/profiler')))), ($this->privates['monolog.logger.profiler'] ?? $this->getMonolog_Logger_ProfilerService()), true);

        $instance->add(($this->privates['data_collector.request'] ?? ($this->privates['data_collector.request'] = new \Symfony\Component\HttpKernel\DataCollector\RequestDataCollector())));
        $instance->add(($this->privates['data_collector.time'] ?? $this->getDataCollector_TimeService()));
        $instance->add(($this->privates['data_collector.memory'] ?? ($this->privates['data_collector.memory'] = new \Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector())));
        $instance->add(($this->privates['data_collector.validator'] ?? $this->getDataCollector_ValidatorService()));
        $instance->add(($this->privates['data_collector.ajax'] ?? ($this->privates['data_collector.ajax'] = new \Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector())));
        $instance->add(($this->privates['data_collector.form'] ?? $this->getDataCollector_FormService()));
        $instance->add(($this->privates['data_collector.exception'] ?? ($this->privates['data_collector.exception'] = new \Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector())));
        $instance->add(($this->privates['data_collector.logger'] ?? $this->getDataCollector_LoggerService()));
        $instance->add(($this->privates['data_collector.events'] ?? $this->getDataCollector_EventsService()));
        $instance->add(($this->privates['data_collector.router'] ?? ($this->privates['data_collector.router'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector())));
        $instance->add(($this->privates['data_collector.cache'] ?? $this->getDataCollector_CacheService()));
        $instance->add(($this->privates['data_collector.translation'] ?? $this->getDataCollector_TranslationService()));
        $instance->add(($this->privates['data_collector.security'] ?? $this->getDataCollector_SecurityService()));
        $instance->add(($this->privates['data_collector.twig'] ?? $this->getDataCollector_TwigService()));
        $instance->add(($this->privates['data_collector.doctrine'] ?? $this->getDataCollector_DoctrineService()));
        $instance->add(($this->privates['doctrine_phpcr.data_collector'] ?? $this->getDoctrinePhpcr_DataCollectorService()));
        $instance->add(($this->privates['swiftmailer.data_collector'] ?? ($this->privates['swiftmailer.data_collector'] = new \Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector($this))));
        $instance->add(($this->privates['data_collector.config'] ?? $this->getDataCollector_ConfigService()));

        return $instance;
    }

    /**
     * Gets the public 'request_stack' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    protected function getRequestStackService()
    {
        return $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack();
    }

    /**
     * Gets the public 'router' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected function getRouterService()
    {
        $this->services['router'] = $instance = new \Symfony\Bundle\FrameworkBundle\Routing\Router((new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'routing.loader' => ['services', 'routing.loader', 'getRouting_LoaderService.php', true],
        ], [
            'routing.loader' => 'Symfony\\Component\\Config\\Loader\\LoaderInterface',
        ]))->withContext('router.default', $this), ($this->targetDirs[4].'/config/routing.yml'), ['cache_dir' => $this->targetDirs[0], 'debug' => true, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\CompiledUrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\CompiledUrlGeneratorDumper', 'matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableCompiledUrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\CompiledUrlMatcherDumper', 'strict_requirements' => true], ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()), ($this->privates['parameter_bag'] ?? ($this->privates['parameter_bag'] = new \Symfony\Component\DependencyInjection\ParameterBag\ContainerBag($this))), ($this->privates['monolog.logger.router'] ?? $this->getMonolog_Logger_RouterService()), 'en');

        $instance->setConfigCacheFactory(($this->privates['config_cache_factory'] ?? $this->getConfigCacheFactoryService()));

        return $instance;
    }

    /**
     * Gets the public 'security.authorization_checker' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    protected function getSecurity_AuthorizationCheckerService()
    {
        return $this->services['security.authorization_checker'] = new \Symfony\Component\Security\Core\Authorization\AuthorizationChecker(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->privates['security.authentication.manager'] ?? $this->getSecurity_Authentication_ManagerService()), ($this->privates['debug.security.access.decision_manager'] ?? $this->getDebug_Security_Access_DecisionManagerService()), false);
    }

    /**
     * Gets the public 'security.token_storage' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    protected function getSecurity_TokenStorageService()
    {
        return $this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage();
    }

    /**
     * Gets the public 'sulu.content.localization_finder' shared service.
     *
     * @return \Sulu\Component\Content\Compat\LocalizationFinder
     */
    protected function getSulu_Content_LocalizationFinderService()
    {
        return $this->services['sulu.content.localization_finder'] = new \Sulu\Component\Content\Compat\LocalizationFinder(($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()));
    }

    /**
     * Gets the public 'sulu.content.mapper' shared service.
     *
     * @return \Sulu\Component\Content\Mapper\ContentMapper
     */
    protected function getSulu_Content_MapperService()
    {
        return $this->services['sulu.content.mapper'] = new \Sulu\Component\Content\Mapper\ContentMapper(($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), ($this->services['form.factory'] ?? $this->getForm_FactoryService()), ($this->services['sulu_document_manager.document_inspector'] ?? $this->getSuluDocumentManager_DocumentInspectorService()), ($this->services['sulu_document_manager.property_encoder'] ?? $this->getSuluDocumentManager_PropertyEncoderService()), ($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu_page.extension.manager'] ?? $this->getSuluPage_Extension_ManagerService()), ($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()), ($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->privates['sulu.content.resource_locator.strategy_pool'] ?? $this->getSulu_Content_ResourceLocator_StrategyPoolService()), ($this->privates['sulu_document_manager.namespace_registry'] ?? $this->getSuluDocumentManager_NamespaceRegistryService()));
    }

    /**
     * Gets the public 'sulu.content.path_cleaner' shared service.
     *
     * @return \Sulu\Component\PHPCR\PathCleanup
     */
    protected function getSulu_Content_PathCleanerService()
    {
        return $this->services['sulu.content.path_cleaner'] = new \Sulu\Component\PHPCR\PathCleanup(['default' => [' ' => '-', '+' => '-', '.' => '-', '^' => '-', '~' => '-', '[' => '-', ']' => '-', '(' => '-', ')' => '-', '{' => '-', '}' => '-', 'Á' => 'A', 'á' => 'a', 'Ć' => 'C', 'ć' => 'c', 'É' => 'E', 'é' => 'e', 'Í' => 'I', 'í' => 'i', 'Ĺ' => 'L', 'ĺ' => 'l', 'Ń' => 'N', 'ń' => 'n', 'Ó' => 'O', 'ó' => 'o', 'Ő' => 'O', 'ő' => 'o', 'Ŕ' => 'R', 'ŕ' => 'r', 'Ś' => 'S', 'ś' => 's', 'Ú' => 'U', 'ú' => 'u', 'Ű' => 'U', 'ű' => 'u', 'Ý' => 'Y', 'ý' => 'y', 'Ź' => 'Z', 'ź' => 'z', 'Ă' => 'A', 'ă' => 'a', 'Ĕ' => 'E', 'ĕ' => 'e', 'Ğ' => 'G', 'ğ' => 'g', 'Ĭ' => 'I', 'ĭ' => 'i', 'Ŏ' => 'o', 'ŏ' => 'o', 'Ŭ' => 'U', 'ŭ' => 'u', 'Č' => 'C', 'č' => 'c', 'Ď' => 'D', 'Ě' => 'E', 'ě' => 'e', 'Ň' => 'N', 'ň' => 'n', 'Ř' => 'R', 'ř' => 'r', 'Š' => 'S', 'š' => 's', 'Ť' => 'T', 'Ž' => 'Z', 'ž' => 'z', 'Ç' => 'C', 'ç' => 'c', 'Ģ' => 'G', 'ģ' => 'g', 'Ķ' => 'K', 'ķ' => 'k', 'Ļ' => 'L', 'ļ' => 'l', 'Ņ' => 'N', 'ņ' => 'n', 'Ŗ' => 'R', 'ŗ' => 'r', 'Ş' => 'S', 'ş' => 's', 'Ţ' => 'T', 'ţ' => 't', 'Ä' => 'Ae', 'ä' => 'ae', 'Ë' => 'E', 'ë' => 'e', 'Ï' => 'I', 'ï' => 'i', 'Ö' => 'Oe', 'ö' => 'oe', 'Ü' => 'Ue', 'ü' => 'ue', 'Ÿ' => 'Y', 'ÿ' => 'y', 'À' => 'A', 'à' => 'a', 'È' => 'E', 'è' => 'e', 'Ì' => 'I', 'ì' => 'i', 'Ò' => 'O', 'ò' => 'o', 'Ù' => 'U', 'ù' => 'u', 'Ā' => 'A', 'ā' => 'a', 'Ē' => 'E', 'ē' => 'e', 'Ī' => 'I', 'ī' => 'i', 'Ō' => 'O', 'ō' => 'o', 'Ū' => 'U', 'ū' => 'u', 'Ą' => 'A', 'ą' => 'a', 'Ę' => 'E', 'ę' => 'e', 'Į' => 'I', 'į' => 'i', 'Ų' => 'U', 'ų' => 'u', 'Ḃ' => 'B', 'ḃ' => 'b', 'Ċ' => 'C', 'ċ' => 'c', 'Ḋ' => 'D', 'ḋ' => 'd', 'Ė' => 'E', 'ė' => 'e', 'Ḟ' => 'F', 'Ġ' => 'G', 'ġ' => 'g', 'Ḣ' => 'H', 'ḣ' => 'h', 'İ' => 'I', 'Ṁ' => 'M', 'ṁ' => 'm', 'Ṅ' => 'N', 'ṅ' => 'n', 'Ṗ' => 'P', 'ṗ' => 'p', 'Ṙ' => 'R', 'ṙ' => 'r', 'Ṡ' => 'S', 'ṡ' => 's', 'Ṫ' => 'T', 'ṫ' => 't', 'Ż' => 'Z', 'ż' => 'z', 'Ḍ' => 'D', 'ḍ' => 'd', 'Ḥ' => 'H', 'ḥ' => 'h', 'Ḳ' => 'K', 'ḳ' => 'k', 'Ḷ' => 'L', 'ḷ' => 'l', 'Ṃ' => 'M', 'ṃ' => 'm', 'Ṛ' => 'R', 'ṛ' => 'r', 'Ṣ' => 'S', 'ṣ' => 's', 'Ṭ' => 'T', 'ṭ' => 't', 'Ṿ' => 'V', 'ṿ' => 'v', 'Đ' => 'D', 'đ' => 'd', 'Ħ' => 'H', 'ħ' => 'h', 'Ŧ' => 'T', 'ŧ' => 't', 'Å' => 'A', 'å' => 'a', 'Ů' => 'U', 'ů' => 'u', 'Ł' => 'L', 'ł' => 'l', 'Ø' => 'O', 'ø' => 'o', 'Ã' => 'A', 'ã' => 'a', 'Ĩ' => 'I', 'ĩ' => 'i', 'Ñ' => 'N', 'ñ' => 'n', 'Õ' => 'O', 'õ' => 'o', 'Ũ' => 'U', 'ũ' => 'u', 'Â' => 'A', 'â' => 'a', 'Ĉ' => 'C', 'ĉ' => 'c', 'Ê' => 'E', 'ê' => 'e', 'Ĝ' => 'G', 'ĝ' => 'g', 'Ĥ' => 'H', 'ĥ' => 'h', 'Î' => 'I', 'î' => 'i', 'Ĵ' => 'J', 'ĵ' => 'j', 'Ô' => 'O', 'ô' => 'o', 'Ŝ' => 'S', 'ŝ' => 's', 'Û' => 'U', 'û' => 'u', 'Ŵ' => 'W', 'ŵ' => 'w', 'Ŷ' => 'Y', 'ŷ' => 'y', 'Æ' => 'AE', 'æ' => 'ae', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Ĳ' => 'IJ', 'ª' => 'a', 'º' => 'o'], 'de' => ['&' => 'und'], 'en' => ['&' => 'and'], 'fr' => ['&' => 'et'], 'it' => ['&' => 'e'], 'nl' => ['&' => 'en'], 'es' => ['&' => 'y']]);
    }

    /**
     * Gets the public 'sulu.content.structure_manager' shared service.
     *
     * @return \Sulu\Component\Content\Compat\StructureManager
     */
    protected function getSulu_Content_StructureManagerService()
    {
        return $this->services['sulu.content.structure_manager'] = new \Sulu\Component\Content\Compat\StructureManager(($this->services['sulu_page.structure.factory'] ?? $this->getSuluPage_Structure_FactoryService()), ($this->services['sulu_document_manager.document_inspector'] ?? $this->getSuluDocumentManager_DocumentInspectorService()), ($this->services['sulu_page.compat.structure.legacy_property_factory'] ?? $this->getSuluPage_Compat_Structure_LegacyPropertyFactoryService()), $this->parameters['sulu.content.structure.type_map']);
    }

    /**
     * Gets the public 'sulu.content.type_manager' shared service.
     *
     * @return \Sulu\Component\Content\ContentTypeManager
     */
    protected function getSulu_Content_TypeManagerService()
    {
        $this->services['sulu.content.type_manager'] = $instance = new \Sulu\Component\Content\ContentTypeManager($this);

        $instance->mapAliasToServiceId('single_form_selection', 'sulu_form.content_type.single_form_selection');
        $instance->mapAliasToServiceId('number', 'sulu.content.type.number');
        $instance->mapAliasToServiceId('text_line', 'sulu.content.type.text_line');
        $instance->mapAliasToServiceId('text_area', 'sulu.content.type.text_area');
        $instance->mapAliasToServiceId('text_editor', 'sulu.content.type.text_editor');
        $instance->mapAliasToServiceId('resource_locator', 'sulu.content.type.resource_locator');
        $instance->mapAliasToServiceId('block', 'sulu.content.type.block');
        $instance->mapAliasToServiceId('smart_content', 'sulu_page.smart_content.content_type');
        $instance->mapAliasToServiceId('teaser_selection', 'sulu_page.teaser.content_type');
        $instance->mapAliasToServiceId('page_selection', 'sulu.content.type.page_selection');
        $instance->mapAliasToServiceId('single_page_selection', 'sulu.content.type.single_page_selection');
        $instance->mapAliasToServiceId('phone', 'sulu.content.type.phone');
        $instance->mapAliasToServiceId('password', 'sulu.content.type.password');
        $instance->mapAliasToServiceId('url', 'sulu.content.type.url');
        $instance->mapAliasToServiceId('email', 'sulu.content.type.email');
        $instance->mapAliasToServiceId('date', 'sulu.content.type.date');
        $instance->mapAliasToServiceId('time', 'sulu.content.type.time');
        $instance->mapAliasToServiceId('color', 'sulu.content.type.color');
        $instance->mapAliasToServiceId('checkbox', 'sulu.content.type.checkbox');
        $instance->mapAliasToServiceId('select', 'sulu.content.type.select');
        $instance->mapAliasToServiceId('single_select', 'sulu.content.type.single_select');
        $instance->mapAliasToServiceId('contact_account_selection', 'sulu_contact.content.contact_account_selection');
        $instance->mapAliasToServiceId('single_contact_selection', 'sulu_contact.content.single_contact_selection');
        $instance->mapAliasToServiceId('single_account_selection', 'sulu_contact.content.single_account_selection');
        $instance->mapAliasToServiceId('tag_selection', 'sulu_tag.content.type.tag_selection');
        $instance->mapAliasToServiceId('media_selection', 'sulu_media.type.media_selection');
        $instance->mapAliasToServiceId('single_media_selection', 'sulu_media.type.single_media_selection');
        $instance->mapAliasToServiceId('category_selection', 'sulu_category.content.type.category_selection');
        $instance->mapAliasToServiceId('snippet_selection', 'sulu_snippet.content.snippet');
        $instance->mapAliasToServiceId('location', 'sulu_location.content.type.location');
        $instance->mapAliasToServiceId('route', 'sulu_route.content_type');
        $instance->mapAliasToServiceId('target_group_selection', 'sulu_audience_targeting.content.type.target_group_selection');

        return $instance;
    }

    /**
     * Gets the public 'sulu.phpcr.session' shared service.
     *
     * @return \Sulu\Component\PHPCR\SessionManager\SessionManager
     */
    protected function getSulu_Phpcr_SessionService()
    {
        return $this->services['sulu.phpcr.session'] = new \Sulu\Component\PHPCR\SessionManager\SessionManager(($this->services['sulu_test.doctrine_phpcr.default_session'] ?? $this->getSuluTest_DoctrinePhpcr_DefaultSessionService()), ['base' => 'cmf', 'content' => 'contents', 'route' => 'routes', 'snippet' => 'snippets']);
    }

    /**
     * Gets the public 'sulu.repository.category' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Entity\CategoryRepository
     */
    protected function getSulu_Repository_CategoryService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.category'] = $this->createProxy('CategoryRepository_9c346ab', function () {
                return \CategoryRepository_9c346ab::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_CategoryService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\CategoryBundle\Entity\CategoryRepository($a, $a->getClassMetadata('Sulu\\Bundle\\CategoryBundle\\Entity\\Category'));
    }

    /**
     * Gets the public 'sulu.repository.category_meta' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Entity\CategoryMetaRepository
     */
    protected function getSulu_Repository_CategoryMetaService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.category_meta'] = $this->createProxy('CategoryMetaRepository_d16c689', function () {
                return \CategoryMetaRepository_d16c689::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_CategoryMetaService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\CategoryBundle\Entity\CategoryMetaRepository($a, $a->getClassMetadata('Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMeta'));
    }

    /**
     * Gets the public 'sulu.repository.category_translation' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationRepository
     */
    protected function getSulu_Repository_CategoryTranslationService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.category_translation'] = $this->createProxy('CategoryTranslationRepository_5ea8703', function () {
                return \CategoryTranslationRepository_5ea8703::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_CategoryTranslationService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\CategoryBundle\Entity\CategoryTranslationRepository($a, $a->getClassMetadata('Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslation'));
    }

    /**
     * Gets the public 'sulu.repository.contact' shared service.
     *
     * @return \Sulu\Bundle\ContactBundle\Entity\ContactRepository
     */
    protected function getSulu_Repository_ContactService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.contact'] = $this->createProxy('ContactRepository_74094bd', function () {
                return \ContactRepository_74094bd::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_ContactService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\ContactBundle\Entity\ContactRepository($a, $a->getClassMetadata('Sulu\\Bundle\\ContactBundle\\Entity\\Contact'));
    }

    /**
     * Gets the public 'sulu.repository.keyword' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Entity\KeywordRepository
     */
    protected function getSulu_Repository_KeywordService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.keyword'] = $this->createProxy('KeywordRepository_4891058', function () {
                return \KeywordRepository_4891058::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_KeywordService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\CategoryBundle\Entity\KeywordRepository($a, $a->getClassMetadata('Sulu\\Bundle\\CategoryBundle\\Entity\\Keyword'));
    }

    /**
     * Gets the public 'sulu.repository.media' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Entity\MediaRepository
     */
    protected function getSulu_Repository_MediaService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.media'] = $this->createProxy('MediaRepository_283a6d2', function () {
                return \MediaRepository_283a6d2::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_MediaService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\MediaBundle\Entity\MediaRepository($a, $a->getClassMetadata('Sulu\\Bundle\\MediaBundle\\Entity\\Media'));
    }

    /**
     * Gets the public 'sulu.repository.tag' shared service.
     *
     * @return \Sulu\Bundle\TagBundle\Entity\TagRepository
     */
    protected function getSulu_Repository_TagService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.tag'] = $this->createProxy('TagRepository_4e72930', function () {
                return \TagRepository_4e72930::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_TagService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\TagBundle\Entity\TagRepository($a, $a->getClassMetadata('Sulu\\Bundle\\TagBundle\\Entity\\Tag'));
    }

    /**
     * Gets the public 'sulu.repository.target_group' shared service.
     *
     * @return \Sulu\Bundle\AudienceTargetingBundle\Entity\TargetGroupRepository
     */
    protected function getSulu_Repository_TargetGroupService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.target_group'] = $this->createProxy('TargetGroupRepository_450a9cd', function () {
                return \TargetGroupRepository_450a9cd::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_TargetGroupService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\AudienceTargetingBundle\Entity\TargetGroupRepository($a, $a->getClassMetadata('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroup'));
    }

    /**
     * Gets the public 'sulu.repository.user' shared service.
     *
     * @return \Sulu\Bundle\SecurityBundle\Entity\UserRepository
     */
    protected function getSulu_Repository_UserService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['sulu.repository.user'] = $this->createProxy('UserRepository_28384ec', function () {
                return \UserRepository_28384ec::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getSulu_Repository_UserService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        $a = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService());

        return new \Sulu\Bundle\SecurityBundle\Entity\UserRepository($a, $a->getClassMetadata('Sulu\\Bundle\\SecurityBundle\\Entity\\User'));
    }

    /**
     * Gets the public 'sulu.util.node_helper' shared service.
     *
     * @return \Sulu\Component\Util\SuluNodeHelper
     */
    protected function getSulu_Util_NodeHelperService()
    {
        return $this->services['sulu.util.node_helper'] = new \Sulu\Component\Util\SuluNodeHelper(($this->services['sulu_test.doctrine_phpcr.default_session'] ?? $this->getSuluTest_DoctrinePhpcr_DefaultSessionService()), 'i18n', ['base' => 'cmf', 'content' => 'contents', 'route' => 'routes', 'snippet' => 'snippets'], ($this->services['sulu_page.structure.factory'] ?? $this->getSuluPage_Structure_FactoryService()));
    }

    /**
     * Gets the public 'sulu_category.category_manager' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Category\CategoryManager
     */
    protected function getSuluCategory_CategoryManagerService()
    {
        return $this->services['sulu_category.category_manager'] = new \Sulu\Bundle\CategoryBundle\Category\CategoryManager(($this->services['sulu.repository.category'] ?? $this->getSulu_Repository_CategoryService()), ($this->services['sulu.repository.category_meta'] ?? $this->getSulu_Repository_CategoryMetaService()), ($this->services['sulu.repository.category_translation'] ?? $this->getSulu_Repository_CategoryTranslationService()), ($this->services['sulu.repository.user'] ?? $this->getSulu_Repository_UserService()), ($this->services['sulu_category.keyword_manager'] ?? $this->getSuluCategory_KeywordManagerService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));
    }

    /**
     * Gets the public 'sulu_category.keyword_manager' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Category\KeywordManager
     */
    protected function getSuluCategory_KeywordManagerService()
    {
        return $this->services['sulu_category.keyword_manager'] = new \Sulu\Bundle\CategoryBundle\Category\KeywordManager(($this->services['sulu.repository.keyword'] ?? $this->getSulu_Repository_KeywordService()), ($this->services['sulu.repository.category_translation'] ?? $this->getSulu_Repository_CategoryTranslationService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()));
    }

    /**
     * Gets the public 'sulu_core.webspace.request_analyzer' shared service.
     *
     * @return \Sulu\Component\Webspace\Analyzer\RequestAnalyzer
     */
    protected function getSuluCore_Webspace_RequestAnalyzerService()
    {
        return $this->services['sulu_core.webspace.request_analyzer'] = new \Sulu\Component\Webspace\Analyzer\RequestAnalyzer(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), [0 => ($this->privates['sulu_core.request_processor.admin'] ?? $this->getSuluCore_RequestProcessor_AdminService())]);
    }

    /**
     * Gets the public 'sulu_core.webspace.webspace_manager' shared service.
     *
     * @return \Sulu\Component\Webspace\Manager\WebspaceManager
     */
    protected function getSuluCore_Webspace_WebspaceManagerService()
    {
        return $this->services['sulu_core.webspace.webspace_manager'] = new \Sulu\Component\Webspace\Manager\WebspaceManager(($this->privates['sulu_core.webspace.loader.delegator'] ?? $this->getSuluCore_Webspace_Loader_DelegatorService()), ($this->privates['sulu_core.webspace.webspace_manager.url_replacer'] ?? ($this->privates['sulu_core.webspace.webspace_manager.url_replacer'] = new \Sulu\Component\Webspace\Url\Replacer())), ['config_dir' => ($this->targetDirs[4].'/config/webspaces'), 'cache_dir' => ($this->targetDirs[0].'/sulu'), 'debug' => true, 'cache_class' => 'adminWebspaceCollectionCache', 'base_class' => 'WebspaceCollection']);
    }

    /**
     * Gets the public 'sulu_document_manager.document_inspector' shared service.
     *
     * @return \Sulu\Bundle\DocumentManagerBundle\Bridge\DocumentInspector
     */
    protected function getSuluDocumentManager_DocumentInspectorService()
    {
        return $this->services['sulu_document_manager.document_inspector'] = new \Sulu\Bundle\DocumentManagerBundle\Bridge\DocumentInspector(($this->privates['sulu_document_manager.document_registry'] ?? ($this->privates['sulu_document_manager.document_registry'] = new \Sulu\Component\DocumentManager\DocumentRegistry('en'))), ($this->privates['sulu_document_manager.path_segment_registry'] ?? $this->getSuluDocumentManager_PathSegmentRegistryService()), ($this->privates['sulu_document_manager.namespace_registry'] ?? $this->getSuluDocumentManager_NamespaceRegistryService()), ($this->privates['sulu_document_manager.proxy_factory'] ?? $this->getSuluDocumentManager_ProxyFactoryService()), ($this->privates['sulu_document_manager.metadata_factory'] ?? $this->getSuluDocumentManager_MetadataFactoryService()), ($this->services['sulu_page.structure.factory'] ?? $this->getSuluPage_Structure_FactoryService()), ($this->services['sulu_document_manager.property_encoder'] ?? $this->getSuluDocumentManager_PropertyEncoderService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()));
    }

    /**
     * Gets the public 'sulu_document_manager.document_manager' shared service.
     *
     * @return \Sulu\Component\DocumentManager\DocumentManager
     */
    protected function getSuluDocumentManager_DocumentManagerService()
    {
        return $this->services['sulu_document_manager.document_manager'] = new \Sulu\Component\DocumentManager\DocumentManager(($this->privates['sulu_document_manager.event_dispatcher.standard'] ?? $this->getSuluDocumentManager_EventDispatcher_StandardService()), ($this->privates['sulu_document_manager.node_manager'] ?? $this->getSuluDocumentManager_NodeManagerService()));
    }

    /**
     * Gets the public 'sulu_document_manager.metadata_factory.base' shared service.
     *
     * @return \Sulu\Component\DocumentManager\Metadata\BaseMetadataFactory
     */
    protected function getSuluDocumentManager_MetadataFactory_BaseService()
    {
        return $this->services['sulu_document_manager.metadata_factory.base'] = new \Sulu\Component\DocumentManager\Metadata\BaseMetadataFactory(($this->privates['sulu_document_manager.event_dispatcher.standard'] ?? $this->getSuluDocumentManager_EventDispatcher_StandardService()), $this->parameters['sulu_document_manager.mapping']);
    }

    /**
     * Gets the public 'sulu_document_manager.property_encoder' shared service.
     *
     * @return \Sulu\Bundle\DocumentManagerBundle\Bridge\PropertyEncoder
     */
    protected function getSuluDocumentManager_PropertyEncoderService()
    {
        return $this->services['sulu_document_manager.property_encoder'] = new \Sulu\Bundle\DocumentManagerBundle\Bridge\PropertyEncoder(($this->privates['sulu_document_manager.namespace_registry'] ?? $this->getSuluDocumentManager_NamespaceRegistryService()));
    }

    /**
     * Gets the public 'sulu_markup.parser.html_extractor' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Markup\HtmlTagExtractor
     */
    protected function getSuluMarkup_Parser_HtmlExtractorService()
    {
        return $this->services['sulu_markup.parser.html_extractor'] = new \Sulu\Bundle\MarkupBundle\Markup\HtmlTagExtractor('sulu');
    }

    /**
     * Gets the public 'sulu_media.collection_manager' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Collection\Manager\CollectionManager
     */
    protected function getSuluMedia_CollectionManagerService()
    {
        return $this->services['sulu_media.collection_manager'] = new \Sulu\Bundle\MediaBundle\Collection\Manager\CollectionManager(($this->services['sulu_media.collection_repository'] ?? $this->getSuluMedia_CollectionRepositoryService()), ($this->services['sulu.repository.media'] ?? $this->getSulu_Repository_MediaService()), ($this->services['sulu_media.format_manager'] ?? $this->getSuluMedia_FormatManagerService()), ($this->services['sulu.repository.user'] ?? $this->getSulu_Repository_UserService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), 'sulu-50x50', $this->parameters['sulu_security.permissions']);
    }

    /**
     * Gets the public 'sulu_media.collection_repository' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Entity\CollectionRepository
     */
    protected function getSuluMedia_CollectionRepositoryService()
    {
        return $this->services['sulu_media.collection_repository'] = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService())->getRepository('SuluMediaBundle:Collection');
    }

    /**
     * Gets the public 'sulu_media.format_manager' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\FormatManager\FormatManager
     */
    protected function getSuluMedia_FormatManagerService()
    {
        return $this->services['sulu_media.format_manager'] = new \Sulu\Bundle\MediaBundle\Media\FormatManager\FormatManager(($this->services['sulu.repository.media'] ?? $this->getSulu_Repository_MediaService()), ($this->privates['sulu_media.format_cache'] ?? $this->getSuluMedia_FormatCacheService()), ($this->privates['sulu_media.image.converter'] ?? $this->getSuluMedia_Image_ConverterService()), true, $this->parameters['sulu_media.format_manager.response_headers'], $this->parameters['sulu_media.image.formats'], $this->parameters['sulu_media.format_manager.mime_types'], ($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /**
     * Gets the public 'sulu_media.image.transformation.blur' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\BlurTransformation
     */
    protected function getSuluMedia_Image_Transformation_BlurService()
    {
        return $this->services['sulu_media.image.transformation.blur'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\BlurTransformation();
    }

    /**
     * Gets the public 'sulu_media.image.transformation.crop' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\CropTransformation
     */
    protected function getSuluMedia_Image_Transformation_CropService()
    {
        return $this->services['sulu_media.image.transformation.crop'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\CropTransformation();
    }

    /**
     * Gets the public 'sulu_media.image.transformation.gamma' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\GammaTransformation
     */
    protected function getSuluMedia_Image_Transformation_GammaService()
    {
        return $this->services['sulu_media.image.transformation.gamma'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\GammaTransformation();
    }

    /**
     * Gets the public 'sulu_media.image.transformation.grayscale' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\GrayscaleTransformation
     */
    protected function getSuluMedia_Image_Transformation_GrayscaleService()
    {
        return $this->services['sulu_media.image.transformation.grayscale'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\GrayscaleTransformation();
    }

    /**
     * Gets the public 'sulu_media.image.transformation.negative' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\NegativeTransformation
     */
    protected function getSuluMedia_Image_Transformation_NegativeService()
    {
        return $this->services['sulu_media.image.transformation.negative'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\NegativeTransformation();
    }

    /**
     * Gets the public 'sulu_media.image.transformation.paste' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\PasteTransformation
     */
    protected function getSuluMedia_Image_Transformation_PasteService()
    {
        return $this->services['sulu_media.image.transformation.paste'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\PasteTransformation(($this->privates['sulu_media.adapter.imagick'] ?? ($this->privates['sulu_media.adapter.imagick'] = new \Imagine\Imagick\Imagine())), ($this->privates['file_locator'] ?? ($this->privates['file_locator'] = new \Symfony\Component\HttpKernel\Config\FileLocator(($this->services['kernel'] ?? $this->get('kernel', 1)), ($this->targetDirs[4].'/Resources'), [0 => $this->targetDirs[4]]))));
    }

    /**
     * Gets the public 'sulu_media.image.transformation.sharpen' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\SharpenTransformation
     */
    protected function getSuluMedia_Image_Transformation_SharpenService()
    {
        return $this->services['sulu_media.image.transformation.sharpen'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\SharpenTransformation();
    }

    /**
     * Gets the public 'sulu_media.media_manager' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\Manager\MediaManager
     */
    protected function getSuluMedia_MediaManagerService()
    {
        return $this->services['sulu_media.media_manager'] = new \Sulu\Bundle\MediaBundle\Media\Manager\MediaManager(($this->services['sulu.repository.media'] ?? $this->getSulu_Repository_MediaService()), ($this->services['sulu_media.collection_repository'] ?? $this->getSuluMedia_CollectionRepositoryService()), ($this->services['sulu.repository.user'] ?? $this->getSulu_Repository_UserService()), ($this->services['sulu.repository.category'] ?? $this->getSulu_Repository_CategoryService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->services['sulu_media.storage'] ?? $this->getSuluMedia_StorageService()), ($this->privates['sulu_media.file_validator'] ?? ($this->privates['sulu_media.file_validator'] = new \Sulu\Bundle\MediaBundle\Media\FileValidator\FileValidator())), ($this->services['sulu_media.format_manager'] ?? $this->getSuluMedia_FormatManagerService()), ($this->services['sulu_tag.tag_manager'] ?? $this->getSuluTag_TagManagerService()), ($this->privates['sulu_media.type_manager'] ?? $this->getSuluMedia_TypeManagerService()), ($this->services['sulu.content.path_cleaner'] ?? $this->getSulu_Content_PathCleanerService()), ($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->services['sulu_security.security_checker'] ?? $this->getSuluSecurity_SecurityCheckerService()), NULL, $this->parameters['sulu_security.permissions'], '/media/{id}/download/{slug}', '16MB', ($this->services['sulu.repository.target_group'] ?? $this->getSulu_Repository_TargetGroupService()));
    }

    /**
     * Gets the public 'sulu_media.storage' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\Storage\LocalStorage
     */
    protected function getSuluMedia_StorageService()
    {
        return $this->services['sulu_media.storage'] = new \Sulu\Bundle\MediaBundle\Media\Storage\LocalStorage(($this->targetDirs[3].'/uploads/media'), 10, ($this->privates['sulu_media.storage.local.file_system'] ?? ($this->privates['sulu_media.storage.local.file_system'] = new \Symfony\Component\Filesystem\Filesystem())), ($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /**
     * Gets the public 'sulu_media.system_collections.manager' shared service.
     *
     * @return \Sulu\Component\Media\SystemCollections\SystemCollectionManager
     */
    protected function getSuluMedia_SystemCollections_ManagerService()
    {
        return $this->services['sulu_media.system_collections.manager'] = new \Sulu\Component\Media\SystemCollections\SystemCollectionManager($this->parameters['sulu_media.system_collections'], ($this->services['sulu_media.collection_manager'] ?? $this->getSuluMedia_CollectionManagerService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->privates['sulu_media.system_collections.cache'] ?? ($this->privates['sulu_media.system_collections.cache'] = new \Sulu\Component\Cache\DataCache(($this->targetDirs[0].'/sulu/system_collection.cache')))), 'en');
    }

    /**
     * Gets the public 'sulu_page.compat.structure.legacy_property_factory' shared service.
     *
     * @return \Sulu\Component\Content\Compat\Structure\LegacyPropertyFactory
     */
    protected function getSuluPage_Compat_Structure_LegacyPropertyFactoryService()
    {
        return $this->services['sulu_page.compat.structure.legacy_property_factory'] = new \Sulu\Component\Content\Compat\Structure\LegacyPropertyFactory(($this->privates['sulu_document_manager.namespace_registry'] ?? $this->getSuluDocumentManager_NamespaceRegistryService()));
    }

    /**
     * Gets the public 'sulu_page.content_repository' shared service.
     *
     * @return \Sulu\Component\Content\Repository\ContentRepository
     */
    protected function getSuluPage_ContentRepositoryService()
    {
        return $this->services['sulu_page.content_repository'] = new \Sulu\Component\Content\Repository\ContentRepository(($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->services['sulu_document_manager.property_encoder'] ?? $this->getSuluDocumentManager_PropertyEncoderService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), ($this->services['sulu.content.localization_finder'] ?? $this->getSulu_Content_LocalizationFinderService()), ($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu.util.node_helper'] ?? $this->getSulu_Util_NodeHelperService()), $this->parameters['sulu_security.permissions']);
    }

    /**
     * Gets the public 'sulu_page.controller_name_converter' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser
     */
    protected function getSuluPage_ControllerNameConverterService()
    {
        return $this->services['sulu_page.controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel', 1)));
    }

    /**
     * Gets the public 'sulu_page.extension.manager' shared service.
     *
     * @return \Sulu\Component\Content\Extension\ExtensionManager
     */
    protected function getSuluPage_Extension_ManagerService()
    {
        $this->services['sulu_page.extension.manager'] = $instance = new \Sulu\Component\Content\Extension\ExtensionManager();

        $instance->addExtension(($this->privates['sulu_page.extension.seo'] ?? ($this->privates['sulu_page.extension.seo'] = new \Sulu\Bundle\PageBundle\Content\Structure\SeoStructureExtension())));
        $instance->addExtension(($this->privates['sulu_page.extension.excerpt'] ?? $this->getSuluPage_Extension_ExcerptService()));

        return $instance;
    }

    /**
     * Gets the public 'sulu_page.structure.factory' shared service.
     *
     * @return \Sulu\Component\Content\Metadata\Factory\StructureMetadataFactory
     */
    protected function getSuluPage_Structure_FactoryService()
    {
        return $this->services['sulu_page.structure.factory'] = new \Sulu\Component\Content\Metadata\Factory\StructureMetadataFactory(($this->privates['sulu_page.structure.loader.xml'] ?? $this->getSuluPage_Structure_Loader_XmlService()), $this->getParameter('sulu.content.structure.paths'), $this->parameters['sulu.content.structure.default_types'], ($this->targetDirs[0].'/sulu/structures'), true);
    }

    /**
     * Gets the public 'sulu_security.security_checker' shared service.
     *
     * @return \Sulu\Component\Security\Authorization\SecurityChecker
     */
    protected function getSuluSecurity_SecurityCheckerService()
    {
        return $this->services['sulu_security.security_checker'] = new \Sulu\Component\Security\Authorization\SecurityChecker(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService()));
    }

    /**
     * Gets the public 'sulu_snippet.default_snippet.manager' shared service.
     *
     * @return \Sulu\Bundle\SnippetBundle\Snippet\DefaultSnippetManager
     */
    protected function getSuluSnippet_DefaultSnippet_ManagerService()
    {
        return $this->services['sulu_snippet.default_snippet.manager'] = new \Sulu\Bundle\SnippetBundle\Snippet\DefaultSnippetManager(($this->privates['sulu_core.webspace.settings_manager'] ?? $this->getSuluCore_Webspace_SettingsManagerService()), ($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), ($this->privates['sulu_document_manager.document_registry'] ?? ($this->privates['sulu_document_manager.document_registry'] = new \Sulu\Component\DocumentManager\DocumentRegistry('en'))), []);
    }

    /**
     * Gets the public 'sulu_snippet.resolver' shared service.
     *
     * @return \Sulu\Bundle\SnippetBundle\Snippet\SnippetResolver
     */
    protected function getSuluSnippet_ResolverService()
    {
        return $this->services['sulu_snippet.resolver'] = new \Sulu\Bundle\SnippetBundle\Snippet\SnippetResolver(($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->services['sulu_website.resolver.structure'] ?? $this->getSuluWebsite_Resolver_StructureService()));
    }

    /**
     * Gets the public 'sulu_tag.tag_manager' shared service.
     *
     * @return \Sulu\Bundle\TagBundle\Tag\TagManager
     */
    protected function getSuluTag_TagManagerService()
    {
        return $this->services['sulu_tag.tag_manager'] = new \Sulu\Bundle\TagBundle\Tag\TagManager(($this->services['sulu.repository.tag'] ?? $this->getSulu_Repository_TagService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));
    }

    /**
     * Gets the public 'sulu_test.doctrine_phpcr.default_session' shared service.
     *
     * @return \Sulu\Bundle\DocumentManagerBundle\Session\Session
     */
    protected function getSuluTest_DoctrinePhpcr_DefaultSessionService()
    {
        return $this->services['sulu_test.doctrine_phpcr.default_session'] = new \Sulu\Bundle\DocumentManagerBundle\Session\Session(($this->privates['sulu_document_manager.decorated_default_session.inner'] ?? $this->getSuluDocumentManager_DecoratedDefaultSession_InnerService()));
    }

    /**
     * Gets the public 'sulu_test.doctrine_phpcr.live_session' shared service.
     *
     * @return \Sulu\Bundle\DocumentManagerBundle\Session\Session
     */
    protected function getSuluTest_DoctrinePhpcr_LiveSessionService()
    {
        return $this->services['sulu_test.doctrine_phpcr.live_session'] = new \Sulu\Bundle\DocumentManagerBundle\Session\Session(($this->privates['sulu_document_manager.decorated_live_session.inner'] ?? $this->getSuluDocumentManager_DecoratedLiveSession_InnerService()));
    }

    /**
     * Gets the public 'sulu_website.resolver.structure' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Resolver\StructureResolver
     */
    protected function getSuluWebsite_Resolver_StructureService()
    {
        return $this->services['sulu_website.resolver.structure'] = new \Sulu\Bundle\WebsiteBundle\Resolver\StructureResolver(($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()), ($this->services['sulu_page.extension.manager'] ?? $this->getSuluPage_Extension_ManagerService()));
    }

    /**
     * Gets the public 'translator' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Translator\RequestLocaleTranslator
     */
    protected function getTranslatorService()
    {
        return $this->services['translator'] = new \Sulu\Bundle\WebsiteBundle\Translator\RequestLocaleTranslator(($this->privates['translator.data_collector'] ?? $this->getTranslator_DataCollectorService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the public 'twig' shared service.
     *
     * @return \Twig\Environment
     */
    protected function getTwigService()
    {
        $this->services['twig'] = $instance = new \Twig\Environment(($this->privates['twig.loader.filesystem'] ?? $this->getTwig_Loader_FilesystemService()), ['exception_controller' => 'sulu_website.exception.controller:showAction', 'form_themes' => $this->parameters['twig.form.resources'], 'autoescape' => 'name', 'cache' => ($this->targetDirs[0].'/twig'), 'charset' => 'UTF-8', 'debug' => true, 'strict_variables' => false, 'default_path' => ($this->targetDirs[4].'/templates'), 'paths' => [], 'date' => ['format' => 'F j, Y H:i', 'interval_format' => '%d days', 'timezone' => NULL], 'number_format' => ['decimals' => 0, 'decimal_point' => '.', 'thousands_separator' => ',']]);

        $instance->addExtension(($this->privates['twig.extension.security_csrf'] ?? ($this->privates['twig.extension.security_csrf'] = new \Symfony\Bridge\Twig\Extension\CsrfExtension())));
        $instance->addExtension(($this->privates['twig.extension.profiler'] ?? $this->getTwig_Extension_ProfilerService()));
        $instance->addExtension(($this->privates['twig.extension.trans'] ?? $this->getTwig_Extension_TransService()));
        $instance->addExtension(($this->privates['twig.extension.assets'] ?? $this->getTwig_Extension_AssetsService()));
        $instance->addExtension(($this->privates['twig.extension.code'] ?? $this->getTwig_Extension_CodeService()));
        $instance->addExtension(($this->privates['twig.extension.routing'] ?? $this->getTwig_Extension_RoutingService()));
        $instance->addExtension(($this->privates['twig.extension.yaml'] ?? ($this->privates['twig.extension.yaml'] = new \Symfony\Bridge\Twig\Extension\YamlExtension())));
        $instance->addExtension(($this->privates['twig.extension.debug.stopwatch'] ?? $this->getTwig_Extension_Debug_StopwatchService()));
        $instance->addExtension(($this->privates['twig.extension.expression'] ?? ($this->privates['twig.extension.expression'] = new \Symfony\Bridge\Twig\Extension\ExpressionExtension())));
        $instance->addExtension(($this->privates['twig.extension.httpkernel'] ?? ($this->privates['twig.extension.httpkernel'] = new \Symfony\Bridge\Twig\Extension\HttpKernelExtension())));
        $instance->addExtension(($this->privates['twig.extension.httpfoundation'] ?? $this->getTwig_Extension_HttpfoundationService()));
        $instance->addExtension(($this->privates['twig.extension.weblink'] ?? $this->getTwig_Extension_WeblinkService()));
        $instance->addExtension(($this->privates['twig.extension.form'] ?? ($this->privates['twig.extension.form'] = new \Symfony\Bridge\Twig\Extension\FormExtension([0 => $this, 1 => 'twig.form.renderer']))));
        $instance->addExtension(($this->privates['twig.extension.logout_url'] ?? $this->getTwig_Extension_LogoutUrlService()));
        $instance->addExtension(($this->privates['twig.extension.security'] ?? $this->getTwig_Extension_SecurityService()));
        $instance->addExtension(($this->privates['sulu_form.twig_extension'] ?? $this->getSuluForm_TwigExtensionService()));
        $instance->addExtension(($this->privates['twig.extension.debug'] ?? ($this->privates['twig.extension.debug'] = new \Twig\Extension\DebugExtension())));
        $instance->addExtension(($this->privates['doctrine.twig.doctrine_extension'] ?? ($this->privates['doctrine.twig.doctrine_extension'] = new \Doctrine\Bundle\DoctrineBundle\Twig\DoctrineExtension())));
        $instance->addExtension(($this->privates['jms_serializer.twig_extension.serializer'] ?? ($this->privates['jms_serializer.twig_extension.serializer'] = new \JMS\Serializer\Twig\SerializerRuntimeExtension())));
        $instance->addExtension(($this->privates['sulu_page.export_twig_extension'] ?? $this->getSuluPage_ExportTwigExtensionService()));
        $instance->addExtension(($this->privates['sulu_contact.twig'] ?? $this->getSuluContact_TwigService()));
        $instance->addExtension(($this->privates['sulu_security.twig_extension.user'] ?? $this->getSuluSecurity_TwigExtension_UserService()));
        $instance->addExtension(($this->privates['sulu_website.twig.content_path'] ?? $this->getSuluWebsite_Twig_ContentPathService()));
        $instance->addExtension(($this->privates['sulu_website.twig.navigation.memoized'] ?? $this->getSuluWebsite_Twig_Navigation_MemoizedService()));
        $instance->addExtension(($this->privates['sulu_website.twig.sitemap.memoized'] ?? $this->getSuluWebsite_Twig_Sitemap_MemoizedService()));
        $instance->addExtension(($this->privates['sulu_website.twig.content.memoized'] ?? $this->getSuluWebsite_Twig_Content_MemoizedService()));
        $instance->addExtension(($this->privates['sulu_website.twig.meta'] ?? $this->getSuluWebsite_Twig_MetaService()));
        $instance->addExtension(($this->privates['sulu_website.twig.seo'] ?? $this->getSuluWebsite_Twig_SeoService()));
        $instance->addExtension(($this->privates['sulu_website.twig.util'] ?? ($this->privates['sulu_website.twig.util'] = new \Sulu\Bundle\WebsiteBundle\Twig\Core\UtilTwigExtension())));
        $instance->addExtension(($this->privates['sulu_tag.twig_extension'] ?? $this->getSuluTag_TwigExtensionService()));
        $instance->addExtension(($this->privates['sulu_media.twig_extension.disposition_type'] ?? ($this->privates['sulu_media.twig_extension.disposition_type'] = new \Sulu\Bundle\MediaBundle\Twig\DispositionTypeTwigExtension())));
        $instance->addExtension(($this->privates['sulu_media.twig_extension.media'] ?? $this->getSuluMedia_TwigExtension_MediaService()));
        $instance->addExtension(($this->privates['sulu_category.twig_extension'] ?? $this->getSuluCategory_TwigExtensionService()));
        $instance->addExtension(($this->privates['sulu_snippet.twig.snippet.memoized'] ?? $this->getSuluSnippet_Twig_Snippet_MemoizedService()));
        $instance->addExtension(($this->privates['sulu_snippet.twig.default_snippet'] ?? $this->getSuluSnippet_Twig_DefaultSnippetService()));
        $instance->addExtension(($this->privates['sulu_snippet.twig.area_snippet'] ?? $this->getSuluSnippet_Twig_AreaSnippetService()));
        $instance->addExtension(($this->privates['hateoas.twig.link'] ?? $this->getHateoas_Twig_LinkService()));
        $instance->addGlobal('app', ($this->privates['twig.app_variable'] ?? $this->getTwig_AppVariableService()));
        $instance->addRuntimeLoader(($this->privates['twig.runtime_loader'] ?? $this->getTwig_RuntimeLoaderService()));
        ($this->privates['twig.configurator.environment'] ?? $this->getTwig_Configurator_EnvironmentService())->configure($instance);

        return $instance;
    }

    /**
     * Gets the public 'validator' shared service.
     *
     * @return \Symfony\Component\Validator\Validator\TraceableValidator
     */
    protected function getValidatorService()
    {
        return $this->services['validator'] = new \Symfony\Component\Validator\Validator\TraceableValidator(($this->privates['debug.validator.inner'] ?? $this->getDebug_Validator_InnerService()));
    }

    /**
     * Gets the private '.service_locator.9_yeNH1' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    protected function get_ServiceLocator_9YeNH1Service()
    {
        return $this->privates['.service_locator.9_yeNH1'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [], []);
    }

    /**
     * Gets the private 'annotations.cached_reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\CachedReader
     */
    protected function getAnnotations_CachedReaderService()
    {
        return $this->privates['annotations.cached_reader'] = new \Doctrine\Common\Annotations\CachedReader(($this->privates['annotations.reader'] ?? $this->getAnnotations_ReaderService()), ($this->privates['annotations.cache'] ?? $this->load('getAnnotations_CacheService.php')), true);
    }

    /**
     * Gets the private 'annotations.dummy_registry' shared service.
     *
     * @return \Doctrine\Common\Annotations\AnnotationRegistry
     */
    protected function getAnnotations_DummyRegistryService()
    {
        $this->privates['annotations.dummy_registry'] = $instance = new \Doctrine\Common\Annotations\AnnotationRegistry();

        $instance->registerUniqueLoader('class_exists');

        return $instance;
    }

    /**
     * Gets the private 'annotations.reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    protected function getAnnotations_ReaderService()
    {
        $this->privates['annotations.reader'] = $instance = new \Doctrine\Common\Annotations\AnnotationReader();

        $instance->addGlobalIgnoredName('required', ($this->privates['annotations.dummy_registry'] ?? $this->getAnnotations_DummyRegistryService()));

        return $instance;
    }

    /**
     * Gets the private 'argument_metadata_factory' shared service.
     *
     * @return \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory
     */
    protected function getArgumentMetadataFactoryService()
    {
        return $this->privates['argument_metadata_factory'] = new \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory();
    }

    /**
     * Gets the private 'assets._default_package' shared service.
     *
     * @return \Symfony\Component\Asset\PathPackage
     */
    protected function getAssets_DefaultPackageService()
    {
        return $this->privates['assets._default_package'] = new \Symfony\Component\Asset\PathPackage('', ($this->privates['assets.empty_version_strategy'] ?? ($this->privates['assets.empty_version_strategy'] = new \Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy())), ($this->privates['assets.context'] ?? $this->getAssets_ContextService()));
    }

    /**
     * Gets the private 'assets._package_sulu_admin' shared service.
     *
     * @return \Symfony\Component\Asset\PathPackage
     */
    protected function getAssets_PackageSuluAdminService()
    {
        return $this->privates['assets._package_sulu_admin'] = new \Symfony\Component\Asset\PathPackage('', ($this->privates['assets._version_sulu_admin'] ?? ($this->privates['assets._version_sulu_admin'] = new \Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy(($this->targetDirs[4].'/public/build/admin/manifest.json')))), ($this->privates['assets.context'] ?? $this->getAssets_ContextService()));
    }

    /**
     * Gets the private 'assets._version_sulu_admin' shared service.
     *
     * @return \Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy
     */
    protected function getAssets_VersionSuluAdminService()
    {
        return $this->privates['assets._version_sulu_admin'] = new \Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy(($this->targetDirs[4].'/public/build/admin/manifest.json'));
    }

    /**
     * Gets the private 'assets.context' shared service.
     *
     * @return \Symfony\Component\Asset\Context\RequestStackContext
     */
    protected function getAssets_ContextService()
    {
        return $this->privates['assets.context'] = new \Symfony\Component\Asset\Context\RequestStackContext(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), '', false);
    }

    /**
     * Gets the private 'assets.empty_version_strategy' shared service.
     *
     * @return \Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy
     */
    protected function getAssets_EmptyVersionStrategyService()
    {
        return $this->privates['assets.empty_version_strategy'] = new \Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy();
    }

    /**
     * Gets the private 'assets.packages' shared service.
     *
     * @return \Symfony\Component\Asset\Packages
     */
    protected function getAssets_PackagesService()
    {
        return $this->privates['assets.packages'] = new \Symfony\Component\Asset\Packages(($this->privates['assets._default_package'] ?? $this->getAssets_DefaultPackageService()), ['sulu_admin' => ($this->privates['assets._package_sulu_admin'] ?? $this->getAssets_PackageSuluAdminService())]);
    }

    /**
     * Gets the private 'bazinga_hateoas.expression_language' shared service.
     *
     * @return \Bazinga\Bundle\HateoasBundle\ExpressionLanguage\ExpressionLanguage
     */
    protected function getBazingaHateoas_ExpressionLanguageService()
    {
        return $this->privates['bazinga_hateoas.expression_language'] = new \Bazinga\Bundle\HateoasBundle\ExpressionLanguage\ExpressionLanguage();
    }

    /**
     * Gets the private 'cache.annotations' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_AnnotationsService()
    {
        return $this->privates['cache.annotations'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.annotations.recorder_inner'] ?? $this->getCache_Annotations_RecorderInnerService()));
    }

    /**
     * Gets the private 'cache.annotations.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_Annotations_RecorderInnerService()
    {
        return $this->privates['cache.annotations.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('4CMHcFQRTg', 0, $this->getParameter('container.build_id'), ($this->targetDirs[0].'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /**
     * Gets the private 'cache.app.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    protected function getCache_App_RecorderInnerService()
    {
        $this->privates['cache.app.recorder_inner'] = $instance = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('uHJTC0lX+4', 0, ($this->targetDirs[0].'/pools'), ($this->privates['cache.default_marshaller'] ?? ($this->privates['cache.default_marshaller'] = new \Symfony\Component\Cache\Marshaller\DefaultMarshaller(NULL))));

        $instance->setLogger(($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));

        return $instance;
    }

    /**
     * Gets the private 'cache.default_marshaller' shared service.
     *
     * @return \Symfony\Component\Cache\Marshaller\DefaultMarshaller
     */
    protected function getCache_DefaultMarshallerService()
    {
        return $this->privates['cache.default_marshaller'] = new \Symfony\Component\Cache\Marshaller\DefaultMarshaller(NULL);
    }

    /**
     * Gets the private 'cache.messenger.restart_workers_signal' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_Messenger_RestartWorkersSignalService()
    {
        return $this->privates['cache.messenger.restart_workers_signal'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.messenger.restart_workers_signal.recorder_inner'] ?? $this->getCache_Messenger_RestartWorkersSignal_RecorderInnerService()));
    }

    /**
     * Gets the private 'cache.messenger.restart_workers_signal.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    protected function getCache_Messenger_RestartWorkersSignal_RecorderInnerService()
    {
        $this->privates['cache.messenger.restart_workers_signal.recorder_inner'] = $instance = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('rM-pwBmKzb', 0, ($this->targetDirs[0].'/pools'), ($this->privates['cache.default_marshaller'] ?? ($this->privates['cache.default_marshaller'] = new \Symfony\Component\Cache\Marshaller\DefaultMarshaller(NULL))));

        $instance->setLogger(($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));

        return $instance;
    }

    /**
     * Gets the private 'cache.property_info' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_PropertyInfoService()
    {
        return $this->privates['cache.property_info'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.property_info.recorder_inner'] ?? $this->getCache_PropertyInfo_RecorderInnerService()));
    }

    /**
     * Gets the private 'cache.property_info.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_PropertyInfo_RecorderInnerService()
    {
        return $this->privates['cache.property_info.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('VvNzG7g1g9', 0, $this->getParameter('container.build_id'), ($this->targetDirs[0].'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /**
     * Gets the private 'cache.security_expression_language' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_SecurityExpressionLanguageService()
    {
        return $this->privates['cache.security_expression_language'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.security_expression_language.recorder_inner'] ?? $this->getCache_SecurityExpressionLanguage_RecorderInnerService()));
    }

    /**
     * Gets the private 'cache.security_expression_language.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_SecurityExpressionLanguage_RecorderInnerService()
    {
        return $this->privates['cache.security_expression_language.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('Hb58jFKgSn', 0, $this->getParameter('container.build_id'), ($this->targetDirs[0].'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /**
     * Gets the private 'cache.serializer' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_SerializerService()
    {
        return $this->privates['cache.serializer'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.serializer.recorder_inner'] ?? $this->getCache_Serializer_RecorderInnerService()));
    }

    /**
     * Gets the private 'cache.serializer.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_Serializer_RecorderInnerService()
    {
        return $this->privates['cache.serializer.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('kR2TyCqWl0', 0, $this->getParameter('container.build_id'), ($this->targetDirs[0].'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /**
     * Gets the private 'cache.system.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_System_RecorderInnerService()
    {
        return $this->privates['cache.system.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('NysTH0zi1M', 0, $this->getParameter('container.build_id'), ($this->targetDirs[0].'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /**
     * Gets the private 'cache.validator' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\TraceableAdapter
     */
    protected function getCache_ValidatorService()
    {
        return $this->privates['cache.validator'] = new \Symfony\Component\Cache\Adapter\TraceableAdapter(($this->privates['cache.validator.recorder_inner'] ?? $this->getCache_Validator_RecorderInnerService()));
    }

    /**
     * Gets the private 'cache.validator.recorder_inner' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_Validator_RecorderInnerService()
    {
        return $this->privates['cache.validator.recorder_inner'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('UK2e8f0p1V', 0, $this->getParameter('container.build_id'), ($this->targetDirs[0].'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /**
     * Gets the private 'config_cache_factory' shared service.
     *
     * @return \Symfony\Component\Config\ResourceCheckerConfigCacheFactory
     */
    protected function getConfigCacheFactoryService()
    {
        return $this->privates['config_cache_factory'] = new \Symfony\Component\Config\ResourceCheckerConfigCacheFactory(new RewindableGenerator(function () {
            yield 0 => ($this->privates['dependency_injection.config.container_parameters_resource_checker'] ?? ($this->privates['dependency_injection.config.container_parameters_resource_checker'] = new \Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker($this)));
            yield 1 => ($this->privates['config.resource.self_checking_resource_checker'] ?? ($this->privates['config.resource.self_checking_resource_checker'] = new \Symfony\Component\Config\Resource\SelfCheckingResourceChecker()));
        }, 2));
    }

    /**
     * Gets the private 'data_collector.ajax' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector
     */
    protected function getDataCollector_AjaxService()
    {
        return $this->privates['data_collector.ajax'] = new \Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector();
    }

    /**
     * Gets the private 'data_collector.cache' shared service.
     *
     * @return \Symfony\Component\Cache\DataCollector\CacheDataCollector
     */
    protected function getDataCollector_CacheService()
    {
        $this->privates['data_collector.cache'] = $instance = new \Symfony\Component\Cache\DataCollector\CacheDataCollector();

        $instance->addInstance('cache.app', ($this->services['cache.app'] ?? $this->getCache_AppService()));
        $instance->addInstance('cache.system', ($this->services['cache.system'] ?? $this->getCache_SystemService()));
        $instance->addInstance('cache.validator', ($this->privates['cache.validator'] ?? $this->getCache_ValidatorService()));
        $instance->addInstance('cache.serializer', ($this->privates['cache.serializer'] ?? $this->getCache_SerializerService()));
        $instance->addInstance('cache.annotations', ($this->privates['cache.annotations'] ?? $this->getCache_AnnotationsService()));
        $instance->addInstance('cache.property_info', ($this->privates['cache.property_info'] ?? $this->getCache_PropertyInfoService()));
        $instance->addInstance('cache.messenger.restart_workers_signal', ($this->privates['cache.messenger.restart_workers_signal'] ?? $this->getCache_Messenger_RestartWorkersSignalService()));
        $instance->addInstance('cache.security_expression_language', ($this->privates['cache.security_expression_language'] ?? $this->getCache_SecurityExpressionLanguageService()));

        return $instance;
    }

    /**
     * Gets the private 'data_collector.config' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector
     */
    protected function getDataCollector_ConfigService()
    {
        $this->privates['data_collector.config'] = $instance = new \Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector();

        if ($this->has('kernel')) {
            $instance->setKernel(($this->services['kernel'] ?? $this->get('kernel', 3)));
        }

        return $instance;
    }

    /**
     * Gets the private 'data_collector.doctrine' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\DataCollector\DoctrineDataCollector
     */
    protected function getDataCollector_DoctrineService()
    {
        $this->privates['data_collector.doctrine'] = $instance = new \Doctrine\Bundle\DoctrineBundle\DataCollector\DoctrineDataCollector(($this->services['doctrine'] ?? $this->getDoctrineService()));

        $instance->addLogger('default', ($this->privates['doctrine.dbal.logger.profiling.default'] ?? ($this->privates['doctrine.dbal.logger.profiling.default'] = new \Doctrine\DBAL\Logging\DebugStack())));

        return $instance;
    }

    /**
     * Gets the private 'data_collector.events' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\EventDataCollector
     */
    protected function getDataCollector_EventsService()
    {
        return $this->privates['data_collector.events'] = new \Symfony\Component\HttpKernel\DataCollector\EventDataCollector(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'data_collector.exception' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector
     */
    protected function getDataCollector_ExceptionService()
    {
        return $this->privates['data_collector.exception'] = new \Symfony\Component\HttpKernel\DataCollector\ExceptionDataCollector();
    }

    /**
     * Gets the private 'data_collector.form' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\FormDataCollector
     */
    protected function getDataCollector_FormService()
    {
        return $this->privates['data_collector.form'] = new \Symfony\Component\Form\Extension\DataCollector\FormDataCollector(($this->privates['data_collector.form.extractor'] ?? ($this->privates['data_collector.form.extractor'] = new \Symfony\Component\Form\Extension\DataCollector\FormDataExtractor())));
    }

    /**
     * Gets the private 'data_collector.form.extractor' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\FormDataExtractor
     */
    protected function getDataCollector_Form_ExtractorService()
    {
        return $this->privates['data_collector.form.extractor'] = new \Symfony\Component\Form\Extension\DataCollector\FormDataExtractor();
    }

    /**
     * Gets the private 'data_collector.logger' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector
     */
    protected function getDataCollector_LoggerService()
    {
        return $this->privates['data_collector.logger'] = new \Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector(($this->privates['monolog.logger.profiler'] ?? $this->getMonolog_Logger_ProfilerService()), ($this->targetDirs[0].'/adminAdminTestDebugProjectContainer'), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'data_collector.memory' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector
     */
    protected function getDataCollector_MemoryService()
    {
        return $this->privates['data_collector.memory'] = new \Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector();
    }

    /**
     * Gets the private 'data_collector.request' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\RequestDataCollector
     */
    protected function getDataCollector_RequestService()
    {
        return $this->privates['data_collector.request'] = new \Symfony\Component\HttpKernel\DataCollector\RequestDataCollector();
    }

    /**
     * Gets the private 'data_collector.router' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector
     */
    protected function getDataCollector_RouterService()
    {
        return $this->privates['data_collector.router'] = new \Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector();
    }

    /**
     * Gets the private 'data_collector.security' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\DataCollector\SecurityDataCollector
     */
    protected function getDataCollector_SecurityService()
    {
        return $this->privates['data_collector.security'] = new \Symfony\Bundle\SecurityBundle\DataCollector\SecurityDataCollector(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->privates['security.role_hierarchy'] ?? ($this->privates['security.role_hierarchy'] = new \Symfony\Component\Security\Core\Role\RoleHierarchy([]))), ($this->privates['security.logout_url_generator'] ?? $this->getSecurity_LogoutUrlGeneratorService()), ($this->privates['debug.security.access.decision_manager'] ?? $this->getDebug_Security_Access_DecisionManagerService()), ($this->privates['security.firewall.map'] ?? $this->getSecurity_Firewall_MapService()), ($this->privates['debug.security.firewall'] ?? $this->getDebug_Security_FirewallService()));
    }

    /**
     * Gets the private 'data_collector.time' shared service.
     *
     * @return \Symfony\Component\HttpKernel\DataCollector\TimeDataCollector
     */
    protected function getDataCollector_TimeService()
    {
        return $this->privates['data_collector.time'] = new \Symfony\Component\HttpKernel\DataCollector\TimeDataCollector(($this->services['kernel'] ?? $this->get('kernel', 3)), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'data_collector.translation' shared service.
     *
     * @return \Symfony\Component\Translation\DataCollector\TranslationDataCollector
     */
    protected function getDataCollector_TranslationService()
    {
        return $this->privates['data_collector.translation'] = new \Symfony\Component\Translation\DataCollector\TranslationDataCollector(($this->privates['translator.data_collector'] ?? $this->getTranslator_DataCollectorService()));
    }

    /**
     * Gets the private 'data_collector.twig' shared service.
     *
     * @return \Symfony\Bridge\Twig\DataCollector\TwigDataCollector
     */
    protected function getDataCollector_TwigService()
    {
        return $this->privates['data_collector.twig'] = new \Symfony\Bridge\Twig\DataCollector\TwigDataCollector(($this->privates['twig.profile'] ?? ($this->privates['twig.profile'] = new \Twig\Profiler\Profile())), ($this->services['twig'] ?? $this->getTwigService()));
    }

    /**
     * Gets the private 'data_collector.validator' shared service.
     *
     * @return \Symfony\Component\Validator\DataCollector\ValidatorDataCollector
     */
    protected function getDataCollector_ValidatorService()
    {
        return $this->privates['data_collector.validator'] = new \Symfony\Component\Validator\DataCollector\ValidatorDataCollector(($this->services['validator'] ?? $this->getValidatorService()));
    }

    /**
     * Gets the private 'debug.argument_resolver' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\TraceableArgumentResolver
     */
    protected function getDebug_ArgumentResolverService()
    {
        return $this->privates['debug.argument_resolver'] = new \Symfony\Component\HttpKernel\Controller\TraceableArgumentResolver(($this->privates['debug.argument_resolver.inner'] ?? $this->getDebug_ArgumentResolver_InnerService()), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'debug.argument_resolver.inner' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\ArgumentResolver
     */
    protected function getDebug_ArgumentResolver_InnerService()
    {
        return $this->privates['debug.argument_resolver.inner'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver(($this->privates['argument_metadata_factory'] ?? ($this->privates['argument_metadata_factory'] = new \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory())), new RewindableGenerator(function () {
            yield 0 => ($this->privates['debug.argument_resolver.request_attribute'] ?? $this->load('getDebug_ArgumentResolver_RequestAttributeService.php'));
            yield 1 => ($this->privates['debug.argument_resolver.request'] ?? $this->load('getDebug_ArgumentResolver_RequestService.php'));
            yield 2 => ($this->privates['debug.argument_resolver.session'] ?? $this->load('getDebug_ArgumentResolver_SessionService.php'));
            yield 3 => ($this->privates['debug.security.user_value_resolver'] ?? $this->load('getDebug_Security_UserValueResolverService.php'));
            yield 4 => ($this->privates['debug.argument_resolver.service'] ?? $this->load('getDebug_ArgumentResolver_ServiceService.php'));
            yield 5 => ($this->privates['debug.argument_resolver.default'] ?? $this->load('getDebug_ArgumentResolver_DefaultService.php'));
            yield 6 => ($this->privates['debug.argument_resolver.variadic'] ?? $this->load('getDebug_ArgumentResolver_VariadicService.php'));
            yield 7 => ($this->privates['debug.argument_resolver.not_tagged_controller'] ?? $this->load('getDebug_ArgumentResolver_NotTaggedControllerService.php'));
        }, 8));
    }

    /**
     * Gets the private 'debug.controller_resolver' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Controller\TraceableControllerResolver
     */
    protected function getDebug_ControllerResolverService()
    {
        return $this->privates['debug.controller_resolver'] = new \Symfony\Component\HttpKernel\Controller\TraceableControllerResolver(($this->privates['debug.controller_resolver.inner'] ?? $this->getDebug_ControllerResolver_InnerService()), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'debug.controller_resolver.inner' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver
     */
    protected function getDebug_ControllerResolver_InnerService()
    {
        return $this->privates['debug.controller_resolver.inner'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver($this, ($this->services['sulu_page.controller_name_converter'] ?? ($this->services['sulu_page.controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel', 1))))), ($this->privates['monolog.logger.request'] ?? $this->getMonolog_Logger_RequestService()));
    }

    /**
     * Gets the private 'debug.debug_handlers_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener
     */
    protected function getDebug_DebugHandlersListenerService()
    {
        return $this->privates['debug.debug_handlers_listener'] = new \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener(NULL, ($this->privates['monolog.logger.php'] ?? $this->getMonolog_Logger_PhpService()), NULL, -1, true, ($this->privates['debug.file_link_formatter'] ?? ($this->privates['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL))), true, 'UTF-8');
    }

    /**
     * Gets the private 'debug.event_dispatcher.inner' shared service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getDebug_EventDispatcher_InnerService()
    {
        return $this->privates['debug.event_dispatcher.inner'] = new \Symfony\Component\EventDispatcher\EventDispatcher();
    }

    /**
     * Gets the private 'debug.file_link_formatter' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Debug\FileLinkFormatter
     */
    protected function getDebug_FileLinkFormatterService()
    {
        return $this->privates['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL);
    }

    /**
     * Gets the private 'debug.log_processor' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Processor\DebugProcessor
     */
    protected function getDebug_LogProcessorService()
    {
        return $this->privates['debug.log_processor'] = new \Symfony\Bridge\Monolog\Processor\DebugProcessor(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'debug.security.access.decision_manager' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\TraceableAccessDecisionManager
     */
    protected function getDebug_Security_Access_DecisionManagerService()
    {
        return $this->privates['debug.security.access.decision_manager'] = new \Symfony\Component\Security\Core\Authorization\TraceableAccessDecisionManager(($this->privates['debug.security.access.decision_manager.inner'] ?? $this->getDebug_Security_Access_DecisionManager_InnerService()));
    }

    /**
     * Gets the private 'debug.security.access.decision_manager.inner' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\AccessDecisionManager
     */
    protected function getDebug_Security_Access_DecisionManager_InnerService()
    {
        return $this->privates['debug.security.access.decision_manager.inner'] = new \Symfony\Component\Security\Core\Authorization\AccessDecisionManager(new RewindableGenerator(function () {
            yield 0 => ($this->privates['debug.security.voter.security.access.authenticated_voter'] ?? $this->load('getDebug_Security_Voter_Security_Access_AuthenticatedVoterService.php'));
            yield 1 => ($this->privates['debug.security.voter.security.access.simple_role_voter'] ?? $this->load('getDebug_Security_Voter_Security_Access_SimpleRoleVoterService.php'));
            yield 2 => ($this->privates['debug.security.voter.security.access.expression_voter'] ?? $this->load('getDebug_Security_Voter_Security_Access_ExpressionVoterService.php'));
            yield 3 => ($this->privates['debug.security.voter.sulu_security.security_context_voter'] ?? $this->load('getDebug_Security_Voter_SuluSecurity_SecurityContextVoterService.php'));
            yield 4 => ($this->privates['debug.security.voter.test_voter'] ?? $this->load('getDebug_Security_Voter_TestVoterService.php'));
        }, 5), 'affirmative', false, true);
    }

    /**
     * Gets the private 'debug.security.firewall' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Debug\TraceableFirewallListener
     */
    protected function getDebug_Security_FirewallService()
    {
        return $this->privates['debug.security.firewall'] = new \Symfony\Bundle\SecurityBundle\Debug\TraceableFirewallListener(($this->privates['security.firewall.map'] ?? $this->getSecurity_Firewall_MapService()), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->privates['security.logout_url_generator'] ?? $this->getSecurity_LogoutUrlGeneratorService()));
    }

    /**
     * Gets the private 'debug.stopwatch' shared service.
     *
     * @return \Symfony\Component\Stopwatch\Stopwatch
     */
    protected function getDebug_StopwatchService()
    {
        return $this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true);
    }

    /**
     * Gets the private 'debug.validator.inner' shared service.
     *
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected function getDebug_Validator_InnerService()
    {
        return $this->privates['debug.validator.inner'] = ($this->privates['validator.builder'] ?? $this->getValidator_BuilderService())->getValidator();
    }

    /**
     * Gets the private 'disallow_search_engine_index_response_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\DisallowRobotsIndexingListener
     */
    protected function getDisallowSearchEngineIndexResponseListenerService()
    {
        return $this->privates['disallow_search_engine_index_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\DisallowRobotsIndexingListener();
    }

    /**
     * Gets the private 'doctrine.dbal.connection_factory' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\ConnectionFactory
     */
    protected function getDoctrine_Dbal_ConnectionFactoryService()
    {
        return $this->privates['doctrine.dbal.connection_factory'] = new \Doctrine\Bundle\DoctrineBundle\ConnectionFactory([]);
    }

    /**
     * Gets the private 'doctrine.dbal.default_connection.configuration' shared service.
     *
     * @return \Doctrine\DBAL\Configuration
     */
    protected function getDoctrine_Dbal_DefaultConnection_ConfigurationService()
    {
        $this->privates['doctrine.dbal.default_connection.configuration'] = $instance = new \Doctrine\DBAL\Configuration();

        $instance->setSQLLogger(($this->privates['doctrine.dbal.logger.chain.default'] ?? $this->getDoctrine_Dbal_Logger_Chain_DefaultService()));

        return $instance;
    }

    /**
     * Gets the private 'doctrine.dbal.default_connection.event_manager' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\ContainerAwareEventManager
     */
    protected function getDoctrine_Dbal_DefaultConnection_EventManagerService()
    {
        $this->privates['doctrine.dbal.default_connection.event_manager'] = $instance = new \Symfony\Bridge\Doctrine\ContainerAwareEventManager(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'doctrine.orm.default_listeners.attach_entity_listeners' => ['privates', 'doctrine.orm.default_listeners.attach_entity_listeners', 'getDoctrine_Orm_DefaultListeners_AttachEntityListenersService.php', true],
            'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener' => ['privates', 'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener', 'getDoctrinePhpcr_JackalopeDoctrineDbal_SchemaListenerService.php', true],
            'sulu_contact.account_listener' => ['privates', 'sulu_contact.account_listener', 'getSuluContact_AccountListenerService.php', true],
            'sulu_contact.doctrine.invalidation_listener' => ['privates', 'sulu_contact.doctrine.invalidation_listener', 'getSuluContact_Doctrine_InvalidationListenerService.php', true],
            'sulu_media.doctrine.invalidation_listener' => ['privates', 'sulu_media.doctrine.invalidation_listener', 'getSuluMedia_Doctrine_InvalidationListenerService.php', true],
        ], [
            'doctrine.orm.default_listeners.attach_entity_listeners' => '?',
            'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener' => '?',
            'sulu_contact.account_listener' => '?',
            'sulu_contact.doctrine.invalidation_listener' => '?',
            'sulu_media.doctrine.invalidation_listener' => '?',
        ]));

        $instance->addEventSubscriber(($this->privates['sulu.persistence.event_subscriber.orm.metadata'] ?? $this->getSulu_Persistence_EventSubscriber_Orm_MetadataService()));
        $instance->addEventSubscriber(($this->privates['sulu_core.doctrine.references'] ?? $this->getSuluCore_Doctrine_ReferencesService()));
        $instance->addEventSubscriber(($this->privates['doctrine.orm.listeners.resolve_target_entity'] ?? $this->getDoctrine_Orm_Listeners_ResolveTargetEntityService()));
        $instance->addEventSubscriber(($this->privates['stof_doctrine_extensions.listener.tree'] ?? $this->getStofDoctrineExtensions_Listener_TreeService()));
        $instance->addEventSubscriber(($this->privates['massive_search.search.event_subscriber.doctrine_orm'] ?? $this->getMassiveSearch_Search_EventSubscriber_DoctrineOrmService()));
        $instance->addEventSubscriber(($this->privates['sulu.persistence.event_subscriber.orm.timestampable'] ?? ($this->privates['sulu.persistence.event_subscriber.orm.timestampable'] = new \Sulu\Component\Persistence\EventSubscriber\ORM\TimestampableSubscriber())));
        $instance->addEventSubscriber(($this->privates['sulu.persistence.event_subscriber.orm.user_blame'] ?? $this->getSulu_Persistence_EventSubscriber_Orm_UserBlameService()));
        $instance->addEventSubscriber(($this->privates['sulu_media.media_audience_targeting_subscriber'] ?? ($this->privates['sulu_media.media_audience_targeting_subscriber'] = new \Sulu\Bundle\MediaBundle\EventListener\MediaAudienceTargetingSubscriber('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroup'))));
        $instance->addEventListener([0 => 'loadClassMetadata'], 'doctrine.orm.default_listeners.attach_entity_listeners');
        $instance->addEventListener([0 => 'postGenerateSchema'], 'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener');
        $instance->addEventListener([0 => 'postGenerateSchema'], 'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener');
        $instance->addEventListener([0 => 'postGenerateSchema'], 'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener');
        $instance->addEventListener([0 => 'postGenerateSchema'], 'doctrine_phpcr.jackalope_doctrine_dbal.schema_listener');
        $instance->addEventListener([0 => 'postPersist'], 'sulu_contact.account_listener');
        $instance->addEventListener([0 => 'postPersist'], 'sulu_contact.doctrine.invalidation_listener');
        $instance->addEventListener([0 => 'postUpdate'], 'sulu_contact.doctrine.invalidation_listener');
        $instance->addEventListener([0 => 'preRemove'], 'sulu_contact.doctrine.invalidation_listener');
        $instance->addEventListener([0 => 'postPersist'], 'sulu_media.doctrine.invalidation_listener');
        $instance->addEventListener([0 => 'postUpdate'], 'sulu_media.doctrine.invalidation_listener');
        $instance->addEventListener([0 => 'preRemove'], 'sulu_media.doctrine.invalidation_listener');

        return $instance;
    }

    /**
     * Gets the private 'doctrine.dbal.logger' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Logger\DbalLogger
     */
    protected function getDoctrine_Dbal_LoggerService()
    {
        return $this->privates['doctrine.dbal.logger'] = new \Symfony\Bridge\Doctrine\Logger\DbalLogger(($this->privates['monolog.logger.doctrine'] ?? $this->getMonolog_Logger_DoctrineService()), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'doctrine.dbal.logger.chain.default' shared service.
     *
     * @return \Doctrine\DBAL\Logging\LoggerChain
     */
    protected function getDoctrine_Dbal_Logger_Chain_DefaultService()
    {
        $this->privates['doctrine.dbal.logger.chain.default'] = $instance = new \Doctrine\DBAL\Logging\LoggerChain();

        $instance->addLogger(($this->privates['doctrine.dbal.logger'] ?? $this->getDoctrine_Dbal_LoggerService()));
        $instance->addLogger(($this->privates['doctrine.dbal.logger.profiling.default'] ?? ($this->privates['doctrine.dbal.logger.profiling.default'] = new \Doctrine\DBAL\Logging\DebugStack())));

        return $instance;
    }

    /**
     * Gets the private 'doctrine.dbal.logger.profiling.default' shared service.
     *
     * @return \Doctrine\DBAL\Logging\DebugStack
     */
    protected function getDoctrine_Dbal_Logger_Profiling_DefaultService()
    {
        return $this->privates['doctrine.dbal.logger.profiling.default'] = new \Doctrine\DBAL\Logging\DebugStack();
    }

    /**
     * Gets the private 'doctrine.orm.container_repository_factory' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Repository\ContainerRepositoryFactory
     */
    protected function getDoctrine_Orm_ContainerRepositoryFactoryService()
    {
        return $this->privates['doctrine.orm.container_repository_factory'] = new \Doctrine\Bundle\DoctrineBundle\Repository\ContainerRepositoryFactory(($this->privates['.service_locator.9_yeNH1'] ?? ($this->privates['.service_locator.9_yeNH1'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [], []))));
    }

    /**
     * Gets the private 'doctrine.orm.default_annotation_metadata_driver' shared service.
     *
     * @return \Doctrine\ORM\Mapping\Driver\AnnotationDriver
     */
    protected function getDoctrine_Orm_DefaultAnnotationMetadataDriverService()
    {
        return $this->privates['doctrine.orm.default_annotation_metadata_driver'] = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(($this->privates['annotations.cached_reader'] ?? $this->getAnnotations_CachedReaderService()), [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CoreBundle/Entity']);
    }

    /**
     * Gets the private 'doctrine.orm.default_configuration' shared service.
     *
     * @return \Doctrine\ORM\Configuration
     */
    protected function getDoctrine_Orm_DefaultConfigurationService()
    {
        $this->privates['doctrine.orm.default_configuration'] = $instance = new \Doctrine\ORM\Configuration();

        $instance->setEntityNamespaces(['GedmoTree' => 'Gedmo\\Tree\\Entity', 'SuluFormBundle' => 'Sulu\\Bundle\\FormBundle\\Entity', 'SuluCoreBundle' => 'Sulu\\Bundle\\CoreBundle\\Entity', 'SuluContactBundle' => 'Sulu\\Bundle\\ContactBundle\\Entity', 'SuluSecurityBundle' => 'Sulu\\Bundle\\SecurityBundle\\Entity', 'SuluWebsiteBundle' => 'Sulu\\Bundle\\WebsiteBundle\\Entity', 'SuluTagBundle' => 'Sulu\\Bundle\\TagBundle\\Entity', 'SuluMediaBundle' => 'Sulu\\Bundle\\MediaBundle\\Entity', 'SuluCategoryBundle' => 'Sulu\\Bundle\\CategoryBundle\\Entity', 'SuluRouteBundle' => 'Sulu\\Bundle\\RouteBundle\\Entity', 'SuluAudienceTargetingBundle' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity']);
        $instance->setMetadataCacheImpl(($this->services['doctrine_cache.providers.doctrine.orm.default_metadata_cache'] ?? $this->getDoctrineCache_Providers_Doctrine_Orm_DefaultMetadataCacheService()));
        $instance->setQueryCacheImpl(($this->services['doctrine_cache.providers.doctrine.orm.default_query_cache'] ?? $this->getDoctrineCache_Providers_Doctrine_Orm_DefaultQueryCacheService()));
        $instance->setResultCacheImpl(($this->services['doctrine_cache.providers.doctrine.orm.default_result_cache'] ?? $this->getDoctrineCache_Providers_Doctrine_Orm_DefaultResultCacheService()));
        $instance->setMetadataDriverImpl(($this->privates['doctrine.orm.default_metadata_driver'] ?? $this->getDoctrine_Orm_DefaultMetadataDriverService()));
        $instance->setProxyDir(($this->targetDirs[0].'/doctrine/orm/Proxies'));
        $instance->setProxyNamespace('Proxies');
        $instance->setAutoGenerateProxyClasses(true);
        $instance->setClassMetadataFactoryName('Doctrine\\ORM\\Mapping\\ClassMetadataFactory');
        $instance->setDefaultRepositoryClassName('Doctrine\\ORM\\EntityRepository');
        $instance->setNamingStrategy(($this->privates['doctrine.orm.naming_strategy.underscore'] ?? ($this->privates['doctrine.orm.naming_strategy.underscore'] = new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy())));
        $instance->setQuoteStrategy(($this->privates['doctrine.orm.quote_strategy.default'] ?? ($this->privates['doctrine.orm.quote_strategy.default'] = new \Doctrine\ORM\Mapping\DefaultQuoteStrategy())));
        $instance->setEntityListenerResolver(($this->privates['doctrine.orm.default_entity_listener_resolver'] ?? ($this->privates['doctrine.orm.default_entity_listener_resolver'] = new \Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver($this))));
        $instance->setRepositoryFactory(($this->privates['doctrine.orm.container_repository_factory'] ?? $this->getDoctrine_Orm_ContainerRepositoryFactoryService()));
        $instance->addCustomStringFunction('group_concat', 'Oro\\ORM\\Query\\AST\\Functions\\String\\GroupConcat');
        $instance->addCustomStringFunction('CAST', 'Sulu\\Component\\Rest\\DQL\\Cast');

        return $instance;
    }

    /**
     * Gets the private 'doctrine.orm.default_entity_listener_resolver' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver
     */
    protected function getDoctrine_Orm_DefaultEntityListenerResolverService()
    {
        return $this->privates['doctrine.orm.default_entity_listener_resolver'] = new \Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver($this);
    }

    /**
     * Gets the private 'doctrine.orm.default_entity_manager.validator_loader' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Validator\DoctrineLoader
     */
    protected function getDoctrine_Orm_DefaultEntityManager_ValidatorLoaderService()
    {
        return $this->privates['doctrine.orm.default_entity_manager.validator_loader'] = new \Symfony\Bridge\Doctrine\Validator\DoctrineLoader(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), NULL);
    }

    /**
     * Gets the private 'doctrine.orm.default_manager_configurator' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator
     */
    protected function getDoctrine_Orm_DefaultManagerConfiguratorService()
    {
        return $this->privates['doctrine.orm.default_manager_configurator'] = new \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator([], []);
    }

    /**
     * Gets the private 'doctrine.orm.default_metadata_driver' shared service.
     *
     * @return \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain
     */
    protected function getDoctrine_Orm_DefaultMetadataDriverService()
    {
        $this->privates['doctrine.orm.default_metadata_driver'] = $instance = new \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain();

        $a = ($this->privates['doctrine.orm.default_xml_metadata_driver'] ?? $this->getDoctrine_Orm_DefaultXmlMetadataDriverService());

        $instance->addDriver($a, 'Gedmo\\Tree\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\FormBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\ContactBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\SecurityBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\WebsiteBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\TagBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\MediaBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\CategoryBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\RouteBundle\\Entity');
        $instance->addDriver($a, 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity');
        $instance->addDriver(($this->privates['doctrine.orm.default_annotation_metadata_driver'] ?? $this->getDoctrine_Orm_DefaultAnnotationMetadataDriverService()), 'Sulu\\Bundle\\CoreBundle\\Entity');

        return $instance;
    }

    /**
     * Gets the private 'doctrine.orm.default_xml_metadata_driver' shared service.
     *
     * @return \Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver
     */
    protected function getDoctrine_Orm_DefaultXmlMetadataDriverService()
    {
        $this->privates['doctrine.orm.default_xml_metadata_driver'] = $instance = new \Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver(['/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/gedmo/doctrine-extensions/lib/Gedmo/Tree/Entity' => 'Gedmo\\Tree\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/config/doctrine' => 'Sulu\\Bundle\\FormBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\ContactBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\SecurityBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\WebsiteBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\TagBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\MediaBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\CategoryBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/RouteBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\RouteBundle\\Entity', '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Resources/config/doctrine' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity']);

        $instance->setGlobalBasename('mapping');

        return $instance;
    }

    /**
     * Gets the private 'doctrine.orm.listeners.resolve_target_entity' shared service.
     *
     * @return \Doctrine\ORM\Tools\ResolveTargetEntityListener
     */
    protected function getDoctrine_Orm_Listeners_ResolveTargetEntityService()
    {
        $this->privates['doctrine.orm.listeners.resolve_target_entity'] = $instance = new \Doctrine\ORM\Tools\ResolveTargetEntityListener();

        $instance->addResolveTargetEntity('Sulu\\Bundle\\MediaBundle\\Entity\\CollectionInterface', 'Sulu\\Bundle\\MediaBundle\\Entity\\Collection', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\ContactBundle\\Entity\\AccountInterface', 'Sulu\\Bundle\\ContactBundle\\Entity\\Account', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\ContactBundle\\Entity\\ContactInterface', 'Sulu\\Bundle\\ContactBundle\\Entity\\Contact', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\ContactBundle\\Entity\\AccountInterface', 'Sulu\\Bundle\\ContactBundle\\Entity\\Account', []);
        $instance->addResolveTargetEntity('Sulu\\Component\\Security\\Authentication\\UserInterface', 'Sulu\\Bundle\\SecurityBundle\\Entity\\User', []);
        $instance->addResolveTargetEntity('Sulu\\Component\\Security\\Authentication\\RoleInterface', 'Sulu\\Bundle\\SecurityBundle\\Entity\\Role', []);
        $instance->addResolveTargetEntity('Sulu\\Component\\Security\\Authentication\\RoleSettingInterface', 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleSetting', []);
        $instance->addResolveTargetEntity('Sulu\\Component\\Security\\Authorization\\AccessControl\\AccessControlInterface', 'Sulu\\Bundle\\SecurityBundle\\Entity\\AccessControl', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\TagBundle\\Tag\\TagInterface', 'Sulu\\Bundle\\TagBundle\\Entity\\Tag', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\MediaBundle\\Entity\\MediaInterface', 'Sulu\\Bundle\\MediaBundle\\Entity\\Media', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryInterface', 'Sulu\\Bundle\\CategoryBundle\\Entity\\Category', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMetaInterface', 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMeta', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslationInterface', 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslation', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\CategoryBundle\\Entity\\KeywordInterface', 'Sulu\\Bundle\\CategoryBundle\\Entity\\Keyword', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\RouteBundle\\Model\\RouteInterface', 'Sulu\\Bundle\\RouteBundle\\Entity\\Route', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupInterface', 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroup', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupConditionInterface', 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupCondition', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRuleInterface', 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRule', []);
        $instance->addResolveTargetEntity('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupWebspaceInterface', 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupWebspace', []);

        return $instance;
    }

    /**
     * Gets the private 'doctrine.orm.naming_strategy.underscore' shared service.
     *
     * @return \Doctrine\ORM\Mapping\UnderscoreNamingStrategy
     */
    protected function getDoctrine_Orm_NamingStrategy_UnderscoreService()
    {
        return $this->privates['doctrine.orm.naming_strategy.underscore'] = new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy();
    }

    /**
     * Gets the private 'doctrine.orm.quote_strategy.default' shared service.
     *
     * @return \Doctrine\ORM\Mapping\DefaultQuoteStrategy
     */
    protected function getDoctrine_Orm_QuoteStrategy_DefaultService()
    {
        return $this->privates['doctrine.orm.quote_strategy.default'] = new \Doctrine\ORM\Mapping\DefaultQuoteStrategy();
    }

    /**
     * Gets the private 'doctrine.orm.validator_initializer' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Validator\DoctrineInitializer
     */
    protected function getDoctrine_Orm_ValidatorInitializerService()
    {
        return $this->privates['doctrine.orm.validator_initializer'] = new \Symfony\Bridge\Doctrine\Validator\DoctrineInitializer(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /**
     * Gets the private 'doctrine.twig.doctrine_extension' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Twig\DoctrineExtension
     */
    protected function getDoctrine_Twig_DoctrineExtensionService()
    {
        return $this->privates['doctrine.twig.doctrine_extension'] = new \Doctrine\Bundle\DoctrineBundle\Twig\DoctrineExtension();
    }

    /**
     * Gets the private 'doctrine_phpcr.data_collector' shared service.
     *
     * @return \Doctrine\Bundle\PHPCRBundle\DataCollector\PHPCRDataCollector
     */
    protected function getDoctrinePhpcr_DataCollectorService()
    {
        return $this->privates['doctrine_phpcr.data_collector'] = new \Doctrine\Bundle\PHPCRBundle\DataCollector\PHPCRDataCollector(($this->services['doctrine_phpcr'] ?? $this->getDoctrinePhpcrService()));
    }

    /**
     * Gets the private 'doctrine_phpcr.default_credentials' shared service.
     *
     * @return \PHPCR\SimpleCredentials
     */
    protected function getDoctrinePhpcr_DefaultCredentialsService()
    {
        return $this->privates['doctrine_phpcr.default_credentials'] = new \PHPCR\SimpleCredentials($this->getEnv('PHPCR_USERNAME'), $this->getEnv('PHPCR_PASSWORD'));
    }

    /**
     * Gets the private 'doctrine_phpcr.jackalope.repository.default' shared service.
     *
     * @return \Jackalope\Repository
     */
    protected function getDoctrinePhpcr_Jackalope_Repository_DefaultService()
    {
        return $this->privates['doctrine_phpcr.jackalope.repository.default'] = ($this->privates['doctrine_phpcr.jackalope.repository.factory.service.doctrinedbal'] ?? ($this->privates['doctrine_phpcr.jackalope.repository.factory.service.doctrinedbal'] = new \Jackalope\RepositoryFactoryDoctrineDBAL()))->getRepository(['jackalope.doctrine_dbal_connection' => ($this->services['doctrine.dbal.default_connection'] ?? $this->getDoctrine_Dbal_DefaultConnectionService()), 'jackalope.check_login_on_server' => false]);
    }

    /**
     * Gets the private 'doctrine_phpcr.jackalope.repository.factory.service.doctrinedbal' shared service.
     *
     * @return \Jackalope\RepositoryFactoryDoctrineDBAL
     */
    protected function getDoctrinePhpcr_Jackalope_Repository_Factory_Service_DoctrinedbalService()
    {
        return $this->privates['doctrine_phpcr.jackalope.repository.factory.service.doctrinedbal'] = new \Jackalope\RepositoryFactoryDoctrineDBAL();
    }

    /**
     * Gets the private 'doctrine_phpcr.jackalope.repository.live' shared service.
     *
     * @return \Jackalope\Repository
     */
    protected function getDoctrinePhpcr_Jackalope_Repository_LiveService()
    {
        return $this->privates['doctrine_phpcr.jackalope.repository.live'] = ($this->privates['doctrine_phpcr.jackalope.repository.factory.service.doctrinedbal'] ?? ($this->privates['doctrine_phpcr.jackalope.repository.factory.service.doctrinedbal'] = new \Jackalope\RepositoryFactoryDoctrineDBAL()))->getRepository(['jackalope.doctrine_dbal_connection' => ($this->services['doctrine.dbal.default_connection'] ?? $this->getDoctrine_Dbal_DefaultConnectionService()), 'jackalope.check_login_on_server' => false]);
    }

    /**
     * Gets the private 'doctrine_phpcr.live_credentials' shared service.
     *
     * @return \PHPCR\SimpleCredentials
     */
    protected function getDoctrinePhpcr_LiveCredentialsService()
    {
        return $this->privates['doctrine_phpcr.live_credentials'] = new \PHPCR\SimpleCredentials($this->getEnv('PHPCR_USERNAME'), $this->getEnv('PHPCR_PASSWORD'));
    }

    /**
     * Gets the private 'esi' shared service.
     *
     * @return \Symfony\Component\HttpKernel\HttpCache\Esi
     */
    protected function getEsiService()
    {
        return $this->privates['esi'] = new \Symfony\Component\HttpKernel\HttpCache\Esi();
    }

    /**
     * Gets the private 'esi_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SurrogateListener
     */
    protected function getEsiListenerService()
    {
        return $this->privates['esi_listener'] = new \Symfony\Component\HttpKernel\EventListener\SurrogateListener(($this->privates['esi'] ?? ($this->privates['esi'] = new \Symfony\Component\HttpKernel\HttpCache\Esi())));
    }

    /**
     * Gets the private 'file_locator' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Config\FileLocator
     */
    protected function getFileLocatorService()
    {
        return $this->privates['file_locator'] = new \Symfony\Component\HttpKernel\Config\FileLocator(($this->services['kernel'] ?? $this->get('kernel', 1)), ($this->targetDirs[4].'/Resources'), [0 => $this->targetDirs[4]]);
    }

    /**
     * Gets the private 'form.extension' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DependencyInjection\DependencyInjectionExtension
     */
    protected function getForm_ExtensionService()
    {
        return $this->privates['form.extension'] = new \Symfony\Component\Form\Extension\DependencyInjection\DependencyInjectionExtension(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'Doctrine\\Bundle\\PHPCRBundle\\Form\\Type\\PHPCRReferenceType' => ['privates', 'form.type.phpcr.reference', 'getForm_Type_Phpcr_ReferenceService.php', true],
            'Sulu\\Bundle\\FormBundle\\Form\\Type\\DynamicFormType' => ['privates', 'sulu_form.form_type', 'getSuluForm_FormTypeService.php', true],
            'Sulu\\Bundle\\PageBundle\\Form\\Type\\HomeDocumentType' => ['privates', 'dtl_content.form.type.home', 'getDtlContent_Form_Type_HomeService.php', true],
            'Sulu\\Bundle\\PageBundle\\Form\\Type\\PageDocumentType' => ['privates', 'dtl_content.form.type.page', 'getDtlContent_Form_Type_PageService.php', true],
            'Sulu\\Bundle\\SnippetBundle\\Form\\SnippetType' => ['privates', 'sulu_snippet.form.snippet', 'getSuluSnippet_Form_SnippetService.php', true],
            'Sulu\\Component\\Content\\Form\\Type\\DocumentObjectType' => ['privates', 'dtl_content.form.factory.document_type', 'getDtlContent_Form_Factory_DocumentTypeService.php', true],
            'Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType' => ['privates', 'form.type.entity', 'getForm_Type_EntityService.php', true],
            'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType' => ['privates', 'form.type.choice', 'getForm_Type_ChoiceService.php', true],
            'Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType' => ['services', 'form.type.file', 'getForm_Type_FileService.php', true],
            'Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType' => ['privates', 'form.type.form', 'getForm_Type_FormService.php', true],
        ], [
            'Doctrine\\Bundle\\PHPCRBundle\\Form\\Type\\PHPCRReferenceType' => '?',
            'Sulu\\Bundle\\FormBundle\\Form\\Type\\DynamicFormType' => '?',
            'Sulu\\Bundle\\PageBundle\\Form\\Type\\HomeDocumentType' => '?',
            'Sulu\\Bundle\\PageBundle\\Form\\Type\\PageDocumentType' => '?',
            'Sulu\\Bundle\\SnippetBundle\\Form\\SnippetType' => '?',
            'Sulu\\Component\\Content\\Form\\Type\\DocumentObjectType' => '?',
            'Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType' => '?',
            'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType' => '?',
            'Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType' => '?',
            'Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType' => '?',
        ]), ['Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType' => new RewindableGenerator(function () {
            yield 0 => ($this->privates['form.type_extension.form.transformation_failure_handling'] ?? $this->load('getForm_TypeExtension_Form_TransformationFailureHandlingService.php'));
            yield 1 => ($this->privates['form.type_extension.form.http_foundation'] ?? $this->load('getForm_TypeExtension_Form_HttpFoundationService.php'));
            yield 2 => ($this->privates['form.type_extension.form.validator'] ?? $this->load('getForm_TypeExtension_Form_ValidatorService.php'));
            yield 3 => ($this->privates['form.type_extension.upload.validator'] ?? $this->load('getForm_TypeExtension_Upload_ValidatorService.php'));
            yield 4 => ($this->privates['form.type_extension.csrf'] ?? $this->load('getForm_TypeExtension_CsrfService.php'));
            yield 5 => ($this->privates['form.type_extension.form.data_collector'] ?? $this->load('getForm_TypeExtension_Form_DataCollectorService.php'));
        }, 6), 'Symfony\\Component\\Form\\Extension\\Core\\Type\\RepeatedType' => new RewindableGenerator(function () {
            yield 0 => ($this->privates['form.type_extension.repeated.validator'] ?? ($this->privates['form.type_extension.repeated.validator'] = new \Symfony\Component\Form\Extension\Validator\Type\RepeatedTypeValidatorExtension()));
        }, 1), 'Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType' => new RewindableGenerator(function () {
            yield 0 => ($this->privates['form.type_extension.submit.validator'] ?? ($this->privates['form.type_extension.submit.validator'] = new \Symfony\Component\Form\Extension\Validator\Type\SubmitTypeValidatorExtension()));
        }, 1)], new RewindableGenerator(function () {
            yield 0 => ($this->privates['form.type_guesser.validator'] ?? $this->load('getForm_TypeGuesser_ValidatorService.php'));
            yield 1 => ($this->privates['form.type_guesser.doctrine'] ?? $this->load('getForm_TypeGuesser_DoctrineService.php'));
        }, 2));
    }

    /**
     * Gets the private 'form.registry' shared service.
     *
     * @return \Symfony\Component\Form\FormRegistry
     */
    protected function getForm_RegistryService()
    {
        return $this->privates['form.registry'] = new \Symfony\Component\Form\FormRegistry([0 => ($this->privates['form.extension'] ?? $this->getForm_ExtensionService())], ($this->privates['form.resolved_type_factory'] ?? $this->getForm_ResolvedTypeFactoryService()));
    }

    /**
     * Gets the private 'form.resolved_type_factory' shared service.
     *
     * @return \Symfony\Component\Form\Extension\DataCollector\Proxy\ResolvedTypeFactoryDataCollectorProxy
     */
    protected function getForm_ResolvedTypeFactoryService()
    {
        return $this->privates['form.resolved_type_factory'] = new \Symfony\Component\Form\Extension\DataCollector\Proxy\ResolvedTypeFactoryDataCollectorProxy(new \Symfony\Component\Form\ResolvedFormTypeFactory(), ($this->privates['data_collector.form'] ?? $this->getDataCollector_FormService()));
    }

    /**
     * Gets the private 'fos_rest.body_listener' shared service.
     *
     * @return \FOS\RestBundle\EventListener\BodyListener
     */
    protected function getFosRest_BodyListenerService()
    {
        $this->privates['fos_rest.body_listener'] = $instance = new \FOS\RestBundle\EventListener\BodyListener(($this->privates['fos_rest.decoder_provider'] ?? $this->getFosRest_DecoderProviderService()), false);

        $instance->setDefaultFormat(NULL);

        return $instance;
    }

    /**
     * Gets the private 'fos_rest.decoder_provider' shared service.
     *
     * @return \FOS\RestBundle\Decoder\ContainerDecoderProvider
     */
    protected function getFosRest_DecoderProviderService()
    {
        return $this->privates['fos_rest.decoder_provider'] = new \FOS\RestBundle\Decoder\ContainerDecoderProvider(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'fos_rest.decoder.json' => ['privates', 'fos_rest.decoder.json', 'getFosRest_Decoder_JsonService.php', true],
            'fos_rest.decoder.xml' => ['privates', 'fos_rest.decoder.xml', 'getFosRest_Decoder_XmlService.php', true],
        ], [
            'fos_rest.decoder.json' => '?',
            'fos_rest.decoder.xml' => '?',
        ]), ['json' => 'fos_rest.decoder.json', 'xml' => 'fos_rest.decoder.xml']);
    }

    /**
     * Gets the private 'fos_rest.serializer.jms_handler_registry.inner' shared service.
     *
     * @return \JMS\Serializer\Handler\LazyHandlerRegistry
     */
    protected function getFosRest_Serializer_JmsHandlerRegistry_InnerService()
    {
        return $this->privates['fos_rest.serializer.jms_handler_registry.inner'] = new \JMS\Serializer\Handler\LazyHandlerRegistry(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'fos_rest.serializer.exception_normalizer.jms' => ['privates', 'fos_rest.serializer.exception_normalizer.jms', 'getFosRest_Serializer_ExceptionNormalizer_JmsService.php', true],
            'fos_rest.serializer.form_error_handler' => ['services', 'jms_serializer.form_error_handler', 'getJmsSerializer_FormErrorHandlerService.php', true],
            'jms_serializer.array_collection_handler' => ['services', 'jms_serializer.array_collection_handler', 'getJmsSerializer_ArrayCollectionHandlerService.php', true],
            'jms_serializer.constraint_violation_handler' => ['services', 'jms_serializer.constraint_violation_handler', 'getJmsSerializer_ConstraintViolationHandlerService.php', true],
            'jms_serializer.datetime_handler' => ['services', 'jms_serializer.datetime_handler', 'getJmsSerializer_DatetimeHandlerService.php', true],
            'jms_serializer.php_collection_handler' => ['services', 'jms_serializer.php_collection_handler', 'getJmsSerializer_PhpCollectionHandlerService.php', true],
            'sulu_admin.schema_handler' => ['privates', 'sulu_admin.schema_handler', 'getSuluAdmin_SchemaHandlerService.php', true],
            'sulu_core.rest.datetime_handler' => ['privates', 'sulu_core.rest.datetime_handler', 'getSuluCore_Rest_DatetimeHandlerService.php', true],
            'sulu_document_manager.serializer.handler.children_collection' => ['privates', 'sulu_document_manager.serializer.handler.children_collection', 'getSuluDocumentManager_Serializer_Handler_ChildrenCollectionService.php', true],
            'sulu_page.compat.serializer.handler.page_bridge' => ['privates', 'sulu_page.compat.serializer.handler.page_bridge', 'getSuluPage_Compat_Serializer_Handler_PageBridgeService.php', true],
            'sulu_page.document.serializer.handler.extension_container' => ['privates', 'sulu_page.document.serializer.handler.extension_container', 'getSuluPage_Document_Serializer_Handler_ExtensionContainerService.php', true],
            'sulu_page.document.serializer.handler.structure' => ['privates', 'sulu_page.document.serializer.handler.structure', 'getSuluPage_Document_Serializer_Handler_StructureService.php', true],
        ], [
            'fos_rest.serializer.exception_normalizer.jms' => '?',
            'fos_rest.serializer.form_error_handler' => '?',
            'jms_serializer.array_collection_handler' => '?',
            'jms_serializer.constraint_violation_handler' => '?',
            'jms_serializer.datetime_handler' => '?',
            'jms_serializer.php_collection_handler' => '?',
            'sulu_admin.schema_handler' => '?',
            'sulu_core.rest.datetime_handler' => '?',
            'sulu_document_manager.serializer.handler.children_collection' => '?',
            'sulu_page.compat.serializer.handler.page_bridge' => '?',
            'sulu_page.document.serializer.handler.extension_container' => '?',
            'sulu_page.document.serializer.handler.structure' => '?',
        ]), [2 => ['DateTime' => ['array' => [0 => 'sulu_core.rest.datetime_handler', 1 => 'deserialize'], 'json' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeFromjson'], 'xml' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeFromxml'], 'yml' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeFromyml']], 'DateTimeImmutable' => ['array' => [0 => 'sulu_core.rest.datetime_handler', 1 => 'deserialize'], 'json' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeImmutableFromjson'], 'xml' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeImmutableFromxml'], 'yml' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateTimeImmutableFromyml']], 'DateInterval' => ['json' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateIntervalFromjson'], 'xml' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateIntervalFromxml'], 'yml' => [0 => 'jms_serializer.datetime_handler', 1 => 'deserializeDateIntervalFromyml']], 'ArrayCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection']], 'Doctrine\\Common\\Collections\\ArrayCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection']], 'Doctrine\\ORM\\PersistentCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection']], 'Doctrine\\ODM\\MongoDB\\PersistentCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection']], 'Doctrine\\ODM\\PHPCR\\PersistentCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'deserializeCollection']], 'PhpCollection\\Sequence' => ['json' => [0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeSequence'], 'xml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeSequence'], 'yml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeSequence']], 'PhpCollection\\Map' => ['json' => [0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeMap'], 'xml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeMap'], 'yml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'deserializeMap']], 'Sulu\\Component\\Content\\Document\\Structure\\Structure' => ['json' => [0 => 'sulu_page.document.serializer.handler.structure', 1 => 'doDeserialize']], 'Sulu\\Component\\Content\\Document\\Extension\\ExtensionContainer' => ['json' => [0 => 'sulu_page.document.serializer.handler.extension_container', 1 => 'doDeserialize']], 'Sulu\\Component\\Content\\Compat\\Structure\\PageBridge' => ['json' => [0 => 'sulu_page.compat.serializer.handler.page_bridge', 1 => 'doDeserialize']]], 1 => ['DateTime' => ['array' => [0 => 'sulu_core.rest.datetime_handler', 1 => 'serialize'], 'json' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTime'], 'xml' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTime'], 'yml' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTime']], 'DateTimeImmutable' => ['array' => [0 => 'sulu_core.rest.datetime_handler', 1 => 'serialize'], 'json' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTimeImmutable'], 'xml' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTimeImmutable'], 'yml' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateTimeImmutable']], 'DateInterval' => ['json' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateInterval'], 'xml' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateInterval'], 'yml' => [0 => 'jms_serializer.datetime_handler', 1 => 'serializeDateInterval']], 'ArrayCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection']], 'Doctrine\\Common\\Collections\\ArrayCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection']], 'Doctrine\\ORM\\PersistentCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection']], 'Doctrine\\ODM\\MongoDB\\PersistentCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection']], 'Doctrine\\ODM\\PHPCR\\PersistentCollection' => ['json' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'xml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection'], 'yml' => [0 => 'jms_serializer.array_collection_handler', 1 => 'serializeCollection']], 'PhpCollection\\Sequence' => ['json' => [0 => 'jms_serializer.php_collection_handler', 1 => 'serializeSequence'], 'xml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'serializeSequence'], 'yml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'serializeSequence']], 'PhpCollection\\Map' => ['json' => [0 => 'jms_serializer.php_collection_handler', 1 => 'serializeMap'], 'xml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'serializeMap'], 'yml' => [0 => 'jms_serializer.php_collection_handler', 1 => 'serializeMap']], 'Symfony\\Component\\Validator\\ConstraintViolationList' => ['xml' => [0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeListToxml'], 'json' => [0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeListTojson'], 'yml' => [0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeListToyml']], 'Symfony\\Component\\Validator\\ConstraintViolation' => ['xml' => [0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeViolationToxml'], 'json' => [0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeViolationTojson'], 'yml' => [0 => 'jms_serializer.constraint_violation_handler', 1 => 'serializeViolationToyml']], 'Sulu\\Component\\Content\\Document\\Structure\\Structure' => ['json' => [0 => 'sulu_page.document.serializer.handler.structure', 1 => 'doSerialize']], 'Sulu\\Component\\Content\\Document\\Extension\\ExtensionContainer' => ['json' => [0 => 'sulu_page.document.serializer.handler.extension_container', 1 => 'doSerialize']], 'Sulu\\Component\\Content\\Compat\\Structure\\PageBridge' => ['json' => [0 => 'sulu_page.compat.serializer.handler.page_bridge', 1 => 'doSerialize']], 'Sulu\\Component\\DocumentManager\\Collection\\ChildrenCollection' => ['json' => [0 => 'sulu_document_manager.serializer.handler.children_collection', 1 => 'doSerialize']], 'Exception' => ['json' => [0 => 'fos_rest.serializer.exception_normalizer.jms', 1 => 'serializeToJson'], 'xml' => [0 => 'fos_rest.serializer.exception_normalizer.jms', 1 => 'serializeToXml']], 'Sulu\\Bundle\\AdminBundle\\Metadata\\SchemaMetadata\\SchemaMetadata' => ['json' => [0 => 'sulu_admin.schema_handler', 1 => 'serializeToJsonSchema']], 'Symfony\\Component\\Form\\Form' => ['xml' => [0 => 'fos_rest.serializer.form_error_handler', 1 => 'serializeFormToxml'], 'json' => [0 => 'fos_rest.serializer.form_error_handler', 1 => 'serializeFormTojson'], 'yml' => [0 => 'fos_rest.serializer.form_error_handler', 1 => 'serializeFormToyml']], 'Symfony\\Component\\Form\\FormError' => ['xml' => [0 => 'fos_rest.serializer.form_error_handler', 1 => 'serializeFormErrorToxml'], 'json' => [0 => 'fos_rest.serializer.form_error_handler', 1 => 'serializeFormErrorTojson'], 'yml' => [0 => 'fos_rest.serializer.form_error_handler', 1 => 'serializeFormErrorToyml']]]]);
    }

    /**
     * Gets the private 'fragment.listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\FragmentListener
     */
    protected function getFragment_ListenerService()
    {
        return $this->privates['fragment.listener'] = new \Symfony\Component\HttpKernel\EventListener\FragmentListener(($this->privates['uri_signer'] ?? ($this->privates['uri_signer'] = new \Symfony\Component\HttpKernel\UriSigner('secret'))), '/admin/_fragments');
    }

    /**
     * Gets the private 'hateoas.configuration.metadata.annotation_driver' shared service.
     *
     * @return \Hateoas\Configuration\Metadata\Driver\AnnotationDriver
     */
    protected function getHateoas_Configuration_Metadata_AnnotationDriverService()
    {
        return $this->privates['hateoas.configuration.metadata.annotation_driver'] = new \Hateoas\Configuration\Metadata\Driver\AnnotationDriver(($this->privates['annotations.cached_reader'] ?? $this->getAnnotations_CachedReaderService()));
    }

    /**
     * Gets the private 'hateoas.configuration.metadata.cache.file_cache' shared service.
     *
     * @return \Metadata\Cache\FileCache
     */
    protected function getHateoas_Configuration_Metadata_Cache_FileCacheService()
    {
        return $this->privates['hateoas.configuration.metadata.cache.file_cache'] = new \Metadata\Cache\FileCache(($this->targetDirs[0].'/hateoas'));
    }

    /**
     * Gets the private 'hateoas.configuration.metadata.chain_driver' shared service.
     *
     * @return \Metadata\Driver\DriverChain
     */
    protected function getHateoas_Configuration_Metadata_ChainDriverService()
    {
        return $this->privates['hateoas.configuration.metadata.chain_driver'] = new \Metadata\Driver\DriverChain([0 => ($this->privates['hateoas.configuration.metadata.yaml_driver'] ?? $this->getHateoas_Configuration_Metadata_YamlDriverService()), 1 => ($this->privates['hateoas.configuration.metadata.xml_driver'] ?? $this->getHateoas_Configuration_Metadata_XmlDriverService()), 2 => ($this->privates['hateoas.configuration.metadata.extension_driver'] ?? $this->getHateoas_Configuration_Metadata_ExtensionDriverService())]);
    }

    /**
     * Gets the private 'hateoas.configuration.metadata.extension_driver' shared service.
     *
     * @return \Hateoas\Configuration\Metadata\Driver\ExtensionDriver
     */
    protected function getHateoas_Configuration_Metadata_ExtensionDriverService()
    {
        return $this->privates['hateoas.configuration.metadata.extension_driver'] = new \Hateoas\Configuration\Metadata\Driver\ExtensionDriver(($this->privates['hateoas.configuration.metadata.annotation_driver'] ?? $this->getHateoas_Configuration_Metadata_AnnotationDriverService()));
    }

    /**
     * Gets the private 'hateoas.configuration.metadata.xml_driver' shared service.
     *
     * @return \Hateoas\Configuration\Metadata\Driver\XmlDriver
     */
    protected function getHateoas_Configuration_Metadata_XmlDriverService()
    {
        return $this->privates['hateoas.configuration.metadata.xml_driver'] = new \Hateoas\Configuration\Metadata\Driver\XmlDriver(($this->privates['jms_serializer.metadata.file_locator'] ?? $this->getJmsSerializer_Metadata_FileLocatorService()));
    }

    /**
     * Gets the private 'hateoas.configuration.metadata.yaml_driver' shared service.
     *
     * @return \Hateoas\Configuration\Metadata\Driver\YamlDriver
     */
    protected function getHateoas_Configuration_Metadata_YamlDriverService()
    {
        return $this->privates['hateoas.configuration.metadata.yaml_driver'] = new \Hateoas\Configuration\Metadata\Driver\YamlDriver(($this->privates['jms_serializer.metadata.file_locator'] ?? $this->getJmsSerializer_Metadata_FileLocatorService()));
    }

    /**
     * Gets the private 'hateoas.configuration.metadata_factory' shared service.
     *
     * @return \Metadata\MetadataFactory
     */
    protected function getHateoas_Configuration_MetadataFactoryService()
    {
        $this->privates['hateoas.configuration.metadata_factory'] = $instance = new \Metadata\MetadataFactory(($this->privates['hateoas.configuration.metadata.chain_driver'] ?? $this->getHateoas_Configuration_Metadata_ChainDriverService()), 'Metadata\\ClassHierarchyMetadata', true);

        $instance->setCache(($this->privates['hateoas.configuration.metadata.cache.file_cache'] ?? ($this->privates['hateoas.configuration.metadata.cache.file_cache'] = new \Metadata\Cache\FileCache(($this->targetDirs[0].'/hateoas')))));

        return $instance;
    }

    /**
     * Gets the private 'hateoas.configuration.provider.resolver.chain' shared service.
     *
     * @return \Hateoas\Configuration\Provider\Resolver\ChainResolver
     */
    protected function getHateoas_Configuration_Provider_Resolver_ChainService()
    {
        return $this->privates['hateoas.configuration.provider.resolver.chain'] = new \Hateoas\Configuration\Provider\Resolver\ChainResolver([0 => new \Hateoas\Configuration\Provider\Resolver\MethodResolver(), 1 => new \Hateoas\Configuration\Provider\Resolver\StaticMethodResolver(), 2 => new \Hateoas\Configuration\Provider\Resolver\SymfonyContainerResolver($this)]);
    }

    /**
     * Gets the private 'hateoas.configuration.relation_provider' shared service.
     *
     * @return \Hateoas\Configuration\Provider\RelationProvider
     */
    protected function getHateoas_Configuration_RelationProviderService()
    {
        return $this->privates['hateoas.configuration.relation_provider'] = new \Hateoas\Configuration\Provider\RelationProvider(($this->privates['hateoas.configuration.metadata_factory'] ?? $this->getHateoas_Configuration_MetadataFactoryService()), ($this->privates['hateoas.configuration.provider.resolver.chain'] ?? $this->getHateoas_Configuration_Provider_Resolver_ChainService()));
    }

    /**
     * Gets the private 'hateoas.configuration.relations_repository' shared service.
     *
     * @return \Hateoas\Configuration\RelationsRepository
     */
    protected function getHateoas_Configuration_RelationsRepositoryService()
    {
        return $this->privates['hateoas.configuration.relations_repository'] = new \Hateoas\Configuration\RelationsRepository(($this->privates['hateoas.configuration.metadata_factory'] ?? $this->getHateoas_Configuration_MetadataFactoryService()), ($this->privates['hateoas.configuration.relation_provider'] ?? $this->getHateoas_Configuration_RelationProviderService()));
    }

    /**
     * Gets the private 'hateoas.expression.evaluator' shared service.
     *
     * @return \Bazinga\Bundle\HateoasBundle\Hateoas\Expression\LazyFunctionExpressionEvaluator
     */
    protected function getHateoas_Expression_EvaluatorService()
    {
        $this->privates['hateoas.expression.evaluator'] = $instance = new \Bazinga\Bundle\HateoasBundle\Hateoas\Expression\LazyFunctionExpressionEvaluator(($this->privates['bazinga_hateoas.expression_language'] ?? ($this->privates['bazinga_hateoas.expression_language'] = new \Bazinga\Bundle\HateoasBundle\ExpressionLanguage\ExpressionLanguage())), [], $this);

        $instance->setContextVariable('container', $this);
        $instance->registerFunctionId('hateoas.expression.link');

        return $instance;
    }

    /**
     * Gets the private 'hateoas.generator.symfony' shared service.
     *
     * @return \Hateoas\UrlGenerator\SymfonyUrlGenerator
     */
    protected function getHateoas_Generator_SymfonyService()
    {
        return $this->privates['hateoas.generator.symfony'] = new \Hateoas\UrlGenerator\SymfonyUrlGenerator(($this->services['router'] ?? $this->getRouterService()));
    }

    /**
     * Gets the private 'hateoas.link_factory' shared service.
     *
     * @return \Hateoas\Factory\LinkFactory
     */
    protected function getHateoas_LinkFactoryService()
    {
        return $this->privates['hateoas.link_factory'] = new \Hateoas\Factory\LinkFactory(($this->privates['hateoas.expression.evaluator'] ?? $this->getHateoas_Expression_EvaluatorService()), ($this->services['hateoas.generator.registry'] ?? $this->getHateoas_Generator_RegistryService()));
    }

    /**
     * Gets the private 'hateoas.twig.link' shared service.
     *
     * @return \Hateoas\Twig\Extension\LinkExtension
     */
    protected function getHateoas_Twig_LinkService()
    {
        return $this->privates['hateoas.twig.link'] = new \Hateoas\Twig\Extension\LinkExtension(($this->services['hateoas.helper.link'] ?? $this->getHateoas_Helper_LinkService()));
    }

    /**
     * Gets the private 'identity_translator' shared service.
     *
     * @return \Symfony\Component\Translation\IdentityTranslator
     */
    protected function getIdentityTranslatorService()
    {
        return $this->privates['identity_translator'] = new \Symfony\Component\Translation\IdentityTranslator();
    }

    /**
     * Gets the private 'jms_serializer.accessor_strategy.default' shared service.
     *
     * @return \JMS\Serializer\Accessor\DefaultAccessorStrategy
     */
    protected function getJmsSerializer_AccessorStrategy_DefaultService()
    {
        return $this->privates['jms_serializer.accessor_strategy.default'] = new \JMS\Serializer\Accessor\DefaultAccessorStrategy();
    }

    /**
     * Gets the private 'jms_serializer.accessor_strategy.expression' shared service.
     *
     * @return \JMS\Serializer\Accessor\ExpressionAccessorStrategy
     */
    protected function getJmsSerializer_AccessorStrategy_ExpressionService()
    {
        return $this->privates['jms_serializer.accessor_strategy.expression'] = new \JMS\Serializer\Accessor\ExpressionAccessorStrategy(($this->privates['jms_serializer.expression_evaluator'] ?? $this->getJmsSerializer_ExpressionEvaluatorService()), ($this->privates['jms_serializer.accessor_strategy.default'] ?? ($this->privates['jms_serializer.accessor_strategy.default'] = new \JMS\Serializer\Accessor\DefaultAccessorStrategy())));
    }

    /**
     * Gets the private 'jms_serializer.event_dispatcher' shared service.
     *
     * @return \JMS\Serializer\EventDispatcher\LazyEventDispatcher
     */
    protected function getJmsSerializer_EventDispatcherService()
    {
        $this->privates['jms_serializer.event_dispatcher'] = $instance = new \JMS\Serializer\EventDispatcher\LazyEventDispatcher(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'hateoas.event_subscriber.json' => ['services', 'hateoas.event_subscriber.json', 'getHateoas_EventSubscriber_JsonService.php', true],
            'hateoas.event_subscriber.xml' => ['services', 'hateoas.event_subscriber.xml', 'getHateoas_EventSubscriber_XmlService.php', true],
            'jms_serializer.doctrine_proxy_subscriber' => ['services', 'jms_serializer.doctrine_proxy_subscriber', 'getJmsSerializer_DoctrineProxySubscriberService.php', true],
            'jms_serializer.stopwatch_subscriber' => ['services', 'jms_serializer.stopwatch_subscriber', 'getJmsSerializer_StopwatchSubscriberService.php', true],
            'sulu_audience_targeting.serializer.target_group_rule_serializer' => ['privates', 'sulu_audience_targeting.serializer.target_group_rule_serializer', 'getSuluAudienceTargeting_Serializer_TargetGroupRuleSerializerService.php', true],
            'sulu_audience_targeting.serializer.target_group_subscriber' => ['privates', 'sulu_audience_targeting.serializer.target_group_subscriber', 'getSuluAudienceTargeting_Serializer_TargetGroupSubscriberService.php', true],
            'sulu_custom_urls.serializer.event_subscriber' => ['privates', 'sulu_custom_urls.serializer.event_subscriber', 'getSuluCustomUrls_Serializer_EventSubscriberService.php', true],
            'sulu_document_manager.serializer.subscriber.children_behavior' => ['privates', 'sulu_document_manager.serializer.subscriber.children_behavior', 'getSuluDocumentManager_Serializer_Subscriber_ChildrenBehaviorService.php', true],
            'sulu_document_manager.serializer.subscriber.document' => ['privates', 'sulu_document_manager.serializer.subscriber.document', 'getSuluDocumentManager_Serializer_Subscriber_DocumentService.php', true],
            'sulu_document_manager.serializer.subscriber.proxy' => ['services', 'sulu_document_manager.serializer.subscriber.proxy', 'getSuluDocumentManager_Serializer_Subscriber_ProxyService.php', true],
            'sulu_hash.event_subscriber.serializer' => ['privates', 'sulu_hash.event_subscriber.serializer', 'getSuluHash_EventSubscriber_SerializerService.php', true],
            'sulu_page.content_repository.event_subscriber' => ['privates', 'sulu_page.content_repository.event_subscriber', 'getSuluPage_ContentRepository_EventSubscriberService.php', true],
            'sulu_page.document.serializer.subscriber.extension_container' => ['privates', 'sulu_page.document.serializer.subscriber.extension_container', 'getSuluPage_Document_Serializer_Subscriber_ExtensionContainerService.php', true],
            'sulu_page.document.serializer.subscriber.locale' => ['privates', 'sulu_page.document.serializer.subscriber.locale', 'getSuluPage_Document_Serializer_Subscriber_LocaleService.php', true],
            'sulu_page.document.serializer.subscriber.parent_behavior' => ['privates', 'sulu_page.document.serializer.subscriber.parent_behavior', 'getSuluPage_Document_Serializer_Subscriber_ParentBehaviorService.php', true],
            'sulu_page.document.serializer.subscriber.path_behavior' => ['privates', 'sulu_page.document.serializer.subscriber.path_behavior', 'getSuluPage_Document_Serializer_Subscriber_PathBehaviorService.php', true],
            'sulu_page.document.serializer.subscriber.redirect_type_behavior' => ['privates', 'sulu_page.document.serializer.subscriber.redirect_type_behavior', 'getSuluPage_Document_Serializer_Subscriber_RedirectTypeBehaviorService.php', true],
            'sulu_page.document.serializer.subscriber.shadow_locale_behavior' => ['privates', 'sulu_page.document.serializer.subscriber.shadow_locale_behavior', 'getSuluPage_Document_Serializer_Subscriber_ShadowLocaleBehaviorService.php', true],
            'sulu_page.document.serializer.subscriber.structure_behavior' => ['privates', 'sulu_page.document.serializer.subscriber.structure_behavior', 'getSuluPage_Document_Serializer_Subscriber_StructureBehaviorService.php', true],
            'sulu_page.document.serializer.subscriber.workflow_stage_behavior' => ['privates', 'sulu_page.document.serializer.subscriber.workflow_stage_behavior', 'getSuluPage_Document_Serializer_Subscriber_WorkflowStageBehaviorService.php', true],
            'sulu_page.teaser.serializer.event_subscriber' => ['privates', 'sulu_page.teaser.serializer.event_subscriber', 'getSuluPage_Teaser_Serializer_EventSubscriberService.php', true],
            'sulu_page.webspace.serializer.event_subscriber' => ['privates', 'sulu_page.webspace.serializer.event_subscriber', 'getSuluPage_Webspace_Serializer_EventSubscriberService.php', true],
            'sulu_security.document.serializer.subscriber.security' => ['privates', 'sulu_security.document.serializer.subscriber.security', 'getSuluSecurity_Document_Serializer_Subscriber_SecurityService.php', true],
            'sulu_security.serializer.handler.secured_entity' => ['privates', 'sulu_security.serializer.handler.secured_entity', 'getSuluSecurity_Serializer_Handler_SecuredEntityService.php', true],
            'sulu_website.analytics.event_subscriber' => ['privates', 'sulu_website.analytics.event_subscriber', 'getSuluWebsite_Analytics_EventSubscriberService.php', true],
        ], [
            'hateoas.event_subscriber.json' => '?',
            'hateoas.event_subscriber.xml' => '?',
            'jms_serializer.doctrine_proxy_subscriber' => '?',
            'jms_serializer.stopwatch_subscriber' => '?',
            'sulu_audience_targeting.serializer.target_group_rule_serializer' => '?',
            'sulu_audience_targeting.serializer.target_group_subscriber' => '?',
            'sulu_custom_urls.serializer.event_subscriber' => '?',
            'sulu_document_manager.serializer.subscriber.children_behavior' => '?',
            'sulu_document_manager.serializer.subscriber.document' => '?',
            'sulu_document_manager.serializer.subscriber.proxy' => '?',
            'sulu_hash.event_subscriber.serializer' => '?',
            'sulu_page.content_repository.event_subscriber' => '?',
            'sulu_page.document.serializer.subscriber.extension_container' => '?',
            'sulu_page.document.serializer.subscriber.locale' => '?',
            'sulu_page.document.serializer.subscriber.parent_behavior' => '?',
            'sulu_page.document.serializer.subscriber.path_behavior' => '?',
            'sulu_page.document.serializer.subscriber.redirect_type_behavior' => '?',
            'sulu_page.document.serializer.subscriber.shadow_locale_behavior' => '?',
            'sulu_page.document.serializer.subscriber.structure_behavior' => '?',
            'sulu_page.document.serializer.subscriber.workflow_stage_behavior' => '?',
            'sulu_page.teaser.serializer.event_subscriber' => '?',
            'sulu_page.webspace.serializer.event_subscriber' => '?',
            'sulu_security.document.serializer.subscriber.security' => '?',
            'sulu_security.serializer.handler.secured_entity' => '?',
            'sulu_website.analytics.event_subscriber' => '?',
        ]));

        $instance->setListeners(['serializer.pre_serialize' => [0 => [0 => [0 => 'jms_serializer.stopwatch_subscriber', 1 => 'onPreSerialize'], 1 => NULL, 2 => NULL], 1 => [0 => [0 => 'jms_serializer.doctrine_proxy_subscriber', 1 => 'onPreSerializeTypedProxy'], 1 => NULL, 2 => NULL], 2 => [0 => [0 => 'jms_serializer.doctrine_proxy_subscriber', 1 => 'onPreSerialize'], 1 => NULL, 2 => NULL], 3 => [0 => [0 => 'sulu_page.document.serializer.subscriber.structure_behavior', 1 => 'onPreSerialize'], 1 => NULL, 2 => NULL], 4 => [0 => [0 => 'sulu_page.document.serializer.subscriber.extension_container', 1 => 'onPreSerialize'], 1 => NULL, 2 => NULL], 5 => [0 => [0 => 'sulu_document_manager.serializer.subscriber.proxy', 1 => 'onPreSerialize'], 1 => NULL, 2 => NULL]], 'serializer.post_serialize' => [0 => [0 => [0 => 'sulu_page.webspace.serializer.event_subscriber', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 1 => [0 => [0 => 'sulu_page.content_repository.event_subscriber', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 2 => [0 => [0 => 'sulu_page.teaser.serializer.event_subscriber', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 3 => [0 => [0 => 'sulu_page.document.serializer.subscriber.structure_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 4 => [0 => [0 => 'sulu_page.document.serializer.subscriber.path_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 5 => [0 => [0 => 'sulu_page.document.serializer.subscriber.parent_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 6 => [0 => [0 => 'sulu_page.document.serializer.subscriber.locale', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 7 => [0 => [0 => 'sulu_page.document.serializer.subscriber.shadow_locale_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 8 => [0 => [0 => 'sulu_page.document.serializer.subscriber.redirect_type_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 9 => [0 => [0 => 'sulu_page.document.serializer.subscriber.workflow_stage_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 10 => [0 => [0 => 'sulu_security.serializer.handler.secured_entity', 1 => 'onPostSerialize'], 1 => NULL, 2 => NULL], 11 => [0 => [0 => 'sulu_security.document.serializer.subscriber.security', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 12 => [0 => [0 => 'sulu_website.analytics.event_subscriber', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 13 => [0 => [0 => 'sulu_document_manager.serializer.subscriber.children_behavior', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 14 => [0 => [0 => 'sulu_hash.event_subscriber.serializer', 1 => 'onPostSerialize'], 1 => NULL, 2 => NULL], 15 => [0 => [0 => 'sulu_custom_urls.serializer.event_subscriber', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 16 => [0 => [0 => 'hateoas.event_subscriber.xml', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'xml'], 17 => [0 => [0 => 'hateoas.event_subscriber.json', 1 => 'onPostSerialize'], 1 => NULL, 2 => 'json'], 18 => [0 => [0 => 'jms_serializer.stopwatch_subscriber', 1 => 'onPostSerialize'], 1 => NULL, 2 => NULL]], 'serializer.post_deserialize' => [0 => [0 => [0 => 'sulu_document_manager.serializer.subscriber.document', 1 => 'onPostDeserialize'], 1 => NULL, 2 => NULL], 1 => [0 => [0 => 'sulu_audience_targeting.serializer.target_group_subscriber', 1 => 'onPostDeserialize'], 1 => NULL, 2 => 'json'], 2 => [0 => [0 => 'sulu_audience_targeting.serializer.target_group_rule_serializer', 1 => 'onPostDeserialize'], 1 => NULL, 2 => 'json']]]);

        return $instance;
    }

    /**
     * Gets the private 'jms_serializer.expression_evaluator' shared service.
     *
     * @return \JMS\Serializer\Expression\ExpressionEvaluator
     */
    protected function getJmsSerializer_ExpressionEvaluatorService()
    {
        return $this->privates['jms_serializer.expression_evaluator'] = new \JMS\Serializer\Expression\ExpressionEvaluator(($this->privates['jms_serializer.expression_language'] ?? $this->getJmsSerializer_ExpressionLanguageService()), ['container' => $this]);
    }

    /**
     * Gets the private 'jms_serializer.expression_language' shared service.
     *
     * @return \Symfony\Component\ExpressionLanguage\ExpressionLanguage
     */
    protected function getJmsSerializer_ExpressionLanguageService()
    {
        $this->privates['jms_serializer.expression_language'] = $instance = new \Symfony\Component\ExpressionLanguage\ExpressionLanguage();

        $instance->registerProvider(($this->privates['jms_serializer.expression_language.function_provider'] ?? ($this->privates['jms_serializer.expression_language.function_provider'] = new \JMS\SerializerBundle\ExpressionLanguage\BasicSerializerFunctionsProvider())));

        return $instance;
    }

    /**
     * Gets the private 'jms_serializer.expression_language.function_provider' shared service.
     *
     * @return \JMS\SerializerBundle\ExpressionLanguage\BasicSerializerFunctionsProvider
     */
    protected function getJmsSerializer_ExpressionLanguage_FunctionProviderService()
    {
        return $this->privates['jms_serializer.expression_language.function_provider'] = new \JMS\SerializerBundle\ExpressionLanguage\BasicSerializerFunctionsProvider();
    }

    /**
     * Gets the private 'jms_serializer.identical_property_naming_strategy' shared service.
     *
     * @return \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy
     */
    protected function getJmsSerializer_IdenticalPropertyNamingStrategyService()
    {
        return $this->privates['jms_serializer.identical_property_naming_strategy'] = new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy();
    }

    /**
     * Gets the private 'jms_serializer.metadata.cache.file_cache' shared service.
     *
     * @return \Metadata\Cache\FileCache
     */
    protected function getJmsSerializer_Metadata_Cache_FileCacheService()
    {
        return $this->privates['jms_serializer.metadata.cache.file_cache'] = new \Metadata\Cache\FileCache(($this->targetDirs[0].'/jms_serializer'));
    }

    /**
     * Gets the private 'jms_serializer.metadata.file_locator' shared service.
     *
     * @return \Metadata\Driver\FileLocator
     */
    protected function getJmsSerializer_Metadata_FileLocatorService()
    {
        return $this->privates['jms_serializer.metadata.file_locator'] = new \Metadata\Driver\FileLocator(['Sulu\\Bundle\\SearchBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Resources/config/serializer', 'Sulu\\Bundle\\PageBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/DependencyInjection/../Resources/config/serializer', 'Sulu\\Bundle\\CategoryBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/Resources/config/serializer', 'Sulu\\Bundle\\SnippetBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle/Resources/config/serializer', 'Sulu\\Bundle\\DocumentManagerBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/DocumentManagerBundle/Resources/config/serializer', 'Sulu\\Bundle\\CustomUrlBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/Resources/config/serializer', 'Sulu\\Bundle\\AdminBundle' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Resources/config/serializer', 'Sulu\\Component\\SmartContent\\Configuration' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/DependencyInjection/../Resources/config/serializer', 'Sulu\\Component\\CustomUrl' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/DependencyInjection/../Resources/config/serializer', 'Sulu\\Component\\DocumentManager' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/DocumentManagerBundle/DependencyInjection/../Resources/config/serializer', 'Sulu\\Bundle\\CategoryBundle\\Entity' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/DependencyInjection/../Resources/config/serializer', 'Sulu\\Component\\Content' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/DependencyInjection/../Resources/config/serializer', 'Sulu\\Component\\Webspace' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/DependencyInjection/../Resources/config/serializer', 'Massive\\Bundle\\SearchBundle\\Search' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Resources/config/serializer/massive', 'Sulu\\Bundle\\SearchBundle\\Search' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Resources/config/serializer/sulu']);
    }

    /**
     * Gets the private 'jms_serializer.metadata.lazy_loading_driver' shared service.
     *
     * @return \Metadata\Driver\LazyLoadingDriver
     */
    protected function getJmsSerializer_Metadata_LazyLoadingDriverService()
    {
        return $this->privates['jms_serializer.metadata.lazy_loading_driver'] = new \Metadata\Driver\LazyLoadingDriver($this, 'jms_serializer.metadata_driver');
    }

    /**
     * Gets the private 'jms_serializer.metadata_factory' shared service.
     *
     * @return \Metadata\MetadataFactory
     */
    protected function getJmsSerializer_MetadataFactoryService()
    {
        $this->privates['jms_serializer.metadata_factory'] = $instance = new \Metadata\MetadataFactory(($this->privates['jms_serializer.metadata.lazy_loading_driver'] ?? ($this->privates['jms_serializer.metadata.lazy_loading_driver'] = new \Metadata\Driver\LazyLoadingDriver($this, 'jms_serializer.metadata_driver'))), 'Metadata\\ClassHierarchyMetadata', true);

        $instance->setCache(($this->privates['jms_serializer.metadata.cache.file_cache'] ?? ($this->privates['jms_serializer.metadata.cache.file_cache'] = new \Metadata\Cache\FileCache(($this->targetDirs[0].'/jms_serializer')))));

        return $instance;
    }

    /**
     * Gets the private 'jms_serializer.twig_extension.serializer' shared service.
     *
     * @return \JMS\Serializer\Twig\SerializerRuntimeExtension
     */
    protected function getJmsSerializer_TwigExtension_SerializerService()
    {
        return $this->privates['jms_serializer.twig_extension.serializer'] = new \JMS\Serializer\Twig\SerializerRuntimeExtension();
    }

    /**
     * Gets the private 'jms_serializer.unserialize_object_constructor' shared service.
     *
     * @return \JMS\Serializer\Construction\UnserializeObjectConstructor
     */
    protected function getJmsSerializer_UnserializeObjectConstructorService()
    {
        return $this->privates['jms_serializer.unserialize_object_constructor'] = new \JMS\Serializer\Construction\UnserializeObjectConstructor();
    }

    /**
     * Gets the private 'locale_aware_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\LocaleAwareListener
     */
    protected function getLocaleAwareListenerService()
    {
        return $this->privates['locale_aware_listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleAwareListener(new RewindableGenerator(function () {
            yield 0 => ($this->privates['translator.default'] ?? $this->getTranslator_DefaultService());
        }, 1), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'locale_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\LocaleListener
     */
    protected function getLocaleListenerService()
    {
        return $this->privates['locale_listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleListener(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), 'en', ($this->services['router'] ?? $this->getRouterService()));
    }

    /**
     * Gets the private 'massive_search.search.event_subscriber.doctrine_orm' shared service.
     *
     * @return \Massive\Bundle\SearchBundle\Search\EventSubscriber\DoctrineOrmSubscriber
     */
    protected function getMassiveSearch_Search_EventSubscriber_DoctrineOrmService()
    {
        return $this->privates['massive_search.search.event_subscriber.doctrine_orm'] = new \Massive\Bundle\SearchBundle\Search\EventSubscriber\DoctrineOrmSubscriber(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));
    }

    /**
     * Gets the private 'monolog.handler.main' shared service.
     *
     * @return \Monolog\Handler\NullHandler
     */
    protected function getMonolog_Handler_MainService()
    {
        $this->privates['monolog.handler.main'] = $instance = new \Monolog\Handler\NullHandler(100, true);

        $instance->pushProcessor(($this->privates['monolog.processor.psr_log_message'] ?? ($this->privates['monolog.processor.psr_log_message'] = new \Monolog\Processor\PsrLogMessageProcessor())));

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_LoggerService()
    {
        $this->privates['monolog.logger'] = $instance = new \Symfony\Bridge\Monolog\Logger('app');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->useMicrosecondTimestamps(true);
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.cache' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_CacheService()
    {
        $this->privates['monolog.logger.cache'] = $instance = new \Symfony\Bridge\Monolog\Logger('cache');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.doctrine' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_DoctrineService()
    {
        $this->privates['monolog.logger.doctrine'] = $instance = new \Symfony\Bridge\Monolog\Logger('doctrine');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.event' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_EventService()
    {
        $this->privates['monolog.logger.event'] = $instance = new \Symfony\Bridge\Monolog\Logger('event');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.php' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_PhpService()
    {
        $this->privates['monolog.logger.php'] = $instance = new \Symfony\Bridge\Monolog\Logger('php');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.profiler' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_ProfilerService()
    {
        $this->privates['monolog.logger.profiler'] = $instance = new \Symfony\Bridge\Monolog\Logger('profiler');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.request' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_RequestService()
    {
        $this->privates['monolog.logger.request'] = $instance = new \Symfony\Bridge\Monolog\Logger('request');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.logger.router' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_RouterService()
    {
        $this->privates['monolog.logger.router'] = $instance = new \Symfony\Bridge\Monolog\Logger('router');

        $instance->pushProcessor(($this->privates['debug.log_processor'] ?? $this->getDebug_LogProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));
        \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddDebugLogProcessorPass::configureLogger($instance);

        return $instance;
    }

    /**
     * Gets the private 'monolog.processor.psr_log_message' shared service.
     *
     * @return \Monolog\Processor\PsrLogMessageProcessor
     */
    protected function getMonolog_Processor_PsrLogMessageService()
    {
        return $this->privates['monolog.processor.psr_log_message'] = new \Monolog\Processor\PsrLogMessageProcessor();
    }

    /**
     * Gets the private 'parameter_bag' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ParameterBag\ContainerBag
     */
    protected function getParameterBagService()
    {
        return $this->privates['parameter_bag'] = new \Symfony\Component\DependencyInjection\ParameterBag\ContainerBag($this);
    }

    /**
     * Gets the private 'profiler.storage' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Profiler\FileProfilerStorage
     */
    protected function getProfiler_StorageService()
    {
        return $this->privates['profiler.storage'] = new \Symfony\Component\HttpKernel\Profiler\FileProfilerStorage(('file:'.$this->targetDirs[0].'/profiler'));
    }

    /**
     * Gets the private 'profiler_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ProfilerListener
     */
    protected function getProfilerListenerService()
    {
        return $this->privates['profiler_listener'] = new \Symfony\Component\HttpKernel\EventListener\ProfilerListener(($this->services['profiler'] ?? $this->getProfilerService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), NULL, false, false);
    }

    /**
     * Gets the private 'resolve_controller_name_subscriber' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber
     */
    protected function getResolveControllerNameSubscriberService()
    {
        return $this->privates['resolve_controller_name_subscriber'] = new \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber(($this->services['sulu_page.controller_name_converter'] ?? ($this->services['sulu_page.controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel', 1))))));
    }

    /**
     * Gets the private 'response_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ResponseListener
     */
    protected function getResponseListenerService()
    {
        return $this->privates['response_listener'] = new \Symfony\Component\HttpKernel\EventListener\ResponseListener('UTF-8');
    }

    /**
     * Gets the private 'router.request_context' shared service.
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    protected function getRouter_RequestContextService()
    {
        return $this->privates['router.request_context'] = new \Symfony\Component\Routing\RequestContext('', 'GET', 'localhost', 'http', 80, 443);
    }

    /**
     * Gets the private 'security.authentication.manager' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager
     */
    protected function getSecurity_Authentication_ManagerService()
    {
        $this->privates['security.authentication.manager'] = $instance = new \Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager(new RewindableGenerator(function () {
            yield 0 => ($this->privates['security.authentication.provider.dao.test'] ?? $this->load('getSecurity_Authentication_Provider_Dao_TestService.php'));
        }, 1), true);

        $instance->setEventDispatcher(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));

        return $instance;
    }

    /**
     * Gets the private 'security.firewall.map' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Security\FirewallMap
     */
    protected function getSecurity_Firewall_MapService()
    {
        return $this->privates['security.firewall.map'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallMap(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'security.firewall.map.context.test' => ['privates', 'security.firewall.map.context.test', 'getSecurity_Firewall_Map_Context_TestService.php', true],
        ], [
            'security.firewall.map.context.test' => '?',
        ]), new RewindableGenerator(function () {
            yield 'security.firewall.map.context.test' => NULL;
        }, 1));
    }

    /**
     * Gets the private 'security.logout_url_generator' shared service.
     *
     * @return \Symfony\Component\Security\Http\Logout\LogoutUrlGenerator
     */
    protected function getSecurity_LogoutUrlGeneratorService()
    {
        return $this->privates['security.logout_url_generator'] = new \Symfony\Component\Security\Http\Logout\LogoutUrlGenerator(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->services['router'] ?? $this->getRouterService()), ($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())));
    }

    /**
     * Gets the private 'security.rememberme.response_listener' shared service.
     *
     * @return \Symfony\Component\Security\Http\RememberMe\ResponseListener
     */
    protected function getSecurity_Rememberme_ResponseListenerService()
    {
        return $this->privates['security.rememberme.response_listener'] = new \Symfony\Component\Security\Http\RememberMe\ResponseListener();
    }

    /**
     * Gets the private 'security.role_hierarchy' shared service.
     *
     * @return \Symfony\Component\Security\Core\Role\RoleHierarchy
     */
    protected function getSecurity_RoleHierarchyService()
    {
        return $this->privates['security.role_hierarchy'] = new \Symfony\Component\Security\Core\Role\RoleHierarchy([]);
    }

    /**
     * Gets the private 'session_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SessionListener
     */
    protected function getSessionListenerService()
    {
        return $this->privates['session_listener'] = new \Symfony\Component\HttpKernel\EventListener\SessionListener(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'initialized_session' => ['services', 'session', NULL, true],
            'session' => ['services', 'session', 'getSessionService.php', true],
        ], [
            'initialized_session' => '?',
            'session' => '?',
        ]));
    }

    /**
     * Gets the private 'stof_doctrine_extensions.listener.tree' shared service.
     *
     * @return \Gedmo\Tree\TreeListener
     */
    protected function getStofDoctrineExtensions_Listener_TreeService()
    {
        $this->privates['stof_doctrine_extensions.listener.tree'] = $instance = new \Gedmo\Tree\TreeListener();

        $instance->setAnnotationReader(($this->privates['annotations.cached_reader'] ?? $this->getAnnotations_CachedReaderService()));

        return $instance;
    }

    /**
     * Gets the private 'streamed_response_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener
     */
    protected function getStreamedResponseListenerService()
    {
        return $this->privates['streamed_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener();
    }

    /**
     * Gets the private 'sulu.content.query_executor' shared service.
     *
     * @return \Sulu\Component\Content\Query\ContentQueryExecutor
     */
    protected function getSulu_Content_QueryExecutorService()
    {
        return $this->privates['sulu.content.query_executor'] = new \Sulu\Component\Content\Query\ContentQueryExecutor(($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'sulu.content.resource_locator.mapper.phpcr' shared service.
     *
     * @return \Sulu\Component\Content\Types\ResourceLocator\Mapper\PhpcrMapper
     */
    protected function getSulu_Content_ResourceLocator_Mapper_PhpcrService()
    {
        return $this->privates['sulu.content.resource_locator.mapper.phpcr'] = new \Sulu\Component\Content\Types\ResourceLocator\Mapper\PhpcrMapper(($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), ($this->services['sulu_document_manager.document_inspector'] ?? $this->getSuluDocumentManager_DocumentInspectorService()));
    }

    /**
     * Gets the private 'sulu.content.resource_locator.strategy.tree_full_edit' shared service.
     *
     * @return \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeFullEditStrategy
     */
    protected function getSulu_Content_ResourceLocator_Strategy_TreeFullEditService()
    {
        return $this->privates['sulu.content.resource_locator.strategy.tree_full_edit'] = new \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeFullEditStrategy(($this->privates['sulu.content.resource_locator.mapper.phpcr'] ?? $this->getSulu_Content_ResourceLocator_Mapper_PhpcrService()), ($this->services['sulu.content.path_cleaner'] ?? $this->getSulu_Content_PathCleanerService()), ($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()), ($this->services['sulu.util.node_helper'] ?? $this->getSulu_Util_NodeHelperService()), ($this->services['sulu_document_manager.document_inspector'] ?? $this->getSuluDocumentManager_DocumentInspectorService()), ($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), ($this->privates['sulu.content.resource_locator.strategy.tree_generator'] ?? ($this->privates['sulu.content.resource_locator.strategy.tree_generator'] = new \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeGenerator())));
    }

    /**
     * Gets the private 'sulu.content.resource_locator.strategy.tree_generator' shared service.
     *
     * @return \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeGenerator
     */
    protected function getSulu_Content_ResourceLocator_Strategy_TreeGeneratorService()
    {
        return $this->privates['sulu.content.resource_locator.strategy.tree_generator'] = new \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeGenerator();
    }

    /**
     * Gets the private 'sulu.content.resource_locator.strategy.tree_leaf_edit' shared service.
     *
     * @return \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeLeafEditStrategy
     */
    protected function getSulu_Content_ResourceLocator_Strategy_TreeLeafEditService()
    {
        return $this->privates['sulu.content.resource_locator.strategy.tree_leaf_edit'] = new \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeLeafEditStrategy(($this->privates['sulu.content.resource_locator.mapper.phpcr'] ?? $this->getSulu_Content_ResourceLocator_Mapper_PhpcrService()), ($this->services['sulu.content.path_cleaner'] ?? $this->getSulu_Content_PathCleanerService()), ($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()), ($this->services['sulu.util.node_helper'] ?? $this->getSulu_Util_NodeHelperService()), ($this->services['sulu_document_manager.document_inspector'] ?? $this->getSuluDocumentManager_DocumentInspectorService()), ($this->services['sulu_document_manager.document_manager'] ?? $this->getSuluDocumentManager_DocumentManagerService()), ($this->privates['sulu.content.resource_locator.strategy.tree_generator'] ?? ($this->privates['sulu.content.resource_locator.strategy.tree_generator'] = new \Sulu\Component\Content\Types\ResourceLocator\Strategy\TreeGenerator())));
    }

    /**
     * Gets the private 'sulu.content.resource_locator.strategy_pool' shared service.
     *
     * @return \Sulu\Component\Content\Types\ResourceLocator\Strategy\ResourceLocatorStrategyPool
     */
    protected function getSulu_Content_ResourceLocator_StrategyPoolService()
    {
        return $this->privates['sulu.content.resource_locator.strategy_pool'] = new \Sulu\Component\Content\Types\ResourceLocator\Strategy\ResourceLocatorStrategyPool(['tree_leaf_edit' => ($this->privates['sulu.content.resource_locator.strategy.tree_leaf_edit'] ?? $this->getSulu_Content_ResourceLocator_Strategy_TreeLeafEditService()), 'tree_full_edit' => ($this->privates['sulu.content.resource_locator.strategy.tree_full_edit'] ?? $this->getSulu_Content_ResourceLocator_Strategy_TreeFullEditService())], ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()));
    }

    /**
     * Gets the private 'sulu.mail.helper' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Mail\Helper
     */
    protected function getSulu_Mail_HelperService()
    {
        return $this->privates['sulu.mail.helper'] = new \Sulu\Bundle\FormBundle\Mail\Helper(($this->services['swiftmailer.mailer.default'] ?? $this->load('getSwiftmailer_Mailer_DefaultService.php')), 'from@example.org', 'to@example.org', ($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /**
     * Gets the private 'sulu.persistence.event_subscriber.orm.metadata' shared service.
     *
     * @return \Sulu\Component\Persistence\EventSubscriber\ORM\MetadataSubscriber
     */
    protected function getSulu_Persistence_EventSubscriber_Orm_MetadataService()
    {
        return $this->privates['sulu.persistence.event_subscriber.orm.metadata'] = new \Sulu\Component\Persistence\EventSubscriber\ORM\MetadataSubscriber($this->parameters['sulu.persistence.objects']);
    }

    /**
     * Gets the private 'sulu.persistence.event_subscriber.orm.timestampable' shared service.
     *
     * @return \Sulu\Component\Persistence\EventSubscriber\ORM\TimestampableSubscriber
     */
    protected function getSulu_Persistence_EventSubscriber_Orm_TimestampableService()
    {
        return $this->privates['sulu.persistence.event_subscriber.orm.timestampable'] = new \Sulu\Component\Persistence\EventSubscriber\ORM\TimestampableSubscriber();
    }

    /**
     * Gets the private 'sulu.persistence.event_subscriber.orm.user_blame' shared service.
     *
     * @return \Sulu\Component\Persistence\EventSubscriber\ORM\UserBlameSubscriber
     */
    protected function getSulu_Persistence_EventSubscriber_Orm_UserBlameService()
    {
        return $this->privates['sulu.persistence.event_subscriber.orm.user_blame'] = new \Sulu\Component\Persistence\EventSubscriber\ORM\UserBlameSubscriber(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), 'Sulu\\Bundle\\SecurityBundle\\Entity\\User');
    }

    /**
     * Gets the private 'sulu_category.category_request_handler' shared service.
     *
     * @return \Sulu\Component\Category\Request\CategoryRequestHandler
     */
    protected function getSuluCategory_CategoryRequestHandlerService()
    {
        return $this->privates['sulu_category.category_request_handler'] = new \Sulu\Component\Category\Request\CategoryRequestHandler(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'sulu_category.twig_extension' shared service.
     *
     * @return \Sulu\Bundle\CategoryBundle\Twig\CategoryTwigExtension
     */
    protected function getSuluCategory_TwigExtensionService()
    {
        return $this->privates['sulu_category.twig_extension'] = new \Sulu\Bundle\CategoryBundle\Twig\CategoryTwigExtension(($this->services['sulu_category.category_manager'] ?? $this->getSuluCategory_CategoryManagerService()), ($this->privates['sulu_category.category_request_handler'] ?? $this->getSuluCategory_CategoryRequestHandlerService()), ($this->services['jms_serializer'] ?? $this->getJmsSerializerService()), ($this->privates['sulu_core.cache.memoize'] ?? $this->getSuluCore_Cache_MemoizeService()));
    }

    /**
     * Gets the private 'sulu_contact.twig' shared service.
     *
     * @return \Sulu\Bundle\ContactBundle\Twig\ContactTwigExtension
     */
    protected function getSuluContact_TwigService()
    {
        return $this->privates['sulu_contact.twig'] = new \Sulu\Bundle\ContactBundle\Twig\ContactTwigExtension(($this->privates['sulu_contact.twig.cache'] ?? ($this->privates['sulu_contact.twig.cache'] = new \Doctrine\Common\Cache\ArrayCache())), ($this->services['sulu.repository.contact'] ?? $this->getSulu_Repository_ContactService()));
    }

    /**
     * Gets the private 'sulu_contact.twig.cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getSuluContact_Twig_CacheService()
    {
        return $this->privates['sulu_contact.twig.cache'] = new \Doctrine\Common\Cache\ArrayCache();
    }

    /**
     * Gets the private 'sulu_core.array_serialization_visitor' shared service.
     *
     * @return \Sulu\Component\Serializer\ArraySerializationVisitor
     */
    protected function getSuluCore_ArraySerializationVisitorService()
    {
        return $this->privates['sulu_core.array_serialization_visitor'] = new \Sulu\Component\Serializer\ArraySerializationVisitor(($this->privates['sulu_core.serialize_caching_strategy'] ?? $this->getSuluCore_SerializeCachingStrategyService()));
    }

    /**
     * Gets the private 'sulu_core.cache.memoize' shared service.
     *
     * @return \Sulu\Component\Cache\Memoize
     */
    protected function getSuluCore_Cache_MemoizeService()
    {
        return $this->privates['sulu_core.cache.memoize'] = new \Sulu\Component\Cache\Memoize(($this->privates['sulu_core.cache.memoize.cache'] ?? ($this->privates['sulu_core.cache.memoize.cache'] = new \Doctrine\Common\Cache\ArrayCache())), 1);
    }

    /**
     * Gets the private 'sulu_core.cache.memoize.cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getSuluCore_Cache_Memoize_CacheService()
    {
        return $this->privates['sulu_core.cache.memoize.cache'] = new \Doctrine\Common\Cache\ArrayCache();
    }

    /**
     * Gets the private 'sulu_core.doctrine.references' shared service.
     *
     * @return \Sulu\Component\Doctrine\ReferencesOption
     */
    protected function getSuluCore_Doctrine_ReferencesService()
    {
        return $this->privates['sulu_core.doctrine.references'] = new \Sulu\Component\Doctrine\ReferencesOption(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /**
     * Gets the private 'sulu_core.proxy_manager.configuration' shared service.
     *
     * @return \ProxyManager\Configuration
     */
    protected function getSuluCore_ProxyManager_ConfigurationService()
    {
        $this->privates['sulu_core.proxy_manager.configuration'] = $instance = new \ProxyManager\Configuration();

        $instance->setProxiesTargetDir(($this->targetDirs[0].'/sulu/proxies'));
        $instance->setGeneratorStrategy(($this->privates['sulu_core.proxy_manager.file_writer_generator_strategy'] ?? $this->getSuluCore_ProxyManager_FileWriterGeneratorStrategyService()));

        return $instance;
    }

    /**
     * Gets the private 'sulu_core.proxy_manager.file_locator' shared service.
     *
     * @return \ProxyManager\FileLocator\FileLocator
     */
    protected function getSuluCore_ProxyManager_FileLocatorService()
    {
        return $this->privates['sulu_core.proxy_manager.file_locator'] = new \ProxyManager\FileLocator\FileLocator(($this->privates['sulu_core.proxy_manager.configuration'] ?? $this->getSuluCore_ProxyManager_ConfigurationService())->getProxiesTargetDir());
    }

    /**
     * Gets the private 'sulu_core.proxy_manager.file_writer_generator_strategy' shared service.
     *
     * @return \ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy
     */
    protected function getSuluCore_ProxyManager_FileWriterGeneratorStrategyService()
    {
        $a = ($this->privates['sulu_core.proxy_manager.file_locator'] ?? $this->getSuluCore_ProxyManager_FileLocatorService());

        if (isset($this->privates['sulu_core.proxy_manager.file_writer_generator_strategy'])) {
            return $this->privates['sulu_core.proxy_manager.file_writer_generator_strategy'];
        }

        return $this->privates['sulu_core.proxy_manager.file_writer_generator_strategy'] = new \ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy($a);
    }

    /**
     * Gets the private 'sulu_core.request_processor.admin' shared service.
     *
     * @return \Sulu\Component\Webspace\Analyzer\Attributes\AdminRequestProcessor
     */
    protected function getSuluCore_RequestProcessor_AdminService()
    {
        return $this->privates['sulu_core.request_processor.admin'] = new \Sulu\Component\Webspace\Analyzer\Attributes\AdminRequestProcessor(($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), 'test');
    }

    /**
     * Gets the private 'sulu_core.serialize_caching_strategy' shared service.
     *
     * @return \JMS\Serializer\Naming\CacheNamingStrategy
     */
    protected function getSuluCore_SerializeCachingStrategyService()
    {
        return $this->privates['sulu_core.serialize_caching_strategy'] = new \JMS\Serializer\Naming\CacheNamingStrategy(($this->privates['sulu_core.serialize_naming_strategy'] ?? $this->getSuluCore_SerializeNamingStrategyService()));
    }

    /**
     * Gets the private 'sulu_core.serialize_naming_strategy' shared service.
     *
     * @return \JMS\Serializer\Naming\SerializedNameAnnotationStrategy
     */
    protected function getSuluCore_SerializeNamingStrategyService()
    {
        return $this->privates['sulu_core.serialize_naming_strategy'] = new \JMS\Serializer\Naming\SerializedNameAnnotationStrategy(($this->privates['jms_serializer.identical_property_naming_strategy'] ?? ($this->privates['jms_serializer.identical_property_naming_strategy'] = new \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy())));
    }

    /**
     * Gets the private 'sulu_core.webspace.loader.delegator' shared service.
     *
     * @return \Symfony\Component\Config\Loader\DelegatingLoader
     */
    protected function getSuluCore_Webspace_Loader_DelegatorService()
    {
        return $this->privates['sulu_core.webspace.loader.delegator'] = new \Symfony\Component\Config\Loader\DelegatingLoader(($this->privates['sulu_core.webspace.loader.resolver'] ?? $this->getSuluCore_Webspace_Loader_ResolverService()));
    }

    /**
     * Gets the private 'sulu_core.webspace.loader.resolver' shared service.
     *
     * @return \Symfony\Component\Config\Loader\LoaderResolver
     */
    protected function getSuluCore_Webspace_Loader_ResolverService()
    {
        return $this->privates['sulu_core.webspace.loader.resolver'] = new \Symfony\Component\Config\Loader\LoaderResolver([0 => ($this->privates['sulu_core.webspace.loader.xml.1.1'] ?? $this->getSuluCore_Webspace_Loader_Xml_1_1Service()), 1 => ($this->privates['sulu_core.webspace.loader.xml.1.0'] ?? $this->getSuluCore_Webspace_Loader_Xml_1_0Service())]);
    }

    /**
     * Gets the private 'sulu_core.webspace.loader.xml.1.0' shared service.
     *
     * @return \Sulu\Component\Webspace\Loader\XmlFileLoader10
     */
    protected function getSuluCore_Webspace_Loader_Xml_1_0Service()
    {
        return $this->privates['sulu_core.webspace.loader.xml.1.0'] = new \Sulu\Component\Webspace\Loader\XmlFileLoader10(($this->privates['file_locator'] ?? ($this->privates['file_locator'] = new \Symfony\Component\HttpKernel\Config\FileLocator(($this->services['kernel'] ?? $this->get('kernel', 1)), ($this->targetDirs[4].'/Resources'), [0 => $this->targetDirs[4]]))));
    }

    /**
     * Gets the private 'sulu_core.webspace.loader.xml.1.1' shared service.
     *
     * @return \Sulu\Component\Webspace\Loader\XmlFileLoader11
     */
    protected function getSuluCore_Webspace_Loader_Xml_1_1Service()
    {
        return $this->privates['sulu_core.webspace.loader.xml.1.1'] = new \Sulu\Component\Webspace\Loader\XmlFileLoader11(($this->privates['file_locator'] ?? ($this->privates['file_locator'] = new \Symfony\Component\HttpKernel\Config\FileLocator(($this->services['kernel'] ?? $this->get('kernel', 1)), ($this->targetDirs[4].'/Resources'), [0 => $this->targetDirs[4]]))));
    }

    /**
     * Gets the private 'sulu_core.webspace.settings_manager' shared service.
     *
     * @return \Sulu\Component\Webspace\Settings\SettingsManager
     */
    protected function getSuluCore_Webspace_SettingsManagerService()
    {
        return $this->privates['sulu_core.webspace.settings_manager'] = new \Sulu\Component\Webspace\Settings\SettingsManager(($this->privates['sulu_document_manager.session_manager'] ?? $this->getSuluDocumentManager_SessionManagerService()), ($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()));
    }

    /**
     * Gets the private 'sulu_core.webspace.webspace_manager.url_replacer' shared service.
     *
     * @return \Sulu\Component\Webspace\Url\Replacer
     */
    protected function getSuluCore_Webspace_WebspaceManager_UrlReplacerService()
    {
        return $this->privates['sulu_core.webspace.webspace_manager.url_replacer'] = new \Sulu\Component\Webspace\Url\Replacer();
    }

    /**
     * Gets the private 'sulu_document_manager.decorated_default_session.inner' shared service.
     *
     * @return \Jackalope\Session
     */
    protected function getSuluDocumentManager_DecoratedDefaultSession_InnerService()
    {
        return $this->privates['sulu_document_manager.decorated_default_session.inner'] = ($this->privates['doctrine_phpcr.jackalope.repository.default'] ?? $this->getDoctrinePhpcr_Jackalope_Repository_DefaultService())->login(($this->privates['doctrine_phpcr.default_credentials'] ?? ($this->privates['doctrine_phpcr.default_credentials'] = new \PHPCR\SimpleCredentials($this->getEnv('PHPCR_USERNAME'), $this->getEnv('PHPCR_PASSWORD')))), $this->getEnv('PHPCR_WORKSPACE'));
    }

    /**
     * Gets the private 'sulu_document_manager.decorated_live_session.inner' shared service.
     *
     * @return \Jackalope\Session
     */
    protected function getSuluDocumentManager_DecoratedLiveSession_InnerService()
    {
        return $this->privates['sulu_document_manager.decorated_live_session.inner'] = ($this->privates['doctrine_phpcr.jackalope.repository.live'] ?? $this->getDoctrinePhpcr_Jackalope_Repository_LiveService())->login(($this->privates['doctrine_phpcr.live_credentials'] ?? ($this->privates['doctrine_phpcr.live_credentials'] = new \PHPCR\SimpleCredentials($this->getEnv('PHPCR_USERNAME'), $this->getEnv('PHPCR_PASSWORD')))), $this->getEnv('string:PHPCR_WORKSPACE').'_live');
    }

    /**
     * Gets the private 'sulu_document_manager.document_registry' shared service.
     *
     * @return \Sulu\Component\DocumentManager\DocumentRegistry
     */
    protected function getSuluDocumentManager_DocumentRegistryService()
    {
        return $this->privates['sulu_document_manager.document_registry'] = new \Sulu\Component\DocumentManager\DocumentRegistry('en');
    }

    /**
     * Gets the private 'sulu_document_manager.event_dispatcher.standard' shared service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getSuluDocumentManager_EventDispatcher_StandardService()
    {
        $this->privates['sulu_document_manager.event_dispatcher.standard'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.structure'] ?? $this->load('getSuluPage_Search_EventSubscriber_StructureService.php'));
        }, 1 => 'indexPersistedDocument'], -10);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.structure'] ?? $this->load('getSuluPage_Search_EventSubscriber_StructureService.php'));
        }, 1 => 'indexPublishedDocument'], -256);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.structure'] ?? $this->load('getSuluPage_Search_EventSubscriber_StructureService.php'));
        }, 1 => 'deindexRemovedDocument'], 600);
        $instance->addListener('sulu_document_manager.unpublish', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.structure'] ?? $this->load('getSuluPage_Search_EventSubscriber_StructureService.php'));
        }, 1 => 'deindexUnpublishedDocument'], -1024);
        $instance->addListener('sulu_document_manager.remove_draft', [0 => function () {
            return ($this->privates['sulu_page.search.event_subscriber.structure'] ?? $this->load('getSuluPage_Search_EventSubscriber_StructureService.php'));
        }, 1 => 'indexDocumentAfterRemoveDraft'], -1024);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_page.document.subscriber.content'] ?? $this->load('getSuluPage_Document_Subscriber_ContentService.php'));
        }, 1 => 'saveStructureData'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_page.document.subscriber.content'] ?? $this->load('getSuluPage_Document_Subscriber_ContentService.php'));
        }, 1 => 'handlePersistStagedProperties'], 50);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_page.document.subscriber.content'] ?? $this->load('getSuluPage_Document_Subscriber_ContentService.php'));
        }, 1 => 'handlePersistStructureType'], 100);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_page.document.subscriber.content'] ?? $this->load('getSuluPage_Document_Subscriber_ContentService.php'));
        }, 1 => 'saveStructureData'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_page.document.subscriber.content'] ?? $this->load('getSuluPage_Document_Subscriber_ContentService.php'));
        }, 1 => 'handleHydrate'], 0);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_page.document.subscriber.content'] ?? $this->load('getSuluPage_Document_Subscriber_ContentService.php'));
        }, 1 => 'configureOptions'], 0);
        $instance->addListener('sulu_document_manager.metadata_load', [0 => function () {
            return ($this->privates['sulu_navigationContext.document.subscriber.navigation_context'] ?? ($this->privates['sulu_navigationContext.document.subscriber.navigation_context'] = new \Sulu\Component\Content\Document\Subscriber\NavigationContextSubscriber()));
        }, 1 => 'handleMetadataLoad'], 0);
        $instance->addListener('sulu_document_manager.metadata_load', [0 => function () {
            return ($this->privates['sulu_redirect_type.document.subscriber.redirect_type'] ?? ($this->privates['sulu_redirect_type.document.subscriber.redirect_type'] = new \Sulu\Component\Content\Document\Subscriber\RedirectTypeSubscriber()));
        }, 1 => 'handleMetadataLoad'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_redirect_type.document.subscriber.redirect_type'] ?? ($this->privates['sulu_redirect_type.document.subscriber.redirect_type'] = new \Sulu\Component\Content\Document\Subscriber\RedirectTypeSubscriber()));
        }, 1 => 'handlePersist'], 15);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_resource_segment.document.subscriber.resource_segment'] ?? $this->load('getSuluResourceSegment_Document_Subscriber_ResourceSegmentService.php'));
        }, 1 => 'handlePersistDocument'], 10);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_resource_segment.document.subscriber.resource_segment'] ?? $this->load('getSuluResourceSegment_Document_Subscriber_ResourceSegmentService.php'));
        }, 1 => 'handleHydrate'], -200);
        $instance->addListener('sulu_document_manager.move', [0 => function () {
            return ($this->privates['sulu_resource_segment.document.subscriber.resource_segment'] ?? $this->load('getSuluResourceSegment_Document_Subscriber_ResourceSegmentService.php'));
        }, 1 => 'updateMovedDocument'], -128);
        $instance->addListener('sulu_document_manager.copy', [0 => function () {
            return ($this->privates['sulu_resource_segment.document.subscriber.resource_segment'] ?? $this->load('getSuluResourceSegment_Document_Subscriber_ResourceSegmentService.php'));
        }, 1 => 'updateCopiedDocument'], -128);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_resource_segment.document.subscriber.resource_segment'] ?? $this->load('getSuluResourceSegment_Document_Subscriber_ResourceSegmentService.php'));
        }, 1 => 'handlePersistRoute'], -128);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.workflow_stage'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WorkflowStageService.php'));
        }, 1 => 'setWorkflowStageOnDocument'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.workflow_stage'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WorkflowStageService.php'));
        }, 1 => 'setWorkflowStageToTest'], 0);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.workflow_stage'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WorkflowStageService.php'));
        }, 1 => 'setWorkflowStageToPublished'], 0);
        $instance->addListener('sulu_document_manager.unpublish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.workflow_stage'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WorkflowStageService.php'));
        }, 1 => 'setWorkflowStageToTestAndResetPublishedDate'], 0);
        $instance->addListener('sulu_document_manager.copy', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.workflow_stage'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WorkflowStageService.php'));
        }, 1 => 'setWorkflowStageToTestForCopy'], 0);
        $instance->addListener('sulu_document_manager.restore', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.workflow_stage'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WorkflowStageService.php'));
        }, 1 => 'setWorkflowStageToTestForRestore'], -32);
        $instance->addListener('sulu_document_manager.metadata_load', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_locale'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowLocaleService.php'));
        }, 1 => 'handleMetadataLoad'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_locale'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowLocaleService.php'));
        }, 1 => 'handlePersistUpdateUrl'], 20);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_locale'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowLocaleService.php'));
        }, 1 => 'saveShadowProperties'], 15);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_locale'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowLocaleService.php'));
        }, 1 => 'handleHydrate'], 390);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_locale'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowLocaleService.php'));
        }, 1 => 'saveShadowProperties'], 15);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_locale'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowLocaleService.php'));
        }, 1 => 'handleConfigureOptions'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_copy_properties'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowCopyPropertiesService.php'));
        }, 1 => 'copyShadowProperties'], -256);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.shadow_copy_properties'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ShadowCopyPropertiesService.php'));
        }, 1 => 'copyShadowProperties'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.title'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_TitleService.php'));
        }, 1 => 'setTitleOnDocument'], -10);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.title'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_TitleService.php'));
        }, 1 => 'setTitleOnNode'], 10);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.title'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_TitleService.php'));
        }, 1 => 'setTitleOnNode'], 10);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.fallback_localization'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_FallbackLocalizationService.php'));
        }, 1 => 'handleHydrate'], 400);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.extension'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ExtensionService.php'));
        }, 1 => 'saveExtensionData'], 10);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.extension'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ExtensionService.php'));
        }, 1 => 'saveExtensionData'], 10);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.extension'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_ExtensionService.php'));
        }, 1 => 'handleHydrate'], -10);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.order'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_OrderService.php'));
        }, 1 => 'handlePersist'], 0);
        $instance->addListener('sulu_document_manager.metadata_load', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.order'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_OrderService.php'));
        }, 1 => 'handleMetadataLoad'], 0);
        $instance->addListener('sulu_document_manager.reorder', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.order'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_OrderService.php'));
        }, 1 => 'handleReorder'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.security'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_SecurityService.php'));
        }, 1 => 'handlePersist'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.security'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_SecurityService.php'));
        }, 1 => 'handleHydrate'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.webspace'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WebspaceService.php'));
        }, 1 => 'handleWebspace'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.webspace'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_WebspaceService.php'));
        }, 1 => 'handleWebspace'], -10);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.route'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_RouteService.php'));
        }, 1 => 'handleSetNodeOnPersist'], 490);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.route'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_RouteService.php'));
        }, 1 => 'handlePersist'], 5);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.route'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_RouteService.php'));
        }, 1 => 'handleHydrate'], 0);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.route'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_RouteService.php'));
        }, 1 => 'handleRemove'], 550);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.route'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_RouteService.php'));
        }, 1 => 'handlePublish'], 0);
        $instance->addListener('sulu_document_manager.metadata_load', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.target'] ?? ($this->privates['sulu_document_manager.document.subscriber.target'] = new \Sulu\Component\Content\Document\Subscriber\TargetSubscriber()));
        }, 1 => 'handleMetadataLoad'], 0);
        $instance->addListener('sulu_document_manager.metadata_load', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.robot'] ?? ($this->privates['sulu_document_manager.document.subscriber.robot'] = new \Sulu\Component\Content\Document\Subscriber\RobotSubscriber()));
        }, 1 => 'handleMetadataLoad'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'createNodeInPublicWorkspace'], -490);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'removeNodeFromPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.move', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'moveNodeInPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.copy', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'copyNodeInPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.reorder', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'reorderNodeInPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'setNodeFromPublicWorkspaceForPublishing'], 512);
        $instance->addListener('sulu_document_manager.unpublish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'setNodeFromPublicWorkspaceForUnpublishing'], 512);
        $instance->addListener('sulu_document_manager.unpublish', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'removePropertiesFromPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.remove_draft', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'copyPropertiesFromPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.flush', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.publish'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_PublishService.php'));
        }, 1 => 'flushPublicWorkspace'], 0);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.compat.content_mapper'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_Compat_ContentMapperService.php'));
        }, 1 => 'handlePreRemove'], 500);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.compat.content_mapper'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_Compat_ContentMapperService.php'));
        }, 1 => 'handlePostRemove'], -100);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.compat.content_mapper'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_Compat_ContentMapperService.php'));
        }, 1 => 'handlePersist'], 0);
        $instance->addListener('sulu_document_manager.flush', [0 => function () {
            return ($this->privates['sulu_document_manager.document.subscriber.compat.content_mapper'] ?? $this->load('getSuluDocumentManager_Document_Subscriber_Compat_ContentMapperService.php'));
        }, 1 => 'handleFlush'], 0);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.remove_content'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_RemoveContentService.php'));
        }, 1 => 'handleRemove'], 550);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_http_cache.event_subscriber.invalidation'] ?? $this->load('getSuluHttpCache_EventSubscriber_InvalidationService.php'));
        }, 1 => 'invalidateDocumentBeforePublishing'], 1024);
        $instance->addListener('sulu_document_manager.unpublish', [0 => function () {
            return ($this->privates['sulu_http_cache.event_subscriber.invalidation'] ?? $this->load('getSuluHttpCache_EventSubscriber_InvalidationService.php'));
        }, 1 => 'invalidateDocumentBeforeUnpublishing'], 1024);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_http_cache.event_subscriber.invalidation'] ?? $this->load('getSuluHttpCache_EventSubscriber_InvalidationService.php'));
        }, 1 => 'invalidateDocumentBeforeRemoving'], 1024);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.instantiator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_InstantiatorService.php'));
        }, 1 => 'handleHydrate'], 500);
        $instance->addListener('sulu_document_manager.create', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.instantiator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_InstantiatorService.php'));
        }, 1 => 'handleCreate'], 500);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleDefaultLocale'], 520);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleDocumentFromRegistry'], 510);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleStopPropagationAndResetLocale'], 509);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleHydrate'], 490);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleEndHydrate'], -500);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handlePersist'], 450);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleNodeFromRegistry'], 510);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleEndPersist'], -500);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleRemove'], 490);
        $instance->addListener('sulu_document_manager.clear', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleClear'], 500);
        $instance->addListener('sulu_document_manager.reorder', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleNodeFromRegistry'], 510);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'configureOptions'], 0);
        $instance->addListener('sulu_document_manager.remove_draft', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleNodeFromRegistry'], 512);
        $instance->addListener('sulu_document_manager.restore', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.registrator'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_RegistratorService.php'));
        }, 1 => 'handleNodeFromRegistry'], 512);
        $instance->addListener('sulu_document_manager.reorder', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.reorder'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_ReorderService.php'));
        }, 1 => 'handleReorder'], 500);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.mixin'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_MixinService.php'));
        }, 1 => 'setDocumentMixinsOnNode'], 468);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.mixin'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_MixinService.php'));
        }, 1 => 'setDocumentMixinsOnNode'], 468);
        $instance->addListener('sulu_document_manager.find', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.find'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_FindService.php'));
        }, 1 => 'handleFind'], 500);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.find'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_FindService.php'));
        }, 1 => 'configureOptions'], 0);
        $instance->addListener('sulu_document_manager.query.create', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.query'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_QueryService.php'));
        }, 1 => 'handleCreate'], 500);
        $instance->addListener('sulu_document_manager.query.create_builder', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.query'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_QueryService.php'));
        }, 1 => 'handleCreateBuilder'], 500);
        $instance->addListener('sulu_document_manager.query.execute', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.query'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_QueryService.php'));
        }, 1 => 'handleQueryExecute'], 500);
        $instance->addListener('sulu_document_manager.move', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.general'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_GeneralService.php'));
        }, 1 => 'handleMove'], 400);
        $instance->addListener('sulu_document_manager.copy', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.general'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_GeneralService.php'));
        }, 1 => 'handleCopy'], 400);
        $instance->addListener('sulu_document_manager.clear', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.general'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_GeneralService.php'));
        }, 1 => 'handleClear'], 500);
        $instance->addListener('sulu_document_manager.flush', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.general'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_GeneralService.php'));
        }, 1 => 'handleFlush'], 500);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.remove'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_RemoveService.php'));
        }, 1 => 'handleRemove'], 500);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.mapping'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_MappingService.php'));
        }, 1 => 'handleHydrate'], -100);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.mapping'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_MappingService.php'));
        }, 1 => 'handleMapping'], -100);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.core.mapping'] ?? $this->load('getSuluDocumentManager_Subscriber_Core_MappingService.php'));
        }, 1 => 'handleMapping'], -128);
        $instance->addListener('sulu_document_manager.refresh', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.refresh'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_RefreshService.php'));
        }, 1 => 'refreshDocument'], 0);
        $instance->addListener('sulu_document_manager.remove_draft', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.phpcr.refresh'] ?? $this->load('getSuluDocumentManager_Subscriber_Phpcr_RefreshService.php'));
        }, 1 => 'refreshDocumentForDeleteDraft'], -512);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.security'] ?? $this->load('getSuluDocumentManager_Subscriber_SecurityService.php'));
        }, 1 => 'setDefaultUser'], 0);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.auto_name'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AutoNameService.php'));
        }, 1 => 'configureOptions'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.auto_name'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AutoNameService.php'));
        }, 1 => 'handleScheduleRename'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.auto_name'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AutoNameService.php'));
        }, 1 => 'handlePersist'], 480);
        $instance->addListener('sulu_document_manager.move', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.auto_name'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AutoNameService.php'));
        }, 1 => 'handleMove'], 480);
        $instance->addListener('sulu_document_manager.copy', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.auto_name'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AutoNameService.php'));
        }, 1 => 'handleCopy'], 480);
        $instance->addListener('sulu_document_manager.flush', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.auto_name'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AutoNameService.php'));
        }, 1 => 'handleRename'], 510);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.path.explicit'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_Path_ExplicitService.php'));
        }, 1 => 'handlePersist'], 485);
        $instance->addListener('sulu_document_manager.configure_options', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.path.explicit'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_Path_ExplicitService.php'));
        }, 1 => 'configureOptions'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.blame'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_BlameService.php'));
        }, 1 => 'setBlamesOnDocument'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.blame'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_BlameService.php'));
        }, 1 => 'setBlamesOnNodeForPersist'], 0);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.blame'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_BlameService.php'));
        }, 1 => 'setBlamesOnNodeForPublish'], 0);
        $instance->addListener('sulu_document_manager.restore', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.blame'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_BlameService.php'));
        }, 1 => 'setChangerForRestore'], -32);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.author'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_AuthorService.php'));
        }, 1 => 'setAuthorOnDocument'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.author'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_AuthorService.php'));
        }, 1 => 'setAuthorOnNode'], 0);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.author'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_AuthorService.php'));
        }, 1 => 'setAuthorOnNode'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.timestamp'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_TimestampService.php'));
        }, 1 => 'setTimestampsOnNodeForPersist'], 0);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.timestamp'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_TimestampService.php'));
        }, 1 => 'setTimestampsOnNodeForPublish'], 0);
        $instance->addListener('sulu_document_manager.restore', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.timestamp'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_TimestampService.php'));
        }, 1 => 'setChangedForRestore'], -32);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.timestamp'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_TimestampService.php'));
        }, 1 => 'setTimestampsOnDocument'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.node_name'] ?? ($this->privates['sulu_document_manager.suscriber.behavior.node_name'] = new \Sulu\Component\DocumentManager\Subscriber\Behavior\Mapping\NodeNameSubscriber()));
        }, 1 => 'setFinalNodeName'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.node_name'] ?? ($this->privates['sulu_document_manager.suscriber.behavior.node_name'] = new \Sulu\Component\DocumentManager\Subscriber\Behavior\Mapping\NodeNameSubscriber()));
        }, 1 => 'setInitialNodeName'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.node_name'] ?? ($this->privates['sulu_document_manager.suscriber.behavior.node_name'] = new \Sulu\Component\DocumentManager\Subscriber\Behavior\Mapping\NodeNameSubscriber()));
        }, 1 => 'setFinalNodeName'], -480);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.uuid'] ?? ($this->privates['sulu_document_manager.suscriber.behavior.uuid'] = new \Sulu\Component\DocumentManager\Subscriber\Behavior\Mapping\UuidSubscriber()));
        }, 1 => 'handleUuid'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.uuid'] ?? ($this->privates['sulu_document_manager.suscriber.behavior.uuid'] = new \Sulu\Component\DocumentManager\Subscriber\Behavior\Mapping\UuidSubscriber()));
        }, 1 => 'handleUuid'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.locale'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_LocaleService.php'));
        }, 1 => 'handleLocale'], 410);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.locale'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_LocaleService.php'));
        }, 1 => 'handleLocale'], 410);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.parent'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_ParentService.php'));
        }, 1 => 'handleHydrate'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.parent'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_ParentService.php'));
        }, 1 => 'handleChangeParent'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.parent'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_ParentService.php'));
        }, 1 => 'handleSetParentNodeFromDocument'], 490);
        $instance->addListener('sulu_document_manager.move', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.parent'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_ParentService.php'));
        }, 1 => 'handleMove'], 0);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.suscriber.behavior.children'] ?? $this->load('getSuluDocumentManager_Suscriber_Behavior_ChildrenService.php'));
        }, 1 => 'handleHydrate'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.path'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_PathService.php'));
        }, 1 => 'setInitialPath'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.path'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_PathService.php'));
        }, 1 => 'setFinalPath'], -495);
        $instance->addListener('sulu_document_manager.hydrate', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.path'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_PathService.php'));
        }, 1 => 'setFinalPath'], 0);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.filing'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_FilingService.php'));
        }, 1 => 'handlePersist'], 485);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.alias'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_AliasService.php'));
        }, 1 => 'handlePersist'], 490);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_document_manager.subscriber.behavior.base_path'] ?? $this->load('getSuluDocumentManager_Subscriber_Behavior_BasePathService.php'));
        }, 1 => 'handlePersist'], 500);
        $instance->addListener('sulu_document_manager.persist', [0 => function () {
            return ($this->privates['sulu_custom_urls.subscriber'] ?? $this->load('getSuluCustomUrls_SubscriberService.php'));
        }, 1 => 'handlePersist'], 0);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_custom_urls.subscriber'] ?? $this->load('getSuluCustomUrls_SubscriberService.php'));
        }, 1 => 'handleRemove'], 550);
        $instance->addListener('sulu_document_manager.publish', [0 => function () {
            return ($this->privates['sulu_custom_urls.event_subscriber.invalidation'] ?? $this->load('getSuluCustomUrls_EventSubscriber_InvalidationService.php'));
        }, 1 => 'invalidateDocumentBeforePublishing'], 1024);
        $instance->addListener('sulu_document_manager.remove', [0 => function () {
            return ($this->privates['sulu_custom_urls.event_subscriber.invalidation'] ?? $this->load('getSuluCustomUrls_EventSubscriber_InvalidationService.php'));
        }, 1 => 'invalidateDocumentBeforeRemoving'], 1024);

        return $instance;
    }

    /**
     * Gets the private 'sulu_document_manager.metadata_factory' shared service.
     *
     * @return \Sulu\Component\DocumentManager\Metadata\MetadataFactory
     */
    protected function getSuluDocumentManager_MetadataFactoryService()
    {
        return $this->privates['sulu_document_manager.metadata_factory'] = new \Sulu\Component\DocumentManager\Metadata\MetadataFactory(($this->services['sulu_document_manager.metadata_factory.base'] ?? $this->getSuluDocumentManager_MetadataFactory_BaseService()));
    }

    /**
     * Gets the private 'sulu_document_manager.namespace_registry' shared service.
     *
     * @return \Sulu\Component\DocumentManager\NamespaceRegistry
     */
    protected function getSuluDocumentManager_NamespaceRegistryService()
    {
        return $this->privates['sulu_document_manager.namespace_registry'] = new \Sulu\Component\DocumentManager\NamespaceRegistry($this->parameters['sulu_document_manager.namespace_mapping']);
    }

    /**
     * Gets the private 'sulu_document_manager.node_manager' shared service.
     *
     * @return \Sulu\Component\DocumentManager\NodeManager
     */
    protected function getSuluDocumentManager_NodeManagerService()
    {
        return $this->privates['sulu_document_manager.node_manager'] = new \Sulu\Component\DocumentManager\NodeManager(($this->services['sulu_test.doctrine_phpcr.default_session'] ?? $this->getSuluTest_DoctrinePhpcr_DefaultSessionService()));
    }

    /**
     * Gets the private 'sulu_document_manager.path_segment_registry' shared service.
     *
     * @return \Sulu\Component\DocumentManager\PathSegmentRegistry
     */
    protected function getSuluDocumentManager_PathSegmentRegistryService()
    {
        return $this->privates['sulu_document_manager.path_segment_registry'] = new \Sulu\Component\DocumentManager\PathSegmentRegistry($this->parameters['sulu_document_manager.segments']);
    }

    /**
     * Gets the private 'sulu_document_manager.proxy_factory' shared service.
     *
     * @return \Sulu\Component\DocumentManager\ProxyFactory
     */
    protected function getSuluDocumentManager_ProxyFactoryService()
    {
        return $this->privates['sulu_document_manager.proxy_factory'] = new \Sulu\Component\DocumentManager\ProxyFactory(($this->privates['sulu_document_manager.proxy_manager.factory.ghost'] ?? $this->getSuluDocumentManager_ProxyManager_Factory_GhostService()), ($this->privates['sulu_document_manager.event_dispatcher.standard'] ?? $this->getSuluDocumentManager_EventDispatcher_StandardService()), ($this->privates['sulu_document_manager.document_registry'] ?? ($this->privates['sulu_document_manager.document_registry'] = new \Sulu\Component\DocumentManager\DocumentRegistry('en'))), ($this->privates['sulu_document_manager.metadata_factory'] ?? $this->getSuluDocumentManager_MetadataFactoryService()));
    }

    /**
     * Gets the private 'sulu_document_manager.proxy_manager.factory.ghost' shared service.
     *
     * @return \ProxyManager\Factory\LazyLoadingGhostFactory
     */
    protected function getSuluDocumentManager_ProxyManager_Factory_GhostService()
    {
        return $this->privates['sulu_document_manager.proxy_manager.factory.ghost'] = new \ProxyManager\Factory\LazyLoadingGhostFactory(($this->privates['sulu_core.proxy_manager.configuration'] ?? $this->getSuluCore_ProxyManager_ConfigurationService()));
    }

    /**
     * Gets the private 'sulu_document_manager.session_manager' shared service.
     *
     * @return \Sulu\Bundle\DocumentManagerBundle\Session\SessionManager
     */
    protected function getSuluDocumentManager_SessionManagerService()
    {
        return $this->privates['sulu_document_manager.session_manager'] = new \Sulu\Bundle\DocumentManagerBundle\Session\SessionManager(($this->services['sulu_test.doctrine_phpcr.default_session'] ?? $this->getSuluTest_DoctrinePhpcr_DefaultSessionService()), ($this->services['sulu_test.doctrine_phpcr.live_session'] ?? $this->getSuluTest_DoctrinePhpcr_LiveSessionService()));
    }

    /**
     * Gets the private 'sulu_form.builder' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Form\Builder
     */
    protected function getSuluForm_BuilderService()
    {
        return $this->privates['sulu_form.builder'] = new \Sulu\Bundle\FormBundle\Form\Builder(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->privates['sulu_form.dynamic.form_field_type_pool'] ?? $this->getSuluForm_Dynamic_FormFieldTypePoolService()), ($this->privates['sulu_form.title_provider.pool'] ?? $this->getSuluForm_TitleProvider_PoolService()), ($this->privates['sulu_form.repository.form'] ?? $this->getSuluForm_Repository_FormService()), ($this->services['form.factory'] ?? $this->getForm_FactoryService()), ($this->privates['sulu_form.checksum'] ?? ($this->privates['sulu_form.checksum'] = new \Sulu\Bundle\FormBundle\Dynamic\Checksum('secret'))));
    }

    /**
     * Gets the private 'sulu_form.checksum' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Checksum
     */
    protected function getSuluForm_ChecksumService()
    {
        return $this->privates['sulu_form.checksum'] = new \Sulu\Bundle\FormBundle\Dynamic\Checksum('secret');
    }

    /**
     * Gets the private 'sulu_form.configuration.form_configuration_factory' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory
     */
    protected function getSuluForm_Configuration_FormConfigurationFactoryService()
    {
        return $this->privates['sulu_form.configuration.form_configuration_factory'] = new \Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory(($this->privates['sulu_form.media_collection_strategy.single'] ?? $this->getSuluForm_MediaCollectionStrategy_SingleService()), 'SuluFormBundle:mails:notify.html.twig', 'SuluFormBundle:mails:customer.html.twig', 'SuluFormBundle:mails:notify_plain_text.html.twig', 'SuluFormBundle:mails:customer_plain_text.html.twig');
    }

    /**
     * Gets the private 'sulu_form.dynamic.form_field_type_pool' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool
     */
    protected function getSuluForm_Dynamic_FormFieldTypePoolService()
    {
        return $this->privates['sulu_form.dynamic.form_field_type_pool'] = new \Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool(['text' => ($this->privates['sulu_form.dynamic.type_text'] ?? ($this->privates['sulu_form.dynamic.type_text'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\TextType())), 'firstName' => ($this->privates['sulu_form.dynamic.type_firstname'] ?? ($this->privates['sulu_form.dynamic.type_firstname'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FirstNameType())), 'lastName' => ($this->privates['sulu_form.dynamic.type_lastname'] ?? ($this->privates['sulu_form.dynamic.type_lastname'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\LastNameType())), 'street' => ($this->privates['sulu_form.dynamic.type_street'] ?? ($this->privates['sulu_form.dynamic.type_street'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\StreetType())), 'zip' => ($this->privates['sulu_form.dynamic.type_zip'] ?? ($this->privates['sulu_form.dynamic.type_zip'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\ZipType())), 'city' => ($this->privates['sulu_form.dynamic.type_city'] ?? ($this->privates['sulu_form.dynamic.type_city'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CityType())), 'state' => ($this->privates['sulu_form.dynamic.type_state'] ?? ($this->privates['sulu_form.dynamic.type_state'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\StateType())), 'function' => ($this->privates['sulu_form.dynamic.type_function'] ?? ($this->privates['sulu_form.dynamic.type_function'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FunctionType())), 'company' => ($this->privates['sulu_form.dynamic.type_company'] ?? ($this->privates['sulu_form.dynamic.type_company'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CompanyType())), 'phone' => ($this->privates['sulu_form.dynamic.type_phone'] ?? ($this->privates['sulu_form.dynamic.type_phone'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\PhoneType())), 'fax' => ($this->privates['sulu_form.dynamic.type_fax'] ?? ($this->privates['sulu_form.dynamic.type_fax'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FaxType())), 'title' => ($this->privates['sulu_form.dynamic.type_title'] ?? ($this->privates['sulu_form.dynamic.type_title'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\TitleType())), 'textarea' => ($this->privates['sulu_form.dynamic.type_textarea'] ?? ($this->privates['sulu_form.dynamic.type_textarea'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\TextareaType())), 'headline' => ($this->privates['sulu_form.dynamic.type_headline'] ?? ($this->privates['sulu_form.dynamic.type_headline'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\HeadlineType())), 'spacer' => ($this->privates['sulu_form.dynamic.type_spacer'] ?? ($this->privates['sulu_form.dynamic.type_spacer'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\SpacerType())), 'freeText' => ($this->privates['sulu_form.dynamic.type_freetext'] ?? ($this->privates['sulu_form.dynamic.type_freetext'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FreeTextType())), 'country' => ($this->privates['sulu_form.dynamic.type_country'] ?? ($this->privates['sulu_form.dynamic.type_country'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CountryType())), 'email' => ($this->privates['sulu_form.dynamic.type_email'] ?? ($this->privates['sulu_form.dynamic.type_email'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\EmailType())), 'date' => ($this->privates['sulu_form.dynamic.type_date'] ?? ($this->privates['sulu_form.dynamic.type_date'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\DateType())), 'checkbox' => ($this->privates['sulu_form.dynamic.type_checkobox'] ?? ($this->privates['sulu_form.dynamic.type_checkobox'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxType())), 'checkboxMultiple' => ($this->privates['sulu_form.dynamic.type_checkboxmultiple'] ?? ($this->privates['sulu_form.dynamic.type_checkboxmultiple'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxMultipleType())), 'dropdown' => ($this->privates['sulu_form.dynamic.type_dropdown'] ?? ($this->privates['sulu_form.dynamic.type_dropdown'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\DropdownType())), 'radioButtons' => ($this->privates['sulu_form.dynamic.type_radiobuttons'] ?? ($this->privates['sulu_form.dynamic.type_radiobuttons'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\RadioButtonsType())), 'dropdownMultiple' => ($this->privates['sulu_form.dynamic.type_dropdownmultiple'] ?? ($this->privates['sulu_form.dynamic.type_dropdownmultiple'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\DropdownMultiple())), 'salutation' => ($this->privates['sulu_form.dynamic.type_salutation'] ?? ($this->privates['sulu_form.dynamic.type_salutation'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\SalutationType())), 'attachment' => ($this->privates['sulu_form.dynamic.type_attachment'] ?? ($this->privates['sulu_form.dynamic.type_attachment'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\AttachmentType()))]);
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_attachment' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\AttachmentType
     */
    protected function getSuluForm_Dynamic_TypeAttachmentService()
    {
        return $this->privates['sulu_form.dynamic.type_attachment'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\AttachmentType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_checkboxmultiple' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxMultipleType
     */
    protected function getSuluForm_Dynamic_TypeCheckboxmultipleService()
    {
        return $this->privates['sulu_form.dynamic.type_checkboxmultiple'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxMultipleType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_checkobox' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxType
     */
    protected function getSuluForm_Dynamic_TypeCheckoboxService()
    {
        return $this->privates['sulu_form.dynamic.type_checkobox'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_city' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\CityType
     */
    protected function getSuluForm_Dynamic_TypeCityService()
    {
        return $this->privates['sulu_form.dynamic.type_city'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CityType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_company' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\CompanyType
     */
    protected function getSuluForm_Dynamic_TypeCompanyService()
    {
        return $this->privates['sulu_form.dynamic.type_company'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CompanyType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_country' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\CountryType
     */
    protected function getSuluForm_Dynamic_TypeCountryService()
    {
        return $this->privates['sulu_form.dynamic.type_country'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\CountryType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_date' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\DateType
     */
    protected function getSuluForm_Dynamic_TypeDateService()
    {
        return $this->privates['sulu_form.dynamic.type_date'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\DateType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_dropdown' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\DropdownType
     */
    protected function getSuluForm_Dynamic_TypeDropdownService()
    {
        return $this->privates['sulu_form.dynamic.type_dropdown'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\DropdownType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_dropdownmultiple' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\DropdownMultiple
     */
    protected function getSuluForm_Dynamic_TypeDropdownmultipleService()
    {
        return $this->privates['sulu_form.dynamic.type_dropdownmultiple'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\DropdownMultiple();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_email' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\EmailType
     */
    protected function getSuluForm_Dynamic_TypeEmailService()
    {
        return $this->privates['sulu_form.dynamic.type_email'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\EmailType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_fax' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\FaxType
     */
    protected function getSuluForm_Dynamic_TypeFaxService()
    {
        return $this->privates['sulu_form.dynamic.type_fax'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FaxType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_firstname' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\FirstNameType
     */
    protected function getSuluForm_Dynamic_TypeFirstnameService()
    {
        return $this->privates['sulu_form.dynamic.type_firstname'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FirstNameType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_freetext' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\FreeTextType
     */
    protected function getSuluForm_Dynamic_TypeFreetextService()
    {
        return $this->privates['sulu_form.dynamic.type_freetext'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FreeTextType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_function' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\FunctionType
     */
    protected function getSuluForm_Dynamic_TypeFunctionService()
    {
        return $this->privates['sulu_form.dynamic.type_function'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\FunctionType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_headline' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\HeadlineType
     */
    protected function getSuluForm_Dynamic_TypeHeadlineService()
    {
        return $this->privates['sulu_form.dynamic.type_headline'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\HeadlineType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_lastname' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\LastNameType
     */
    protected function getSuluForm_Dynamic_TypeLastnameService()
    {
        return $this->privates['sulu_form.dynamic.type_lastname'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\LastNameType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_phone' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\PhoneType
     */
    protected function getSuluForm_Dynamic_TypePhoneService()
    {
        return $this->privates['sulu_form.dynamic.type_phone'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\PhoneType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_radiobuttons' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\RadioButtonsType
     */
    protected function getSuluForm_Dynamic_TypeRadiobuttonsService()
    {
        return $this->privates['sulu_form.dynamic.type_radiobuttons'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\RadioButtonsType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_salutation' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\SalutationType
     */
    protected function getSuluForm_Dynamic_TypeSalutationService()
    {
        return $this->privates['sulu_form.dynamic.type_salutation'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\SalutationType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_spacer' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\SpacerType
     */
    protected function getSuluForm_Dynamic_TypeSpacerService()
    {
        return $this->privates['sulu_form.dynamic.type_spacer'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\SpacerType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_state' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\StateType
     */
    protected function getSuluForm_Dynamic_TypeStateService()
    {
        return $this->privates['sulu_form.dynamic.type_state'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\StateType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_street' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\StreetType
     */
    protected function getSuluForm_Dynamic_TypeStreetService()
    {
        return $this->privates['sulu_form.dynamic.type_street'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\StreetType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_text' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\TextType
     */
    protected function getSuluForm_Dynamic_TypeTextService()
    {
        return $this->privates['sulu_form.dynamic.type_text'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\TextType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_textarea' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\TextareaType
     */
    protected function getSuluForm_Dynamic_TypeTextareaService()
    {
        return $this->privates['sulu_form.dynamic.type_textarea'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\TextareaType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_title' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\TitleType
     */
    protected function getSuluForm_Dynamic_TypeTitleService()
    {
        return $this->privates['sulu_form.dynamic.type_title'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\TitleType();
    }

    /**
     * Gets the private 'sulu_form.dynamic.type_zip' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Dynamic\Types\ZipType
     */
    protected function getSuluForm_Dynamic_TypeZipService()
    {
        return $this->privates['sulu_form.dynamic.type_zip'] = new \Sulu\Bundle\FormBundle\Dynamic\Types\ZipType();
    }

    /**
     * Gets the private 'sulu_form.handler' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Form\Handler
     */
    protected function getSuluForm_HandlerService()
    {
        return $this->privates['sulu_form.handler'] = new \Sulu\Bundle\FormBundle\Form\Handler(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->privates['sulu.mail.helper'] ?? $this->getSulu_Mail_HelperService()), ($this->services['twig'] ?? $this->getTwigService()), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->services['sulu_media.media_manager'] ?? $this->getSuluMedia_MediaManagerService()), ($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /**
     * Gets the private 'sulu_form.media_collection_strategy.single' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Media\CollectionStrategySingle
     */
    protected function getSuluForm_MediaCollectionStrategy_SingleService()
    {
        return $this->privates['sulu_form.media_collection_strategy.single'] = new \Sulu\Bundle\FormBundle\Media\CollectionStrategySingle(($this->services['sulu_media.system_collections.manager'] ?? $this->getSuluMedia_SystemCollections_ManagerService()));
    }

    /**
     * Gets the private 'sulu_form.repository.form' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Repository\FormRepository
     */
    protected function getSuluForm_Repository_FormService()
    {
        return $this->privates['sulu_form.repository.form'] = ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService())->getRepository('SuluFormBundle:Form');
    }

    /**
     * Gets the private 'sulu_form.request_listener' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Event\RequestListener
     */
    protected function getSuluForm_RequestListenerService()
    {
        return $this->privates['sulu_form.request_listener'] = new \Sulu\Bundle\FormBundle\Event\RequestListener(($this->privates['sulu_form.builder'] ?? $this->getSuluForm_BuilderService()), ($this->privates['sulu_form.handler'] ?? $this->getSuluForm_HandlerService()), ($this->privates['sulu_form.configuration.form_configuration_factory'] ?? $this->getSuluForm_Configuration_FormConfigurationFactoryService()), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));
    }

    /**
     * Gets the private 'sulu_form.title_provider.page' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\TitleProvider\StructureTitleProvider
     */
    protected function getSuluForm_TitleProvider_PageService()
    {
        return $this->privates['sulu_form.title_provider.page'] = new \Sulu\Bundle\FormBundle\TitleProvider\StructureTitleProvider(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'sulu_form.title_provider.pool' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPool
     */
    protected function getSuluForm_TitleProvider_PoolService()
    {
        return $this->privates['sulu_form.title_provider.pool'] = new \Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPool(['page' => ($this->privates['sulu_form.title_provider.page'] ?? $this->getSuluForm_TitleProvider_PageService())]);
    }

    /**
     * Gets the private 'sulu_form.twig_extension' shared service.
     *
     * @return \Sulu\Bundle\FormBundle\Twig\FormTwigExtension
     */
    protected function getSuluForm_TwigExtensionService()
    {
        return $this->privates['sulu_form.twig_extension'] = new \Sulu\Bundle\FormBundle\Twig\FormTwigExtension(($this->privates['sulu_form.builder'] ?? $this->getSuluForm_BuilderService()));
    }

    /**
     * Gets the private 'sulu_http_cache.cache_lifetime.resolver' shared service.
     *
     * @return \Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeResolver
     */
    protected function getSuluHttpCache_CacheLifetime_ResolverService()
    {
        return $this->privates['sulu_http_cache.cache_lifetime.resolver'] = new \Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeResolver();
    }

    /**
     * Gets the private 'sulu_markup.link_tag' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Markup\LinkTag
     */
    protected function getSuluMarkup_LinkTagService()
    {
        return $this->privates['sulu_markup.link_tag'] = new \Sulu\Bundle\MarkupBundle\Markup\LinkTag(($this->privates['sulu_markup.link_tag.provider_pool'] ?? $this->getSuluMarkup_LinkTag_ProviderPoolService()));
    }

    /**
     * Gets the private 'sulu_markup.link_tag.provider_pool' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Markup\Link\LinkProviderPool
     */
    protected function getSuluMarkup_LinkTag_ProviderPoolService()
    {
        return $this->privates['sulu_markup.link_tag.provider_pool'] = new \Sulu\Bundle\MarkupBundle\Markup\Link\LinkProviderPool(['page' => ($this->privates['sulu_page.link_tag.page_provider'] ?? $this->getSuluPage_LinkTag_PageProviderService()), 'media' => ($this->privates['sulu_media.media_link_provider'] ?? $this->getSuluMedia_MediaLinkProviderService())]);
    }

    /**
     * Gets the private 'sulu_markup.parser' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Markup\HtmlMarkupParser
     */
    protected function getSuluMarkup_ParserService()
    {
        return $this->privates['sulu_markup.parser'] = new \Sulu\Bundle\MarkupBundle\Markup\HtmlMarkupParser(($this->privates['sulu_markup.tag.registry'] ?? $this->getSuluMarkup_Tag_RegistryService()), ($this->privates['sulu_markup.parser.delegating_html_extractor'] ?? $this->getSuluMarkup_Parser_DelegatingHtmlExtractorService()));
    }

    /**
     * Gets the private 'sulu_markup.parser.delegating_html_extractor' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Markup\DelegatingTagExtractor
     */
    protected function getSuluMarkup_Parser_DelegatingHtmlExtractorService()
    {
        return $this->privates['sulu_markup.parser.delegating_html_extractor'] = new \Sulu\Bundle\MarkupBundle\Markup\DelegatingTagExtractor([0 => ($this->services['sulu_markup.parser.html_extractor'] ?? ($this->services['sulu_markup.parser.html_extractor'] = new \Sulu\Bundle\MarkupBundle\Markup\HtmlTagExtractor('sulu')))]);
    }

    /**
     * Gets the private 'sulu_markup.response_listener' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Listener\MarkupListener
     */
    protected function getSuluMarkup_ResponseListenerService()
    {
        return $this->privates['sulu_markup.response_listener'] = new \Sulu\Bundle\MarkupBundle\Listener\MarkupListener(['html' => ($this->privates['sulu_markup.parser'] ?? $this->getSuluMarkup_ParserService())]);
    }

    /**
     * Gets the private 'sulu_markup.tag.registry' shared service.
     *
     * @return \Sulu\Bundle\MarkupBundle\Tag\TagRegistry
     */
    protected function getSuluMarkup_Tag_RegistryService()
    {
        return $this->privates['sulu_markup.tag.registry'] = new \Sulu\Bundle\MarkupBundle\Tag\TagRegistry(['html' => ['sulu' => ['link' => ($this->privates['sulu_markup.link_tag'] ?? $this->getSuluMarkup_LinkTagService())]]]);
    }

    /**
     * Gets the private 'sulu_media.adapter.imagick' shared service.
     *
     * @return \Imagine\Imagick\Imagine
     */
    protected function getSuluMedia_Adapter_ImagickService()
    {
        return $this->privates['sulu_media.adapter.imagick'] = new \Imagine\Imagick\Imagine();
    }

    /**
     * Gets the private 'sulu_media.file_validator' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\FileValidator\FileValidator
     */
    protected function getSuluMedia_FileValidatorService()
    {
        return $this->privates['sulu_media.file_validator'] = new \Sulu\Bundle\MediaBundle\Media\FileValidator\FileValidator();
    }

    /**
     * Gets the private 'sulu_media.format_cache' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\FormatCache\LocalFormatCache
     */
    protected function getSuluMedia_FormatCacheService()
    {
        return $this->privates['sulu_media.format_cache'] = new \Sulu\Bundle\MediaBundle\Media\FormatCache\LocalFormatCache(($this->services['filesystem'] ?? ($this->services['filesystem'] = new \Symfony\Component\Filesystem\Filesystem())), ($this->targetDirs[4].'/public/uploads/media'), '/uploads/media/{slug}', 10, $this->parameters['sulu_media.image.formats']);
    }

    /**
     * Gets the private 'sulu_media.image.converter' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\ImagineImageConverter
     */
    protected function getSuluMedia_Image_ConverterService()
    {
        return $this->privates['sulu_media.image.converter'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\ImagineImageConverter(($this->privates['sulu_media.adapter.imagick'] ?? ($this->privates['sulu_media.adapter.imagick'] = new \Imagine\Imagick\Imagine())), ($this->services['sulu_media.storage'] ?? $this->getSuluMedia_StorageService()), ($this->privates['sulu_media.image.media_extractor'] ?? $this->getSuluMedia_Image_MediaExtractorService()), ($this->privates['sulu_media.image.transformation_pool'] ?? $this->getSuluMedia_Image_TransformationPoolService()), ($this->privates['sulu_media.image.focus'] ?? ($this->privates['sulu_media.image.focus'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Focus\Focus())), ($this->privates['sulu_media.image.scaler'] ?? ($this->privates['sulu_media.image.scaler'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Scaler\Scaler())), ($this->privates['sulu_media.image.cropper'] ?? ($this->privates['sulu_media.image.cropper'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Cropper\Cropper())), $this->parameters['sulu_media.image.formats']);
    }

    /**
     * Gets the private 'sulu_media.image.cropper' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Cropper\Cropper
     */
    protected function getSuluMedia_Image_CropperService()
    {
        return $this->privates['sulu_media.image.cropper'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Cropper\Cropper();
    }

    /**
     * Gets the private 'sulu_media.image.focus' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Focus\Focus
     */
    protected function getSuluMedia_Image_FocusService()
    {
        return $this->privates['sulu_media.image.focus'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Focus\Focus();
    }

    /**
     * Gets the private 'sulu_media.image.media_extractor' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\MediaImageExtractor
     */
    protected function getSuluMedia_Image_MediaExtractorService()
    {
        return $this->privates['sulu_media.image.media_extractor'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\MediaImageExtractor(($this->privates['sulu_media.adapter.imagick'] ?? ($this->privates['sulu_media.adapter.imagick'] = new \Imagine\Imagick\Imagine())), ($this->privates['sulu_media.video_thumbnail_generator'] ?? ($this->privates['sulu_media.video_thumbnail_generator'] = new \Sulu\Bundle\MediaBundle\Media\Video\VideoThumbnailService(NULL))), 'gs');
    }

    /**
     * Gets the private 'sulu_media.image.scaler' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\Scaler\Scaler
     */
    protected function getSuluMedia_Image_ScalerService()
    {
        return $this->privates['sulu_media.image.scaler'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Scaler\Scaler();
    }

    /**
     * Gets the private 'sulu_media.image.transformation_pool' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\ImageConverter\TransformationPool
     */
    protected function getSuluMedia_Image_TransformationPoolService()
    {
        $this->privates['sulu_media.image.transformation_pool'] = $instance = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\TransformationPool();

        $instance->add(($this->services['sulu_media.image.transformation.crop'] ?? ($this->services['sulu_media.image.transformation.crop'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\CropTransformation())), 'crop');
        $instance->add(($this->services['sulu_media.image.transformation.paste'] ?? $this->getSuluMedia_Image_Transformation_PasteService()), 'paste');
        $instance->add(($this->services['sulu_media.image.transformation.blur'] ?? ($this->services['sulu_media.image.transformation.blur'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\BlurTransformation())), 'blur');
        $instance->add(($this->services['sulu_media.image.transformation.gamma'] ?? ($this->services['sulu_media.image.transformation.gamma'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\GammaTransformation())), 'gamma');
        $instance->add(($this->services['sulu_media.image.transformation.grayscale'] ?? ($this->services['sulu_media.image.transformation.grayscale'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\GrayscaleTransformation())), 'grayscale');
        $instance->add(($this->services['sulu_media.image.transformation.negative'] ?? ($this->services['sulu_media.image.transformation.negative'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\NegativeTransformation())), 'negative');
        $instance->add(($this->services['sulu_media.image.transformation.sharpen'] ?? ($this->services['sulu_media.image.transformation.sharpen'] = new \Sulu\Bundle\MediaBundle\Media\ImageConverter\Transformation\SharpenTransformation())), 'sharpen');

        return $instance;
    }

    /**
     * Gets the private 'sulu_media.media_audience_targeting_subscriber' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\EventListener\MediaAudienceTargetingSubscriber
     */
    protected function getSuluMedia_MediaAudienceTargetingSubscriberService()
    {
        return $this->privates['sulu_media.media_audience_targeting_subscriber'] = new \Sulu\Bundle\MediaBundle\EventListener\MediaAudienceTargetingSubscriber('Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroup');
    }

    /**
     * Gets the private 'sulu_media.media_link_provider' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Markup\Link\MediaLinkProvider
     */
    protected function getSuluMedia_MediaLinkProviderService()
    {
        return $this->privates['sulu_media.media_link_provider'] = new \Sulu\Bundle\MediaBundle\Markup\Link\MediaLinkProvider(($this->services['sulu.repository.media'] ?? $this->getSulu_Repository_MediaService()), ($this->services['sulu_media.media_manager'] ?? $this->getSuluMedia_MediaManagerService()));
    }

    /**
     * Gets the private 'sulu_media.storage.local.file_system' shared service.
     *
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    protected function getSuluMedia_Storage_Local_FileSystemService()
    {
        return $this->privates['sulu_media.storage.local.file_system'] = new \Symfony\Component\Filesystem\Filesystem();
    }

    /**
     * Gets the private 'sulu_media.system_collections.cache' shared service.
     *
     * @return \Sulu\Component\Cache\DataCache
     */
    protected function getSuluMedia_SystemCollections_CacheService()
    {
        return $this->privates['sulu_media.system_collections.cache'] = new \Sulu\Component\Cache\DataCache(($this->targetDirs[0].'/sulu/system_collection.cache'));
    }

    /**
     * Gets the private 'sulu_media.twig_extension.disposition_type' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Twig\DispositionTypeTwigExtension
     */
    protected function getSuluMedia_TwigExtension_DispositionTypeService()
    {
        return $this->privates['sulu_media.twig_extension.disposition_type'] = new \Sulu\Bundle\MediaBundle\Twig\DispositionTypeTwigExtension();
    }

    /**
     * Gets the private 'sulu_media.twig_extension.media' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Twig\MediaTwigExtension
     */
    protected function getSuluMedia_TwigExtension_MediaService()
    {
        return $this->privates['sulu_media.twig_extension.media'] = new \Sulu\Bundle\MediaBundle\Twig\MediaTwigExtension(($this->services['sulu_media.media_manager'] ?? $this->getSuluMedia_MediaManagerService()));
    }

    /**
     * Gets the private 'sulu_media.type_manager' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\TypeManager\TypeManager
     */
    protected function getSuluMedia_TypeManagerService()
    {
        return $this->privates['sulu_media.type_manager'] = new \Sulu\Bundle\MediaBundle\Media\TypeManager\TypeManager(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), $this->parameters['sulu_media.media.types'], $this->parameters['sulu_media.media.blocked_file_types']);
    }

    /**
     * Gets the private 'sulu_media.video_thumbnail_generator' shared service.
     *
     * @return \Sulu\Bundle\MediaBundle\Media\Video\VideoThumbnailService
     */
    protected function getSuluMedia_VideoThumbnailGeneratorService()
    {
        return $this->privates['sulu_media.video_thumbnail_generator'] = new \Sulu\Bundle\MediaBundle\Media\Video\VideoThumbnailService(NULL);
    }

    /**
     * Gets the private 'sulu_page.export.manager' shared service.
     *
     * @return \Sulu\Component\Export\Manager\ExportManager
     */
    protected function getSuluPage_Export_ManagerService()
    {
        $this->privates['sulu_page.export.manager'] = $instance = new \Sulu\Component\Export\Manager\ExportManager(($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()));

        $instance->add('number', '1.2.xliff', ['translate' => true]);
        $instance->add('text_line', '1.2.xliff', ['translate' => true]);
        $instance->add('text_area', '1.2.xliff', ['translate' => true]);
        $instance->add('text_editor', '1.2.xliff', ['translate' => true]);
        $instance->add('resource_locator', '1.2.xliff', ['translate' => false]);
        $instance->add('block', '1.2.xliff', ['translate' => false]);
        $instance->add('smart_content', '1.2.xliff', ['translate' => false]);
        $instance->add('teaser_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('page_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('single_page_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('phone', '1.2.xliff', ['translate' => false]);
        $instance->add('password', '1.2.xliff', ['translate' => false]);
        $instance->add('url', '1.2.xliff', ['translate' => false]);
        $instance->add('email', '1.2.xliff', ['translate' => false]);
        $instance->add('date', '1.2.xliff', ['translate' => false]);
        $instance->add('time', '1.2.xliff', ['translate' => false]);
        $instance->add('color', '1.2.xliff', ['translate' => false]);
        $instance->add('checkbox', '1.2.xliff', ['translate' => false]);
        $instance->add('select', '1.2.xliff', ['translate' => false]);
        $instance->add('single_select', '1.2.xliff', ['translate' => false]);
        $instance->add('contact_account_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('single_contact_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('single_account_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('tag_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('media_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('single_media_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('category_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('snippet_selection', '1.2.xliff', ['translate' => false]);
        $instance->add('location', '1.2.xliff', ['translate' => false]);
        $instance->add('target_group_selection', '1.2.xliff', ['translate' => false]);

        return $instance;
    }

    /**
     * Gets the private 'sulu_page.export_twig_extension' shared service.
     *
     * @return \Sulu\Bundle\PageBundle\Twig\ExportTwigExtension
     */
    protected function getSuluPage_ExportTwigExtensionService()
    {
        return $this->privates['sulu_page.export_twig_extension'] = new \Sulu\Bundle\PageBundle\Twig\ExportTwigExtension(($this->privates['sulu_page.export.manager'] ?? $this->getSuluPage_Export_ManagerService()));
    }

    /**
     * Gets the private 'sulu_page.extension.excerpt' shared service.
     *
     * @return \Sulu\Bundle\PageBundle\Content\Structure\ExcerptStructureExtension
     */
    protected function getSuluPage_Extension_ExcerptService()
    {
        return $this->privates['sulu_page.extension.excerpt'] = new \Sulu\Bundle\PageBundle\Content\Structure\ExcerptStructureExtension(($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()), ($this->privates['sulu_page.export.manager'] ?? $this->getSuluPage_Export_ManagerService()), ($this->privates['sulu_page.import.manager'] ?? $this->getSuluPage_Import_ManagerService()), ($this->privates['sulu_search.search.factory'] ?? ($this->privates['sulu_search.search.factory'] = new \Sulu\Bundle\SearchBundle\Search\Factory())));
    }

    /**
     * Gets the private 'sulu_page.extension.seo' shared service.
     *
     * @return \Sulu\Bundle\PageBundle\Content\Structure\SeoStructureExtension
     */
    protected function getSuluPage_Extension_SeoService()
    {
        return $this->privates['sulu_page.extension.seo'] = new \Sulu\Bundle\PageBundle\Content\Structure\SeoStructureExtension();
    }

    /**
     * Gets the private 'sulu_page.import.manager' shared service.
     *
     * @return \Sulu\Component\Import\Manager\ImportManager
     */
    protected function getSuluPage_Import_ManagerService()
    {
        return $this->privates['sulu_page.import.manager'] = new \Sulu\Component\Import\Manager\ImportManager(($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()));
    }

    /**
     * Gets the private 'sulu_page.link_tag.page_provider' shared service.
     *
     * @return \Sulu\Bundle\PageBundle\Markup\Link\PageLinkProvider
     */
    protected function getSuluPage_LinkTag_PageProviderService()
    {
        return $this->privates['sulu_page.link_tag.page_provider'] = new \Sulu\Bundle\PageBundle\Markup\Link\PageLinkProvider(($this->services['sulu_page.content_repository'] ?? $this->getSuluPage_ContentRepositoryService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->services['translator'] ?? $this->getTranslatorService()), 'test');
    }

    /**
     * Gets the private 'sulu_page.structure.loader.xml' shared service.
     *
     * @return \Sulu\Component\Content\Metadata\Loader\StructureXmlLoader
     */
    protected function getSuluPage_Structure_Loader_XmlService()
    {
        return $this->privates['sulu_page.structure.loader.xml'] = new \Sulu\Component\Content\Metadata\Loader\StructureXmlLoader(($this->privates['sulu_http_cache.cache_lifetime.resolver'] ?? ($this->privates['sulu_http_cache.cache_lifetime.resolver'] = new \Sulu\Bundle\HttpCacheBundle\CacheLifetime\CacheLifetimeResolver())), ($this->privates['sulu_page.structure.properties_xml_parser'] ?? $this->getSuluPage_Structure_PropertiesXmlParserService()), ($this->privates['sulu_page.structure.schema_xml_parser'] ?? ($this->privates['sulu_page.structure.schema_xml_parser'] = new \Sulu\Component\Content\Metadata\Parser\SchemaXmlParser())), ($this->services['sulu.content.type_manager'] ?? $this->getSulu_Content_TypeManagerService()), $this->parameters['sulu.content.structure.required_properties'], $this->parameters['sulu.content.structure.required_tags']);
    }

    /**
     * Gets the private 'sulu_page.structure.properties_xml_parser' shared service.
     *
     * @return \Sulu\Component\Content\Metadata\Parser\PropertiesXmlParser
     */
    protected function getSuluPage_Structure_PropertiesXmlParserService()
    {
        return $this->privates['sulu_page.structure.properties_xml_parser'] = new \Sulu\Component\Content\Metadata\Parser\PropertiesXmlParser(($this->services['translator'] ?? $this->getTranslatorService()), $this->parameters['sulu_core.translated_locales']);
    }

    /**
     * Gets the private 'sulu_page.structure.schema_xml_parser' shared service.
     *
     * @return \Sulu\Component\Content\Metadata\Parser\SchemaXmlParser
     */
    protected function getSuluPage_Structure_SchemaXmlParserService()
    {
        return $this->privates['sulu_page.structure.schema_xml_parser'] = new \Sulu\Component\Content\Metadata\Parser\SchemaXmlParser();
    }

    /**
     * Gets the private 'sulu_search.search.factory' shared service.
     *
     * @return \Sulu\Bundle\SearchBundle\Search\Factory
     */
    protected function getSuluSearch_Search_FactoryService()
    {
        return $this->privates['sulu_search.search.factory'] = new \Sulu\Bundle\SearchBundle\Search\Factory();
    }

    /**
     * Gets the private 'sulu_security.event_listener.security' shared service.
     *
     * @return \Sulu\Bundle\SecurityBundle\EventListener\SuluSecurityListener
     */
    protected function getSuluSecurity_EventListener_SecurityService()
    {
        return $this->privates['sulu_security.event_listener.security'] = new \Sulu\Bundle\SecurityBundle\EventListener\SuluSecurityListener(($this->services['sulu_security.security_checker'] ?? $this->getSuluSecurity_SecurityCheckerService()));
    }

    /**
     * Gets the private 'sulu_security.twig_extension.user' shared service.
     *
     * @return \Sulu\Bundle\SecurityBundle\Twig\UserTwigExtension
     */
    protected function getSuluSecurity_TwigExtension_UserService()
    {
        return $this->privates['sulu_security.twig_extension.user'] = new \Sulu\Bundle\SecurityBundle\Twig\UserTwigExtension(($this->privates['sulu_security.twig_extension.user.cache'] ?? ($this->privates['sulu_security.twig_extension.user.cache'] = new \Doctrine\Common\Cache\ArrayCache())), ($this->services['sulu.repository.user'] ?? $this->getSulu_Repository_UserService()));
    }

    /**
     * Gets the private 'sulu_security.twig_extension.user.cache' shared service.
     *
     * @return \Doctrine\Common\Cache\ArrayCache
     */
    protected function getSuluSecurity_TwigExtension_User_CacheService()
    {
        return $this->privates['sulu_security.twig_extension.user.cache'] = new \Doctrine\Common\Cache\ArrayCache();
    }

    /**
     * Gets the private 'sulu_security.user_locale_listener' shared service.
     *
     * @return \Sulu\Bundle\SecurityBundle\EventListener\UserLocaleListener
     */
    protected function getSuluSecurity_UserLocaleListenerService()
    {
        return $this->privates['sulu_security.user_locale_listener'] = new \Sulu\Bundle\SecurityBundle\EventListener\UserLocaleListener(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->services['translator'] ?? $this->getTranslatorService()));
    }

    /**
     * Gets the private 'sulu_snippet.twig.area_snippet' shared service.
     *
     * @return \Sulu\Bundle\SnippetBundle\Twig\SnippetAreaTwigExtension
     */
    protected function getSuluSnippet_Twig_AreaSnippetService()
    {
        return $this->privates['sulu_snippet.twig.area_snippet'] = new \Sulu\Bundle\SnippetBundle\Twig\SnippetAreaTwigExtension(($this->services['sulu_snippet.default_snippet.manager'] ?? $this->getSuluSnippet_DefaultSnippet_ManagerService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), ($this->services['sulu_snippet.resolver'] ?? $this->getSuluSnippet_ResolverService()));
    }

    /**
     * Gets the private 'sulu_snippet.twig.default_snippet' shared service.
     *
     * @return \Sulu\Bundle\SnippetBundle\Twig\DefaultSnippetTwigExtension
     */
    protected function getSuluSnippet_Twig_DefaultSnippetService()
    {
        return $this->privates['sulu_snippet.twig.default_snippet'] = new \Sulu\Bundle\SnippetBundle\Twig\DefaultSnippetTwigExtension(($this->services['sulu_snippet.default_snippet.manager'] ?? $this->getSuluSnippet_DefaultSnippet_ManagerService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), ($this->services['sulu_snippet.resolver'] ?? $this->getSuluSnippet_ResolverService()));
    }

    /**
     * Gets the private 'sulu_snippet.twig.snippet' shared service.
     *
     * @return \Sulu\Bundle\SnippetBundle\Twig\SnippetTwigExtension
     */
    protected function getSuluSnippet_Twig_SnippetService()
    {
        return $this->privates['sulu_snippet.twig.snippet'] = new \Sulu\Bundle\SnippetBundle\Twig\SnippetTwigExtension(($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), ($this->services['sulu_website.resolver.structure'] ?? $this->getSuluWebsite_Resolver_StructureService()));
    }

    /**
     * Gets the private 'sulu_snippet.twig.snippet.memoized' shared service.
     *
     * @return \Sulu\Bundle\SnippetBundle\Twig\MemoizedSnippetTwigExtension
     */
    protected function getSuluSnippet_Twig_Snippet_MemoizedService()
    {
        return $this->privates['sulu_snippet.twig.snippet.memoized'] = new \Sulu\Bundle\SnippetBundle\Twig\MemoizedSnippetTwigExtension(($this->privates['sulu_snippet.twig.snippet'] ?? $this->getSuluSnippet_Twig_SnippetService()), ($this->privates['sulu_core.cache.memoize'] ?? $this->getSuluCore_Cache_MemoizeService()), 1);
    }

    /**
     * Gets the private 'sulu_tag.tag_request_handler' shared service.
     *
     * @return \Sulu\Component\Tag\Request\TagRequestHandler
     */
    protected function getSuluTag_TagRequestHandlerService()
    {
        return $this->privates['sulu_tag.tag_request_handler'] = new \Sulu\Component\Tag\Request\TagRequestHandler(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'sulu_tag.twig_extension' shared service.
     *
     * @return \Sulu\Bundle\TagBundle\Twig\TagTwigExtension
     */
    protected function getSuluTag_TwigExtensionService()
    {
        return $this->privates['sulu_tag.twig_extension'] = new \Sulu\Bundle\TagBundle\Twig\TagTwigExtension(($this->services['sulu_tag.tag_manager'] ?? $this->getSuluTag_TagManagerService()), ($this->privates['sulu_tag.tag_request_handler'] ?? $this->getSuluTag_TagRequestHandlerService()), ($this->services['jms_serializer'] ?? $this->getJmsSerializerService()), ($this->privates['sulu_core.cache.memoize'] ?? $this->getSuluCore_Cache_MemoizeService()));
    }

    /**
     * Gets the private 'sulu_website.navigation_mapper' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapper
     */
    protected function getSuluWebsite_NavigationMapperService()
    {
        return $this->privates['sulu_website.navigation_mapper'] = new \Sulu\Bundle\WebsiteBundle\Navigation\NavigationMapper(($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->privates['sulu.content.query_executor'] ?? $this->getSulu_Content_QueryExecutorService()), ($this->privates['sulu_website.navigation_mapper.query_builder'] ?? $this->getSuluWebsite_NavigationMapper_QueryBuilderService()), ($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'sulu_website.navigation_mapper.query_builder' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Navigation\NavigationQueryBuilder
     */
    protected function getSuluWebsite_NavigationMapper_QueryBuilderService()
    {
        return $this->privates['sulu_website.navigation_mapper.query_builder'] = new \Sulu\Bundle\WebsiteBundle\Navigation\NavigationQueryBuilder(($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu_page.extension.manager'] ?? $this->getSuluPage_Extension_ManagerService()), 'i18n');
    }

    /**
     * Gets the private 'sulu_website.router_listener' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\EventListener\RouterListener
     */
    protected function getSuluWebsite_RouterListenerService()
    {
        return $this->privates['sulu_website.router_listener'] = new \Sulu\Bundle\WebsiteBundle\EventListener\RouterListener(($this->privates['sulu_website.router_listener.inner'] ?? $this->getSuluWebsite_RouterListener_InnerService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()));
    }

    /**
     * Gets the private 'sulu_website.router_listener.inner' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\RouterListener
     */
    protected function getSuluWebsite_RouterListener_InnerService()
    {
        return $this->privates['sulu_website.router_listener.inner'] = new \Symfony\Component\HttpKernel\EventListener\RouterListener(($this->services['router'] ?? $this->getRouterService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()), ($this->privates['monolog.logger.request'] ?? $this->getMonolog_Logger_RequestService()), $this->targetDirs[4], true);
    }

    /**
     * Gets the private 'sulu_website.routing.request_listener' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Routing\RequestListener
     */
    protected function getSuluWebsite_Routing_RequestListenerService()
    {
        return $this->privates['sulu_website.routing.request_listener'] = new \Sulu\Bundle\WebsiteBundle\Routing\RequestListener(($this->services['router'] ?? $this->getRouterService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()));
    }

    /**
     * Gets the private 'sulu_website.sitemap' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Sitemap\SitemapGenerator
     */
    protected function getSuluWebsite_SitemapService()
    {
        return $this->privates['sulu_website.sitemap'] = new \Sulu\Bundle\WebsiteBundle\Sitemap\SitemapGenerator(($this->privates['sulu.content.query_executor'] ?? $this->getSulu_Content_QueryExecutorService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), ($this->privates['sulu_website.sitemap.query_builder'] ?? $this->getSuluWebsite_Sitemap_QueryBuilderService()), 'test');
    }

    /**
     * Gets the private 'sulu_website.sitemap.query_builder' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Sitemap\SitemapContentQueryBuilder
     */
    protected function getSuluWebsite_Sitemap_QueryBuilderService()
    {
        return $this->privates['sulu_website.sitemap.query_builder'] = new \Sulu\Bundle\WebsiteBundle\Sitemap\SitemapContentQueryBuilder(($this->services['sulu.content.structure_manager'] ?? $this->getSulu_Content_StructureManagerService()), ($this->services['sulu_page.extension.manager'] ?? $this->getSuluPage_Extension_ManagerService()), 'i18n');
    }

    /**
     * Gets the private 'sulu_website.twig.content' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Content\ContentTwigExtension
     */
    protected function getSuluWebsite_Twig_ContentService()
    {
        return $this->privates['sulu_website.twig.content'] = new \Sulu\Bundle\WebsiteBundle\Twig\Content\ContentTwigExtension(($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->services['sulu_website.resolver.structure'] ?? $this->getSuluWebsite_Resolver_StructureService()), ($this->services['sulu.phpcr.session'] ?? $this->getSulu_Phpcr_SessionService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), ($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /**
     * Gets the private 'sulu_website.twig.content.memoized' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Content\MemoizedContentTwigExtension
     */
    protected function getSuluWebsite_Twig_Content_MemoizedService()
    {
        return $this->privates['sulu_website.twig.content.memoized'] = new \Sulu\Bundle\WebsiteBundle\Twig\Content\MemoizedContentTwigExtension(($this->privates['sulu_website.twig.content'] ?? $this->getSuluWebsite_Twig_ContentService()), ($this->privates['sulu_core.cache.memoize'] ?? $this->getSuluCore_Cache_MemoizeService()), 1);
    }

    /**
     * Gets the private 'sulu_website.twig.content_path' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Content\ContentPathTwigExtension
     */
    protected function getSuluWebsite_Twig_ContentPathService()
    {
        return $this->privates['sulu_website.twig.content_path'] = new \Sulu\Bundle\WebsiteBundle\Twig\Content\ContentPathTwigExtension(($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), 'test', ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()));
    }

    /**
     * Gets the private 'sulu_website.twig.meta' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Meta\MetaTwigExtension
     */
    protected function getSuluWebsite_Twig_MetaService()
    {
        return $this->privates['sulu_website.twig.meta'] = new \Sulu\Bundle\WebsiteBundle\Twig\Meta\MetaTwigExtension(($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), ($this->privates['sulu_website.twig.content_path'] ?? $this->getSuluWebsite_Twig_ContentPathService()));
    }

    /**
     * Gets the private 'sulu_website.twig.navigation' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Navigation\NavigationTwigExtension
     */
    protected function getSuluWebsite_Twig_NavigationService()
    {
        return $this->privates['sulu_website.twig.navigation'] = new \Sulu\Bundle\WebsiteBundle\Twig\Navigation\NavigationTwigExtension(($this->services['sulu.content.mapper'] ?? $this->getSulu_Content_MapperService()), ($this->privates['sulu_website.navigation_mapper'] ?? $this->getSuluWebsite_NavigationMapperService()), ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()));
    }

    /**
     * Gets the private 'sulu_website.twig.navigation.memoized' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Navigation\MemoizedNavigationTwigExtension
     */
    protected function getSuluWebsite_Twig_Navigation_MemoizedService()
    {
        return $this->privates['sulu_website.twig.navigation.memoized'] = new \Sulu\Bundle\WebsiteBundle\Twig\Navigation\MemoizedNavigationTwigExtension(($this->privates['sulu_website.twig.navigation'] ?? $this->getSuluWebsite_Twig_NavigationService()), ($this->privates['sulu_core.cache.memoize'] ?? $this->getSuluCore_Cache_MemoizeService()), 1);
    }

    /**
     * Gets the private 'sulu_website.twig.seo' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Seo\SeoTwigExtension
     */
    protected function getSuluWebsite_Twig_SeoService()
    {
        return $this->privates['sulu_website.twig.seo'] = new \Sulu\Bundle\WebsiteBundle\Twig\Seo\SeoTwigExtension(($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()), ($this->privates['sulu_website.twig.content_path'] ?? $this->getSuluWebsite_Twig_ContentPathService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'sulu_website.twig.sitemap' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Sitemap\SitemapTwigExtension
     */
    protected function getSuluWebsite_Twig_SitemapService()
    {
        return $this->privates['sulu_website.twig.sitemap'] = new \Sulu\Bundle\WebsiteBundle\Twig\Sitemap\SitemapTwigExtension(($this->privates['sulu_website.sitemap'] ?? $this->getSuluWebsite_SitemapService()), ($this->services['sulu_core.webspace.webspace_manager'] ?? $this->getSuluCore_Webspace_WebspaceManagerService()), 'test', ($this->services['sulu_core.webspace.request_analyzer'] ?? $this->getSuluCore_Webspace_RequestAnalyzerService()));
    }

    /**
     * Gets the private 'sulu_website.twig.sitemap.memoized' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Sitemap\MemoizedSitemapTwigExtension
     */
    protected function getSuluWebsite_Twig_Sitemap_MemoizedService()
    {
        return $this->privates['sulu_website.twig.sitemap.memoized'] = new \Sulu\Bundle\WebsiteBundle\Twig\Sitemap\MemoizedSitemapTwigExtension(($this->privates['sulu_website.twig.sitemap'] ?? $this->getSuluWebsite_Twig_SitemapService()), ($this->privates['sulu_core.cache.memoize'] ?? $this->getSuluCore_Cache_MemoizeService()), 1);
    }

    /**
     * Gets the private 'sulu_website.twig.util' shared service.
     *
     * @return \Sulu\Bundle\WebsiteBundle\Twig\Core\UtilTwigExtension
     */
    protected function getSuluWebsite_Twig_UtilService()
    {
        return $this->privates['sulu_website.twig.util'] = new \Sulu\Bundle\WebsiteBundle\Twig\Core\UtilTwigExtension();
    }

    /**
     * Gets the private 'swiftmailer.data_collector' shared service.
     *
     * @return \Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector
     */
    protected function getSwiftmailer_DataCollectorService()
    {
        return $this->privates['swiftmailer.data_collector'] = new \Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector($this);
    }

    /**
     * Gets the private 'test.session.listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\TestSessionListener
     */
    protected function getTest_Session_ListenerService()
    {
        return $this->privates['test.session.listener'] = new \Symfony\Component\HttpKernel\EventListener\TestSessionListener(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'session' => ['services', 'session', 'getSessionService.php', true],
        ], [
            'session' => '?',
        ]), $this->parameters['session.storage.options']);
    }

    /**
     * Gets the private 'translator.data_collector' shared service.
     *
     * @return \Symfony\Component\Translation\DataCollectorTranslator
     */
    protected function getTranslator_DataCollectorService()
    {
        return $this->privates['translator.data_collector'] = new \Symfony\Component\Translation\DataCollectorTranslator(($this->privates['translator.default'] ?? $this->getTranslator_DefaultService()));
    }

    /**
     * Gets the private 'translator.default' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getTranslator_DefaultService()
    {
        $this->privates['translator.default'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'translation.loader.csv' => ['privates', 'translation.loader.csv', 'getTranslation_Loader_CsvService.php', true],
            'translation.loader.dat' => ['privates', 'translation.loader.dat', 'getTranslation_Loader_DatService.php', true],
            'translation.loader.ini' => ['privates', 'translation.loader.ini', 'getTranslation_Loader_IniService.php', true],
            'translation.loader.json' => ['privates', 'translation.loader.json', 'getTranslation_Loader_JsonService.php', true],
            'translation.loader.mo' => ['privates', 'translation.loader.mo', 'getTranslation_Loader_MoService.php', true],
            'translation.loader.php' => ['privates', 'translation.loader.php', 'getTranslation_Loader_PhpService.php', true],
            'translation.loader.po' => ['privates', 'translation.loader.po', 'getTranslation_Loader_PoService.php', true],
            'translation.loader.qt' => ['privates', 'translation.loader.qt', 'getTranslation_Loader_QtService.php', true],
            'translation.loader.res' => ['privates', 'translation.loader.res', 'getTranslation_Loader_ResService.php', true],
            'translation.loader.xliff' => ['privates', 'translation.loader.xliff', 'getTranslation_Loader_XliffService.php', true],
            'translation.loader.yml' => ['privates', 'translation.loader.yml', 'getTranslation_Loader_YmlService.php', true],
        ], [
            'translation.loader.csv' => '?',
            'translation.loader.dat' => '?',
            'translation.loader.ini' => '?',
            'translation.loader.json' => '?',
            'translation.loader.mo' => '?',
            'translation.loader.php' => '?',
            'translation.loader.po' => '?',
            'translation.loader.qt' => '?',
            'translation.loader.res' => '?',
            'translation.loader.xliff' => '?',
            'translation.loader.yml' => '?',
        ]), ($this->privates['translator.formatter.default'] ?? $this->getTranslator_Formatter_DefaultService()), 'en', ['translation.loader.php' => [0 => 'php'], 'translation.loader.yml' => [0 => 'yaml', 1 => 'yml'], 'translation.loader.xliff' => [0 => 'xlf', 1 => 'xliff'], 'translation.loader.po' => [0 => 'po'], 'translation.loader.mo' => [0 => 'mo'], 'translation.loader.qt' => [0 => 'ts'], 'translation.loader.csv' => [0 => 'csv'], 'translation.loader.res' => [0 => 'res'], 'translation.loader.dat' => [0 => 'dat'], 'translation.loader.ini' => [0 => 'ini'], 'translation.loader.json' => [0 => 'json']], ['cache_dir' => ($this->targetDirs[0].'/translations'), 'debug' => true, 'resource_files' => ['af' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.af.xlf'], 'ar' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.ar.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.ar.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.ar.xlf'], 'az' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.az.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.az.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.az.xlf'], 'be' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.be.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.be.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.be.xlf'], 'bg' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.bg.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.bg.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.bg.xlf'], 'ca' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.ca.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.ca.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.ca.xlf'], 'cs' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.cs.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.cs.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.cs.xlf'], 'cy' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.cy.xlf'], 'da' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.da.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.da.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.da.xlf'], 'de' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.de.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.de.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.de.xlf', 3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations/admin.de.json', 4 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations/messages.de.xliff', 5 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Resources/translations/admin.de.json', 6 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Resources/translations/admin.de.json', 7 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle/Resources/translations/admin.de.json', 8 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Resources/translations/admin.de.json', 9 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/Resources/translations/admin.de.json', 10 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle/Resources/translations/admin.de.json', 11 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/Resources/translations/admin.de.json', 12 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/Resources/translations/admin.de.json', 13 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle/Resources/translations/admin.de.json', 14 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/Resources/translations/admin.de.json', 15 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Resources/translations/admin.de.json', 16 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Resources/translations/admin.de.json', 17 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PreviewBundle/Resources/translations/admin.de.json'], 'el' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.el.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.el.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.el.xlf'], 'en' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.en.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.en.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.en.xlf', 3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations/admin.en.json', 4 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations/messages.en.xliff', 5 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Resources/translations/admin.en.json', 6 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Resources/translations/admin.en.json', 7 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle/Resources/translations/admin.en.json', 8 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Resources/translations/admin.en.json', 9 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/Resources/translations/admin.en.json', 10 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle/Resources/translations/admin.en.json', 11 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/Resources/translations/admin.en.json', 12 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/Resources/translations/admin.en.json', 13 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle/Resources/translations/admin.en.json', 14 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/Resources/translations/admin.en.json', 15 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Resources/translations/admin.en.json', 16 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Resources/translations/admin.en.json', 17 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PreviewBundle/Resources/translations/admin.en.json'], 'es' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.es.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.es.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.es.xlf'], 'et' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.et.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.et.xlf'], 'eu' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.eu.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.eu.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.eu.xlf'], 'fa' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.fa.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.fa.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.fa.xlf'], 'fi' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.fi.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.fi.xlf'], 'fr' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.fr.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.fr.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.fr.xlf', 3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations/messages.fr.xliff'], 'gl' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.gl.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.gl.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.gl.xlf'], 'he' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.he.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.he.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.he.xlf'], 'hr' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.hr.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.hr.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.hr.xlf'], 'hu' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.hu.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.hu.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.hu.xlf'], 'hy' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.hy.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.hy.xlf'], 'id' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.id.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.id.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.id.xlf'], 'it' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.it.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.it.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.it.xlf'], 'ja' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.ja.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.ja.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.ja.xlf'], 'lb' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.lb.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.lb.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.lb.xlf'], 'lt' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.lt.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.lt.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.lt.xlf'], 'lv' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.lv.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.lv.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.lv.xlf'], 'mn' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.mn.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.mn.xlf'], 'nb' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.nb.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.nb.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.nb.xlf'], 'nl' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.nl.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.nl.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.nl.xlf', 3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations/messages.nl.xliff'], 'nn' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.nn.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.nn.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.nn.xlf'], 'no' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.no.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.no.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.no.xlf'], 'pl' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.pl.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.pl.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.pl.xlf'], 'pt' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.pt.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.pt.xlf'], 'pt_BR' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.pt_BR.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.pt_BR.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.pt_BR.xlf'], 'ro' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.ro.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.ro.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.ro.xlf'], 'ru' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.ru.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.ru.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.ru.xlf'], 'sk' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.sk.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.sk.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.sk.xlf'], 'sl' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.sl.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.sl.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.sl.xlf'], 'sq' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.sq.xlf'], 'sr_Cyrl' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.sr_Cyrl.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.sr_Cyrl.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.sr_Cyrl.xlf'], 'sr_Latn' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.sr_Latn.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.sr_Latn.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.sr_Latn.xlf'], 'sv' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.sv.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.sv.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.sv.xlf'], 'th' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.th.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.th.xlf'], 'tl' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.tl.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.tl.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.tl.xlf'], 'tr' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.tr.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.tr.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.tr.xlf'], 'uk' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.uk.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.uk.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.uk.xlf'], 'vi' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.vi.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.vi.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.vi.xlf'], 'zh_CN' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.zh_CN.xlf', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations/validators.zh_CN.xlf', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.zh_CN.xlf'], 'zh_TW' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations/validators.zh_TW.xlf'], 'pt_PT' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations/security.pt_PT.xlf']], 'scanned_directories' => [0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/validator/Resources/translations', 1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/translations', 2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security/Core/Resources/translations', 3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/translations', 4 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle/Resources/translations', 5 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Resources/translations', 6 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle/Resources/translations', 7 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Resources/translations', 8 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/Resources/translations', 9 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle/Resources/translations', 10 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/Resources/translations', 11 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/Resources/translations', 12 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle/Resources/translations', 13 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/Resources/translations', 14 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Resources/translations', 15 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Resources/translations', 16 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PreviewBundle/Resources/translations', 17 => ($this->targetDirs[4].'/Resources/SuluFormBundle/translations'), 18 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/swiftmailer-bundle/Resources/translations', 19 => ($this->targetDirs[4].'/Resources/SwiftmailerBundle/translations'), 20 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/framework-bundle/Resources/translations', 21 => ($this->targetDirs[4].'/Resources/FrameworkBundle/translations'), 22 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bundle/Resources/translations', 23 => ($this->targetDirs[4].'/Resources/TwigBundle/translations'), 24 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/monolog-bundle/Resources/translations', 25 => ($this->targetDirs[4].'/Resources/MonologBundle/translations'), 26 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CoreBundle/Resources/translations', 27 => ($this->targetDirs[4].'/Resources/SuluCoreBundle/translations'), 28 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/doctrine-bundle/Resources/translations', 29 => ($this->targetDirs[4].'/Resources/DoctrineBundle/translations'), 30 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/doctrine-cache-bundle/Resources/translations', 31 => ($this->targetDirs[4].'/Resources/DoctrineCacheBundle/translations'), 32 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/phpcr-bundle/src/Resources/translations', 33 => ($this->targetDirs[4].'/Resources/DoctrinePHPCRBundle/translations'), 34 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/dantleech/phpcr-migrations-bundle/Resources/translations', 35 => ($this->targetDirs[4].'/Resources/PhpcrMigrationsBundle/translations'), 36 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/stof/doctrine-extensions-bundle/Resources/translations', 37 => ($this->targetDirs[4].'/Resources/StofDoctrineExtensionsBundle/translations'), 38 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/jms/serializer-bundle/Resources/translations', 39 => ($this->targetDirs[4].'/Resources/JMSSerializerBundle/translations'), 40 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/massive/search-bundle/Resources/translations', 41 => ($this->targetDirs[4].'/Resources/MassiveSearchBundle/translations'), 42 => ($this->targetDirs[4].'/Resources/SuluSearchBundle/translations'), 43 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PersistenceBundle/Resources/translations', 44 => ($this->targetDirs[4].'/Resources/SuluPersistenceBundle/translations'), 45 => ($this->targetDirs[4].'/Resources/SuluPageBundle/translations'), 46 => ($this->targetDirs[4].'/Resources/SuluContactBundle/translations'), 47 => ($this->targetDirs[4].'/Resources/SuluSecurityBundle/translations'), 48 => ($this->targetDirs[4].'/Resources/SuluWebsiteBundle/translations'), 49 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TestBundle/Resources/translations', 50 => ($this->targetDirs[4].'/Resources/SuluTestBundle/translations'), 51 => ($this->targetDirs[4].'/Resources/SuluTagBundle/translations'), 52 => ($this->targetDirs[4].'/Resources/SuluMediaBundle/translations'), 53 => ($this->targetDirs[4].'/Resources/SuluCategoryBundle/translations'), 54 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/HttpCacheBundle/Resources/translations', 55 => ($this->targetDirs[4].'/Resources/SuluHttpCacheBundle/translations'), 56 => ($this->targetDirs[4].'/Resources/SuluSnippetBundle/translations'), 57 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/LocationBundle/Resources/translations', 58 => ($this->targetDirs[4].'/Resources/SuluLocationBundle/translations'), 59 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/DocumentManagerBundle/Resources/translations', 60 => ($this->targetDirs[4].'/Resources/SuluDocumentManagerBundle/translations'), 61 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/HashBundle/Resources/translations', 62 => ($this->targetDirs[4].'/Resources/SuluHashBundle/translations'), 63 => ($this->targetDirs[4].'/Resources/SuluCustomUrlBundle/translations'), 64 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/RouteBundle/Resources/translations', 65 => ($this->targetDirs[4].'/Resources/SuluRouteBundle/translations'), 66 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MarkupBundle/Resources/translations', 67 => ($this->targetDirs[4].'/Resources/SuluMarkupBundle/translations'), 68 => ($this->targetDirs[4].'/Resources/SuluAudienceTargetingBundle/translations'), 69 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/willdurand/hateoas-bundle/Resources/translations', 70 => ($this->targetDirs[4].'/Resources/BazingaHateoasBundle/translations'), 71 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/friendsofsymfony/rest-bundle/Resources/translations', 72 => ($this->targetDirs[4].'/Resources/FOSRestBundle/translations'), 73 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security-bundle/Resources/translations', 74 => ($this->targetDirs[4].'/Resources/SecurityBundle/translations'), 75 => ($this->targetDirs[4].'/Resources/SuluAdminBundle/translations'), 76 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CollaborationBundle/Resources/translations', 77 => ($this->targetDirs[4].'/Resources/SuluCollaborationBundle/translations'), 78 => ($this->targetDirs[4].'/Resources/SuluPreviewBundle/translations'), 79 => ($this->targetDirs[4].'/translations'), 80 => ($this->targetDirs[4].'/Resources/translations')]]);

        $instance->setConfigCacheFactory(($this->privates['config_cache_factory'] ?? $this->getConfigCacheFactoryService()));
        $instance->setFallbackLocales([0 => 'en']);

        return $instance;
    }

    /**
     * Gets the private 'translator.formatter.default' shared service.
     *
     * @return \Symfony\Component\Translation\Formatter\MessageFormatter
     */
    protected function getTranslator_Formatter_DefaultService()
    {
        return $this->privates['translator.formatter.default'] = new \Symfony\Component\Translation\Formatter\MessageFormatter(($this->privates['identity_translator'] ?? ($this->privates['identity_translator'] = new \Symfony\Component\Translation\IdentityTranslator())));
    }

    /**
     * Gets the private 'twig.app_variable' shared service.
     *
     * @return \Symfony\Bridge\Twig\AppVariable
     */
    protected function getTwig_AppVariableService()
    {
        $this->privates['twig.app_variable'] = $instance = new \Symfony\Bridge\Twig\AppVariable();

        $instance->setEnvironment('test');
        $instance->setDebug(true);
        if ($this->has('security.token_storage')) {
            $instance->setTokenStorage(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())));
        }
        if ($this->has('request_stack')) {
            $instance->setRequestStack(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
        }

        return $instance;
    }

    /**
     * Gets the private 'twig.configurator.environment' shared service.
     *
     * @return \Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator
     */
    protected function getTwig_Configurator_EnvironmentService()
    {
        return $this->privates['twig.configurator.environment'] = new \Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator('F j, Y H:i', '%d days', NULL, 0, '.', ',');
    }

    /**
     * Gets the private 'twig.extension.assets' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\AssetExtension
     */
    protected function getTwig_Extension_AssetsService()
    {
        return $this->privates['twig.extension.assets'] = new \Symfony\Bridge\Twig\Extension\AssetExtension(($this->privates['assets.packages'] ?? $this->getAssets_PackagesService()));
    }

    /**
     * Gets the private 'twig.extension.code' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\CodeExtension
     */
    protected function getTwig_Extension_CodeService()
    {
        return $this->privates['twig.extension.code'] = new \Symfony\Bridge\Twig\Extension\CodeExtension(($this->privates['debug.file_link_formatter'] ?? ($this->privates['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL))), $this->targetDirs[4], 'UTF-8');
    }

    /**
     * Gets the private 'twig.extension.debug' shared service.
     *
     * @return \Twig\Extension\DebugExtension
     */
    protected function getTwig_Extension_DebugService()
    {
        return $this->privates['twig.extension.debug'] = new \Twig\Extension\DebugExtension();
    }

    /**
     * Gets the private 'twig.extension.debug.stopwatch' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\StopwatchExtension
     */
    protected function getTwig_Extension_Debug_StopwatchService()
    {
        return $this->privates['twig.extension.debug.stopwatch'] = new \Symfony\Bridge\Twig\Extension\StopwatchExtension(($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))), true);
    }

    /**
     * Gets the private 'twig.extension.expression' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\ExpressionExtension
     */
    protected function getTwig_Extension_ExpressionService()
    {
        return $this->privates['twig.extension.expression'] = new \Symfony\Bridge\Twig\Extension\ExpressionExtension();
    }

    /**
     * Gets the private 'twig.extension.form' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\FormExtension
     */
    protected function getTwig_Extension_FormService()
    {
        return $this->privates['twig.extension.form'] = new \Symfony\Bridge\Twig\Extension\FormExtension([0 => $this, 1 => 'twig.form.renderer']);
    }

    /**
     * Gets the private 'twig.extension.httpfoundation' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\HttpFoundationExtension
     */
    protected function getTwig_Extension_HttpfoundationService()
    {
        return $this->privates['twig.extension.httpfoundation'] = new \Symfony\Bridge\Twig\Extension\HttpFoundationExtension(($this->privates['url_helper'] ?? $this->getUrlHelperService()));
    }

    /**
     * Gets the private 'twig.extension.httpkernel' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\HttpKernelExtension
     */
    protected function getTwig_Extension_HttpkernelService()
    {
        return $this->privates['twig.extension.httpkernel'] = new \Symfony\Bridge\Twig\Extension\HttpKernelExtension();
    }

    /**
     * Gets the private 'twig.extension.logout_url' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\LogoutUrlExtension
     */
    protected function getTwig_Extension_LogoutUrlService()
    {
        return $this->privates['twig.extension.logout_url'] = new \Symfony\Bridge\Twig\Extension\LogoutUrlExtension(($this->privates['security.logout_url_generator'] ?? $this->getSecurity_LogoutUrlGeneratorService()));
    }

    /**
     * Gets the private 'twig.extension.profiler' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\ProfilerExtension
     */
    protected function getTwig_Extension_ProfilerService()
    {
        return $this->privates['twig.extension.profiler'] = new \Symfony\Bridge\Twig\Extension\ProfilerExtension(($this->privates['twig.profile'] ?? ($this->privates['twig.profile'] = new \Twig\Profiler\Profile())), ($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))));
    }

    /**
     * Gets the private 'twig.extension.routing' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\RoutingExtension
     */
    protected function getTwig_Extension_RoutingService()
    {
        return $this->privates['twig.extension.routing'] = new \Symfony\Bridge\Twig\Extension\RoutingExtension(($this->services['router'] ?? $this->getRouterService()));
    }

    /**
     * Gets the private 'twig.extension.security' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\SecurityExtension
     */
    protected function getTwig_Extension_SecurityService()
    {
        return $this->privates['twig.extension.security'] = new \Symfony\Bridge\Twig\Extension\SecurityExtension(($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService()));
    }

    /**
     * Gets the private 'twig.extension.security_csrf' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\CsrfExtension
     */
    protected function getTwig_Extension_SecurityCsrfService()
    {
        return $this->privates['twig.extension.security_csrf'] = new \Symfony\Bridge\Twig\Extension\CsrfExtension();
    }

    /**
     * Gets the private 'twig.extension.trans' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\TranslationExtension
     */
    protected function getTwig_Extension_TransService()
    {
        return $this->privates['twig.extension.trans'] = new \Symfony\Bridge\Twig\Extension\TranslationExtension(($this->services['translator'] ?? $this->getTranslatorService()));
    }

    /**
     * Gets the private 'twig.extension.weblink' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\WebLinkExtension
     */
    protected function getTwig_Extension_WeblinkService()
    {
        return $this->privates['twig.extension.weblink'] = new \Symfony\Bridge\Twig\Extension\WebLinkExtension(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /**
     * Gets the private 'twig.extension.yaml' shared service.
     *
     * @return \Symfony\Bridge\Twig\Extension\YamlExtension
     */
    protected function getTwig_Extension_YamlService()
    {
        return $this->privates['twig.extension.yaml'] = new \Symfony\Bridge\Twig\Extension\YamlExtension();
    }

    /**
     * Gets the private 'twig.loader.filesystem' shared service.
     *
     * @return \Symfony\Bundle\TwigBundle\Loader\FilesystemLoader
     */
    protected function getTwig_Loader_FilesystemService()
    {
        $this->privates['twig.loader.filesystem'] = $instance = new \Symfony\Bundle\TwigBundle\Loader\FilesystemLoader(($this->privates['templating.locator'] ?? $this->load('getTemplating_LocatorService.php')), ($this->privates['templating.name_parser'] ?? $this->load('getTemplating_NameParserService.php')), $this->targetDirs[4]);

        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/views', 'SuluForm');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/Resources/views', '!SuluForm');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/swiftmailer-bundle/Resources/views', 'Swiftmailer');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/swiftmailer-bundle/Resources/views', '!Swiftmailer');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/framework-bundle/Resources/views', 'Framework');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/framework-bundle/Resources/views', '!Framework');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bundle/Resources/views', 'Twig');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bundle/Resources/views', '!Twig');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/doctrine-bundle/Resources/views', 'Doctrine');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/doctrine-bundle/Resources/views', '!Doctrine');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/phpcr-bundle/src/Resources/views', 'DoctrinePHPCR');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/phpcr-bundle/src/Resources/views', '!DoctrinePHPCR');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Resources/views', 'SuluPage');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Resources/views', '!SuluPage');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Resources/views', 'SuluSecurity');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/Resources/views', '!SuluSecurity');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/Resources/views', 'SuluWebsite');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/Resources/views', '!SuluWebsite');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TestBundle/Resources/views', 'SuluTest');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TestBundle/Resources/views', '!SuluTest');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Resources/views', 'SuluAudienceTargeting');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/Resources/views', '!SuluAudienceTargeting');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security-bundle/Resources/views', 'Security');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security-bundle/Resources/views', '!Security');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Resources/views', 'SuluAdmin');
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle/Resources/views', '!SuluAdmin');
        $instance->addPath(($this->targetDirs[4].'/Resources/views'));
        $instance->addPath('/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bridge/Resources/views/Form');

        return $instance;
    }

    /**
     * Gets the private 'twig.profile' shared service.
     *
     * @return \Twig\Profiler\Profile
     */
    protected function getTwig_ProfileService()
    {
        return $this->privates['twig.profile'] = new \Twig\Profiler\Profile();
    }

    /**
     * Gets the private 'twig.runtime_loader' shared service.
     *
     * @return \Twig\RuntimeLoader\ContainerRuntimeLoader
     */
    protected function getTwig_RuntimeLoaderService()
    {
        return $this->privates['twig.runtime_loader'] = new \Twig\RuntimeLoader\ContainerRuntimeLoader(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'JMS\\Serializer\\Twig\\SerializerRuntimeHelper' => ['services', 'jms_serializer.twig_extension.serializer_runtime_helper', 'getJmsSerializer_TwigExtension_SerializerRuntimeHelperService.php', true],
            'Symfony\\Bridge\\Twig\\Extension\\CsrfRuntime' => ['privates', 'twig.runtime.security_csrf', 'getTwig_Runtime_SecurityCsrfService.php', true],
            'Symfony\\Bridge\\Twig\\Extension\\HttpKernelRuntime' => ['privates', 'twig.runtime.httpkernel', 'getTwig_Runtime_HttpkernelService.php', true],
            'Symfony\\Component\\Form\\FormRenderer' => ['privates', 'twig.form.renderer', 'getTwig_Form_RendererService.php', true],
        ], [
            'JMS\\Serializer\\Twig\\SerializerRuntimeHelper' => '?',
            'Symfony\\Bridge\\Twig\\Extension\\CsrfRuntime' => '?',
            'Symfony\\Bridge\\Twig\\Extension\\HttpKernelRuntime' => '?',
            'Symfony\\Component\\Form\\FormRenderer' => '?',
        ]));
    }

    /**
     * Gets the private 'uri_signer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\UriSigner
     */
    protected function getUriSignerService()
    {
        return $this->privates['uri_signer'] = new \Symfony\Component\HttpKernel\UriSigner('secret');
    }

    /**
     * Gets the private 'url_helper' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\UrlHelper
     */
    protected function getUrlHelperService()
    {
        return $this->privates['url_helper'] = new \Symfony\Component\HttpFoundation\UrlHelper(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()));
    }

    /**
     * Gets the private 'validate_request_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener
     */
    protected function getValidateRequestListenerService()
    {
        return $this->privates['validate_request_listener'] = new \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener();
    }

    /**
     * Gets the private 'validator.builder' shared service.
     *
     * @return \Symfony\Component\Validator\ValidatorBuilderInterface
     */
    protected function getValidator_BuilderService()
    {
        $this->privates['validator.builder'] = $instance = \Symfony\Component\Validator\Validation::createValidatorBuilder();

        $instance->setConstraintValidatorFactory(($this->privates['validator.validator_factory'] ?? $this->getValidator_ValidatorFactoryService()));
        $instance->setTranslator(new \Symfony\Component\Validator\Util\LegacyTranslatorProxy(($this->services['translator'] ?? $this->getTranslatorService())));
        $instance->setTranslationDomain('validators');
        $instance->addXmlMappings([0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/form/Resources/config/validation.xml']);
        $instance->enableAnnotationMapping(($this->privates['annotations.cached_reader'] ?? $this->getAnnotations_CachedReaderService()));
        $instance->addMethodMapping('loadValidatorMetadata');
        $instance->addObjectInitializers([0 => ($this->privates['doctrine.orm.validator_initializer'] ?? $this->getDoctrine_Orm_ValidatorInitializerService())]);
        $instance->addLoader(($this->privates['doctrine.orm.default_entity_manager.validator_loader'] ?? $this->getDoctrine_Orm_DefaultEntityManager_ValidatorLoaderService()));

        return $instance;
    }

    /**
     * Gets the private 'validator.validator_factory' shared service.
     *
     * @return \Symfony\Component\Validator\ContainerConstraintValidatorFactory
     */
    protected function getValidator_ValidatorFactoryService()
    {
        return $this->privates['validator.validator_factory'] = new \Symfony\Component\Validator\ContainerConstraintValidatorFactory(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntityValidator' => ['privates', 'doctrine.orm.validator.unique', 'getDoctrine_Orm_Validator_UniqueService.php', true],
            'Symfony\\Component\\Security\\Core\\Validator\\Constraints\\UserPasswordValidator' => ['privates', 'security.validator.user_password', 'getSecurity_Validator_UserPasswordService.php', true],
            'Symfony\\Component\\Validator\\Constraints\\EmailValidator' => ['privates', 'validator.email', 'getValidator_EmailService.php', true],
            'Symfony\\Component\\Validator\\Constraints\\ExpressionValidator' => ['privates', 'validator.expression', 'getValidator_ExpressionService.php', true],
            'Symfony\\Component\\Validator\\Constraints\\NotCompromisedPasswordValidator' => ['privates', 'validator.not_compromised_password', 'getValidator_NotCompromisedPasswordService.php', true],
            'doctrine.orm.validator.unique' => ['privates', 'doctrine.orm.validator.unique', 'getDoctrine_Orm_Validator_UniqueService.php', true],
            'security.validator.user_password' => ['privates', 'security.validator.user_password', 'getSecurity_Validator_UserPasswordService.php', true],
            'validator.expression' => ['privates', 'validator.expression', 'getValidator_ExpressionService.php', true],
        ], [
            'Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntityValidator' => '?',
            'Symfony\\Component\\Security\\Core\\Validator\\Constraints\\UserPasswordValidator' => '?',
            'Symfony\\Component\\Validator\\Constraints\\EmailValidator' => '?',
            'Symfony\\Component\\Validator\\Constraints\\ExpressionValidator' => '?',
            'Symfony\\Component\\Validator\\Constraints\\NotCompromisedPasswordValidator' => '?',
            'doctrine.orm.validator.unique' => '?',
            'security.validator.user_password' => '?',
            'validator.expression' => '?',
        ]));
    }

    /**
     * Gets the private 'web_link.add_link_header_listener' shared service.
     *
     * @return \Symfony\Component\WebLink\EventListener\AddLinkHeaderListener
     */
    protected function getWebLink_AddLinkHeaderListenerService()
    {
        return $this->privates['web_link.add_link_header_listener'] = new \Symfony\Component\WebLink\EventListener\AddLinkHeaderListener();
    }

    public function getParameter($name)
    {
        $name = (string) $name;
        if (isset($this->buildParameters[$name])) {
            return $this->buildParameters[$name];
        }

        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name)
    {
        $name = (string) $name;
        if (isset($this->buildParameters[$name])) {
            return true;
        }

        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            foreach ($this->buildParameters as $name => $value) {
                $parameters[$name] = $value;
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = [
        'kernel.root_dir' => false,
        'kernel.project_dir' => false,
        'kernel.cache_dir' => false,
        'kernel.logs_dir' => false,
        'sulu.common_cache_dir' => false,
        'database.url' => false,
        'database.charset' => false,
        'database.collate' => false,
        'phpcr.backend_url' => false,
        'phpcr.username' => false,
        'phpcr.password' => false,
        'phpcr.workspace' => false,
        'session.save_path' => false,
        'validator.mapping.cache.file' => false,
        'translator.default_path' => false,
        'profiler.storage.dsn' => false,
        'debug.container.dump' => false,
        'router.resource' => false,
        'serializer.mapping.cache.file' => false,
        'twig.default_path' => false,
        'sulu.cache_dir' => false,
        'sulu_core.proxy_cache_dir' => false,
        'sulu.content.structure.paths' => false,
        'sulu_core.webspace.config_dir' => false,
        'doctrine.orm.proxy_dir' => false,
        'massive_search.adapter.zend_lucene.basepath' => false,
        'massive_search.metadata.cache_dir' => false,
        'sulu_website.sitemap.dump_dir' => false,
        'sulu_media.image_format_files' => false,
        'sulu_media.format_cache.path' => false,
        'sulu_media.media.storage.local.path' => false,
    ];
    private $dynamicParameters = [];

    /**
     * Computes a dynamic parameter.
     *
     * @param string $name The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        switch ($name) {
            case 'kernel.root_dir': $value = $this->targetDirs[4]; break;
            case 'kernel.project_dir': $value = $this->targetDirs[4]; break;
            case 'kernel.cache_dir': $value = $this->targetDirs[0]; break;
            case 'kernel.logs_dir': $value = ($this->targetDirs[3].'/log/admin'); break;
            case 'sulu.common_cache_dir': $value = ($this->targetDirs[2].'/common/test'); break;
            case 'database.url': $value = $this->getEnv('DATABASE_URL'); break;
            case 'database.charset': $value = $this->getEnv('DATABASE_CHARSET'); break;
            case 'database.collate': $value = $this->getEnv('DATABASE_COLLATE'); break;
            case 'phpcr.backend_url': $value = $this->getEnv('PHPCR_BACKEND_URL'); break;
            case 'phpcr.username': $value = $this->getEnv('PHPCR_USERNAME'); break;
            case 'phpcr.password': $value = $this->getEnv('PHPCR_PASSWORD'); break;
            case 'phpcr.workspace': $value = $this->getEnv('PHPCR_WORKSPACE'); break;
            case 'session.save_path': $value = ($this->targetDirs[0].'/sessions'); break;
            case 'validator.mapping.cache.file': $value = ($this->targetDirs[0].'/validation.php'); break;
            case 'translator.default_path': $value = ($this->targetDirs[4].'/translations'); break;
            case 'profiler.storage.dsn': $value = ('file:'.$this->targetDirs[0].'/profiler'); break;
            case 'debug.container.dump': $value = ($this->targetDirs[0].'/adminAdminTestDebugProjectContainer.xml'); break;
            case 'router.resource': $value = ($this->targetDirs[4].'/config/routing.yml'); break;
            case 'serializer.mapping.cache.file': $value = ($this->targetDirs[0].'/serialization.php'); break;
            case 'twig.default_path': $value = ($this->targetDirs[4].'/templates'); break;
            case 'sulu.cache_dir': $value = ($this->targetDirs[0].'/sulu'); break;
            case 'sulu_core.proxy_cache_dir': $value = ($this->targetDirs[0].'/sulu/proxies'); break;
            case 'sulu.content.structure.paths': $value = [
                'snippet' => [
                    0 => [
                        'path' => ($this->targetDirs[4].'/config/templates/snippets'),
                        'type' => 'snippet',
                    ],
                ],
                'page' => [
                    0 => [
                        'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/DependencyInjection/../Content/templates',
                        'type' => 'page',
                    ],
                    1 => [
                        'path' => ($this->targetDirs[4].'/config/templates/pages'),
                        'type' => 'page',
                    ],
                    2 => [
                        'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CoreBundle/DependencyInjection/../Content/templates',
                        'type' => 'page',
                    ],
                ],
                'home' => [
                    0 => [
                        'path' => ($this->targetDirs[4].'/config/templates/pages'),
                        'type' => 'home',
                    ],
                ],
            ]; break;
            case 'sulu_core.webspace.config_dir': $value = ($this->targetDirs[4].'/config/webspaces'); break;
            case 'doctrine.orm.proxy_dir': $value = ($this->targetDirs[0].'/doctrine/orm/Proxies'); break;
            case 'massive_search.adapter.zend_lucene.basepath': $value = ($this->targetDirs[3].'/indexes'); break;
            case 'massive_search.metadata.cache_dir': $value = ($this->targetDirs[0].'/massive-search'); break;
            case 'sulu_website.sitemap.dump_dir': $value = ($this->targetDirs[0].'/sulu/sitemaps'); break;
            case 'sulu_media.image_format_files': $value = [
                0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/DependencyInjection/../Resources/config/image-formats.xml',
                1 => ($this->targetDirs[4].'/config/image-formats.xml'),
            ]; break;
            case 'sulu_media.format_cache.path': $value = ($this->targetDirs[4].'/public/uploads/media'); break;
            case 'sulu_media.media.storage.local.path': $value = ($this->targetDirs[3].'/uploads/media'); break;
            default: throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
        }
        $this->loadedDynamicParameters[$name] = true;

        return $this->dynamicParameters[$name] = $value;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return [
            'kernel.environment' => 'test',
            'kernel.debug' => true,
            'kernel.name' => 'admin',
            'kernel.bundles' => [
                'SuluFormBundle' => 'Sulu\\Bundle\\FormBundle\\SuluFormBundle',
                'SwiftmailerBundle' => 'Symfony\\Bundle\\SwiftmailerBundle\\SwiftmailerBundle',
                'FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                'TwigBundle' => 'Symfony\\Bundle\\TwigBundle\\TwigBundle',
                'MonologBundle' => 'Symfony\\Bundle\\MonologBundle\\MonologBundle',
                'SuluCoreBundle' => 'Sulu\\Bundle\\CoreBundle\\SuluCoreBundle',
                'DoctrineBundle' => 'Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle',
                'DoctrineCacheBundle' => 'Doctrine\\Bundle\\DoctrineCacheBundle\\DoctrineCacheBundle',
                'DoctrinePHPCRBundle' => 'Doctrine\\Bundle\\PHPCRBundle\\DoctrinePHPCRBundle',
                'PhpcrMigrationsBundle' => 'DTL\\Bundle\\PhpcrMigrations\\PhpcrMigrationsBundle',
                'StofDoctrineExtensionsBundle' => 'Stof\\DoctrineExtensionsBundle\\StofDoctrineExtensionsBundle',
                'JMSSerializerBundle' => 'JMS\\SerializerBundle\\JMSSerializerBundle',
                'MassiveSearchBundle' => 'Massive\\Bundle\\SearchBundle\\MassiveSearchBundle',
                'SuluSearchBundle' => 'Sulu\\Bundle\\SearchBundle\\SuluSearchBundle',
                'SuluPersistenceBundle' => 'Sulu\\Bundle\\PersistenceBundle\\SuluPersistenceBundle',
                'SuluPageBundle' => 'Sulu\\Bundle\\PageBundle\\SuluPageBundle',
                'SuluContactBundle' => 'Sulu\\Bundle\\ContactBundle\\SuluContactBundle',
                'SuluSecurityBundle' => 'Sulu\\Bundle\\SecurityBundle\\SuluSecurityBundle',
                'SuluWebsiteBundle' => 'Sulu\\Bundle\\WebsiteBundle\\SuluWebsiteBundle',
                'SuluTestBundle' => 'Sulu\\Bundle\\TestBundle\\SuluTestBundle',
                'SuluTagBundle' => 'Sulu\\Bundle\\TagBundle\\SuluTagBundle',
                'SuluMediaBundle' => 'Sulu\\Bundle\\MediaBundle\\SuluMediaBundle',
                'SuluCategoryBundle' => 'Sulu\\Bundle\\CategoryBundle\\SuluCategoryBundle',
                'SuluHttpCacheBundle' => 'Sulu\\Bundle\\HttpCacheBundle\\SuluHttpCacheBundle',
                'SuluSnippetBundle' => 'Sulu\\Bundle\\SnippetBundle\\SuluSnippetBundle',
                'SuluLocationBundle' => 'Sulu\\Bundle\\LocationBundle\\SuluLocationBundle',
                'SuluDocumentManagerBundle' => 'Sulu\\Bundle\\DocumentManagerBundle\\SuluDocumentManagerBundle',
                'SuluHashBundle' => 'Sulu\\Bundle\\HashBundle\\SuluHashBundle',
                'SuluCustomUrlBundle' => 'Sulu\\Bundle\\CustomUrlBundle\\SuluCustomUrlBundle',
                'SuluRouteBundle' => 'Sulu\\Bundle\\RouteBundle\\SuluRouteBundle',
                'SuluMarkupBundle' => 'Sulu\\Bundle\\MarkupBundle\\SuluMarkupBundle',
                'SuluAudienceTargetingBundle' => 'Sulu\\Bundle\\AudienceTargetingBundle\\SuluAudienceTargetingBundle',
                'BazingaHateoasBundle' => 'Bazinga\\Bundle\\HateoasBundle\\BazingaHateoasBundle',
                'FOSRestBundle' => 'FOS\\RestBundle\\FOSRestBundle',
                'SecurityBundle' => 'Symfony\\Bundle\\SecurityBundle\\SecurityBundle',
                'SuluAdminBundle' => 'Sulu\\Bundle\\AdminBundle\\SuluAdminBundle',
                'SuluCollaborationBundle' => 'Sulu\\Bundle\\CollaborationBundle\\SuluCollaborationBundle',
                'SuluPreviewBundle' => 'Sulu\\Bundle\\PreviewBundle\\SuluPreviewBundle',
            ],
            'kernel.bundles_metadata' => [
                'SuluFormBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle',
                    'namespace' => 'Sulu\\Bundle\\FormBundle',
                ],
                'SwiftmailerBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/swiftmailer-bundle',
                    'namespace' => 'Symfony\\Bundle\\SwiftmailerBundle',
                ],
                'FrameworkBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/framework-bundle',
                    'namespace' => 'Symfony\\Bundle\\FrameworkBundle',
                ],
                'TwigBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/twig-bundle',
                    'namespace' => 'Symfony\\Bundle\\TwigBundle',
                ],
                'MonologBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/monolog-bundle',
                    'namespace' => 'Symfony\\Bundle\\MonologBundle',
                ],
                'SuluCoreBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CoreBundle',
                    'namespace' => 'Sulu\\Bundle\\CoreBundle',
                ],
                'DoctrineBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/doctrine-bundle',
                    'namespace' => 'Doctrine\\Bundle\\DoctrineBundle',
                ],
                'DoctrineCacheBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/doctrine-cache-bundle',
                    'namespace' => 'Doctrine\\Bundle\\DoctrineCacheBundle',
                ],
                'DoctrinePHPCRBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/doctrine/phpcr-bundle/src',
                    'namespace' => 'Doctrine\\Bundle\\PHPCRBundle',
                ],
                'PhpcrMigrationsBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/dantleech/phpcr-migrations-bundle',
                    'namespace' => 'DTL\\Bundle\\PhpcrMigrations',
                ],
                'StofDoctrineExtensionsBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/stof/doctrine-extensions-bundle',
                    'namespace' => 'Stof\\DoctrineExtensionsBundle',
                ],
                'JMSSerializerBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/jms/serializer-bundle',
                    'namespace' => 'JMS\\SerializerBundle',
                ],
                'MassiveSearchBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/massive/search-bundle',
                    'namespace' => 'Massive\\Bundle\\SearchBundle',
                ],
                'SuluSearchBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SearchBundle',
                    'namespace' => 'Sulu\\Bundle\\SearchBundle',
                ],
                'SuluPersistenceBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PersistenceBundle',
                    'namespace' => 'Sulu\\Bundle\\PersistenceBundle',
                ],
                'SuluPageBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle',
                    'namespace' => 'Sulu\\Bundle\\PageBundle',
                ],
                'SuluContactBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle',
                    'namespace' => 'Sulu\\Bundle\\ContactBundle',
                ],
                'SuluSecurityBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle',
                    'namespace' => 'Sulu\\Bundle\\SecurityBundle',
                ],
                'SuluWebsiteBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle',
                    'namespace' => 'Sulu\\Bundle\\WebsiteBundle',
                ],
                'SuluTestBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TestBundle',
                    'namespace' => 'Sulu\\Bundle\\TestBundle',
                ],
                'SuluTagBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle',
                    'namespace' => 'Sulu\\Bundle\\TagBundle',
                ],
                'SuluMediaBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle',
                    'namespace' => 'Sulu\\Bundle\\MediaBundle',
                ],
                'SuluCategoryBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle',
                    'namespace' => 'Sulu\\Bundle\\CategoryBundle',
                ],
                'SuluHttpCacheBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/HttpCacheBundle',
                    'namespace' => 'Sulu\\Bundle\\HttpCacheBundle',
                ],
                'SuluSnippetBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle',
                    'namespace' => 'Sulu\\Bundle\\SnippetBundle',
                ],
                'SuluLocationBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/LocationBundle',
                    'namespace' => 'Sulu\\Bundle\\LocationBundle',
                ],
                'SuluDocumentManagerBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/DocumentManagerBundle',
                    'namespace' => 'Sulu\\Bundle\\DocumentManagerBundle',
                ],
                'SuluHashBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/HashBundle',
                    'namespace' => 'Sulu\\Bundle\\HashBundle',
                ],
                'SuluCustomUrlBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle',
                    'namespace' => 'Sulu\\Bundle\\CustomUrlBundle',
                ],
                'SuluRouteBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/RouteBundle',
                    'namespace' => 'Sulu\\Bundle\\RouteBundle',
                ],
                'SuluMarkupBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MarkupBundle',
                    'namespace' => 'Sulu\\Bundle\\MarkupBundle',
                ],
                'SuluAudienceTargetingBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle',
                    'namespace' => 'Sulu\\Bundle\\AudienceTargetingBundle',
                ],
                'BazingaHateoasBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/willdurand/hateoas-bundle',
                    'namespace' => 'Bazinga\\Bundle\\HateoasBundle',
                ],
                'FOSRestBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/friendsofsymfony/rest-bundle',
                    'namespace' => 'FOS\\RestBundle',
                ],
                'SecurityBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/symfony/security-bundle',
                    'namespace' => 'Symfony\\Bundle\\SecurityBundle',
                ],
                'SuluAdminBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AdminBundle',
                    'namespace' => 'Sulu\\Bundle\\AdminBundle',
                ],
                'SuluCollaborationBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CollaborationBundle',
                    'namespace' => 'Sulu\\Bundle\\CollaborationBundle',
                ],
                'SuluPreviewBundle' => [
                    'path' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PreviewBundle',
                    'namespace' => 'Sulu\\Bundle\\PreviewBundle',
                ],
            ],
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'adminAdminTestDebugProjectContainer',
            'sulu.context' => 'admin',
            'phpcr.transport' => 'doctrinedbal',
            'env(DATABASE_URL)' => 'mysql://root:@127.0.0.1:3306/sulu_test',
            'env(DATABASE_CHARSET)' => 'utf8mb4',
            'env(DATABASE_COLLATE)' => 'utf8mb4_unicode_ci',
            'env(PHPCR_TRANSPORT)' => 'doctrinedbal',
            'env(PHPCR_BACKEND_URL)' => 'http://localhost:8080/server/',
            'env(PHPCR_USERNAME)' => 'admin',
            'env(PHPCR_PASSWORD)' => 'admin',
            'env(PHPCR_WORKSPACE)' => 'test',
            'secret' => 'test',
            'sulu_form.mail.from' => 'from@example.org',
            'sulu_form.mail.to' => 'to@example.org',
            'sulu_form.mail.template.notify' => 'SuluFormBundle:mails:notify.html.twig',
            'sulu_form.mail.template.notify_plain_text' => 'SuluFormBundle:mails:notify_plain_text.html.twig',
            'sulu_form.mail.template.customer' => 'SuluFormBundle:mails:customer.html.twig',
            'sulu_form.mail.template.customer_plain_text' => 'SuluFormBundle:mails:customer_plain_text.html.twig',
            'sulu_form.ajax_templates' => [

            ],
            'sulu_form.dynamic_widths' => [
                'full' => 'sulu_form.width.full',
                'half' => 'sulu_form.width.half',
                'one-third' => 'sulu_form.width.one-third',
                'two-thirds' => 'sulu_form.width.two-thirds',
                'one-quarter' => 'sulu_form.width.one-quarter',
                'three-quarters' => 'sulu_form.width.three-quarters',
                'one-sixth' => 'sulu_form.width.one-sixth',
                'five-sixths' => 'sulu_form.width.five-sixths',
            ],
            'sulu_form.dynamic_auto_title' => true,
            'sulu_form.mailchimp_api_key' => NULL,
            'sulu_form.mailchimp_subscribe_status' => 'subscribed',
            'sulu_form.dynamic_lists.config' => [

            ],
            'sulu_form.media_collection_strategy' => 'single',
            'sulu_form.static_forms' => [

            ],
            'sulu_form.dynamic_disabled_types' => [

            ],
            'sulu_form.dynamic_lists.sulu_form_form.config' => [
                'form' => [
                    'property' => 'id',
                    'position' => 40,
                    'name' => 'sulu_form.navigation.data',
                    'width' => 'max',
                ],
            ],
            'sulu_form.dynamic_list_builder.default' => 'simple',
            'sulu_form.dynamic_list_builder.delimiter' => ''."\n".'',
            'swiftmailer.mailer.default.transport.name' => 'null',
            'swiftmailer.mailer.default.transport.smtp.encryption' => NULL,
            'swiftmailer.mailer.default.transport.smtp.port' => 25,
            'swiftmailer.mailer.default.transport.smtp.host' => 'localhost',
            'swiftmailer.mailer.default.transport.smtp.username' => NULL,
            'swiftmailer.mailer.default.transport.smtp.password' => NULL,
            'swiftmailer.mailer.default.transport.smtp.auth_mode' => NULL,
            'swiftmailer.mailer.default.transport.smtp.timeout' => 30,
            'swiftmailer.mailer.default.transport.smtp.source_ip' => NULL,
            'swiftmailer.mailer.default.transport.smtp.local_domain' => NULL,
            'swiftmailer.mailer.default.spool.enabled' => false,
            'swiftmailer.mailer.default.plugin.impersonate' => NULL,
            'swiftmailer.mailer.default.single_address' => NULL,
            'swiftmailer.mailer.default.delivery.enabled' => false,
            'swiftmailer.spool.enabled' => false,
            'swiftmailer.delivery.enabled' => false,
            'swiftmailer.single_address' => NULL,
            'swiftmailer.mailers' => [
                'default' => 'swiftmailer.mailer.default',
            ],
            'swiftmailer.default_mailer' => 'default',
            'fragment.renderer.hinclude.global_template' => NULL,
            'fragment.path' => '/admin/_fragments',
            'kernel.secret' => 'secret',
            'kernel.http_method_override' => true,
            'kernel.trusted_hosts' => [

            ],
            'kernel.default_locale' => 'en',
            'templating.helper.code.file_link_format' => NULL,
            'debug.file_link_format' => NULL,
            'test.client.parameters' => [

            ],
            'session.metadata.storage_key' => '_sf2_meta',
            'session.storage.options' => [
                'cache_limiter' => '0',
                'cookie_path' => '/admin',
                'cookie_httponly' => true,
                'gc_probability' => 1,
            ],
            'session.metadata.update_threshold' => 0,
            'form.type_extension.csrf.enabled' => true,
            'form.type_extension.csrf.field_name' => '_token',
            'asset.request_context.base_path' => '',
            'asset.request_context.secure' => false,
            'templating.loader.cache.path' => NULL,
            'templating.engines' => [
                0 => 'twig',
            ],
            'validator.mapping.cache.prefix' => '',
            'validator.translation_domain' => 'validators',
            'translator.logging' => false,
            'profiler_listener.only_exceptions' => false,
            'profiler_listener.only_master_requests' => false,
            'debug.error_handler.throw_at' => -1,
            'router.request_context.host' => 'localhost',
            'router.request_context.scheme' => 'http',
            'router.request_context.base_url' => '',
            'router.cache_class_prefix' => 'adminAdminTestDebugProjectContainer',
            'request_listener.http_port' => 80,
            'request_listener.https_port' => 443,
            'serializer.mapping.cache.prefix' => '',
            'twig.exception_listener.controller' => 'sulu_website.exception.controller:showAction',
            'twig.form.resources' => [
                0 => 'form_div_layout.html.twig',
            ],
            'monolog.use_microseconds' => true,
            'monolog.swift_mailer.handlers' => [

            ],
            'monolog.handlers_to_channels' => [
                'monolog.handler.main' => NULL,
            ],
            'sulu_core.locales' => [
                0 => 'de',
                1 => 'en',
                2 => 'fr',
                3 => 'nl',
            ],
            'sulu_core.translated_locales' => [
                'de' => 'Deutsch',
                'en' => 'English',
                'fr' => 'Français',
                'nl' => 'Nederlands',
            ],
            'sulu_core.translations' => [
                0 => 'de',
                1 => 'en',
                2 => 'fr',
                3 => 'nl',
            ],
            'sulu_core.fallback_locale' => 'en',
            'sulu.content.language.namespace' => 'i18n',
            'sulu.content.language.default' => 'en',
            'sulu.content.node_names.base' => 'cmf',
            'sulu.content.node_names.content' => 'contents',
            'sulu.content.node_names.route' => 'routes',
            'sulu.content.node_names.snippet' => 'snippets',
            'sulu.content.structure.default_types' => [
                'snippet' => 'default',
            ],
            'sulu.content.structure.default_type.snippet' => 'default',
            'sulu.content.structure.required_properties' => [
                'snippet' => [
                    0 => 'title',
                ],
                'home' => [
                    0 => 'title',
                ],
                'page' => [
                    0 => 'title',
                ],
            ],
            'sulu.content.structure.required_tags' => [
                'home' => [
                    0 => 'sulu.rlp',
                ],
                'page' => [
                    0 => 'sulu.rlp',
                ],
            ],
            'sulu.content.internal_prefix' => '',
            'sulu.content.structure.type_map' => [
                'snippet' => 'Sulu\\Component\\Content\\Compat\\Structure\\SnippetBridge',
                'page' => 'Sulu\\Component\\Content\\Compat\\Structure\\PageBridge',
                'home' => 'Sulu\\Component\\Content\\Compat\\Structure\\PageBridge',
            ],
            'sulu.content.path_cleaner.replacer_loader.file_locator.class' => 'Symfony\\Component\\Config\\FileLocator',
            'sulu.content.path_cleaner.replacer_loader.class' => 'Sulu\\Bundle\\CoreBundle\\DataFixtures\\ReplacerXmlLoader',
            'sulu.content.path_cleaner.class' => 'Sulu\\Component\\PHPCR\\PathCleanup',
            'sulu.content.template_resolver.class' => 'Sulu\\Component\\Content\\Template\\TemplateResolver',
            'sulu.content.mapper.class' => 'Sulu\\Component\\Content\\Mapper\\ContentMapper',
            'sulu.content.structure_manager.class' => 'Sulu\\Component\\Content\\Compat\\StructureManager',
            'sulu.content.webspace_structure_provider.cache.class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
            'sulu.content.webspace_structure_provider.class' => 'Sulu\\Component\\Webspace\\StructureProvider\\WebspaceStructureProvider',
            'sulu.content.type_manager.class' => 'Sulu\\Component\\Content\\ContentTypeManager',
            'sulu.content.type.number.class' => 'Sulu\\Component\\Content\\Types\\Number',
            'sulu.content.type.text_line.class' => 'Sulu\\Component\\Content\\Types\\TextLine',
            'sulu.content.type.text_area.class' => 'Sulu\\Component\\Content\\Types\\TextArea',
            'sulu.content.type.text_editor.class' => 'Sulu\\Component\\Content\\Types\\TextEditor',
            'sulu.content.type.resource_locator.class' => 'Sulu\\Component\\Content\\Types\\ResourceLocator',
            'sulu.content.type.block.class' => 'Sulu\\Component\\Content\\Types\\BlockContentType',
            'sulu.content.resource_locator.mapper.phpcr.class' => 'Sulu\\Component\\Content\\Types\\ResourceLocator\\Mapper\\PhpcrMapper',
            'sulu.content.query_executor.class' => 'Sulu\\Component\\Content\\Query\\ContentQueryExecutor',
            'sulu.cache.warmer.structure.class' => 'Sulu\\Bundle\\CoreBundle\\Cache\\StructureWarmer',
            'sulu.util.node_helper.class' => 'Sulu\\Component\\Util\\SuluNodeHelper',
            'sulu_core.webspace.cache_class' => 'adminWebspaceCollectionCache',
            'sulu_core.webspace.base_class' => 'WebspaceCollection',
            'sulu_core.cache.memoize.default_lifetime' => 1,
            'sulu_core.cache.memoize.cache.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'sulu_core.cache.memoize.class' => 'Sulu\\Component\\Cache\\Memoize',
            'sulu.fields_defaults.translations' => [
                'id' => 'public.id',
                'title' => 'public.title',
                'name' => 'public.name',
                'created' => 'public.created',
                'changed' => 'public.changed',
            ],
            'sulu.fields_defaults.widths' => [
                'id' => '50px',
            ],
            'sulu.phpcr.session.class' => 'Sulu\\Component\\PHPCR\\SessionManager\\SessionManager',
            'sulu_core.build.builder.database.class' => 'Sulu\\Bundle\\CoreBundle\\Build\\DatabaseBuilder',
            'sulu_core.build.builder.phpcr.class' => 'Sulu\\Bundle\\CoreBundle\\Build\\PhpcrBuilder',
            'sulu_core.build.builder.phpcr_migrations.class' => 'Sulu\\Bundle\\CoreBundle\\Build\\PhpcrMigrationsBuilder',
            'sulu_core.build.builder.fixtures.class' => 'Sulu\\Bundle\\CoreBundle\\Build\\FixturesBuilder',
            'sulu.core.localization_manager.class' => 'Sulu\\Component\\Localization\\Manager\\LocalizationManager',
            'sulu.core.localization_manager.core_provider.class' => 'Sulu\\Component\\Localization\\Provider\\LocalizationProvider',
            'sulu_core.array_serialization_visitor.class' => 'Sulu\\Component\\Serializer\\ArraySerializationVisitor',
            'doctrine_cache.apc.class' => 'Doctrine\\Common\\Cache\\ApcCache',
            'doctrine_cache.apcu.class' => 'Doctrine\\Common\\Cache\\ApcuCache',
            'doctrine_cache.array.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'doctrine_cache.chain.class' => 'Doctrine\\Common\\Cache\\ChainCache',
            'doctrine_cache.couchbase.class' => 'Doctrine\\Common\\Cache\\CouchbaseCache',
            'doctrine_cache.couchbase.connection.class' => 'Couchbase',
            'doctrine_cache.couchbase.hostnames' => 'localhost:8091',
            'doctrine_cache.file_system.class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
            'doctrine_cache.php_file.class' => 'Doctrine\\Common\\Cache\\PhpFileCache',
            'doctrine_cache.memcache.class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
            'doctrine_cache.memcache.connection.class' => 'Memcache',
            'doctrine_cache.memcache.host' => 'localhost',
            'doctrine_cache.memcache.port' => 11211,
            'doctrine_cache.memcached.class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
            'doctrine_cache.memcached.connection.class' => 'Memcached',
            'doctrine_cache.memcached.host' => 'localhost',
            'doctrine_cache.memcached.port' => 11211,
            'doctrine_cache.mongodb.class' => 'Doctrine\\Common\\Cache\\MongoDBCache',
            'doctrine_cache.mongodb.collection.class' => 'MongoCollection',
            'doctrine_cache.mongodb.connection.class' => 'MongoClient',
            'doctrine_cache.mongodb.server' => 'localhost:27017',
            'doctrine_cache.predis.client.class' => 'Predis\\Client',
            'doctrine_cache.predis.scheme' => 'tcp',
            'doctrine_cache.predis.host' => 'localhost',
            'doctrine_cache.predis.port' => 6379,
            'doctrine_cache.redis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'doctrine_cache.redis.connection.class' => 'Redis',
            'doctrine_cache.redis.host' => 'localhost',
            'doctrine_cache.redis.port' => 6379,
            'doctrine_cache.riak.class' => 'Doctrine\\Common\\Cache\\RiakCache',
            'doctrine_cache.riak.bucket.class' => 'Riak\\Bucket',
            'doctrine_cache.riak.connection.class' => 'Riak\\Connection',
            'doctrine_cache.riak.bucket_property_list.class' => 'Riak\\BucketPropertyList',
            'doctrine_cache.riak.host' => 'localhost',
            'doctrine_cache.riak.port' => 8087,
            'doctrine_cache.sqlite3.class' => 'Doctrine\\Common\\Cache\\SQLite3Cache',
            'doctrine_cache.sqlite3.connection.class' => 'SQLite3',
            'doctrine_cache.void.class' => 'Doctrine\\Common\\Cache\\VoidCache',
            'doctrine_cache.wincache.class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
            'doctrine_cache.xcache.class' => 'Doctrine\\Common\\Cache\\XcacheCache',
            'doctrine_cache.zenddata.class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
            'doctrine_cache.security.acl.cache.class' => 'Doctrine\\Bundle\\DoctrineCacheBundle\\Acl\\Model\\AclCache',
            'doctrine.dbal.logger.chain.class' => 'Doctrine\\DBAL\\Logging\\LoggerChain',
            'doctrine.dbal.logger.profiling.class' => 'Doctrine\\DBAL\\Logging\\DebugStack',
            'doctrine.dbal.logger.class' => 'Symfony\\Bridge\\Doctrine\\Logger\\DbalLogger',
            'doctrine.dbal.configuration.class' => 'Doctrine\\DBAL\\Configuration',
            'doctrine.data_collector.class' => 'Doctrine\\Bundle\\DoctrineBundle\\DataCollector\\DoctrineDataCollector',
            'doctrine.dbal.connection.event_manager.class' => 'Symfony\\Bridge\\Doctrine\\ContainerAwareEventManager',
            'doctrine.dbal.connection_factory.class' => 'Doctrine\\Bundle\\DoctrineBundle\\ConnectionFactory',
            'doctrine.dbal.events.mysql_session_init.class' => 'Doctrine\\DBAL\\Event\\Listeners\\MysqlSessionInit',
            'doctrine.dbal.events.oracle_session_init.class' => 'Doctrine\\DBAL\\Event\\Listeners\\OracleSessionInit',
            'doctrine.class' => 'Doctrine\\Bundle\\DoctrineBundle\\Registry',
            'doctrine.entity_managers' => [
                'default' => 'doctrine.orm.default_entity_manager',
            ],
            'doctrine.default_entity_manager' => 'default',
            'doctrine.dbal.connection_factory.types' => [

            ],
            'doctrine.connections' => [
                'default' => 'doctrine.dbal.default_connection',
            ],
            'doctrine.default_connection' => 'default',
            'doctrine.orm.configuration.class' => 'Doctrine\\ORM\\Configuration',
            'doctrine.orm.entity_manager.class' => 'Doctrine\\ORM\\EntityManager',
            'doctrine.orm.manager_configurator.class' => 'Doctrine\\Bundle\\DoctrineBundle\\ManagerConfigurator',
            'doctrine.orm.cache.array.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'doctrine.orm.cache.apc.class' => 'Doctrine\\Common\\Cache\\ApcCache',
            'doctrine.orm.cache.memcache.class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
            'doctrine.orm.cache.memcache_host' => 'localhost',
            'doctrine.orm.cache.memcache_port' => 11211,
            'doctrine.orm.cache.memcache_instance.class' => 'Memcache',
            'doctrine.orm.cache.memcached.class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
            'doctrine.orm.cache.memcached_host' => 'localhost',
            'doctrine.orm.cache.memcached_port' => 11211,
            'doctrine.orm.cache.memcached_instance.class' => 'Memcached',
            'doctrine.orm.cache.redis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'doctrine.orm.cache.redis_host' => 'localhost',
            'doctrine.orm.cache.redis_port' => 6379,
            'doctrine.orm.cache.redis_instance.class' => 'Redis',
            'doctrine.orm.cache.xcache.class' => 'Doctrine\\Common\\Cache\\XcacheCache',
            'doctrine.orm.cache.wincache.class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
            'doctrine.orm.cache.zenddata.class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
            'doctrine.orm.metadata.driver_chain.class' => 'Doctrine\\Common\\Persistence\\Mapping\\Driver\\MappingDriverChain',
            'doctrine.orm.metadata.annotation.class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
            'doctrine.orm.metadata.xml.class' => 'Doctrine\\ORM\\Mapping\\Driver\\SimplifiedXmlDriver',
            'doctrine.orm.metadata.yml.class' => 'Doctrine\\ORM\\Mapping\\Driver\\SimplifiedYamlDriver',
            'doctrine.orm.metadata.php.class' => 'Doctrine\\ORM\\Mapping\\Driver\\PHPDriver',
            'doctrine.orm.metadata.staticphp.class' => 'Doctrine\\ORM\\Mapping\\Driver\\StaticPHPDriver',
            'doctrine.orm.proxy_cache_warmer.class' => 'Symfony\\Bridge\\Doctrine\\CacheWarmer\\ProxyCacheWarmer',
            'form.type_guesser.doctrine.class' => 'Symfony\\Bridge\\Doctrine\\Form\\DoctrineOrmTypeGuesser',
            'doctrine.orm.validator.unique.class' => 'Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntityValidator',
            'doctrine.orm.validator_initializer.class' => 'Symfony\\Bridge\\Doctrine\\Validator\\DoctrineInitializer',
            'doctrine.orm.security.user.provider.class' => 'Symfony\\Bridge\\Doctrine\\Security\\User\\EntityUserProvider',
            'doctrine.orm.listeners.resolve_target_entity.class' => 'Doctrine\\ORM\\Tools\\ResolveTargetEntityListener',
            'doctrine.orm.listeners.attach_entity_listeners.class' => 'Doctrine\\ORM\\Tools\\AttachEntityListenersListener',
            'doctrine.orm.naming_strategy.default.class' => 'Doctrine\\ORM\\Mapping\\DefaultNamingStrategy',
            'doctrine.orm.naming_strategy.underscore.class' => 'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy',
            'doctrine.orm.quote_strategy.default.class' => 'Doctrine\\ORM\\Mapping\\DefaultQuoteStrategy',
            'doctrine.orm.quote_strategy.ansi.class' => 'Doctrine\\ORM\\Mapping\\AnsiQuoteStrategy',
            'doctrine.orm.entity_listener_resolver.class' => 'Doctrine\\Bundle\\DoctrineBundle\\Mapping\\ContainerEntityListenerResolver',
            'doctrine.orm.second_level_cache.default_cache_factory.class' => 'Doctrine\\ORM\\Cache\\DefaultCacheFactory',
            'doctrine.orm.second_level_cache.default_region.class' => 'Doctrine\\ORM\\Cache\\Region\\DefaultRegion',
            'doctrine.orm.second_level_cache.filelock_region.class' => 'Doctrine\\ORM\\Cache\\Region\\FileLockRegion',
            'doctrine.orm.second_level_cache.logger_chain.class' => 'Doctrine\\ORM\\Cache\\Logging\\CacheLoggerChain',
            'doctrine.orm.second_level_cache.logger_statistics.class' => 'Doctrine\\ORM\\Cache\\Logging\\StatisticsCacheLogger',
            'doctrine.orm.second_level_cache.cache_configuration.class' => 'Doctrine\\ORM\\Cache\\CacheConfiguration',
            'doctrine.orm.second_level_cache.regions_configuration.class' => 'Doctrine\\ORM\\Cache\\RegionsConfiguration',
            'doctrine.orm.auto_generate_proxy_classes' => true,
            'doctrine.orm.proxy_namespace' => 'Proxies',
            'doctrine_phpcr.sessions' => [
                'default' => 'doctrine_phpcr.default_session',
                'live' => 'doctrine_phpcr.live_session',
            ],
            'doctrine_phpcr.odm.document_managers' => [

            ],
            'doctrine_phpcr.default_session' => 'default',
            'doctrine_phpcr.odm.default_document_manager' => '',
            'doctrine_phpcr.dump_max_line_length' => 120,
            'doctrine_phpcr.form.type_guess' => [

            ],
            'phpcr_migrations.version_node_name' => 'jcr:versions',
            'phpcr_migrations.paths' => [
                0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/Resources/phpcr-migrations',
                1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/Resources/phpcr-migrations',
            ],
            'stof_doctrine_extensions.listener.tree.class' => 'Gedmo\\Tree\\TreeListener',
            'stof_doctrine_extensions.default_locale' => 'en',
            'stof_doctrine_extensions.translation_fallback' => false,
            'stof_doctrine_extensions.persist_default_translation' => false,
            'stof_doctrine_extensions.skip_translation_on_load' => false,
            'stof_doctrine_extensions.listener.translatable.class' => 'Gedmo\\Translatable\\TranslatableListener',
            'stof_doctrine_extensions.listener.timestampable.class' => 'Gedmo\\Timestampable\\TimestampableListener',
            'stof_doctrine_extensions.listener.blameable.class' => 'Gedmo\\Blameable\\BlameableListener',
            'stof_doctrine_extensions.listener.sluggable.class' => 'Gedmo\\Sluggable\\SluggableListener',
            'stof_doctrine_extensions.listener.loggable.class' => 'Gedmo\\Loggable\\LoggableListener',
            'stof_doctrine_extensions.listener.sortable.class' => 'Gedmo\\Sortable\\SortableListener',
            'stof_doctrine_extensions.listener.softdeleteable.class' => 'Gedmo\\SoftDeleteable\\SoftDeleteableListener',
            'stof_doctrine_extensions.listener.uploadable.class' => 'Gedmo\\Uploadable\\UploadableListener',
            'stof_doctrine_extensions.listener.reference_integrity.class' => 'Gedmo\\ReferenceIntegrity\\ReferenceIntegrityListener',
            'jms_serializer.metadata.file_locator.class' => 'Metadata\\Driver\\FileLocator',
            'jms_serializer.metadata.annotation_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\AnnotationDriver',
            'jms_serializer.metadata.chain_driver.class' => 'Metadata\\Driver\\DriverChain',
            'jms_serializer.metadata.yaml_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\YamlDriver',
            'jms_serializer.metadata.xml_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\XmlDriver',
            'jms_serializer.metadata.php_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\PhpDriver',
            'jms_serializer.metadata.doctrine_type_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\DoctrineTypeDriver',
            'jms_serializer.metadata.doctrine_phpcr_type_driver.class' => 'JMS\\Serializer\\Metadata\\Driver\\DoctrinePHPCRTypeDriver',
            'jms_serializer.metadata.lazy_loading_driver.class' => 'Metadata\\Driver\\LazyLoadingDriver',
            'jms_serializer.metadata.metadata_factory.class' => 'Metadata\\MetadataFactory',
            'jms_serializer.metadata.cache.file_cache.class' => 'Metadata\\Cache\\FileCache',
            'jms_serializer.event_dispatcher.class' => 'JMS\\Serializer\\EventDispatcher\\LazyEventDispatcher',
            'jms_serializer.camel_case_naming_strategy.class' => 'JMS\\Serializer\\Naming\\CamelCaseNamingStrategy',
            'jms_serializer.identical_property_naming_strategy.class' => 'JMS\\Serializer\\Naming\\IdenticalPropertyNamingStrategy',
            'jms_serializer.serialized_name_annotation_strategy.class' => 'JMS\\Serializer\\Naming\\SerializedNameAnnotationStrategy',
            'jms_serializer.cache_naming_strategy.class' => 'JMS\\Serializer\\Naming\\CacheNamingStrategy',
            'jms_serializer.doctrine_object_constructor.class' => 'JMS\\Serializer\\Construction\\DoctrineObjectConstructor',
            'jms_serializer.unserialize_object_constructor.class' => 'JMS\\Serializer\\Construction\\UnserializeObjectConstructor',
            'jms_serializer.version_exclusion_strategy.class' => 'JMS\\Serializer\\Exclusion\\VersionExclusionStrategy',
            'jms_serializer.serializer.class' => 'JMS\\Serializer\\Serializer',
            'jms_serializer.twig_extension.class' => 'JMS\\Serializer\\Twig\\SerializerExtension',
            'jms_serializer.twig_runtime_extension.class' => 'JMS\\Serializer\\Twig\\SerializerRuntimeExtension',
            'jms_serializer.twig_runtime_extension_helper.class' => 'JMS\\Serializer\\Twig\\SerializerRuntimeHelper',
            'jms_serializer.templating.helper.class' => 'JMS\\SerializerBundle\\Templating\\SerializerHelper',
            'jms_serializer.json_serialization_visitor.class' => 'JMS\\Serializer\\JsonSerializationVisitor',
            'jms_serializer.json_serialization_visitor.options' => 0,
            'jms_serializer.json_deserialization_visitor.class' => 'JMS\\Serializer\\JsonDeserializationVisitor',
            'jms_serializer.xml_serialization_visitor.class' => 'JMS\\Serializer\\XmlSerializationVisitor',
            'jms_serializer.xml_deserialization_visitor.class' => 'JMS\\Serializer\\XmlDeserializationVisitor',
            'jms_serializer.xml_deserialization_visitor.doctype_whitelist' => [

            ],
            'jms_serializer.xml_serialization_visitor.format_output' => true,
            'jms_serializer.yaml_serialization_visitor.class' => 'JMS\\Serializer\\YamlSerializationVisitor',
            'jms_serializer.handler_registry.class' => 'JMS\\Serializer\\Handler\\LazyHandlerRegistry',
            'jms_serializer.datetime_handler.class' => 'JMS\\Serializer\\Handler\\DateHandler',
            'jms_serializer.array_collection_handler.class' => 'JMS\\Serializer\\Handler\\ArrayCollectionHandler',
            'jms_serializer.php_collection_handler.class' => 'JMS\\Serializer\\Handler\\PhpCollectionHandler',
            'jms_serializer.form_error_handler.class' => 'JMS\\Serializer\\Handler\\FormErrorHandler',
            'jms_serializer.constraint_violation_handler.class' => 'JMS\\Serializer\\Handler\\ConstraintViolationHandler',
            'jms_serializer.doctrine_proxy_subscriber.class' => 'JMS\\Serializer\\EventDispatcher\\Subscriber\\DoctrineProxySubscriber',
            'jms_serializer.stopwatch_subscriber.class' => 'JMS\\SerializerBundle\\Serializer\\StopwatchEventSubscriber',
            'jms_serializer.configured_context_factory.class' => 'JMS\\SerializerBundle\\ContextFactory\\ConfiguredContextFactory',
            'jms_serializer.expression_evaluator.class' => 'JMS\\Serializer\\Expression\\ExpressionEvaluator',
            'jms_serializer.expression_language.class' => 'Symfony\\Component\\ExpressionLanguage\\ExpressionLanguage',
            'jms_serializer.expression_language.function_provider.class' => 'JMS\\SerializerBundle\\ExpressionLanguage\\BasicSerializerFunctionsProvider',
            'jms_serializer.accessor_strategy.default.class' => 'JMS\\Serializer\\Accessor\\DefaultAccessorStrategy',
            'jms_serializer.accessor_strategy.expression.class' => 'JMS\\Serializer\\Accessor\\ExpressionAccessorStrategy',
            'jms_serializer.cache.cache_warmer.class' => 'JMS\\SerializerBundle\\Cache\\CacheWarmer',
            'massive_search.search_manager.class' => 'Massive\\Bundle\\SearchBundle\\Search\\SearchManager',
            'massive_search.object_to_document_converter.class' => 'Massive\\Bundle\\SearchBundle\\Search\\ObjectToDocumentConverter',
            'massive_search.expression_language.class' => 'Massive\\Bundle\\SearchBundle\\Search\\ExpressionLanguage\\MassiveSearchExpressionLanguage',
            'massive_search.search.adapter.zend_lucene.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Adapter\\ZendLuceneAdapter',
            'massive_search.search.adapter.test.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Adapter\\TestAdapter',
            'massive_search.factory_default.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Factory',
            'massive_search.controller.rest.class' => 'Massive\\Bundle\\SearchBundle\\Controller\\SearchController',
            'massive_search.events.index' => 'massive_search.index',
            'massive_search.events.deindex' => 'massive_search.deindex',
            'massive_search.adapter.zend_lucene.hide_index_exception' => false,
            'massive_search.adapter.zend_lucene.encoding' => 'UTF-8',
            'massive_search.metadata.prefix' => 'massive',
            'massive_search.metadata.debug' => true,
            'massive_search.metadata.driver.xml.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Metadata\\Driver\\XmlDriver',
            'massive_search.metadata.driver.annotation.class' => 'Symfony\\Cmf\\Bundle\\TreeUiBundle\\Tree\\Metadata\\Driver\\AnnotationDriver',
            'massive_search.metadata.driver.chain.class' => 'Metadata\\Driver\\DriverChain',
            'massive_search.metadata.file_locator.class' => 'Metadata\\Driver\\FileLocator',
            'massive_search.metadata.factory.class' => 'Metadata\\MetadataFactory',
            'massive_search.metadata.field_evaluator.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Metadata\\FieldEvaluator',
            'massive_search.metadata.cache.file_cache.class' => 'Metadata\\Cache\\FileCache',
            'massive_search.metadata.provider.default.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Metadata\\Provider\\DefaultProvider',
            'massive_search.metadata.provider.chain.class' => 'Massive\\Bundle\\SearchBundle\\Search\\Metadata\\Provider\\ChainProvider',
            'sulu_search.indexes' => [
                'snippet' => [
                    'name' => 'sulu_snippet.snippets',
                    'icon' => 'su-snippet',
                    'route' => [
                        'name' => 'sulu_snippet.edit_form',
                        'result_to_route' => [
                            'id' => 'id',
                            'locale' => 'locale',
                        ],
                    ],
                    'security_context' => 'sulu.global.snippets',
                    'contexts' => [

                    ],
                ],
                'category' => [
                    'name' => 'sulu_category.categories',
                    'icon' => 'su-tag',
                    'route' => [
                        'name' => 'sulu_category.edit_form',
                        'result_to_route' => [
                            'id' => 'id',
                            'locale' => 'locale',
                        ],
                    ],
                    'security_context' => 'sulu.settings.categories',
                    'contexts' => [

                    ],
                ],
                'media' => [
                    'name' => 'sulu_media.media',
                    'icon' => 'su-image',
                    'route' => [
                        'name' => 'sulu_media.form',
                        'result_to_route' => [
                            'id' => 'id',
                            'locale' => 'locale',
                        ],
                    ],
                    'security_context' => 'sulu.media.collections',
                    'contexts' => [

                    ],
                ],
                'contact' => [
                    'name' => 'sulu_contact.people',
                    'icon' => 'su-user',
                    'route' => [
                        'name' => 'sulu_contact.contact_edit_form',
                        'result_to_route' => [
                            'id' => 'id',
                            'locale' => 'locale',
                        ],
                    ],
                    'security_context' => 'sulu.contact.people',
                    'contexts' => [

                    ],
                ],
                'account' => [
                    'name' => 'sulu_contact.organizations',
                    'icon' => 'su-house',
                    'route' => [
                        'name' => 'sulu_contact.account_edit_form',
                        'result_to_route' => [
                            'id' => 'id',
                            'locale' => 'locale',
                        ],
                    ],
                    'security_context' => 'sulu.contact.organizations',
                    'contexts' => [

                    ],
                ],
            ],
            'sulu_search.controller.search.class' => 'Sulu\\Bundle\\SearchBundle\\Controller\\SearchController',
            'sulu_search.search.factory.class' => 'Sulu\\Bundle\\SearchBundle\\Search\\Factory',
            'sulu_search.build.index.class' => 'Sulu\\Bundle\\SearchBundle\\Build\\IndexBuilder',
            'sulu.persistence.event_subscriber.orm.timestampable.class' => 'Sulu\\Component\\Persistence\\EventSubscriber\\ORM\\TimestampableSubscriber',
            'sulu.persistence.event_subscriber.orm.user_blame.class' => 'Sulu\\Component\\Persistence\\EventSubscriber\\ORM\\UserBlameSubscriber',
            'sulu.persistence.event_subscriber.orm.metadata.class' => 'Sulu\\Component\\Persistence\\EventSubscriber\\ORM\\MetadataSubscriber',
            'sulu_page.search.mapping' => [
                'Sulu\\Bundle\\SnippetBundle\\Document\\SnippetDocument' => [
                    'index' => 'snippet',
                    'decorate_index' => false,
                ],
                'Sulu\\Bundle\\PageBundle\\Document\\PageDocument' => [
                    'index' => 'page',
                    'decorate_index' => true,
                ],
                'Sulu\\Bundle\\PageBundle\\Document\\HomeDocument' => [
                    'index' => 'page',
                    'decorate_index' => true,
                ],
            ],
            'sulu_page.search.metadata.provider.structure.class' => 'Sulu\\Bundle\\PageBundle\\Search\\Metadata\\StructureProvider',
            'sulu_page.search.event_subscriber.blame_timestamp.class' => 'Sulu\\Bundle\\PageBundle\\Search\\EventSubscriber\\BlameTimestampSubscriber',
            'sulu_page.search.event_subscriber.structure.class' => 'Sulu\\Bundle\\PageBundle\\Search\\EventSubscriber\\StructureSubscriber',
            'sulu_search.event_listener.hit.class' => 'Sulu\\Bundle\\PageBundle\\Search\\EventListener\\HitListener',
            'sulu_page.admin.class' => 'Sulu\\Bundle\\PageBundle\\Admin\\PageAdmin',
            'sulu_page.node_repository.class' => 'Sulu\\Bundle\\PageBundle\\Repository\\NodeRepository',
            'sulu_page.rl_repository.class' => 'Sulu\\Bundle\\PageBundle\\Repository\\ResourceLocatorRepository',
            'sulu_page.extension.seo.class' => 'Sulu\\Bundle\\PageBundle\\Content\\Structure\\SeoStructureExtension',
            'sulu_page.extension.excerpt.class' => 'Sulu\\Bundle\\PageBundle\\Content\\Structure\\ExcerptStructureExtension',
            'sulu_page.smart_content.data_provider_pool.class' => 'Sulu\\Component\\SmartContent\\DataProviderPool',
            'sulu_page.smart_content.data_provider.content.query_builder.class' => 'Sulu\\Component\\Content\\SmartContent\\QueryBuilder',
            'sulu_page.smart_content.data_provider.page.class' => 'Sulu\\Component\\Content\\SmartContent\\PageDataProvider',
            'sulu_page.smart_content.data_provider.content.proxy_factory.class' => 'ProxyManager\\Factory\\LazyLoadingValueHolderFactory',
            'sulu_page.smart_content.content_type.class' => 'Sulu\\Component\\SmartContent\\ContentType',
            'sulu_page.extension.manager.class' => 'Sulu\\Component\\Content\\Extension\\ExtensionManager',
            'sulu_page.export.webspace.formats' => [
                '1.2.xliff' => 'SuluPageBundle:Export:Webspace/1.2.xliff.twig',
            ],
            'sulu_page.default_author' => true,
            'sulu_page.seo' => [
                'max_title_length' => 70,
                'max_description_length' => 320,
                'max_keywords' => 5,
                'keywords_separator' => ',',
                'url_prefix' => 'www.yoursite.com/{locale}',
            ],
            'sulu_contact.country.entity' => 'SuluContactBundle:Country',
            'sulu_contact.contact_title.entity' => 'SuluContactBundle:ContactTitle',
            'sulu_contact.defaults' => [
                'phoneType' => '1',
                'phoneTypeMobile' => '3',
                'phoneTypeIsdn' => '1',
                'emailType' => '1',
                'addressType' => '1',
                'urlType' => '1',
                'faxType' => '1',
                'socialMediaProfileType' => '1',
                'country' => 'AT',
            ],
            'sulu_contact.form_of_address' => [
                'male' => [
                    'id' => 0,
                    'name' => 'male',
                    'translation' => 'contact.contacts.formOfAddress.male',
                ],
                'female' => [
                    'id' => 1,
                    'name' => 'female',
                    'translation' => 'contact.contacts.formOfAddress.female',
                ],
            ],
            'sulu_contact.contact_form.category_root' => NULL,
            'sulu_contact.account_form.category_root' => NULL,
            'sulu.model.contact.class' => 'Sulu\\Bundle\\ContactBundle\\Entity\\Contact',
            'sulu.repository.contact.class' => 'Sulu\\Bundle\\ContactBundle\\Entity\\ContactRepository',
            'sulu.model.account.class' => 'Sulu\\Bundle\\ContactBundle\\Entity\\Account',
            'sulu.repository.account.class' => 'Sulu\\Bundle\\ContactBundle\\Entity\\AccountRepository',
            'sulu.persistence.objects' => [
                'sulu' => [
                    'target_group' => [
                        'model' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroup',
                        'repository' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRepository',
                    ],
                    'target_group_condition' => [
                        'model' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupCondition',
                        'repository' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupConditionRepository',
                    ],
                    'target_group_rule' => [
                        'model' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRule',
                        'repository' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRuleRepository',
                    ],
                    'target_group_webspace' => [
                        'model' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupWebspace',
                        'repository' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupWebspaceRepository',
                    ],
                    'route' => [
                        'model' => 'Sulu\\Bundle\\RouteBundle\\Entity\\Route',
                        'repository' => 'Sulu\\Bundle\\RouteBundle\\Entity\\RouteRepository',
                    ],
                    'category' => [
                        'model' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\Category',
                        'repository' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryRepository',
                    ],
                    'category_meta' => [
                        'model' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMeta',
                        'repository' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMetaRepository',
                    ],
                    'category_translation' => [
                        'model' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslation',
                        'repository' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslationRepository',
                    ],
                    'keyword' => [
                        'model' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\Keyword',
                        'repository' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\KeywordRepository',
                    ],
                    'media' => [
                        'model' => 'Sulu\\Bundle\\MediaBundle\\Entity\\Media',
                        'repository' => 'Sulu\\Bundle\\MediaBundle\\Entity\\MediaRepository',
                    ],
                    'tag' => [
                        'model' => 'Sulu\\Bundle\\TagBundle\\Entity\\Tag',
                        'repository' => 'Sulu\\Bundle\\TagBundle\\Entity\\TagRepository',
                    ],
                    'user' => [
                        'model' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\User',
                        'repository' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\UserRepository',
                    ],
                    'role' => [
                        'model' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\Role',
                        'repository' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleRepository',
                    ],
                    'role_setting' => [
                        'model' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleSetting',
                        'repository' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleSettingRepository',
                    ],
                    'access_control' => [
                        'model' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\AccessControl',
                        'repository' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\AccessControlRepository',
                    ],
                    'contact' => [
                        'model' => 'Sulu\\Bundle\\ContactBundle\\Entity\\Contact',
                        'repository' => 'Sulu\\Bundle\\ContactBundle\\Entity\\ContactRepository',
                    ],
                    'account' => [
                        'model' => 'Sulu\\Bundle\\ContactBundle\\Entity\\Account',
                        'repository' => 'Sulu\\Bundle\\ContactBundle\\Entity\\AccountRepository',
                    ],
                ],
            ],
            'sulu_security.system' => 'Sulu',
            'sulu_security.security_types.fixture' => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/DependencyInjection/../DataFixtures/security-types.xml',
            'sulu_security.reset_password.mail.token_send_limit' => 3,
            'sulu_security.reset_password.mail.sender' => '',
            'sulu_security.reset_password.mail.subject' => 'sulu_security.reset_mail_subject',
            'sulu_security.reset_password.mail.template' => 'SuluSecurityBundle:mail_templates:reset_password.html.twig',
            'sulu_security.reset_password.mail.translation_domain' => 'admin',
            'sulu_security.permissions' => [
                'view' => 64,
                'add' => 32,
                'edit' => 16,
                'delete' => 8,
                'archive' => 4,
                'live' => 2,
                'security' => 1,
            ],
            'permissions' => [
                'view' => 64,
                'add' => 32,
                'edit' => 16,
                'delete' => 8,
                'archive' => 4,
                'live' => 2,
                'security' => 1,
            ],
            'sulu_security.admin.class' => 'Sulu\\Bundle\\SecurityBundle\\Admin\\SecurityAdmin',
            'sulu_security.authentication_entry_point.class' => 'Sulu\\Bundle\\SecurityBundle\\Security\\AuthenticationEntryPoint',
            'sulu_security.authentication_handler.class' => 'Sulu\\Bundle\\SecurityBundle\\Security\\AuthenticationHandler',
            'sulu_security.mask_converter.class' => 'Sulu\\Component\\Security\\Authorization\\MaskConverter',
            'sulu_security.salt_generator.class' => 'Sulu\\Component\\Security\\Authentication\\SaltGenerator',
            'sulu_security.token_generator.class' => 'Sulu\\Bundle\\SecurityBundle\\Util\\TokenGenerator',
            'sulu_security.security_context_voter.class' => 'Sulu\\Component\\Security\\Authorization\\SecurityContextVoter',
            'sulu_security.access_control_manager.class' => 'Sulu\\Component\\Security\\Authorization\\AccessControl\\AccessControlManager',
            'sulu_security.phpcr_access_control_provider.class' => 'Sulu\\Component\\Security\\Authorization\\AccessControl\\PhpcrAccessControlProvider',
            'sulu_security.doctrine_access_control_provider.class' => 'Sulu\\Component\\Security\\Authorization\\AccessControl\\DoctrineAccessControlProvider',
            'sulu_security.permission_controller.class' => 'Sulu\\Bundle\\SecurityBundle\\Controller\\PermissionController',
            'sulu_security.group_repository.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\GroupRepository',
            'sulu_security.user_repository.class' => 'Sulu\\Component\\Security\\Authentication\\UserRepository',
            'sulu_security.user_setting_repository.class' => 'Sulu\\Component\\Security\\Authentication\\UserSettingRepository',
            'sulu_security.user_repository_factory.class' => 'Sulu\\Component\\Security\\Authentication\\UserRepositoryFactory',
            'sulu_security.build.user.class' => 'Sulu\\Bundle\\SecurityBundle\\Build\\UserBuilder',
            'sulu_security.entity.role' => 'SuluSecurityBundle:Role',
            'sulu_security.entity.group' => 'SuluSecurityBundle:Group',
            'sulu_security.entity.user_setting' => 'SuluSecurityBundle:UserSetting',
            'sulu_security.profile_controller.class' => 'Sulu\\Bundle\\SecurityBundle\\Controller\\ProfileController',
            'sulu.model.user.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\User',
            'sulu.repository.user.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\UserRepository',
            'sulu.model.role.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\Role',
            'sulu.repository.role.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleRepository',
            'sulu.model.role_setting.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleSetting',
            'sulu.repository.role_setting.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\RoleSettingRepository',
            'sulu.model.access_control.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\AccessControl',
            'sulu.repository.access_control.class' => 'Sulu\\Bundle\\SecurityBundle\\Entity\\AccessControlRepository',
            'sulu_website.navigation.cache.lifetime' => 1,
            'sulu_website.content.cache.lifetime' => 1,
            'sulu_website.sitemap.cache.lifetime' => 1,
            'sulu_website.sitemap.default_host' => NULL,
            'sulu_website.admin.class' => 'Sulu\\Bundle\\WebsiteBundle\\Admin\\WebsiteAdmin',
            'sulu_website.navigation_mapper.class' => 'Sulu\\Bundle\\WebsiteBundle\\Navigation\\NavigationMapper',
            'sulu_website.sitemap.class' => 'Sulu\\Bundle\\WebsiteBundle\\Sitemap\\SitemapGenerator',
            'sulu_website.twig.content_path.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Content\\ContentPathTwigExtension',
            'sulu_website.twig.navigation.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Navigation\\NavigationTwigExtension',
            'sulu_website.twig.navigation.memoized.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Navigation\\MemoizedNavigationTwigExtension',
            'sulu_website.twig.sitemap.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Sitemap\\SitemapTwigExtension',
            'sulu_website.twig.sitemap.memoized.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Sitemap\\MemoizedSitemapTwigExtension',
            'sulu_website.twig.content.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Content\\ContentTwigExtension',
            'sulu_website.twig.content.memoized.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Content\\MemoizedContentTwigExtension',
            'sulu_website.twig.meta.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Meta\\MetaTwigExtension',
            'sulu_website.twig.seo.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Seo\\SeoTwigExtension',
            'sulu_website.twig.util.class' => 'Sulu\\Bundle\\WebsiteBundle\\Twig\\Core\\UtilTwigExtension',
            'sulu_website.routing.portal_loader.class' => 'Sulu\\Bundle\\WebsiteBundle\\Routing\\PortalLoader',
            'sulu_website.exception.controller.class' => 'Sulu\\Bundle\\WebsiteBundle\\Controller\\ExceptionController',
            'sulu_website.resolver.request_analyzer.class' => 'Sulu\\Bundle\\WebsiteBundle\\Resolver\\RequestAnalyzerResolver',
            'sulu_website.resolver.structure.class' => 'Sulu\\Bundle\\WebsiteBundle\\Resolver\\StructureResolver',
            'sulu_website.resolver.parameter.class' => 'Sulu\\Bundle\\WebsiteBundle\\Resolver\\ParameterResolver',
            'sulu_website.navigation_mapper.query_builder.class' => 'Sulu\\Bundle\\WebsiteBundle\\Navigation\\NavigationQueryBuilder',
            'sulu_website.sitemap.query_builder.class' => 'Sulu\\Bundle\\WebsiteBundle\\Sitemap\\SitemapContentQueryBuilder',
            'sulu.test_user_provider.class' => 'Sulu\\Bundle\\TestBundle\\Testing\\TestUserProvider',
            'sulu.test_voter.class' => 'Sulu\\Bundle\\TestBundle\\Testing\\TestVoter',
            'sulu_test.test_user_repository.class' => 'Sulu\\Bundle\\TestBundle\\Entity\\TestUserRepository',
            'sulu.model.tag.class' => 'Sulu\\Bundle\\TagBundle\\Entity\\Tag',
            'sulu.repository.tag.class' => 'Sulu\\Bundle\\TagBundle\\Entity\\TagRepository',
            'sulu.model.collection.class' => 'Sulu\\Bundle\\MediaBundle\\Entity\\Collection',
            'sulu_media.system_collections' => [
                'sulu_media' => [
                    'meta_title' => [
                        'en' => 'Sulu media',
                        'de' => 'Sulu Medien',
                    ],
                    'collections' => [
                        'preview_image' => [
                            'meta_title' => [
                                'en' => 'Preview images',
                                'de' => 'Vorschaubilder',
                            ],
                        ],
                    ],
                ],
                'sulu_contact' => [
                    'meta_title' => [
                        'en' => 'Sulu contacts',
                        'de' => 'Sulu Kontakte',
                    ],
                    'collections' => [
                        'contact' => [
                            'meta_title' => [
                                'en' => 'People',
                                'de' => 'Personen',
                            ],
                        ],
                        'account' => [
                            'meta_title' => [
                                'en' => 'Organizations',
                                'de' => 'Organisationen',
                            ],
                        ],
                    ],
                ],
                'sulu_form' => [
                    'meta_title' => [
                        'en' => 'Sulu forms',
                        'de' => 'Sulu Formulare',
                    ],
                    'collections' => [
                        'attachments' => [
                            'meta_title' => [
                                'en' => 'Attachments',
                                'de' => 'Anhänge',
                            ],
                        ],
                    ],
                ],
            ],
            'sulu_media.format_cache.media_proxy_path' => '/uploads/media/{slug}',
            'sulu_media.media_manager.media_download_path' => '/media/{id}/download/{slug}',
            'sulu_media.format_manager.response_headers' => [
                'Expires' => '+1 month',
                'Pragma' => 'public',
                'Cache-Control' => 'public',
            ],
            'sulu_media.format_manager.default_imagine_options' => [

            ],
            'sulu_media.format_manager.mime_types' => [
                0 => 'image/*',
                1 => 'video/*',
                2 => 'application/pdf',
            ],
            'sulu_media.format_cache.save_image' => true,
            'sulu_media.format_cache.segments' => 10,
            'sulu_media.ghost_script.path' => 'gs',
            'sulu_media.media.max_file_size' => '16MB',
            'sulu_media.media.blocked_file_types' => [
                0 => 'file/exe',
            ],
            'sulu_media.collection.type.default' => [
                'id' => 1,
            ],
            'sulu_media.collection.previews.format' => 'sulu-50x50',
            'sulu_media.media.types' => [
                0 => [
                    'type' => 'document',
                    'mimeTypes' => [
                        0 => '*',
                    ],
                ],
                1 => [
                    'type' => 'image',
                    'mimeTypes' => [
                        0 => 'image/*',
                    ],
                ],
                2 => [
                    'type' => 'video',
                    'mimeTypes' => [
                        0 => 'video/*',
                    ],
                ],
                3 => [
                    'type' => 'audio',
                    'mimeTypes' => [
                        0 => 'audio/*',
                    ],
                ],
            ],
            'sulu_media.search.default_image_format' => 'sulu-100x100',
            'sulu_media.disposition_type.default' => 'attachment',
            'sulu_media.disposition_type.mime_types_inline' => [

            ],
            'sulu_media.disposition_type.mime_types_attachment' => [

            ],
            'sulu_media.upload.max_filesize' => 256,
            'sulu_media.adobe_creative_key' => NULL,
            'sulu_media.admin.class' => 'Sulu\\Bundle\\MediaBundle\\Admin\\MediaAdmin',
            'sulu_media.media_manager.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\Manager\\MediaManager',
            'sulu_media.collection_repository.class' => 'Sulu\\Bundle\\MediaBundle\\Entity\\CollectionRepository',
            'sulu_media.file_validator.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\FileValidator\\FileValidator',
            'sulu_media.format_manager.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\FormatManager\\FormatManager',
            'sulu_media.format_cache_clearer.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\FormatCache\\FormatCacheClearer',
            'sulu_media.format_cache.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\FormatCache\\LocalFormatCache',
            'sulu_media.image.converter.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\ImageConverter\\ImagineImageConverter',
            'sulu_media.image.scaler.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\ImageConverter\\Scaler\\Scaler',
            'sulu_media.image.cropper.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\ImageConverter\\Cropper\\Cropper',
            'sulu_media.image.transformation_pool.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\ImageConverter\\TransformationPool',
            'sulu_media.image.transformation.crop.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\ImageConverter\\Transformation\\CropTransformation',
            'sulu_media.media_selection.class' => 'Sulu\\Bundle\\MediaBundle\\Content\\Types\\MediaSelectionContentType',
            'sulu_media.collection_manager.class' => 'Sulu\\Bundle\\MediaBundle\\Collection\\Manager\\CollectionManager',
            'sulu_media.type_manager.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\TypeManager\\TypeManager',
            'sulu_media.format_options_manager.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\FormatOptions\\FormatOptionsManager',
            'sulu_media.collection_entity' => 'SuluMediaBundle:Collection',
            'sulu_media.format_options_entity' => 'SuluMediaBundle:FormatOptions',
            'sulu_media.entity.file_version_meta' => 'SuluMediaBundle:FileVersionMeta',
            'sulu_media.twig_extension.disposition_type.class' => 'Sulu\\Bundle\\MediaBundle\\Twig\\DispositionTypeTwigExtension',
            'sulu_media.twig_extension.media.class' => 'Sulu\\Bundle\\MediaBundle\\Twig\\MediaTwigExtension',
            'tmp' => 'Sulu\\Bundle\\MediaBundle\\Twig\\MediaTwigExtension',
            'sulu_media.video_thumbnail_generator.class' => 'Sulu\\Bundle\\MediaBundle\\Media\\Video\\VideoThumbnailService',
            'sulu_media.search.subscriber.structure_media.class' => 'Sulu\\Bundle\\MediaBundle\\Search\\Subscriber\\StructureMediaSearchSubscriber',
            'sulu_media.search.subscriber.media.class' => 'Sulu\\Bundle\\MediaBundle\\Search\\Subscriber\\MediaSearchSubscriber',
            'sulu.model.media.class' => 'Sulu\\Bundle\\MediaBundle\\Entity\\Media',
            'sulu.repository.media.class' => 'Sulu\\Bundle\\MediaBundle\\Entity\\MediaRepository',
            'sulu_media.media.storage' => 'local',
            'sulu_media.media.storage.local.segments' => 10,
            'sulu.model.category.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\Category',
            'sulu.repository.category.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryRepository',
            'sulu.model.category_meta.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMeta',
            'sulu.repository.category_meta.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryMetaRepository',
            'sulu.model.category_translation.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslation',
            'sulu.repository.category_translation.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\CategoryTranslationRepository',
            'sulu.model.keyword.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\Keyword',
            'sulu.repository.keyword.class' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\KeywordRepository',
            'sulu_http_cache.cache.max_age' => 240,
            'sulu_http_cache.cache.shared_max_age' => 240,
            'sulu_snippet.content-type.default_enabled' => true,
            'sulu_snippet.twig.snippet.cache_lifetime' => 1,
            'sulu_snippet.repository.class' => 'Sulu\\Bundle\\SnippetBundle\\Snippet\\SnippetRepository',
            'sulu_snippet.controller.snippet.class' => 'Sulu\\Bundle\\SnippetBundle\\Controller\\SnippetController',
            'sulu_snippet.twig.snippet.class' => 'Sulu\\Bundle\\SnippetBundle\\Twig\\SnippetTwigExtension',
            'sulu_snippet.twig.snippet.memoized.class' => 'Sulu\\Bundle\\SnippetBundle\\Twig\\MemoizedSnippetTwigExtension',
            'sulu_snippet.form.snippet.class' => 'Sulu\\Bundle\\SnippetBundle\\Form\\SnippetType',
            'sulu_snippet.document.snippet_initializer.class' => 'Sulu\\Bundle\\SnippetBundle\\Document\\SnippetInitializer',
            'sulu_snippet.export.snippet.formats' => [
                '1.2.xliff' => 'SuluPageBundle:Export:Snippet/1.2.xliff.twig',
            ],
            'sulu_location.content.type.location.class' => 'Sulu\\Bundle\\LocationBundle\\Content\\Types\\LocationContentType',
            'sulu_location.map_manager.class' => 'Sulu\\Bundle\\LocationBundle\\Map\\MapManager',
            'sulu_location.guzzle.client.class' => 'GuzzleHttp\\Client',
            'sulu_location.geolocator.manager.class' => 'Sulu\\Bundle\\LocationBundle\\Geolocator\\GeolocatorManager',
            'sulu_location.geolocator.nominatim.class' => 'Sulu\\Bundle\\LocationBundle\\Geolocator\\Service\\NominatimGeolocator',
            'sulu_location.geolocator.google.class' => 'Sulu\\Bundle\\LocationBundle\\Geolocator\\Service\\GoogleGeolocator',
            'sulu_location.geolocator.name' => 'nominatim',
            'sulu_location.geolocator.service.nominatim.endpoint' => 'http://open.mapquestapi.com/nominatim/v1/search.php',
            'sulu_location.geolocator.service.google.api_key' => '',
            'sulu_document_manager.mapping' => [
                0 => [
                    'alias' => 'custom_url',
                    'class' => 'Sulu\\Component\\CustomUrl\\Document\\CustomUrlDocument',
                    'phpcr_type' => 'sulu:custom_url',
                    'mapping' => [
                        'published' => [
                            'property' => 'published',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                        'baseDomain' => [
                            'property' => 'baseDomain',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                        'domainParts' => [
                            'property' => 'domainParts',
                            'type' => 'json_array',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                        'canonical' => [
                            'property' => 'canonical',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                        'redirect' => [
                            'property' => 'redirect',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                        'targetLocale' => [
                            'property' => 'targetLocale',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                    ],
                ],
                1 => [
                    'alias' => 'custom_url_route',
                    'class' => 'Sulu\\Component\\CustomUrl\\Document\\RouteDocument',
                    'phpcr_type' => 'sulu:custom_url_route',
                    'mapping' => [
                        'locale' => [
                            'property' => 'locale',
                            'encoding' => 'content',
                            'mapped' => true,
                            'multiple' => false,
                            'default' => NULL,
                        ],
                    ],
                ],
                2 => [
                    'alias' => 'snippet',
                    'class' => 'Sulu\\Bundle\\SnippetBundle\\Document\\SnippetDocument',
                    'phpcr_type' => 'sulu:snippet',
                    'form_type' => 'Sulu\\Bundle\\SnippetBundle\\Form\\SnippetType',
                    'mapping' => [

                    ],
                ],
                3 => [
                    'alias' => 'page',
                    'class' => 'Sulu\\Bundle\\PageBundle\\Document\\PageDocument',
                    'phpcr_type' => 'sulu:page',
                    'form_type' => 'Sulu\\Bundle\\PageBundle\\Form\\Type\\PageDocumentType',
                    'set_default_author' => true,
                    'mapping' => [

                    ],
                ],
                4 => [
                    'alias' => 'home',
                    'class' => 'Sulu\\Bundle\\PageBundle\\Document\\HomeDocument',
                    'phpcr_type' => 'sulu:home',
                    'form_type' => 'Sulu\\Bundle\\PageBundle\\Form\\Type\\HomeDocumentType',
                    'set_default_author' => true,
                    'mapping' => [

                    ],
                ],
                5 => [
                    'alias' => 'route',
                    'class' => 'Sulu\\Bundle\\PageBundle\\Document\\RouteDocument',
                    'phpcr_type' => 'sulu:path',
                    'mapping' => [

                    ],
                ],
            ],
            'sulu_document_manager.namespace_mapping' => [
                'extension_localized' => 'i18n',
                'system' => 'sulu',
                'system_localized' => 'i18n',
                'content' => NULL,
                'content_localized' => 'i18n',
            ],
            'sulu_document_manager.versioning.enabled' => false,
            'sulu_document_manager.show_drafts' => true,
            'sulu_document_manager.segments' => [
                'custom_urls' => 'custom-urls',
                'custom_urls_items' => 'items',
                'custom_urls_routes' => 'routes',
                'base' => 'cmf',
                'content' => 'contents',
                'route' => 'routes',
                'snippet' => 'snippets',
            ],
            'sulu_custom_urls.uri_filter_regexp' => NULL,
            'sulu_route.mappings' => [

            ],
            'sulu_route.resource_key_mappings' => [

            ],
            'sulu_route.routing.uri_filter_regexp' => NULL,
            'sulu.model.route.class' => 'Sulu\\Bundle\\RouteBundle\\Entity\\Route',
            'sulu.repository.route.class' => 'Sulu\\Bundle\\RouteBundle\\Entity\\RouteRepository',
            'sulu_audience_targeting.enabled' => true,
            'sulu_audience_targeting.number_of_priorities' => 5,
            'sulu_audience_targeting.headers.target_group' => 'X-Sulu-Target-Group',
            'sulu_audience_targeting.headers.url' => 'X-Forwarded-URL',
            'sulu_audience_targeting.url' => '/_sulu_target_group',
            'sulu_audience_targeting.hit.url' => '/_sulu_target_group_hit',
            'sulu_audience_targeting.hit.headers.referrer' => 'X-Forwarded-Referrer',
            'sulu_audience_targeting.hit.headers.uuid' => 'X-Forwarded-UUID',
            'sulu_audience_targeting.cookies.target_group' => '_svtg',
            'sulu_audience_targeting.cookies.session' => '_svs',
            'sulu.model.target_group.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroup',
            'sulu.repository.target_group.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRepository',
            'sulu.model.target_group_condition.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupCondition',
            'sulu.repository.target_group_condition.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupConditionRepository',
            'sulu.model.target_group_rule.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRule',
            'sulu.repository.target_group_rule.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupRuleRepository',
            'sulu.model.target_group_webspace.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupWebspace',
            'sulu.repository.target_group_webspace.class' => 'Sulu\\Bundle\\AudienceTargetingBundle\\Entity\\TargetGroupWebspaceRepository',
            'hateoas.link_factory.class' => 'Hateoas\\Factory\\LinkFactory',
            'hateoas.links_factory.class' => 'Hateoas\\Factory\\LinksFactory',
            'hateoas.embeds_factory.class' => 'Hateoas\\Factory\\EmbeddedsFactory',
            'hateoas.expression.evaluator.class' => 'Bazinga\\Bundle\\HateoasBundle\\Hateoas\\Expression\\LazyFunctionExpressionEvaluator',
            'bazinga_hateoas.expression_language.class' => 'Bazinga\\Bundle\\HateoasBundle\\ExpressionLanguage\\ExpressionLanguage',
            'hateoas.expression.link.class' => 'Hateoas\\Expression\\LinkExpressionFunction',
            'hateoas.serializer.xml.class' => 'Hateoas\\Serializer\\XmlSerializer',
            'hateoas.serializer.json_hal.class' => 'Hateoas\\Serializer\\JsonHalSerializer',
            'hateoas.serializer.exclusion_manager.class' => 'Hateoas\\Serializer\\ExclusionManager',
            'hateoas.event_subscriber.xml.class' => 'Hateoas\\Serializer\\EventSubscriber\\XmlEventSubscriber',
            'hateoas.event_subscriber.json.class' => 'Hateoas\\Serializer\\EventSubscriber\\JsonEventSubscriber',
            'hateoas.inline_deferrer.embeds.class' => 'Hateoas\\Serializer\\Metadata\\InlineDeferrer',
            'hateoas.inline_deferrer.links.class' => 'Hateoas\\Serializer\\Metadata\\InlineDeferrer',
            'hateoas.configuration.provider.resolver.chain.class' => 'Hateoas\\Configuration\\Provider\\Resolver\\ChainResolver',
            'hateoas.configuration.provider.resolver.method.class' => 'Hateoas\\Configuration\\Provider\\Resolver\\MethodResolver',
            'hateoas.configuration.provider.resolver.static_method.class' => 'Hateoas\\Configuration\\Provider\\Resolver\\StaticMethodResolver',
            'hateoas.configuration.provider.resolver.symfony_container.class' => 'Hateoas\\Configuration\\Provider\\Resolver\\SymfonyContainerResolver',
            'hateoas.configuration.relation_provider.class' => 'Hateoas\\Configuration\\Provider\\RelationProvider',
            'hateoas.configuration.relations_repository.class' => 'Hateoas\\Configuration\\RelationsRepository',
            'hateoas.configuration.metadata.yaml_driver.class' => 'Hateoas\\Configuration\\Metadata\\Driver\\YamlDriver',
            'hateoas.configuration.metadata.xml_driver.class' => 'Hateoas\\Configuration\\Metadata\\Driver\\XmlDriver',
            'hateoas.configuration.metadata.annotation_driver.class' => 'Hateoas\\Configuration\\Metadata\\Driver\\AnnotationDriver',
            'hateoas.configuration.metadata.extension_driver.class' => 'Hateoas\\Configuration\\Metadata\\Driver\\ExtensionDriver',
            'hateoas.generator.registry.class' => 'Hateoas\\UrlGenerator\\UrlGeneratorRegistry',
            'hateoas.generator.symfony.class' => 'Hateoas\\UrlGenerator\\SymfonyUrlGenerator',
            'hateoas.helper.link.class' => 'Hateoas\\Helper\\LinkHelper',
            'hateoas.twig.link.class' => 'Hateoas\\Twig\\Extension\\LinkExtension',
            'security.authentication.trust_resolver.anonymous_class' => NULL,
            'security.authentication.trust_resolver.rememberme_class' => NULL,
            'security.role_hierarchy.roles' => [

            ],
            'security.access.denied_url' => NULL,
            'security.authentication.manager.erase_credentials' => true,
            'security.authentication.session_strategy.strategy' => 'migrate',
            'security.access.always_authenticate_before_granting' => false,
            'security.authentication.hide_user_not_found' => true,
            'sulu_admin.name' => 'SULU 2.0',
            'sulu_admin.email' => 'installation.email@sulu.test',
            'sulu_admin.user_data_service' => 'sulu_security.user_manager',
            'sulu_admin.resources' => [
                'localizations' => [
                    'routes' => [
                        'list' => 'sulu_core.get_localizations',
                    ],
                ],
                'teasers' => [
                    'routes' => [
                        'list' => 'sulu_page.get_teasers',
                    ],
                ],
                'target_groups' => [
                    'routes' => [
                        'list' => 'sulu_audience_targeting.get_target-groups',
                        'detail' => 'sulu_audience_targeting.get_target-group',
                    ],
                ],
                'routes' => [
                    'routes' => [
                        'list' => 'sulu_routes.get_routes',
                    ],
                ],
                'custom_urls' => [
                    'routes' => [
                        'list' => 'sulu_custom_url.cget_webspace_custom-urls',
                        'detail' => 'sulu_custom_url.get_webspace_custom-urls',
                    ],
                ],
                'custom_url_routes' => [
                    'routes' => [
                        'list' => 'sulu_custom_url.get_webspace_custom-urls_routes',
                    ],
                ],
                'snippets' => [
                    'routes' => [
                        'list' => 'sulu_snippet.get_snippets',
                        'detail' => 'sulu_snippet.get_snippet',
                    ],
                ],
                'snippet_areas' => [
                    'routes' => [
                        'list' => 'sulu_snippet.get_snippet-areas',
                        'detail' => 'sulu_snippet.put_snippet-area',
                    ],
                ],
                'categories' => [
                    'routes' => [
                        'list' => 'sulu_category.get_categories',
                        'detail' => 'sulu_category.get_category',
                    ],
                ],
                'category_keywords' => [
                    'routes' => [
                        'list' => 'sulu_category.get_category_keywords',
                        'detail' => 'sulu_category.get_category_keyword',
                    ],
                ],
                'media' => [
                    'routes' => [
                        'list' => 'sulu_media.cget_media',
                        'detail' => 'sulu_media.get_media',
                    ],
                    'security_context' => 'sulu.media.collections',
                    'security_class' => 'Sulu\\Bundle\\MediaBundle\\Entity\\Collection',
                ],
                'media_formats' => [
                    'routes' => [
                        'list' => 'sulu_media.get_media_formats',
                        'detail' => 'sulu_media.put_media_format',
                    ],
                ],
                'media_versions' => [
                    'routes' => [
                        'detail' => 'sulu_media.delete_media_version',
                    ],
                ],
                'collections' => [
                    'routes' => [
                        'list' => 'sulu_media.get_collections',
                        'detail' => 'sulu_media.get_collection',
                    ],
                ],
                'formats' => [
                    'routes' => [
                        'list' => 'sulu_media.get_formats',
                        'detail' => 'sulu_media.get_format',
                    ],
                ],
                'tags' => [
                    'routes' => [
                        'list' => 'sulu_tag.get_tags',
                        'detail' => 'sulu_tag.get_tag',
                    ],
                ],
                'analytics' => [
                    'routes' => [
                        'list' => 'sulu_website.cget_webspace_analytics',
                        'detail' => 'sulu_website.get_webspace_analytics',
                    ],
                ],
                'permissions' => [
                    'routes' => [
                        'detail' => 'sulu_security.get_permissions',
                    ],
                ],
                'roles' => [
                    'routes' => [
                        'list' => 'sulu_security.get_roles',
                        'detail' => 'sulu_security.get_role',
                    ],
                ],
                'users' => [
                    'routes' => [
                        'list' => 'sulu_security.get_users',
                        'detail' => 'sulu_security.get_user',
                    ],
                ],
                'profile' => [
                    'routes' => [
                        'detail' => 'sulu_security.get_profile',
                    ],
                ],
                'contacts' => [
                    'routes' => [
                        'list' => 'sulu_contact.get_contacts',
                        'detail' => 'sulu_contact.get_contact',
                    ],
                ],
                'contact_titles' => [
                    'routes' => [
                        'list' => 'sulu_contact.get_contact-titles',
                    ],
                ],
                'contact_positions' => [
                    'routes' => [
                        'list' => 'sulu_contact.get_contact-positions',
                    ],
                ],
                'contact_media' => [
                    'routes' => [
                        'list' => 'sulu_contact.cget_contact_medias',
                        'detail' => 'sulu_contact.delete_contact_medias',
                    ],
                ],
                'accounts' => [
                    'routes' => [
                        'list' => 'sulu_contact.get_accounts',
                        'detail' => 'sulu_contact.get_account',
                    ],
                ],
                'account_media' => [
                    'routes' => [
                        'list' => 'sulu_contact.cget_account_medias',
                        'detail' => 'sulu_contact.delete_account_medias',
                    ],
                ],
                'account_contacts' => [
                    'routes' => [
                        'list' => 'sulu_contact.get_account_addresses',
                        'detail' => 'sulu_contact.delete_account_contacts',
                    ],
                ],
                'page_resourcelocators' => [
                    'routes' => [
                        'list' => 'sulu_page.get_page_resourcelocators',
                    ],
                ],
                'pages' => [
                    'routes' => [
                        'list' => 'sulu_page.get_pages',
                        'detail' => 'sulu_page.get_page',
                    ],
                    'security_context' => 'sulu.webspaces.#webspace#',
                    'security_class' => 'Sulu\\Component\\Content\\Document\\Behavior\\SecurityBehavior',
                ],
                'page_versions' => [
                    'routes' => [
                        'list' => 'sulu_page.get_page_versions',
                        'detail' => 'sulu_page.post_page_version_trigger',
                    ],
                ],
                'webspaces' => [
                    'routes' => [
                        'list' => 'sulu_page.get_webspaces',
                        'detail' => 'sulu_page.get_webspace',
                    ],
                ],
                'search' => [
                    'routes' => [
                        'list' => 'sulu_search_search',
                    ],
                ],
                'search_indexes' => [
                    'routes' => [
                        'list' => 'sulu_search_indexes',
                    ],
                ],
                'forms' => [
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
            'sulu_admin.forms.directories' => [
                0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/DependencyInjection/../Resources/config/forms',
                1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/DependencyInjection/../Resources/config/forms',
                2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle/DependencyInjection/../Resources/config/forms',
                3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/DependencyInjection/../Resources/config/forms',
                4 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/DependencyInjection/../Resources/config/forms',
                5 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle/DependencyInjection/../Resources/config/forms',
                6 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/DependencyInjection/../Resources/config/forms',
                7 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/DependencyInjection/../Resources/config/forms',
                8 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle/DependencyInjection/../Resources/config/forms',
                9 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/DependencyInjection/../Resources/config/forms',
            ],
            'sulu_admin.lists.directories' => [
                0 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/AudienceTargetingBundle/DependencyInjection/../Resources/config/lists',
                1 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CustomUrlBundle/DependencyInjection/../Resources/config/lists',
                2 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SnippetBundle/DependencyInjection/../Resources/config/lists',
                3 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/CategoryBundle/DependencyInjection/../Resources/config/lists',
                4 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/MediaBundle/DependencyInjection/../Resources/config/lists',
                5 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/TagBundle/DependencyInjection/../Resources/config/lists',
                6 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/WebsiteBundle/DependencyInjection/../Resources/config/lists',
                7 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/SecurityBundle/DependencyInjection/../Resources/config/lists',
                8 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/ContactBundle/DependencyInjection/../Resources/config/lists',
                9 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/vendor/sulu/sulu/src/Sulu/Bundle/PageBundle/DependencyInjection/../Resources/config/lists',
                10 => '/Users/danielmathis/Development/sulu-website/sulu-docker/project/vendor/sulu/sulu-form-bundle/DependencyInjection/../Resources/config/lists',
            ],
            'sulu_admin.admin_controller.class' => 'Sulu\\Bundle\\AdminBundle\\Controller\\AdminController',
            'sulu_admin.admin_pool.class' => 'Sulu\\Bundle\\AdminBundle\\Admin\\AdminPool',
            'sulu_collaboration.interval' => 300000,
            'sulu_collaboration.threshold' => 10000,
            'sulu_preview.mode' => 'auto',
            'sulu_preview.delay' => 500,
            'sulu_preview.events.pre-render' => 'sulu.preview.pre-render',
            'data_collector.templates' => [
                'data_collector.request' => [
                    0 => 'request',
                    1 => '@WebProfiler/Collector/request.html.twig',
                ],
                'data_collector.time' => [
                    0 => 'time',
                    1 => '@WebProfiler/Collector/time.html.twig',
                ],
                'data_collector.memory' => [
                    0 => 'memory',
                    1 => '@WebProfiler/Collector/memory.html.twig',
                ],
                'data_collector.validator' => [
                    0 => 'validator',
                    1 => '@WebProfiler/Collector/validator.html.twig',
                ],
                'data_collector.ajax' => [
                    0 => 'ajax',
                    1 => '@WebProfiler/Collector/ajax.html.twig',
                ],
                'data_collector.form' => [
                    0 => 'form',
                    1 => '@WebProfiler/Collector/form.html.twig',
                ],
                'data_collector.exception' => [
                    0 => 'exception',
                    1 => '@WebProfiler/Collector/exception.html.twig',
                ],
                'data_collector.logger' => [
                    0 => 'logger',
                    1 => '@WebProfiler/Collector/logger.html.twig',
                ],
                'data_collector.events' => [
                    0 => 'events',
                    1 => '@WebProfiler/Collector/events.html.twig',
                ],
                'data_collector.router' => [
                    0 => 'router',
                    1 => '@WebProfiler/Collector/router.html.twig',
                ],
                'data_collector.cache' => [
                    0 => 'cache',
                    1 => '@WebProfiler/Collector/cache.html.twig',
                ],
                'data_collector.translation' => [
                    0 => 'translation',
                    1 => '@WebProfiler/Collector/translation.html.twig',
                ],
                'data_collector.security' => [
                    0 => 'security',
                    1 => '@Security/Collector/security.html.twig',
                ],
                'data_collector.twig' => [
                    0 => 'twig',
                    1 => '@WebProfiler/Collector/twig.html.twig',
                ],
                'data_collector.doctrine' => [
                    0 => 'db',
                    1 => '@Doctrine/Collector/db.html.twig',
                ],
                'doctrine_phpcr.data_collector' => [
                    0 => 'phpcr',
                    1 => '@DoctrinePHPCR/Collector/phpcr',
                ],
                'swiftmailer.data_collector' => [
                    0 => 'swiftmailer',
                    1 => '@Swiftmailer/Collector/swiftmailer.html.twig',
                ],
                'data_collector.config' => [
                    0 => 'config',
                    1 => '@WebProfiler/Collector/config.html.twig',
                ],
            ],
            'doctrine_phpcr.migrate.migrators' => [

            ],
            'sulu.version' => '_._._',
            'app.version' => NULL,
            'sulu_media.image.formats' => [
                'sulu-400x400' => [
                    'key' => 'sulu-400x400',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Contact avatar (Sulu)',
                            'de' => 'Kontaktavatar (Sulu)',
                            'fr' => 'Avatar du contact (Sulu)',
                            'nl' => 'Contact avatar (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 400,
                        'y' => 400,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-260x' => [
                    'key' => 'sulu-260x',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Masonry preview (Sulu)',
                            'de' => 'Masonry Vorschau (Sulu)',
                            'fr' => 'Prévisualisation maçonnerie (Sulu)',
                            'nl' => 'Masonry voorbeeld (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 260,
                        'y' => NULL,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-170x170' => [
                    'key' => 'sulu-170x170',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Search (Sulu)',
                            'de' => 'Suche (Sulu)',
                            'fr' => 'Recherche (Sulu)',
                            'nl' => 'Zoeken (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 170,
                        'y' => 170,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-100x100-inset' => [
                    'key' => 'sulu-100x100-inset',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Organization card (Sulu)',
                            'de' => 'Organisationskarte (Sulu)',
                            'fr' => 'Carte d\'organisation (Sulu)',
                            'nl' => 'Organisatie kaart (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 100,
                        'y' => 100,
                        'mode' => 1,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-50x50' => [
                    'key' => 'sulu-50x50',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Small thumbnail (Sulu)',
                            'de' => 'Kleines Thumbnail (Sulu)',
                            'fr' => 'Image miniature (Sulu)',
                            'nl' => 'Kleine thumbnail (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 50,
                        'y' => 50,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-25x25' => [
                    'key' => 'sulu-25x25',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Micro thumbnail',
                            'de' => 'Mikro Thumbnail',
                            'fr' => 'Image micro',
                            'nl' => 'Micro thumbnail',
                        ],
                    ],
                    'scale' => [
                        'x' => 25,
                        'y' => 25,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-40x40' => [
                    'key' => 'sulu-40x40',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Small thumbnail (Sulu)',
                            'de' => 'Kleines Thumbnail (Sulu)',
                            'fr' => 'Image miniature (Sulu)',
                            'nl' => 'Kleine thumbnail (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 40,
                        'y' => 40,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-240x' => [
                    'key' => 'sulu-240x',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Masonry preview (Sulu)',
                            'de' => 'Masonry Vorschau (Sulu)',
                            'fr' => 'Prévisualisation maçonnerie (Sulu)',
                            'nl' => 'Masonry voorbeeld (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 240,
                        'y' => NULL,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-400x400-inset' => [
                    'key' => 'sulu-400x400-inset',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Organization logo (Sulu)',
                            'de' => 'Organisationslogo (Sulu)',
                            'fr' => 'Logo d\'organisation (Sulu)',
                            'nl' => 'Organisatie logo (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 400,
                        'y' => 400,
                        'mode' => 1,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
                'sulu-100x100' => [
                    'key' => 'sulu-100x100',
                    'internal' => true,
                    'meta' => [
                        'title' => [
                            'en' => 'Contact card (Sulu)',
                            'de' => 'Personenkarte (Sulu)',
                            'fr' => 'Carte personnelle (Sulu)',
                            'nl' => 'Contact kaart (Sulu)',
                        ],
                    ],
                    'scale' => [
                        'x' => 100,
                        'y' => 100,
                        'mode' => 2,
                        'retina' => false,
                        'forceRatio' => true,
                    ],
                    'transformations' => [

                    ],
                    'options' => [

                    ],
                ],
            ],
            'sulu_category.entity.category' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\Category',
            'sulu_category.entity.keyword' => 'Sulu\\Bundle\\CategoryBundle\\Entity\\Keyword',
            'sulu_snippet.areas' => [

            ],
            'console.command.ids' => [
                0 => 'console.command.public_alias.doctrine_cache.contains_command',
                1 => 'console.command.public_alias.doctrine_cache.delete_command',
                2 => 'console.command.public_alias.doctrine_cache.flush_command',
                3 => 'console.command.public_alias.doctrine_cache.stats_command',
                4 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\LoadFixtureCommand',
                5 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceQueryCommand',
                6 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\MigratorMigrateCommand',
                7 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeDumpCommand',
                8 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeMoveCommand',
                9 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeRemoveCommand',
                10 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodesUpdateCommand',
                11 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeTouchCommand',
                12 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeTypeListCommand',
                13 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\NodeTypeRegisterCommand',
                14 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\PhpcrShellCommand',
                15 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\RepositoryInitCommand',
                16 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceCreateCommand',
                17 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceDeleteCommand',
                18 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceExportCommand',
                19 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceImportCommand',
                20 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspaceListCommand',
                21 => 'console.command.public_alias.Doctrine\\Bundle\\PHPCRBundle\\Command\\WorkspacePurgeCommand',
                22 => 'phpcr_migrations.command.status',
                23 => 'phpcr_migrations.command.migrate',
                24 => 'phpcr_migrations.command.initialize',
                25 => 'console.command.public_alias.sulu_page.command.workspace_import',
            ],
        ];
    }
}
