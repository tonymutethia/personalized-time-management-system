<?php
require_once '../includes/db.php';

class Schedule {
    private $conn;
    

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Handle creating a schedule
    public function createSchedule($course_name, $start_time, $end_time, $location, $day, $user_id = 1, $created_by = 1 ) {
        $stmt = $this->conn->prepare("INSERT INTO class_schedules (course_name, start_time, end_time, location, user_id, created_by, day) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $course_name, $start_time, $end_time, $location, $user_id, $created_by, $day);
        $stmt->execute();
    }

    // Handle deleting a schedule
    public function deleteSchedule($id) {
        $stmt = $this->conn->prepare("DELETE FROM class_schedules WHERE schedule_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Handle updating a schedule
    public function updateSchedule($id, $course_name, $start_time, $end_time, $location, $day) {
        $stmt = $this->conn->prepare("UPDATE class_schedules SET course_name=?, start_time=?, end_time=?, location=?, day=? WHERE schedule_id=?");
        $stmt->bind_param("ssssssi", $course_name, $start_time, $end_time, $location, $day, $id);
        $stmt->execute();
    }

    // Get all schedules
    public function getSchedules() {
        $result = $this->conn->query("
        SELECT cs.*, u.fullname AS creator_name 
        FROM class_schedules cs
        JOIN users u ON cs.user_id = u.id
        ORDER BY cs.start_time DESC
    ");
        return $result;
    }
}
?>
<!-- query("SELECT * FROM class_schedules ORDER BY start_time DESC"); -->