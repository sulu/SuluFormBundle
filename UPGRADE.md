# Upgrade

## dev-develop

### Upgrade database schema

```sql
ALTER TABLE fo_form_translations ADD submitLabel VARCHAR(255) DEFAULT NULL;
ALTER TABLE fo_dynamics ADD type VARCHAR(255) NOT NULL, CHANGE uuid typeId VARCHAR(255) NOT NULL;
ALTER TABLE fo_dynamics ADD idUsersCreator INT DEFAULT NULL, ADD idUsersChanger INT DEFAULT NULL;
ALTER TABLE fo_dynamics ADD CONSTRAINT FK_EC8AF030DBF11E1D FOREIGN KEY (idUsersCreator) REFERENCES se_users (id) ON DELETE SET NULL;
ALTER TABLE fo_dynamics ADD CONSTRAINT FK_EC8AF03030D07CD5 FOREIGN KEY (idUsersChanger) REFERENCES se_users (id) ON DELETE SET NULL;
CREATE INDEX IDX_EC8AF030DBF11E1D ON fo_dynamics (idUsersCreator);
CREATE INDEX IDX_EC8AF03030D07CD5 ON fo_dynamics (idUsersChanger);
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
