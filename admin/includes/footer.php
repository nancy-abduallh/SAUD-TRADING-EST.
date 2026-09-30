    </main>
  </div>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
  <!-- SortableJS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
  <!-- Dashboard JS -->
  <script src="assets/js/dashboard.js"></script>
  <?php if (isset($pageScripts)): ?>
    <?= $pageScripts ?>
  <?php endif; ?>
</body>
</html>
