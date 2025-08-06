# Admin Interface

The admin section hosts pages for managing global resources such as roles, lookup lists, and users.

## Permissions

Admin pages check entries in the `admin_permissions` table. User management pages depend on the following permissions seeded in `_SQL/008_admin_users.sql`:

- module `users` with actions `create`, `read`, `update`, and `delete`

These permissions are automatically granted to the default **Admin** role.
