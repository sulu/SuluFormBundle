# Dynamic Form

This part describes step by step how to create a dynamic form with this bundle.

## Basic Sulu Template

Create a template in `app/Resources/pages` which uses the content type of the bundle to select
one of the dynamic templates which can be created in the Sulu backend.

```xml
<?xml version="1.0" ?>
<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd">

    <key>form</key>

    <view>AppBundle:website:templates/pages/default</view>
    <controller>SuluWebsiteBundle:Default:index</controller>
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

        <property name="form" type="form_select">
            <meta>
                <title lang="de">Formular</title>
                <title lang="en">Form</title>
            </meta>
        
            <params>
                <param name="type" value="page" />
            </params>
        </property>
    </properties>
</template>
```

Use `article` as `type` when you use the form_select inside article template.

## Output Form and customize

Create the view template which visualises the form or the success message if the form
has been submitted successfully!

```twig
<!doctype html>
<html>
<head>
    <title>Basic Form</title>
</head>
<body>
    {% if app.request.get('send') != 'true' %}
        {# FORM THEME #}
        {% form_theme content.form 'SuluFormBundle:themes:dynamic.html.twig' %}
        {{ form(content.form) }}
    {% else %}
        {{ view.form.entity.successText|raw }}
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
            notify: 'AppBundle:mails:dynamic-notify.html.twig'
            customer: 'AppBundle:mails:dynamic-customer.html.twig'
```

Examples for the notification and costumer mail you can find [here](https://github.com/sulu/SuluFormBundle/tree/master/Resources/views/mails/).

## List Tab - Export

To visualise a tab in the Sulu template, simply configured the following in your `app/config/config.yml`:

```yml
sulu_form:
    dynamic_lists:
        content: # tab navigation key e.g. "content" for sulu pages or "article" for sulu articles.
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

## Media Collections

To create for every form and page an own collection you need to configure the following in your `config.yml`:

```yml
sulu_form:
    media_collection_strategy: "tree"
```

## Test Checklist

The following things you should check when implement the dynamic form type on your website.

 - Test CSRF Token on production in 2 different browser sessions
 - Test media upload
 - Test the notifiy email
 - Test the customer email
 - Test backend field errors
 - Test backend general errors ( e.g. remove CSRF token value )
