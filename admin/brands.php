<?php
require_once 'auth.php';
$pageTitle = 'Brands';
$currentPage = 'brands.php';
$brands = $conn->query("SELECT * FROM brands ORDER BY sort_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands - SAUD TRADING EST</title>
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
                <h2>Brands</h2>
                <button id="addBrandBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Brand</button>
            </div>
            
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Website</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="brandsTableBody">
                            <?php if($brands && $brands->num_rows > 0): ?>
                                <?php while($row = $brands->fetch_assoc()): ?>
                                <tr data-id="<?php echo htmlspecialchars($row['id']); ?>">
                                    <td class="drag-handle"><i class="fas fa-grip-vertical"></i></td>
                                    <td>
                                        <?php if($row['logo_url']): ?>
                                            <img src="<?php echo htmlspecialchars($row['logo_url']); ?>" alt="Logo" width="50" height="50" style="object-fit: contain; background: #fff; border-radius: 4px; padding: 2px;">
                                        <?php else: ?>
                                            <div class="no-image"><i class="fas fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td>
                                        <?php if($row['website_url']): ?>
                                            <a href="<?php echo htmlspecialchars($row['website_url']); ?>" target="_blank" style="color: var(--accent-blue);"><i class="fas fa-external-link-alt"></i> Link</a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $row['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-icon edit-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-icon toggle-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-status="<?php echo $row['is_active'] ? '1' : '0'; ?>"><i class="fas fa-power-off"></i></button>
                                        <button class="btn btn-sm btn-icon btn-danger delete-btn" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-name="<?php echo htmlspecialchars($row['name']); ?>"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No brands found.</td>
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
<div id="brandModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="brandModalTitle">Add New Brand</h3>
            <button class="modal-close" onclick="modalManager.close('brandModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="brandForm">
                <input type="hidden" id="brandId" name="id">
                
                <div class="form-group">
                    <label for="brandName">Name</label>
                    <input type="text" id="brandName" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="brandLogoUrl">Logo URL</label>
                    <div class="input-group">
                        <input type="text" id="brandLogoUrl" name="logo_url" class="form-control">
                        <input type="file" id="brandLogo" class="d-none" accept="image/*">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('brandLogo').click()">Upload</button>
                    </div>
                    <div id="brandLogoPreview" class="image-preview mt-2" style="background: #fff; border-radius: 4px;"></div>
                </div>
                
                <div class="form-group">
                    <label for="brandWebsiteUrl">Website URL</label>
                    <input type="url" id="brandWebsiteUrl" name="website_url" class="form-control" placeholder="https://example.com">
                </div>
                
                <div class="form-group">
                    <label for="brandSortOrder">Sort Order</label>
                    <input type="number" id="brandSortOrder" name="sort_order" class="form-control" value="0">
                </div>
                
                <div class="form-actions text-right mt-4">
                    <button type="button" class="btn btn-secondary" onclick="modalManager.close('brandModal')">Cancel</button>
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
    const tableBody = document.getElementById('brandsTableBody');
    if (tableBody) {
        new Sortable(tableBody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function() {
                const ids = [...tableBody.querySelectorAll('tr')].map(r => r.dataset.id);
                api.request('api.php?entity=brands&action=update_order', 'POST', { items: ids });
            }
        });
    }
    
    // Setup image upload preview
    if(typeof setupImageUpload === 'function') {
        setupImageUpload('brandLogo', 'brandLogoPreview');
    }
    
    // Add brand button
    document.getElementById('addBrandBtn').addEventListener('click', () => {
        document.getElementById('brandForm').reset();
        document.getElementById('brandModalTitle').textContent = 'Add New Brand';
        document.getElementById('brandId').value = '';
        document.getElementById('brandLogoPreview').innerHTML = '';
        modalManager.open('brandModal');
    });
    
    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const res = await api.request('api.php?entity=brands&id=' + id, 'GET');
            if (res.success) {
                const d = res.data;
                document.getElementById('brandId').value = d.id;
                document.getElementById('brandName').value = d.name || '';
                document.getElementById('brandLogoUrl').value = d.logo_url || '';
                document.getElementById('brandWebsiteUrl').value = d.website_url || '';
                document.getElementById('brandSortOrder').value = d.sort_order || 0;
                document.getElementById('brandModalTitle').textContent = 'Edit Brand';
                
                if (d.logo_url) {
                    document.getElementById('brandLogoPreview').innerHTML = '<img src="' + d.logo_url + '" alt="Preview" style="max-width: 100%; max-height: 100px; object-fit: contain;">';
                } else {
                    document.getElementById('brandLogoPreview').innerHTML = '';
                }
                modalManager.open('brandModal');
            }
        });
    });
    
    // Form submit
    document.getElementById('brandForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('brandId').value;
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        const url = id ? 'api.php?entity=brands&id=' + id : 'api.php?entity=brands';
        const method = id ? 'PUT' : 'POST';
        const res = await api.request(url, method, data);
        if (res.success) {
            toast.success(id ? 'Brand updated!' : 'Brand created!');
            setTimeout(() => location.reload(), 1000);
        } else {
            toast.error(res.message || 'Error saving brand');
        }
    });
    
    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(typeof confirmDelete === 'function') {
                confirmDelete('brands', btn.dataset.id, btn.dataset.name);
            }
        });
    });
    
    // Toggle status
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(typeof toggleStatus === 'function') {
                toggleStatus('brands', btn.dataset.id, btn.dataset.status);
            }
        });
    });
});
</script>
</body>
</html>
