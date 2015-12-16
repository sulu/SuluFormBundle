# Form Bundle for Sulu

Simple handling from Symfony Forms in [Sulu.io](http://sulu.io).  
You can use the Bundle to handle forms which are directly integrated in a Sulu page
or for ajax loaded forms.

## Installation

Use composer to install this Bundle:

``` json
{
    "require": {
        "l91/sulu-form-bundle": "~0.2"
    }
}
```

or

``` bash
composer require l91/sulu-form-bundle:~0.2
```

Add to AbstractKernel (app/AbstractKernel.php)

``` php
new L91\Sulu\Bundle\FormBundle\L91SuluFormBundle(),
```

## Config

add the following config to `app/config/config.yml`

``` yml
framework:
    esi: { enabled: true } # use to reload csrf token

l91_sulu_form:
    mail_helper:
        from: %parameter_recommended_for_from%
        to: %parameter_recommended_for_to%
```

## Features

This Bundle handles the problem with the `CSRF Token` and `HTTP Cache`.  
A simple Controller is provided to handle a Symfony Form with CSRF Token.  
Also `mail` dispatching is handled by the bundle.

### Cacheable Items:

The Template itself should be cached also the form fields.

 - Template
 - Form Fields

### Uncacheable Items

 - Form CSRF Token (loaded over ESI Request in the twig theme)

## Example Template

The following is showing an example how you can use the bundle.

### Basic Sulu Template

Sulu template is not needed when using a ajax loaded form.

``` xml
<?xml version="1.0" ?>
<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd">

    <key>pages_template_key</key>

    <view>ClientWebsiteBundle:templates:pages_template_key</view>
    <controller>L91SuluFormBundle:Form:form</controller>
    <cacheLifetime>2400</cacheLifetime>

    <meta>
        <title lang="de">Form</title>
        <title lang="en">Form</title>
    </meta>

    <properties>
        <property name="title" type="text_line" mandatory="true">
            <meta>
                <title lang="de">Titel</title>
                <title lang="en">Title</title>
            </meta>

            <tag name="sulu.rlp.part"/>
        </property>

        <property name="url" type="resource_locator" mandatory="true">
            <meta>
                <title lang="de">Adresse</title>
                <title lang="en">Resourcelocator</title>
            </meta>

            <tag name="sulu.rlp"/>
            <tag name="sulu.search.field" role="description"/>
        </property>

        <section name="form">
            <meta>
                <title lang="de">Form</title>
                <title lang="en">Form</title>
            </meta>
            <properties>
                <property name="options" type="text_area">
                    <meta>
                        <title lang="de">Form Options</title>
                        <title lang="en">Form Options</title>
                    </meta>
                </property>

                <property name="mail_customer_from_address" type="text_line" mandatory="true">
                    <meta>
                        <title lang="de">Customer From Mail</title>
                        <title lang="en">Customer From Mail</title>
                    </meta>
                </property>

                <property name="mail_notify_from_address" type="text_line" mandatory="true">
                    <meta>
                        <title lang="de">Notify From Mail</title>
                        <title lang="en">Notify From Mail</title>
                    </meta>
                </property>

                <property name="mail_notify_to_address" type="text_line" mandatory="true">
                    <meta>
                        <title lang="de">Notify To Mail</title>
                        <title lang="en">Notify To Mail</title>
                    </meta>
                </property>
            </properties>
        </section>
    </properties>
</template>
```

### Create Entity

In your Bundle under `Resources/config/doctrine/` create your `*.orm.xml` file:

``` xml
<?xml version="1.0" encoding="utf-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Client\Bundle\WebsiteBundle\Entity\Example" table="cl_form_example">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO"/>
        </id>
        <field name="firstName" type="string" column="firstName" />
        <field name="lastName" type="string" column="lastName" />
        <field name="email" type="string" column="email" />
        <field name="customOption" type="string" column="customOption" nullable="true" />
        <field name="created" type="datetime" column="created">
            <options>
                <option name="default">CURRENT_TIMESTAMP</option>
            </options>
        </field>
    </entity>
</doctrine-mapping>
```

Create the entity with `app/console doctrine:generate:entities ClientWebsiteBundle`  
Sulu have sometimes problem with this command and you maybe need first create the empty class in your `Entity` Folder. (Issue: https://github.com/sulu-io/sulu/issues/1343) 

### Create Form Type

In your Symfony Form Type extend from `L91\Sulu\Bundle\FormBunde\Form\Type\AbstractType` and use and create the following function.

``` php
namespace Client\Bundle\WebsiteBundle\Form\Type;

use L91\Sulu\Bundle\FormBundle\Entity\Example;
use L91\Sulu\Bundle\FormBundle\Form\Type;
use Symfony\Component\Form\FormBuilderInterface;

class FormExampleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    protected $dataClass = 'L91\Sulu\Bundle\FormBundle\Entity\Example';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setData(new Example());

        $builder->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('email', 'text')
            ->add('customOption', 'choice', array(
                'choices' => preg_split('/\r\n|\r|\n/',  $this->getAttribute('options'))
            ))
            ->add('submit', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pages_template_key';
    }
}
```

### Register new FormType in services.xml

The form is loaded by the template key so create a form type with the name same as the template key.

``` xml
    <service id="form_example" class="Client\Bundle\WebsiteBundle\Type\ExampleType">
        <tag name="form.type" alias="pages_template_key" />
    </service>
```

### Add routing for the only Action (needed for Ajax loaded Forms)

Add ajax route to website config (app/config/website/routing.yml)

```
l91_sulu_form:
    resource: "@L91SuluFormBundle/Resources/config/routing.yml"
```

To form can now be requested under `/form/only/{form_type_alias}`  
The form type alias you did set in your `services.xml`

### Output Form and customize

To modified use a Symfony Form Theme
https://github.com/symfony/symfony/blob/v2.7.0/src/Symfony/Bridge/Twig/Resources/views/Form/form_div_layout.html.twig

``` twig
<!doctype html>
<html>
<head>
    <title>Basic Form</title>
</head>
<body>
    {% if app.request.get('send') != 'true' %}
        <h1>Basic Form {{ template }}</h1>

        {# FORM THEME #}
        {% form_theme form 'ClientWebsiteBundle:forms:theme.html.twig' %}
        {{ form(form) }}
    {% else %}
        <h1>Thank you</h1>

        <a href="{{ app.request.headers.get('referer') }}">back</a>
    {% endif %}
</body>
</html>
```

ClientWebsiteBundle:forms:theme.html.twig:

``` twig
{% block _contact_request__token_widget %}
    {% set type = type|default('hidden') %}
    <input type="{{ type }}" {{ block('widget_attributes') }} value="{{ render_esi(controller('L91SuluFormBundle:Form:token', { 'form': 'form_type_alias' })) }}" /> {#  #}
{% endblock _contact_request__token_widget %}
```


### Email

You need to create 2 emails(visitor/admin). Default Path are:  
Admin: `ClientWebsiteBundle:views:form/mail/{form_type_name}/notify.html.twig`;  
Visitor: `ClientWebsiteBundle:views:form/mail/{form_type_name}/success.html.twig`;  

To change it you can just overwrite in your FormType the `getNotifyMail` or `getCustomerMail` function.

**Twig**

To output the data in the email see the following example:

``` twig
Firstname: {{ form.data.firstName }}<br/>
Lastname: {{ form.data.lastName }}<br/>

{# You can also access the template data in your mail #}
{{ content.mail_success_text }}
```

