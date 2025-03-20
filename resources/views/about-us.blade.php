<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>About Us - Medibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Learn about Medibook Hospital's mission, services, and commitment to healthcare excellence.">

    <!-- App favicon -->
    <link rel="shortcut icon" href="build\images\assets\favicon2.png">

    <!-- App css -->
    <link href="build\css\bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="build\css\icons.min.css" rel="stylesheet" type="text/css" />
    <link href="build\css\app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="landing-page">
        <!-- header nav bar start  -->
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top navbar-custom sticky sticky-light" id="navbar">
                <div class="container">
                    <a class="navbar-brand logo" href="/">
                        <img src="build\images\logo2.png" alt="logo-dark" height="22">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('about.us') }}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                            </li>
                        </ul>
                        <div class="nav-btn" style="margin-right: 10px;">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="mdi mdi-login me-2"></i>Log in</a>
                        </div>
                        
                        <div class="nav-btn" style="margin-right: 10px;">
                            <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="mdi mdi-account-plus me-2"></i>Register</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- header nav bar end  -->

        <!-- Hero Section -->
        <section class="hero-section bg-img" id="home">
            <div class="container">
                <!-- row start  -->
                <div class="row align-items-center justify-content-between g-3 g-lg-5">
                    <div class="col-lg-5 align-self-start">
                        <div class="hero-content">
                            <div class="title-sm my-4">
                                <h4 class="text-success">About Medibook</h4>
                            </div>
                            <div class="hero-header">
                                <h1 class="display-6 lh-base fw-medium">Best Healthcare 
                                    <span class="text-primary">Management</span></h1>
                                <h1 class="display-6 lh-base fw-medium">Solutions For</h1>
                                <h1 class="display-6 lh-base fw-medium">Hospitals & Laboratories</h1>
                                <p>Providing exceptional healthcare services with compassion and excellence since 2010. Transforming healthcare delivery through innovation and dedication.</p>
                            </div>
                            <div class="hero-btn mt-4">
                                <a href="{{ route('contact') }}" class="btn btn-primary">
                                <i class="mdi mdi-phone me-2"></i>Contact Us</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 align-self-end">
                        <div class="img-part ms-auto">
                            <img src="build\images\landing\doctor-team.png" alt="Hospital Building" class="img-fluid img-width">
                            <div class="img-text text-center p-3 pb-1 rounded-3">
                                <i class="mdi mdi-hospital-building"></i>
                                <p class="my-2 fw-semibold">24/7 Healthcare</p>
                                <div class="mb-3">
                                    <span>Comprehensive Medical Services</span>
                                </div>
                            </div>
                            <div class="img-text-1 text-start rounded-3 px-3 p-2">
                                <i class="mdi mdi-doctor"></i>
                                <div class="text">
                                    <p class="pt-2 pb-2 ms-4 fw-semibold mb-0">Expert Medical Team</p>
                                    <div class="ms-4">
                                        <span>All Specialties</span>
                                    </div>
                                </div>
                            </div>
                            <div class="img-text-2 text-center p-2 px-3 rounded-3">
                                <i class="mdi mdi-cast-education"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row end  -->
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="section py-5">
            <div class="container">
                <div class="row g-4 text-center">
                    <div class="col-md-3">
                        <div class="p-4">
                            <h2 class="display-4 fw-bold text-primary mb-3">12+</h2>
                            <p class="lead">Years of Excellence</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4">
                            <h2 class="display-4 fw-bold text-primary mb-3">10+</h2>
                            <p class="lead">Countries Served</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4">
                            <h2 class="display-4 fw-bold text-primary mb-3">50+</h2>
                            <p class="lead">Cities Covered</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-4">
                            <h2 class="display-4 fw-bold text-primary mb-3">30K+</h2>
                            <p class="lead">Doctors</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="section py-5 bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="display-5 fw-bold mb-4">Our Story</h2>
                        <p class="lead mb-4">Medibook Hospital began its journey in 2010 with a vision to revolutionize healthcare delivery. What started as a single facility has grown into a comprehensive healthcare network serving communities across multiple cities.</p>
                        <p>Over the years, we have continuously evolved and expanded our services to meet the growing healthcare needs of our patients. Our commitment to excellence and innovation has made us one of the leading healthcare providers in the region.</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="build\images\landing\mission.png" alt="Our Story" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </section>

        <!-- Vision & Mission Section -->
        <section class="section py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-4">Our Vision</h3>
                                <p>To be the leading healthcare provider, recognized for excellence in patient care, medical innovation, and community health improvement.</p>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="mdi mdi-check-circle text-primary me-2"></i>
                                        Global Healthcare Leadership
                                    </li>
                                    <li class="mb-3">
                                        <i class="mdi mdi-check-circle text-primary me-2"></i>
                                        Medical Innovation
                                    </li>
                                    <li class="mb-3">
                                        <i class="mdi mdi-check-circle text-primary me-2"></i>
                                        Community Health
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="fw-bold mb-4">Our Mission</h3>
                                <p>To provide exceptional healthcare services with compassion, innovation, and excellence, making quality healthcare accessible to all.</p>
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="mdi mdi-check-circle text-primary me-2"></i>
                                        Quality Healthcare for All
                                    </li>
                                    <li class="mb-3">
                                        <i class="mdi mdi-check-circle text-primary me-2"></i>
                                        Patient-Centered Care
                                    </li>
                                    <li class="mb-3">
                                        <i class="mdi mdi-check-circle text-primary me-2"></i>
                                        Medical Excellence
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Commitment Section -->
        <section class="section py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold">Our Commitment</h2>
                    <p class="lead">Dedicated to providing the best healthcare experience</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="mdi mdi-heart-pulse display-4 text-primary mb-3"></i>
                            <h5>Patient Care</h5>
                            <p>Compassionate and personalized care</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="mdi mdi-shield-check display-4 text-primary mb-3"></i>
                            <h5>Quality</h5>
                            <p>High standards of medical excellence</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="mdi mdi-clock-outline display-4 text-primary mb-3"></i>
                            <h5>Accessibility</h5>
                            <p>Easy access to healthcare services</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="mdi mdi-account-group display-4 text-primary mb-3"></i>
                            <h5>Community</h5>
                            <p>Supporting community health</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="section py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold">Our Leadership Team</h2>
                    <p class="lead">Meet the people behind our success</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <img src="build\images\landing\doctor-1.jpg" alt="CEO" class="rounded-circle mb-3" width="150">
                                <h4>Dr. John Smith</h4>
                                <p class="text-muted">Chief Executive Officer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <img src="build\images\landing\doctor-2.jpg" alt="Medical Director" class="rounded-circle mb-3" width="150">
                                <h4>Dr. Sarah Johnson</h4>
                                <p class="text-muted">Medical Director</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <img src="build\images\landing\doctor-3.jpg" alt="Head of Operations" class="rounded-circle mb-3" width="150">
                                <h4>Dr. Michael Brown</h4>
                                <p class="text-muted">Head of Operations</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="section footer-section bg-dark">
            <div class="container">
                <div class="row justify-content-between g-2">
                    <div class="col-lg-4">
                        <a class="brand-logo" href="/">
                            <img src="build\images\logo-light.png" alt="" height="22">
                        </a>
                        <p class="mt-4 text-white-50">Expert healthcare services for comprehensive medical care.</p>
                        <div class="footer-btn mt-4">
                            <h5>Subscribe :</h5>
                            <a href="#" class="btn btn-light">Subscribe to more</a>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <h5>Services :</h5>
                        <ul>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Emergency Care</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Specialized Treatment</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Laboratory Services</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Pharmacy</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Rehabilitation</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5>Quick Links :</h5>
                        <ul>
                            <li><a href="{{ route('about.us') }}"><i class="mdi mdi-chevron-right"></i>About Us</a></li>
                            <li><a href="{{ route('contact') }}"><i class="mdi mdi-chevron-right"></i>Contact</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Support</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Latest Updates</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5>Contact Us :</h5>
                        <ul>
                            <li>
                                <span class="text-white"><span class="mdi mdi-map-marker font-size-18"></span></span>
                                <a href="#">Ahmedabad, Gujarat, India</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-email-outline font-size-18"></span></span>
                                <a href="#">contact@medibook.com</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-phone-outline font-size-18"></span></span>
                                <a href="#">+91 9427502555</a>
                            </li>
                        </ul>
                        <div class="media-icon">
                            <ul class="list-inline d-flex flex-wrap social m-0">
                                <li class="me-1"><a href="#" class="social-icon"><i class="mdi mdi-facebook"></i></a></li>
                                <li class="mx-1"><a href="#" class="social-icon"><i class="mdi mdi-twitter"></i></a></li>
                                <li class="mx-1"><a href="#" class="social-icon"><i class="mdi mdi-linkedin"></i></a></li>
                                <li class="mx-1"><a href="#" class="social-icon"><i class="mdi mdi-google-plus"></i></a></li>
                                <li class="mx-1"><a href="#" class="social-icon"><i class="mdi mdi-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Footer Copyright -->
        <div class="footer-copyright p-4">
            <div class="container">
                <div class="text-center">
                    <p class="text-white m-0">© 2025 . Crafted with by Vandan Vaghamshi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="build/libs/bootstarp/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="build/libs/jquery/jquery.min.js"></script>
    <script src="build/libs/metismenu/metisMenu.min.js"></script>
    <script src="build/libs/simplebar/simplebar.min.js"></script>
    <script src="build/libs/node-wavws/waves.min.js"></script>
    <script src="build/libs/toaste/toastr.js"></script>    
    <script src="build/js/app.min.js"></script>
    <script src="build/js/landing.js"></script>
</body>
</html> 