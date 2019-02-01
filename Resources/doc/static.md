# Static Form

_The current way to create static form is deprecated_
_its recommend to create your own custom controller_
_instead of using the form bundle for it_

The following is showing an example how you can use the bundle to create a static form (deprecated).

## Basic Sulu Template

Sulu template is not needed when using a ajax loaded form.

``` xml
<?xml version="1.0" ?>
<template xmlns="http://schemas.sulu.io/template/template"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
          xsi:schemaLocation="http://schemas.sulu.io/template/template http://schemas.sulu.io/template/template-1.0.xsd">

    <key>pages_template_key</key>

    <view>ClientWebsiteBundle:templates:pages_template_key</view>
    <controller>SuluFormBundle:FormWebsite:form</controller>
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

                <property name="mail_customer_replyto_address" type="text_line" mandatory="false">
                    <meta>
                        <title lang="de">Antwort E-Mail für Bestätigungsmail</title>
                        <title lang="en">Reply address for customer mail</title>
                    </meta>
                </property>

                <property name="mail_notify_replyto_address" type="text_line" mandatory="false">
                    <meta>
                        <title lang="de">Antowrt E-Mail für Benachrichtigungsmail</title>
                        <title lang="en">Reply address for notify mail</title>
                    </meta>
                </property>
            </properties>
        </section>
    </properties>
</template>
```

## Create Entity

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

Create the entity with `app/console doctrine:generate:entities ClientWebsiteBundle`.
Sometimes Sulu has problems with this command, in this case you will need to create an empty class in your `Entity` Folder. (Issue: https://github.com/sulu-io/sulu/issues/1343) 

## Create Form Type

In your Symfony Form Type extend from `Sulu\Bundle\FormBundle\Form\Type\AbstractType` and use and create the following function.

``` php
namespace Client\Bundle\WebsiteBundle\Form\Type;

use Sulu\Bundle\FormBundle\Entity\Example;
use Sulu\Bundle\FormBundle\Form\Type;
use Symfony\Component\Form\FormBuilderInterface;

class FormExampleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    protected $dataClass = 'Sulu\Bundle\FormBundle\Entity\Example';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setData(new Example());

        $builder->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('email', 'text')
            ->add('customOption', 'choice', [
                'choices' => preg_split('/\r\n|\r|\n/',  $this->getAttribute('options')),
            ])
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

## Register new FormType in services.xml and in the config.xml

The form is loaded by the template key so create a form type with the name same as the template key.

```xml
    <service id="form_example" class="Client\Bundle\WebsiteBundle\Type\ExampleType">
        <tag name="form.type" />
    </service>
```

For the mapping between the class and the template we need to configure it in the app/config/config.xml

```yml
sulu_form:
    static_forms:
        page_template_key:
            class: Client\Bundle\WebsiteBundle\Type\ExampleType
```

## Add routing for the only Action (needed for Ajax loaded Forms)

Add ajax route to website config (app/config/website/routing.yml)

```yml
sulu_form:
    resource: "@SuluFormBundle/Resources/config/routing.yml"
```

To form can now be requested under `/form/only/{form_type_alias}`  
The form type alias you did set in your `services.xml`

## Output Form and customize

Create a Symfony Form Theme to modify the HTML structure of the form:
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
{% block token_widget %}
    { render_esi(controller('SuluFormBundle:FormWebsite:token', { 'form': 'form_type_alias', 'html': true })) }}
{% endblock token_widget %}
```

## E-Mail

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

## Create a ListProvider (optional)

For the list provider you need first register the admin api in `app/config/admin/routing.yml`

```yml
sulu_form_api:
    type: rest
    resource: "@SuluFormBundle/Resources/config/routing_api.yml"
    prefix: /admin/api
```

After this you need to create a new class which implements the `ListProviderInterface`

```php
<?php

namespace Client\Bundle\WebsiteBundle\Provider;

use Client\Bundle\WebsiteBundle\Entity\Example;
use Sulu\Bundle\FormBundle\Provider\ListProviderInterface;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;

class ExampleListProvider implements ListProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFieldDescriptors($webspace, $locale, $uuid)
    {
        $fieldDescriptors['id'] = $this->createFieldDescriptor('id');
        $fieldDescriptors['uuid'] = $this->createFieldDescriptor('uuid', true);
        $fieldDescriptors['email'] = $this->createFieldDescriptor('email');
        $fieldDescriptors['created'] = $this->createFieldDescriptor('created', false, 'date');

        return $fieldDescriptors;
    }

    /**
     * @param string $fieldName
     * @param $disabled $isDate
     * @param string $type
     *
     * @return DoctrineFieldDescriptor
     */
    protected function createFieldDescriptor($fieldName, $disabled = false, $type = '')
    {
        return new DoctrineFieldDescriptor(
            $fieldName,
            $fieldName,
            Example::class,
            'public.' . $fieldName,
            [],
            $disabled,
            false,
            $type
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName($webspace, $locale, $uuid)
    {
        return Example::class;
    }
}

```

Register the class and tag it 

```xml
<service id="client_website.list_provider.example" class="Client\Bundle\WebsiteBundle\Provider\ExampleListProvider">
    <tag name="sulu_form.list_provider" template="pages_template_key" />
</service>
```

**Now a tab should be visible with a list you can export**
