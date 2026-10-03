<?php
require_once __DIR__ . '/auth.php';
$pageTitle = 'Profile';
$active = 'profile';
require __DIR__ . '/includes/header.php';
?>
<div class="grid-2">
  <div class="card pad">
    <h3><?= e(__('Account')) ?></h3>
    <form data-action="update_profile" data-reload>
      <div class="form-grid">
        <div class="field"><label><?= e(__('Username')) ?></label><input name="username" value="<?= e($ADMIN['username']) ?>" required></div>
        <div class="field"><label><?= e(__('Email')) ?></label><input name="email" type="email" value="<?= e($ADMIN['email']) ?>"></div>
      </div>
      <div class="modal-foot"><button class="btn btn-primary" type="submit"><?= e(__('Save profile')) ?></button></div>
    </form>
  </div>
  <div class="card pad">
    <h3><?= e(__('Change password')) ?></h3>
    <form data-action="change_password" data-reset>
      <div class="form-grid">
        <div class="field full"><label><?= e(__('Current password')) ?></label><input name="current" type="password" autocomplete="current-password" required></div>
        <div class="field"><label><?= e(__('New password (min 8)')) ?></label><input name="new" type="password" autocomplete="new-password" required minlength="8"></div>
        <div class="field"><label><?= e(__('Confirm new password')) ?></label><input name="confirm" type="password" autocomplete="new-password" required></div>
      </div>
      <div class="modal-foot"><button class="btn btn-primary" type="submit"><?= e(__('Update password')) ?></button></div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>