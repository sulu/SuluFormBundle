# Dynamic Form

This part describes step by step how to create a static form with this bundle.

## Basic Sulu Template

Create a template in `app/Resources/pages` which uses the content type of the bundle to select
one of the dynamic templates which can be created in the Sulu backend.

``` xml
<property name="form" type="form_select">
    <meta>
        <title lang="de">Formular</title>
        <title lang="en">Form</title>
    </meta>
</property>
```

## Output Form and customize

Create the view template which visualises the form or the success message if the form
has been submitted successfully!

Create a Symfony Form Theme to modify the HTML structure of the form:
https://github.com/symfony/symfony/blob/v2.7.0/src/Symfony/Bridge/Twig/Resources/views/Form/form_div_layout.html.twig

``` twig
<!doctype html>
<html>
<head>
    <title>Basic Form</title>
</head>
<body>
    {% if app.request.get('send') != 'true' %}
        {# FORM THEME #}
        {% form_theme form 'ClientWebsiteBundle:forms:theme.html.twig' %}
        {{ form(form) }}
    {% else %}
        {{ view.form.entity.successText|raw }}
    {% endif %}
</body>
</html>
```

## Theme

```twig
+{%- block _dynamic_form__token_widget -%}
+    {% set type = type|default('hidden') %}
+    <input type="{{ type }}" {{ block('widget_attributes') }} value="{{ render_esi(controller('L91SuluFormBundle:FormWebsite:token', { 'form': form.parent.vars.name })) }}" />
+{% endblock %}

{%- block hidden_row -%}
    {% set width = attr.width|default('half')|replace({
        'half': 'one-half',
        'full': 'one-whole'
    }) %}

    <div class="grid__item {{ width }}">
        {% if attr.type|default('') == 'spacer' %}
            <div class="form-field">
                {# SPACER #}
            </div>
        {% elseif attr.type|default('') == 'freeText' %}
            <div class="form-field">
                <p>{{ label|nl2br }}</p>
            </div>
        {% elseif attr.type|default('') == 'headline' %}
            <div class="grid__item one-whole">
                <h2>{{ attr.headline }}</h4>
            </div>
        {% else %}
            {{ form_widget(form) }}
        {% endif %}
    </div>
{%- endblock hidden_row -%}
```

## Issues

Please check to following issue before using it in production:

[https://github.com/alexander-schranz/sulu-form-bundle/issues/69](https://github.com/alexander-schranz/sulu-form-bundle/issues/69)

## Create Form

To create a dynamic form (which is selectable in the property type `form_select`) simply
click on the magic icon in the Sulu backend navigation and create a new form.

## List Tab - Export

To visualise a tab in the Sulu template, simply add following lines to your Bundles `services.xml`:

```xml
<service id="client_website.list_provider.form" class="L91\Sulu\Bundle\FormBundle\Provider\DynamicProvider">
    <tag name="l91_sulu_form.list_provider" template="form" />
</service>
```

**Now a tab should be visible with a list you can export**

