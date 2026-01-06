<?php
require_once(__DIR__ . '/../../includes/db.php');

// Fetch unread notification count
$db = new Database();
$conn = $db->connect();
$user_id = $_SESSION['user_id'] ?? 0;

$unread_count = 0;

if ($user_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($unread_count);
        $stmt->fetch();
        $stmt->close();
    }
}
?>
<!-- Bootstrap 5 & jQuery -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

   <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Sidebar Styling */
    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1030;
        background: linear-gradient(180deg, #2c3e50 0%, #1a252f 100%); /* Gradient background */
        color: white;
        transition: transform 0.3s ease;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
    }

    /* Sidebar Header */
    .sidebar-header {
        background-color: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .sidebar-header a {
        font-size: 1.25rem;
        font-weight: 600;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Navigation Links */
    .sidebar-nav {
        flex-grow: 1;
        padding: 10px 0;
    }

    .sidebar-nav .nav-link {
        color: #d1d4d8;
        padding: 12px 20px;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 5px;
        margin: 5px 10px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .sidebar-nav .nav-link.active {
        background-color: #007bff;
        color: #ffffff !important;
        font-weight: 500;
    }

    /* Logout Button */
    .logout-section {
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: auto; /* Ensures logout stays at the bottom */
    }

    .logout-btn {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        background-color: transparent;
        border: 1px solid #dc3545;
        color: #dc3545;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #dc3545;
        color: #ffffff;
    }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        padding: 20px;
        transition: margin-left 0.3s ease;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* Toggle Button for Mobile */
    .sidebar-toggle {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1050;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 1.2rem;
        transition: background-color 0.3s ease;
    }

    .sidebar-toggle:hover {
        background-color: #0056b3;
    }

    /* Responsive Design */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .sidebar-toggle {
            display: block;
        }
    }
</style>

<!-- Toggle button for mobile -->
<button class="sidebar-toggle d-lg-none" id="toggleSidebar">
    <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <a href="#" class="text-decoration-none">
            <i class="bi bi-book"></i> Student Dashboard
        </a>
        <button class="btn btn-outline-light d-lg-none" id="closeSidebar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" id="dashboardLink" href="/thikatechinical-personalised-time-management-system/student/dashboard.php">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/thikatechinical-personalised-time-management-system/student/schedule.php">
                    <i class="bi bi-calendar"></i> Time table
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/thikatechinical-personalised-time-management-system/student/assignment.php">
                    <i class="bi bi-journal-text"></i> Assignments
                </a>
            </li>
         
        <li class="nav-item">
    <a class="nav-link" href="/thikatechinical-personalised-time-management-system/student/notifications.php">
        <i class="bi bi-bell"></i> Notifications
        <?php if ($unread_count > 0): ?>
            <span class="blink" style="color: red; margin-left: 5px;"><?php echo $unread_count; ?></span>
        <?php endif; ?>
    </a>
</li>
            <li class="nav-item">
                <a class="nav-link" href="/thikatechinical-personalised-time-management-system/student/task.php">
                    <i class="bi bi-check-square"></i> Task
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/thikatechinical-personalised-time-management-system/student/checkin.php">
                    <i class="bi bi-check-square"></i> check in
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/thikatechinical-personalised-time-management-system/profile.php">
                    <i class="bi bi-person"></i> Profile
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Section -->
    <div class="logout-section">
        <a href="/thikatechinical-personalised-time-management-system/logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</aside>


<script>
    $(document).ready(function () {
        // Sidebar toggle for mobile
        $('#toggleSidebar').click(function () {
            $('#sidebar').addClass('active');
        });

        $('#closeSidebar').click(function () {
            $('#sidebar').removeClass('active');
        });

        // Highlight active nav link based on current URL
        const currentPage = window.location.pathname;
        $('.sidebar-nav .nav-link').each(function () {
            if (this.pathname === currentPage) {
                $(this).addClass('active');
            }
        });

        // Close sidebar when clicking a link on mobile
        $('.sidebar-nav .nav-link').click(function () {
            if ($(window).width() < 992) {
                $('#sidebar').removeClass('active');
            }
        });
    });
</script>