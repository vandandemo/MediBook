<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Surgical Services - Medibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional surgical services with state-of-the-art facilities and expert surgeons for comprehensive surgical care.">

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

        <!-- Surgical Services Section -->
        <section class="section services-section pt-5 mt-5" id="services">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold">Surgical <span class="text-primary">Services</span></h1>
                            <p>Providing comprehensive surgical care with state-of-the-art facilities and expert surgical teams.</p>
                        </div>
                    </div>
                </div>

                <!-- Our Services -->
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
<!-- <h3 class="mb-4">Our Services</h3>-->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-medical-bag text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">General Surgery</h4>
                                        <p class="text-muted mb-0">Comprehensive surgical procedures for various conditions</p>
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
                                        <h4 class="card-title mb-1">Cardiothoracic Surgery</h4>
                                        <p class="text-muted mb-0">Specialized procedures for heart and chest conditions</p>
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
                                        <i class="mdi mdi-brain text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Neurosurgery</h4>
                                        <p class="text-muted mb-0">Advanced procedures for brain and spine conditions</p>
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
                                        <i class="mdi mdi-bone text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Orthopedic Surgery</h4>
                                        <p class="text-muted mb-0">Specialized procedures for bone and joint conditions</p>
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
                                            <i class="mdi mdi-microscope display-4 text-primary"></i>
                                            <h5 class="mt-3">Robotic Surgery Systems</h5>
                                            <p>Advanced robotic assistance for precise procedures</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="equipment-item text-center p-3">
                                            <i class="mdi mdi-camera display-4 text-primary"></i>
                                            <h5 class="mt-3">Laparoscopic Equipment</h5>
                                            <p>Minimally invasive surgical tools</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="equipment-item text-center p-3">
                                            <i class="mdi mdi-monitor display-4 text-primary"></i>
                                            <h5 class="mt-3">Advanced Monitoring Systems</h5>
                                            <p>Real-time patient monitoring during surgery</p>
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
                                <h3 class="mb-4">Our Specialists</h3>
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <div class="specialist-item text-center p-3">
                                            <img src="build\images\landing\doctor-4.png" alt="Surgeon" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <h5>Dr. John Smith</h5>
                                            <p>General Surgeon</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="specialist-item text-center p-3">
                                            <img src="build\images\landing\doctor-3.png" alt="Surgeon" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <h5>Dr. Sarah Johnson</h5>
                                            <p>Cardiothoracic Surgeon</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="specialist-item text-center p-3">
                                            <img src="build\images\landing\doctor-5.png" alt="Surgeon" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            <h5>Dr. Michael Brown</h5>
                                            <p>Neurosurgeon</p>
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
                                            <h5><i class="mdi mdi-clock-fast me-2"></i>Emergency Surgery</h5>
                                            <p>24/7 availability for emergency surgical procedures</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="program-item p-3 bg-light rounded">
                                            <h5><i class="mdi mdi-hospital-building me-2"></i>Day Surgery</h5>
                                            <p>Outpatient surgical procedures with quick recovery</p>
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
                            <h1 class="lh-base">Contact Our <span class="text-primary">Surgical Team</span></h1>
                            <p>Get in touch with our surgical department for consultations and appointments</p>
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
                            <p>Visit our surgical center at the following location</p>
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