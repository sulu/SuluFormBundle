# Upgrade

## 3.0.0

### Replace sendinblue with getbrevo

The Sendinblue Form Field is now deprecated; please use the Brevo Form Field instead.
Both fields offer the same functionality but rely on different SDKs.
Therefore, replace `sendinblue/api-v3-sdk` with `getbrevo/brevo-php` in your dependencies.
Additionally, update the configuration variable from `sendinblue_api_key` to `brevo_api_key`
in `config/packages/sulu_form.yaml`.

You can find all Brevo configuration options [here](Resources/doc/brevo.md).

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
>>>>>>> 696bb05 (Upgrade instructions):UPGRADE.md
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
