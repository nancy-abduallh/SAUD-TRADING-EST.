    </section>
  </div><!-- .main -->
</div><!-- .app -->

<div class="modal" id="confirmModal">
  <div class="modal-card small">
    <div class="modal-head"><h3><?= e(__('Please confirm')) ?></h3></div>
    <p id="confirmText" class="confirm-text"></p>
    <div class="modal-foot">
      <button class="btn" data-close type="button"><?= e(__('Cancel')) ?></button>
      <button class="btn btn-danger" id="confirmOk" type="button"><?= e(__('Confirm')) ?></button>
    </div>
  </div>
</div>
<div id="toasts"></div>

<script>
window.CSRF = <?= json_encode(csrf_token()) ?>;
window.I18N = {
  add: <?= json_encode(__('Add')) ?>,
  edit: <?= json_encode(__('Edit')) ?>,
  delete_confirm: <?= json_encode(__('delete_confirm')) ?>,
  enabled: <?= json_encode(__('Active')) ?>,
  disabled: <?= json_encode(__('inactive', 'Inactive')) ?>,
  saved: <?= json_encode(__('Saved')) ?>,
  network_error: <?= json_encode(__('network_error', 'Network error')) ?>,
  something_wrong: <?= json_encode(__('something_wrong', 'Something went wrong')) ?>
};
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<?php if (!empty($useCharts)): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<?php endif; ?>
<script src="assets/js/dashboard.js?v=<?= filemtime(__DIR__ . '/../assets/js/dashboard.js') ?>"></script>
</body>
</html>