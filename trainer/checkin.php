<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/auth-guard.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$location = "Main Gate"; // Can later be dynamic

// Handle Check-In
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_in'])) {
    $stmt = $conn->prepare("INSERT INTO attendance_logs (user_id, role, location) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $role, $location);
    $stmt->execute();
    $success = "You have successfully checked in.";
}

// Trainer View All Logs with Filters
$filter_name = $_GET['name'] ?? '';
$filter_date = $_GET['date'] ?? '';

if ($role === 'trainer') {
    $query = "SELECT al.check_in_time, al.location, u.fullname, u.role FROM attendance_logs al
              JOIN users u ON al.user_id = u.id WHERE 1=1";

    $params = [];
    $types = '';

    if (!empty($filter_name)) {
        $query .= " AND u.fullname LIKE ?";
        $params[] = "%$filter_name%";
        $types .= 's';
    }
    if (!empty($filter_date)) {
        $query .= " AND DATE(al.check_in_time) = ?";
        $params[] = $filter_date;
        $types .= 's';
    }

    $query .= " ORDER BY al.check_in_time DESC";
    $stmt = $conn->prepare($query);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Student view only own check-ins
    $today = date('Y-m-d');
    $stmt = $conn->prepare("SELECT check_in_time, location FROM attendance_logs WHERE user_id = ? AND DATE(check_in_time) = ? ORDER BY check_in_time DESC");
    $stmt->bind_param("is", $user_id, $today);
    $stmt->execute();
    $result = $stmt->get_result();
}

if (!$result instanceof mysqli_result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In | Time Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="main-content">
    <?php  include '../partials/trainer/navbar.php'; ?>
    <h2>Hello, <?php echo ucfirst($role); ?> 👋</h2>
    <h4>Welcome to Check-In Page</h4>

    <?php if (!empty($success)) { ?>
        <div class="alert alert-success mt-3"> <?php echo $success; ?> </div>
    <?php } ?>

    <form method="POST" class="mt-4">
        <button type="submit" name="check_in" class="btn btn-primary btn-lg">✅ Check In Now</button>
    </form>

    <?php if ($role === 'trainer'): ?>
        <h5 class="mt-5">🔎 Search & Filter Logs</h5>
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Search by name" value="<?= htmlspecialchars($filter_name) ?>">
            </div>
            <div class="col-md-4">
                <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($filter_date) ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-secondary">Filter</button>
                <a href="checkin.php" class="btn btn-outline-danger">Reset</a>
            </div>
        </form>
        <h5>📋 All Attendance Logs</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Check-In Time</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= ucfirst($row['role']) ?></td>
                        <td><?= date('Y-m-d h:i A', strtotime($row['check_in_time'])) ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h5 class="mt-5">🗕️ Your Check-Ins for Today:</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('h:i A', strtotime($row['check_in_time'])); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
</body>
</html>
