# CSRF Protection in Modules

All module endpoints must protect against Cross-Site Request Forgery.

- Include `includes/helpers.php` to gain access to CSRF helpers.
- In views, add `<?= csrf_field(); ?>` inside every `<form>` to emit a hidden `csrf_token` field.
- For JavaScript requests, read the token using `csrf_token()` in PHP and send it with your AJAX payload.
- Server-side scripts under `module/*/functions/` must verify the token before doing any work:

```php
if (!verify_csrf_token($_POST['csrf_token'] ?? $_GET['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Forbidden');
}
```

Follow this pattern for all new module endpoints.
