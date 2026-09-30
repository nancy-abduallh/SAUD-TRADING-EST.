<?php
require_once 'auth.php';
$pageTitle = 'Clients';
$currentPage = 'clients.php';
$clients = $conn->query("SELECT * FROM clients ORDER BY sort_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - SAUD Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
  <div class="dashboard-layout">
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
      <?php include 'includes/header.php'; ?>
      <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa-solid fa-users"></i> Clients</h2>
            <button class="btn btn-primary" onclick="openModal('addClientModal')"><i class="fa-solid fa-plus"></i> Add Client</button>
        </div>

        <div class="card glass-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="clientsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($clients && $clients->num_rows > 0): ?>
                                <?php while($row = $clients->fetch_assoc()): ?>
                                    <tr data-id="<?= $row['id'] ?>">
                                        <td><i class="fa-solid fa-grip-vertical text-muted drag-handle" style="cursor: grab;"></i></td>
                                        <td>
                                            <?php if($row['logo']): ?>
                                                <img src="<?= htmlspecialchars($row['logo']) ?>" alt="Logo" style="height:40px; border-radius:4px;">
                                            <?php else: ?>
                                                <div class="placeholder-img" style="width:40px;height:40px;background:#333;border-radius:4px;"></div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($row['description'] ?? '', 0, 100, '...')) ?></td>
                                        <td>
                                            <?php if($row['status'] === 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-action edit-btn" data-client='<?= htmlspecialchars(json_encode($row), ENT_QUOTES) ?>'><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-sm btn-action toggle-btn" onclick="toggleStatus(<?= $row['id'] ?>)"><i class="fa-solid <?= $row['status'] === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i></button>
                                            <button class="btn btn-sm btn-action text-danger" onclick="deleteClient(<?= $row['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No clients found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
      <?php include 'includes/footer.php'; ?>
    </main>
  </div>

  <!-- Add/Edit Modal -->
  <div id="clientModal" class="modal">
      <div class="modal-content glass-card">
          <div class="modal-header">
              <h3 id="modalTitle">Add Client</h3>
              <span class="close" onclick="closeModal('clientModal')">&times;</span>
          </div>
          <div class="modal-body">
              <form id="clientForm">
                  <input type="hidden" name="id" id="clientId">
                  <div class="form-group">
                      <label>Name</label>
                      <input type="text" name="name" id="clientName" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label>Logo URL (or path)</label>
                      <input type="text" name="logo" id="clientLogo" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Description</label>
                      <textarea name="description" id="clientDescription" class="form-control" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                      <label>Status</label>
                      <select name="status" id="clientStatus" class="form-control">
                          <option value="active">Active</option>
                          <option value="inactive">Inactive</option>
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 mt-3">Save</button>
              </form>
          </div>
      </div>
  </div>

  <script>
      function openModal(id) {
          if(id === 'addClientModal') {
              document.getElementById('modalTitle').innerText = 'Add Client';
              document.getElementById('clientForm').reset();
              document.getElementById('clientId').value = '';
              document.getElementById('clientModal').style.display = 'block';
          } else {
              document.getElementById(id).style.display = 'block';
          }
      }
      function closeModal(id) {
          document.getElementById(id).style.display = 'none';
      }

      document.querySelectorAll('.edit-btn').forEach(btn => {
          btn.addEventListener('click', function() {
              const client = JSON.parse(this.dataset.client);
              document.getElementById('modalTitle').innerText = 'Edit Client';
              document.getElementById('clientId').value = client.id;
              document.getElementById('clientName').value = client.name;
              document.getElementById('clientLogo').value = client.logo || '';
              document.getElementById('clientDescription').value = client.description || '';
              document.getElementById('clientStatus').value = client.status;
              openModal('clientModal');
          });
      });

      document.getElementById('clientForm').addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);
          formData.append('action', 'save');
          formData.append('entity', 'clients');
          
          fetch('ajax_handler.php', {
              method: 'POST',
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if(data.success) location.reload();
              else alert(data.message || 'Error saving client');
          })
          .catch(err => alert('An error occurred.'));
      });

      function deleteClient(id) {
          if(confirm('Are you sure you want to delete this client?')) {
              const formData = new FormData();
              formData.append('action', 'delete');
              formData.append('entity', 'clients');
              formData.append('id', id);
              fetch('ajax_handler.php', {
                  method: 'POST',
                  body: formData
              })
              .then(res => res.json())
              .then(data => {
                  if(data.success) location.reload();
                  else alert(data.message || 'Error deleting');
              });
          }
      }

      function toggleStatus(id) {
          const formData = new FormData();
          formData.append('action', 'toggle_status');
          formData.append('entity', 'clients');
          formData.append('id', id);
          fetch('ajax_handler.php', {
              method: 'POST',
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if(data.success) location.reload();
              else alert(data.message || 'Error toggling status');
          });
      }
  </script>
</body>
</html>
