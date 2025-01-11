-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2025 at 02:22 PM
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
-- Database: `lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `a_id` int(11) NOT NULL,
  `a_name` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`a_id`, `a_name`, `creation_date`, `updation_date`) VALUES
(3, 'jarus', '2024-11-23 11:08:07', '2024-11-23 11:08:07'),
(4, 'Frank', '2024-11-24 08:28:54', '2024-11-24 08:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'available',
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `b_image` varchar(255) DEFAULT NULL,
  `book_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `year`, `status`, `category_id`, `description`, `b_image`, `book_url`) VALUES
(5, 'Frankenstein', 0, 1213, 'Checked Out', 3, 'jzkdvashjcvasvcasvvakhsvhvaskhvkavshvahvska', '../admin/uploads/ptyhon.jpg', 'https://etc.usf.edu/lit2go/128/frankenstein-or-the-modern-prometheus/2280/chapter-1/'),
(12, 'ABC', 0, 2002, 'Checked Out', 4, NULL, NULL, NULL),
(13, 'acsh', 0, 2002, 'Checked Out', 4, 'Kcnjbih SCVBSBCSCA KSJCLNA SC', 'uploads/ptyhon.jpg', NULL),
(14, 'BDe', 0, 2143, 'Checked Out', 3, 'daubsc', 'uploads/78335219_181768896341951_872475305707569152_n.jpg', NULL),
(15, 'eaerr', NULL, 34543, 'Checked Out', 3, 'jkvhfu', 'uploads/6213064665391548082.jpg', 'https://etc.usf.edu/lit2go/128/frankenstein-or-the-modern-prometheus/2280/chapter-1/'),
(16, 'asac', NULL, 0, 'Checked Out', 3, 'asdcasfavavavaddvadvav', 'admin/uploads/one-piece-anime-logo-illustration-260nw-2200287243.jpg', 'https://etc.usf.edu/lit2go/128/frankenstein-or-the-modern-prometheus/2280/chapter-1/'),
(17, 'Google', NULL, 1231, 'Available', 3, 'goooogle', 'admin/uploads/6213064665391548082.jpg', 'https://chatgpt.com/c/6782215b-bc40-800d-a720-58375df021b7'),
(18, 'dvs', NULL, 1934, 'Available', 4, 'sdvsvsvsdvs', 'admin/uploads/6213064665391548107.jpg', 'http://localhost/serenity/admin/add_book.php');

-- --------------------------------------------------------

--
-- Table structure for table `book_requests`
--

CREATE TABLE `book_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `request_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `a_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_requests`
--

INSERT INTO `book_requests` (`request_id`, `user_id`, `book_id`, `request_date`, `status`, `a_id`) VALUES
(9, 1, 5, '2024-11-24', 'approved', 3);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `c_name`, `status`, `creation_date`, `updation_date`) VALUES
(3, 'SCI-FI', 'active', '2024-11-23 15:52:54', '2024-11-23 15:53:01'),
(4, 'Fantasy', 'active', '2024-11-24 13:14:25', '2024-11-24 13:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'suraj', 'fairytail235');

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`user_id`, `username`, `email`, `password`, `mobile`, `created_at`, `image`) VALUES
(1, 'suraj', 'suraj112gurung@gmail.com', 'abc', '9867929490', '2024-11-22 14:14:16', 'uploads/happy.jpg'),
(2, 'jarus', 'jarus@gmail.com', 'jarus12345', '8961478148', '2024-11-22 14:23:23', NULL),
(3, 'ram', 'ram@gmail.com', 'rampandey12345', '9876543210', '0000-00-00 00:00:00', NULL),
(9, 'abcde', 'abcde@gmail.com', 'abcde12345', '9834142347', '2024-11-23 10:04:16', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `book_requests`
--
ALTER TABLE `book_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `a_id` (`a_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userss`
--
ALTER TABLE `userss`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `book_requests`
--
ALTER TABLE `book_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userss`
--
ALTER TABLE `userss`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`c_id`);

--
-- Constraints for table `book_requests`
--
ALTER TABLE `book_requests`
  ADD CONSTRAINT `book_requests_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `book_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `userss` (`user_id`),
  ADD CONSTRAINT `book_requests_ibfk_3` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`),
  ADD CONSTRAINT `book_requests_ibfk_4` FOREIGN KEY (`a_id`) REFERENCES `author` (`a_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
