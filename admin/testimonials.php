<?php
require_once 'auth.php';
$pageTitle = 'Testimonials';
$currentPage = 'testimonials.php';
$testimonials = $conn->query("SELECT * FROM testimonials ORDER BY created_at DESC");
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
            <h2><i class="fa-solid fa-comment-dots"></i> Testimonials</h2>
            <button class="btn btn-primary" onclick="openModal('addTestimonialModal')"><i class="fa-solid fa-plus"></i> Add Testimonial</button>
        </div>

        <div class="card glass-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="testimonialsTable">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Client Name</th>
                                <th>Position</th>
                                <th>Company</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($testimonials && $testimonials->num_rows > 0): ?>
                                <?php while($row = $testimonials->fetch_assoc()): ?>
                                    <tr data-id="<?= $row['id'] ?>">
                                        <td>
                                            <?php if($row['avatar']): ?>
                                                <img src="<?= htmlspecialchars($row['avatar']) ?>" alt="Avatar" style="width:40px; height:40px; border-radius:50%; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="placeholder-img" style="width:40px;height:40px;background:#333;border-radius:50%;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-user"></i></div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['client_name']) ?></td>
                                        <td><?= htmlspecialchars($row['position'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['company'] ?? '-') ?></td>
                                        <td>
                                            <?php
                                            $rating = (int)($row['rating'] ?? 5);
                                            for($i = 1; $i <= 5; $i++) {
                                                echo $i <= $rating ? '<i class="fa-solid fa-star text-warning"></i>' : '<i class="fa-regular fa-star text-muted"></i>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($row['status'] === 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-action edit-btn" data-testimonial='<?= htmlspecialchars(json_encode($row), ENT_QUOTES) ?>'><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn btn-sm btn-action toggle-btn" onclick="toggleStatus(<?= $row['id'] ?>)"><i class="fa-solid <?= $row['status'] === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i></button>
                                            <button class="btn btn-sm btn-action text-danger" onclick="deleteTestimonial(<?= $row['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No testimonials found.</td>
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
  <div id="testimonialModal" class="modal">
      <div class="modal-content glass-card">
          <div class="modal-header">
              <h3 id="modalTitle">Add Testimonial</h3>
              <span class="close" onclick="closeModal('testimonialModal')">&times;</span>
          </div>
          <div class="modal-body">
              <form id="testimonialForm">
                  <input type="hidden" name="id" id="testimonialId">
                  <div class="form-group">
                      <label>Client Name</label>
                      <input type="text" name="client_name" id="tClientName" class="form-control" required>
                  </div>
                  <div class="form-group">
                      <label>Position</label>
                      <input type="text" name="position" id="tPosition" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Company</label>
                      <input type="text" name="company" id="tCompany" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Avatar URL</label>
                      <input type="text" name="avatar" id="tAvatar" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Rating</label>
                      <select name="rating" id="tRating" class="form-control">
                          <option value="5">5 - Excellent</option>
                          <option value="4">4 - Good</option>
                          <option value="3">3 - Average</option>
                          <option value="2">2 - Poor</option>
                          <option value="1">1 - Terrible</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Content</label>
                      <textarea name="content" id="tContent" class="form-control" rows="4" required></textarea>
                  </div>
                  <div class="form-group">
                      <label>Status</label>
                      <select name="status" id="tStatus" class="form-control">
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
          if(id === 'addTestimonialModal') {
              document.getElementById('modalTitle').innerText = 'Add Testimonial';
              document.getElementById('testimonialForm').reset();
              document.getElementById('testimonialId').value = '';
              document.getElementById('testimonialModal').style.display = 'block';
          } else {
              document.getElementById(id).style.display = 'block';
          }
      }
      function closeModal(id) {
          document.getElementById(id).style.display = 'none';
      }

      document.querySelectorAll('.edit-btn').forEach(btn => {
          btn.addEventListener('click', function() {
              const t = JSON.parse(this.dataset.testimonial);
              document.getElementById('modalTitle').innerText = 'Edit Testimonial';
              document.getElementById('testimonialId').value = t.id;
              document.getElementById('tClientName').value = t.client_name;
              document.getElementById('tPosition').value = t.position || '';
              document.getElementById('tCompany').value = t.company || '';
              document.getElementById('tAvatar').value = t.avatar || '';
              document.getElementById('tRating').value = t.rating || '5';
              document.getElementById('tContent').value = t.content || '';
              document.getElementById('tStatus').value = t.status;
              openModal('testimonialModal');
          });
      });

      document.getElementById('testimonialForm').addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(this);
          formData.append('action', 'save');
          formData.append('entity', 'testimonials');
          
          fetch('ajax_handler.php', {
              method: 'POST',
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if(data.success) location.reload();
              else alert(data.message || 'Error saving testimonial');
          })
          .catch(err => alert('An error occurred.'));
      });

      function deleteTestimonial(id) {
          if(confirm('Are you sure you want to delete this testimonial?')) {
              const formData = new FormData();
              formData.append('action', 'delete');
              formData.append('entity', 'testimonials');
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
          formData.append('entity', 'testimonials');
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
