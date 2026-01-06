
<?php  
require_once 'includes/db.php';
require_once 'includes/auth-guard.php';
require_once 'classes/profile.php';
 requireLogin();

 $db = new Database();
 $conn = $db->connect();
 
 $message = "";
 if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $_SESSION['flash_message'] = "Profile updated successfully!";

    
}

 //showing datafrom profile page
 $userId = $_SESSION['user_id']; // Must be set from login
$sql = "SELECT fullname, email, role, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
//endof profile
 
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $controller = new ProfileController();
     $message = $controller->updateProfile($conn, $_SESSION['user_id'], $_POST, $_FILES);
 }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Student-Trainer System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
        
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .main-content {
                margin-left: 250px;
                padding: 20px;
            }
        .profile-container {
            margin: 30px auto;
            padding: 20px;
            max-width: 600px;
        }
        .profile-card, .form-section {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 20px;
        }
        .profile-picture {
            max-width: 300px;
        ; 
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<?php

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'student') {
        
        require_once 'partials/student/navbar.php';
    } elseif ($_SESSION['role'] === 'trainer') {
        require_once 'partials/trainer/navbar.php';
    } else {
        // Optional: load a default or error header
        echo "Invalid role.";
    }
} else {
    // Optional: redirect to login or show error
    echo "No role found in session.";
}
?>

<div class="main-content">
    

    

    <!-- Profile Content -->
    <section class="profile-container container">
    <h2 class="mb-4">Your Profile</h2>

<div class="profile-card" style="width: auto;">
    <div class="container"> <section class="image-section">
    <img id="profilePicture" 
             src="<?= $user['profile_picture'] ? $user['profile_picture'] : 'https://via.placeholder.com/150' ?>" 
             alt="Profile Picture" 
             class="profile-picture profile-card profile-container">
    </section></div>
   

          
    
    <p><strong>Fullname:</strong> <span id="profileUsername"><?= htmlspecialchars($user['fullname']) ?></span></p>
    <p><strong>Email:</strong> <span id="profileEmail"><?= htmlspecialchars($user['email']) ?></span></p>
    <p><strong>Role:</strong> <span id="profileRole"><?= htmlspecialchars(ucfirst($user['role'])) ?></span></p>
</div>


        <!-- Update Profile Form -->
        <div class="form-section">
            <h5>Update Profile</h5>
            <?php
// Show flash message if it exists
if (isset($_SESSION['flash_message'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
    </div>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<?php
// Show persistent message (e.g., form validation errors)
if (!empty($message)): ?>
    <div class="alert alert-info">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>


            <form id="profileForm" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>"  id="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" id="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">New Password (leave blank to keep current)</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="mb-3">
        <label for="profilePictureInput" class="form-label">Profile Picture</label>
        <input type="file" name="profilePictureInput" class="form-control" id="profilePictureInput" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
        </div>
    </section>
</div>

    
  

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
  
</body>
</html>