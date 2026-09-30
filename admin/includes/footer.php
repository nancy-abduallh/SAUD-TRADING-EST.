    </section>
  </div><!-- .main -->
</div><!-- .app -->

<div class="modal" id="confirmModal">
  <div class="modal-card small">
    <div class="modal-head"><h3>Please confirm</h3></div>
    <p id="confirmText" class="confirm-text"></p>
    <div class="modal-foot">
      <button class="btn" data-close type="button">Cancel</button>
      <button class="btn btn-danger" id="confirmOk" type="button">Confirm</button>
    </div>
  </div>
</div>
<div id="toasts"></div>

<script>window.CSRF = <?= json_encode(csrf_token()) ?>;</script>
<script src="https://unpkg.com/lucide@latest"></script>
<?php if (!empty($useCharts)): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<?php endif; ?>
<script src="assets/js/dashboard.js"></script>
</body>
</html>