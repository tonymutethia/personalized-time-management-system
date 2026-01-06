<?php
require_once '../includes/db.php';
require_once '../classes/task.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_role = $_SESSION['role'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

$taskObj = new task();

// Handle task creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $status = $_POST['status'];
    $taskObj->createtask($title, $status, $user_id);
    header("Location: task.php");
    exit;
}

// Handle task deletion
if (isset($_GET['delete'])) {
    $taskObj->deleteTask($_GET['delete']);
    header("Location: task.php");
    exit;
}

// Handle task status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['new_status'];
    $conn->query("UPDATE task SET status = '$new_status' WHERE task_id = $task_id AND user_id = $user_id");
    header("Location: task.php");
    exit;
}

// Fetch tasks
$tasks = $taskObj->gettasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Class Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .task-card { background: white; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 20px; }
        .table thead { background-color: #0d6efd; color: white; }
        .task-form .form-control, .task-form .form-select { border-radius: 8px; }
        .btn-sm { padding: 4px 10px; }

        /* Apply colors to the status column <td> */
        td.status-todo {
            background-color: #fff3cd !important; /* Yellow (Bootstrap warning) */
            color: #856404; /* Adjust text color for contrast */
        }
        td.status-doing {
            background-color: #cce5ff !important; /* Light blue (Bootstrap info) */
            color: #004085; /* Adjust text color for contrast */
        }
        td.status-done {
            background-color: #d4edda !important; /* Light green (Bootstrap success) */
            color: #155724; /* Adjust text color for contrast */
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="main-content">
    <?php
    if ($user_role === 'student') include '../partials/student/navbar.php';
    elseif ($user_role === 'trainer') include '../partials/trainer/navbar.php';
    ?>

    <div class="task-card">
        <h2>Class Tasks</h2>

        <!-- Filter/Search Form -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control" placeholder="Search tasks...">
            </div>
            <div class="col-md-3">
                <select id="statusFilter" onchange="filterTable()" class="form-select">
                    <option value="">Filter by Status</option>
                    <option value="todo">To Do</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                </select>
            </div>
        </div>

        <!-- Add Task Form -->
        <form method="POST" class="row g-3 task-form mb-4">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="Task Title" required>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select" required>
                    <option disabled selected>Status</option>
                    <option value="todo">To Do</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" name="create" class="btn btn-success w-100">Add Task</button>
            </div>
        </form>

        <!-- Print Button -->
        <div class="d-flex justify-content-end mb-3">
            <button onclick="printTable()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
        </div>

        <!-- Tasks Table -->
        <div class="table-responsive" id="printableTable">
            <table class="table table-bordered" id="taskTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Update Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $tasks->fetch_assoc()): ?>
                    <?php if ($user_id == $row['user_id']): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td class="status-<?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                            <td>
                                <form method="POST" class="d-flex gap-1">
                                    <input type="hidden" name="task_id" value="<?= $row['task_id'] ?>">
                                    <select name="new_status" class="form-select form-select-sm" required>
                                        <option <?= $row['status'] === 'todo' ? 'selected' : '' ?> value="todo">To Do</option>
                                        <option <?= $row['status'] === 'doing' ? 'selected' : '' ?> value="doing">Doing</option>
                                        <option <?= $row['status'] === 'done' ? 'selected' : '' ?> value="done">Done</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-warning btn-sm">Update</button>
                                </form>
                            </td>
                            <td>
                                <a href="task.php?delete=<?= $row['task_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this task?')">Delete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
function printTable() {
    var content = document.getElementById("printableTable").innerHTML;
    var win = window.open('', '', 'height=700,width=900');
    win.document.write('<html><head><title>Print Tasks</title>');
    win.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    win.document.write('<style>');
    win.document.write('td.status-todo { background-color: #fff3cd !important; color: #856404; }');
    win.document.write('td.status-doing { background-color: #cce5ff !important; color: #004085; }');
    win.document.write('td.status-done { background-color: #d4edda !important; color: #155724; }');
    win.document.write('</style>');
    win.document.write('</head><body>');
    win.document.write('<h2 class="text-center my-4">Task List</h2>');
    win.document.write(content);
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}

function filterTable() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let statusFilter = document.getElementById("statusFilter").value;
    let rows = document.querySelectorAll("#taskTable tbody tr");

    rows.forEach(row => {
        let title = row.children[0].textContent.toLowerCase();
        let status = row.children[1].textContent.toLowerCase();
        let show = true;

        if (input && !title.includes(input)) show = false;
        if (statusFilter && status !== statusFilter) show = false;

        row.style.display = show ? "" : "none";
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
</body>
</html>