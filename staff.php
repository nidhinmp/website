<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get all staff
$stmt = $pdo->query("SELECT * FROM staff ORDER BY id DESC");
$staff = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff & Faculty - National College, Nadakakvu</title>
    <meta name="description" content="Meet our experienced and dedicated faculty members at National College, Nadakakvu">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="nav-logo">
                <i class="fas fa-graduation-cap"></i>
                <div>
                    <h1>National College</h1>
                    <span>Nadakakvu</span>
                </div>
            </a>
            <div class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="about.php" class="nav-link">About</a></li>
                <li><a href="courses.php" class="nav-link">Courses</a></li>
                <li><a href="staff.php" class="nav-link">Staff</a></li>
                <li><a href="gallery.php" class="nav-link">Gallery</a></li>
                <li><a href="contact.php" class="nav-link">Contact</a></li>
                <li><a href="admin/login.php" class="nav-link" target="_blank"><i class="fas fa-user-shield"></i> Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Our Faculty</h1>
            <p>Meet our experienced and dedicated team</p>
        </div>
    </section>

    <!-- Staff Section -->
    <section class="staff-section section">
        <div class="container">
            <?php if (empty($staff)): ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>No Staff Details Available</h3>
                    <p>Staff information will be updated soon.</p>
                </div>
            <?php else: ?>
                <div class="staff-grid">
                    <?php foreach ($staff as $member): ?>
                        <div class="staff-card">
                            <?php if ($member['image']): ?>
                                <img src="<?php echo STAFF_UPLOAD_PATH . sanitize($member['image']); ?>" alt="<?php echo sanitize($member['name']); ?>" class="staff-image">
                            <?php else: ?>
                                <div class="staff-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            <div class="staff-info">
                                <h3><?php echo sanitize($member['name']); ?></h3>
                                <p class="designation"><?php echo sanitize($member['designation']); ?></p>
                                <p class="department"><?php echo sanitize($member['department']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>National College</h3>
                    <p>Empowering future leaders through quality education and innovation.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="courses.php">Courses</a></li>
                        <li><a href="staff.php">Staff</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo SITE_ADDRESS; ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo SITE_PHONE; ?></p>
                    <p><i class="fas fa-envelope"></i> <?php echo SITE_EMAIL; ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> National College, Nadakakvu. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating Buttons -->
    <div class="floating-buttons">
        <a href="https://wa.me/<?php echo str_replace(' ', '', SITE_PHONE); ?>" class="float-btn whatsapp-btn" target="_blank" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="tel:<?php echo SITE_PHONE; ?>" class="float-btn phone-btn" title="Call Us">
            <i class="fas fa-phone"></i>
        </a>
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Gallery Image">
    </div>

    <!-- Scripts -->
    <script src="js/main.js"></script>
</body>
</html>