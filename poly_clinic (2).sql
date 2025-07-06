-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 12:31 AM
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
-- Database: `poly_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `doctorId` int(11) NOT NULL,
  `patientId` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'booked',
  `fees` int(11) DEFAULT NULL,
  `secretaryId` int(11) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `doctorId`, `patientId`, `start`, `end`, `status`, `fees`, `secretaryId`, `createdAt`) VALUES
(55, 28, 18, '2024-05-27 08:00:00', '2024-05-27 08:30:00', 'accepted', 34, NULL, '2024-05-25 12:47:48'),
(56, 29, 18, '2024-05-27 15:30:00', '2024-05-27 16:00:00', 'accepted', 20, NULL, '2024-05-25 12:49:25'),
(59, 18, 18, '2024-05-27 09:00:00', '2024-05-27 09:30:00', 'accepted', 90, NULL, '2024-05-25 12:54:08'),
(62, 18, 18, '2024-05-27 09:30:00', '2024-05-27 10:00:00', 'rejected', NULL, NULL, '2024-05-25 13:40:06'),
(63, 29, 18, '2024-05-27 16:00:00', '2024-05-27 16:30:00', 'accepted', NULL, NULL, '2024-05-25 13:40:21'),
(64, 30, 24, '2024-05-27 09:30:00', '2024-05-27 10:00:00', 'accepted', 12, NULL, '2024-05-25 13:43:56'),
(65, 18, 18, '2024-05-30 09:00:00', '2024-05-30 09:30:00', 'accepted', 121, 12, '2024-05-25 13:51:20'),
(66, 18, 24, '2024-05-30 11:00:00', '2024-05-30 11:30:00', 'booked', NULL, NULL, '2024-05-25 13:56:52'),
(67, 18, 18, '2024-05-28 10:00:00', '2024-05-28 10:30:00', 'accepted', NULL, NULL, '2024-05-25 13:58:01'),
(68, 29, 18, '2024-05-27 17:00:00', '2024-05-27 17:30:00', 'booked', NULL, NULL, '2024-05-25 13:58:51'),
(69, 19, 18, '2024-05-30 12:00:00', '2024-05-30 12:30:00', 'booked', NULL, NULL, '2024-05-25 14:00:31'),
(70, 29, 18, '2024-05-27 17:30:00', '2024-05-27 18:00:00', 'booked', NULL, NULL, '2024-05-25 16:21:12'),
(71, 18, 26, '2024-05-28 12:30:00', '2024-05-28 13:00:00', 'accepted', 100, 12, '2024-05-26 00:44:31'),
(72, 29, 18, '2024-05-27 16:30:00', '2024-05-27 17:00:00', 'booked', NULL, NULL, '2024-05-26 01:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `id` int(11) NOT NULL,
  `appointmentId` int(11) NOT NULL,
  `notes` text NOT NULL,
  `allergy` text NOT NULL,
  `previousTreatment` text NOT NULL,
  `laboratoryResult` text NOT NULL,
  `currentTreatment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`id`, `appointmentId`, `notes`, `allergy`, `previousTreatment`, `laboratoryResult`, `currentTreatment`) VALUES
(29, 55, 'hello', 'world', 'no prev', 'no lab', 'panadol for 2 months'),
(31, 64, 'hello', 'world', 'no prev', 'no lab', 'panadol for 2 months'),
(32, 65, 'hello', 'dhjfdghdkfgkg', 'no prev', 'no lab', 'panadol for 2 months'),
(33, 59, 'hello', 'dhjfdghdkfgkg', 'no prev', 'no lab', 'panadol for 2 months'),
(34, 71, 'balalal', 'ashkahd', 'af', 'sdfsd', 'dfssd');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `gmail` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `specialityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `firstName`, `lastName`, `gmail`, `password`, `picture`, `phone`, `specialityId`) VALUES
(18, 'Mohamad ', 'shaheen', 'mohamadshahine391@gmail.com', 'Moesh2004', 'image_6649d3d35e9f6_IMG-20240519-WA0020.jpg', 71113515, 14),
(19, 'Nour', 'hek', 'nourhekk@gmail.com', 'nour123', 'image_6649d3fd54d1c_IMG-20240519-WA0016.jpg', 3456789, 14),
(28, 'soleen', 'shaheen', 'mohamadshah91@gmail.com', '128lshdk', 'image_664adf0991e10_IMG-20240519-WA0019.jpg', 76266736, 14),
(29, 'Elie', 'Khoury', 'Elie@gmail.com', 'elie123', 'image_6651b202bb1fd_IMG-20240519-WA0018.jpg', 525252, 11),
(30, 'Salam', 'Shreif', 'salam@gmail.com', 'salam', 'image_6651be53b8d38_IMG-20240519-WA0015.jpg', 565656, 10);

-- --------------------------------------------------------

--
-- Table structure for table `manger`
--

CREATE TABLE `manger` (
  `id` int(11) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manger`
