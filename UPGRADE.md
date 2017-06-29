# Upgrade

## 0.2.0

### Upgrade database schema

```sql
ALTER TABLE fo_form_translations ADD submitLabel VARCHAR(255) DEFAULT NULL;
ALTER TABLE fo_dynamics ADD type VARCHAR(255) NOT NULL, CHANGE uuid typeId VARCHAR(255) NOT NULL;
ALTER TABLE fo_dynamics ADD idUsersCreator INT DEFAULT NULL, ADD idUsersChanger INT DEFAULT NULL;
ALTER TABLE fo_dynamics ADD CONSTRAINT FK_EC8AF030DBF11E1D FOREIGN KEY (idUsersCreator) REFERENCES se_users (id) ON DELETE SET NULL;
ALTER TABLE fo_dynamics ADD CONSTRAINT FK_EC8AF03030D07CD5 FOREIGN KEY (idUsersChanger) REFERENCES se_users (id) ON DELETE SET NULL;
CREATE INDEX IDX_EC8AF030DBF11E1D ON fo_dynamics (idUsersCreator);
CREATE INDEX IDX_EC8AF03030D07CD5 ON fo_dynamics (idUsersChanger);
ALTER TABLE fo_dynamics ADD typeName VARCHAR(255) DEFAULT NULL;
```

or run

```bash
php bin/adminconsole doctrine:schema:update --dump-sql # run with --force to actually update the database
```

### Set type for content type definition

With the compatibility to use the form bundle in articles it is needed to define
the type in the xml definition.

__before__

```xml
<property name="form" type="form_select">
    <meta>
        <title lang="de">Formular</title>
        <title lang="en">Form</title>
    </meta>
</property>
```

__after__

```xml
<property name="form" type="form_select">
    <meta>
        <title lang="de">Formular</title>
        <title lang="en">Form</title>
    </meta>

    <params>
        <param name="type" value="page" />
    </params>
</property>
```

### Update configuration for export list

Change `app/config/config.yml` the `dynamic_lists` configuration need to be updated.

**before:**

```yml
sulu_form:
    dynamic_lists:
        content:
            default:
                property: form
```

**after:**

```yml
sulu_form:
    dynamic_lists:
        content:
            default:
                template: default
                property: form
                type: page
```

### BC Breaks

The bundle is under heavy development so check the changes of the following link
when you did overwrite or extend the sulu form bundle: 
https://github.com/sulu/suluformbundle/compare/0.1.0...0.2.0

### Deprecations

Handling static forms this way is deprecated and will be removed in one of the next releases.

 - The `Sulu\Bundle\FormBundle\Provider\DynamicProvider` is deprecated and will be removed in one of the next releases use the config above.  
 - Handling static forms the current way is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Event\DynFormSavedEvent::getFormSelect` function is deprecated us `getData` instead.
 - The `Sulu\Bundle\FormBundle\Form\Builder::buildForm` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::createForm` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::loadFormEntity` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::createFormType` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::loadFormEntity` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::getDefaults` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Builder::getWebspaceKey` is deprecated and will be removed in one of the next releases.
 - The `Sulu\Bundle\FormBundle\Form\Handler` is deprecated and will be removed in one of the next releases.
