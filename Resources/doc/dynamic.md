# Dynamic Form

This part describes step by step how to create a dynamic form with this bundle.

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

## Controller

For the dynamic form type you can use the default sulu controller in your template or a custom one.

```xml
<controller>SuluWebsiteBundle:Default:index</controller>
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
        {% form_theme content.form 'ClientWebsiteBundle:forms:theme.html.twig' %}
        {{ form(content.form) }}
    {% else %}
        {{ view.form.entity.successText|raw }}
    {% endif %}
</body>
</html>
```

## Theme

```twig
{%- block _dynamic_form__token_widget -%}
    {{ render_esi(controller('L91SuluFormBundle:FormWebsite:token', { 'form': form.parent.vars.name, 'html': true, _requestAnalyzer: false })) }}
{% endblock %}

{%- block form_row -%}
    {% set className = 'form-item form-width-' ~ attr.width|default('full') %}

    {% if attr.lastWidth|default(false) %}
        {% set className = className ~ ' form-width-last' %}
    {% endif %}

    <div class="{{ className }}">
        {{- form_label(form) -}}
        {{- form_errors(form) -}}
        {{- form_widget(form) -}}
    </div>
{%- endblock -%}

{%- block hidden_row -%}
    <div class="form-item form-width-{{ attr.width|default('full') }}">
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
                <h2>{{ label }}</h2>
            </div>
        {% else %}
            {{ form_widget(form) }}
        {% endif %}
    </div>
{%- endblock hidden_row -%}

{%- block form_label -%}
    {% if label is not same as(false) -%}
        {% if not compound -%}
            {% set label_attr = label_attr|merge({'for': id}) %}
        {%- endif -%}
        {% if required -%}
            {% set label_attr = label_attr|merge({'class': (label_attr.class|default('') ~ ' required')|trim}) %}
        {%- endif -%}
        {% if label is empty -%}
            {%- if label_format is not empty -%}
                {% set label = label_format|replace({
                    '%name%': name,
                    '%id%': id,
                }) %}
            {%- else -%}
                {% set label = name|humanize %}
            {%- endif -%}
        {%- endif -%}
        <label{% for attrname, attrvalue in label_attr %} {{ attrname }}="{{ attrvalue }}"{% endfor %}>
            {{ label|raw }}
        </label>
    {%- endif -%}
{%- endblock form_label -%}
```

## Create Form

To create a dynamic form (which is selectable in the property type `form_select`) simply
click on the magic icon in the Sulu backend navigation and create a new form.

## Emails

Create the emails template in the a folder <templateKey-mail>.

form-notify.html.twig

```twig
{% for field in formEntity.fields|default([]) %}
    {% set value = field.value %}

    {# get formatted value #}
    {% if value is iterable %}
        {% set value = value|json_encode %}
    {% elseif value.timestamp is defined %}
        {% set value = value|date('d.m.Y') %}
    {% endif %}

    {% if value is not empty %}
        <strong>{{ field.title|default('') }}</strong>: {{ value }}<br>
    {% endif %}
{% endfor %}
```

form-notify.html.twig

```twig
{{ formEntity.mailText|default('')|raw }}
```

## List Tab - Export

To visualise a tab in the Sulu template, simply configured the following in your `app/config/config.yml`:

```xml
l91_sulu_form:
    dynamic_lists:
        content:
            <template_key>:
                property: <form_select_property_name>
```

**Now a tab should be visible with a list you can export**

## Media Collections

To create for every form and page an own collection you need to configure the following in your `config.yml`:

```yml
l91_sulu_form:
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
