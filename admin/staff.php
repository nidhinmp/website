<?php
/**
 * Admin Staff Management
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
    if (isset($_POST['add_staff'])) {
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $department = trim($_POST['department'] ?? '');
        
        // Handle image upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            }
        }
        
        if (empty($name)) {
            $message = '<div class="alert alert-error">Staff name is required.</div>';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO staff (name, designation, department, image) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $designation, $department, $imagePath]);
                $message = '<div class="alert alert-success">Staff added successfully!</div>';
            } catch (PDOException $e) {
                $message = '<div class="alert alert-error">Error adding staff.</div>';
            }
        }
    } elseif (isset($_POST['update_staff'])) {
        $id = $_POST['id'] ?? 0;
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $department = trim($_POST['department'] ?? '');
        
        // Get existing image
        $stmt = $pdo->prepare("SELECT image FROM staff WHERE id = ?");
        $stmt->execute([$id]);
        $existingStaff = $stmt->fetch();
        $imagePath = $existingStaff['image'] ?? '';
        
        // Handle new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // Delete old image if exists
                if ($imagePath && file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $imagePath = $targetPath;
            }
        }
        
        try {
            $stmt = $pdo->prepare("UPDATE staff SET name = ?, designation = ?, department = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $designation, $department, $imagePath, $id]);
            $message = '<div class="alert alert-success">Staff updated successfully!</div>';
        } catch (PDOException $e) {
            $message = '<div class="alert alert-error">Error updating staff.</div>';
        }
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // Get image path before deleting
        $stmt = $pdo->prepare("SELECT image FROM staff WHERE id = ?");
        $stmt->execute([$id]);
        $staff = $stmt->fetch();
        
        if ($staff['image'] && file_exists($staff['image'])) {
            unlink($staff['image']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM staff WHERE id = ?");
        $stmt->execute([$id]);
        $message = '<div class="alert alert-success">Staff deleted successfully!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error deleting staff.</div>';
    }
}

// Get all staff
$stmt = $pdo->query("SELECT * FROM staff ORDER BY name ASC");
$staffMembers = $stmt->fetchAll();

// Get staff for editing
$editStaff = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM staff WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editStaff = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff - <?php echo SITE_NAME; ?></title>
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
                <li><a href="staff.php" class="active"><i class="fas fa-users"></i> <span>Staff</span></a></li>
                <li><a href="gallery.php"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="enquiries.php"><i class="fas fa-envelope"></i> <span>Enquiries</span></a></li>
                <li><a href="dashboard.php?action=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header-admin">
                <h2><i class="fas fa-users"></i> Manage Staff</h2>
                <p>Add, edit, or remove staff members from the website</p>
            </div>

            <?php echo $message; ?>

            <!-- Add/Edit Form -->
            <div class="form-card" style="margin-bottom: 30px;">
                <h3><?php echo $editStaff ? 'Edit Staff' : 'Add New Staff'; ?></h3>
                <form method="POST" enctype="multipart/form-data">
                    <?php if ($editStaff): ?>
                    <input type="hidden" name="id" value="<?php echo $editStaff['id']; ?>">
                    <input type="hidden" name="update_staff" value="1">
                    <?php else: ?>
                    <input type="hidden" name="add_staff" value="1">
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" class="form-control" required value="<?php echo $editStaff ? htmlspecialchars($editStaff['name']) : ''; ?>" placeholder="e.g., Dr. John Smith">
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <input type="text" id="designation" name="designation" class="form-control" value="<?php echo $editStaff ? htmlspecialchars($editStaff['designation']) : ''; ?>" placeholder="e.g., Professor">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" id="department" name="department" class="form-control" value="<?php echo $editStaff ? htmlspecialchars($editStaff['department']) : ''; ?>" placeholder="e.g., Department of Science">
                        </div>
                        <div class="form-group">
                            <label for="image">Photo</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <?php if ($editStaff && $editStaff['image']): ?>
                            <img src="<?php echo htmlspecialchars($editStaff['image']); ?>" alt="Current Photo" style="width: 100px; height: 100px; object-fit: cover; margin-top: 10px; border-radius: 10px;">
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> <?php echo $editStaff ? 'Update Staff' : 'Add Staff'; ?>
                    </button>
                    <?php if ($editStaff): ?>
                    <a href="staff.php" class="btn btn-danger">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Staff List -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($staffMembers) > 0): ?>
                            <?php foreach ($staffMembers as $staffMember): ?>
                            <tr>
                                <td><?php echo $staffMember['id']; ?></td>
                                <td>
                                    <?php if ($staffMember['image'] && file_exists($staffMember['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($staffMember['image']); ?>" alt="<?php echo htmlspecialchars($staffMember['name']); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user" style="color: #ccc;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($staffMember['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($staffMember['designation']); ?></td>
                                <td><?php echo htmlspecialchars($staffMember['department']); ?></td>
                                <td>
                                    <a href="staff.php?edit=<?php echo $staffMember['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="staff.php?delete=<?php echo $staffMember['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-users" style="font-size: 40px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No staff members found. Add your first staff above.</p>
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