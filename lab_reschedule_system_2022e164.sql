-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 01:18 PM
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
-- Database: `lab_reschedule_system_2022e164`
--

-- --------------------------------------------------------

--
-- Table structure for table `coordinators`
--

CREATE TABLE `coordinators` (
  `coordinator_id` int(11) NOT NULL,
  `coordinator_name` varchar(255) NOT NULL,
  `coordinator_email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinators`
--

INSERT INTO `coordinators` (`coordinator_id`, `coordinator_name`, `coordinator_email`, `username`, `password`) VALUES
(1, 'Dr. Emily Adams', 'emily.adams@university.com', 'emily_adams', 'emily123'),
(2, 'Prof. Mark Johnson', 'mark.johnson@university.com', 'mark_johnson', 'mark456');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `instructor_email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `instructor_name`, `instructor_email`, `username`, `password`) VALUES
(1, 'Dr. Sarah Lee', 'sarah.lee@university.com', 'sarah_lee', 'sarah789'),
(2, 'Dr. Kevin Brown', 'kevin.brown@university.com', 'kevin_brown', 'kevin101');

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `lab_id` int(11) NOT NULL,
  `lab_name` varchar(255) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `venue` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`lab_id`, `lab_name`, `instructor_name`, `module`, `venue`) VALUES
(1, 'LAB 1', 'Dr. Sarah Lee', 'Mathematics', '1st floor-Admin'),
(2, 'LAB 2', 'Dr. John Doe', 'Physics', '2nd floor-Admin'),
(3, 'LAB 3', 'Dr. Emily Roberts', 'Chemistry', '1st floor-Admin'),
(4, 'LAB 4', 'Dr. Michael Brown', 'Mathematics', '2nd floor-Admin'),
(9, 'LAB 5', 'Dr. Sarah Lee', 'Mathematics', '1st floor-Admin'),
(10, 'LAB 6', 'Dr. John Doe', 'Physics', '2nd floor-Admin'),
(11, 'LAB 7', 'Dr. Sarah Lee', 'Chemistry', '1st floor-Admin'),
(12, 'LAB 8', 'Dr. John Doe', 'Biology', '2nd floor-Admin'),
(13, 'LAB 9', 'Dr. Sarah Lee', 'Mathematics', '1st floor-Admin'),
(14, 'LAB 10', 'Dr. John Doe', 'Physics', '2nd floor-Admin'),
(15, 'LAB 11', 'Dr. Sarah Lee', 'Chemistry', '1st floor-Admin'),
(16, 'LAB 12', 'Dr. John Doe', 'Biology', '2nd floor-Admin'),
(17, 'LAB 13', 'Dr. Sarah Lee', 'Mathematics', '1st floor-Admin'),
(18, 'LAB 14', 'Dr. John Doe', 'Physics', '2nd floor-Admin'),
(19, 'LAB 15', 'Dr. Sarah Lee', 'Chemistry', '1st floor-Admin'),
(20, 'LAB 16', 'Dr. John Doe', 'Biology', NULL),
(21, 'LAB 17', 'Dr. Sarah Lee', 'Mathematics', NULL),
(22, 'LAB 18', 'Dr. John Doe', 'Physics', NULL),
(23, 'LAB 19', 'Dr. Sarah Lee', 'Chemistry', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_forms`
--

CREATE TABLE `medical_forms` (
  `medical_form_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `medical_certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_forms`
--

INSERT INTO `medical_forms` (`medical_form_id`, `student_id`, `medical_certificate`) VALUES
(26, 1, 'DB_2022E164_AND_REVISED_ERD.pdf'),
(27, 1, 'DB_2022E164_AND_REVISED_ERD.pdf'),
(28, 1, 'DB_2022E164_AND_REVISED_ERD.pdf'),
(29, 1, '2021E006.pdf'),
(30, 3, '2022E144-03042024130637.pdf'),
(31, 1, '2022E144-03042024130637.pdf'),
(32, 3, '2022E144-03042024130637.pdf'),
(33, 3, '2022E164_EC5020_Lab04.pdf'),
(34, 3, 'DB_2022E164_AND_REVISED_ERD.pdf'),
(35, 3, 'LAB RESCHEDULE SYSTEM.pdf'),
(36, 3, 'LAB RESCHEDULE SYSTEM.pdf'),
(37, 3, 'DB_2022E164_AND_REVISED_ERD.pdf'),
(38, 3, '2022E144-03042024130637.pdf'),
(39, 3, '2022E144-03042024130637.pdf'),
(40, 3, '2022E144-03042024130637.pdf'),
(41, 3, '2022E144-03042024130637.pdf'),
(42, 3, '2022E144-03042024130637.pdf'),
(43, 3, '2022E144-03042024130637.pdf'),
(44, 3, '2022E144-03042024130637.pdf'),
(45, 3, '2022E144-03042024130637.pdf'),
(46, 3, '2022E144-03042024130637.pdf'),
(47, 3, '2022E144-03042024130637.pdf'),
(48, 1, '2022E144-03042024130637.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `messages_from_coordinator`
--

CREATE TABLE `messages_from_coordinator` (
  `lab_id` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `medical_certificate` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages_from_coordinator`
--

INSERT INTO `messages_from_coordinator` (`lab_id`, `module`, `student_id`, `student_name`, `medical_certificate`, `status`) VALUES
(1, 'Maths', 3, 'sahithyan', 'uploads/37', 'approved'),
(1, 'Maths', 3, 'sahithyan', 'uploads/36', 'approved'),
(1, 'Maths', 3, 'sahithyan', 'uploads/37', 'approved'),
(11, 'Chemistry', 3, 'sahithyan', 'uploads/38', 'approved'),
(11, 'Chemistry', 3, 'sahithyan', 'uploads/39', 'approved'),
(11, 'Chemistry', 3, 'sahithyan', 'uploads/40', 'approved'),
(11, 'Maths', 3, 'sahithyan', 'uploads/41', 'approved'),
(11, 'Maths', 3, 'sahithyan', 'uploads/42', 'approved'),
(11, 'Maths', 3, 'sahithyan', 'uploads/43', 'approved'),
(11, 'Maths', 3, 'sahithyan', 'uploads/44', 'approved'),
(11, 'Mathematics', 3, 'sahithyan', 'uploads/45', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `rescheduled_labs`
--

CREATE TABLE `rescheduled_labs` (
  `lab_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `lab_name` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `rescheduled_date` date NOT NULL,
  `rescheduled_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rescheduled_labs`
--

INSERT INTO `rescheduled_labs` (`lab_id`, `student_id`, `lab_name`, `module`, `rescheduled_date`, `rescheduled_time`) VALUES
(1, 3, 'LAB 1', 'Maths', '2025-07-05', '10:00:00'),
(11, 1, '', '', '2025-07-16', '01:00:00'),
(18, 3, 'LAB 14', 'Physics', '2025-07-16', '00:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `reschedule_requests`
--

CREATE TABLE `reschedule_requests` (
  `request_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `coordinator_id` int(11) NOT NULL,
  `module` varchar(255) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `lab_name` varchar(255) NOT NULL,
  `instructor_name` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `medical_certificate` varchar(255) DEFAULT NULL,
  `medical_form_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reschedule_requests`
--

INSERT INTO `reschedule_requests` (`request_id`, `student_id`, `coordinator_id`, `module`, `lab_id`, `lab_name`, `instructor_name`, `status`, `medical_certificate`, `medical_form_id`) VALUES
(1, 3, 1, 'Maths', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'approved', NULL, 41),
(2, 3, 1, 'Maths', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'approved', NULL, 42),
(3, 3, 1, 'Maths', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'approved', NULL, 43),
(4, 3, 1, 'Maths', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'approved', NULL, 44),
(5, 3, 1, 'Mathematics', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'approved', NULL, 45),
(6, 3, 1, 'Mathematics', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'pending', NULL, 46),
(7, 3, 1, 'Mathematics', 11, 'Chemistry Lab 1', 'Dr. Sarah Lee', 'pending', NULL, 47),
(8, 1, 1, 'Mathematics', 13, 'LAB 9', 'Dr. Sarah Lee', 'pending', NULL, 48);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `student_email`, `username`, `password`) VALUES
(1, 'John Doe', 'john.doe@example.com', 'john_doe', 'password123'),
(2, 'Jane Smith', 'jane.smith@example.com', 'jane_smith', 'securePassword456'),
(3, 'sahithyan', 'sahithyan1205@gmail.com', 'Sahi', 'saHI@1205');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `slot_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `available_date` date NOT NULL,
  `available_time` time NOT NULL,
  `is_booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`slot_id`, `instructor_id`, `lab_id`, `available_date`, `available_time`, `is_booked`) VALUES
(9, 1, 4, '2025-07-01', '10:30:00', 1),
(10, 1, 1, '2025-07-16', '09:00:00', 0),
(11, 1, 1, '2025-07-16', '09:00:00', 0),
(12, 1, 12, '2025-07-01', '13:27:00', 1),
(13, 1, 18, '2025-07-16', '00:30:00', 0),
(14, 1, 18, '2025-07-16', '00:30:00', 1),
(15, 1, 12, '2025-07-01', '13:27:00', 0),
(16, 1, 11, '2025-07-16', '01:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`coordinator_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`lab_id`);

--
-- Indexes for table `medical_forms`
--
ALTER TABLE `medical_forms`
  ADD PRIMARY KEY (`medical_form_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `messages_from_coordinator`
--
ALTER TABLE `messages_from_coordinator`
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `rescheduled_labs`
--
ALTER TABLE `rescheduled_labs`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `coordinator_id` (`coordinator_id`),
  ADD KEY `lab_id` (`lab_id`),
  ADD KEY `medical_form_id` (`medical_form_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `instructor_id` (`instructor_id`),
  ADD KEY `time_slots_ibfk_2` (`lab_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coordinators`
--
ALTER TABLE `coordinators`
  MODIFY `coordinator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `labs`
--
ALTER TABLE `labs`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `medical_forms`
--
ALTER TABLE `medical_forms`
  MODIFY `medical_form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `rescheduled_labs`
--
ALTER TABLE `rescheduled_labs`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medical_forms`
--
ALTER TABLE `medical_forms`
  ADD CONSTRAINT `medical_forms_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `messages_from_coordinator`
--
ALTER TABLE `messages_from_coordinator`
  ADD CONSTRAINT `messages_from_coordinator_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`),
  ADD CONSTRAINT `messages_from_coordinator_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `rescheduled_labs`
--
ALTER TABLE `rescheduled_labs`
  ADD CONSTRAINT `rescheduled_labs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `reschedule_requests`
--
ALTER TABLE `reschedule_requests`
  ADD CONSTRAINT `reschedule_requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `reschedule_requests_ibfk_2` FOREIGN KEY (`coordinator_id`) REFERENCES `coordinators` (`coordinator_id`),
  ADD CONSTRAINT `reschedule_requests_ibfk_3` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`),
  ADD CONSTRAINT `reschedule_requests_ibfk_4` FOREIGN KEY (`medical_form_id`) REFERENCES `medical_forms` (`medical_form_id`);

--
-- Constraints for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD CONSTRAINT `time_slots_ibfk_1` FOREIGN KEY (`instructor_id`) REFERENCES `instructors` (`instructor_id`),
  ADD CONSTRAINT `time_slots_ibfk_2` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
