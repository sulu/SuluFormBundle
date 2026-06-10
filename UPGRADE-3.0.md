# Upgrade

## 3.0.0

### Removed static forms

The deprecated static forms feature has been removed. It is fully superseded by dynamic (admin-built) forms. The
following has been removed:

- `Sulu\Bundle\FormBundle\Form\Type\AbstractType` and `Sulu\Bundle\FormBundle\Form\Type\TypeInterface`
- `FormConfigurationFactory::buildByType()`
- the `sulu_form.static_forms` configuration option
- the `Sulu\Bundle\FormBundle\Provider\ListProviderInterface` / `ListProviderRegistry` extension point, including the
  `sulu_form.list_provider` service tag, the `Sulu\Bundle\FormBundle\Controller\ListController` and its
  `/form/lists` and `/form/lists/fields` routes

If you relied on static forms, migrate to dynamic forms.

### Removed deprecated code

The following long-deprecated APIs have been removed:

- **`Sulu\Bundle\FormBundle\Event\DynFormSavedEvent`** (event name `sulu.dynform.saved`) — listen to
  `Sulu\Bundle\FormBundle\Event\FormSavePostEvent` (event name `sulu_form.handler.saved`) instead. The new event is
  dispatched right after the submission is persisted (before the mails are sent) and exposes the form and the `Dynamic`
  entity via `getData()` / `getConfiguration()` instead of a pre-serialized array.
- **`Sulu\Bundle\FormBundle\Provider\DynamicProvider`** — removed, use the dynamic list configuration instead.
- **`HandlerInterface::EVENT_FORM_SAVE` / `HandlerInterface::EVENT_FORM_SAVED`** constants — use
  `FormSavePreEvent::NAME` / `FormSavePostEvent::NAME` instead.
- **Swiftmailer support** (`Mail\Helper`, the `swift_mailer` mail helper) — removed, the bundle now requires
  `symfony/mailer`. Remove any `sulu_form.mail.helper` setting from your configuration; the option has been removed
  entirely. `MailerHelper` is now wired directly and is always used.
- **`Mail\NullHelper`** — removed, use the `null://` transport of `symfony/mailer` instead.
- **`@SuluForm/themes/dynamic.html.twig`** form theme — use `@SuluForm/themes/basic.html.twig` instead.
- The deprecated top-level **`sulu_form.media_collection_strategy`** config option — use
  `sulu_form.media.collection_strategy` instead.

The CSRF token in `@SuluForm/themes/basic.html.twig` is now always rendered directly; the deprecated ESI-based token
loading (which failed since Symfony 5.4) has been removed.

Attachment fields (`input[type=file]`) no longer render a `max` attribute, as it is not supported by the browser. Use
the `data-max` attribute instead if you read it on the front-end; the maximum file count is still enforced server-side.

### Replace config with auto complete

The Mailchimp and Brevo list/template pickers now use an autocomplete/list-overlay
selection backed by API controllers instead of the `getValues()` expression services.

Renamed service:
"sulu_form.dynamic.mailchimp_list_select" -> "sulu_form.mailchimp_list_select_controller"

The Brevo selection controllers ("sulu_form.brevo_list_select_controller" and
"sulu_form.brevo_mail_template_select_controller") are new and replace the removed
Sendinblue services listed below.

### Replace sendinblue with getbrevo

The Sendinblue Form Fields were replaced with the Brevo Form Field.
You can find all Brevo configuration options [here](Resources/doc/brevo.md).

### Config changes
```diff
 # config/packages/sulu_form.yaml
 sulu_form:
-    sendinblue_api_key: <your key>
+    brevo_api_key: <your key>
```

### Composer dependency changes
```
composer remove sendinblue/api-v3-sdk
composer require getbrevo/brevo-php
```

### Routing changes

If you want to use mail chimp also include those routes in your config:

```yaml
sulu_form_api_mailchimp:
    resource: "@SuluFormBundle/Resources/config/routing_api_mailchimp.yaml"
    prefix: /admin/api
```

If you want to use brevo also include those routes in your config:

```yaml
sulu_form_api_brevo:
    resource: "@SuluFormBundle/Resources/config/routing_api_brevo.yaml"
    prefix: /admin/api
```

### Container changes

