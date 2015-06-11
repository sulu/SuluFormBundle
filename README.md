# Form Bundle for Sulu

Handle Symfony Forms in Sulu.io

## TODO

 - [ ] Mail Helper
 - [ ] Template Field Injection
 - [ ] Mail Templates
 - [ ] Token from ESI

## Installation

Add to Kernel

``` php
    new L91\Bundle\FormBundle\L91FormBundle(),
```

## Concept

### Cacheable Items:

The Template itself should be cached also the form fields.

 - Template
 - Form Fields

### Uncacheable Items

 - Form Token

The CSRF

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

    <key>form_example</key>

    <view>ClientWebsiteBundle:templates:form_example</view>
    <controller>ClientFormBundle:Form:form</controller>
    <cacheLifetime>2400</cacheLifetime>

    <meta>
        <title lang="de">Standard</title>
        <title lang="en">Default</title>
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

        <! -- Example Options -->
        <property name="option" type="text_area" mandatory="true">
            <meta>
                <title lang="de">Options</title>
                <title lang="en">Options</title>
            </meta>
        </property>


    </properties>
</template>
```

### Create Form Type

In your Symfony Form Type extend from `L91\Bundle\FormBunde\Form\Type\AbstractType` and use and create the following function.

``` php
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // your form ...

        $builder->setData(new Example());

        $builder->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('email', 'text')
            ->add('option', 'choice', array(
                'choices' =>preg_split('/\r\n|\r|\n/',  $this->getAttribute('options'))
            ))
            ->add('submit', 'submit');
    }

    public function getDataClass()
    {
        return 'L91\Bundle\FormBundle\Entity\Example';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'form_example'; // Template Key
    }
```

### Register new FormType in services.xml

``` xml
    <service id="form_example" class="Your/Bundle/FormBundle/Form/Type/ExampleType">
        <tag name="form.type" alias="form_example" />
    </service>
```

### Output Form and customize

Output form with the follwing code in your sulu template:

``` twig
    {{ form(form) }}
```

To modified use a Symfony Form Theme
https://github.com/symfony/symfony/blob/v2.7.0/src/Symfony/Bridge/Twig/Resources/views/Form/form_div_layout.html.twig

``` twig
    {% extends 'master.html.twig' %}

    {# FORM THEME #}
    {% form_theme form _self %}
    {%- block form_row -%}
        <div class="grid-item one--whole">
            {{- form_label(form) -}}
            {{- form_errors(form) -}}
            {{- form_widget(form) -}}
        </div>
    {%- endblock form_row -%}


    {% block body %}
        {{ form(form) }}
    {% endblock %}
```