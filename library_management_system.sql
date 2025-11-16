-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 16, 2025 at 08:51 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_information`
--

DROP TABLE IF EXISTS `book_information`;
CREATE TABLE IF NOT EXISTS `book_information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `isbn` varchar(250) NOT NULL,
  `status` enum('available','issued') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'available',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ISBN Unique` (`isbn`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `book_information`
--

INSERT INTO `book_information` (`id`, `title`, `author`, `isbn`, `status`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 'issued'),
(2, '1984', 'George Orwell', '978-0451524935', 'available'),
(3, 'The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 'issued'),
(4, 'Pride and Prejudice', 'Jane Austen', '978-1503290563', 'available'),
(5, 'The Catcher in the Rye', 'J.D. Salinger', '978-0316769488', 'available'),
(6, 'The Lord of the Rings', 'J.R.R. Tolkien', '978-0544003415', 'available'),
(7, 'Harry Potter and the Sorcerer’s Stone', 'J.K. Rowling', '978-0590353427', 'available'),
(8, 'The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 'available'),
(9, 'The Alchemist', 'Paulo Coelho', '978-0061122415', 'issued'),
(10, 'The Da Vinci Code', 'Dan Brown', '978-0307474278', 'available'),
(11, 'The Diary of a Young Girl', 'Anne Frank', '978-0553296983', 'available'),
(12, 'The Book Thief', 'Markus Zusak', '978-0375842207', 'available'),
(13, 'The Kite Runner', 'Khaled Hosseini', '978-1594631931', 'available'),
(14, 'The Hunger Games', 'Suzanne Collins', '978-0439023481', 'available'),
(15, 'The Fault in Our Stars', 'John Green', '978-0142424179', 'available'),
(16, 'Becoming', 'Michelle Obama', '978-1524763138', 'available'),
(17, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', '978-0062316110', 'available'),
(18, 'The Power of Now', 'Eckhart Tolle', '978-1577314806', 'available'),
(19, 'Atomic Habits', 'James Clear', '978-0735211292', 'available'),
(27, 'ASDFas', 'asdfa', 'awdAW', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `issue_return`
--

DROP TABLE IF EXISTS `issue_return`;
CREATE TABLE IF NOT EXISTS `issue_return` (
  `id` int NOT NULL AUTO_INCREMENT,
  `registration_no` varchar(50) NOT NULL,
  `book_id` int NOT NULL,
  `action` enum('issue','return') NOT NULL,
  `issue_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `action_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `issue_return`
--

INSERT INTO `issue_return` (`id`, `registration_no`, `book_id`, `action`, `issue_date`, `return_date`, `due_date`, `action_date`) VALUES
(1, '23it0470', 1, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 10:52:34'),
(2, '23it0470', 1, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 10:53:02'),
(3, '23IT0470', 2, 'issue', '2025-11-07', NULL, '2025-11-27', '2025-11-13 11:02:49'),
(4, '23IT0470', 3, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:13:38'),
(5, '23', 1, 'return', '2025-11-13', '2025-11-13', NULL, '2025-11-13 11:18:37'),
(6, '23IT0470', 1, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:19:26'),
(7, '23', 1, 'return', '2025-11-13', '2025-11-13', NULL, '2025-11-13 11:20:13'),
(8, '23', 2, 'return', '2025-11-07', '2025-11-13', NULL, '2025-11-13 11:24:37'),
(9, '23', 3, 'return', '2025-11-13', '2025-11-13', NULL, '2025-11-13 11:24:45'),
(10, '23IT0470', 1, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:25:03'),
(11, '23', 1, 'return', '2025-11-13', '2025-11-13', NULL, '2025-11-13 11:25:09'),
(12, '23IT0470', 1, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:25:30'),
(13, '23', 1, 'return', '2025-11-13', '2025-11-13', NULL, '2025-11-13 11:25:37'),
(14, '23IT0527', 1, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:27:49'),
(15, '23IT0527', 2, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:27:53'),
(16, '23IT0527', 3, 'issue', '2025-11-13', NULL, '2025-11-27', '2025-11-13 11:27:56'),
(17, '23', 3, 'return', '2025-11-13', '2025-11-13', NULL, '2025-11-13 11:28:01'),
(18, '23', 2, 'return', '2025-11-13', '2025-11-14', NULL, '2025-11-14 05:47:40'),
(19, '23', 1, 'return', '2025-11-13', '2025-11-14', NULL, '2025-11-14 05:47:46'),
(20, '23it0527', 3, 'issue', '2025-11-14', NULL, '2025-11-28', '2025-11-14 06:21:49'),
(21, '23it0527', 1, 'issue', '2025-11-14', NULL, '2025-11-28', '2025-11-14 06:25:28'),
(22, '23it0527', 5, 'issue', '2025-11-14', NULL, '2025-11-28', '2025-11-14 06:28:33'),
(23, '23it0527', 9, 'issue', '2025-11-14', NULL, '2025-11-28', '2025-11-14 06:31:07'),
(24, '23', 1, 'return', '2025-11-14', '2025-11-14', NULL, '2025-11-14 06:41:44'),
(25, '23', 3, 'return', '2025-11-14', '2025-11-16', NULL, '2025-11-16 05:48:30'),
(26, '23', 5, 'return', '2025-11-14', '2025-11-16', NULL, '2025-11-16 05:48:52'),
(27, '23it0470', 1, 'issue', '2025-11-16', NULL, '2025-11-30', '2025-11-16 06:39:33'),
(28, '23it0470', 3, 'issue', '2025-11-16', NULL, '2025-11-30', '2025-11-16 06:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_registered_info`
--

DROP TABLE IF EXISTS `user_registered_info`;
CREATE TABLE IF NOT EXISTS `user_registered_info` (
  `RegistrationNo` varchar(8) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `ConfirmPassword` varchar(200) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MobileNo` int NOT NULL,
  `Role` varchar(50) NOT NULL DEFAULT 'User',
  PRIMARY KEY (`RegistrationNo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_registered_info`
--

INSERT INTO `user_registered_info` (`RegistrationNo`, `FirstName`, `LastName`, `Password`, `ConfirmPassword`, `Email`, `MobileNo`, `Role`) VALUES
('23IT0470', 'Umindu', 'Dinal', '$2y$10$MvIXvVeW/NrnL9MJJFK7HOEk56QizUuf7eKSVOLORbNRrNwoel2l2', '$2y$10$MvIXvVeW/NrnL9MJJFK7HOEk56QizUuf7eKSVOLORbNRrNwoel2l2', 'umindu@gmail.com', 1234567890, 'Admin'),
('23IT0527', 'Imasha', 'Samodee', '$2y$10$a.BQf6b2RdynHi8KDENm/eQnXXX7lRBcu3ARZqnk4jYt.RZtoke5K', '$2y$10$a.BQf6b2RdynHi8KDENm/eQnXXX7lRBcu3ARZqnk4jYt.RZtoke5K', 'imasha@gmail.com', 1234567890, 'User'),
('23IT0459', 'Thanusha', 'Samudrajith', '$2y$10$h.CkFBYF0tjifjgoFOw57OmtMKdtl713Wdp2ORJusIWpdfKRYfTsi', '$2y$10$h.CkFBYF0tjifjgoFOw57OmtMKdtl713Wdp2ORJusIWpdfKRYfTsi', 'thanusha@gmail.com', 1234567890, 'User');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
