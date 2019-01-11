# Upgrade

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
