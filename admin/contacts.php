<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
requireAdmin();

// Handle delete
$message = '';
$messageType = '';

if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        $message = 'Message deleted successfully!';
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error deleting message. Please try again.';
        $messageType = 'error';
    }
}

// Get all contacts
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$contacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages - National College Admin</title>
    
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
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.9rem;
            text-decoration: none;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .table-card {
            background: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        
        .table-card h2 {
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
            vertical-align: top;
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
        
        .message-cell {
            max-width: 300px;
        }
        
        .message-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .delete-btn {
            background: var(--danger);
            color: var(--white);
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-block;
        }
        
        .delete-btn:hover {
            background: #c53030;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: var(--gray-600);
        }
        
        .empty-state i {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: 20px;
        }
        
        .date-badge {
            display: inline-block;
            padding: 4px 10px;
            background: var(--gray-200);
            border-radius: 4px;
            font-size: 0.85rem;
            color: var(--gray-600);
        }
        
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            
            .admin-content {
                margin-left: 0;
            }
            
            .data-table {
                display: block;
                overflow-x: auto;
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
                <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="courses.php"><i class="fas fa-book"></i> Courses</a>
                <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
                <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="contacts.php" class="active"><i class="fas fa-envelope"></i> Contacts</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1><i class="fas fa-envelope"></i> Contact Messages</h1>
                <a href="logout.php" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="table-card">
                <h2>All Messages (<?php echo count($contacts); ?>)</h2>
                
                <?php if (empty($contacts)): ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No Messages Yet</h3>
                        <p>Contact messages from the website will appear here.</p>
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                    <tr>
                                        <td><strong><?php echo sanitize($contact['name']); ?></strong></td>
                                        <td>
                                            <a href="mailto:<?php echo sanitize($contact['email']); ?>" style="color: var(--primary);">
                                                <?php echo sanitize($contact['email']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($contact['phone']): ?>
                                                <a href="tel:<?php echo sanitize($contact['phone']); ?>" style="color: var(--primary);">
                                                    <?php echo sanitize($contact['phone']); ?>
                                                </a>
                                            <?php else: ?>
                                                <span style="color: var(--gray-600);">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="message-cell">
                                            <span class="message-text"><?php echo sanitize($contact['message']); ?></span>
                                        </td>
                                        <td>
                                            <span class="date-badge"><?php echo formatDate($contact['created_at']); ?></span>
                                        </td>
                                        <td>
                                            <a href="?delete=<?php echo $contact['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>