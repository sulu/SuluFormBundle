# CSRF Token

The csrf token is session based so it need to be loaded over 
an seperate request this can be done by esi or ajax. In your
form theme template.

## ESI

Add the following to your form theme to overwrite the default
behaviour of token generation.

```twig
{%- block _dynamic_form__token_widget -%}
    {{ render_esi(controller('SuluFormBundle:FormWebsite:token', { 'form': form.parent.vars.name, 'html': true, , _requestAnalyzer: false })) }}
{% endblock %}
```

## Ajax ( required for varnish cache )

A simplified version loading the csrf token over ajax could
look like this:

``` twig
{%- block _dynamic_form__token_widget -%}
    {{ block('hidden_widget') }}

    <script>
        var formName = '{{ form.parent.vars.name }}';
        var fieldId = '{{ id }}';
    </script>
{% endblock %}
```

``` js
jQuery.get('/form/token?form=' + formName + '&html=0').done(function(data) {
    jQuery('#' + fieldId).val(data);
});
```

