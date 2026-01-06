<?php
require_once '../includes/db.php';

class  Task{
    private $conn;
    

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Handle creating a task
    public function createtask($title,$status, $user_id) {
        $stmt = $this->conn->prepare("INSERT INTO task (title, status, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $status, $user_id);
        $stmt->execute();
    }

    // Handle deleting a task
    public function deletetask($id) {
        $stmt = $this->conn->prepare("DELETE FROM task WHERE task_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }


    // Get all tasks
    public function gettasks() {
        $result = $this->conn->query("
        SELECT t.*, u.fullname AS creator_name 
        FROM task t
        JOIN users u ON t.user_id = u.id
    ");
        return $result;
    }
}
?>
<!-- query("SELECT * FROM class_tasks ORDER BY start_time DESC"); -->