# Upgrade

## 2.5.0

### Deprecate Swiftmailer

To support Symfony 6 and Sulu 2.5 the usage of Swiftmailer has been deprecated.
Remove the `Swiftmailer` from your project to automatically use the `symfony/mailer` instead.

## 2.4.0

### CSRF Protection disabled

By default, the csrf protection is disabled now because of caching mechanism it is required that
csrf token is loaded over ajax. Since Symfony 5.4, it is not possible todo this over ESI, as the
session cookie can not be created by a Symfony subrequest, which was already the behaviour before when
using a caching server like varnish.

If you want to enable csrf protection again it is required to configure:

```yaml
sulu_form:
    csrf_protection: true
```

And important implement ajax loading of the csrf protection.
See the [CSRF Ajax documentation](Resources/doc/csrf.md) as an example.

As an alternative protection there is [HoneyPotField](Resources/doc/dynamic.md#add-honeypot-field-for-spam-protection)
or [Recaptcha](Resources/doc/recaptcha.md). Which both do not require a session.

## 2.1.1

### Builder constructor changed

The `Builder` service of the SuluFormBundle requires now the `security.csrf.token_manager` service to be injected
this was required to solve caching problems on pages using forms.

## 2.1.0

### Database

#### Add deactivateAttachmentSave field to form

To allow to deactivate that attachment is saved, the following needed to be adjusted in the database:

```sql
ALTER TABLE fo_form_translations ADD deactivateAttachmentSave TINYINT(1) DEFAULT '0' NOT NULL;
```

## 2.0.0

### Database

Dynamic Entity has been reduced to some basic fields. All previous data fields are merged into the `data` column.

#### Data Migration

Migrate the data fields into the json `data`. 

```sql
UPDATE
  fo_dynamics as dyn
SET
  dyn.data = (
    CONCAT(
      '{',
      CONCAT_WS(
        ',',
        IF(
          STRCMP('', SUBSTRING(dyn.data, 2, LENGTH(dyn.data) -2)) = 0,
          NULL,
          SUBSTRING(dyn.data, 2, CHAR_LENGTH(dyn.data) -2)
        ),
        IF(
          dyn.salutation is not NULL,
          CONCAT(
            '\"salutation\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.salutation, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.title is not NULL,
          CONCAT(
            '\"title\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.title, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.firstName is not NULL,
          CONCAT(
            '\"firstName\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.firstName, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.lastName is not NULL,
          CONCAT(
            '\"lastName\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.lastName, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.email is not NULL,
          CONCAT(
            '\"email\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.email, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.phone is not NULL,
          CONCAT(
            '\"phone\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.phone, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.fax is not NULL,
          CONCAT(
            '\"fax\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.fax, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.street is not NULL,
          CONCAT(
            '\"street\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.street, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.zip is not NULL,
          CONCAT(
            '\"zip\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.zip, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.city is not NULL,
          CONCAT(
            '\"city\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.city, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.state is not NULL,
          CONCAT(
            '\"state\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.state, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.country is not NULL,
          CONCAT(
            '\"country\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.country, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.function is not NULL,
          CONCAT(
            '\"function\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.function, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.company is not NULL,
          CONCAT(
            '\"company\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.company, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.text is not NULL,
          CONCAT(
            '\"text\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.text, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.textarea is not NULL,
          CONCAT(
            '\"textarea\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.textarea, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.date is not NULL,
          CONCAT(
            '\"date\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.date, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.attachment is not NULL,
          CONCAT(
            '\"attachment\":',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.attachment, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f')
          ),
          NULL
        ),
        IF(
          dyn.checkbox is not NULL,
          CONCAT(
            '\"checkbox\":',
            IF(
                STRCMP('',dyn.checkbox) = 0,
                '\"\"',
                dyn.checkbox
              )
          ),
          NULL
        ),
        IF(
          dyn.checkboxMultiple is not NULL,
          CONCAT(
            '\"checkboxMultiple\":',
            dyn.checkboxMultiple
          ),
          NULL
        ),
        IF(
          dyn.dropdown is not NULL,
          CONCAT(
            '\"dropdown\":\"',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.dropdown, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '\"'
          ),
          NULL
        ),
        IF(
          dyn.dropdownMultiple is not NULL,
          CONCAT(
            '\"dropdownMultiple\":',
            dyn.dropdownMultiple
          ),
          NULL
        ),
        IF(
          dyn.radioButtons is not NULL,
          CONCAT(
            '\"radioButtons\":',
            replace(replace(replace(replace(replace(replace(replace(replace(dyn.radioButtons, '\\', '\\\\'), '/', '\\/'), '"', '\\\"'), CHAR(10), '\\n'), CHAR(9), '\\t'), CHAR(8), '\\b'), CHAR(13), '\\r'), CHAR(12), '\\f'),
            '[]'
          ),
          NULL
        )
      ),
      '}'
    )
  );
```

Delete the redundant columns.

```sql
ALTER TABLE fo_dynamics 
  DROP COLUMN salutation,
  DROP COLUMN title,
  DROP COLUMN firstName,
  DROP COLUMN lastName,
  DROP COLUMN email,
  DROP COLUMN phone,
  DROP COLUMN fax,
  DROP COLUMN street,
  DROP COLUMN zip,
  DROP COLUMN city,
  DROP COLUMN state,
  DROP COLUMN country,
  DROP COLUMN function,
  DROP COLUMN company,
  DROP COLUMN text,
  DROP COLUMN textarea,
  DROP COLUMN date,
  DROP COLUMN attachment,
  DROP COLUMN checkbox,
  DROP COLUMN checkboxMultiple,
  DROP COLUMN dropdown,
  DROP COLUMN dropdownMultiple,
  DROP COLUMN radioButtons;
```

### Unnecessary routing files removed

The `routing.yml` file was removed as it the routes are not needed for rendering dynamic forms.
If you did build on top of this route something register the needed routes in your project:

```yaml
# config/routes/sulu_form.yaml

sulu_form.only:
    path: /form/only/{key}
    defaults:
        _controller: Sulu\Bundle\FormBundle\Controller\FormWebsiteController::onlyAction

sulu_form.token:
    path: /form/token
    defaults:
        _controller: Sulu\Bundle\FormBundle\Controller\FormTokenController::tokenAction
        _requestAnalyzer: false
```

### Dynamic magic getter and setter removed

The magic setter of the `Dynamic?  entity was removed:

**before**:

```php
$dynamic->__set($key, $value);
$dynamic->__get($key);
$dynamic->{$key};
```

**after**:

```php
$dynamic->setField($key, $value);
$dynamic->getField($key);
```

### Token Controller moved

The tokenAction was moved into an own Controller:

**before**:

```twig
'Sulu\\Bundle\\FormBundle\\Controller\\FormWebsiteController::tokenAction'
```

**after**:

```twig
'Sulu\\Bundle\\FormBundle\\Controller\\FormTokenController::tokenAction'
```

### Form List Tab

The list tab configuration need the parent route key (can be found in the related admin classes).

**before**:

```yaml
sulu_form:
    dynamic_lists:
        content:
            form:
                template: form
                property: form
                type: page
```

**after**:

```yaml
sulu_form:
    dynamic_lists:
        sulu_page.page_edit_form:
            form:
                template: form
                property: form
                type: page
```

### TitleProvider interface

The argument `$locale = null` was added to the method `TitleProvider::getTitle`.
It contains the locale which was used to create the form. 

### UTF8MB4 compatibility

The field `keyName` need to be short to 128 length for UTF8MB4 compatibility:

```sql
ALTER TABLE fo_form_fields CHANGE keyName keyName VARCHAR(128) NOT NULL;
``` 

### Content type changed

The content type for form selection has been changed from `form_select` to `single_form_selection` also the param `type` has changed to `resourceKey`:

**before**:

```xml
<property name="form" type="form_select">
    <params>
        <param name="type" value="page" />
    </params>
</property>
```

**after**:

```xml
<property name="form" type="single_form_selection">
    <params>
        <param name="resourceKey" value="page" />
    </params>
</property>
```

## 1.0.0

No breaking changes since RC7.

## 1.0.0-RC7

### BC Breaks

Constructor of `FormSelect` (`sulu_form.content_type.form_select`) changed.
An additional Service `sulu_form.reference_store.form` (`ReferenceStoreInterface`) is needed.

Constructor of `FormConfigurationFactory` changed.
Additional configuration for `$mailAdminPlainTextTemplate` are `$mailWebsitePlainTextTemplate` are needed.

Interface of `MailConfigurationInterface` changed.
Additional `getPlainTextTemplate` is needed.

## 1.0.0-RC6

For the compatibility with `doctrine/orm ^2.6` the function names of the FormRepository are renamed to avoid inheritance issues.

 - `findById` changed to `loadById`
 - `findAll` changed to `loadAll`
 - `count` changed to `countByFilters`

## 1.0.0-RC3

### Removed `dynamic_default_view` parameter

The `dynamic_default_view` parameter was removed as it is not longer used.
If you did overwrite it remove it from your configuration.

### Longer default values

Upgrade the database schema that the defaultValue can contain a longer text:

```sql
ALTER TABLE fo_form_field_translations CHANGE defaultValue defaultValue LONGTEXT DEFAULT NULL;
```

### BC Breaks

The `MultiChoiceTrait` was renamed to `ChoiceTrait`.
Also its `getChoiceOptions` function changed not longer care about expanded or multiple.
Also the traits function are all private and can not longer be called outside.

## 0.4.0

### BC Breaks

The internal api changed

`Sulu\Bundle\FormBundle\Controller\TemplateController::getSortedTypes` is not longer public available
POST /api/forms/{id} will return 201 instead of 200 status code.
DELETE /api/forms/{id} will return 204 no content instead of 200 status code.

## 0.3.1

 - `Sulu\Bundle\FormBundle\Mail\HelperInterface::getReceiverTypes` unused function was removed.

## 0.3.0

### Symfony 3 compatibility

For the Symfony 3 Compatibility the following classes where refractored:

 - `Sulu\Bundle\FormBundle\Controller\FormWebsiteController`
 - `Sulu\Bundle\FormBundle\Form\Handler`
 - `Sulu\Bundle\FormBundle\Form\HandlerInterface`
 - `Sulu\Bundle\FormBundle\EventListener\RequestListener`
 - `Sulu\Bundle\FormBundle\Form\Builder`
 - `Sulu\Bundle\FormBundle\Event\MailSubscriber`

If you depend on them or overridden them you need reimplement your logic based
on the new classes and events.

**Your custom forms and dynamic form field types**

To update your custom form and form types have a look at https://github.com/symfony/symfony/blob/2.8/UPGRADE-3.0.md#form

### LastWidth and Column Attribute not longer written in dynamic.html.twig theme

The lastwidth and column attribute for the grid are not longer written to the dom.
If you still want them overwrite the `attributes` block in your theme with the default
of form_div_layout.html.twig.

### Static form configuration

Handling static forms the current way is deprecated if you still want use them
you need to configure a mapping between template and the static form:

```yml
sulu_form:
    static_forms:
        page_template_key:
            class: Client\Bundle\WebsiteBundle\Type\ExampleType
```

### BC Breaks

 - `Sulu\Bundle\FormBundle\Event\DynFormSavedEvent::getFormSelect` deprecated function was removed use `getData` instead.
 - `Sulu\Bundle\FormBundle\EventListener\RequestListener` was moved use `Sulu\Bundle\FormBundle\Event\RequestListener` instead
 - `Sulu\Bundle\FormBundle\Form\Handler::get` was removed form is now created in FormWebsiteController
 - `Sulu\Bundle\FormBundle\Form\Handler::getToken` was removed
 - `Sulu\Bundle\FormBundle\Form\Handler::handle($form, $attributes)` was replaced with `Sulu\Bundle\FormBundle\Form\Handler::handle($form, $configuration)`
 - `Sulu\Bundle\FormBundle\Form\Handler::sendMails` is not longer overrideable use EventListener to change Email behaviour instead
 - `Sulu\Bundle\FormBundle\Form\Handler::saveForm` is not longer overrideable use EventLister when you want to avoid save process
 - `Sulu\Bundle\FormBundle\Form\Handler::getFormLocale` was removed
 - `Sulu\Bundle\FormBundle\Form\Builder::getKey` is not longer overrideable
 - `Sulu\Bundle\FormBundle\Form\Builder::createForm` changed is not longer overrideable
 - `Sulu\Bundle\FormBundle\Form\Builder::loadFormEntity` is not longer overrideable
 - `Sulu\Bundle\FormBundle\Form\Builder::createFormType` is not longer available
 - `Sulu\Bundle\FormBundle\Form\Builder::getWebspaceKey` is not longer overrideable
 - `Sulu\Bundle\FormBundle\Form\Builder::build` return a FormInterface instead of an array
 - `Sulu\Bundle\FormBundle\Event\MailSubscriber` was removed

## 0.2.3

### Form Template file moved

`FormController:cgetTemplateAction` (/admin/api/forms/template) was moved to `TemplateController:formAction` (/admin/api//form/templates/form.html).

## 0.2.0

### Upgrade database schema

```sql
ALTER TABLE fo_form_translations ADD submitLabel VARCHAR(255) DEFAULT NULL;
ALTER TABLE fo_dynamics ADD type VARCHAR(255) NOT NULL, CHANGE uuid typeId VARCHAR(255) NOT NULL;
ALTER TABLE fo_dynamics ADD idUsersCreator INT DEFAULT NULL, ADD idUsersChanger INT DEFAULT NULL;
ALTER TABLE fo_dynamics ADD CONSTRAINT FK_EC8AF030DBF11E1D FOREIGN KEY (idUsersCreator) REFERENCES se_users (id) ON DELETE SET NULL;
ALTER TABLE fo_dynamics ADD CONSTRAINT FK_EC8AF03030D07CD5 FOREIGN KEY (idUsersChanger) REFERENCES se_users (id) ON DELETE SET NULL;
CREATE INDEX IDX_EC8AF030DBF11E1D ON fo_dynamics (idUsersCreator);
CREATE INDEX IDX_EC8AF03030D07CD5 ON fo_dynamics (idUsersChanger);
ALTER TABLE fo_dynamics ADD typeName VARCHAR(255) DEFAULT NULL;
UPDATE `fo_dynamics` SET `type` = 'page' WHERE `type` = '';
```

### Set type for content type definition

With the compatibility to use the form bundle in articles it is needed to define
the type in the xml definition.

__before__

```xml
<property name="form" type="form_select">
    <meta>
        <title lang="de">Formular</title>
        <title lang="en">Form</title>
    </meta>
</property>
```

__after__

```xml
<property name="form" type="form_select">
    <meta>
        <title lang="de">Formular</title>
        <title lang="en">Form</title>
    </meta>

    <params>
        <param name="type" value="page" />
    </params>
</property>
```

### Update configuration for export list

Change `app/config/config.yml` the `dynamic_lists` configuration need to be updated.

**before:**

```yml
sulu_form:
    dynamic_lists:
        content:
            default:
                property: form
```

**after:**

```yml
sulu_form:
    dynamic_lists:
        content:
            default:
                template: default
                property: form
                type: page
```

### BC Breaks

The bundle is under heavy development so check the changes of the following link
when you did overwrite or extend the sulu form bundle: 
https://github.com/sulu/suluformbundle/compare/0.1.0...0.2.0

### Deprecations

Handling static forms this way is deprecated and will be removed in one of the next releases.

 - The `Sulu\Bundle\FormBundle\Provider\DynamicProvider` is deprecated and will be removed in one of the next releases use the config above.  
 - Handling static forms the current way is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Event\DynFormSavedEvent::getFormSelect` function is deprecated us `getData` instead.
 - The `Sulu\Bundle\FormBundle\Form\Builder::buildForm` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::createForm` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::loadFormEntity` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::createFormType` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::loadFormEntity` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::getDefaults` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::getWebspaceKey` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Handler` is deprecated and will be removed in one of the next releases.
