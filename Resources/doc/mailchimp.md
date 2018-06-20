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
    mailchimp_subscribe_status: %parameter_recommended_for_mailchimp_subscribe_status%
```

## Subscribe Status

- subscribed
    - ```This address is on the list and ready to receive email. You can only send campaigns to ‘subscribed’ addresses.```
    
- unsibscribed
    - ```This address used to be on the list but isn’t anymore.```

- pending 
    - ```This address requested to be added with double-opt-in but hasn’t confirmed their subscription yet.```
    
- cleaned
    - ```This address bounced and has been removed from the list.```

## Where is my Mailchimp API Key?
Account -> Extras -> Api Keys (create new / use existing)

or

https://us14.admin.mailchimp.com/account/api/

## Why is there still no Mailchimp Fieldtype?

1. Did you install the bundle?
2. Did you added an Api-Key?
3. Did you create a list what can be shown in the fieldtype?