Removed parameters:
- sulu_form.sendinblue_api_key

Removed services:
- sulu_form.subscriber.sendinblue_list_subscriber
- sulu_form.dynamic.type_sendinblue
- sulu_form.dynamic.sendinblue_list_select
- sulu_form.dynamic.sendinblue_mail_template_select

#### Data Migration

Use the following database query to update all existing forms.

```sql
UPDATE `fo_form_fields` SET `type` = 'brevo' WHERE `type` = 'sendinblue';
```

### Content Type replaced with PropertyResolver and ResourceLoader

The `SingleFormSelection` content type has been replaced with the new Sulu 3.0 content resolution architecture using `PropertyResolverInterface` and `ResourceLoaderInterface`.

#### Template changes required

The form is no longer built during content resolution. Instead, use the new `sulu_form_build` Twig function to build the form at render time:

```diff
{% if content.form %}
    {% if app.request.get('send') != 'true' %}
-        {% form_theme content.form '@SuluForm/themes/basic.html.twig' %}
-        {{ form(content.form) }}
+        {% set form_view = sulu_form_build(content.form, 'page', resource.id) %}
+        {% form_theme form_view '@SuluForm/themes/basic.html.twig' %}
+        {{ form(form_view) }}
    {% else %}
        {{ view.form.entity.successText|raw }}
    {% endif %}
{% endif %}
```

The resolved content now contains:
- `entity` - the Form entity
- `data` - serialized form data (previously in view)

#### New Twig function

A new Twig function `sulu_form_build` was added:

```php
sulu_form_build(array $formContent, string $type, string $typeId, ?string $locale = null, string $name = 'form'): ?FormView
```

The existing `sulu_form_get_by_id` function still works if you prefer to build forms by ID directly.

### Removed TaggedServiceCollectorCompilerPass

The `TaggedServiceCollectorCompilerPass` has been removed in Sulu 3.0. Services now use Symfony's native `tagged_iterator` for collecting tagged services.

If you extended `FormFieldTypePool` or `TitleProviderPool`, update your constructor to accept `iterable` instead of arrays:

**before:**

```php
public function __construct(array $types)
```

**after:**

```php
public function __construct(iterable $types)
```

### Metadata loaders refactored

The `PropertiesXmlLoader` and `DynamicFormMetadataLoader` have been refactored to use the new Sulu 3.0 metadata API:

- `PropertiesXmlLoader` now extends `Sulu\Bundle\AdminBundle\Metadata\FormMetadata\Loader\AbstractLoader`
- `DynamicFormMetadataLoader` no longer uses `FormMetadataMapper` (removed in Sulu 3.0)
- Metadata cache is now locale-independent

### StructureTitleProvider refactored

The `StructureTitleProvider` has been refactored to use Sulu 3.0's new content architecture:

- Uses a new name `DimensionContentTitleProvider`
- Uses `DimensionContentInterface` instead of removed `StructureInterface`
- Gets `object` from request attributes instead of `structure`
- Uses `getResource()->getId()` instead of `getUuid()`
- Gets title from `getTemplateData()['title']`

If you extended this class, update your code accordingly. This class is now final, to override it decorate the 
`sulu_form.title_provider.page` service.

### Deprecated Symfony methods removed

The following deprecated Symfony method calls have been replaced:

- `isMasterRequest()` → `isMainRequest()` (in `RequestListener`, `ProtectedMediaSubscriber`)
- `getMasterRequest()` → `getMainRequest()` (in `StructureTitleProvider`)

### FormWebsiteController removed

The deprecated `FormWebsiteController` has been removed as it extended the removed `Sulu\Bundle\WebsiteBundle\Controller\DefaultController`.

### Routing format changed

The routing file has been renamed from `routing_api.yml` to `routing_api.yaml` and uses explicit Symfony route 
definitions instead of FOS REST routing (removed in Sulu 3.0).

### Service configuration changes

The following services have been removed or renamed:

- `sulu_form.content_type.single_form_selection` - removed (replaced by PropertyResolver)
- `sulu_form.reference_store.form` - removed (references now handled by PropertyResolver)

New services added:

- `sulu_form.single_form_selection_property_resolver` - resolves form content
- `sulu_form.form_resource_loader` - loads form entities by ID
