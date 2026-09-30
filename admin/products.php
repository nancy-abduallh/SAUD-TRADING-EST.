<?php
require_once 'auth.php';
$pageTitle = 'Products';
$currentPage = 'products.php';

// Fetch sectors for filter/dropdown
$sectors = $conn->query("SELECT * FROM sectors ORDER BY sort_order ASC");
$sectorsList = [];
while ($row = $sectors->fetch_assoc()) { 
    $sectorsList[] = $row; 
}

// Current filter
$sectorFilter = isset($_GET['sector']) ? (int)$_GET['sector'] : 0;
$whereClause = $sectorFilter ? "WHERE p.sector_id = $sectorFilter" : '';

$products = $conn->query("SELECT p.*, s.title as sector_name FROM products p LEFT JOIN sectors s ON p.sector_id = s.id $whereClause ORDER BY p.sort_order ASC");
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
    <style>
        .filter-bar { background: var(--card-bg); padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 15px; }
        .filter-bar select { padding: 8px 15px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #fff; }
        .thumbnail { width: 50px; height: 50px; border-radius: 6px; object-fit: cover; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; }
        .status-active { background: rgba(0, 229, 255, 0.2); color: var(--accent-teal); }
        .status-inactive { background: rgba(255, 255, 255, 0.1); color: #ccc; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; color: #fff; font-size: 0.9rem; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #fff; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: var(--accent-blue); }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: var(--accent-blue); color: #0a0e27; }
        .btn-success { background: var(--accent-teal); color: #0a0e27; }
        .btn-secondary { background: rgba(255,255,255,0.1); color: #fff; }
    </style>
</head>
<body>
  <div class="dashboard-layout">
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
      <?php include 'includes/header.php'; ?>
      <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title"><?= $pageTitle ?></h1>
            <button class="btn btn-success" onclick="openModal()"><i class="fas fa-plus"></i> Add Product</button>
        </div>

        <div class="filter-bar">
            <label>Filter by Sector:</label>
            <select id="sectorFilter" onchange="filterProducts()">
                <option value="0">All Sectors</option>
                <?php foreach($sectorsList as $sec): ?>
                    <option value="<?= $sec['id'] ?>" <?= $sectorFilter == $sec['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($sec['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table" id="productsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Sector</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($products->num_rows > 0): ?>
                            <?php while ($p = $products->fetch_assoc()): ?>
                            <tr data-id="<?= $p['id'] ?>">
                                <td><?= $p['id'] ?></td>
                                <td><img src="<?= htmlspecialchars($p['image_url'] ?? 'assets/img/placeholder.jpg') ?>" class="thumbnail" alt="Product"></td>
                                <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                                <td><?= htmlspecialchars($p['category']) ?></td>
                                <td><?= htmlspecialchars($p['sector_name'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="status-badge <?= $p['status'] == 'active' ? 'status-active' : 'status-inactive' ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-icon" onclick="editProduct(<?= $p['id'] ?>)"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon text-danger" onclick="deleteProduct(<?= $p['id'] ?>)"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No products found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

      </div>
      <?php include 'includes/footer.php'; ?>
    </main>
  </div>

  <!-- PRODUCT MODAL -->
  <div id="productModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Add Product</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="productForm">
                <input type="hidden" id="prod_id" name="id">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="prod_name" name="name" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <input type="text" id="prod_category" name="category">
                </div>
                <div class="form-group">
                    <label>Sector</label>
                    <select id="prod_sector" name="sector_id" required>
                        <option value="">Select Sector</option>
                        <?php foreach($sectorsList as $sec): ?>
                            <option value="<?= $sec['id'] ?>"><?= htmlspecialchars($sec['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="prod_description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Image URL</label>
                    <input type="text" id="prod_image" name="image_url">
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" id="prod_sort" name="sort_order" value="0">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="prod_status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group mt-3 text-right">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
  </div>

<script>
function filterProducts() {
    const sector = document.getElementById('sectorFilter').value;
    window.location.href = `products.php?sector=${sector}`;
}

const modal = document.getElementById('productModal');

function openModal() {
    document.getElementById('productForm').reset();
    document.getElementById('prod_id').value = '';
    document.getElementById('modalTitle').innerText = 'Add Product';
    modal.style.display = 'block';
}

function closeModal() {
    modal.style.display = 'none';
}

document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.csrf_token = '<?= $_SESSION['csrf_token'] ?>';
    
    const method = data.id ? 'PUT' : 'POST';
    
    fetch('api.php?entity=products', {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if(res.success) location.reload();
        else alert('Error: ' + res.error);
    });
});

function editProduct(id) {
    fetch(`api.php?entity=products&id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('prod_id').value = data.id;
        document.getElementById('prod_name').value = data.name;
        document.getElementById('prod_category').value = data.category;
        document.getElementById('prod_sector').value = data.sector_id;
        document.getElementById('prod_description').value = data.description;
        document.getElementById('prod_image').value = data.image_url;
        document.getElementById('prod_sort').value = data.sort_order;
        document.getElementById('prod_status').value = data.status;
        
        document.getElementById('modalTitle').innerText = 'Edit Product';
        modal.style.display = 'block';
    });
}

function deleteProduct(id) {
    if(confirm('Are you sure you want to delete this product?')) {
        fetch(`api.php?entity=products&id=${id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ csrf_token: '<?= $_SESSION['csrf_token'] ?>' })
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) location.reload();
            else alert('Error deleting product');
        });
    }
}
</script>
</body>
</html>
