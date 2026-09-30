<?php
require_once __DIR__ . '/auth.php';
$pageTitle = 'Profile';
$active = 'profile';
require __DIR__ . '/includes/header.php';
?>
<div class="grid-2">
  <div class="card pad">
    <h3>Account</h3>
    <form data-action="update_profile" data-reload>
      <div class="form-grid">
        <div class="field"><label>Username</label><input name="username" value="<?= e($ADMIN['username']) ?>" required></div>
        <div class="field"><label>Email</label><input name="email" type="email" value="<?= e($ADMIN['email']) ?>"></div>
      </div>
      <div class="modal-foot"><button class="btn btn-primary" type="submit">Save profile</button></div>
    </form>
  </div>
  <div class="card pad">
    <h3>Change password</h3>
    <form data-action="change_password" data-reset>
      <div class="form-grid">
        <div class="field full"><label>Current password</label><input name="current" type="password" autocomplete="current-password" required></div>
        <div class="field"><label>New password (min 8)</label><input name="new" type="password" autocomplete="new-password" required minlength="8"></div>
        <div class="field"><label>Confirm new password</label><input name="confirm" type="password" autocomplete="new-password" required></div>
      </div>
      <div class="modal-foot"><button class="btn btn-primary" type="submit">Update password</button></div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>