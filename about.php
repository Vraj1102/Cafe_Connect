<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body { padding-top: 85px; }
        .hero-section {
            background: linear-gradient(135deg, #2C1810 0%, #8B4513 50%, #D2691E 100%);
            color: white;
            padding: 4rem 0;
        }
        .team-card {
            transition: transform 0.3s ease;
        }
        .team-card:hover {
            transform: translateY(-5px);
        }
    </style>
    <title>About Us | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('includes/nav_header.php'); ?>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">About CafeConnect</h1>
            <p class="lead">Connecting communities through exceptional food experiences</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Our Story -->
        <div class="row mb-5">
            <div class="col-lg-6">
                <h2 class="cc-text-coffee mb-4">Our Story</h2>
                <p class="lead">CafeConnect was born from a simple idea: making great food accessible to everyone while supporting local businesses.</p>
                <p>We recognized the challenges faced by both food lovers and cafe owners - customers wanted convenient access to quality food, while shop owners needed a platform to reach more customers efficiently.</p>
                <p>Our platform bridges this gap by providing a seamless, user-friendly experience that benefits everyone in the food ecosystem.</p>
            </div>
            <div class="col-lg-6">
                <img src="assets/img/Coffee Shop banner.jpg" class="img-fluid rounded shadow" alt="CafeConnect Story">
            </div>
        </div>

        <!-- Our Mission -->
        <div class="row mb-5">
            <div class="col-lg-6 order-lg-2">
                <h2 class="cc-text-coffee mb-4">Our Mission</h2>
                <div class="mb-4">
                    <h5><i class="bi bi-heart-fill text-danger me-2"></i>For Food Lovers</h5>
                    <p>Discover amazing local cafes, enjoy hassle-free ordering, and never miss out on your favorite meals.</p>
                </div>
                <div class="mb-4">
                    <h5><i class="bi bi-shop text-success me-2"></i>For Cafe Owners</h5>
                    <p>Grow your business with our easy-to-use platform, reach more customers, and manage orders efficiently.</p>
                </div>
                <div class="mb-4">
                    <h5><i class="bi bi-people-fill text-primary me-2"></i>For Communities</h5>
                    <p>Strengthen local food culture by connecting neighbors with their favorite local eateries.</p>
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <img src="assets/img/homepic1.jpg" class="img-fluid rounded shadow" alt="Our Mission">
            </div>
        </div>

        <!-- Our Values -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="cc-text-coffee">Our Values</h2>
                <p class="lead text-muted">The principles that guide everything we do</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <i class="bi bi-shield-check" style="font-size: 3rem; color: var(--cc-coffee-brown);"></i>
                    <h4 class="mt-3 cc-text-espresso">Quality First</h4>
                    <p>We partner only with cafes that meet our high standards for food quality and service.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <i class="bi bi-lightning-charge" style="font-size: 3rem; color: var(--cc-fresh-green);"></i>
                    <h4 class="mt-3 cc-text-espresso">Innovation</h4>
                    <p>Continuously improving our platform with the latest technology and user feedback.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center p-4">
                    <i class="bi bi-heart" style="font-size: 3rem; color: var(--cc-caramel);"></i>
                    <h4 class="mt-3 cc-text-espresso">Community</h4>
                    <p>Building stronger communities by supporting local businesses and bringing people together.</p>
                </div>
            </div>
        </div>

        <!-- Our Team -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2 class="cc-text-coffee">Meet Our Developer</h2>
                <p class="lead text-muted">The passionate mind behind CafeConnect</p>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <div class="col-md-4">
                    <div class="card team-card border-0 shadow-sm text-center p-4">
                        <div class="mx-auto mb-3" style="width: 120px; height: 120px; background: linear-gradient(135deg, #8B4513, #D2691E); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="cc-text-espresso">Vraj Patel</h4>
                        <p class="text-muted">Full Stack Developer</p>
                        <p class="small">Passionate about creating seamless user experiences, robust backend systems, and beautiful interfaces that users love to interact with.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="row">
            <div class="col-12">
                <div class="cc-bg-cream p-5 rounded text-center">
                    <h3 class="cc-text-coffee mb-3">Get In Touch</h3>
                    <p class="lead mb-4">Have questions or want to partner with us? We'd love to hear from you!</p>
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-envelope-fill cc-text-coffee me-2"></i>
                            <strong>Email:</strong> hello@cafeconnect.com
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-telephone-fill cc-text-coffee me-2"></i>
                            <strong>Phone:</strong> +1 (555) 123-CAFE
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="bi bi-geo-alt-fill cc-text-coffee me-2"></i>
                            <strong>Location:</strong> Multiple Cities
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-light mt-auto" style="background: linear-gradient(135deg, #2C1810 0%, #8B4513 50%, #D2691E 100%);">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="assets/img/landing_logo.png" width="50" class="me-3" alt="CafeConnect">
                        <div>
                            <h4 class="mb-0 text-white fw-bold">CafeConnect</h4>
                            <small class="text-light fst-italic">"Brewing Connections"</small>
                        </div>
                    </div>
                    <p class="text-light mb-3">Your premier destination for exceptional coffee experiences and delicious food, connecting communities one cup at a time.</p>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Home</a></li>
                        <li class="mb-2"><a href="customer/shop_list.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Our Cafes</a></li>
                        <li class="mb-2"><a href="about.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> About Us</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3">Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-cup-hot"></i> Fresh Coffee</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-basket"></i> Online Ordering</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-clock"></i> Pre-Orders</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-truck"></i> Quick Pickup</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3">Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light"><i class="bi bi-geo-alt"></i> Multiple Locations</li>
                        <li class="mb-2 text-light"><i class="bi bi-telephone"></i> +1 (555) 123-CAFE</li>
                        <li class="mb-2 text-light"><i class="bi bi-envelope"></i> hello@cafeconnect.com</li>
                        <li class="mb-2 text-light"><i class="bi bi-clock"></i> Open Daily 7AM - 9PM</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 border-light">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light">&copy; 2024 CafeConnect. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-light text-decoration-none me-3">Terms of Service</a>
                    <a href="about.php" class="text-light text-decoration-none">About Us</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>