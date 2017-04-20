# Dynamic Form

This part describes step by step how to create a dynamic form with this bundle.

## Basic Sulu Template

Create a template in `app/Resources/pages` which uses the content type of the bundle to select
one of the dynamic templates which can be created in the Sulu backend.

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

## Controller

For the dynamic form type you can use the default sulu controller in your template or a custom one.

```xml
<controller>SuluWebsiteBundle:Default:index</controller>
```

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
        <tab_navigation>: # For sulu pages "content".
            <unique_key>: # Mostly the same as the template key.
                template: <template_key>
                property: <form_select_property_name>
                type: <form_type> # (e.g. page, article, event,…)
```

**Now a tab should be visible with a list you can export**

### Implement Tab into a custom module:

 - Implement a Provider for your Module with `TitleProviderInterface`.
 - Create a service for this Provider:

```xml
<service id="sulu_form.dynamic.collection_title_<module_name>" class="Sulu\Bundle\FormBundle\TitleProvider\Collections\StructureTitleProvider">
    <tag name="sulu_form.title_provider" alias="<module_name>"/>
    <argument type="service" id="request_stack"/>
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
