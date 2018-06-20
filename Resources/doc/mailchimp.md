# Mailchimp Form Field

The following is showing an example how you can use the Mailchimp form field to add customers to your Mailchimp lists.

## Installation

First of all you need to install drewn's Mailchimp API, if this bundle is missing the Mailchimp Fieldtype won't be available.

```json
{
    "require": {
        "drewm/mailchimp-api": "^2.5"
    }
}
```

or

```bash
composer require drewm/mailchimp-api:^2.5
```

## Config

add the following config to `app/config/config.yml`

```yml
sulu_form:
    mailchimp_api_key: %parameter_recommended_for_mailchimp_api_key%
```

## Subscribe Status

To change the subscribe status from `subscribed` to `pending` you need to configure the following:

```yml
sulu_form:
    mailchimp_subscribe_status: "pending"
```
https://developer.mailchimp.com/documentation/mailchimp/guides/manage-subscribers-with-the-mailchimp-api/#check-subscription-status

## Where is my Mailchimp API Key?
Account -> Extras -> Api Keys (create new / use existing)

or

https://us14.admin.mailchimp.com/account/api/

## Why is there still no Mailchimp Fieldtype?

1. Did you install the bundle?
2. Did you added an Api-Key?
3. Did you create a list what can be shown in the fieldtype?
