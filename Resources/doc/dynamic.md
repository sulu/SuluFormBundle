# Dynamic Form

This part describes step by step how to create a dynamic form with this bundle.

## Basic Sulu Template

Create a template in `config/templates/pages` which uses the content type of the bundle to select
one of the dynamic templates which can be created in the Sulu backend.

```xml
<?xml version="1.0" ?>
<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd">

    <key>form</key>

    <view>pages/form</view>
    <controller>Sulu\Bundle\WebsiteBundle\Controller\DefaultController::indexAction</controller>
    <cacheLifetime>1209600</cacheLifetime>

    <meta>
        <title lang="en">Form</title>
        <title lang="de">Formular</title>
    </meta>

    <properties>
        <section name="highlight">
            <properties>
                <property name="title" type="text_line" mandatory="true">
                    <meta>
                        <title lang="en">Title</title>
                        <title lang="de">Titel</title>
                    </meta>

                    <params>
                        <param name="headline" value="true"/>
                    </params>

                    <tag name="sulu.rlp.part"/>
                </property>

                <property name="url" type="resource_locator" mandatory="true">
                    <meta>
                        <title lang="en">Resourcelocator</title>
                        <title lang="de">Adresse</title>
                    </meta>

                    <tag name="sulu.rlp"/>
                </property>
            </properties>
        </section>

        <property name="form" type="single_form_selection">
            <meta>
                <title lang="de">Formular</title>
                <title lang="en">Form</title>
            </meta>

            <params>
                <param name="resourceKey" value="page"/>
            </params>
        </property>
    </properties>
</template>
```

Use `article` as `resourceKey` when you use the single_form_selection inside article template.

You can create a basic form called: `Test Form` which include all usable form types with:

```bash
php bin/adminconsole sulu:form:generate-form
```

> If a form called: `Test Form` already exist, it will be updated. 

## Output Form and customize

Create the view template which visualises the form or the success message if the form
has been submitted successfully!

```twig
<!doctype html>
<html lang="en">
<head>
    <title>Basic Form</title>
</head>
<body>
    {% if content.form %}
        {% if app.request.get('send') != 'true' %}
            {# FORM THEME #}
            {% form_theme content.form '@SuluForm/themes/basic.html.twig' %}
            {{ form(content.form) }}
        {% else %}
            {{ view.form.entity.successText|raw }}
        {% endif %}
    {% endif %}
</body>
</html>
```

For a custom theme look at [theming](theming.md "Theming for dynamic forms").

## Create Form

To create a dynamic form (which is selectable in the property type `form_select`) simply
click on the magic icon in the Sulu backend navigation and create a new form.

## Custom emails

For customizing the notification mail and the customer confirmation mail, adding the following lines to the configuration:

```yml
sulu_form:
    mail:
        templates:
            notify: 'mails/dynamic-notify.html.twig'
            notify_plain_text: 'mails/dynamic-notify-plain-text.html.twig'
            customer: 'mails/dynamic-customer.html.twig'
            customer_plain_text: 'mails/dynamic-customer-plain-text.html.twig'
```

Examples for the notification and costumer mail you can find [here](https://github.com/sulu/SuluFormBundle/tree/2.x/Resources/views/mails/).

## List Tab - Export

To visualise a tab in the Sulu template, simply configured the following in your `config/packages/sulu_form.yaml`:

```yml
sulu_form:
    dynamic_lists:
        sulu_page.page_edit_form: # view key e.g. "sulu_page.page_edit_form" for sulu pages or "sulu_article.edit_form" for sulu articles.
            form: # unique key mostly the same as the template key or a combination between template and property key.
                template: form # template key
                property: form # form property name
                type: page # the site type e.g. page, article, … (same as the content type type param)
```

**Now a tab should be visible with a list you can export**

## Disable specific field types

To disable specific field types in dynamic forms, add the following lines to the configuration.
Use the field type alias to disable it.
Pay attention to not disable field types already in use in your forms otherwise they will break

```yml
sulu_form:
    dynamic_disabled_types:
        - firstName
        - lastName
        - street
        - zip

```

Aliases can be found by running the following command:

```bash
php bin/adminconsole debug:container --tag=sulu_form.dynamic.type
```

### Implement Form into a custom module:

 - Implement a Provider for your Module with `TitleProviderInterface`.
 - Create a service for this Provider:

```xml
<service id="sulu_form.dynamic.collection_title_<type_name>" class="AppBundle\TitleProvider\YourTitleProvider">
    <tag name="sulu_form.title_provider" alias="<type_name>"/>
</service>
```

**Provider for type "structure" already exists**

## Add Honeypot field for spam protection

If you want to add a honeypot field for spam protection you can activate it the following way:

```yaml
sulu_form:
    honeypot:
        field: "Honey Pot Field Name"
        strategy: spam # no_save, no_email, spam
```

There are 3 honeypot strategies:

**spam**

Spam is the default behaviour and it will just mark the email subject with a prefix `(SPAM) `.

**no_email**

This option will save the form if enabled but will not send any emails.

**no_save**

Will not save and will not send any emails.

### Style honey pot field

The honey pot field need to be hidden so in your theme add a new class to it:

```twig
{%- block honeypot_row -%}
    <div class="honung">
        {{- block('form_row') -}}
    </div>
{%- endblock -%}
```

And then hide it in your css with:

```css
.honung {
    display: none;
}
```

## Media Collections

To create for every form and page an own collection you need to configure the following in your `config/packages/sulu_form.yaml`:

```yml
sulu_form:
    media:
        collection_strategy: "tree"
```

## Media Protection

In some cases you want that the uploaded media is only download able from the admin context in all cases.
To force this you need to log into to enabled media protection with, this should be enabled by default in
since 2.2 over the form bundle recipe:

```yml
sulu_form:
    media:
        protected: true
```

## Test Checklist

The following things you should check when implement the dynamic form type on your website.

 - Test media upload
 - Test the notify email
 - Test the customer email
 - Test form submit errors (e.g. use spaces in required fields should show error after submit)
 - Test backend general errors ( e.g. remove CSRF token value if enabled )
 - Test CSRF Token on production in 2 different browser sessions (when csrf protection enabled)
