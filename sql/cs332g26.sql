-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 09:17 PM
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
-- Database: `cs332g26`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `textbook` varchar(255) NOT NULL,
  `units` varchar(255) NOT NULL,
  `dept_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `title`, `textbook`, `units`, `dept_id`) VALUES
('045816', 'Software Engineering', 'N/A', '3', '1'),
('238090', 'History of Computer Science\r\n', 'N/A', '3', '1'),
('239032', 'Comparative Education', 'N/A', '3', '2'),
('476615', 'Early Childhood Education', 'N/A', '3', '2');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `dept_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_#` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `chairperson` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `name`, `phone_#`, `location`, `chairperson`) VALUES
('1', 'Department of Computer Science', '(307) 808-1962', 'somewhere', '652-30-XXXX'),
('2', 'Department of Education', '(913) 956-0157', 'elsewhere', '544-04-XXXX');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_records`
--

CREATE TABLE `enrollment_records` (
  `CWID` varchar(255) NOT NULL,
  `section_id` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_records`
--

INSERT INTO `enrollment_records` (`CWID`, `section_id`, `grade`) VALUES
('4986', '05', 'A'),
('4986', '10', 'A'),
('4986', '22', 'C'),
('5355', '05', 'B'),
('5355', '22', 'D'),
('7293', '05', 'B'),
('7293', '10', 'C'),
('7293', '22', 'A'),
('2058', '10', 'D'),
('2058', '22', 'B'),
('8259', '45', 'C'),
('8259', '87', 'A'),
('7903', '45', 'D'),
('7903', '87', 'C'),
('7903', '96', 'B'),
('7964', '87', 'C'),
('7964', '96', 'B'),
('9374', '45', 'C'),
('9374', '87', 'A'),
('9374', '96', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `minors`
--

CREATE TABLE `minors` (
  `CWID` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `ssn` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_#` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `salary` varchar(255) NOT NULL,
  `college_degree` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`ssn`, `name`, `address`, `phone_#`, `sex`, `title`, `salary`, `college_degree`) VALUES
('544-04-XXXX', 'Madalyn Jerrie', 'CA 55555 Fullerton', '(819) 162-5319', 'F', 'Professor', '100000', '2'),
('652-30-XXXX', 'Horace Carmella', 'CA 55555 Fullerton', '(772) 777-3665', 'F', 'Professor', '100000', '1'),
('695-10-XXXX', 'Quinlan Braidy', 'CA 55555 Fullerton', '(901) 658-6656', 'M', 'Professor', '100000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `section_id` varchar(255) NOT NULL,
  `classroom` varchar(255) NOT NULL,
  `seats` varchar(255) NOT NULL,
  `meeting_days` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `teacher` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `classroom`, `seats`, `meeting_days`, `start_time`, `end_time`, `course_id`, `teacher`) VALUES
('05', 'CPSC 110', '4', 'MW', '8:00am', '9:15am', '238090', '652-30-XXXX'),
('10', 'CPSC 101', '4', 'TTH', '12:00pm', '2:15pm', '238090', '652-30-XXXX'),
('22', 'CPSC 102', '4', 'MW', '10:30am', '11:45pm', '045816', '695-10-XXXX'),
('45', 'EC 102', '5', 'TTH', '3:00pm', '4:15pm', '476615', '544-04-XXXX'),
('87', 'EC 203', '5', 'M', '7:00pm', '9:45pm', '239032', '544-04-XXXX'),
('96', 'EC 120', '5', 'T', '5:00pm', '7:45pm', '239032', '544-04-XXXX');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `CWID` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone_#` varchar(255) NOT NULL,
  `dept_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`CWID`, `name`, `address`, `phone_#`, `dept_id`) VALUES
('2058', 'Bindy Kassy', 'N/A', '(620) 763-5612', '1'),
('4986', 'Christine Claude', 'N/A', '(418) 720-7900', '1'),
('5355', 'Celinda Mickey', 'N/A', '(613) 605-5191', '1'),
('7293', 'Peta Osmond', 'N/A', '(416) 428-2366', '1'),
('7903', 'Anton Everlee', 'N/A', '(630) 171-4473', '2'),
('7964', 'Marina Floretta', 'N/A', '(831) 695-7235', '2'),
('8259', 'Len Alexander', 'N/A', '(236) 418-6432', '2'),
('9374', 'Annie Sincere', 'N/A', '(219) 909-2459', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`ssn`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`CWID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
