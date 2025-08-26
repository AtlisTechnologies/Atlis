<?php
require '../admin_header.php';
require_permission('branding','read');

// Load user.css and extract custom color tokens from Additional Custom Color Themes block
$cssPath = __DIR__ . '/../../assets/css/user.css';
$css = file_get_contents($cssPath);
$block = '';
// Capture the entire :root { ... } section following the Additional Custom Color Themes comment
if (preg_match('/\/\* ===== Additional Custom Color Themes ===== \*\/.*?(\:root\s*{[^}]*})/s', $css, $m)) {
    $block = $m[1];
}
$customColors = [];
if ($block) {
    // Match variables like --sunset: but ignore --sunset-hover
    if (preg_match_all('/--([a-z0-9]+):/i', $block, $matches)) {
        $customColors = array_unique($matches[1]);
    }
}
// Ensure the primary brand color is included
$customColors[] = 'atlis';
$customColors = array_values(array_unique($customColors));

$bootstrapColors = ['primary','secondary','success','danger','warning','info','light','dark'];
?>
<h2 class="mb-4">Branding Colors</h2>

<h3>Bootstrap Colors</h3>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
<?php foreach ($bootstrapColors as $color): 
    $label = ucfirst($color);
    $html = '<span class="badge rounded-pill badge-phoenix badge-phoenix-' . $color . '">' . $label . '</span>';
?>
  <div class="col">
    <?= $html ?>
    <button class="btn btn-sm btn-link p-0 ms-1 copy-snippet" data-snippet="<?= e($html, ENT_QUOTES) ?>" title="Copy HTML"><span class="fa-regular fa-copy"></span></button>
    <code class="d-block mt-1"><?= e($html) ?></code>
  </div>
<?php endforeach; ?>
</div>

<h3>Custom Colors</h3>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
<?php foreach ($customColors as $name):
    $label = ucfirst($name);
    $html = '<span class="badge rounded-pill badge-phoenix badge-phoenix-' . $name . '">' . $label . '</span>';
?>
  <div class="col">
    <?= $html ?>
    <button class="btn btn-sm btn-link p-0 ms-1 copy-snippet" data-snippet="<?= e($html, ENT_QUOTES) ?>" title="Copy HTML"><span class="fa-regular fa-copy"></span></button>
    <code class="d-block mt-1"><?= e($html) ?></code>
  </div>
<?php endforeach; ?>
</div>

<script>
  document.querySelectorAll('.copy-snippet').forEach(btn => {
    btn.addEventListener('click', () => {
      navigator.clipboard.writeText(btn.dataset.snippet);
    });
  });
</script>
<?php require '../admin_footer.php'; ?>
