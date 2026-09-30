<?php
require_once 'auth.php';
$pageTitle = 'Messages';
$currentPage = 'messages.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 15;
$offset = ($page - 1) * $perPage;

// Filter
$filter = $_GET['filter'] ?? 'all';
$whereClause = '';
if ($filter === 'unread') $whereClause = 'WHERE is_read = 0';
elseif ($filter === 'read') $whereClause = 'WHERE is_read = 1';

// Search
$search = $_GET['search'] ?? '';
if ($search) {
    $searchEsc = $conn->real_escape_string($search);
    $whereClause .= ($whereClause ? ' AND' : 'WHERE') . " (name LIKE '%$searchEsc%' OR email LIKE '%$searchEsc%' OR subject LIKE '%$searchEsc%')";
}

$totalMessages = $conn->query("SELECT COUNT(*) as cnt FROM contact_messages $whereClause")->fetch_assoc()['cnt'];
$totalPages = ceil($totalMessages / $perPage);
$messages = $conn->query("SELECT * FROM contact_messages $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$unreadCount = $conn->query("SELECT COUNT(*) as cnt FROM contact_messages WHERE is_read = 0")->fetch_assoc()['cnt'];
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
        .unread-row {
            background-color: rgba(79, 195, 247, 0.05);
            border-left: 4px solid #4fc3f7;
            font-weight: 600;
        }
        .filter-tabs .btn {
            margin-right: 5px;
        }
        .filter-tabs .active {
            background: #4fc3f7;
            color: #0a0e27;
        }
        .stats-bar .badge {
            margin-right: 10px;
            font-size: 14px;
            padding: 8px 12px;
        }
    </style>
</head>
<body>
  <div class="dashboard-layout">
    <?php include 'includes/sidebar.php'; ?>
    <main class="main-content">
      <?php include 'includes/header.php'; ?>
      <div class="content-area">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="fa-solid fa-envelope"></i> Contact Messages</h2>
        </div>

        <div class="stats-bar mb-3">
            <span class="badge badge-primary">Total: <?= $totalMessages ?></span>
            <span class="badge badge-warning">Unread: <?= $unreadCount ?></span>
            <span class="badge badge-success">Read: <?= $totalMessages - $unreadCount ?></span>
        </div>

        <div class="card glass-card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap" style="gap:10px;">
                <div class="filter-tabs">
                    <a href="?filter=all&search=<?= urlencode($search) ?>" class="btn btn-sm btn-outline <?= $filter === 'all' ? 'active' : '' ?>">All</a>
                    <a href="?filter=unread&search=<?= urlencode($search) ?>" class="btn btn-sm btn-outline <?= $filter === 'unread' ? 'active' : '' ?>">Unread</a>
                    <a href="?filter=read&search=<?= urlencode($search) ?>" class="btn btn-sm btn-outline <?= $filter === 'read' ? 'active' : '' ?>">Read</a>
                </div>
                <form class="search-form d-flex" method="GET" action="messages.php">
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($search) ?>" style="width:250px;">
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Search</button>
                </form>
                <button class="btn btn-secondary" onclick="markAllRead()">Mark All Read</button>
            </div>
        </div>

        <div class="card glass-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="messagesTable">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($messages && $messages->num_rows > 0): ?>
                                <?php while($row = $messages->fetch_assoc()): ?>
                                    <tr class="<?= $row['is_read'] ? '' : 'unread-row' ?>" data-id="<?= $row['id'] ?>">
                                        <td>
                                            <?php if(!$row['is_read']): ?>
                                                <i class="fa-solid fa-circle text-primary" style="font-size: 10px;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars(mb_strimwidth($row['subject'], 0, 40, '...')) ?></td>
                                        <td><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-action text-info view-btn" data-message='<?= htmlspecialchars(json_encode($row), ENT_QUOTES) ?>'><i class="fa-solid fa-eye"></i></button>
                                            <button class="btn btn-sm btn-action text-warning" onclick="toggleRead(<?= $row['id'] ?>, <?= $row['is_read'] ? '0' : '1' ?>)" title="<?= $row['is_read'] ? 'Mark Unread' : 'Mark Read' ?>">
                                                <i class="fa-solid <?= $row['is_read'] ? 'fa-envelope' : 'fa-envelope-open' ?>"></i>
                                            </button>
                                            <button class="btn btn-sm btn-action text-danger" onclick="deleteMessage(<?= $row['id'] ?>)"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No messages found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($totalPages > 1): ?>
                <div class="pagination mt-4 d-flex justify-content-center">
                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>&filter=<?= htmlspecialchars($filter) ?>&search=<?= urlencode($search) ?>" class="btn btn-sm <?= $page === $i ? 'btn-primary' : 'btn-outline' ?>" style="margin:0 5px;"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
      </div>
      <?php include 'includes/footer.php'; ?>
    </main>
  </div>

  <!-- View Message Modal -->
  <div id="viewMessageModal" class="modal">
      <div class="modal-content glass-card">
          <div class="modal-header">
              <h3>View Message</h3>
              <span class="close" onclick="closeModal('viewMessageModal')">&times;</span>
          </div>
          <div class="modal-body">
              <div class="message-details mb-4">
                  <p><strong>From:</strong> <span id="mName"></span> &lt;<span id="mEmail"></span>&gt;</p>
                  <p><strong>Phone:</strong> <span id="mPhone"></span></p>
                  <p><strong>Date:</strong> <span id="mDate"></span></p>
                  <hr>
                  <p><strong>Subject:</strong> <span id="mSubject"></span></p>
                  <div class="message-body p-3 mt-2" style="background: rgba(0,0,0,0.2); border-radius: 8px;">
                      <p id="mMessage" style="white-space: pre-wrap; margin:0;"></p>
                  </div>
              </div>
              <div class="d-flex justify-content-between mt-4">
                  <button class="btn btn-secondary" onclick="closeModal('viewMessageModal')">Close</button>
                  <div>
                      <button class="btn btn-warning" id="btnToggleRead">Mark Unread</button>
                      <button class="btn btn-danger" id="btnDeleteMsg">Delete</button>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      function openModal(id) {
          document.getElementById(id).style.display = 'block';
      }
      function closeModal(id) {
          document.getElementById(id).style.display = 'none';
      }

      let currentMsgId = null;
      let currentMsgIsRead = false;

      document.querySelectorAll('.view-btn').forEach(btn => {
          btn.addEventListener('click', function() {
              const msg = JSON.parse(this.dataset.message);
              currentMsgId = msg.id;
              currentMsgIsRead = msg.is_read == 1;
              
              document.getElementById('mName').innerText = msg.name;
              document.getElementById('mEmail').innerText = msg.email;
              document.getElementById('mPhone').innerText = msg.phone || 'N/A';
              document.getElementById('mDate').innerText = new Date(msg.created_at).toLocaleString();
              document.getElementById('mSubject').innerText = msg.subject;
              document.getElementById('mMessage').innerText = msg.message;
              
              document.getElementById('btnToggleRead').innerText = currentMsgIsRead ? 'Mark Unread' : 'Keep Unread';
              
              openModal('viewMessageModal');
              
              // Auto mark as read if unread
              if(msg.is_read == 0) {
                  toggleRead(msg.id, 1, false);
              }
          });
      });

      document.getElementById('btnToggleRead').addEventListener('click', function() {
          if(currentMsgId) {
              toggleRead(currentMsgId, currentMsgIsRead ? 0 : 1, true);
          }
      });

      document.getElementById('btnDeleteMsg').addEventListener('click', function() {
          if(currentMsgId) {
              deleteMessage(currentMsgId);
          }
      });

      function toggleRead(id, status, reload = true) {
          const formData = new FormData();
          formData.append('action', 'toggle_read');
          formData.append('entity', 'contact_messages');
          formData.append('id', id);
          formData.append('status', status);
          
          fetch('ajax_handler.php', {
              method: 'POST',
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if(data.success && reload) location.reload();
          });
      }

      function markAllRead() {
          if(confirm('Mark all messages as read?')) {
              const formData = new FormData();
              formData.append('action', 'mark_all_read');
              formData.append('entity', 'contact_messages');
              
              fetch('ajax_handler.php', {
                  method: 'POST',
                  body: formData
              })
              .then(res => res.json())
              .then(data => {
                  if(data.success) location.reload();
              });
          }
      }

      function deleteMessage(id) {
          if(confirm('Are you sure you want to delete this message?')) {
              const formData = new FormData();
              formData.append('action', 'delete');
              formData.append('entity', 'contact_messages'); 
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
  </script>
</body>
</html>
