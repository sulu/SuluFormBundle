# Form Bundle for Sulu (This is a PROTOTYPE currenty this bundle is not maintained)

Handle Symfony Forms in Sulu.io

## Installation

Add to AbstractKernel (app/AbstractKernel.php)

``` php
    new L91\Sulu\Bundle\FormBundle\L91SuluFormBundle(),
```

## Concept

### Cacheable Items:

The Template itself should be cached also the form fields.

 - Template
 - Form Fields

### Uncacheable Items

 - Form CSRF Token

### Solutions

1. Load an CSRF Token over Ajax
2. Load CSRF Token in uncached ESI 

## Example Template

The following is showing an example how you can use the bundle.

### Basic Sulu Template

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

Create the entity with `app/console doctrine:generate:entites ClientWebsiteBundle`

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

``` xml
    <service id="form_example" class="Your/Bundle/FormBundle/Form/Type/ExampleType">
        <tag name="form.type" alias="pages_template_key" />
    </service>
```

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
        {% form_theme form _self %}

        {% block _l91_form_example__token_widget %}
            {% set type = type|default('hidden') %}
            <input type="{{ type }}" {{ block('widget_attributes') }} value="{{ render_esi(controller('L91SuluFormBundle:Form:token', { 'form': 'pages_template_key' })) }}" />
        {% endblock _l91_form_example__token_widget %}

        {{ form(form) }}
    {% else %}
        <h1>Thank you</h1>

        <a href="{{ app.request.headers.get('referer') }}">back</a>
    {% endif %}
</body>
</html>
```

