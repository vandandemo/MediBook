<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Emergency Help 24/7 - Medibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get immediate emergency medical assistance 24/7. Our emergency department is always ready to provide urgent medical care.">
    
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
            <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top navbar-custom sticky sticky-light"
                id="navbar">
                <div class="container">
                    <a class="navbar-brand logo" href="/">
                        <img src="build\images\logo2.png" alt="logo-dark"
                            height="22">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav mx-auto">
                            <!--<li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#services">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#departments">Departments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#team">Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#reviews">Reviews</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact</a>
                            </li>-->
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
        <!-- header nav bar end  -->

        <!-- Emergency Help Section Start -->
        <section class="section emergency-help-section pt-5 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold">Emergency Help Available 24/7</h1>
                            <p class="text-muted">Our emergency department is always ready to provide immediate medical assistance</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Emergency Care -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-ambulance text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Emergency Care</h4>
                                        <p class="text-muted mb-0">24/7 Emergency Services</p>
                                    </div>
                                </div>
                                <p class="card-text">Our emergency department provides immediate medical attention:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Round-the-clock emergency care</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Emergency ambulance service</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Trauma care center</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Emergency surgery facilities</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Team -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-doctor text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Emergency Team</h4>
                                        <p class="text-muted mb-0">Expert emergency staff</p>
                                    </div>
                                </div>
                                <p class="card-text">Our emergency team is always ready to help:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Emergency physicians</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Trauma specialists</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Emergency nurses</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Paramedics</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Facilities -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-hospital-building text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Emergency Facilities</h4>
                                        <p class="text-muted mb-0">State-of-the-art equipment</p>
                                    </div>
                                </div>
                                <p class="card-text">Our emergency department is equipped with:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Emergency operation theater</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Intensive care units</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Advanced diagnostic equipment</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Emergency pharmacy</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Services -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-medical-bag text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Emergency Services</h4>
                                        <p class="text-muted mb-0">Comprehensive emergency care</p>
                                    </div>
                                </div>
                                <p class="card-text">We provide various emergency services:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Trauma care</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Cardiac emergencies</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Pediatric emergencies</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Accident care</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact Section -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <h3 class="mb-4">Need Emergency Help?</h3>
                                <p class="text-muted mb-4">Call our emergency helpline for immediate assistance</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="tel:+919427502555" class="btn btn-danger">
                                        <i class="mdi mdi-phone me-2"></i>Emergency: +91 9427502555
                                    </a>
                                    <a href="mailto:vandanvaghamshi1@gmail.com" class="btn btn-outline-danger">
                                        <i class="mdi mdi-email me-2"></i>Email Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Emergency Help Section End -->

        <!-- map-section start  -->
        <section class="section map-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="map-header text-center">
                            <div class="title-sm">
                                <h4 class="text-success">Our Location</h4>
                            </div>
                            <h1 class="lh-base mt-3">Find Us On <span class="text-primary">Map</span></h1>
                            <p>Visit our emergency department at the following location. We are easily accessible from all parts of the city.</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="map-container">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5192.71809486732!2d72.55930315009886!3d23.03088775266828!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84f53fffffff%3A0xa5680aa626bd4d43!2sNCode%20Technologies%2C%20Inc%20-%20Web%20%26%20Mobile%20App%20Development!5e0!3m2!1sen!2sin!4v1742296284588!5m2!1sen!2sin"
                                width="100%" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- map-section end  -->

        <!-- footer-section start  -->
        <footer class="section footer-section bg-dark">
            <div class="container">
                <div class="row justify-content-between g-2">
                    <div class="col-lg-4">
                        <a class="brand-logo" href="/">
                            <img src="build\images\logo-light.png" alt="" height="22">
                        </a>
                        <p class="mt-4 text-white-50">Providing 24/7 emergency medical care and support to our community.</p>
                        <div class="footer-btn mt-4">
                            <h5>Subscribe :</h5>
                            <a href="#" class="btn btn-light">Subscribe to more</a>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <h5>Department :</h5>
                        <ul>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Emergency Care</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Trauma Center</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Intensive Care</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Emergency Surgery</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Pediatric Emergency</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Cardiac Emergency</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5>Quick Links :</h5>
                        <ul>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>About Us</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Contact</a></li>
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
                                <a href="#">vandanvaghamshi1@gmail.com</a>
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
                                <li class="mx-1"><a href="#" class="social-icon"><i class="mdi mdi-microsoft-xbox"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end  -->

        <!-- footer-copyright start  -->
        <div class="footer-copyright p-4">
            <div class="container">
                <div class="text-center">
                    <p class="text-white m-0">© 2025 . Crafted with by Vandan Vaghamshi</p>
                </div>
            </div>
        </div>
        <!-- footer-copyright end  -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="build/libs/bootstarp/bootstrap.bundle.min.js"></script>
    <script src="build/libs/jquery/jquery.min.js"></script>
    <script src="build/js/app.min.js"></script>
</body>
</html> 