<?php
require_once '../includes/auth-guard.php';
requireRole('student');
require_once '../includes/db.php';


$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'];
$db = new Database();
$conn = $db->connect();

// Notifications
$notif_stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id IS NULL OR user_id = ? ORDER BY created_at DESC LIMIT 3");
$notif_stmt->bind_param("i", $user_id);
$notif_stmt->execute();
$notifications = $notif_stmt->get_result();

// Tasks
$task_stmt = $conn->prepare("SELECT * FROM task WHERE user_id = ? ORDER BY task_id DESC LIMIT 5");
$task_stmt->bind_param("i", $user_id);
$task_stmt->execute();
$tasks = $task_stmt->get_result();

// Schedules
$sched_stmt = $conn->prepare("SELECT * FROM class_schedules WHERE user_id = ? ORDER BY start_time ASC LIMIT 5");
$sched_stmt->bind_param("i", $user_id);
$sched_stmt->execute();
$schedules = $sched_stmt->get_result();

// Assignments
$assign_result = $conn->query("SELECT * FROM assignments ORDER BY due_date ASC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card-header { font-weight: 600; }
        .card-body ul { padding-left: 15px; }
    </style>
</head>
<body>

<div class="container mt-4">
<div class="main-content">


<?php include '../partials/student/navbar.php'; ?>

    <h3 class="mb-4">👋 Welcome back, <?= htmlspecialchars($fullname) ?></h3>

    <div class="row g-4">

        <!-- Notifications -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white">📩 Unread Notifications</div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php if ($notifications->num_rows > 0): ?>
                            <?php while ($n = $notifications->fetch_assoc()): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <?= htmlspecialchars($n['title']) ?>
                                    <small><?= date('M d, h:i A', strtotime($n['created_at'])) ?></small>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="list-group-item">No notifications</li>
                        <?php endif; ?>
                    </ul>
                    <a href="notifications.php" class="btn btn-sm btn-outline-warning mt-2 w-100">View All</a>
                </div>
            </div>
        </div>

        <!-- Tasks -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">✅ Your Tasks</div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php if ($tasks->num_rows > 0): ?>
                            <?php while ($t = $tasks->fetch_assoc()): ?>
                                <li class="list-group-item"><?= htmlspecialchars($t['title']) ?> <span class="badge bg-secondary"><?= $t['status'] ?></span></li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="list-group-item">No tasks found</li>
                        <?php endif; ?>
                    </ul>
                    <a href="task.php" class="btn btn-sm btn-outline-primary mt-2 w-100">Manage Tasks</a>
                </div>
            </div>
        </div>

        <!-- Schedules -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">📅 Upcoming Schedules</div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php if ($schedules->num_rows > 0): ?>
                            <?php while ($s = $schedules->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <?= htmlspecialchars($s['course_name']) ?> - <?= htmlspecialchars($s['day']) ?><br>
                                    <small><?= date('g:i A', strtotime($s['start_time'])) ?> - <?= date('g:i A', strtotime($s['end_time'])) ?> @ <?= $s['location'] ?></small>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="list-group-item">No schedules yet</li>
                        <?php endif; ?>
                    </ul>
                    <a href="schedule.php" class="btn btn-sm btn-outline-success mt-2 w-100">View Schedule</a>
                </div>
            </div>
        </div>

        <!-- Assignments -->
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">📚 Latest Assignments</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Course</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($assign_result->num_rows > 0): ?>
                                <?php while ($a = $assign_result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($a['title']) ?></td>
                                        <td><?= htmlspecialchars($a['course_name']) ?></td>
                                        <td><?= date('M d, h:i A', strtotime($a['due_date'])) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="3">No assignments yet</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <a href="assignment.php" class="btn btn-outline-info w-100">View All Assignments</a>
                </div>
            </div>
        </div>

    </div>

    <footer class="mt-5 text-center text-muted">
        <hr>
        <p>&copy; <?= date('Y') ?> Student-Trainer System. All rights reserved.</p>
    </footer>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>
