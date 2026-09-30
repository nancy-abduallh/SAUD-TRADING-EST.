<?php
require_once 'auth.php';
$pageTitle = 'Dashboard';
$currentPage = 'index.php';

// Helper function in case getCount is not available globally
if (!function_exists('getCount')) {
    function getCount($conn, $table, $condition = '') {
        $sql = "SELECT COUNT(*) as count FROM $table";
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }
        $result = $conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        return 0;
    }
}

// Fetch dashboard data
$totalServices = getCount($conn, 'services');
$totalBrands = getCount($conn, 'brands');
$totalClients = getCount($conn, 'clients');
$totalTestimonials = getCount($conn, 'testimonials');
$totalProducts = getCount($conn, 'products');
$unreadMessages = getCount($conn, 'contact_messages', 'is_read = 0');
$totalMessages = getCount($conn, 'contact_messages');
$totalSectors = getCount($conn, 'sectors');
$totalFaqs = getCount($conn, 'faqs');

$totalContent = $totalServices + $totalBrands + $totalClients + $totalProducts;

// Fetch recent messages
$recentMessages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");

// Fetch recent activity (Assuming activity_log exists, ignore errors if it doesn't)
$recentActivity = null;
if ($conn->query("SHOW TABLES LIKE 'activity_log'")->num_rows > 0) {
    $recentActivity = $conn->query("SELECT al.*, a.username FROM activity_log al LEFT JOIN admins a ON al.admin_id = a.id ORDER BY al.created_at DESC LIMIT 10");
}

// Monthly messages data for chart
$monthlyMessages = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM contact_messages GROUP BY month ORDER BY month DESC LIMIT 12");
$monthlyData = [];
if ($monthlyMessages) {
    while ($row = $monthlyMessages->fetch_assoc()) { 
        $monthlyData[] = $row; 
    }
    $monthlyData = array_reverse($monthlyData);
}

