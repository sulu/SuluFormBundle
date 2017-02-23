# 1.0.0 
### Upgrade databse schema
```sql
ALTER TABLE fo_dynamics ADD type VARCHAR(255) NOT NULL, CHANGE uuid typeId VARCHAR(255) NOT NULL;
```