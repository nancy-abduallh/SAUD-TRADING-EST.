<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/includes/ui.php';
$pageTitle = 'Settings';
$active = 'settings';

$groups = settings_groups();
$vals = [
    'contact' => row('SELECT * FROM contact_info WHERE id = 1') ?: [],
    'about' => row('SELECT * FROM about_content WHERE id = 1') ?: [],
    'general' => array_column(rows('SELECT setting_key, setting_value FROM site_settings'), 'setting_value', 'setting_key'),
];

require __DIR__ . '/includes/header.php';
?>
<div class="page-head">
  <div><h2>Site settings</h2><p class="muted">Contact details, about / vision and social links</p></div>
  <div class="tabs">
    <?php $first = true; foreach ($groups as $key => $g): ?>
      <button class="<?= $first ? 'active' : '' ?>" data-pane="pane-<?= e($key) ?>"><?= e($g['title']) ?></button>
    <?php $first = false; endforeach; ?>
  </div>
</div>

<?php $first = true; foreach ($groups as $key => $g): ?>
  <div class="card pad pane<?= $first ? ' active' : '' ?>" id="pane-<?= e($key) ?>">
    <form data-action="save_settings" data-group="<?= e($key) ?>" enctype="multipart/form-data">
      <div class="form-grid">
        <?php foreach ($g['fields'] as $f) render_field($f, [], $vals[$key][$f['name']] ?? ''); ?>
      </div>
      <div class="modal-foot"><button class="btn btn-primary" type="submit">Save <?= e($g['title']) ?></button></div>
    </form>
  </div>
<?php $first = false; endforeach; ?>

<div class="card pad mt">
  <h3>Managed on their own pages</h3>
  <div class="quick">
    <a class="btn" href="stats.php"><i data-lucide="trending-up"></i> Stats / KPIs</a>
    <a class="btn" href="countries.php"><i data-lucide="globe"></i> Countries</a>
    <a class="btn" href="values.php"><i data-lucide="sparkles"></i> Values</a>
    <a class="btn" href="ecosystem.php"><i data-lucide="bot"></i> Digital ecosystem</a>
    <a class="btn" href="comparison.php"><i data-lucide="table"></i> Comparison</a>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>