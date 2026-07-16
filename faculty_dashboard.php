<?php
session_start();
require_once 'db.php';

// Authentication check
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'faculty') {
    header("Location: login.php?role=faculty");
    exit;
}

$user = $_SESSION['user'];
$db = get_db();

$success_message = '';
$error_message = '';

// Handle Approve / Reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $leave_id = intval($_POST['leave_id']);

    $updated = false;
    foreach ($db['leaves'] as &$leave) {
        if ($leave['id'] === $leave_id) {
            if ($action === 'approve') {
                $leave['status'] = 'Approved';
                $success_message = 'Leave request #' . $leave_id . ' (Reason: ' . $leave['reason'] . ') has been Approved.';
                $updated = true;
            } elseif ($action === 'reject') {
                $leave['status'] = 'Rejected';
                $success_message = 'Leave request #' . $leave_id . ' (Reason: ' . $leave['reason'] . ') has been Rejected.';
                $updated = true;
            }
            break;
        }
    }

    if ($updated) {
        save_db($db);
    } else {
        $error_message = 'Failed to update leave request status. Request #' . $leave_id . ' not found.';
    }
}

// Reload database to get fresh updates
$db = get_db();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College ERP Portal - Faculty Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="theme-faculty">
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <div>
                        <span>College ERP</span>
                        <span class="sub">Faculty Portal</span>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li><a class="sidebar-nav-item active" onclick="switchTab('leaves', this)"><i class="fa-solid fa-envelope-open-text"></i><span>Leave Approvals</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('assignments', this)"><i class="fa-solid fa-file-invoice"></i><span>Manage Assignments</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('notices', this)"><i class="fa-solid fa-bullhorn"></i><span>Publish Notices</span></a></li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <a href="logout.php" class="sidebar-nav-item" style="background: rgba(239, 68, 68, 0.1); color: #f87171;"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
            </div>
        </aside>

        <!-- Main Dashboard View Area -->
        <main class="main-content">
            <!-- Header Widget -->
            <header class="dashboard-header">
                <div class="page-title-box">
                    <h2 id="currentTabTitle">Leave Approvals</h2>
                    <p id="currentTabSubtitle">Review, approve or reject student leave requests submitted for review.</p>
                </div>
                <div class="user-profile-widget">
                    <div class="notification-bell" onclick="alert('You have no new notifications.')">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                    <div class="user-avatar-box">
                        <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="User Avatar">
                        <div class="user-details">
                            <span class="name"><?php echo htmlspecialchars($user['name']); ?></span>
                            <span class="role"><?php echo htmlspecialchars($user['dept']); ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Success/Error alert banner -->
            <?php if (!empty($success_message)): ?>
                <div class="error-message" style="display:flex; background: #ecfdf5; border-color: #a7f3d0; color: #065f46; margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo $success_message; ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div class="error-message" style="display:flex; margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?php echo $error_message; ?></span>
                </div>
            <?php endif; ?>

            <!-- ============================================ -->
            <!-- 1. LEAVE APPROVALS TAB                       -->
            <!-- ============================================ -->
            <div id="tab-leaves" class="app-view active">
                <div class="data-table-container">
                    <div class="table-header-filters" style="justify-content: flex-start; background: #fafafa; border-bottom: 1px solid var(--border-color);">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: #111827; padding: 0.5rem 0.25rem;">Active Leave Requests</h3>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Student Details</th>
                                <th>Reason</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Leave Form</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center; width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db['leaves'] as $leave): ?>
                                <tr>
                                    <td><?php echo $leave['id']; ?></td>
                                    <td>
                                        <div class="publisher-cell">
                                            <span class="pub-name">Prasad Kulkarni</span>
                                            <span class="pub-role">IT - Div A (A2)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600;"><?php echo htmlspecialchars($leave['reason']); ?></span>
                                    </td>
                                    <td>
                                        <span class="date-cell"><?php echo htmlspecialchars($leave['from']); ?></span>
                                    </td>
                                    <td>
                                        <span class="date-cell"><?php echo htmlspecialchars($leave['to']); ?></span>
                                    </td>
                                    <td>
                                        <div class="publisher-cell" style="flex-direction:row; align-items:center; gap:0.5rem;">
                                            <?php 
                                                $ext = pathinfo($leave['file'], PATHINFO_EXTENSION);
                                                $is_pdf = (strtolower($ext) === 'pdf');
                                            ?>
                                            <i class="fa-solid <?php echo $is_pdf?'fa-file-pdf':'fa-file-word'; ?>" style="font-size:1.15rem; color:<?php echo $is_pdf?'#ef4444':'#0284c7'; ?>"></i>
                                            <a href="#" class="pub-name" style="font-size:0.9rem; font-weight:500; text-decoration:none; color: var(--primary-color);" onclick="alert('Viewing document: <?php echo $leave['file']; ?>')">
                                                <?php echo htmlspecialchars($leave['file']); ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php 
                                            $status = strtolower($leave['status']);
                                            $pill_class = ($status === 'approved') ? 'graded' : (($status === 'pending') ? 'pending' : 'rejected');
                                        ?>
                                        <span class="status-pill <?php echo $pill_class; ?>"><?php echo htmlspecialchars($leave['status']); ?></span>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php if ($status === 'pending'): ?>
                                            <div class="faculty-actions-cell">
                                                <form method="POST" action="faculty_dashboard.php" style="display:inline;">
                                                    <input type="hidden" name="action" value="approve">
                                                    <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                                                    <button type="submit" class="btn-approve">
                                                        <i class="fa-solid fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="faculty_dashboard.php" style="display:inline;">
                                                    <input type="hidden" name="action" value="reject">
                                                    <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                                                    <button type="submit" class="btn-reject">
                                                        <i class="fa-solid fa-xmark"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">No Action Needed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ============================================ -->
            <!-- MOCK TABS PANEL                              -->
            <!-- ============================================ -->
            <div id="tab-mock" class="app-view">
                <div class="mock-page-container">
                    <div class="mock-page-icon" id="mockPageIcon">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h3 id="mockPageTitle">Manage Assignments</h3>
                    <p id="mockPageDesc">This panel allows faculty members to publish assignments, set deadlines, and review student code file uploads.</p>
                </div>
            </div>

        </main>
    </div>

    <!-- JavaScript code for navigation -->
    <script>
        function switchTab(tabName, element) {
            const items = document.querySelectorAll('.sidebar-nav-item');
            items.forEach(item => item.classList.remove('active'));
            element.classList.add('active');

            const panels = document.querySelectorAll('.app-view');
            panels.forEach(p => p.classList.remove('active'));

            const headerTitle = document.getElementById('currentTabTitle');
            const headerSubtitle = document.getElementById('currentTabSubtitle');

            if (tabName === 'leaves') {
                document.getElementById('tab-leaves').classList.add('active');
                headerTitle.textContent = "Leave Approvals";
                headerSubtitle.textContent = "Review, approve or reject student leave requests submitted for review.";
            } else {
                const mockPanel = document.getElementById('tab-mock');
                mockPanel.classList.add('active');

                const titleText = document.getElementById('mockPageTitle');
                const descText = document.getElementById('mockPageDesc');
                const iconBox = document.getElementById('mockPageIcon');

                headerTitle.textContent = tabName.charAt(0).toUpperCase() + tabName.slice(1);
                headerSubtitle.textContent = `Access faculty ${tabName} configuration panels.`;

                titleText.textContent = tabName.toUpperCase();
                
                if (tabName === 'assignments') {
                    iconBox.innerHTML = '<i class="fa-solid fa-file-invoice"></i>';
                    descText.textContent = "View and grade submitted student code assignments. In this view, you can check file uploads, assign unit marks (e.g. 7/10 or 10/10), and modify assignment descriptions.";
                } else if (tabName === 'notices') {
                    iconBox.innerHTML = '<i class="fa-solid fa-bullhorn"></i>';
                    descText.textContent = "Compose and publish academic notices directly to the Student Portal notices bulletin board. Include titles, dates, descriptions, and file downloads (PDF/DOCX).";
                }
            }
        }
    </script>
</body>
</html>
