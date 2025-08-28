# Environment Configuration

Atlisware reads its database settings from environment variables or an optional `.env` file at the project root.

## Setup

1. Copy `.env.example` to `.env` and update the values for your environment.
2. The `.env` file is ignored by Git; do not commit it.
3. In production, set the variables in the server's environment instead of using a `.env` file.

### Required variables

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`

## Database user

Use `_SQL/create_atlis_user.sql` to provision a dedicated MySQL user with only the privileges needed by Atlisware:

```sql
SOURCE _SQL/create_atlis_user.sql;
```

Replace `change_this_password` with a strong password before running the script.
