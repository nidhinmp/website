<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - <?php echo SITE_NAME; ?></title>
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
                    <li><a href="about.php" class="nav-link active">About Us</a></li>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-title">About Us</h1>
            <p class="page-breadcrumb"><a href="index.php">Home</a> / About Us</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=600&h=400&fit=crop" alt="College Building">
                </div>
                <div class="about-content">
                    <h3>Our History</h3>
                    <p><?php echo SITE_NAME; ?> has been a beacon of quality education since its establishment. Our college has consistently strived to provide the best academic environment for students to excel in their chosen fields.</p>
                    <p>Over the years, we have built a reputation for academic excellence, character development, and producing graduates who make significant contributions to society.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Vision Section -->
    <section class="section section-light">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <h3>Our Mission</h3>
                    <p>To provide quality education that empowers students to become competent professionals and responsible citizens. We are committed to fostering intellectual growth, ethical values, and social responsibility in our students.</p>
                </div>
                <div class="about-content">
                    <h3>Our Vision</h3>
                    <p>To be a center of excellence in higher education, producing leaders who will contribute meaningfully to the development of the nation and the world at large.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Principal Message -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Message</span>
                <h2 class="section-title">Principal's Message</h2>
            </div>
            <div class="about-grid">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&h=400&fit=crop" alt="Principal">
                </div>
                <div class="about-content">
                    <h3>Dear Students and Parents,</h3>
                    <p>Welcome to <?php echo SITE_NAME; ?>! It gives me great pleasure to lead an institution that has been at the forefront of academic excellence.</p>
                    <p>Our college is committed to providing an environment that nurtures academic achievement, personal growth, and character development. We believe in holistic education that prepares students not just for careers, but for life.</p>
                    <p>Our dedicated faculty, state-of-the-art facilities, and comprehensive curriculum ensure that every student receives the best possible education. We encourage all our students to actively participate in academic and co-curricular activities to develop their full potential.</p>
                    <p>I invite you to explore our college and join us in our mission to shape the leaders of tomorrow.</p>
                    <p><strong>Dr. Rajesh Kumar</strong><br>Principal, <?php echo SITE_NAME; ?></p>
                </div>
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