# Theming for dynamic forms

Mostly you want a custom theme here a basic example for common customization

```twig
{% extends 'SuluFormBundle:themes:dynamic.html.twig' %}

{# Custom title #}
{%- block sulu_form_text_headline_widget -%}
    <div class="title">{{- label|raw -}}</div>
{%- endblock sulu_form_text_headline_widget -%}

{# Custom freeText #}
{%- block sulu_form_text_freeText_widget -%}
    <div class="free-text">{{- label|raw -}}</div>
{%- endblock sulu_form_text_freeText_widget -%}

{# Custom grid class #}
{%- block sulu_form_row_class_name -%}
    {{- 'grid-item ' ~ attr.width|default('full') -}}
{%- endblock sulu_form_row_class_name -%}
```

To use the new theme you must change the following line in your form rendering:

```twig
{% form_theme content.form 'AppBundle:themes:custom-dynamic.html.twig' %}
```

**Other theme customization**

For other block you can overwrites have a look at the 

https://github.com/symfony/symfony/blob/2.8/src/Symfony/Bridge/Twig/Resources/views/Form/form_div_layout.html.twig

and

https://github.com/sulu/SuluFormBundle/blob/master/Resources/views/themes/dynamic.html.twig
