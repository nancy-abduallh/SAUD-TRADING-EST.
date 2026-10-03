<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/ui.php';

$m = modules()[$module];
$pageTitle = $m['title'];
$active = $module;

// Foreign-key lookups (config-defined tables only)
$lookups = [];
$filter = null;
$hasIcon = false;
foreach ($m['fields'] as $f) {
    if ($f['type'] === 'select' && isset($f['source'])) {
        $s = $f['source'];
        $lookups[$f['name']] = array_column(
            rows("SELECT id, `{$s['label']}` AS label FROM `{$s['table']}` ORDER BY id"), 'label', 'id');
    }
    if (!empty($f['filter'])) $filter = $f;
    if ($f['type'] === 'icon') $hasIcon = true;
}

$data = rows("SELECT * FROM `{$m['table']}` ORDER BY {$m['order']}");
$byId = [];
foreach ($data as $r) $byId[$r['id']] = $r;
$listFields = array_values(array_filter($m['fields'], fn($f) => !empty($f['list'])));

require __DIR__ . '/header.php';
?>
<div class="page-head">
  <div>
    <h2><?= e(__($m['title'])) ?></h2>
    <p class="muted"><?= count($data) ?> <?= e(__('records')) ?><?= !empty($m['sortable']) ? ' · ' . e(__('drag_reorder')) : '' ?></p>
  </div>
  <div class="actions">
    <?php if ($filter): ?>
      <select id="filterSel" class="select-sm">
        <option value=""><?= e(__('All')) ?> <?= e(__($filter['label'])) ?></option>
        <?php foreach ($lookups[$filter['name']] as $id => $label): ?>
          <option value="<?= (int)$id ?>"><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
    <?php endif; ?>
    <button class="btn btn-primary" data-add><i data-lucide="plus"></i> <?= e(__('Add')) ?> <?= e(__($m['singular'])) ?></button>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="data-table" id="dataTable">
      <thead>
        <tr>
          <?php if (!empty($m['sortable'])): ?><th class="w-s"></th><?php endif; ?>
          <th class="w-s">#</th>
          <?php foreach ($listFields as $f): ?><th><?= e(__($f['label'])) ?></th><?php endforeach; ?>
          <?php if (!empty($m['toggle'])): ?><th><?= e(__('Status')) ?></th><?php endif; ?>
          <th class="w-a"><?= e(__('Actions')) ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $r): ?>
          <tr data-id="<?= (int)$r['id'] ?>"
              data-filter="<?= e($filter ? $r[$filter['name']] : '') ?>"
              <?= !empty($m['sortable']) ? 'draggable="true"' : '' ?>>
            <?php if (!empty($m['sortable'])): ?><td class="grip"><i data-lucide="grip-vertical"></i></td><?php endif; ?>
            <td class="muted"><?= (int)$r['id'] ?></td>
            <?php foreach ($listFields as $f): ?><td><?= cell($f, $r, $lookups) ?></td><?php endforeach; ?>
            <?php if (!empty($m['toggle'])): ?>
              <td><label class="switch"><input type="checkbox" class="tg" <?= $r[$m['toggle']] ? 'checked' : '' ?>><i></i></label></td>
            <?php endif; ?>
            <td class="row-actions">
              <button class="icon-btn" data-edit title="<?= e(__('Edit')) ?>"><i data-lucide="pencil"></i></button>
              <button class="icon-btn danger" data-delete title="<?= e(__('Delete')) ?>"><i data-lucide="trash-2"></i></button>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$data): ?>
          <tr><td colspan="20" class="empty"><?= e(__('nothing_here')) ?></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal" id="formModal">
  <div class="modal-card">
    <div class="modal-head"><h3 id="modalTitle"></h3><button class="icon-btn" data-close type="button"><i data-lucide="x"></i></button></div>
    <form id="recordForm" data-action="save" data-module="<?= e($module) ?>" data-reload enctype="multipart/form-data">
      <input type="hidden" name="id" value="">
      <div class="form-grid">
        <?php foreach ($m['fields'] as $f) render_field($f, $lookups); ?>
      </div>
      <div class="modal-foot">
        <button type="button" class="btn" data-close><?= e(__('Cancel')) ?></button>
        <button type="submit" class="btn btn-primary"><?= e(__('Save')) ?></button>
      </div>
    </form>
  </div>
</div>

<?php if ($hasIcon): ?>
  <datalist id="iconList"><?php foreach (icon_list() as $i): ?><option value="<?= e($i) ?>"><?php endforeach; ?></datalist>
<?php endif; ?>

<script>
window.CRUD = {
  module: <?= json_encode($module) ?>,
  singular: <?= json_encode($m['singular']) ?>,
  singular_i18n: <?= json_encode(__($m['singular'])) ?>,
  sortable: <?= !empty($m['sortable']) ? 'true' : 'false' ?>,
  filter: <?= json_encode($filter['name'] ?? null) ?>,
  fields: <?= json_encode(array_map(fn($f) => ['name' => $f['name'], 'type' => $f['type']], $m['fields'])) ?>,
  rows: <?= json_encode($byId, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE) ?>
};
</script>
<?php require __DIR__ . '/footer.php'; ?>