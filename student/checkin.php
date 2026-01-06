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

// Fetch today's check-ins
$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT check_in_time, location FROM attendance_logs WHERE user_id = ? AND DATE(check_in_time) = ? ORDER BY check_in_time DESC");
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();

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


<!-- <?php include '../partials/student/navbar.php'; ?> -->

    <h2>Hello, <?php echo ucfirst($role); ?> 👋</h2>
    <h4>Welcome to Check-In Page</h4>

    <?php if (!empty($success)) { ?>
        <div class="alert alert-success mt-3"> <?php echo $success; ?> </div>
    <?php } ?>

    <form method="POST" class="mt-4">
        <button type="submit" name="check_in" class="btn btn-primary btn-lg">✅ Check In Now</button>
    </form>

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
    </div>
</body>
</html>
