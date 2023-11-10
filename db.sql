-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2023 at 06:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `building` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `capacity` int(11) NOT NULL,
  `hourlyAvailability` set('09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00') NOT NULL,
  `dailyAvailability` set('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `type` enum('lab','teaching') NOT NULL,
  `computers` int(11) NOT NULL,
  `projector` tinyint(1) NOT NULL,
  `locked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `building`, `address`, `capacity`, `hourlyAvailability`, `dailyAvailability`, `type`, `computers`, `projector`, `locked`) VALUES
(1, 'Willowwood Hall', '1234 Elm Street, Springfield, IL 62701', 100, '09:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00,19:00,20:00', 'Monday,Tuesday,Wednesday,Thursday,Friday', 'teaching', 0, 1, 1),
(2, 'Cedar Heights', '567 Pine Avenue, Springfield, IL 62701', 200, '09:00,10:00,11:00,12:00,13:00,14:00,15:00', 'Monday,Wednesday,Friday', 'teaching', 0, 1, 1),
(4, 'Stonebridge Hall', '1010 River Road, Springfield, IL 62701', 150, '09:00,10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00', 'Monday,Tuesday,Wednesday,Thursday', 'lab', 150, 1, 1),
(18, 'Science Building', '123 Main Street, Springfield, IL 62701', 30, '09:00,10:00,11:00,12:00,13:00', 'Monday,Tuesday,Wednesday,Thursday', 'lab', 20, 1, 0),
(19, 'Engineering Building', '456 Elm Street, Springfield, IL', 40, '10:00,11:00,12:00,13:00', 'Tuesday,Wednesday,Friday', 'teaching', 30, 1, 0),
(20, 'Arts Building', '789 Oak Avenue, Springfield, IL', 25, '13:00,14:00,15:00', 'Monday,Tuesday,Wednesday,Thursday,Friday', 'lab', 15, 0, 1),
(21, 'Mathematics Building', '101 Maple Lane, Springfield, IL', 50, '15:00', 'Monday', 'teaching', 40, 1, 0),
(22, 'Library Building', '222 Pine Road, Springfield, IL', 60, '10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00', 'Tuesday,Wednesday,Thursday', 'lab', 50, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'Computer Science'),
(2, 'Electrical Engineering'),
(3, 'Medicine');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `teaching` int(11) NOT NULL,
  `teacher` varchar(40) NOT NULL,
  `classroom` int(11) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday') NOT NULL,
  `hour` set('09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00') NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `teaching`, `teacher`, `classroom`, `day`, `hour`, `duration`) VALUES
(1, 1, 'cs12543@stanford.edu', 1, 'Tuesday', '14:00,15:00', 2),
(2, 2, 'cs12543@stanford.edu', 1, 'Tuesday', '09:00,10:00,11:00', 3),
(3, 4, 'cs19876@stanford.edu', 1, 'Monday', '10:00,11:00,12:00', 3),
(5, 3, 'cs19876@stanford.edu', 18, 'Wednesday', '11:00,12:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `teaching`
--

CREATE TABLE `teaching` (
  `id` int(11) NOT NULL,
  `courseCode` varchar(5) NOT NULL,
  `course` varchar(50) NOT NULL,
  `teacher` varchar(40) NOT NULL,
  `type` enum('theory','lab','','') NOT NULL,
  `semester` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching`
--

INSERT INTO `teaching` (`id`, `courseCode`, `course`, `teacher`, `type`, `semester`, `department`, `hours`) VALUES
(1, 'cs001', 'Intro to Computer Science', 'cs12543@stanford.edu', 'theory', 1, 1, 2),
(2, 'cs002', 'Intro to Data Bases', 'cs12543@stanford.edu', 'lab', 1, 1, 2),
(3, 'cs003', 'Programming in Python', 'cs19876@stanford.edu', 'lab', 1, 1, 4),
(4, 'cs004', 'Internet of Things', 'cs19876@stanford.edu', 'lab', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `role` set('useradmin','reservationadmin','teacher','') NOT NULL,
  `department` int(11) NOT NULL,
  `type` enum('lecturer','instructor','professor','') NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `fullname`, `role`, `department`, `type`, `approved`) VALUES
('cs12543@stanford.edu', '123', 'James Curtis', 'teacher', 1, 'instructor', 1),
('cs15324@stanford.edu', '123', 'Michael Smith', 'teacher', 1, 'instructor', 1),
('cs19876@stanford.edu', '123', 'William Davis', 'teacher', 1, 'lecturer', 1),
('cs20123@stanford.edu', '123', 'Sin Cara', 'reservationadmin,teacher', 1, 'instructor', 1),
('cs231001@stanford.edu', '123', 'John Cena', 'useradmin', 1, '', 1),
('ee231111@stanford.edu', '123', 'Arnold Schwarz', 'useradmin', 2, '', 1),
('m231111@stanford.edu', '123', 'Silvester Stalone', 'useradmin', 3, '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching` (`teaching`,`teacher`),
  ADD KEY `teacher` (`teacher`),
  ADD KEY `classroom` (`classroom`);

--
-- Indexes for table `teaching`
--
ALTER TABLE `teaching`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher` (`teacher`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`),
  ADD KEY `department` (`department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teaching`
--
ALTER TABLE `teaching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`teaching`) REFERENCES `teaching` (`id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`teacher`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`classroom`) REFERENCES `classroom` (`id`);

--
-- Constraints for table `teaching`
--
ALTER TABLE `teaching`
  ADD CONSTRAINT `teaching_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `teaching_ibfk_2` FOREIGN KEY (`teacher`) REFERENCES `user` (`email`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`department`) REFERENCES `department` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
