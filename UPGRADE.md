# Upgrade

## dev-develop

### Upgrade database schema

```sql
ALTER TABLE fo_dynamics ADD type VARCHAR(255) NOT NULL, CHANGE uuid typeId VARCHAR(255) NOT NULL;
```

### Update configuration

**before:**
```yml
dynamic_lists:
    content:
        default:
            property: form
```

**after:**
```yml
dynamic_lists:
    content:
        default:
            template: default
            property: form
            type: page
```