<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get all courses
$stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - National College, Nadakakvu</title>
    <meta name="description" content="Explore our diverse range of courses at National College, Nadakakvu">
    
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
            <h1>Our Courses</h1>
            <p>Explore our diverse range of academic programs</p>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses-section section">
        <div class="container">
            <?php if (empty($courses)): ?>
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h3>No Courses Available</h3>
                    <p>Course information will be updated soon. Please check back later.</p>
                    <a href="contact.php" class="btn btn-primary" style="margin-top: 20px;">Contact Us for More Info</a>
                </div>
            <?php else: ?>
                <div class="courses-grid">
                    <?php foreach ($courses as $course): ?>
                        <div class="course-card">
                            <div class="course-header">
                                <h3><?php echo sanitize($course['name']); ?></h3>
                                <span><i class="fas fa-clock"></i> <?php echo sanitize($course['duration']); ?></span>
                            </div>
                            <div class="course-body">
                                <div class="course-info">
                                    <div class="course-info-item">
                                        <i class="fas fa-graduation-cap"></i>
                                        <strong>Eligibility:</strong>
                                        <span><?php echo sanitize($course['eligibility']); ?></span>
                                    </div>
                                </div>
                                <p class="course-description"><?php echo sanitize($course['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: var(--gray-100); text-align: center;">
        <div class="container">
            <h2 style="color: var(--primary); margin-bottom: 20px;">Not Sure Which Course to Choose?</h2>
            <p style="color: var(--gray-600); margin-bottom: 30px;">Our counselors are here to help you find the right path for your career.</p>
            <a href="contact.php" class="btn btn-primary">Talk to Our Counselors</a>
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

    <!-- Scripts -->
    <script src="js/main.js"></script>
</body>
</html>