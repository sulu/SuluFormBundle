# Sulu Form Bundle

Simple handling from Symfony Forms in [Sulu.io](http://sulu.io).  
You can use this Bundle to create and handle dynamic forms.

## Features

This Bundle will allow the content manager to create `custom forms` in the backend which can selected with a content type to be displayed at a specific page.

Also this Bundle handles the problem with the `CSRF Token` and `HTTP Cache`.  
A simple Controller is provided to handle a Symfony Form with CSRF Token.  
The `mail` dispatching is handled by the bundle.

## Installation

Run the following command to install:

```bash
composer require sulu/form-bundle
```

Enable the required bundles in the `config/bundles.php` of your project:

```php
Sulu\Bundle\FormBundle\SuluFormBundle::class => ['all' => true],
```

## Config

Configure the default sender and receivers email address (optional):

```yml
sulu_form:
    mail:
        from: "%env(SULU_ADMIN_EMAIL)%"
        to:   "%env(SULU_ADMIN_EMAIL)%"
        sender: "%env(SULU_ADMIN_EMAIL)%"
```

Optional configure the email handler to SwiftMailer (`swift_mailer`) or the Symfony Mailer (`mailer`):

```yml
sulu_form:
    mail:
        helper: "swift_mailer" # is default
```

## Create Database

Execute the following command to get the sqls to update your database.

```bash
php bin/adminconsole doctrine:schema:update --dump-sql
```

You can use `--force` to run the sqls but be carefully which other
sql statements are executed. Its recommended to use [DoctrineMigrationsBundle](https://github.com/doctrine/DoctrineMigrationsBundle)
to update production databases.

## Routing

Add the following lines to `config/routes/sulu_admin.yaml`

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
- [Sendinblue](sendinblue.md "Sendinblue Form Field")
- [Recaptcha](recaptcha.md "Recaptcha Form Field")
- [Dropzone](dropzone.md "Dropzone Form Field")