--

INSERT INTO `manger` (`id`, `password`) VALUES
(100, 'password');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `appointmentId` int(11) NOT NULL,
  `content` varchar(50) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `appointmentId`, `content`, `createdAt`) VALUES
(59, 56, 'Appointment fees updated to: $020', '2024-05-25 12:51:38'),
(61, 59, 'Appointment fees updated to: $90', '2024-05-25 12:55:10'),
(62, 55, 'Appointment fees updated to: $34', '2024-05-25 13:12:17'),
(67, 62, 'Appointment status changed to: rejected', '2024-05-25 13:40:50'),
(68, 63, 'Appointment status changed to: accepted', '2024-05-25 13:40:55'),
(70, 64, 'Appointment fees updated to: $12', '2024-05-25 13:44:51'),
(72, 65, 'Appointment fees updated to: $121', '2024-05-25 14:07:07'),
(73, 67, 'Appointment status changed to: accepted', '2024-05-25 16:21:30'),
(75, 71, 'Appointment fees updated to: $100', '2024-05-26 00:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `gmail` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `phone` int(11) NOT NULL,
  `blocked` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `firstName`, `lastName`, `gmail`, `password`, `phone`, `blocked`) VALUES
(16, 'Mohamad', 'Shaheen', 'mohamadshaheenceng@gmail.com', '$2y$10$mmbWtEC5cGJ6ZZkkLMHj..q9XQbim3TnU8XY8PnpetzdOu12JNGeO', 71113515, 0),
(17, 'jana', 'shaheen', 'jana1@gmail.com', '$2y$10$TojvstleMZsazEe8G0qjOu/XTwsKCVlQxYuiJB21ViobOa1kq.ltm', 159951, 0),
(18, 'Heba', 'shaheen', 'heba@gmail.com', '$2y$10$CxtVaTI.xLNg8GMNqVENH./Rq.QZeuliKOVBcF5/S12BerTJsxLcW', 789987, 0),
(19, 'jhonyy', 'laravel', 'jhony@gmail.com', '$2y$10$AnM4L1naYEukbE2iYCv4MO0bSGLMnQ5dP2sR4ep2KNMn7owhVy/P2', 7115815, 0),
(20, 'ALI', 'NASER', 'ALI@gmail.com', '$2y$10$JyHleBGNcPDqWR6N6pfPW.uG4u10vvj.9SX4XgFyF0leXzUb2CSNe', 741, 0),
(21, 'Amer', 'Shreif', 'Amer@gmail.com', '$2y$10$kfC0BRnZFsZHLuy3UaTzduEQZh/l9DIg9bj/ZTs2hnuba1Zl.yY0G', 71151515, 1),
(22, 'samar', 'arar', 'samararar@gmail.com', '$2y$10$VH8tKnV/GgiBZI65zHAsL.YAwCKU9oQWkjIKX1q9suPWYxUdmavGq', 283723, 1),
(23, 'samarr', 'ararr', 'samarrr@gmail.com', '$2y$10$BJ4IxTrIO4vrpkfYTcKDz.MZxkVxKkbSDENK4puuU9KK6UBBsqj6m', 2837235, 0),
(24, 'Milad', 'Laman', 'milad@gmail.com', '$2y$10$.oNcXWrQHNfY3ne4xEvZf.yqiFagWGoKyv2aWGc4j1Q54VP01tFei', 1234, 0),
(25, 'Rasha', 'Shaheen', 'rasha@gmail.com', '$2y$10$yJbiqGFB5x3EDb7m0bGDneO6PqWDA7B.LWhCzvgmrxfQR8fF4bgxC', 5454545, 0),
(26, 'rousha', 'shaheen', 'roro@gmail.com', '$2y$10$enV134nTeIBMM9yALDx9f.prTBy1r153Z73ky0zBpt1jnKuD21Xzi', 474747, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `desc` varchar(50) NOT NULL DEFAULT 'desc_'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `number`, `desc`) VALUES
(19, 203, 'Dentist room'),
(20, 501, 'cardiology room'),
(21, 302, ' diabetes room'),
(22, 401, 'Scanner');

