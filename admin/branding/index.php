<?php
require '../admin_header.php';
require_permission('branding','read');

// Load user.css and extract custom color tokens from Additional Custom Color Themes block
$cssPath = __DIR__ . '/../../assets/css/user.css';
$css = file_get_contents($cssPath);
$block = '';
if (preg_match('/\/\* ===== Additional Custom Color Themes ===== \*\/(.*?)(?:\/\*|$)/s', $css, $m)) {
    $block = $m[1];
}
$customColors = [];
if ($block) {
    if (preg_match_all('/--([a-z0-9]+):\s*(#[0-9a-fA-F]{3,8});/i', $block, $matches)) {
        $customColors = array_combine($matches[1], $matches[2]);
    }
}

$bootstrapColors = ['primary','secondary','success','danger','warning','info','light','dark'];
$phoenixColors = ['atlis'];
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
    <button class="btn btn-sm btn-link p-0 ms-1 copy-snippet" data-snippet="<?= htmlspecialchars($html, ENT_QUOTES) ?>" title="Copy HTML"><span class="fa-regular fa-copy"></span></button>
    <code class="d-block mt-1"><?= htmlspecialchars($html) ?></code>
  </div>
<?php endforeach; ?>
</div>

<h3>Custom Colors</h3>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
<?php foreach ($customColors as $name => $hex): 
    $label = ucfirst($name);
    $html = '<span class="badge rounded-pill badge-phoenix badge-phoenix-' . $name . '">' . $label . '</span>';
?>
  <div class="col">
    <?= $html ?>
    <button class="btn btn-sm btn-link p-0 ms-1 copy-snippet" data-snippet="<?= htmlspecialchars($html, ENT_QUOTES) ?>" title="Copy HTML"><span class="fa-regular fa-copy"></span></button>
    <code class="d-block mt-1"><?= htmlspecialchars($html) ?></code>
  </div>
<?php endforeach; ?>
</div>

<h3>Phoenix Variations</h3>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 mb-5">
<?php foreach ($phoenixColors as $color): 
    $label = ucfirst($color);
    $html = '<span class="badge rounded-pill badge-phoenix badge-phoenix-' . $color . '">' . $label . '</span>';
?>
  <div class="col">
    <?= $html ?>
    <button class="btn btn-sm btn-link p-0 ms-1 copy-snippet" data-snippet="<?= htmlspecialchars($html, ENT_QUOTES) ?>" title="Copy HTML"><span class="fa-regular fa-copy"></span></button>
    <code class="d-block mt-1"><?= htmlspecialchars($html) ?></code>
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
