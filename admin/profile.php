<?php
require_once 'auth.php';
$pageTitle = 'My Profile';
$currentPage = 'profile.php';
$admin = getAdminInfo($conn);
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
        .profile-card { background: var(--card-bg); border-radius: 12px; padding: 30px; text-align: center; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.2); margin-bottom: 25px; }
        .avatar-lg { width: 100px; height: 100px; border-radius: 50%; background: var(--accent-blue); display: inline-flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #0a0e27; margin-bottom: 15px; }
        .profile-card h2 { margin: 0 0 5px; color: #fff; }
        .profile-card p { color: #a0a5b1; margin: 0; }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        @media(max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }
        
        .card { background: var(--card-bg); border-radius: 12px; padding: 25px; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
        .card h3 { margin-top: 0; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 8px; color: #fff; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 10px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: #fff; }
        .form-group input:focus { outline: none; border-color: var(--accent-blue); }
        .form-group input:disabled { opacity: 0.6; cursor: not-allowed; }
        .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; width: 100%; justify-content: center; }
        .btn-primary { background: var(--accent-blue); color: #0a0e27; }
        .btn-warning { background: var(--gold); color: #0a0e27; }
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

        <div class="profile-card">
            <div class="avatar-lg"><i class="fas fa-user-shield"></i></div>
            <h2><?= htmlspecialchars($admin['full_name']) ?></h2>
            <p><?= htmlspecialchars($admin['email']) ?> | Role: <?= htmlspecialchars(ucfirst($admin['role'])) ?></p>
            <p class="mt-2"><small>Member since: <?= date('M j, Y', strtotime($admin['created_at'])) ?></small></p>
        </div>

        <div class="grid-2">
            <!-- Update Profile Info -->
            <div class="card">
                <h3>Update Information</h3>
                <form id="profileForm">
                    <div class="form-group">
                        <label>Username (Cannot be changed)</label>
                        <input type="text" value="<?= htmlspecialchars($admin['username']) ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($admin['full_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="card">
                <h3>Change Password</h3>
                <form id="passwordForm">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" id="new_password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required minlength="6">
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Update Password</button>
                    </div>
                </form>
            </div>
        </div>

      </div>
      <?php include 'includes/footer.php'; ?>
    </main>
  </div>

<script>
// Update Profile Info
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.csrf_token = '<?= $_SESSION['csrf_token'] ?>';
    
    fetch('api.php?entity=profile&action=update_info', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if(res.success) {
            alert('Profile updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + res.error);
        }
    });
});

// Change Password
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPw = document.getElementById('new_password').value;
    const confPw = document.getElementById('confirm_password').value;
    
    if (newPw !== confPw) {
        alert("New passwords do not match!");
        return;
    }
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    data.csrf_token = '<?= $_SESSION['csrf_token'] ?>';
    
    fetch('api.php?entity=profile&action=change_password', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if(res.success) {
            alert('Password changed successfully!');
            this.reset();
        } else {
            alert('Error: ' + res.error);
        }
    });
});
</script>
</body>
</html>
