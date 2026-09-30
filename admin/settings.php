<?php
require_once 'auth.php';
$pageTitle = 'Site Settings';
$currentPage = 'settings.php';

// Fetch settings
$settingsResult = $conn->query("SELECT * FROM site_settings");
$settings = [];
while ($row = $settingsResult->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Fetch about content
$about = $conn->query("SELECT * FROM about_content WHERE id = 1")->fetch_assoc();

// Fetch contact info
$contact = $conn->query("SELECT * FROM contact_info WHERE id = 1")->fetch_assoc();

// Fetch stats
$stats = $conn->query("SELECT * FROM stats ORDER BY sort_order ASC");
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
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; }
        .tab-btn { background: none; border: none; color: #a0a5b1; padding: 10px 20px; cursor: pointer; border-radius: 4px; transition: 0.3s; }
        .tab-btn:hover { color: #fff; background: rgba(255,255,255,0.05); }
        .tab-btn.active { background: var(--accent-blue); color: #0a0e27; font-weight: 600; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group.full { grid-column: 1 / -1; }
        .form-group label { display: block; margin-bottom: 8px; color: #fff; font-size: 0.9rem; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #fff; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--accent-blue); }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary { background: var(--accent-blue); color: #0a0e27; }
        .btn-success { background: var(--accent-teal); color: #0a0e27; }
        .card { background: var(--card-bg); border-radius: 12px; padding: 25px; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
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
        </div>

        <div class="card">
            <div class="tabs">
                <button class="tab-btn active" data-target="general">General Settings</button>
                <button class="tab-btn" data-target="about">About Content</button>
                <button class="tab-btn" data-target="contact">Contact Info</button>
                <button class="tab-btn" data-target="stats">Stats / KPIs</button>
            </div>

            <!-- GENERAL SETTINGS -->
            <div id="general" class="tab-content active">
                <form id="generalForm">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Site Name</label>
                            <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group full">
                            <label>Site Tagline</label>
                            <input type="text" name="site_tagline" value="<?= htmlspecialchars($settings['site_tagline'] ?? '') ?>">
                        </div>
                        <div class="form-group full">
                            <label>Site Description</label>
                            <textarea name="site_description" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Site Email</label>
                            <input type="email" name="site_email" value="<?= htmlspecialchars($settings['site_email'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Site Phone</label>
                            <input type="text" name="site_phone" value="<?= htmlspecialchars($settings['site_phone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="url" name="social_facebook" value="<?= htmlspecialchars($settings['social_facebook'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Twitter</label>
                            <input type="url" name="social_twitter" value="<?= htmlspecialchars($settings['social_twitter'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Instagram</label>
                            <input type="url" name="social_instagram" value="<?= htmlspecialchars($settings['social_instagram'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>LinkedIn</label>
                            <input type="url" name="social_linkedin" value="<?= htmlspecialchars($settings['social_linkedin'] ?? '') ?>">
                        </div>
                        <div class="form-group full mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save General Settings</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ABOUT CONTENT -->
            <div id="about" class="tab-content">
                <form id="aboutForm">
                    <div class="form-grid">
                        <div class="form-group full">
                            <label>About Title</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($about['title'] ?? '') ?>">
                        </div>
                        <div class="form-group full">
                            <label>Description</label>
                            <textarea name="description" rows="5"><?= htmlspecialchars($about['description'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Mission</label>
                            <textarea name="mission" rows="4"><?= htmlspecialchars($about['mission'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Vision</label>
                            <textarea name="vision" rows="4"><?= htmlspecialchars($about['vision'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group full">
                            <label>Image URL</label>
                            <input type="text" name="image_url" value="<?= htmlspecialchars($about['image_url'] ?? '') ?>">
                        </div>
                        <div class="form-group full mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save About Content</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- CONTACT INFO -->
            <div id="contact" class="tab-content">
                <form id="contactForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>Working Hours</label>
                            <input type="text" name="working_hours" value="<?= htmlspecialchars($contact['working_hours'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp</label>
                            <input type="text" name="whatsapp" value="<?= htmlspecialchars($contact['whatsapp'] ?? '') ?>">
                        </div>
                        <div class="form-group full">
                            <label>Address</label>
                            <textarea name="address" rows="3"><?= htmlspecialchars($contact['address'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group full">
                            <label>Map URL (Embed)</label>
                            <input type="text" name="map_url" value="<?= htmlspecialchars($contact['map_url'] ?? '') ?>">
                        </div>
                        <div class="form-group full mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Contact Info</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- STATS / KPIs -->
            <div id="stats" class="tab-content">
                <div class="d-flex justify-content-between mb-3">
                    <h3>Statistics</h3>
                    <button class="btn btn-success" onclick="openStatModal()"><i class="fas fa-plus"></i> Add Stat</button>
                </div>
                <div class="table-responsive">
                    <table class="table" id="statsTable">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Label</th>
                                <th>Value</th>
                                <th>Suffix</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($s = $stats->fetch_assoc()): ?>
                            <tr data-id="<?= $s['id'] ?>">
                                <td><i class="<?= htmlspecialchars($s['icon']) ?>"></i></td>
                                <td><?= htmlspecialchars($s['label']) ?></td>
                                <td><?= htmlspecialchars($s['value']) ?></td>
                                <td><?= htmlspecialchars($s['suffix']) ?></td>
                                <td>
                                    <button class="btn-icon" onclick="editStat(<?= $s['id'] ?>)"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon text-danger" onclick="deleteStat(<?= $s['id'] ?>)"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

      </div>
      <?php include 'includes/footer.php'; ?>
    </main>
  </div>

  <!-- STAT MODAL -->
  <div id="statModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="statModalTitle">Add Stat</h3>
            <span class="close" onclick="closeStatModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="statForm">
                <input type="hidden" id="stat_id" name="id">
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" id="stat_label" name="label" required>
                </div>
                <div class="form-group">
                    <label>Value</label>
                    <input type="number" id="stat_value" name="value" required>
                </div>
                <div class="form-group">
                    <label>Suffix</label>
                    <input type="text" id="stat_suffix" name="suffix" placeholder="e.g. +">
                </div>
                <div class="form-group">
                    <label>Icon (FontAwesome class)</label>
                    <input type="text" id="stat_icon" name="icon" placeholder="fas fa-user">
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" id="stat_sort" name="sort_order" value="0">
                </div>
                <div class="form-group mt-3 text-right">
                    <button type="button" class="btn btn-secondary" onclick="closeStatModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Stat</button>
                </div>
            </form>
        </div>
    </div>
  </div>

<script>
// Tabs logic
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(btn.dataset.target).classList.add('active');
    });
});

function handleFormSubmit(formId, entity) {
    document.getElementById(formId).addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        data.csrf_token = '<?= $_SESSION['csrf_token'] ?>';

        fetch(`api.php?entity=${entity}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('Saved successfully!');
            } else {
                alert('Error: ' + res.error);
            }
        })
        .catch(err => alert('An error occurred'));
    });
}

handleFormSubmit('generalForm', 'settings');
handleFormSubmit('aboutForm', 'about');
handleFormSubmit('contactForm', 'contact_info');

// Stats Logic
const statModal = document.getElementById('statModal');
function openStatModal() {
    document.getElementById('statForm').reset();
    document.getElementById('stat_id').value = '';
    document.getElementById('statModalTitle').innerText = 'Add Stat';
    statModal.style.display = 'block';
}
function closeStatModal() { statModal.style.display = 'none'; }

document.getElementById('statForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.csrf_token = '<?= $_SESSION['csrf_token'] ?>';
    const id = data.id;
    const method = id ? 'PUT' : 'POST';

    fetch(`api.php?entity=stats`, {
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

function editStat(id) {
    fetch(`api.php?entity=stats&id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('stat_id').value = data.id;
        document.getElementById('stat_label').value = data.label;
        document.getElementById('stat_value').value = data.value;
        document.getElementById('stat_suffix').value = data.suffix;
        document.getElementById('stat_icon').value = data.icon;
        document.getElementById('stat_sort').value = data.sort_order;
        document.getElementById('statModalTitle').innerText = 'Edit Stat';
        statModal.style.display = 'block';
    });
}

function deleteStat(id) {
    if(confirm('Are you sure?')) {
        fetch(`api.php?entity=stats&id=${id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ csrf_token: '<?= $_SESSION['csrf_token'] ?>' })
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) location.reload();
            else alert('Error deleting');
        });
    }
}
</script>
</body>
</html>
