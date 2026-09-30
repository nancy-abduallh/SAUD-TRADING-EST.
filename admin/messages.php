<?php
require_once __DIR__ . '/auth.php';
$pageTitle = 'Messages';
$active = 'messages';

$msgs = rows('SELECT * FROM contact_messages ORDER BY created_at DESC, id DESC');
$byId = [];
foreach ($msgs as $r) $byId[$r['id']] = $r;

require __DIR__ . '/includes/header.php';
?>
<div class="page-head">
  <div><h2>Contact messages</h2><p class="muted"><?= count($msgs) ?> total · click a row to read</p></div>
  <div class="tabs">
    <button class="active" data-tab="all">All</button>
    <button data-tab="unread">Unread</button>
    <button data-tab="read">Read</button>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="data-table" id="dataTable">
      <thead><tr><th class="w-s"></th><th>From</th><th>Subject</th><th>Email</th><th>Received</th></tr></thead>
      <tbody>
      <?php foreach ($msgs as $r): ?>
        <tr data-msg="<?= (int)$r['id'] ?>" data-read="<?= (int)$r['is_read'] ?>" class="clickable<?= $r['is_read'] ? '' : ' unread' ?>">
          <td><span class="unread-dot"></span></td>
          <td dir="auto"><?= e($r['name']) ?></td>
          <td dir="auto"><?= e(mb_strimwidth($r['subject'] ?: '(no subject)', 0, 60, '…')) ?></td>
          <td><?= e($r['email']) ?></td>
          <td class="muted"><?= e($r['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$msgs): ?><tr><td colspan="5" class="empty">No messages yet. Messages sent through public_api.php (POST) appear here.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal" id="msgModal">
  <div class="modal-card">
    <div class="modal-head"><h3 id="mSubject"></h3><button class="icon-btn" data-close type="button"><i data-lucide="x"></i></button></div>
    <div class="msg-meta">
      <div><b id="mName" dir="auto"></b> · <span id="mEmail"></span> · <span id="mPhone"></span></div>
      <div class="muted" id="mDate"></div>
    </div>
    <div class="msg-body" id="mBody" dir="auto"></div>
    <div class="modal-foot">
      <button class="btn btn-danger" id="mDelete" type="button"><i data-lucide="trash-2"></i> Delete</button>
      <button class="btn" id="mUnread" type="button">Mark unread</button>
      <a class="btn btn-primary" id="mReply" href="#"><i data-lucide="reply"></i> Reply by email</a>
    </div>
  </div>
</div>

<script>
window.MSGS = <?= json_encode($byId, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE) ?>;
</script>
<?php require __DIR__ . '/includes/footer.php'; ?>