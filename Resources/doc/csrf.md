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

> This solution is required when using `Varnish`:

```yaml
# config/routes/sulu_form.yaml

sulu_form.token:
    path: /_form/token
    defaults:
        _controller: Sulu\Bundle\FormBundle\Controller\FormTokenController::tokenAction
        _requestAnalyzer: false
```

### A. Ajax with jquery

A simplified version loading the csrf token over ajax could look like this:

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
jQuery.get('/_form/token?form=' + formName + '&html=0').done(function(data) {
    jQuery('#' + fieldId).val(data);
});
```

### B. Ajax with sulu web js

When using [`@sulu/web`](https://github.com/sulu/web-js) / [`sulu/web-twig`](https://github.com/sulu/web-twig) component library this could look like the following:

```twig
{# templates/form/your-theme.html.twig #}

{% extends '@SuluForm/themes/basic.html.twig' %}

{%- block csrf_token_widget -%}
    {{ block('hidden_widget') }}

    {% do register_component('csrf-token', { id: id, fornName: form.parent.vars.name }) %}
{% endblock %}
```

```js
// assets/website/js/componenes/csrf-token.js

export default class CsrfToken {
    initialize(el, options) {
        fetch('/_form/token?form=' + options.formName + '&html=0').then((response) => {
            if (!response.ok) {
                return Promise.reject(response);
            }

            return response.text();
        }).then((data) => {
            el.value = data;
        });
    }
}
```

```js
// assets/website/js/main.js

import web from '@sulu/web';
import CsrfToken from './components/csrf-token';

web.registerComponent('csrf-token', CsrfToken);
```
