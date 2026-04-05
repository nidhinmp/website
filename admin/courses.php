<?php
/**
 * Admin Courses Management
 */
require_once '../config.php';

// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_course'])) {
        $name = trim($_POST['name'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $eligibility = trim($_POST['eligibility'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($name)) {
            $message = '<div class="alert alert-error">Course name is required.</div>';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO courses (name, duration, eligibility, description) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $duration, $eligibility, $description]);
                $message = '<div class="alert alert-success">Course added successfully!</div>';
            } catch (PDOException $e) {
                $message = '<div class="alert alert-error">Error adding course.</div>';
            }
        }
    } elseif (isset($_POST['update_course'])) {
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $eligibility = trim($_POST['eligibility'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        try {
            $stmt = $pdo->prepare("UPDATE courses SET name = ?, duration = ?, eligibility = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $duration, $eligibility, $description, $id]);
            $message = '<div class="alert alert-success">Course updated successfully!</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-error">Error updating course.</div>';
        }
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $message = '<div class="alert alert-success">Course deleted successfully!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error deleting course.</div>';
    }
}

// Get all courses
$stmt = $pdo->query("SELECT * FROM courses ORDER BY name ASC");
$courses = $stmt->fetchAll();

// Get course for editing
$editCourse = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editCourse = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - <?php echo SITE_NAME; ?></title>
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
                <li><a href="courses.php" class="active"><i class="fas fa-book"></i> <span>Courses</span></a></li>
                <li><a href="staff.php"><i class="fas fa-users"></i> <span>Staff</span></a></li>
                <li><a href="gallery.php"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="enquiries.php"><i class="fas fa-envelope"></i> <span>Enquiries</span></a></li>
                <li><a href="dashboard.php?action=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header-admin">
                <h2><i class="fas fa-book"></i> Manage Courses</h2>
                <p>Add, edit, or remove courses from the website</p>
            </div>

            <?php echo $message; ?>

            <!-- Add/Edit Form -->
            <div class="form-card" style="margin-bottom: 30px;">
                <h3><?php echo $editCourse ? 'Edit Course' : 'Add New Course'; ?></h3>
                <form method="POST">
                    <?php if ($editCourse): ?>
                    <input type="hidden" name="id" value="<?php echo $editCourse['id']; ?>">
                    <input type="hidden" name="update_course" value="1">
                    <?php else: ?>
                    <input type="hidden" name="add_course" value="1">
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Course Name *</label>
                            <input type="text" id="name" name="name" class="form-control" required value="<?php echo $editCourse ? htmlspecialchars($editCourse['name']) : ''; ?>" placeholder="e.g., Bachelor of Arts">
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" id="duration" name="duration" class="form-control" value="<?php echo $editCourse ? htmlspecialchars($editCourse['duration']) : ''; ?>" placeholder="e.g., 3 Years">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="eligibility">Eligibility</label>
                            <input type="text" id="eligibility" name="eligibility" class="form-control" value="<?php echo $editCourse ? htmlspecialchars($editCourse['eligibility']) : ''; ?>" placeholder="e.g., 10+2 Pass">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Course description..."><?php echo $editCourse ? htmlspecialchars($editCourse['description']) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> <?php echo $editCourse ? 'Update Course' : 'Add Course'; ?>
                    </button>
                    <?php if ($editCourse): ?>
                    <a href="courses.php" class="btn btn-danger">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Courses List -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Duration</th>
                            <th>Eligibility</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($courses) > 0): ?>
                            <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo $course['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($course['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($course['duration']); ?></td>
                                <td><?php echo htmlspecialchars($course['eligibility']); ?></td>
                                <td><?php echo htmlspecialchars(substr($course['description'], 0, 80)); ?>...</td>
                                <td>
                                    <a href="courses.php?edit=<?php echo $course['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="courses.php?delete=<?php echo $course['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-book" style="font-size: 40px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No courses found. Add your first course above.</p>
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