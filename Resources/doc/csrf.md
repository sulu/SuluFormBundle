# CSRF Token

The csrf token is session based, because of the sulu caching mechanism
it is needed to be load that token over a separate request (ajax).

Enable csrf protection for dynamic forms via:

```yaml
sulu_form:
    csrf_protection: true
```

## Ajax

> This solution is required when pages are cached using `Varnish`:

```yaml
# config/routes/sulu_form.yaml

sulu_form.token:
    path: /_form/token
    defaults:
        _controller: Sulu\Bundle\FormBundle\Controller\FormTokenController::tokenAction
        _requestAnalyzer: false
```

### A. Ajax with jquery

A simple example for loading the csrf token over ajax looks like this:

```twig
# your-theme.html.twig

{%- block csrf_token_widget -%}
    {{ block('hidden_widget') }}

    {# this is just an example it should use data attributes or something similar to read formName and fieldId #}
    <script>
        var formName = '{{ form.parent.vars.name }}';
        var fieldId = '{{ id }}';
    </script>
{% endblock %}
```

```js
fetch('/_form/token?form=' + formName + '&html=0', {
    credentials: 'same-origin', // required for old safari versions
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
}).then((response) => {
    return response.text();
}).then((token) => {
    document.getElementById(fieldId).value = token;
});
```

### B. Ajax with sulu web-js

When using [`@sulu/web`](https://github.com/sulu/web-js) / [`sulu/web-twig`](https://github.com/sulu/web-twig) component library, loading the csrf token over ajax looks like this:

```twig
{# templates/form/your-theme.html.twig #}

{% extends '@SuluForm/themes/basic.html.twig' %}

{%- block csrf_token_widget -%}
    {{ block('hidden_widget') }}

    {% do register_component('csrf-token', { id: id, formName: form.parent.vars.name }) %}
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

## ESI

> This solution does not work with Symfony 5.4 or later. Please use ajax loading when enabling csrf protection.

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
