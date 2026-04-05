<?php
/**
 * Admin Dashboard
 */
require_once '../config.php';

// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total FROM courses");
$coursesCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM staff");
$staffCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM gallery");
$galleryCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM enquiries");
$enquiriesCount = $stmt->fetch()['total'];

// Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?php echo SITE_NAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h3><i class="fas fa-university"></i> Admin Panel</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li><a href="courses.php"><i class="fas fa-book"></i> <span>Courses</span></a></li>
                <li><a href="staff.php"><i class="fas fa-users"></i> <span>Staff</span></a></li>
                <li><a href="gallery.php"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="enquiries.php"><i class="fas fa-envelope"></i> <span>Enquiries</span></a></li>
                <li><a href="?action=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header-admin">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <p>Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            </div>

            <!-- Statistics Cards -->
            <div class="dashboard-cards">
                <div class="dash-card">
                    <h4><i class="fas fa-book"></i> Total Courses</h4>
                    <div class="number"><?php echo $coursesCount; ?></div>
                    <a href="courses.php" class="btn btn-sm btn-primary" style="margin-top: 10px;">Manage Courses</a>
                </div>
                <div class="dash-card">
                    <h4><i class="fas fa-users"></i> Total Staff</h4>
                    <div class="number"><?php echo $staffCount; ?></div>
                    <a href="staff.php" class="btn btn-sm btn-primary" style="margin-top: 10px;">Manage Staff</a>
                </div>
                <div class="dash-card">
                    <h4><i class="fas fa-images"></i> Gallery Images</h4>
                    <div class="number"><?php echo $galleryCount; ?></div>
                    <a href="gallery.php" class="btn btn-sm btn-primary" style="margin-top: 10px;">Manage Gallery</a>
                </div>
                <div class="dash-card">
                    <h4><i class="fas fa-envelope"></i> Enquiries</h4>
                    <div class="number"><?php echo $enquiriesCount; ?></div>
                    <a href="enquiries.php" class="btn btn-sm btn-primary" style="margin-top: 10px;">View Enquiries</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="form-card">
                <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <a href="courses.php?action=add" class="btn btn-primary" style="text-align: center;">
                        <i class="fas fa-plus"></i> Add New Course
                    </a>
                    <a href="staff.php?action=add" class="btn btn-primary" style="text-align: center;">
                        <i class="fas fa-user-plus"></i> Add New Staff
                    </a>
                    <a href="gallery.php?action=add" class="btn btn-primary" style="text-align: center;">
                        <i class="fas fa-image"></i> Upload Image
                    </a>
                    <a href="../index.php" class="btn btn-secondary" style="text-align: center;" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Website
                    </a>
                </div>
            </div>

            <!-- Recent Enquiries -->
            <div class="form-card" style="margin-top: 30px;">
                <h3><i class="fas fa-envelope-open-text"></i> Recent Enquiries</h3>
                <?php
                $stmt = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5");
                $recentEnquiries = $stmt->fetchAll();
                
                if (count($recentEnquiries) > 0):
                ?>
                <table class="data-table" style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentEnquiries as $enquiry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enquiry['name']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['email']); ?></td>
                            <td><?php echo htmlspecialchars(substr($enquiry['message'], 0, 50)); ?>...</td>
                            <td><?php echo date('d M Y', strtotime($enquiry['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="text-align: center; padding: 30px; color: #666;">No enquiries yet.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>