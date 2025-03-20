<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Medical Advices & Check Ups - Medibook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get professional medical advice and check-ups at our clinic. We provide comprehensive health services and expert medical guidance.">
    
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

        <!-- Medical Advice Section Start -->
        <section class="section medical-advice-section pt-5 mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-center mb-5">
                            <h1 class="display-4 fw-bold">Medical Advices & Check Ups</h1>
                            <p class="text-muted">Professional medical guidance and comprehensive health check-ups for your well-being</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Regular Check-ups -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-stethoscope text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Regular Check-ups</h4>
                                        <p class="text-muted mb-0">Comprehensive health examinations</p>
                                    </div>
                                </div>
                                <p class="card-text">Regular health check-ups are essential for maintaining good health and preventing potential health issues. Our comprehensive check-up packages include:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Complete blood count</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Blood pressure monitoring</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Cholesterol screening</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Diabetes screening</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Consultation -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-doctor text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Medical Consultation</h4>
                                        <p class="text-muted mb-0">Expert medical advice</p>
                                    </div>
                                </div>
                                <p class="card-text">Our experienced doctors provide expert medical advice and consultation services:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>General health advice</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Lifestyle recommendations</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Nutrition guidance</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Preventive care advice</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Preventive Care -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-shield-check text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Preventive Care</h4>
                                        <p class="text-muted mb-0">Stay healthy and prevent diseases</p>
                                    </div>
                                </div>
                                <p class="card-text">Our preventive care services help you maintain good health and prevent potential health issues:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Vaccination services</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Health screenings</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Risk assessment</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Health education</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Specialized Services -->
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-medical-bag text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h4 class="card-title mb-1">Specialized Services</h4>
                                        <p class="text-muted mb-0">Targeted medical care</p>
                                    </div>
                                </div>
                                <p class="card-text">We offer specialized medical services to address specific health concerns:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Cardiac evaluation</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Respiratory assessment</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Orthopedic consultation</li>
                                    <li class="mb-2"><i class="mdi mdi-check-circle text-success me-2"></i>Dental check-up</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <h3 class="mb-4">Need Medical Advice?</h3>
                                <p class="text-muted mb-4">Contact us for professional medical guidance and consultation</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="tel:+919427502555" class="btn btn-primary">
                                        <i class="mdi mdi-phone me-2"></i>Call Us
                                    </a>
                                    <a href="mailto:vandanvaghamshi1@gmail.com" class="btn btn-outline-primary">
                                        <i class="mdi mdi-email me-2"></i>Email Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Medical Advice Section End -->

        
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
                                <p>Visit our clinic at the following location. We are easily accessible from all parts of the city.</p>
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
                <!-- row start  -->
                <div class="row justify-content-between g-2">
                    <div class="col-lg-4">
                        <a class="brand-logo" href="Modification.php">
                            <img src="build\images\logo-light.png" alt="" height="22">
                        </a>
                        <p class="mt-4 text-white-50">Doctorly is our country's health insurance program for people age 65 or older.</p>
                        <div class="footer-btn mt-4">
                            <h5>Subscribe :</h5>
                            <a href="Modification.php" class="btn btn-light">Subscribe to more</a>
                        </div>
                    </div>


                    <div class="col-lg-2">
                        <h5>Department :</h5>
                        <ul>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Anesthesiologists</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Cardiologists </a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Dermatologists</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Ophthalmology</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Neurology</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Hematology</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <h5>Quick Links :</h5>
                        <ul>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    About Us</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Contact</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Support</a>
                            </li>
                            <li>
                                <a href="Modification.php"><i class="mdi mdi-chevron-right"></i>
                                    Latest Blogs</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5>Contact Us :</h5>
                        <ul>
                            <li>
                                <span class="text-white"><span class="mdi mdi-map-marker font-size-18"></span> </span> <a href="Modification.php">Ahemdabad, Gujrat, India</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-email-outline font-size-18"></span> </span> <a href="Modification.php">vandanvaghamshi1@gmail.com</a>
                            </li>
                            <li>
                                <span class="text-white"><span class="mdi mdi-phone-outline font-size-18"></span> </span> <a href="Modification.php">+91 9427502555</a>
                            </li>
                        </ul>
                        <div class="media-icon">
                            <ul class="list-inline d-flex flex-wrap social m-0">
                                <li class="me-1"><a href="Modification.php" class="social-icon"><i
                                            class="mdi mdi-facebook"></i></a></li>
                                <li class="mx-1"><a href="Modification.php" class="social-icon"><i
                                            class="mdi mdi-twitter"></i></a></li>
                                <li class="mx-1"><a href="Modification.php" class="social-icon"><i
                                            class="mdi mdi-linkedin"></i></a></li>
                                <li class="mx-1"><a href="Modification.php" class="social-icon"><i
                                            class="mdi mdi-google-plus"></i></a></li>
                                <li class="mx-1"><a href="Modification.php" class="social-icon"><i
                                            class="mdi mdi-microsoft-xbox"></i></a></li>
                            </ul>
                        </div>

                    </div>

                </div>
                <!-- row end  -->
            </div>
            <!-- container end  -->
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