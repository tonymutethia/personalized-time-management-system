<?php
require_once '../includes/auth-guard.php';
requireRole('trainer');
require_once '../includes/db.php';

// Handle assignment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_assignment'])) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = $_POST['due_date'] ?? '';
    $course_name = trim($_POST['course_name'] ?? '');
    $posted_by = $_SESSION['user_id'] ?? 0;

    if ($title && $description && $due_date && $course_name) {
        $stmt = $conn->prepare("INSERT INTO assignments (title, description, due_date, course_name, posted_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $title, $description, $due_date, $course_name, $posted_by);
        $stmt->execute();
        $successMessage = "✅ Assignment posted successfully.";
    } else {
        $errorMessage = "❌ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trainer Dashboard - Student-Trainer System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card-dashboard {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card-dashboard:hover { transform: scale(1.02); }
        .card-icon {
            font-size: 2.5rem;
            color: #007bff;
        }
    </style>
</head>
<body>


<div class="container py-4">
    <div class="main-content">
<?php include "../partials/trainer/navbar.php"; ?>

   
    <h2 class="mb-4 text-primary">Welcome back, <?= htmlspecialchars($_SESSION['fullname']) ?> 👋</h2>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <?php
        $roles = [
            ['title' => 'Students', 'icon' => 'bi-person-lines-fill', 'role' => 'student'],
            ['title' => 'Trainers', 'icon' => 'bi-person-badge', 'role' => 'trainer']
        ];

        foreach ($roles as $card) {
            $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE role = ?");
            $stmt->bind_param("s", $card['role']);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="card card-dashboard text-center p-4">
                    <div class="card-icon mb-2"><i class="bi <?= $card['icon'] ?>"></i></div>
                    <h5 class="text-muted"><?= $card['title'] ?></h5>
                    <h3 class="fw-bold"><?= $res['count'] ?></h3>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Dashboard Widgets -->
    <div class="row g-4">
        <!-- Quick Links -->
        <div class="col-md-6">
            <div class="card card-dashboard p-4">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a href="../trainer/checkin.php"><i class="bi bi-clock-history me-2"></i>Check-In Logs</a></li>
                    <li class="list-group-item"><a href="../student/schedule.php"><i class="bi bi-calendar me-2"></i>Class Schedules</a></li>
                    <li class="list-group-item"><a href="../student/assignment.php"><i class="bi bi-journal-text me-2"></i>Assignments</a></li>
                    <li class="list-group-item"><a href="../student/notifications.php"><i class="bi bi-bell me-2"></i>Notifications</a></li>
                </ul>
            </div>
        </div>

        <!-- Assignment Form -->
        <div class="col-md-6">
            <div class="card card-dashboard p-4">
                <h5 class="mb-3">Post New Assignment</h5>

                <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?= $successMessage ?></div>
                <?php elseif (!empty($errorMessage)): ?>
                    <div class="alert alert-danger"><?= $errorMessage ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="create_assignment" value="1">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="title" placeholder="Assignment Title" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" rows="3" placeholder="Description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="datetime-local" class="form-control" name="due_date" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="course_name" placeholder="Course Name" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Recent Assignments -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card card-dashboard p-4">
                <h5 class="mb-3">📘 Recent Assignments</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Title</th>
                                <th>Course</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $trainer_id = $_SESSION['user_id'];
                            $result = $conn->query("SELECT title, course_name, due_date FROM assignments WHERE posted_by = $trainer_id ORDER BY due_date DESC LIMIT 5");
                            if ($result && $result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['course_name']) ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($row['due_date'])) ?></td>
                            </tr>
                            <?php endwhile; else: ?>
                                <tr><td colspan="3">No assignments found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-3 mt-5 bg-light border-top">
    <small>&copy; <?= date("Y") ?> Student-Trainer System</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 </div>
</body>
</html>
