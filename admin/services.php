<?php
require_once 'auth.php';
$pageTitle = 'Services';
$currentPage = 'services.php';
$services = $conn->query("SELECT * FROM services ORDER BY sort_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - SAUD TRADING EST</title>
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
                <h2>Services</h2>
                <button id="addServiceBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Service</button>
            </div>
            
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Icon</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="servicesTableBody">
                            <?php if($services && $services->num_rows > 0): ?>
                                <?php while($row = $services->fetch_assoc()): ?>
                                <tr data-id="<?php echo htmlspecialchars($row['id']); ?>">
                                    <td class="drag-handle"><i class="fas fa-grip-vertical"></i></td>
                                    <td>
                                        <i class="<?php echo htmlspecialchars($row['icon_class'] ?: 'fas fa-cogs'); ?> fa-2x" style="color: var(--accent-blue);"></i>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td>
                                        <?php 
                                        $desc = htmlspecialchars($row['description']);
                                        echo strlen($desc) > 50 ? substr($desc, 0, 50) . '...' : $desc;
                                        ?>
                                    </td>
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
                                    <td colspan="6" class="text-center">No services found.</td>
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
<div id="serviceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="serviceModalTitle">Add New Service</h3>
            <button class="modal-close" onclick="modalManager.close('serviceModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="serviceForm">
                <input type="hidden" id="serviceId" name="id">
                
                <div class="form-group">
                    <label for="serviceTitle">Title</label>
                    <input type="text" id="serviceTitle" name="title" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="serviceDescription">Description</label>
                    <textarea id="serviceDescription" name="description" class="form-control" rows="4"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group col">
                        <label for="serviceIconClass">Icon Class <small>(e.g., fa-solid fa-truck)</small></label>
                        <div class="input-group">
                            <span class="input-group-text" id="iconPreview"><i class="fas fa-cogs"></i></span>
                            <input type="text" id="serviceIconClass" name="icon_class" class="form-control" placeholder="fa-solid fa-cogs">
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="serviceSortOrder">Sort Order</label>
                        <input type="number" id="serviceSortOrder" name="sort_order" class="form-control" value="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="serviceImageUrl">Image URL <small>(Optional)</small></label>
                    <input type="text" id="serviceImageUrl" name="image_url" class="form-control">
                </div>
                
                <div class="form-actions text-right mt-4">
                    <button type="button" class="btn btn-secondary" onclick="modalManager.close('serviceModal')">Cancel</button>
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
    const tableBody = document.getElementById('servicesTableBody');
    if (tableBody) {
        new Sortable(tableBody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function() {
                const ids = [...tableBody.querySelectorAll('tr')].map(r => r.dataset.id);
                api.request('api.php?entity=services&action=update_order', 'POST', { items: ids });
            }
        });
    }
    
    // Icon preview
    const iconInput = document.getElementById('serviceIconClass');
    if(iconInput) {
        iconInput.addEventListener('input', function() {
            const preview = document.getElementById('iconPreview');
            if(preview) {
                preview.innerHTML = `<i class="${this.value || 'fas fa-cogs'}"></i>`;
            }
        });
    }
    
    // Add service button
    document.getElementById('addServiceBtn').addEventListener('click', () => {
        document.getElementById('serviceForm').reset();
        document.getElementById('serviceModalTitle').textContent = 'Add New Service';
        document.getElementById('serviceId').value = '';
        if(document.getElementById('iconPreview')) {
            document.getElementById('iconPreview').innerHTML = '<i class="fas fa-cogs"></i>';
        }
        modalManager.open('serviceModal');
    });
    
    // Edit buttons
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const res = await api.request('api.php?entity=services&id=' + id, 'GET');
            if (res.success) {
                const d = res.data;
                document.getElementById('serviceId').value = d.id;
                document.getElementById('serviceTitle').value = d.title || '';
                document.getElementById('serviceDescription').value = d.description || '';
                document.getElementById('serviceIconClass').value = d.icon_class || '';
                document.getElementById('serviceImageUrl').value = d.image_url || '';
                document.getElementById('serviceSortOrder').value = d.sort_order || 0;
                
                if(document.getElementById('iconPreview')) {
                    document.getElementById('iconPreview').innerHTML = `<i class="${d.icon_class || 'fas fa-cogs'}"></i>`;
                }
                
                document.getElementById('serviceModalTitle').textContent = 'Edit Service';
                modalManager.open('serviceModal');
            }
        });
    });
    
    // Form submit
    document.getElementById('serviceForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('serviceId').value;
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        const url = id ? 'api.php?entity=services&id=' + id : 'api.php?entity=services';
        const method = id ? 'PUT' : 'POST';
        const res = await api.request(url, method, data);
        if (res.success) {
            toast.success(id ? 'Service updated!' : 'Service created!');
            setTimeout(() => location.reload(), 1000);
        } else {
            toast.error(res.message || 'Error saving service');
        }
    });
    
    // Delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(typeof confirmDelete === 'function') {
                confirmDelete('services', btn.dataset.id, btn.dataset.name);
            }
        });
    });
    
    // Toggle status
    document.querySelectorAll('.toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if(typeof toggleStatus === 'function') {
                toggleStatus('services', btn.dataset.id, btn.dataset.status);
            }
        });
    });
});
</script>
</body>
</html>
