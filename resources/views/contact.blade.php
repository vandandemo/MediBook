<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Contact Us - Medibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact Medibook Hospital for appointments, inquiries, and healthcare services.">

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
                                <a class="nav-link" href="{{ route('about.us') }}">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('contact') }}">Contact</a>
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
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <div class="hero-header">
                                <h1 class="display-4 fw-medium text-dark">Get in Touch with</h1>
                                <h1 class="display-4 fw-medium text-primary mb-3">Medibook</h1>
                                <h1 class="display-4 fw-medium text-dark mb-4">Healthcare</h1>
                                <p class="text-muted mb-4">We're here to help you with appointments, inquiries, and healthcare services. Reach out to us anytime.</p>
                            </div>
                            <div class="hero-btn">
                                <a href="{{ route('appointments.create') }}" class="btn btn-primary px-4 py-2">
                                <i class="mdi mdi-calendar me-2"></i>Book Appointment</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 position-relative">
                        <div class="contact-image-wrapper">
                            <div class="contact-main-image">
                                <img src="build\images\landing\doctor-team.png" alt="Contact Us" class="img-fluid rounded-circle bg-primary-subtle p-2">
                            </div>
                            <div class="floating-card position-absolute bg-white shadow rounded-3 p-3" style="top: 19   %; right: 315px;">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-phone-in-talk text-primary h3 mb-0 me-2"></i>
                                    <div>
                                        <h6 class="fw-semibold mb-1">24/7 Support</h6>
                                        <p class="small text-muted mb-0">Always Here to Help</p>
                                    </div>
                                </div>
                            </div>
                            <div class="floating-card position-absolute bg-white shadow rounded-3 p-3" style="bottom: 21%; right: 5%;">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-hospital-marker text-primary h3 mb-0 me-2"></i>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Multiple Locations</h6>
                                        <p class="small text-muted mb-0">Easy Access</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- row end  -->
            </div>
        </section>

        <style>
            .contact-image-wrapper {
                position: relative;
                min-height: 500px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .contact-main-image {
                position: relative;
                z-index: 1;
                width: 80%;
                margin: 0 auto;
            }
            .contact-main-image img {
                width: 100%;
                height: auto;
            }
            .floating-card {
                z-index: 2;
                min-width: 200px;
                transition: all 0.3s ease;
            }
            .floating-card:hover {
                transform: translateY(-5px);
            }
            @media (max-width: 991.98px) {
                .contact-image-wrapper {
                    min-height: 400px;
                }
                .floating-card {
                    min-width: 180px;
                }
            }
        </style>

        <!-- Contact Information Section -->
        <section class="section py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="mdi mdi-phone-outline display-4 text-primary mb-3"></i>
                                <h4>Phone</h4>
                                <p class="mb-2">Emergency: +91 9427502555</p>
                                <p class="mb-2">Reception: +91 9427502556</p>
                                <p>Ambulance: +91 9427502557</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="mdi mdi-map-marker-outline display-4 text-primary mb-3"></i>
                                <h4>Location</h4>
                                <p class="mb-2">Medibook Hospital</p>
                                <p class="mb-2">123 Healthcare Avenue</p>
                                <p>Ahmedabad, Gujarat, India</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <i class="mdi mdi-email-outline display-4 text-primary mb-3"></i>
                                <h4>Email</h4>
                                <p class="mb-2">info@medibook.com</p>
                                <p class="mb-2">appointments@medibook.com</p>
                                <p>support@medibook.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form Section -->
        <section class="section py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-5">
                                <h3 class="text-center mb-4">Send us a Message</h3>
                                <form>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Your Name</label>
                                                <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="subject" class="form-label">Subject</label>
                                                <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="message" class="form-label">Message</label>
                                                <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary">Send Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3671.939248817948!2d72.55442937499171!3d23.025725779178728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84f521640d4b%3A0x6f6dd5c9c3b830a1!2sAhmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1709667547417!5m2!1sen!2sin" 
                                    width="100%" 
                                    height="450" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
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