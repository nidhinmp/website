<?php
require_once 'config.php';

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total FROM courses");
$coursesCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM staff");
$staffCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM gallery");
$galleryCount = $stmt->fetch()['total'];

// Get featured courses
$stmt = $pdo->query("SELECT * FROM courses LIMIT 6");
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Empowering Future Leaders</title>
    <meta name="description" content="National College Nadakakvu - Quality education for a brighter future">
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
                    <li><a href="index.php" class="nav-link active">Home</a></li>
                    <li><a href="about.php" class="nav-link">About Us</a></li>
                    <li><a href="courses.php" class="nav-link">Courses</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Established with Excellence</span>
                <h1 class="hero-title"><?php echo SITE_NAME; ?></h1>
                <p class="hero-subtitle"><?php echo SITE_TAGLINE; ?> - Building tomorrow's leaders through quality education and holistic development</p>
                <div class="hero-buttons">
                    <a href="courses.php" class="btn btn-primary">
                        <i class="fas fa-graduation-cap"></i> Explore Courses
                    </a>
                    <a href="contact.php" class="btn btn-secondary">
                        <i class="fas fa-envelope"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">About Us</span>
                <h2 class="section-title">Welcome to National College</h2>
                <p class="section-subtitle">Nurturing excellence in education for over decades</p>
            </div>
            <div class="about-grid">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=600&h=400&fit=crop" alt="College Building">
                </div>
                <div class="about-content">
                    <h3>Excellence in Education</h3>
                    <p><?php echo SITE_NAME; ?> is a premier educational institution committed to providing quality education that empowers students to achieve their full potential. Our college has been at the forefront of academic excellence and holistic development.</p>
                    <p>We believe in nurturing not just academically brilliant students, but well-rounded individuals who are prepared to face the challenges of the modern world with confidence and competence.</p>
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-user-graduate"></i></div>
                            <span class="feature-text">Expert Faculty</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-book"></i></div>
                            <span class="feature-text">Quality Education</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-laptop-code"></i></div>
                            <span class="feature-text">Modern Facilities</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-trophy"></i></div>
                            <span class="feature-text">Excellence Awards</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="stat-number"><?php echo $coursesCount; ?>+</div>
                    <div class="stat-label">Courses Offered</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number"><?php echo $staffCount; ?>+</div>
                    <div class="stat-label">Expert Faculty</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Students Enrolled</div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-award"></i></div>
                    <div class="stat-number"><?php echo $galleryCount; ?>+</div>
                    <div class="stat-label">Events & Activities</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Courses</span>
                <h2 class="section-title">Academic Programs</h2>
                <p class="section-subtitle">Explore our diverse range of courses designed to shape your future</p>
            </div>
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
            <div style="text-align: center; margin-top: 40px;">
                <a href="courses.php" class="btn btn-primary">View All Courses</a>
            </div>
        </div>
    </section>

    <!-- Staff Section -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Team</span>
                <h2 class="section-title">Meet Our Faculty</h2>
                <p class="section-subtitle">Learn from experienced and dedicated educators</p>
            </div>
            <?php
            $stmt = $pdo->query("SELECT * FROM staff LIMIT 4");
            $staffMembers = $stmt->fetchAll();
            ?>
            <div class="staff-grid">
                <?php foreach ($staffMembers as $staffMember): ?>
                <div class="staff-card">
                    <div class="staff-image">
                        <?php if ($staffMember['image'] && file_exists($staffMember['image'])): ?>
                            <img src="<?php echo htmlspecialchars($staffMember['image']); ?>" alt="<?php echo htmlspecialchars($staffMember['name']); ?>">
                        <?php else: ?>
                            <div class="placeholder"><i class="fas fa-user"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="staff-info">
                        <h3 class="staff-name"><?php echo htmlspecialchars($staffMember['name']); ?></h3>
                        <p class="staff-designation"><?php echo htmlspecialchars($staffMember['designation']); ?></p>
                        <p class="staff-department"><?php echo htmlspecialchars($staffMember['department']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="staff.php" class="btn btn-primary">View All Staff</a>
            </div>
        </div>
    </section>

    <!-- Gallery Preview -->
    <section class="section section-light">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Gallery</span>
                <h2 class="section-title">Life at National College</h2>
                <p class="section-subtitle">Capturing moments of excellence and achievement</p>
            </div>
            <?php
            $stmt = $pdo->query("SELECT * FROM gallery ORDER BY uploaded_at DESC LIMIT 6");
            $galleryImages = $stmt->fetchAll();
            ?>
            <div class="gallery-grid">
                <?php foreach ($galleryImages as $image): ?>
                <div class="gallery-item" data-category="<?php echo htmlspecialchars($image['category']); ?>">
                    <?php if (file_exists($image['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="Gallery Image">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop" alt="Gallery Image">
                    <?php endif; ?>
                    <div class="gallery-overlay">
                        <span class="gallery-category"><?php echo htmlspecialchars(ucfirst($image['category'])); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="gallery.php" class="btn btn-primary">View Full Gallery</a>
            </div>
        </div>
    </section>

    <!-- Contact Preview -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Get in Touch</span>
                <h2 class="section-title">Contact Us</h2>
                <p class="section-subtitle">We'd love to hear from you</p>
            </div>
            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3 class="contact-title">Address</h3>
                    <p class="contact-info"><?php echo SITE_ADDRESS; ?></p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                    <h3 class="contact-title">Phone</h3>
                    <p class="contact-info"><a href="tel:<?php echo SITE_PHONE; ?>"><?php echo SITE_PHONE; ?></a></p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <h3 class="contact-title">Email</h3>
                    <p class="contact-info"><a href="mailto:<?php echo SITE_EMAIL; ?>"><?php echo SITE_EMAIL; ?></a></p>
                </div>
            </div>
            <div style="text-align: center;">
                <a href="contact.php" class="btn btn-primary">Send Enquiry</a>
            </div>
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