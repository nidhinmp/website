<?php
require_once '../includes/config.php';
require_once '../includes/db.php';
requireAdmin();

// Handle form submission for add
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $category = sanitize($_POST['category'] ?? '');
        $title = sanitize($_POST['title'] ?? '');
        
        if (!empty($_FILES['image']['name'])) {
            $image = uploadImage($_FILES['image'], '../' . GALLERY_UPLOAD_PATH);
            
            if ($image) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO gallery (image_path, category, title) VALUES (?, ?, ?)");
                    $stmt->execute([$image, $category, $title]);
                    $message = 'Image uploaded successfully!';
                    $messageType = 'success';
                } catch (Exception $e) {
                    $message = 'Error uploading image. Please try again.';
                    $messageType = 'error';
                }
            } else {
                $message = 'Invalid image format. Please use JPG, PNG, GIF, or WebP.';
                $messageType = 'error';
            }
        } else {
            $message = 'Please select an image to upload.';
            $messageType = 'error';
        }
    }
}

// Handle delete
if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
    $id = intval($_GET['delete']);
    try {
        // Get image to delete
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $gallery = $stmt->fetch();
        if ($gallery && $gallery['image_path']) {
            deleteImage('../' . GALLERY_UPLOAD_PATH, $gallery['image_path']);
        }
        
        $stmt = $pdo->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $message = 'Image deleted successfully!';
        $messageType = 'success';
    } catch (Exception $e) {
        $message = 'Error deleting image. Please try again.';
        $messageType = 'error';
    }
}

// Get all gallery images
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
$gallery = $stmt->fetchAll();

// Get category filter
$category = $_GET['category'] ?? 'all';
if ($category !== 'all') {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ? ORDER BY id DESC");
    $stmt->execute([$category]);
    $gallery = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Management - National College Admin</title>
    
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
        
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background: var(--secondary);
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
            grid-template-columns: 350px 1fr;
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
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .file-upload {
            border: 2px dashed var(--gray-300);
            padding: 40px 20px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload:hover {
            border-color: var(--primary);
            background: var(--gray-100);
        }
        
        .file-upload input[type="file"] {
            display: none;
        }
        
        .file-upload i {
            font-size: 2.5rem;
            color: var(--gray-600);
            margin-bottom: 15px;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
            box-shadow: var(--shadow);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-item-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(30, 58, 95, 0.9), transparent);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .gallery-item-overlay span {
            color: var(--white);
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .gallery-item-overlay .delete-btn {
            background: var(--danger);
            color: var(--white);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .gallery-item-overlay .delete-btn:hover {
            background: #c53030;
        }
        
        .category-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-btn {
            padding: 8px 16px;
            background: var(--white);
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary);
            color: var(--white);
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
                <a href="courses.php"><i class="fas fa-book"></i> Courses</a>
                <a href="staff.php"><i class="fas fa-users"></i> Staff</a>
                <a href="gallery.php" class="active"><i class="fas fa-images"></i> Gallery</a>
                <a href="contacts.php"><i class="fas fa-envelope"></i> Contacts</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1><i class="fas fa-images"></i> Gallery Management</h1>
                <a href="logout.php" class="admin-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="content-grid">
                <!-- Upload Form -->
                <div class="form-card">
                    <h2><i class="fas fa-upload"></i> Upload Image</h2>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category" required>
                                <option value="">Select Category</option>
                                <option value="college">College</option>
                                <option value="events">Events</option>
                                <option value="arts">Arts & Culture</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Title (Optional)</label>
                            <input type="text" name="title" placeholder="Enter image title">
                        </div>
                        
                        <div class="form-group">
                            <label>Image *</label>
                            <label class="file-upload">
                                <input type="file" name="image" accept="image/*" required>
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click to upload image</p>
                                <p style="font-size: 0.8rem; color: var(--gray-600);">JPG, PNG, GIF, WebP</p>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-upload"></i> Upload Image
                        </button>
                    </form>
                </div>
                
                <!-- Gallery Grid -->
                <div class="table-card">
                    <h2>All Images</h2>
                    
                    <!-- Category Filters -->
                    <div class="category-filters">
                        <a href="?category=all" class="filter-btn <?php echo $category === 'all' ? 'active' : ''; ?>">All</a>
                        <a href="?category=college" class="filter-btn <?php echo $category === 'college' ? 'active' : ''; ?>">College</a>
                        <a href="?category=events" class="filter-btn <?php echo $category === 'events' ? 'active' : ''; ?>">Events</a>
                        <a href="?category=arts" class="filter-btn <?php echo $category === 'arts' ? 'active' : ''; ?>">Arts & Culture</a>
                    </div>
                    
                    <?php if (empty($gallery)): ?>
                        <div class="empty-state">
                            <i class="fas fa-images"></i>
                            <p>No images uploaded yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="gallery-grid">
                            <?php foreach ($gallery as $image): ?>
                                <div class="gallery-item">
                                    <img src="../<?php echo GALLERY_UPLOAD_PATH . sanitize($image['image_path']); ?>" alt="<?php echo sanitize($image['title'] ?? 'Gallery Image'); ?>">
                                    <div class="gallery-item-overlay">
                                        <span><?php echo sanitize($image['title'] ?? ucfirst($image['category'])); ?></span>
                                        <a href="?delete=<?php echo $image['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this image?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>