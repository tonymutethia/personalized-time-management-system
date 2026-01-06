<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student-Trainer System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/index.css">
    <!-- Custom CSS -->


    <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

   
</head>
<body>
      <!-- ======= Header ======= -->
  <section id="topbar" class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">zac@gmail.com</a></i>
        <i class="bi bi-phone d-flex align-items-center ms-4"><span>+254 7589 588</span></i>
      </div>
      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </section><!-- End Top Bar -->
    <!-- Header -->
    <header id="header" class="header d-flex align-items-center">

<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <!-- Uncomment the line below if you also wish to use an image logo -->
    <!-- <img src="assets/img/logo.png" alt=""> -->
    <h1>
        
<img src="img/logo.jpg" alt="">
    Thika Institute<span>.</span></h1>
  </a>
  <nav id="navbar" class="navbar">
    <ul>
      <li><a href="#hero">Home</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="blog.html">Blog</a></li>
      <li><a href="#contact">Contact</a></li>
      
      
      
      <li><a href="login.php" class="btn btn-outline-light btn-lg me-2 align-items-center">Login Now</a></li>
      <li><a href="register.php" class="btn btn-outline-light btn-lg">Sign Up</a></li>
      
     
      
    </ul>
  </nav><!-- .navbar -->

  <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
  <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

</div>
</header>
    
   

<style>
    .hero {
  background-image: url('img/carosel.jpg');
  background-size: cover;       /* Make sure image covers the section */
  background-position: center;  /* Center the image */
  background-repeat: no-repeat; /* Do not repeat */
  width: 100%;
  height: auto;                 /* Full screen height */
}

