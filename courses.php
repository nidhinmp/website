<?php
require_once 'config.php';

// Get all courses
$stmt = $pdo->query("SELECT * FROM courses ORDER BY name ASC");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - <?php echo SITE_NAME; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">
                    <div class="logo-icon">NC</div>
                    <div class="logo-text">
                        <?php echo SITE_NAME; ?>
                        <span><?php echo SITE_TAGLINE; ?></span>
                    </div>
                </a>
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <li><a href="about.php" class="nav-link">About Us</a></li>
                    <li><a href="courses.php" class="nav-link active">Courses</a></li>
                    <li><a href="staff.php" class="nav-link">Staff</a></li>
                    <li><a href="gallery.php" class="nav-link">Gallery</a></li>
                    <li><a href="contact.php" class="nav-link">Contact</a></li>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">Our Courses</h1>
            <p class="page-breadcrumb"><a href="index.php">Home</a> / Courses</p>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Academic Programs</span>
                <h2 class="section-title">Explore Our Courses</h2>
                <p class="section-subtitle">We offer a wide range of undergraduate and postgraduate programs</p>
            </div>
            
            <?php if (count($courses) > 0): ?>
            <div class="courses-grid">
                <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <div class="course-header">
                        <div class="course-icon"><i class="fas fa-book-open"></i></div>
                        <h3 class="course-name"><?php echo htmlspecialchars($course['name']); ?></h3>
                    </div>
                    <div class="course-body">
                        <div class="course-detail">
                            <i class="fas fa-clock"></i>
                            <span>Duration: <?php echo htmlspecialchars($course['duration']); ?></span>
                        </div>
                        <div class="course-detail">
                            <i class="fas fa-user-graduate"></i>
                            <span>Eligibility: <?php echo htmlspecialchars($course['eligibility']); ?></span>
                        </div>
                        <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-book"></i>
                <h3>No courses available</h3>
                <p>Please check back later for our course offerings.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <div class="logo-text"><?php echo SITE_NAME; ?></div>
                    <p>Empowering future leaders through quality education and holistic development since our inception.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="courses.php">Courses</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4 class="footer-title">Academics</h4>
                    <ul>
                        <li><a href="courses.php">UG Programs</a></li>
                        <li><a href="courses.php">PG Programs</a></li>
                        <li><a href="staff.php">Faculty</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4 class="footer-title">Contact</h4>
                    <ul>
                        <li><?php echo SITE_ADDRESS; ?></li>
                        <li><?php echo SITE_PHONE; ?></li>
                        <li><?php echo SITE_EMAIL; ?></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating Buttons -->
    <div class="floating-buttons">
        <a href="https://wa.me/<?php echo WHATSAPP_NUMBER; ?>" class="float-btn whatsapp-btn" target="_blank" title="Chat on WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="tel:<?php echo SITE_PHONE; ?>" class="float-btn phone-btn" title="Call Us">
            <i class="fas fa-phone-alt"></i>
        </a>
    </div>

    <script src="js/main.js"></script>
</body>
</html>