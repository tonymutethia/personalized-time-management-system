<?php
require_once '../includes/db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
$role = $_SESSION['role'] ?? '';

if (!$user_id) {
    die("Access denied.");
}

// Handle create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $course_name = $_POST['course_name'];

    $stmt = $conn->prepare("INSERT INTO assignments (title, description, due_date, course_name, posted_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $description, $due_date, $course_name, $user_id);
    $stmt->execute();
    header("Location: assignment.php");
    exit;
}

// Handle delete
if (isset($_GET['delete']) && $role === 'trainer') {
    $assignment_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM assignments WHERE assignment_id = ?");
    $stmt->bind_param("i", $assignment_id);
    $stmt->execute();
    header("Location: assignment.php");
    exit;
}

// Search & Filter Setup
$search = $_GET['search'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$where = "1=1";

if (!empty($search)) {
    $safeSearch = "%{$conn->real_escape_string($search)}%";
    $where .= " AND (a.title LIKE '$safeSearch' OR a.course_name LIKE '$safeSearch')";
}

if (!empty($start_date)) {
    $safeStart = $conn->real_escape_string($start_date);
    $where .= " AND a.due_date >= '$safeStart'";
}

if (!empty($end_date)) {
    $safeEnd = $conn->real_escape_string($end_date);
    $where .= " AND a.due_date <= '$safeEnd'";
}

// Fetch assignments
if ($role === 'trainer') {
    $query = "SELECT a.*, u.fullname AS trainer_name FROM assignments a 
              LEFT JOIN users u ON a.posted_by = u.id 
              WHERE $where ORDER BY due_date ASC";
} else {
    $query = "SELECT a.*, u.fullname AS trainer_name FROM assignments a 
              LEFT JOIN users u ON a.posted_by = u.id 
              WHERE $where AND posted_by IS NOT NULL ORDER BY due_date ASC";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <div class="main-content">
    <?php
    if ($role === 'student') {
        include '../partials/student/navbar.php';
    } elseif ($role === 'trainer') {
        include '../partials/trainer/navbar.php';
    }
    ?>

    <h2 class="mb-4">📚 Assignments</h2>

    <!-- Search & Filter Form -->
    <form class="row g-3 mb-4" method="GET">
        <div class="col-md-4">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by title or course">
        </div>
        <div class="col-md-3">
            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control" placeholder="From date"><p class="text-danger"
            >From date</p>
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control" placeholder="To date">
            <p class="text-danger"
            >To date</p>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- Trainer Assignment Form -->
    <?php if ($role === 'trainer'): ?>
    <div class="card mb-4">
        <div class="card-header">Create Assignment</div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="title" class="form-control" placeholder="Assignment Title" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="course_name" class="form-control" placeholder="Course Name" required>
                </div>
                <div class="col-md-12">
                    <textarea name="description" class="form-control" rows="3" placeholder="Assignment Description" required></textarea>
                </div>
                <div class="col-md-6">
                    <input type="datetime-local" name="due_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <button type="submit" name="create" class="btn btn-success">Post Assignment</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Assignment Table -->
    <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Title</th>
                    <th>Course</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Posted By</th>
                    <?php if ($role === 'trainer'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['course_name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= date('d M Y, h:i A', strtotime($row['due_date'])) ?></td>
                    <td><?= htmlspecialchars($row['trainer_name']) ?></td>
                    <?php if ($role === 'trainer'): ?>
                        <td>
                            <a href="assignment.php?delete=<?= $row['assignment_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this assignment?')">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info">No assignments found for the given filter.</div>
    <?php endif; ?>
    </div>

</body>
</html>
