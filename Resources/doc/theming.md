# Theming for dynamic forms

Mostly you want a custom theme here a basic example for common customization

```twig
{# templates/form/theme.html.twig #}
{% extends '@SuluForm/themes/basic.html.twig' %}

{# Add class to <form> tag #}
{%- block form_start -%}
    {% set attr = attr|merge({ class: 'form' }) %}
    {{- parent() -}}
{%- endblock -%}

{# Integrate a basic grid #}
{%- block form_widget_compound -%}
    {%- if form is rootform -%}
        {% set attr = attr|merge({class: 'grid'}) %}
    {%- endif -%}

    {{- parent() -}}
{%- endblock form_widget_compound -%}

{%- block sulu_form_row_class_name -%}
    {{- 'grid__item width-' ~ attr.widthNumber|default(12) -}}
    {#-
     # The form bundle provides the following variables here:
     #
     # attr.width = 'full', 'half', ...
     # attr.widthNumber = 12, 6, ...
     # attr.lastWidth = true, false
     -#}
{%- endblock sulu_form_row_class_name -%}

{# Add class to label #}
{%- block form_label -%}
    {% set label_attr = label_attr|merge({class: 'form__label'}) %}
    {{- parent() -}}
{%- endblock form_label -%}

{# Custom title #}
{%- block headline_widget -%}
    <h4>{{- label|raw -}}</h4>
{%- endblock headline_widget -%}

{%- block freeText_widget -%}
    <p>{{- label|raw -}}</p>
{%- endblock freeText_widget -%}

{# Add classes to button #}
{%- block button_widget -%}
    {% set attr = attr|merge({ class: 'button button--full' }) %}
    {{ parent() }}
{%- endblock button_widget -%}

{# Set wrapping class around checkbox and radio #}
{%- block sulu_form_choice_class_name -%}
    {{- 'form__choice' -}}
{%- endblock sulu_form_choice_class_name -%}

{# Add class to honeypot field to hide it with css #}
{%- block honeypot_row -%}
    <div class="form-block-honung">
        {{- block('form_row') -}}
    </div>
{%- endblock -%}
```

To use the new theme you must change the following line in your form rendering:

```twig
{% form_theme content.form 'templates/form/theme.html.twig' %}
```

**Other theme customization**

For other block you can overwrites have a look at the 

https://github.com/symfony/symfony/blob/4.4/src/Symfony/Bridge/Twig/Resources/views/Form/form_div_layout.html.twig

and

https://github.com/sulu/SuluFormBundle/blob/master/Resources/views/themes/basic.html.twig
