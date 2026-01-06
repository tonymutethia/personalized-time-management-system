-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2025 at 12:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student-trainer-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `title`, `description`, `due_date`, `course_name`, `posted_by`, `created_at`) VALUES
(1, 'Networking Basics', 'Read Chapter 1-3 and answer questions at the end.', '2025-06-24 10:00:00', 'Networking', 28, '2025-06-21 21:10:01'),
(2, 'Database Design', 'Design a relational database schema for a hospital system.', '2025-06-25 14:30:00', 'Database', 28, '2025-06-21 21:10:01'),
(3, 'System Analysis', 'Submit a complete use-case diagram for the inventory system.', '2025-06-26 11:00:00', 'Systems Analysis', 28, '2025-06-21 21:10:01'),
(4, 'Software Engineering', 'Write a software requirement specification (SRS).', '2025-06-27 09:00:00', 'Software Engineering', 28, '2025-06-21 21:10:01'),
(5, 'ICT Project', 'Submit project proposal and topic selection.', '2025-06-28 13:00:00', 'ICT Project', 28, '2025-06-21 21:10:01'),
(6, 'Comp Math', 'Solve problems 1 to 10 on linear algebra.', '2025-06-29 08:00:00', 'Computer Math', 28, '2025-06-21 21:10:01'),
(7, 'submit the cat', 'do all quiz', '2025-06-23 00:00:00', 'ibp', 28, '2025-06-22 00:00:20'),
(8, 'kilomani', 'just do it', '2025-06-22 00:10:00', 'ict', 28, '2025-06-22 00:10:38'),
(9, 'kilomani', 'just do it', '2025-06-22 00:10:00', 'ict', 28, '2025-06-22 00:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('student','trainer') NOT NULL,
  `check_in_time` datetime NOT NULL DEFAULT current_timestamp(),
  `location` varchar(100) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `user_id`, `role`, `check_in_time`, `location`, `schedule_id`) VALUES