-- --------------------------------------------------------

--
-- Table structure for table `secretary`
--

CREATE TABLE `secretary` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `secretary`
--

INSERT INTO `secretary` (`id`, `name`, `phone`, `password`) VALUES
(11, 'Sama hassrouny', 71113515, 'sama123'),
(12, 'Rama shaheen', 123123123, '12112'),
(13, 'Lara shreif', 456456456, 'lara123'),
(112, 'Lara shreif', 212112121, 'helll'),
(898, 'Mohamad Shaheen', 7878, '128lshdk'),
(1212, 'naghamt', 1221212, 'nagham123'),
(1213, 'hahah', 4625347, 'haha2004');

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE `speciality` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`id`, `name`) VALUES
(14, 'Cardiology'),
(11, 'Dentist'),
(10, 'diabetes'),
(8, 'hematology');

-- --------------------------------------------------------

--
-- Table structure for table `weekschedule`
--

CREATE TABLE `weekschedule` (
  `id` int(11) NOT NULL,
  `doctorId` int(11) NOT NULL,
  `day` varchar(30) NOT NULL,
  `target` enum('before','after') NOT NULL,
  `start` time NOT NULL DEFAULT current_timestamp(),
  `end` time NOT NULL DEFAULT current_timestamp(),
  `roomId` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weekschedule`
--

INSERT INTO `weekschedule` (`id`, `doctorId`, `day`, `target`, `start`, `end`, `roomId`) VALUES
(42, 18, 'tuesday', 'before', '09:00:00', '13:30:00', 19),
(43, 18, 'thursday', 'after', '15:30:00', '19:00:00', 19),
(45, 19, 'thursday', 'before', '08:30:00', '13:30:00', 21),
(50, 18, 'monday', 'before', '08:00:00', '10:00:00', 21),
(51, 28, 'monday', 'before', '08:00:00', '12:30:00', 20),
(52, 28, 'monday', 'after', '15:30:00', '19:00:00', 20),
(53, 29, 'monday', 'before', '08:00:00', '12:00:00', 19),
(54, 29, 'monday', 'after', '15:30:00', '18:00:00', 19),
(55, 30, 'monday', 'before', '09:00:00', '10:00:00', 22),
(56, 18, 'thursday', 'before', '08:00:00', '12:00:00', 20),
(57, 18, 'saturday', 'after', '15:30:00', '18:00:00', 22);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_patientId` (`patientId`),
  ADD KEY `fk_secretaryId` (`secretaryId`),
  ADD KEY `fk_doctor_appointment` (`doctorId`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointmentId` (`appointmentId`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gmail` (`gmail`),
  ADD KEY `fk_specialityId` (`specialityId`);

--
-- Indexes for table `manger`
--
ALTER TABLE `manger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointmentId` (`appointmentId`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gmail` (`gmail`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- Indexes for table `secretary`
--
ALTER TABLE `secretary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `weekschedule`
--
ALTER TABLE `weekschedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_doctor_day_target_room` (`doctorId`,`day`,`target`,`roomId`),
  ADD KEY `fk_room` (`roomId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `secretary`
--
ALTER TABLE `secretary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1214;

--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `weekschedule`
--
ALTER TABLE `weekschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_doctorId` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `fk_doctor_appointment` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_patientId` FOREIGN KEY (`patientId`) REFERENCES `patient` (`id`),
  ADD CONSTRAINT `fk_secretaryId` FOREIGN KEY (`secretaryId`) REFERENCES `secretary` (`id`);

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `fk_appointment_consultation` FOREIGN KEY (`appointmentId`) REFERENCES `appointment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_consultation_appointmentId` FOREIGN KEY (`appointmentId`) REFERENCES `appointment` (`id`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `fk_doctor_specialityId` FOREIGN KEY (`specialityId`) REFERENCES `speciality` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_appointmentId` FOREIGN KEY (`appointmentId`) REFERENCES `appointment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appointment_notification` FOREIGN KEY (`appointmentId`) REFERENCES `appointment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `weekschedule`
--
ALTER TABLE `weekschedule`
  ADD CONSTRAINT `fk_room` FOREIGN KEY (`roomId`) REFERENCES `room` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_weekschedule_doctorId` FOREIGN KEY (`doctorId`) REFERENCES `doctor` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
