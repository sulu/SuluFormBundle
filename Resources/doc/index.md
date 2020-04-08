# Sulu Form Bundle

Simple handling from Symfony Forms in [Sulu.io](http://sulu.io).  
You can use this Bundle to create and handle static *(integrated in a Sulu page or loaded via AJAX)* or dynamic forms.

## Features

This Bundle will allow the content manager to create `custom forms` in the backend which can selected with a content type to be displayed at a specific page.

Also this Bundle handles the problem with the `CSRF Token` and `HTTP Cache`.  
A simple Controller is provided to handle a Symfony Form with CSRF Token.  
The `mail` dispatching is handled by the bundle.

## Installation

```bash
composer require sulu/form-bundle
```

Add to AbstractKernel (app/AbstractKernel.php)

```php
new Sulu\Bundle\FormBundle\SuluFormBundle(),
```

## Config

Add the following config to `app/config/config.yml`

```yml
framework:
    esi: ~  # use to reload csrf token
    fragments: ~

sulu_form:
    mail:
        from: %sulu_admin.email%
        to: %sulu_admin.email%
```

## Create Database

Execute following command to update your database

```bash
app/console doctrine:schema:update --force
```

## Install assets

```bash
app/console assets:install --symlink --relative
```

## Generate translations

```bash
app/console sulu:translate:export
```

## Routing

Add the following lines to `app/config/admin/routing.yml`

```yml
sulu_form_api:
    type: rest
    resource: "@SuluFormBundle/Resources/config/routing_api.yml"
    prefix: /admin/api
 ```

## Permissions

Make sure you've set the correct permissions in the Sulu backend for this bundle!

## Usage

- [Static Forms](static.md "Static Forms")
- [Dynamic Forms](dynamic.md "Dynamic Forms")

## Additional form fields

- [Mailchimp](mailchimp.md "Mailchimp Form Field")
- [Recaptcha](recaptcha.md "Recaptcha Form Field")
- [Dropzone](dropzone.md "Dropzone Form Field")

## Varnish

Using varnish have a look at the [CSRF](csrf.md "CSRF Token") documentation.