(20, 100, 'student', '2025-06-21 07:55:00', 'Main Gate', NULL),
(21, 100, 'student', '2025-06-20 08:02:00', 'Library', NULL),
(22, 101, 'student', '2025-06-21 08:01:00', 'Lab 2', NULL),
(23, 102, 'trainer', '2025-06-21 07:45:00', 'Staff Room', NULL),
(24, 103, 'trainer', '2025-06-21 08:00:00', 'Main Hall', NULL),
(25, 27, 'student', '2025-06-21 20:14:04', 'Main Gate', NULL),
(26, 28, 'trainer', '2025-06-21 20:47:31', 'Main Gate', NULL),
(27, 28, 'trainer', '2025-06-21 23:10:56', 'Main Gate', NULL),
(28, 27, 'student', '2025-06-21 23:57:07', 'Main Gate', NULL),
(29, 28, 'trainer', '2025-06-22 00:26:16', 'Main Gate', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_schedules`
--

CREATE TABLE `class_schedules` (
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `day` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_schedules`
--

INSERT INTO `class_schedules` (`schedule_id`, `user_id`, `course_name`, `start_time`, `end_time`, `location`, `created_by`, `created_at`, `day`) VALUES
(85, NULL, 'Ppm', '00:25:00', '06:15:00', 'Ntb', 1, '2025-05-06 00:15:49', 'Saturday'),
(89, 28, 'rrr', '12:12:00', '12:12:00', '212', 1, '2025-06-21 21:03:14', 'Sunday'),
(90, 28, 'System Analysis', '09:00:00', '11:00:00', 'Room A1', 1, '2025-06-21 21:04:34', 'Tuesday'),
(91, 28, 'Database Design', '11:30:00', '13:30:00', 'Room B2', 1, '2025-06-21 21:04:34', 'Wednesday'),
(92, 28, 'Programming Logic', '14:00:00', '16:00:00', 'Room C3', 1, '2025-06-21 21:04:34', 'Thursday'),
(93, 28, 'Networking Basics', '08:00:00', '10:00:00', 'Lab 1', 1, '2025-06-21 21:04:34', 'Friday'),
(94, 28, 'ICT Project', '10:30:00', '12:30:00', 'Main Hall', 1, '2025-06-21 21:04:34', 'Saturday');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(9, NULL, 'meeting', 'inform every class ', 1, '2025-05-05 23:21:43'),
(10, NULL, 'man down', 'why tho', 1, '2025-05-13 11:01:10'),
(11, NULL, 'complite ', 'bring tomm', 0, '2025-05-13 15:16:31'),
(12, NULL, 'Exam cards', 'Correct yout', 1, '2025-05-13 15:21:39'),
(13, 28, 'whats that', 'eeeee', 0, '2025-05-27 09:39:26'),
(22, NULL, 'System Update', 'Maintenance scheduled for Sunday 10 PM.', 0, '2025-06-20 12:00:00'),
(23, 28, 'Assignment Reminder', 'Submit by tonight!', 0, '2025-06-20 16:45:00'),
(24, 27, 'Exam Notice', 'Your exam has been scheduled for next week.', 0, '2025-06-18 10:30:00'),
(25, NULL, 'meeting', 'inform every class ', 1, '2025-05-05 23:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `class_name`, `trainer_id`, `student_id`, `class_date`, `start_time`, `end_time`, `location`, `created_at`) VALUES
(2, 'Networking Basics', 28, 27, '2025-06-24', '08:00:00', '10:00:00', 'Room A1', '2025-06-21 18:02:23'),
(3, 'Computer Math', 28, 27, '2025-06-25', '10:30:00', '12:30:00', 'Lab 3', '2025-06-21 18:02:23'),
(4, 'Systems Analysis', 28, 27, '2025-06-26', '13:00:00', '15:00:00', 'Room B2', '2025-06-21 18:02:23'),
(5, 'Software Engineering', 28, 27, '2025-06-27', '09:00:00', '11:00:00', 'Room C4', '2025-06-21 18:02:23'),
(6, 'Database Design', 28, 27, '2025-06-28', '11:30:00', '13:30:00', 'Library Hall', '2025-06-21 18:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `user_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`user_id`, `title`, `status`, `task_id`) VALUES
(17, 'call who no one', 'done', 30),
(15, 'Time', 'done', 31),
(23, 'call mum', 'doing', 33),
(26, 'CATS', 'doing', 34),
(23, 'toot', 'done', 35),
(24, 'jjjjj', 'doing', 36),
(28, 'security check', 'todo', 37),
(28, 'rewrite the code', 'doing', 38),
(28, 'wah', 'done', 39),
(27, 'kilo', 'todo', 40);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','trainer') NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `role`, `profile_picture`, `created_at`) VALUES
(27, 'STUDENT', 'student', 'student@gmail.com', '$2y$10$xOUMIAMX.RzX0vOjRfwJS.UnfgGcnFdOjKhg4LmxjH8PCX4dPoCAC', 'student', 'public/uploads/img2_1766.jpg', '2025-05-18 22:12:13'),
(28, 'trainer', 'trainer', 'trainer@gmail.com', '$2y$10$N2rZP6TcCTiHZrqLLh9sAOjNNoN5za/TjnocTolVQmR/vWcgHzVlC', 'trainer', NULL, '2025-05-18 22:48:56'),
(100, 'John Student', 'johns', 'johns@example.com', 'password123', 'student', NULL, '2025-06-21 20:45:25'),
(101, 'Alice Student', 'alices', 'alices@example.com', 'password123', 'student', NULL, '2025-06-21 20:45:25'),
(102, 'Mark Trainer', 'markt', 'markt@example.com', 'password123', 'trainer', NULL, '2025-06-21 20:45:25'),
(103, 'Jane Trainer', 'janet', 'janet@example.com', 'password123', 'trainer', NULL, '2025-06-21 20:45:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `idx_posted_by` (`posted_by`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_by` (`created_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `class_schedules`
--
ALTER TABLE `class_schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD CONSTRAINT `attendance_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD CONSTRAINT `class_schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
