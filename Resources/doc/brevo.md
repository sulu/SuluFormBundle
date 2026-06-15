# Brevo Form Field

The following is showing an example how you can use the Brevo form field to add customers to your Brevo lists.

## Installation

First of all you need to install the Brevo php sdk, otherwise the Brevo field type won't be available.

```json
{
    "require": {
        "getbrevo/brevo-php": "^4.0"
    }
}
```

or

```bash
composer require getbrevo/brevo-php:"^4.0"
```

## Config

Add the following config to `config/packages/sulu_form.yaml`:

```yml
sulu_form:
    brevo_api_key: "<YOUR_API_KEY>"
```

It is recommended to store the api key as environment variable see [Symfony Docs](https://symfony.com/doc/4.4/configuration.html#configuration-environments).

## Routing

Add the following lines to `config/routes/sulu_form_admin.yaml`:

```yaml
sulu_form_api_brevo:
    resource: "@SuluFormBundle/Resources/config/routing_api_brevo.yaml"
    prefix: /admin/api
```

## Why is there still no Brevo field type?

1. Did you install the library?
2. Did you add an api key?
3. Did you create a list and an `optin`-tagged mail template that can be shown in the field type?