// Content distribution for doughnut chart
$contentDist = [
    ['label' => 'Services', 'count' => $totalServices],
    ['label' => 'Brands', 'count' => $totalBrands],
    ['label' => 'Clients', 'count' => $totalClients],
    ['label' => 'Products', 'count' => $totalProducts],
    ['label' => 'Testimonials', 'count' => $totalTestimonials],
    ['label' => 'FAQs', 'count' => $totalFaqs],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | SAUD-TRADING-EST Admin</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/dashboard.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="dashboard-layout">
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
        <?php include 'includes/header.php'; ?>
        <div class="content-area">
            
            <!-- KPI Cards Section -->
            <div class="kpi-grid">
                <div class="kpi-card kpi-card--blue">
                    <div class="kpi-icon"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="kpi-info">
                        <div class="kpi-value" data-count="<?= $totalContent ?>">0</div>
                        <div class="kpi-label">Total Content</div>
                    </div>
                    <div class="kpi-trend kpi-trend--up"><i class="fa-solid fa-arrow-up"></i> Active</div>
                </div>

                <div class="kpi-card kpi-card--teal">
                    <div class="kpi-icon"><i class="fa-solid fa-chart-pie"></i></div>
                    <div class="kpi-info">
                        <div class="kpi-value" data-count="<?= $totalSectors ?>">0</div>
                        <div class="kpi-label">Active Sectors</div>
                    </div>
                    <div class="kpi-trend kpi-trend--up"><i class="fa-solid fa-arrow-up"></i> Active</div>
                </div>

                <div class="kpi-card kpi-card--purple">
                    <div class="kpi-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="kpi-info">
                        <div class="kpi-value" data-count="<?= $totalMessages ?>">0</div>
                        <div class="kpi-label">Messages <?php if($unreadMessages > 0): ?><span class="badge badge-unread"><?= $unreadMessages ?> New</span><?php endif; ?></div>
                    </div>
                    <div class="kpi-trend kpi-trend--up"><i class="fa-solid fa-arrow-up"></i> Active</div>
                </div>

                <div class="kpi-card kpi-card--gold">
                    <div class="kpi-icon"><i class="fa-solid fa-star"></i></div>
                    <div class="kpi-info">
                        <div class="kpi-value" data-count="<?= $totalTestimonials ?>">0</div>
                        <div class="kpi-label">Testimonials</div>
                    </div>
                    <div class="kpi-trend kpi-trend--up"><i class="fa-solid fa-arrow-up"></i> Active</div>
                </div>
            </div>

            <!-- Quick Actions Panel -->
            <div class="quick-actions-panel" style="margin-bottom: 2rem;">
                <h3>Quick Actions</h3>
                <div class="quick-actions-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <a href="heroes.php?action=add" class="quick-action-card" style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; text-align: center; color: var(--text-color); text-decoration: none; display: block; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-images" style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #4fc3f7;"></i>
                        <span style="display: block; font-size: 0.875rem;">Add Hero Slide</span>
                    </a>
                    <a href="services.php?action=add" class="quick-action-card" style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; text-align: center; color: var(--text-color); text-decoration: none; display: block; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-briefcase" style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #00e5ff;"></i>
                        <span style="display: block; font-size: 0.875rem;">Add Service</span>
                    </a>
                    <a href="brands.php?action=add" class="quick-action-card" style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; text-align: center; color: var(--text-color); text-decoration: none; display: block; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-tags" style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #7c4dff;"></i>
                        <span style="display: block; font-size: 0.875rem;">Add Brand</span>
                    </a>
                    <a href="messages.php" class="quick-action-card" style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; text-align: center; color: var(--text-color); text-decoration: none; display: block; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-inbox" style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #ffd740;"></i>
                        <span style="display: block; font-size: 0.875rem;">View Messages</span>
                    </a>
                    <a href="settings.php" class="quick-action-card" style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; text-align: center; color: var(--text-color); text-decoration: none; display: block; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-gear" style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #ff5252;"></i>
                        <span style="display: block; font-size: 0.875rem;">Site Settings</span>
                    </a>
                    <a href="../" target="_blank" class="quick-action-card" style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; text-align: center; color: var(--text-color); text-decoration: none; display: block; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-globe" style="font-size: 1.5rem; margin-bottom: 0.5rem; color: #69f0ae;"></i>
                        <span style="display: block; font-size: 0.875rem;">View Site</span>
                    </a>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="chart-grid">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Messages Trend</h3>
                        <select class="chart-period">
                            <option value="12m">Last 12 Months</option>
                            <option value="6m">Last 6 Months</option>
                        </select>
                    </div>
                    <div class="chart-body">
                        <canvas id="messagesChart"></canvas>
                    </div>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Content Distribution</h3>
                    </div>
                    <div class="chart-body">
                        <canvas id="contentChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Bottom Row -->
            <div class="bottom-row-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
                <div class="recent-messages-panel panel" style="background: rgba(30, 41, 59, 0.7); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 1.5rem;">
                    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="margin: 0; font-size: 1.1rem; color: #e2e8f0;">Recent Messages</h3>
                        <a href="messages.php" class="btn btn-sm btn-outline" style="text-decoration: none; font-size: 0.875rem; color: #4fc3f7; border: 1px solid #4fc3f7; padding: 0.25rem 0.5rem; border-radius: 4px;">View All</a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table" style="width: 100%; border-collapse: collapse; text-align: left; color: #94a3b8;">
                                <thead>
                                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                        <th style="padding: 0.75rem 0.5rem; font-weight: 500;">Sender</th>
                                        <th style="padding: 0.75rem 0.5rem; font-weight: 500;">Email</th>
                                        <th style="padding: 0.75rem 0.5rem; font-weight: 500;">Subject</th>
                                        <th style="padding: 0.75rem 0.5rem; font-weight: 500;">Date</th>
                                        <th style="padding: 0.75rem 0.5rem; font-weight: 500;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($recentMessages && $recentMessages->num_rows > 0): ?>
                                        <?php while($msg = $recentMessages->fetch_assoc()): ?>
                                            <tr onclick="window.location='messages.php?id=<?= $msg['id'] ?>'" style="cursor:pointer; border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.3s;">
                                                <td style="padding: 0.75rem 0.5rem;"><?= htmlspecialchars($msg['name']) ?></td>
                                                <td style="padding: 0.75rem 0.5rem;"><?= htmlspecialchars($msg['email']) ?></td>
                                                <td style="padding: 0.75rem 0.5rem;"><?= htmlspecialchars($msg['subject']) ?></td>
                                                <td style="padding: 0.75rem 0.5rem;"><?= date('M d, Y', strtotime($msg['created_at'])) ?></td>
                                                <td style="padding: 0.75rem 0.5rem;">
                                                    <?php if($msg['is_read'] == 0): ?>
                                                        <span class="badge badge-unread" style="background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem;">Unread</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-read" style="background: rgba(34, 197, 94, 0.2); color: #22c55e; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem;">Read</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center" style="padding: 1rem; text-align: center;">No recent messages</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="activity-feed-panel panel" style="background: rgba(30, 41, 59, 0.7); border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1); padding: 1.5rem;">
                    <div class="panel-header" style="margin-bottom: 1rem;">
                        <h3 style="margin: 0; font-size: 1.1rem; color: #e2e8f0;">Recent Activity</h3>
                    </div>
                    <div class="panel-body">
                        <div class="activity-feed" style="position: relative; padding-left: 1.5rem;">
                            <?php if($recentActivity && $recentActivity->num_rows > 0): ?>
                                <?php while($log = $recentActivity->fetch_assoc()): ?>
                                    <div class="activity-item" style="position: relative; padding-bottom: 1rem;">
                                        <div class="activity-icon" style="position: absolute; left: -1.5rem; top: 0; color: #7c4dff; background: #0f172a; border-radius: 50%;">
                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-text" style="color: #cbd5e1; font-size: 0.9rem;">
                                                <strong style="color: #e2e8f0;"><?= htmlspecialchars($log['username'] ?? 'System') ?></strong> <?= htmlspecialchars($log['action']) ?>
                                            </div>
                                            <div class="activity-time" style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem;">
                                                <?= date('M d, Y H:i', strtotime($log['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <div class="activity-text" style="color: #94a3b8; font-size: 0.9rem;">No recent activity</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $pageScripts = '
            <script>
            const monthlyLabels = ' . json_encode(array_column($monthlyData, 'month')) . ';
            const monthlyValues = ' . json_encode(array_map("intval", array_column($monthlyData, 'count'))) . ';
            const contentLabels = ' . json_encode(array_column($contentDist, 'label')) . ';
            const contentValues = ' . json_encode(array_column($contentDist, 'count')) . ';

            function animateCounters() {
                const counters = document.querySelectorAll(".kpi-value");
                counters.forEach(counter => {
                    const target = +counter.getAttribute("data-count");
                    const duration = 1000;
                    const step = target / (duration / 16);
                    
                    let current = 0;
                    const updateCounter = () => {
                        current += step;
                        if(current < target) {
                            counter.innerText = Math.ceil(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCounter();
                });
            }

            function initDashboardCharts(mLabels, mValues, cLabels, cValues) {
                // Messages Chart
                const msgCtx = document.getElementById("messagesChart");
                if (msgCtx) {
                    new Chart(msgCtx, {
                        type: "line",
                        data: {
                            labels: mLabels,
                            datasets: [{
                                label: "Messages",
                                data: mValues,
                                borderColor: "#4fc3f7",
                                backgroundColor: "rgba(79, 195, 247, 0.1)",
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: { beginAtZero: true, grid: { color: "rgba(255, 255, 255, 0.1)" }, ticks: { color: "#94a3b8" } },
                                x: { grid: { color: "rgba(255, 255, 255, 0.1)" }, ticks: { color: "#94a3b8" } }
                            }
                        }
                    });
                }

                // Content Chart
                const contentCtx = document.getElementById("contentChart");
                if (contentCtx) {
                    new Chart(contentCtx, {
                        type: "doughnut",
                        data: {
                            labels: cLabels,
                            datasets: [{
                                data: cValues,
                                backgroundColor: [
                                    "#4fc3f7", "#00e5ff", "#7c4dff", "#ffd740", "#ff5252", "#69f0ae"
                                ],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: "right", labels: { color: "#e2e8f0" } }
                            }
                        }
                    });
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                initDashboardCharts(monthlyLabels, monthlyValues, contentLabels, contentValues);
                animateCounters();
            });
            </script>';
            ?>

        </div>
        <?php include 'includes/footer.php'; ?>
    </main>
</div>
</body>
</html>
