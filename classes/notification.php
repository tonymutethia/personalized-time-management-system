<?php
require_once '../includes/db.php';

class notification {
    private $conn;
    

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Handle creating a notification
    public function createnotification($title, $message, $user_id ) {
        $stmt = $this->conn->prepare("INSERT INTO notifications (title, message, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $message, $user_id);
        $stmt->execute();
    }

    // Handle deleting a notification
    public function deletenotification($id) {
        $stmt = $this->conn->prepare("DELETE FROM notifications WHERE notification_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Handle updating a notification
    // public function updatenotification($id, $course_name, $start_time, $end_time, $location, $day) {
    //     $stmt = $this->conn->prepare("UPDATE class_notifications SET course_name=?, start_time=?, end_time=?, location=?, day=? WHERE notification_id=?");
    //     $stmt->bind_param("ssssssi", $course_name, $start_time, $end_time, $location, $day, $id);
    //     $stmt->execute();
    // }

    // Get all notifications
    public function getnotifications() {
        $result = $this->conn->query("
        SELECT n.*, u.fullname AS creator_name 
        FROM notifications n
        JOIN users u ON n.user_id = u.id
        ORDER BY n.created_at DESC
    ");
        return $result;
    }
}
?>
<!-- query("SELECT * FROM notifications ORDER BY start_time DESC"); -->