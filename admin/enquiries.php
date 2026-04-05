<?php
/**
 * Admin Enquiries Management
 */
require_once '../config.php';

// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = ?");
        $stmt->execute([$id]);
        $message = '<div class="alert alert-success">Enquiry deleted successfully!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error deleting enquiry.</div>';
    }
}

// Get all enquiries
$stmt = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC");
$enquiries = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Enquiries - <?php echo SITE_NAME; ?></title>
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
                <li><a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li><a href="courses.php"><i class="fas fa-book"></i> <span>Courses</span></a></li>
                <li><a href="staff.php"><i class="fas fa-users"></i> <span>Staff</span></a></li>
                <li><a href="gallery.php"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="enquiries.php" class="active"><i class="fas fa-envelope"></i> <span>Enquiries</span></a></li>
                <li><a href="dashboard.php?action=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header-admin">
                <h2><i class="fas fa-envelope"></i> Manage Enquiries</h2>
                <p>View and manage contact form submissions</p>
            </div>

            <?php echo $message; ?>

            <!-- Enquiries List -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($enquiries) > 0): ?>
                            <?php foreach ($enquiries as $enquiry): ?>
                            <tr>
                                <td><?php echo $enquiry['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($enquiry['name']); ?></strong></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($enquiry['email']); ?>"><?php echo htmlspecialchars($enquiry['email']); ?></a>
                                </td>
                                <td>
                                    <?php if ($enquiry['phone']): ?>
                                        <a href="tel:<?php echo htmlspecialchars($enquiry['phone']); ?>"><?php echo htmlspecialchars($enquiry['phone']); ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars(substr($enquiry['message'], 0, 60)); ?>...</td>
                                <td><?php echo date('d M Y', strtotime($enquiry['created_at'])); ?></td>
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($enquiry['email']); ?>?subject=Re: Your Enquiry to National College" class="btn btn-sm btn-success"><i class="fas fa-reply"></i> Reply</a>
                                    <a href="enquiries.php?delete=<?php echo $enquiry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this enquiry?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-envelope" style="font-size: 40px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No enquiries yet. When someone contacts you through the website, their messages will appear here.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script src="../js/main.js"></script>
</body>
</html>