# CSRF Token

The csrf token is session based so it need to be loaded over 
an seperate request this can be done by esi (used by the basic theme) or ajax.
In your form theme template.

## ESI

Add the following to your form theme to overwrite the default
behaviour of token generation or use the `@SuluForm/themes/basic.html.twig` theme.

```twig
{%- block csrf_token_widget -%}
    {{ render_esi(controller('Sulu\\Bundle\\FormBundle\\Controller\\FormTokenController::tokenAction', {
        'form': form.parent.vars.name,
        'html': true,
         _requestAnalyzer: false
     })) }}
{% endblock %}
```

## Ajax

A simplified version loading the csrf token over ajax could
look like this:

```yaml
# config/routes/sulu_form.yaml

sulu_form.token:
    path: /form/token
    defaults:
        _controller: Sulu\Bundle\FormBundle\Controller\FormTokenController::tokenAction
        _requestAnalyzer: false
```

```twig
# your-theme.html.twig

{%- block csrf_token_widget -%}
    {{ block('hidden_widget') }}

    <script>
        var formName = '{{ form.parent.vars.name }}';
        var fieldId = '{{ id }}';
    </script>
{% endblock %}
```

```js
jQuery.get('/form/token?form=' + formName + '&html=0').done(function(data) {
    jQuery('#' + fieldId).val(data);
});
```
