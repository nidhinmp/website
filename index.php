<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Get courses
$stmt = $pdo->query("SELECT * FROM courses ORDER BY id DESC LIMIT 6");
$courses = $stmt->fetchAll();

// Get staff
$stmt = $pdo->query("SELECT * FROM staff ORDER BY id DESC LIMIT 4");
$staff = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National College, Nadakakvu - Home</title>
    <meta name="description" content="National College, Nadakakvu - Empowering Future Leaders Through Quality Education">
    
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="animate-fade">National College, Nadakakvu</h1>
            <p class="animate-fade animate-delay-1"><?php echo SITE_TAGLINE; ?></p>
            <div class="hero-buttons animate-fade animate-delay-2">
                <a href="courses.php" class="btn btn-accent">Explore Courses</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=600&h=400&fit=crop" alt="College Building">
                </div>
                <div class="about-content">
                    <h2 class="section-title">Welcome to National College</h2>
                    <p>National College, Nadakakvu is a premier educational institution committed to providing quality education and fostering academic excellence. Our college has been a beacon of learning, shaping the minds and careers of thousands of students.</p>
                    <p>With a rich history and a vision for the future, we continue to innovate and adapt to the changing educational landscape while maintaining our core values of integrity, excellence, and service.</p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-award"></i></div>
                            <div>
                                <strong>Quality Education</strong>
                                <p>Industry-relevant curriculum</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-users"></i></div>
                            <div>
                                <strong>Expert Faculty</strong>
                                <p>Experienced & dedicated</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-flask"></i></div>
                            <div>
                                <strong>Modern Facilities</strong>
                                <p>State-of-the-art infrastructure</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-globe"></i></div>
                            <div>
                                <strong>Global Exposure</strong>
                                <p>International opportunities</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Highlights Section -->
    <section class="highlights-section section">
        <div class="container">
            <h2 class="section-title text-center" style="display: block;">Why Choose Us</h2>
            <p class="section-subtitle text-center">Excellence in education, innovation in learning</p>
            
            <div class="highlights-grid">
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-book"></i></div>
                    <h3>Diverse Courses</h3>
                    <p>Wide range of undergraduate and postgraduate programs across various disciplines</p>
                </div>
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-building"></i></div>
                    <h3>Modern Infrastructure</h3>
                    <p>Well-equipped laboratories, library, sports facilities, and comfortable campus</p>
                </div>
                <div class="highlight-card">
                    <div class="highlight-icon"><i class="fas fa-trophy"></i></div>
                    <h3>Achievements</h3>
                    <p>Consistent academic excellence with numerous awards and recognitions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="courses-section section">
        <div class="container">
            <h2 class="section-title text-center" style="display: block;">Our Courses</h2>
            <p class="section-subtitle text-center">Explore our diverse range of academic programs</p>
            
            <div class="courses-grid">
                <?php if (empty($courses)): ?>
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-book-open"></i>
                        <h3>No Courses Available</h3>
                        <p>Course information will be updated soon.</p>
                    </div>
                <?php else: ?>
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
                                <p class="course-description"><?php echo sanitize(substr($course['description'], 0, 150)); ?>...</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="text-center" style="margin-top: 40px;">
                <a href="courses.php" class="btn btn-primary">View All Courses <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Staff Section -->
    <section class="staff-section section">
        <div class="container">
            <h2 class="section-title text-center" style="display: block;">Our Faculty</h2>
            <p class="section-subtitle text-center">Meet our experienced and dedicated team</p>
            
            <div class="staff-grid">
                <?php if (empty($staff)): ?>
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-users"></i>
                        <h3>No Staff Details Available</h3>
                        <p>Staff information will be updated soon.</p>
                    </div>
                <?php else: ?>
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
                <?php endif; ?>
            </div>
            
            <div class="text-center" style="margin-top: 40px;">
                <a href="staff.php" class="btn btn-primary">View All Staff <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section section">
        <div class="container">
            <h2 class="section-title text-center" style="display: block;">Gallery</h2>
            <p class="section-subtitle text-center">Glimpses of our campus life</p>
            
            <?php
            $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC LIMIT 6");
            $gallery = $stmt->fetchAll();
            ?>
            
            <div class="gallery-grid">
                <?php if (empty($gallery)): ?>
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class="fas fa-images"></i>
                        <h3>No Images Available</h3>
                        <p>Gallery will be updated soon.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($gallery as $image): ?>
                        <div class="gallery-item" data-category="<?php echo sanitize($image['category']); ?>">
                            <img src="<?php echo GALLERY_UPLOAD_PATH . sanitize($image['image_path']); ?>" alt="<?php echo sanitize($image['title'] ?? 'Gallery Image'); ?>">
                            <div class="gallery-overlay">
                                <span><?php echo sanitize($image['title'] ?? ucfirst($image['category'])); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="text-center" style="margin-top: 40px;">
                <a href="gallery.php" class="btn btn-primary">View Full Gallery <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; text-align: center;">
        <div class="container">
            <h2 style="font-size: 2.2rem; margin-bottom: 20px;">Ready to Shape Your Future?</h2>
            <p style="font-size: 1.1rem; margin-bottom: 30px; opacity: 0.9;">Join National College, Nadakakvu and embark on a journey of academic excellence.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="contact.php" class="btn btn-accent">Apply Now</a>
                <a href="about.php" class="btn btn-outline">Learn More</a>
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

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <span class="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Gallery Image">
    </div>

    <!-- Scripts -->
    <script src="js/main.js"></script>
</body>
</html>