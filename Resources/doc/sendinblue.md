# Sendinblue Form Field

The following is showing an example how you can use the Sendinblue form field to add customers to your Sendinblue lists.

## Installation

First of all you need to install the sendinblue php sdk, otherwise the Sendinblue field type won't be available.

```json
{
    "require": {
        "sendinblue/api-v3-sdk": "^8.0"
    }
}
```

or

```bash
composer require sendinblue/api-v3-sdk:"^8.0"
```

## Config

Add the following config to `config/packages/sulu_form.yaml`:

```yml
sulu_form:
    sendinblue_api_key: "<YOUR_API_KEY>"
```

It is recommended to store the api key as environment variable see [Symfony Docs](https://symfony.com/doc/4.4/configuration.html#configuration-environments).

## Why is there still no Sendinblue field type?

1. Did you install the library?
2. Did you add an api key?
3. Did you create a list and an `optin`-tagged mail template that can be shown in the field type?
