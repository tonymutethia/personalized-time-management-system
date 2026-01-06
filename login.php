<?php
require_once 'includes/db.php'; 
require_once 'classes/auth.php';

$message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new LoginController();
    $message = $login->handleLogin($_POST);

    $messageClass = strpos($message, 'successful') !== false ? 'alert-success' : 'alert-danger';

    // If login is successful, redirect after a short delay to show the message
    if (strpos($message, 'successful') !== false) {
        $role = $_SESSION['role']; // Role is set in handleLogin
        $redirectUrl = $role === 'trainer' ? 'trainer/dashboard.php' : 'student/dashboard.php';
        echo "<script>
                setTimeout(function() {
                    window.location.href = '$redirectUrl';
                }, 2000); // Redirect after 2 seconds
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student-Trainer System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/login.css">

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
    <!-- Header -->
     <header id="header" class="header d-flex align-items-center">

<div class="container-fluid container-xl d-flex align-items-center justify-content-between">
  <a href="index.html" class="logo d-flex align-items-center">
    <!-- Uncomment the line below if you also wish to use an image logo -->
    <img src="assets/img/logo.png" alt="">
    <h1>
    Thika Institute<span>.</span></h1>
  </a>
  <nav id="navbar" class="navbar">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php">About</a></li>
      <li><a href="index.php">Services</a></li>
      <li><a href="#portfolio">Portfolio</a></li>
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

<section class="hero1">

  <style>
      .hero1 {
    background-image: url('img/carosel.jpg');
    background-size: cover;       /* Make sure image covers the section */
    background-position: center;  /* Center the image */
    background-repeat: no-repeat; /* Do not repeat */
    width: 100%;
    height: 100vh;    
      }
  </style>

  <section class="login-container" >
          <!-- <div class="form-header">
              <h2>Login to Your Account</h2>
              <p>Access your dashboard and manage your tasks.</p>
          </div> -->
          <?php if (!empty($message)) : ?>
              <div class="alert <?= $messageClass ?> text-center">
                  <?= htmlspecialchars($message) ?>
              </div>
          <?php endif; ?>

          <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <div class="mb-3 ">
                  <label for="email" class="form-label label label-info ">Email</label>
                  <input type="email" name="email" class="form-control" id="email" required>
              </div>
              <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="password" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
              <p class="text-center mt-3">
                  <a href="#forgot-password" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" >Forgot Password?</a>
              </p>
              <p class="text-center">
                  Don't have an account? <a href="register.php">Register here</a>
              </p>
          </form>
      </section>

</section>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="forgotPasswordLabel">Forgot Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="forgotPasswordForm">
          <div class="mb-3">
            <label for="userEmail" class="form-label">Enter your email address</label>
            <input type="email" class="form-control" id="userEmail" name="email" placeholder="you@example.com" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <small class="text-muted">We’ll send a reset link to your email address.</small>
      </div>
    </div>
  </div>
</div>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Student-Trainer System. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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