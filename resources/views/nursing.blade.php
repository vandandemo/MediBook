<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Nursing Services - Medibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional nursing services with compassionate care and expert nursing staff for comprehensive patient care.">

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

        <!-- Nursing Services Section -->
        <section class="section services-section pt-5 mt-5" id="services">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold">Nursing <span class="text-primary">Services</span></h1>
                            <p>Providing compassionate and professional nursing care with our expert nursing team.</p>
                        </div>
                    </div>
                </div>

                <!-- Our Services -->
<!-- Our Services -->
<div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
<!-- <h3 class="mb-4">Our Services</h3>-->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-hospital-building text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">General Nursing Care</h4>
                                        <p class="text-muted mb-0">Comprehensive patient care and monitoring</p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
<!-- <h3 class="mb-4">Our Services</h3>-->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-heart-pulse text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Critical Care Nursing</h4>
                                        <p class="text-muted mb-0">Specialized care for critically ill patients</p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
<!-- <h3 class="mb-4">Our Services</h3>-->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-baby-face text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Pediatric Nursing</h4>
                                        <p class="text-muted mb-0">Specialized care for children and infants</p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
<!-- <h3 class="mb-4">Our Services</h3>-->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-account-group text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Community Health Nursing</h4>
                                        <p class="text-muted mb-0">Public health and community care services</p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>                
                </div>

                <!-- Modern Equipment -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-4">Modern Equipment</h3>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="equipment-item text-center p-3">
                                            <i class="mdi mdi-monitor display-4 text-primary"></i>
                                            <h5 class="mt-3">Patient Monitoring Systems</h5>
                                            <p>Advanced vital signs monitoring</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="equipment-item text-center p-3">
                                            <i class="mdi mdi-medical-bag display-4 text-primary"></i>
                                            <h5 class="mt-3">Infusion Pumps</h5>
                                            <p>Precise medication delivery systems</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="equipment-item text-center p-3">
                                            <i class="mdi mdi-hospital display-4 text-primary"></i>
                                            <h5 class="mt-3">Patient Care Units</h5>
                                            <p>Modern patient care facilities</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Our Specialists -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-4">Our Nursing Team</h3>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="specialist-item text-center p-3">
                                            <img src="build\images\landing\doctor-4.png" alt="Nurse" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <h5>Sarah Johnson</h5>
                                            <p>Head Nurse</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="specialist-item text-center p-3">
                                            <img src="build\images\landing\doctor-3.png" alt="Nurse" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <h5>Michael Brown</h5>
                                            <p>Critical Care Nurse</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="specialist-item text-center p-3">
                                            <img src="build\images\landing\doctor-5.png" alt="Nurse" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <h5>Emily Davis</h5>
                                            <p>Pediatric Nurse</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Special Programs -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h3 class="mb-4">Special Programs</h3>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="program-item p-3 bg-light rounded">
                                            <h5><i class="mdi mdi-clock-fast me-2"></i>24/7 Nursing Care</h5>
                                            <p>Round-the-clock nursing support and care</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="program-item p-3 bg-light rounded">
                                            <h5><i class="mdi mdi-school me-2"></i>Nursing Education</h5>
                                            <p>Continuous training and development programs</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="section contact-section bg-light" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact-header text-center">
                            <h1 class="lh-base">Contact Our <span class="text-primary">Nursing Team</span></h1>
                            <p>Get in touch with our nursing department for care inquiries and support</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-6">
                        <div class="contact-info p-4 bg-white rounded shadow-sm">
                            <h4 class="mb-5">Contact Information</h4>
                            <div class="d-flex align-items-center mb-4">
                                <i class="mdi mdi-phone text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">Phone</h6>
                                    <p class="mb-0">+91 9427502555</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <i class="mdi mdi-email text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">Email</h6>
                                    <p class="mb-0">bloodbank@medibook.com</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <i class="mdi mdi-map-marker text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-0">Address</h6>
                                    <p class="mb-0">Ahmedabad, Gujarat, India</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form p-4 bg-white rounded shadow-sm">
                            <h4 class="mb-3">Send us a Message</h4>
                            <form>
                                <div class="mb-1">
                                    <input type="text" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="mb-1">
                                    <input type="email" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" rows="3" placeholder="Your Message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="section map-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="map-header text-center">
                            <h1 class="lh-base">Find Us On <span class="text-primary">Map</span></h1>
                            <p>Visit our nursing center at the following location</p>
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

<!-- footer-section start  -->
<footer class="section footer-section bg-dark">
            <div class="container">
                <div class="row justify-content-between g-2">
                    <div class="col-lg-4">
                        <a class="brand-logo" href="/">
                            <img src="build\images\logo-light.png" alt="" height="22">
                        </a>
                        <p class="mt-4 text-white-50">Expert orthopedic services for comprehensive musculoskeletal care.</p>
                        <div class="footer-btn mt-4">
                            <h5>Subscribe :</h5>
                            <a href="#" class="btn btn-light">Subscribe to more</a>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <h5>Services :</h5>
                        <ul>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Joint Replacement</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Sports Medicine</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Spine Surgery</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Trauma Care</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Physical Therapy</a></li>
                            <li><a href="#"><i class="mdi mdi-chevron-right"></i>Rehabilitation</a></li>
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