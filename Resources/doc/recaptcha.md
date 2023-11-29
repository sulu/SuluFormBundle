# Recaptcha Form Field

The following is showing how you can use the Recaptcha form field.

## Installation

First of all you need to install ewz's RecaptchaBundle, if this bundle is missing it will not work.

```json
{
    "require": {
        "excelwebzone/recaptcha-bundle": "^1.4.2"
    }
}
```

or

```bash
composer require excelwebzone/recaptcha-bundle:^1.4.2
```

**Register Bundle in `config/bundles.php`**

```php
EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle::class ['all' => true],
```

## Config

add the following config to `config/packages/ewz_recaptcha.yaml`

```yaml
ewz_recaptcha:
    public_key:  <insert_your_public_key>
    private_key: <insert_your_private_key>
```

Visit [https://www.google.com/recaptcha/](https://www.google.com/recaptcha/intro/index.html) to get the public and private key.  
or visit [https://developers.google.com/recaptcha/docs/faq](https://developers.google.com/recaptcha/docs/faq) to get test keys.
