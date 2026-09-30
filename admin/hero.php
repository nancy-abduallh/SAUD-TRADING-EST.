<?php
require_once 'auth.php';
$pageTitle = 'Hero Slides';
$currentPage = 'hero.php';
$slides = $conn->query("SELECT * FROM hero_slides ORDER BY sort_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Slides - SAUD TRADING EST</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>
<body>
<div class="dashboard-layout">
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
        <?php include 'includes/header.php'; ?>
        <div class="content-area">
            <div class="page-header">
                <h2>Hero Slides</h2>
                <button id="addSlideBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Slide</button>
            </div>
            
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="slidesTableBody">
                            <?php if($slides && $slides->num_rows > 0): ?>
                                <?php while($row = $slides->fetch_assoc()): ?>
                                <tr data-id="<?php echo htmlspecialchars($row['id']); ?>">
                                    <td class="drag-handle"><i class="fas fa-grip-vertical"></i></td>
                                    <td>
                                        <?php if($row['image_url']): ?>
                                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Thumbnail" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                        <?php else: ?>
                                            <div class="no-image"><i class="fas fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subtitle']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sort_order']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $row['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-icon edit-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon toggle-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-status="<?php echo $row['is_active'] ? '1' : '0'; ?>"><i class="fas fa-power-off"></i></button>
                                        <button class="btn btn-sm btn-icon btn-danger delete-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-name="<?php echo htmlspecialchars($row['title']); ?>"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No slides found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Modal -->
<div id="slideModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="slideModalTitle">Add New Slide</h3>
            <button class="modal-close" onclick="modalManager.close('slideModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="slideForm">
                <input type="hidden" id="slideId" name="id">
                
                <div class="form-group">
                    <label for="slideTitle">Title</label>
                    <input type="text" id="slideTitle" name="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="slideSubtitle">Subtitle</label>
                    <input type="text" id="slideSubtitle" name="subtitle" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="slideDescription">Description</label>
                    <textarea id="slideDescription" name="description" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="slideImageUrl">Image URL</label>
                    <div class="input-group">
                        <input type="text" id="slideImageUrl" name="image_url" class="form-control">
                        <input type="file" id="slideImage" class="d-none" accept="image/*">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('slideImage').click()">Upload</button>
                    </div>
                    <div id="slideImagePreview" class="image-preview mt-2"></div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col">
                        <label for="slideCtaText">CTA Text</label>
                        <input type="text" id="slideCtaText" name="cta_text" class="form-control">
                    </div>
                    <div class="form-group col">
                        <label for="slideCtaLink">CTA Link</label>
                        <input type="text" id="slideCtaLink" name="cta_link" class="form-control">
                    </div>
                </div>
                
                <div class="form-actions text-right mt-4">
                    <button type="button" class="btn btn-secondary" onclick="modalManager.close('slideModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content modal-sm">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button class="modal-close" onclick="modalManager.close('deleteModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong id="deleteItemName"></strong>?</p>
            <p class="text-danger"><small>This action cannot be undone.</small></p>
            
            <div class="form-actions text-right mt-4">
                <button class="btn btn-secondary" onclick="modalManager.close('deleteModal')">Cancel</button>
                <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/api.js"></script>
<script src="assets/js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup sortable
    const tableBody = document.getElementById('slidesTableBody');
    if (tableBody) {
        new Sortable(tableBody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function() {
                const ids = [...tableBody.querySelectorAll('tr')].map(r => r.dataset.id);
                api.request('api.php?entity=hero_slides&action=update_order', 'POST', { items: ids });
            }
        });
    }
    
    // Setup image upload preview
    if(typeof setupImageUpload === 'function') {
        setupImageUpload('slideImage', 'slideImagePreview');
    }
    
    // Add slide button
    document.getElementById('addSlideBtn').addEventListener('click', () => {
        document.getElementById('slideForm').reset();
        document.getElementById('slideModalTitle').textContent = 'Add New Slide';
        document.getElementById('slideId').value = '';
        document.getElementById('slideImagePreview').innerHTML = '';
        modalManager.open('slideModal');
    });
    
    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const res = await api.request('api.php?entity=hero_slides&id=' + id, 'GET');
            if (res.success) {
                const d = res.data;
                document.getElementById('slideId').value = d.id;
                document.getElementById('slideTitle').value = d.title || '';
                document.getElementById('slideSubtitle').value = d.subtitle || '';
                document.getElementById('slideDescription').value = d.description || '';
                document.getElementById('slideImageUrl').value = d.image_url || '';
                document.getElementById('slideCtaText').value = d.cta_text || '';
                document.getElementById('slideCtaLink').value = d.cta_link || '';
                document.getElementById('slideModalTitle').textContent = 'Edit Slide';
                if (d.image_url) {
                    document.getElementById('slideImagePreview').innerHTML = '<img src="' + d.image_url + '" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 4px;">';
                } else {
                    document.getElementById('slideImagePreview').innerHTML = '';
                }
                modalManager.open('slideModal');
            }
        });
    });
    
    // Form submit
    document.getElementById('slideForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('slideId').value;
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        const url = id ? 'api.php?entity=hero_slides&id=' + id : 'api.php?entity=hero_slides';
        const method = id ? 'PUT' : 'POST';
        const res = await api.request(url, method, data);
        if (res.success) {
            toast.success(id ? 'Slide updated!' : 'Slide created!');
            setTimeout(() => location.reload(), 1000);
        } else {
            toast.error(res.message || 'Error saving slide');
        }
    });
    
    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(typeof confirmDelete === 'function') {
                confirmDelete('hero_slides', btn.dataset.id, btn.dataset.name);
            }
        });
    });
    
    // Toggle status
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(typeof toggleStatus === 'function') {
                toggleStatus('hero_slides', btn.dataset.id, btn.dataset.status);
            }
        });
    });
});
</script>
</body>
</html>
