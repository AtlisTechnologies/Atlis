# Modules

Each module must include `includes/php_header.php` in its `index.php` to enforce authentication. This ensures unauthenticated users are redirected to the login page.

```php
require_once '../../includes/php_header.php';
```

# Module Structure

Each feature in Atlisware lives under `module/<name>/` and follows the pattern:

```
module/
  <name>/
    index.php         # Entry point for the module
    include/          # Front-end views routed by `index.php`
    functions/        # PHP scripts for CRUD operations
```

## index.php

* Includes `../../includes/php_header.php` and `../../includes/html_header.php`.
* Reads `$_GET['action']` and loads a matching file from `include/`.
* Defaults to `home.php` when no action is provided.

Future modules should copy this layout to maintain consistency across the project.
