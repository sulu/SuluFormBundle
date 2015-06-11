# Form Bundle for Sulu

## TODO

 - [ ] Mail Helper
 - [ ] Template Field Injection
 - [ ] Mail Templates
 - [ ] Token from ESI

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

## Template

It should possible to use Template Fields in the Form Type e.g. Select Options or more.

```
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
