<?php
// Default title if not set
$pageTitle = $pageTitle ?? 'Dashboard';

// Query unread messages count for header (if not already done in sidebar)
$unreadCountHeader = $unreadCount ?? 0;
?>
<header class="top-header">
    <div class="header-left">
        <button class="mobile-toggle-btn" id="mobileToggleBtn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="page-info">
            <h1 class="page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <nav class="breadcrumb">
                <a href="index.php">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span><?= htmlspecialchars($pageTitle) ?></span>
            </nav>
        </div>
    </div>
    
    <div class="header-right">
        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search...">
        </div>
        
        <div class="header-actions">
            <div class="notification-wrapper">
                <a href="messages.php" class="notification-btn">
                    <i class="fa-regular fa-bell"></i>
                    <?php if ($unreadCountHeader > 0): ?>
                    <span class="notification-dot pulse"></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <div class="profile-dropdown-wrapper">
                <button class="profile-btn" id="profileDropdownBtn">
                    <img src="assets/images/default-avatar.png" alt="Profile" class="profile-avatar" onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff'">
                    <span class="profile-name"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="profile-dropdown-menu" id="profileDropdownMenu">
                    <a href="profile.php" class="dropdown-item">
                        <i class="fa-solid fa-user"></i> My Profile
                    </a>
                    <a href="settings.php" class="dropdown-item">
                        <i class="fa-solid fa-gear"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item text-danger">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
