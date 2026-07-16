<?php
session_start();
require_once 'db.php';

// Authentication check
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?role=admin");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College ERP Portal - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="theme-admin">
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <div>
                        <span>College ERP</span>
                        <span class="sub">Admin Portal</span>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li><a class="sidebar-nav-item active" onclick="switchTab('users', this)"><i class="fa-solid fa-user-gear"></i><span>User Management</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('departments', this)"><i class="fa-solid fa-building-columns"></i><span>Departments</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('notices', this)"><i class="fa-solid fa-rectangle-ad"></i><span>Notice Board</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('reports', this)"><i class="fa-solid fa-file-invoice-dollar"></i><span>Report Generation</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('system', this)"><i class="fa-solid fa-sliders"></i><span>System Config</span></a></li>
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
                    <h2 id="currentTabTitle">User Management</h2>
                    <p id="currentTabSubtitle">Admin portal for user credentials, roles, and security access profiles.</p>
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

            <div class="mock-page-container">
                <div class="mock-page-icon" id="mockPageIcon">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <h3 id="mockPageTitle">User Management</h3>
                <p id="mockPageDesc">Manage university users. Generate accounts, check login activity registers, update roles, and reset student/faculty passwords.</p>
            </div>
        </main>
    </div>

    <!-- JavaScript code for navigation -->
    <script>
        function switchTab(tabName, element) {
            const items = document.querySelectorAll('.sidebar-nav-item');
            items.forEach(item => item.classList.remove('active'));
            element.classList.add('active');

            const headerTitle = document.getElementById('currentTabTitle');
            const headerSubtitle = document.getElementById('currentTabSubtitle');
            const titleText = document.getElementById('mockPageTitle');
            const descText = document.getElementById('mockPageDesc');
            const iconBox = document.getElementById('mockPageIcon');

            headerTitle.textContent = tabName.charAt(0).toUpperCase() + tabName.slice(1);
            titleText.textContent = tabName.toUpperCase();

            if (tabName === 'users') {
                headerTitle.textContent = "User Management";
                headerSubtitle.textContent = "Admin portal for user credentials, roles, and security access profiles.";
                iconBox.innerHTML = '<i class="fa-solid fa-user-gear"></i>';
                descText.textContent = "Manage university users. Generate accounts, check login activity registers, update roles, and reset student/faculty passwords.";
            } else if (tabName === 'departments') {
                headerTitle.textContent = "Department Management";
                headerSubtitle.textContent = "Configure curriculum courses, subject lines, and department designations.";
                iconBox.innerHTML = '<i class="fa-solid fa-building-columns"></i>';
                descText.textContent = "Set up new branches of studies, add branches heads, link courses structures, and map faculty to specific branch modules.";
            } else if (tabName === 'notices') {
                headerTitle.textContent = "Notice Management";
                headerSubtitle.textContent = "Publish global and targeted news notices to the ERP bulletin boards.";
                iconBox.innerHTML = '<i class="fa-solid fa-rectangle-ad"></i>';
                descText.textContent = "Publish news events, holidays guidelines, and administrative alerts. Target notices to specific profiles (e.g. all students or all staff).";
            } else if (tabName === 'reports') {
                headerTitle.textContent = "Report Generation";
                headerSubtitle.textContent = "Compile system metrics, resource logs, and institution audit details.";
                iconBox.innerHTML = '<i class="fa-solid fa-file-invoice-dollar"></i>';
                descText.textContent = "Generate reports regarding registrations, active sessions count, security alerts logs, and database size stats.";
            } else if (tabName === 'system') {
                headerTitle.textContent = "System Configuration";
                headerSubtitle.textContent = "Manage global system parameters, theme colors, and portal security levels.";
                iconBox.innerHTML = '<i class="fa-solid fa-sliders"></i>';
                descText.textContent = "Toggle captcha security requirements, modify session durations, adjust file upload size limits, and update backup storage targets.";
            }
        }
    </script>
</body>
</html>
