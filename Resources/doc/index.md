# Sulu Form Bundle

Simple handling from Symfony Forms in [Sulu.io](http://sulu.io).  
You can use this Bundle to create and handle dynamic forms.

## Features

This Bundle will allow the content manager to create `custom forms` in the backend which can selected with a content type to be displayed at a specific page.

Also this Bundle handles the problem with the `CSRF Token` and `HTTP Cache`.  
A simple Controller is provided to handle a Symfony Form with CSRF Token.  
The `mail` dispatching is handled by the bundle.

## Installation

```bash
composer require sulu/sulu-form-bundle
```

Add to AbstractKernel (app/AbstractKernel.php)

```php
new Sulu\Bundle\FormBundle\SuluFormBundle(),
```

## Config

Activate esi for csrf token reload on cache pages
by change the following lines in `app/config/config.yml`.

```yml
framework:
    esi: ~
    fragments: ~
```

Configure the default sender and receivers email address (optional):

```yml
sulu_form:
    mail:
        from: "%sulu_admin.email%"
        to:   "%sulu_admin.email%"
```

## Create Database

Execute the following command to get the sqls to update your database.

```bash
php bin/adminconsole doctrine:schema:update --dump-sql
```

You can use `--force` to run the sqls but be carefully which other
sql statements are executed.

## Install assets

```bash
php bin/adminconsole assets:install --symlink --relative
```

## Generate translations

```bash
php bin/adminconsole sulu:translate:export
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

- [Dynamic Forms](dynamic.md "Dynamic Forms")
- [Static Forms](static.md "Static Forms") (deprecated)

## Additional form fields

- [Mailchimp](mailchimp.md "Mailchimp Form Field")
- [Recaptcha](recaptcha.md "Recaptcha Form Field")
- [Dropzone](dropzone.md "Dropzone Form Field")

## Varnish

Using varnish have a look at the [CSRF](csrf.md "CSRF Token") documentation.

