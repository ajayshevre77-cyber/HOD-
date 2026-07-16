<?php
session_start();
require_once 'db.php';

// Authentication check
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'hod') {
    header("Location: login.php?role=hod");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College ERP Portal - HOD Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="theme-hod">
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <div>
                        <span>College ERP</span>
                        <span class="sub">HOD Portal</span>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li><a class="sidebar-nav-item active" onclick="switchTab('dashboard', this)"><i class="fa-solid fa-chart-pie"></i><span>HOD Dashboard</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('faculty', this)"><i class="fa-solid fa-chalkboard-user"></i><span>Monitor Faculty</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('reports', this)"><i class="fa-solid fa-chart-column"></i><span>View Reports</span></a></li>
                    <li><a class="sidebar-nav-item" onclick="switchTab('grievances', this)"><i class="fa-solid fa-circle-nodes"></i><span>Resolve Grievances</span></a></li>
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
                    <h2 id="currentTabTitle">HOD Dashboard</h2>
                    <p id="currentTabSubtitle">Department of Information Technology administrative panel.</p>
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
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <h3 id="mockPageTitle">HOD Dashboard</h3>
                <p id="mockPageDesc">Manage your department resources. Navigate through HOD features to monitor faculty class progression, inspect academic success reports, and resolve escalated grievances.</p>
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

            if (tabName === 'dashboard') {
                headerTitle.textContent = "HOD Dashboard";
                headerSubtitle.textContent = "Department of Information Technology administrative panel.";
                iconBox.innerHTML = '<i class="fa-solid fa-chart-pie"></i>';
                descText.textContent = "Manage your department resources. Navigate through HOD features to monitor faculty class progression, inspect academic success reports, and resolve escalated grievances.";
            } else if (tabName === 'faculty') {
                headerSubtitle.textContent = "Supervise and monitor class tasks published by your academic faculty.";
                iconBox.innerHTML = '<i class="fa-solid fa-chalkboard-user"></i>';
                descText.textContent = "Track lecture hours coverage, review assignment creation logs, and verify that the syllabus timelines are successfully maintained across all IT semesters.";
            } else if (tabName === 'reports') {
                headerSubtitle.textContent = "Review department progression rates, student performance statistics, and fee collections.";
                iconBox.innerHTML = '<i class="fa-solid fa-chart-column"></i>';
                descText.textContent = "Generate visual analytical graphs outlining term-end pass rates, subject performance matrices, and attendance distributions across IT class subsets.";
            } else if (tabName === 'grievances') {
                headerSubtitle.textContent = "Resolve student complaints and resource issues escalated to head of department.";
                iconBox.innerHTML = '<i class="fa-solid fa-circle-nodes"></i>';
                descText.textContent = "Review resolved or unresolved student grievances. Coordinate directly with the administration and faculty delegates to address student infrastructure and grading issues.";
            }
        }
    </script>
</body>
</html>
