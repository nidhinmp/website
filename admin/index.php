<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
requireAdmin();

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as count FROM courses");
$coursesCount = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM staff");
$staffCount = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM gallery");
$galleryCount = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM contacts");
$contactsCount = $stmt->fetch()['count'];

// Get recent contacts
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");
$recentContacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - National College Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1e3a5f;
            --secondary: #2c5282;
            --accent: #f6993f;
            --light: #f7fafc;
            --dark: #1a202c;
            --white: #ffffff;
            --gray-100: #f7fafc;
            --gray-200: #edf2f7;
            --gray-300: #e2e8f0;
            --gray-600: #718096;
            --success: #38a169;
            --danger: #e53e3e;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background: var(--gray-100);
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .admin-sidebar {
            width: 260px;
            background: var(--primary);
            color: var(--white);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .admin-sidebar .logo {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .admin-sidebar .logo h2 {
            font-size: 1.3rem;
            color: var(--white);
            font-family: 'Playfair Display', serif;
        }
        
        .admin-sidebar .logo span {
            font-size: 0.8rem;
            color: var(--gray-300);
        }
        
        .admin-menu {
            padding: 20px 0;
        }
        
        .admin-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            color: var(--gray-300);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .admin-menu a:hover,
        .admin-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            border-left: 4px solid var(--accent);
        }
        
        .admin-menu a i {
            width: 20px;
            text-align: center;
        }
        
        .admin-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-300);
        }
        
        .admin-header h1 {
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-header .user-info span {
            color: var(--gray-600);
        }
        
        .admin-logout {
            color: var(--danger);
            padding: 10px 20px;
            border: 1px solid var(--danger);
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .admin-logout:hover {
            background: var(--danger);
            color: var(--white);
        }
        
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--white);
        }
        
        .stat-icon.courses { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-icon.staff { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .stat-icon.gallery { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .stat-icon.contacts { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        
        .stat-info h3 {
            font-size: 2rem;
            color: var(--primary);
        }
        
        .stat-info p {
            color: var(--gray-600);
        }
        
        .dashboard-section {
            background: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        
        .dashboard-section h2 {
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-200);
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .data-table th {
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
        }
        
        .data-table tr:nth-child(even) {
            background: var(--gray-100);
        }
        
        .data-table tr:hover {
            background: var(--gray-200);
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        .status-new {
            background: #d4edda;
            color: #155724;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--gray-600);
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="logo">
                <h2>National College</h2>
                <span>Admin Panel</span>
            </div>
            <nav class="admin-menu">
                <a href="index.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="courses.php"><i class="fas fa-book"></i> Courses</a>
                <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
                <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="contacts.php"><i class="fas fa-envelope"></i> Contacts</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, <strong><?php echo sanitize($_SESSION['admin_username']); ?></strong></span>
                    <a href="logout.php" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="admin-stats">
                <div class="stat-card">
                    <div class="stat-icon courses"><i class="fas fa-book"></i></div>
                    <div class="stat-info">
                        <h3><?php echo $coursesCount; ?></h3>
                        <p>Courses</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon staff"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <h3><?php echo $staffCount; ?></h3>
                        <p>Staff Members</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon gallery"><i class="fas fa-images"></i></div>
                    <div class="stat-info">
                        <h3><?php echo $galleryCount; ?></h3>
                        <p>Gallery Images</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon contacts"><i class="fas fa-envelope"></i></div>
                    <div class="stat-info">
                        <h3><?php echo $contactsCount; ?></h3>
                        <p>Contact Messages</p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Contacts -->
            <div class="dashboard-section">
                <h2><i class="fas fa-envelope"></i> Recent Contact Messages</h2>
                
                <?php if (empty($recentContacts)): ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>No contact messages yet.</p>
                    </div>
                <?php else: ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentContacts as $contact): ?>
                                <tr>
                                    <td><?php echo sanitize($contact['name']); ?></td>
                                    <td><?php echo sanitize($contact['email']); ?></td>
                                    <td><?php echo sanitize($contact['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo sanitize(substr($contact['message'], 0, 50)) . '...'; ?></td>
                                    <td><?php echo formatDate($contact['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>