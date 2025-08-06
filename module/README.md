# Modules

Each module must include `includes/php_header.php` in its `index.php` to enforce authentication. This ensures unauthenticated users are redirected to the login page.

```php
require_once '../../includes/php_header.php';
```
