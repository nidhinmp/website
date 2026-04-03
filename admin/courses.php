<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
requireAdmin();

// Handle form submission for add/edit
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $name = sanitize($_POST['name'] ?? '');
        $duration = sanitize($_POST['duration'] ?? '');
        $eligibility = sanitize($_POST['eligibility'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        
        if ($name && $duration && $eligibility && $description) {
            try {
                $stmt = $pdo->prepare("INSERT INTO courses (name, duration, eligibility, description) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $duration, $eligibility, $description]);
                $message = 'Course added successfully!';
                $messageType = 'success';
            } catch (Exception $e) {
                $message = 'Error adding course. Please try again.';
                $messageType = 'error';
            }
        }
    } elseif ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $name = sanitize($_POST['name'] ?? '');
        $duration = sanitize($_POST['duration'] ?? '');
        $eligibility = sanitize($_POST['eligibility'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        
        if ($id && $name && $duration && $eligibility && $description) {
            try {
                $stmt = $pdo->prepare("UPDATE courses SET name = ?, duration = ?, eligibility = ?, description = ? WHERE id = ?");
                $stmt->execute([$name, $duration, $eligibility, $description, $id]);
                $message = 'Course updated successfully!';
                $messageType = 'success';
            } catch (Exception $e) {
                $message = 'Error updating course. Please try again.';
                $messageType = 'error';
            }
        }
    }
}

// Handle delete
if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $message = 'Course deleted successfully!';
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error deleting course. Please try again.';
        $messageType = 'error';
    }
}

// Get all courses
$stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC");
$courses = $stmt->fetchAll();

// Get course for edit if edit parameter exists
$editCourse = null;
if (isset($_GET['edit']) && intval($_GET['edit']) > 0) {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([intval($_GET['edit'])]);
    $editCourse = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Management - National College Admin</title>
    
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
        
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background: var(--secondary);
        }
        
        .btn-success {
            background: var(--success);
            color: var(--white);
        }
        
        .btn-danger {
            background: var(--danger);
            color: var(--white);
        }
        
        .btn-sm {
            padding: 5px 12px;
            font-size: 0.85rem;
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
        
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .form-card {
            background: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            height: fit-content;
        }
        
        .form-card h2 {
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--gray-200);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
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
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .data-table th {
            background: var(--primary);
            color: var(--white);
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .data-table tr:nth-child(even) {
            background: var(--gray-100);
        }
        
        .data-table tr:hover {
            background: var(--gray-200);
        }
        
        .data-table td {
            font-size: 0.9rem;
        }
        
        .table-actions {
            display: flex;
            gap: 8px;
        }
        
        .edit-btn {
            background: var(--secondary);
            color: var(--white);
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
        }
        
        .delete-btn {
            background: var(--danger);
            color: var(--white);
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--gray-600);
        }
        
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
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
                <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="courses.php" class="active"><i class="fas fa-book"></i> Courses</a>
                <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
                <a href="gallery.php"><i class="fas fa-images"></i> Gallery</a>
                <a href="contacts.php"><i class="fas fa-envelope"></i> Contacts</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1><i class="fas fa-book"></i> Courses Management</h1>
                <a href="logout.php" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="content-grid">
                <!-- Add/Edit Form -->
                <div class="form-card">
                    <h2><?php echo $editCourse ? 'Edit Course' : 'Add New Course'; ?></h2>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="<?php echo $editCourse ? 'edit' : 'add'; ?>">
                        <?php if ($editCourse): ?>
                            <input type="hidden" name="id" value="<?php echo $editCourse['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="name">Course Name *</label>
                            <input type="text" id="name" name="name" required value="<?php echo $editCourse ? sanitize($editCourse['name']) : ''; ?>" placeholder="e.g., Bachelor of Science">
                        </div>
                        
                        <div class="form-group">
                            <label for="duration">Duration *</label>
                            <input type="text" id="duration" name="duration" required value="<?php echo $editCourse ? sanitize($editCourse['duration']) : ''; ?>" placeholder="e.g., 3 Years">
                        </div>
                        
                        <div class="form-group">
                            <label for="eligibility">Eligibility *</label>
                            <input type="text" id="eligibility" name="eligibility" required value="<?php echo $editCourse ? sanitize($editCourse['eligibility']) : ''; ?>" placeholder="e.g., 10+2 with Science">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" name="description" required rows="4" placeholder="Enter course description..."><?php echo $editCourse ? sanitize($editCourse['description']) : ''; ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn <?php echo $editCourse ? 'btn-success' : 'btn-primary'; ?>" style="width: 100%;">
                            <i class="fas fa-<?php echo $editCourse ? 'save' : 'plus'; ?>"></i>
                            <?php echo $editCourse ? 'Update Course' : 'Add Course'; ?>
                        </button>
                        
                        <?php if ($editCourse): ?>
                            <a href="courses.php" class="btn btn-danger" style="width: 100%; margin-top: 10px; text-align: center; display: block;">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
                
                <!-- Courses List -->
                <div class="table-card">
                    <h2>All Courses</h2>
                    
                    <?php if (empty($courses)): ?>
                        <div class="empty-state">
                            <i class="fas fa-book-open"></i>
                            <p>No courses added yet.</p>
                        </div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><strong><?php echo sanitize($course['name']); ?></strong></td>
                                            <td><?php echo sanitize($course['duration']); ?></td>
                                            <td>
                                                <div class="table-actions">
                                                    <a href="?edit=<?php echo $course['id']; ?>" class="edit-btn">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="?delete=<?php echo $course['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this course?');">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>