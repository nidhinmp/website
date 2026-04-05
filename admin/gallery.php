<?php
/**
 * Admin Gallery Management
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
    if (isset($_POST['add_gallery'])) {
        $category = trim($_POST['category'] ?? 'college');
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = '../uploads/gallery/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO gallery (image_path, category) VALUES (?, ?)");
                    $stmt->execute([$targetPath, $category]);
                    $message = '<div class="alert alert-success">Image uploaded successfully!</div>';
                } catch (PDOException $e) {
                    $message = '<div class="alert alert-error">Error uploading image.</div>';
                }
            } else {
                $message = '<div class="alert alert-error">Error moving uploaded file.</div>';
            }
        } else {
            $message = '<div class="alert alert-error">Please select an image to upload.</div>';
        }
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // Get image path before deleting
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $gallery = $stmt->fetch();
        
        if ($gallery['image_path'] && file_exists($gallery['image_path'])) {
            unlink($gallery['image_path']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $message = '<div class="alert alert-success">Image deleted successfully!</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Error deleting image.</div>';
    }
}

// Get all gallery images
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
$galleryImages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery - <?php echo SITE_NAME; ?></title>
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
                <li><a href="gallery.php" class="active"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
                <li><a href="enquiries.php"><i class="fas fa-envelope"></i> <span>Enquiries</span></a></li>
                <li><a href="dashboard.php?action=logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header-admin">
                <h2><i class="fas fa-images"></i> Manage Gallery</h2>
                <p>Upload and manage gallery images</p>
            </div>

            <?php echo $message; ?>

            <!-- Add Image Form -->
            <div class="form-card" style="margin-bottom: 30px;">
                <h3><i class="fas fa-cloud-upload-alt"></i> Upload New Image</h3>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="add_gallery" value="1">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" class="form-control">
                                <option value="college">College</option>
                                <option value="events">Events</option>
                                <option value="sports">Sports</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Select Image *</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Image
                    </button>
                </form>
            </div>

            <!-- Gallery Grid -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Uploaded Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($galleryImages) > 0): ?>
                            <?php foreach ($galleryImages as $image): ?>
                            <tr>
                                <td><?php echo $image['id']; ?></td>
                                <td>
                                    <?php if ($image['image_path'] && file_exists($image['image_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Gallery" style="width: 100px; height: 70px; object-fit: cover; border-radius: 8px;">
                                    <?php else: ?>
                                        <div style="width: 100px; height: 70px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image" style="color: #ccc;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge" style="padding: 5px 15px; background: #003366; color: white; border-radius: 20px;"><?php echo htmlspecialchars(ucfirst($image['category'])); ?></span></td>
                                <td><?php echo date('d M Y', strtotime($image['uploaded_at'])); ?></td>
                                <td>
                                    <a href="gallery.php?delete=<?php echo $image['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this image?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-images" style="font-size: 40px; color: #ccc;"></i>
                                    <p style="margin-top: 10px;">No images in gallery. Upload your first image above.</p>
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