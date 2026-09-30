<?php
// Get current page
$currentPage = basename($_SERVER['PHP_SELF']);

// Query unread messages count
$unreadCount = 0;
if (isset($conn)) {
    $unreadResult = $conn->query("SELECT COUNT(*) as cnt FROM contact_messages WHERE is_read = 0");
    if ($unreadResult && $row = $unreadResult->fetch_assoc()) {
        $unreadCount = (int)$row['cnt'];
    }
}
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <span class="logo-text">SAUD Admin</span>
        </div>
        <button class="mobile-close-btn" id="mobileCloseBtn">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="index.php" class="sidebar-link <?= $currentPage === 'index.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="hero.php" class="sidebar-link <?= $currentPage === 'hero.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-images"></i>
                    <span>Hero Slides</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="services.php" class="sidebar-link <?= $currentPage === 'services.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-concierge-bell"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="brands.php" class="sidebar-link <?= $currentPage === 'brands.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-building"></i>
                    <span>Brands</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="clients.php" class="sidebar-link <?= $currentPage === 'clients.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-users"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="testimonials.php" class="sidebar-link <?= $currentPage === 'testimonials.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-quote-right"></i>
                    <span>Testimonials</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="faqs.php" class="sidebar-link <?= $currentPage === 'faqs.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-circle-question"></i>
                    <span>FAQs</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="products.php" class="sidebar-link <?= $currentPage === 'products.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Products</span>
                </a>
            </li>
            
            <li class="nav-separator"></li>
            
            <li class="nav-item">
                <a href="messages.php" class="sidebar-link <?= $currentPage === 'messages.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Messages</span>
                    <?php if ($unreadCount > 0): ?>
                    <span class="badge badge-danger"><?= htmlspecialchars($unreadCount) ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="settings.php" class="sidebar-link <?= $currentPage === 'settings.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="sidebar-link <?= $currentPage === 'profile.php' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-circle"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <div class="sidebar-footer">
        <button class="collapse-btn" id="collapseBtn">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <div class="admin-info">
            <img src="assets/images/default-avatar.png" alt="Admin Avatar" class="admin-avatar" onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff'">
            <div class="admin-details">
                <h4 class="admin-name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin User') ?></h4>
                <p class="admin-role">Super Admin</p>
            </div>
        </div>
    </div>
</aside>
