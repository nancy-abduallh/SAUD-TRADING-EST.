<?php
require_once 'auth.php';
$pageTitle = 'FAQs';
$currentPage = 'faqs.php';
$faqs = $conn->query("SELECT * FROM faqs ORDER BY sort_order ASC");
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
            <h2><i class="fa-solid fa-circle-question"></i> FAQs</h2>
            <button class="btn btn-primary" onclick="openModal('addFaqModal')"><i class="fa-solid fa-plus"></i> Add FAQ</button>
        </div>

        <div class="card glass-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="faqsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($faqs && $faqs->num_rows > 0): ?>
                                <?php while($row = $faqs->fetch_assoc()): ?>
                                    <tr data-id="<?= $row['id'] ?>">
                                        <td><i class="fa-solid fa-grip-vertical text-muted drag-handle" style="cursor: grab;"></i></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($row['question'], 0, 60, '...')) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($row['answer'], 0, 80, '...')) ?></td>
                                        <td>
                                            <?php if($row['status'] === 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-action edit-btn" data-faq='<?= htmlspecialchars(json_encode($row), ENT_QUOTES) ?>'><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-sm btn-action toggle-btn" onclick="toggleStatus(<?= $row['id'] ?>)"><i class="fa-solid <?= $row['status'] === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i></button>
                                            <button class="btn btn-sm btn-action text-danger" onclick="deleteFaq(<?= $row['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No FAQs found.</td>
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
  <div id="faqModal" class="modal">
      <div class="modal-content glass-card">
          <div class="modal-header">
              <h3 id="modalTitle">Add FAQ</h3>
              <span class="close" onclick="closeModal('faqModal')">&times;</span>
          </div>
          <div class="modal-body">
              <form id="faqForm">
                  <input type="hidden" name="id" id="faqId">
                  <div class="form-group">
                      <label>Question</label>
                      <input type="text" name="question" id="fQuestion" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label>Answer</label>
                      <textarea name="answer" id="fAnswer" class="form-control" rows="5" required></textarea>
                  </div>
                  <div class="form-group">
                      <label>Status</label>
                      <select name="status" id="fStatus" class="form-control">
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
          if(id === 'addFaqModal') {
              document.getElementById('modalTitle').innerText = 'Add FAQ';
              document.getElementById('faqForm').reset();
              document.getElementById('faqId').value = '';
              document.getElementById('faqModal').style.display = 'block';
          } else {
              document.getElementById(id).style.display = 'block';
          }
      }
      function closeModal(id) {
          document.getElementById(id).style.display = 'none';
      }

      document.querySelectorAll('.edit-btn').forEach(btn => {
          btn.addEventListener('click', function() {
              const faq = JSON.parse(this.dataset.faq);
              document.getElementById('modalTitle').innerText = 'Edit FAQ';
              document.getElementById('faqId').value = faq.id;
              document.getElementById('fQuestion').value = faq.question;
              document.getElementById('fAnswer').value = faq.answer;
              document.getElementById('fStatus').value = faq.status;
              openModal('faqModal');
          });
      });

      document.getElementById('faqForm').addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);
          formData.append('action', 'save');
          formData.append('entity', 'faqs');
          
          fetch('ajax_handler.php', {
              method: 'POST',
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if(data.success) location.reload();
              else alert(data.message || 'Error saving FAQ');
          })
          .catch(err => alert('An error occurred.'));
      });

      function deleteFaq(id) {
          if(confirm('Are you sure you want to delete this FAQ?')) {
              const formData = new FormData();
              formData.append('action', 'delete');
              formData.append('entity', 'faqs');
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
          formData.append('entity', 'faqs');
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