</style>
      <!-- ======= Hero Section ======= -->
  <section id="hero"  class="hero">
    <div class="container position-relative " >
      <div class="row gy-5" data-aos="fade-in">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
        <h1 style="color: aqua;">Welcome to the thika technical collage</h1>
        <p >Your one-stop platform for managing schedules, assignments, and communication between students and trainers.</p>
          
          <div class="d-flex justify-content-center justify-content-lg-start">
          <a href="login.php" style="background-color: aqua; color: red;" class="btn btn-blue btn-lg me-2">Login Now</a>
          <a href="register.php"  style="background-color: red; color: aqua;" class="btn btn-outline-light btn-lg">Sign Up</a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <img src="assets/img/hero-img.svg" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
        </div>
      </div>
    </div>

    </div>
  </section>
  <!-- End Hero Section -->
 <!-- Features Overview -->
 <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Key Features</h2>
            <div class="row">
                <!-- Student Dashboard -->
                <div class="col-md-4 mb-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-speedometer2 display-4 text-primary"></i>
                            <h5 class="card-title mt-3">Student Dashboard</h5>
                            <p class="card-text">View your schedules, assignments, and upcoming deadlines in one place.</p>
                        </div>
                    </div>
                </div>
                <!-- Trainer Tools -->
                <div class="col-md-4 mb-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-gear-fill display-4 text-primary"></i>
                            <h5 class="card-title mt-3">Trainer Tools</h5>
                            <p class="card-text">Post assignments, manage schedules, and communicate with students.</p>
                        </div>
                    </div>
                </div>
                <!-- Responsive Design -->
                <div class="col-md-4 mb-4">
                    <div class="card feature-card shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-phone display-4 text-primary"></i>
                            <h5 class="card-title mt-3">Responsive Design</h5>
                            <p class="card-text">Access the system seamlessly on both desktop and mobile devices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  
  <!-- ======= About Us Section ======= -->
  <section id="about" class="about">
  <div class="container" data-aos="fade-up">
    <div class="section-header">
      <h2>About Us</h2>
      <p>The Personalised Time Management System at Thika Technical helps students and trainers efficiently manage academic schedules, assignments, and communication.</p>
    </div>

    <div class="row gy-4">
      <div class="col-lg-6">
        <h3>Streamlining Daily Academic Life</h3>
        <img src="assets/img/about.jpg" class="img-fluid rounded-4 mb-4" alt="Time management image">
        <p>Our system is designed to empower students and trainers to stay on top of their daily tasks. Whether it’s tracking class attendance, assignments, or school events — everything is in one place.</p>
        <p>We believe time is the most valuable resource in education. Our tools ensure every learner gets the best use of their academic day, free from confusion or missed deadlines.</p>
      </div>

      <div class="col-lg-6">
        <div class="content ps-0 ps-lg-5">
          <p class="fst-italic">
            Designed with the needs of Thika Technical learners and staff in mind.
          </p>
          <ul>
            <li><i class="bi bi-check-circle-fill"></i> Centralized access to class timetables, assignments, and announcements.</li>
            <li><i class="bi bi-check-circle-fill"></i> Real-time student and trainer communication.</li>
            <li><i class="bi bi-check-circle-fill"></i> Easy login for both students and trainers with personalized dashboards.</li>
          </ul>
          <p>
            Join us in creating a smart and structured learning environment. Whether on a computer or mobile, you can access your academic tools anytime, anywhere.
          </p>

          <div class="position-relative mt-4">
            <img src="assets/img/about-2.jpg" class="img-fluid rounded-4" alt="System preview">
            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End About Us Section -->

  <!-- ======= Our Services Section ======= -->
  <section id="services" class="services sections-bg">
  <div class="container" data-aos="fade-up">
    <div class="section-header">
      <h2>Our Services</h2>
      <p>We provide smart, student-centered tools that improve time management and academic success for everyone at Thika Technical Institute.</p>
    </div>

    <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

      <div class="col-lg-4 col-md-6">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="bi bi-calendar4-week"></i>
          </div>
          <h3>Smart Timetable</h3>
          <p>Students and trainers can view and manage class schedules with ease, including upcoming tasks and sessions.</p>
          <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="bi bi-clipboard-data"></i>
          </div>
          <h3>Task & Assignment Manager</h3>
          <p>Upload, track, and submit assignments on time. Get reminders before due dates to stay on track.</p>
          <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="bi bi-chat-dots"></i>
          </div>
          <h3>Trainer Communication</h3>
          <p>Send and receive messages from your trainers directly inside the system — no external apps required.</p>
          <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="bi bi-bar-chart"></i>
          </div>
          <h3>Attendance Tracking</h3>
          <p>Track and monitor daily attendance logs for every session with automatic timestamps.</p>
          <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="bi bi-clock-history"></i>
          </div>
          <h3>Arrival Time Monitoring</h3>
          <p>See exactly when students and trainers arrive. View by date, class, or role for easy filtering.</p>
          <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="bi bi-phone"></i>
          </div>
          <h3>Mobile Friendly</h3>
          <p>Our system is optimized for mobile devices so users can manage schedules on the go.</p>
          <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End Our Services Section -->
<!-- ======= Contact Section ======= -->
<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-header">
      <h2>Contact Us</h2>
      <p>Reach out to Thika Technical Time Management Team for inquiries, feedback, or technical support.</p>
    </div>

    <div class="row gx-lg-0 gy-4">

      <div class="col-lg-4">

        <div class="info-container d-flex flex-column align-items-center justify-content-center">
          <div class="info-item d-flex">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h4>Location:</h4>
              <p>Thika Technical Training Institute, Thika, Kenya</p>
            </div>
          </div>

          <div class="info-item d-flex">
            <i class="bi bi-envelope flex-shrink-0"></i>
            <div>
              <h4>Email:</h4>
              <p>support@thikatech.ac.ke</p>
            </div>
          </div>

          <div class="info-item d-flex">
            <i class="bi bi-phone flex-shrink-0"></i>
            <div>
              <h4>Call:</h4>
              <p>+254 700 000 000</p>
            </div>
          </div>

          <div class="info-item d-flex">
            <i class="bi bi-clock flex-shrink-0"></i>
            <div>
              <h4>Open Hours:</h4>
              <p>Mon-Fri: 8AM - 5PM</p>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-8">
        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="7" placeholder="Message" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center"><button type="submit">Send Message</button></div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>
</section><!-- End Contact Section -->
<!-- End Contact Section -->


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Student-Trainer System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom JS -->
    <script src="public/js/index.js"></script>

    
  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>