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

## Web server

The `includes/` and top-level `functions/` directories are not meant to be served directly. Each contains a `.htaccess` file that denies all HTTP requests. For these protections to work, the web server must allow overrides:

```
AllowOverride All
```

If your deployment environment does not support Apache `.htaccess` files, move these directories outside the web root and update any PHP include paths accordingly.
