<?php
require_once '../includes/db.php';
require_once '../classes/schedule.php'; // Include the Schedule class
require_once '../includes/auth-guard.php';
requireLogin();
// Start the session to access session variables
$user_role = $_SESSION['role'] ?? ''; // Get the role from session

// Create an instance of the Schedule class
$scheduleObj = new Schedule();

// Handle create (using Schedule class)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $course_name = $_POST['course_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $location = $_POST['location'];
    $day = $_POST['day'];
    
    $user_id = $_SESSION['user_id']; 

    // Call the createSchedule method from the Schedule class
    $scheduleObj->createSchedule($course_name, $start_time, $end_time, $location, $day, $user_id);

    // Redirect to the same page (this prevents re-submission)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Handle delete (using Schedule class)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $scheduleObj->deleteSchedule($id); // Call the deleteSchedule method
    header("Location: schedule.php");
    exit;
}

// Handle update (using Schedule class)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['schedule_id'];
    $course_name = $_POST['course_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $location = $_POST['location'];
    $day = $_POST['day'];
    


    // Call the updateSchedule method from the Schedule class
    $scheduleObj->updateSchedule($id, $course_name, $start_time, $end_time, $location, $day);
    header("Location: schedule.php");
    exit;
}

// Get all schedules (using Schedule class)
$schedules = $scheduleObj->getSchedules();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time table</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar adjustments */
        @media (min-width: 768px) {
            #sidebarMenu {
                position: fixed;
                top: 56px;
                height: calc(100vh - 56px);
                width: 250px;
                z-index: 1000;
                background-color: #ffffff;
                border-right: 1px solid #e0e0e0;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            }

            .main-content {
                margin-left: 250px;
                padding: 30px;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 20px;
            }
        }

        /* Card styling for form and table */
        .schedule-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Form styling */
        .schedule-form .form-control, .schedule-form .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .schedule-form .form-control:focus, .schedule-form .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .schedule-form .btn-success {
            border-radius: 8px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .schedule-form .btn-success:hover {
            background-color: #198754;
        }

        /* Table styling */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background-color: #0d6efd;
            color: #ffffff;
        }

        .table th, .table td {
            vertical-align: middle;
            padding: 15px;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        /* Action buttons */
        .btn-sm {
            border-radius: 6px;
            padding: 6px 12px;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Typography */
        h2 {
            font-weight: 600;
            color: #343a40;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'student') {
                    require_once '../partials/student/navbar.php';
                } elseif ($_SESSION['role'] === 'trainer') {
                    require_once '../partials/trainer/navbar.php';
                } else {
                    echo '<div class="alert alert-danger">Invalid role.</div>';
                }
            } else {
                echo '<div class="alert alert-warning">No role found in session.</div>';
            }
            ?>

            <div class="schedule-card">
                <h2>Time table</h2>

                <!-- Trainer Form -->
                <?php if ($user_role === 'trainer'): ?>
                <form method="POST" class="schedule-form row g-3 mb-4">
                    <input type="hidden" name="schedule_id" value="<?php echo $_GET['edit'] ?? ''; ?>">
                    <div class="col-md-3">
                        <input class="form-control" name="course_name" placeholder="Course Name" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
    <label class="me-2 mb-0" style="color: red;">start Time:</label>
    <input class="form-control" name="start_time" type="time" required>
</div>

                    <div class="col-md-3 d-flex align-items-center">
    <label class="me-2 mb-0" style="color: red;">End Time:</label>
    <input class="form-control" name="end_time" type="time" required>
</div>

                    <div class="col-md-2">
                        <input class="form-control" name="location" placeholder="Location" required>
                    </div>
                    <div class="col-md-2">
                        <select name="day" class="form-select" required>
                            <option value="" disabled selected>Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="hidden" name="created_by" value="<?= $_SESSION['user_id'] ?>">
                        <button type="submit" name="create" class="btn btn-success">Add Schedule</button>
                    </div>
                </form>
                <?php endif; ?>
<!-- print out -->
 <!-- Schedule Table -->
<div class="d-flex justify-content-end mb-3">
    <button onclick="printTable()" class="btn btn-primary">
        <i class="bi bi-printer"></i> Print Schedule
    </button>
</div>


                <!-- Schedule Table -->
                 
                <div  id="printableTable"  class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Day</th>
                                <?php if ($user_role === 'trainer'): ?>
                                    <th>Actions</th>
                                <?php else: ?>
                                    <th>Trainer Name</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $schedules->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['course_name']) ?></td>
                                    <td><?= htmlspecialchars($row['start_time']) ?></td>
                                    <td><?= htmlspecialchars($row['end_time']) ?></td>
                                    <td><?= htmlspecialchars($row['location']) ?></td>
                                    <td><?= htmlspecialchars($row['day']) ?></td>
                                    <td>
                                        <?php if ($user_role === 'trainer'): ?>
                                            <a href="schedule.php?edit=<?= $row['schedule_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="schedule.php?delete=<?= $row['schedule_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this schedule?')">Delete</a>
                                        <?php else: ?>
                                            <span><?= htmlspecialchars($row['creator_name']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
function printTable() {
    var content = document.getElementById("printableTable").innerHTML;
    var win = window.open('', '', 'height=700,width=900');
    win.document.write('<html><head><title>Print Schedule</title>');
    win.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    win.document.write('</head><body>');
    win.document.write('<h2 class="text-center my-4">Class Schedule</h2>');
    win.document.write(content);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}
</script>

</html>