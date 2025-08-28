<?php
// Fetch related data
$imgStmt = $pdo->prepare('SELECT id, file_path, is_banner FROM module_conference_images WHERE conference_id=?');
$imgStmt->execute([$conference['id']]);
$images = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
$banner = null;
$gallery = [];
foreach ($images as $img) {
    if (!empty($img['is_banner'])) {
        $banner = $img;
    } else {
        $gallery[] = $img;
    }
}
$tagStmt = $pdo->prepare('SELECT tag FROM module_conference_tags WHERE conference_id=?');
$tagStmt->execute([$conference['id']]);
$tags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
$upStmt = $pdo->prepare('SELECT id,name,start_datetime,venue FROM module_conferences WHERE start_datetime > NOW() AND id <> ? ORDER BY start_datetime ASC LIMIT 5');
$upStmt->execute([$conference['id']]);
$upcoming = $upStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-4">
  <div class="card mb-4">
    <?php if ($banner): ?>
      <img src="<?= h($banner['file_path']) ?>" class="card-img-top" alt="Banner">
    <?php endif; ?>
    <div class="card-body">
      <h1 class="mb-2"><?= h($conference['name']) ?></h1>
      <?php if (!empty($conference['venue'])): ?>
        <p class="text-muted mb-2"><span class="fas fa-location-dot me-2"></span><?= h($conference['venue']) ?></p>
      <?php endif; ?>
      <p class="mb-3">
        <?php if (!empty($conference['start_datetime'])): ?>
          <?= h(date('F j, Y g:i A', strtotime($conference['start_datetime']))) ?>
          <?php if (!empty($conference['end_datetime'])): ?>
            &ndash; <?= h(date('F j, Y g:i A', strtotime($conference['end_datetime']))) ?>
          <?php endif; ?>
        <?php endif; ?>
      </p>
      <div class="mb-3">
        <button class="btn btn-primary me-2" type="button">Get Tickets</button>
        <button class="btn btn-phoenix-primary" type="button"><span class="fa-regular fa-calendar-plus me-2"></span>Add to Calendar</button>
      </div>
      <div class="mb-4"><?= nl2br(h($conference['description'] ?? '')) ?></div>
      <?php if ($gallery): ?>
        <div class="row g-2 mb-4">
          <?php foreach ($gallery as $img): ?>
            <div class="col-4"><img src="<?= h($img['file_path']) ?>" class="img-fluid rounded" alt=""></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <div class="d-flex mb-4">
        <div class="me-3">
          <p class="mb-1 text-body-secondary">Going</p>
          <h5><?= (int)$conference['going_count'] ?></h5>
        </div>
        <div class="mx-3 border-start"></div>
        <div class="mx-3">
          <p class="mb-1 text-body-secondary">Interested</p>
          <h5><?= (int)$conference['interested_count'] ?></h5>
        </div>
        <div class="mx-3 border-start"></div>
        <div class="ms-3">
          <p class="mb-1 text-body-secondary">Share</p>
          <h5><?= (int)$conference['share_count'] ?></h5>
        </div>
      </div>
      <?php if (!empty($conference['organizers'])): ?>
      <h5 class="mb-2">Organized by</h5>
      <p class="mb-4"><?= nl2br(h($conference['organizers'])) ?></p>
      <?php endif; ?>
      <div class="mb-4">
        <h5 class="mb-2">Location</h5>
        <div class="googlemap border" data-latlng="<?= h($conference['latitude'] . ',' . $conference['longitude']) ?>" style="height:300px"></div>
      </div>
      <?php if ($tags): ?>
      <div class="mb-4">
        <?php foreach ($tags as $tag): ?><span class="badge bg-secondary me-1 mb-1"><?= h($tag) ?></span><?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($conference['type'])): ?><p><strong>Type:</strong> <?= h($conference['type']) ?></p><?php endif; ?>
      <?php if (!empty($conference['topic'])): ?><p><strong>Topic:</strong> <?= h($conference['topic']) ?></p><?php endif; ?>
      <?php if (!empty($conference['mode'])): ?><p><strong>Mode:</strong> <?= h($conference['mode']) ?></p><?php endif; ?>
      <?php if (!empty($conference['organizers'])): ?><p><strong>Organizers:</strong> <?= nl2br(h($conference['organizers'])) ?></p><?php endif; ?>
      <?php if (!empty($conference['sponsors'])): ?><p><strong>Sponsors:</strong> <?= nl2br(h($conference['sponsors'])) ?></p><?php endif; ?>
      <?php if (!empty($conference['going_count']) || !empty($conference['interested_count']) || !empty($conference['share_count'])): ?>
        <p><strong>Attendees:</strong> Going <?= (int)$conference['going_count'] ?>, Interested <?= (int)$conference['interested_count'] ?>, Shares <?= (int)$conference['share_count'] ?></p>
      <?php endif; ?>
      <?php if (!empty($tags)): ?><p><strong>Tags:</strong> <?= h(implode(', ', $tags)) ?></p><?php endif; ?>
      <?php if (!empty($tickets)): ?>
        <p><strong>Ticket Options:</strong>
          <?php foreach ($tickets as $i => $t): ?>
            <?= h($t['option_name']) ?><?php if ($t['price'] !== null && $t['price'] !== ''): ?> ($<?= h($t['price']) ?>)<?php endif; ?><?php if ($i < count($tickets) - 1): ?>, <?php endif; ?>
          <?php endforeach; ?>
        </p>
      <?php endif; ?>
      <div><?= nl2br(h($conference['description'] ?? '')) ?></div>

    </div>
  </div>
  <?php if ($upcoming): ?>
    <h3 class="mb-3">Upcoming Conferences</h3>
    <?php foreach ($upcoming as $u): ?>
      <div class="border rounded p-3 mb-2">
        <a href="index.php?action=details&id=<?= (int)$u['id'] ?>" class="fw-bold"><?= h($u['name']) ?></a><br>
        <small><?= h(date('M j, Y g:i A', strtotime($u['start_datetime']))) ?><?php if (!empty($u['venue'])): ?> - <?= h($u['venue']) ?><?php endif; ?></small>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap" async defer></script>
<script>
function initMap(){
  document.querySelectorAll('.googlemap').forEach(function(el){
    var latlng = el.dataset.latlng.split(',');
    var lat = parseFloat(latlng[0]);
    var lng = parseFloat(latlng[1]);
    var map = new google.maps.Map(el,{center:{lat:lat,lng:lng},zoom:15});
    new google.maps.Marker({position:{lat:lat,lng:lng},map:map});
  });
}
</script>
