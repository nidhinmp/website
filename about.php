<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get principal message if exists
$stmt = $pdo->query("SELECT * FROM staff WHERE department = 'Principal' LIMIT 1");
$principal = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - National College, Nadakakvu</title>
    <meta name="description" content="Learn about National College, Nadakakvu - Our history, mission, vision, and leadership">
    
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
            <h1>About Us</h1>
            <p>Discover our legacy and commitment to excellence</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=600&h=400&fit=crop" alt="College Campus">
                </div>
                <div class="about-content">
                    <h2 class="section-title">Our Story</h2>
                    <p>National College, Nadakakvu was established with a vision to provide quality higher education to the students of the region. Over the years, we have grown from strength to strength, becoming one of the most reputed educational institutions in the area.</p>
                    <p>Our college is dedicated to fostering academic excellence, character development, and overall growth of every student. We believe in a holistic approach to education that combines theoretical knowledge with practical skills.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="section" style="background: var(--gray-100);">
        <div class="container">
            <div class="about-grid" style="grid-template-columns: repeat(2, 1fr); gap: 40px;">
                <div class="about-content" style="background: white; padding: 40px; border-radius: var(--border-radius); box-shadow: var(--shadow);">
                    <h3 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px;"><i class="fas fa-bullseye" style="color: var(--accent); margin-right: 10px;"></i> Our Mission</h3>
                    <p style="color: var(--gray-600);">To provide accessible, quality education that empowers students to become responsible citizens and leaders in their chosen fields. We are committed to fostering intellectual growth, critical thinking, and moral values.</p>
                </div>
                <div class="about-content" style="background: white; padding: 40px; border-radius: var(--border-radius); box-shadow: var(--shadow);">
                    <h3 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 20px;"><i class="fas fa-eye" style="color: var(--accent); margin-right: 10px;"></i> Our Vision</h3>
                    <p style="color: var(--gray-600);">To be a center of excellence in education, research, and community service, producing graduates who are well-prepared to meet the challenges of a rapidly changing world while maintaining strong ethical values.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Principal Message -->
    <section class="principal-section section">
        <div class="container">
            <h2 class="section-title text-center" style="display: block;">Message from the Principal</h2>
            <p class="section-subtitle text-center">A word from our leadership</p>
            
            <div class="principal-card" style="max-width: 900px; margin: 0 auto;">
                <div class="principal-image">
                    <?php if ($principal && $principal['image']): ?>
                        <img src="<?php echo STAFF_UPLOAD_PATH . sanitize($principal['image']); ?>" alt="<?php echo sanitize($principal['name']); ?>">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=300&h=350&fit=crop" alt="Principal">
                    <?php endif; ?>
                </div>
                <div class="principal-content">
                    <?php if ($principal): ?>
                        <h3><?php echo sanitize($principal['name']); ?></h3>
                        <p class="role"><?php echo sanitize($principal['designation']); ?></p>
                    <?php else: ?>
                        <h3>Dr. Principal Name</h3>
                        <p class="role">Principal</p>
                    <?php endif; ?>
                    <p>Welcome to National College, Nadakakvu. It gives me great pleasure to welcome you to our college website. At National College, we believe in nurturing talent and providing opportunities for holistic development.</p>
                    <p>Our dedicated faculty, state-of-the-art infrastructure, and student-centric approach ensure that every student receives the best possible education. We encourage our students to think critically, innovate, and contribute meaningfully to society.</p>
                    <p>I invite you to explore our college and join us in our mission to shape the leaders of tomorrow.</p>
                    <p style="margin-top: 20px; font-style: italic;">- Principal</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section" style="background: var(--white);">
        <div class="container">
            <h2 class="section-title text-center" style="display: block;">Our Core Values</h2>
            <p class="section-subtitle text-center">The principles that guide us</p>
            
            <div class="highlights-grid">
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-star"></i></div>
                    <h3>Excellence</h3>
                    <p>Striving for the highest standards in everything we do</p>
                </div>
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-heart"></i></div>
                    <h3>Integrity</h3>
                    <p>Building character through honesty and ethical practices</p>
                </div>
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-users"></i></div>
                    <h3>Teamwork</h3>
                    <p>Fostering collaboration and mutual respect</p>
                </div>
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-lightbulb"></i></div>
                    <h3>Innovation</h3>
                    <p>Encouraging creative thinking and new ideas</p>
                </div>
            </div>
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