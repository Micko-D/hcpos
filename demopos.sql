-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2024 at 07:05 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demopos`
--

-- --------------------------------------------------------

--
-- Table structure for table `addonorder`
--

CREATE TABLE `addonorder` (
  `id` int NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `productorderid` varchar(255) NOT NULL,
  `addonname` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `orderdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int NOT NULL,
  `role` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `fromdev` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `prodname` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `role`, `userid`, `date`, `time`, `fromdev`, `action`, `prodname`, `info`) VALUES
(2, 'Admin', 'Tql1gyNXU641', '2023-10-01', '18:20:33', 'Web', 'Inventory Entry', 'Chicken Wings', 'POS'),
(3, 'Admin', 'Tql1gyNXU641', '2023-10-01', '19:47:35', 'Web', 'Update Drink Product', 'Choco', 'POS'),
(4, 'Admin', 'Tql1gyNXU641', '2023-10-01', '19:48:10', 'Web', 'Update Food Product', 'Buttered Chicken Wings', 'POS'),
(5, 'Admin', 'Tql1gyNXU641', '2023-10-01', '19:48:26', 'Web', 'Update Add-on Product', 'Garlic Sauce', 'POS'),
(6, 'Admin', 'Tql1gyNXU641', '2023-10-01', '19:52:50', 'Web', 'Update Drink Product', '12Oz. Choco', 'POS'),
(7, 'Admin', 'Tql1gyNXU641', '2023-10-01', '19:53:03', 'Web', 'Update Food Product', '1pc Buttered Chicken Wings', 'POS'),
(13, 'Admin', 'Tql1gyNXU641', '2023-10-01', '20:26:41', 'Web', 'Update Profile ', '', 'User'),
(16, 'Admin', 'Tql1gyNXU641', '2023-10-01', '21:08:29', 'Web', 'Unban Profile', 'ASDZXCWEASDZC1234', 'User'),
(17, 'Admin', 'Tql1gyNXU641', '2023-10-01', '21:08:32', 'Web', 'Ban Profile ', 'ASDZXCWEASDZC1234', 'User'),
(18, 'Admin', 'Tql1gyNXU641', '2023-10-01', '15:15:12', 'Web', 'Create Profile ', 'wE3mJ2AD68c2', 'User'),
(19, 'Cashier', 'vFpjcnihHMv4', '2023-10-01', '21:47:51', 'Mobile', 'Logged In', '', 'Login'),
(20, 'Cashier', 'vFpjcnihHMv4', '2023-10-01', '21:57:12', 'Mobile', 'Logged Out', '', 'Login'),
(21, 'Cashier', 'vFpjcnihHMv4', '2023-10-01', '21:57:27', 'Web', 'Logged In', '', 'Login'),
(22, 'Cashier', 'vFpjcnihHMv4', '2023-10-01', '21:57:29', 'Web', 'Logged Out', '', 'Login'),
(23, 'Admin', 'Tql1gyNXU641', '2023-10-01', '21:57:56', 'Web', 'Logged In', '', 'Login'),
(24, 'Admin', 'Tql1gyNXU641', '2023-10-01', '22:26:45', 'Web', 'Logged Out', '', 'Login'),
(25, 'Admin', 'Tql1gyNXU641', '2023-10-01', '22:29:23', 'Web', 'Logged In', '', 'Login'),
(26, 'Admin', 'Tql1gyNXU641', '2023-10-01', '22:48:11', 'Web', 'Logged Out', '', 'Login'),
(27, 'Admin', 'Tql1gyNXU641', '2023-10-01', '22:48:30', 'Web', 'Logged In', '', 'Login'),
(28, 'Admin', 'Tql1gyNXU641', '2023-10-01', '22:48:44', 'Web', 'Logged Out', '', 'Login'),
(29, 'Admin', 'Tql1gyNXU641', '2023-10-01', '22:49:27', 'Web', 'Logged In', '', 'Login'),
(35, 'null', 'null', '2023-10-03', '11:44:54', 'Web', 'Feedback Acknowledge', '1', 'User'),
(36, 'Admin', 'Tql1gyNXU641', '2023-10-03', '12:03:32', 'Web', 'Logged In', '', 'Login'),
(37, 'Admin', 'Tql1gyNXU641', '2023-10-03', '12:04:26', 'Web', 'Logged In', '', 'Login'),
(38, 'Admin', 'Tql1gyNXU641', '2023-10-03', '12:05:38', 'Web', 'Logged In', '', 'Login'),
(39, 'Admin', 'Tql1gyNXU641', '2023-10-03', '22:28:33', 'Web', 'Logged Out', '', 'Login'),
(40, 'Cashier', 'vFpjcnihHMv4', '2023-10-03', '22:30:24', 'Web', 'Logged In', '', 'Login'),
(41, 'Cashier', 'vFpjcnihHMv4', '2023-10-03', '22:30:48', 'Web', 'Logged Out', '', 'Login'),
(42, 'Admin', 'Tql1gyNXU641', '2023-10-03', '22:31:08', 'Web', 'Logged In', '', 'Login'),
(43, 'Admin', 'Tql1gyNXU641', '2023-10-03', '22:31:50', 'Web', 'Update Profile ', '', 'User'),
(44, 'Admin', 'Tql1gyNXU641', '2023-10-03', '22:32:37', 'Web', 'Logged Out', '', 'Login'),
(45, 'Cashier', 'vFpjcnihHMv4', '2023-10-03', '22:32:45', 'Web', 'Logged In', '', 'Login'),
(46, 'Cashier', 'vFpjcnihHMv4', '2023-10-03', '22:37:13', 'Web', 'Logged Out', '', 'Login'),
(47, 'Admin', 'Tql1gyNXU641', '2023-10-03', '22:41:20', 'Web', 'Logged Out', '', 'Login'),
(48, 'Admin', 'Tql1gyNXU641', '2023-10-03', '23:04:17', 'Web', 'Logged In', '', 'Login'),
(49, '', '', '2023-10-04', '12:18:42', '', 'Update Profile ', '', 'User'),
(50, 'Admin', 'Tql1gyNXU641', '2023-10-04', '12:18:42', '', 'Update Profile ', '', 'User'),
(51, 'Cashier', 'vFpjcnihHMv4', '2023-10-09', '21:03:31', 'Web', 'Logged In', '', 'Login'),
(52, 'Cashier', 'vFpjcnihHMv4', '2023-10-17', '19:59:24', 'Web', 'Logged In', '', 'Login'),
(53, 'Cashier', 'vFpjcnihHMv4', '2023-10-18', '08:30:41', 'Web', 'Logged Out', '', 'Login'),
(54, 'Cashier', 'vFpjcnihHMv4', '2023-10-18', '08:30:42', 'Web', 'Logged Out', '', 'Login'),
(55, 'Admin', 'Tql1gyNXU641', '2023-10-18', '22:35:35', 'Web', 'Logged In', '', 'Login'),
(56, 'Admin', 'Tql1gyNXU641', '2023-10-24', '13:27:57', 'Web', 'Logged In', '', 'Login'),
(57, 'Admin', 'Tql1gyNXU641', '2023-11-04', '21:15:19', 'Web', 'Logged Out', '', 'Login'),
(58, 'Cashier', 'vFpjcnihHMv4', '2023-11-04', '21:15:23', 'Web', 'Logged In', '', 'Login'),
(59, '', '', '2023-11-05', '04:07:33', 'Web', 'Create Profile ', 'HMFK4ubQ8FwR', 'User'),
(60, '', '', '2023-11-06', '08:26:48', 'Web', 'Create Profile ', 'wVNBkDxjo3pC', 'User'),
(61, 'Cashier', 'vFpjcnihHMv4', '2023-11-06', '16:44:36', 'Web', 'Logged In', '', 'Login'),
(62, 'Admin', 'Tql1gyNXU641', '2023-11-07', '14:09:42', 'Web', 'Logged Out', '', 'Login'),
(63, 'Admin', 'Tql1gyNXU641', '2023-11-07', '21:50:46', 'Web', 'Logged In', '', 'Login'),
(64, 'Admin', 'Tql1gyNXU641', '2023-11-14', '19:41:13', 'Web', 'Logged In', '', 'Login'),
(65, 'Admin', 'Tql1gyNXU641', '2023-11-17', '18:34:00', 'Web', 'Logged Out', '', 'Login'),
(66, 'Cashier', 'vFpjcnihHMv4', '2023-11-17', '18:34:05', 'Web', 'Logged In', '', 'Login'),
(67, 'Admin', 'Tql1gyNXU641', '2023-11-17', '18:39:18', 'Web', 'Logged In', '', 'Login'),
(68, 'Admin', 'Tql1gyNXU641', '2023-11-17', '18:50:35', 'Web', 'Logged Out', '', 'Login'),
(69, 'Cashier', 'vFpjcnihHMv4', '2023-11-17', '18:50:39', 'Web', 'Logged In', '', 'Login'),
(70, 'Cashier', 'vFpjcnihHMv4', '2023-11-17', '18:58:27', 'Web', 'Logged Out', '', 'Login'),
(71, 'Admin', 'Tql1gyNXU641', '2023-11-17', '18:58:41', 'Web', 'Logged In', '', 'Login'),
(72, 'Admin', 'Tql1gyNXU641', '2023-11-18', '10:01:40', 'Mobile', 'Logged In', '', 'Login'),
(73, 'Admin', 'Tql1gyNXU641', '2023-11-22', '20:21:13', 'Web', 'Logged Out', '', 'Login'),
(74, 'Cashier', 'vFpjcnihHMv4', '2023-11-22', '20:21:18', 'Web', 'Logged In', '', 'Login'),
(75, 'Cashier', 'vFpjcnihHMv4', '2023-11-22', '20:22:49', 'Web', 'Logged Out', '', 'Login'),
(76, 'Admin', 'Tql1gyNXU641', '2023-11-22', '20:23:05', 'Web', 'Logged In', '', 'Login'),
(77, 'Admin', 'Tql1gyNXU641', '2023-11-22', '20:38:43', 'Web', 'Logged Out', '', 'Login'),
(78, 'Cashier', 'vFpjcnihHMv4', '2023-11-22', '20:38:48', 'Web', 'Logged In', '', 'Login'),
(79, 'Cashier', 'vFpjcnihHMv4', '2023-11-23', '08:25:33', 'Web', 'Logged Out', '', 'Login'),
(80, 'Admin', 'Tql1gyNXU641', '2023-11-23', '08:26:56', 'Web', 'Logged In', '', 'Login'),
(81, 'Admin', 'Tql1gyNXU641', '2023-11-24', '21:20:17', 'Web', 'Logged In', '', 'Login'),
(82, 'Admin', 'Tql1gyNXU641', '2023-11-24', '22:05:51', 'Web', 'Inventory Entry', '12Oz. Small Cup', 'POS'),
(83, 'Admin', 'Tql1gyNXU641', '2023-11-24', '22:07:42', 'Web', 'Unban Profile', 'ASDZXCWEASDZC1234', 'User'),
(84, 'Admin', 'Tql1gyNXU641', '2023-11-24', '22:07:54', 'Web', 'Ban Profile ', 'ASDZXCWEASDZC1234', 'User'),
(85, 'Admin', 'Tql1gyNXU641', '2023-11-24', '22:10:40', 'Web', 'Unban Profile', 'ASDZXCWEASDZC1234', 'User'),
(86, 'Admin', 'Tql1gyNXU641', '2023-11-28', '21:38:44', 'Web', 'Logged In', '', 'Login'),
(87, 'Admin', 'Tql1gyNXU641', '2023-11-29', '08:28:37', 'Web', 'Logged In', '', 'Login'),
(88, 'Admin', 'Tql1gyNXU641', '2023-11-30', '09:55:45', 'Web', 'Logged In', '', 'Login'),
(89, 'Admin', 'Tql1gyNXU641', '2023-11-30', '13:40:04', 'Web', 'Logged Out', '', 'Login'),
(90, 'Cashier', 'vFpjcnihHMv4', '2023-11-30', '13:40:08', 'Web', 'Logged In', '', 'Login'),
(91, 'Cashier', 'vFpjcnihHMv4', '2023-11-30', '13:48:32', 'Web', 'Logged Out', '', 'Login'),
(92, 'Admin', 'Tql1gyNXU641', '2023-11-30', '13:48:36', 'Web', 'Logged In', '', 'Login'),
(93, 'Admin', 'Tql1gyNXU641', '2023-11-30', '21:12:22', 'Web', 'Logged In', '', 'Login'),
(94, 'Admin', 'Tql1gyNXU641', '2023-12-01', '08:18:36', 'Web', 'Logged In', '', 'Login'),
(95, 'Admin', 'Tql1gyNXU641', '2023-12-01', '11:23:14', 'Web', 'Logged In', '', 'Login'),
(96, 'Admin', 'Tql1gyNXU641', '2023-12-02', '00:25:19', 'Web', 'Logged In', '', 'Login'),
(97, 'Admin', 'Tql1gyNXU641', '2023-12-02', '22:16:24', 'Web', 'Logged In', '', 'Login'),
(98, 'Admin', 'Tql1gyNXU641', '2023-12-03', '10:35:02', 'Web', 'Logged In', '', 'Login'),
(99, 'Admin', 'Tql1gyNXU641', '2023-12-04', '08:31:18', 'Web', 'Logged In', '', 'Login'),
(100, 'Admin', 'Tql1gyNXU641', '2023-12-05', '09:31:26', 'Web', 'Logged In', '', 'Login'),
(101, '', '', '2023-12-05', '14:56:09', 'Web', 'Insert Product', '', 'POS'),
(102, '', '', '2023-12-05', '14:57:31', 'Web', 'Insert Product', '', 'POS'),
(103, '', '', '2023-12-05', '19:08:30', 'Web', 'Insert Product', '', 'POS'),
(104, '', '', '2023-12-05', '20:17:28', 'Web', 'Insert Product', '', 'POS'),
(105, '', '', '2023-12-05', '20:22:46', 'Web', 'Insert Product', '', 'POS'),
(106, '', '', '2023-12-05', '20:30:55', 'Web', 'Insert Product', '', 'POS'),
(107, 'Admin', 'Tql1gyNXU641', '2023-12-06', '10:27:49', 'Web', 'Logged In', '', 'Login'),
(108, 'Admin', 'Tql1gyNXU641', '2023-12-06', '23:27:10', 'Web', 'Logged In', '', 'Login'),
(109, 'Admin', 'Tql1gyNXU641', '2023-12-07', '00:14:34', 'Web', 'Logged In', '', 'Login'),
(110, 'Admin', 'Tql1gyNXU641', '2023-12-07', '00:41:24', 'Web', 'Logged In', '', 'Login'),
(111, 'Admin', 'Tql1gyNXU641', '2023-12-07', '00:41:28', 'Web', 'Logged In', '', 'Login'),
(112, 'Admin', 'Tql1gyNXU641', '2023-12-09', '12:43:31', 'Web', 'Logged In', '', 'Login'),
(113, 'Admin', 'Tql1gyNXU641', '2023-12-11', '09:44:05', 'Web', 'Logged In', '', 'Login'),
(114, '', '', '2023-12-11', '09:44:38', 'Web', 'Insert Product', '', 'POS'),
(115, '', '', '2023-12-11', '09:44:55', 'Web', 'Insert Product', '', 'POS'),
(116, 'Admin', 'Tql1gyNXU641', '2024-08-01', '14:13:46', 'Mobile', 'Logged In', '', 'Login'),
(117, 'Admin', 'Tql1gyNXU641', '2024-08-01', '14:23:09', 'Web', 'Logged In', '', 'Login'),
(118, 'Admin', 'Tql1gyNXU641', '2024-08-01', '14:23:21', 'Web', 'Logged In', '', 'Login');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `userid` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `acknowledge` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `userid`, `message`, `category`, `datetime`, `acknowledge`) VALUES
(1, 'ASDZXCWEASDZC1234', 'Test Message for feedback', 'Category Test', '2023-10-03 10:38:37', 'Acknowledge');

-- --------------------------------------------------------

--
-- Table structure for table `inventoryrecords`
--

CREATE TABLE `inventoryrecords` (
  `id` int NOT NULL,
  `prodid` int NOT NULL,
  `dateentry` date NOT NULL,
  `timeentry` time NOT NULL,
  `purchased` int NOT NULL,
  `released` int NOT NULL,
  `updateentry` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventoryrecords`
--

INSERT INTO `inventoryrecords` (`id`, `prodid`, `dateentry`, `timeentry`, `purchased`, `released`, `updateentry`) VALUES
(1, 867582, '2023-12-11', '10:15:39', 0, 4, 'Material Released'),
(2, 23345, '2023-12-11', '10:15:39', 0, 4, 'Material Released'),
(3, 924049, '2023-12-11', '10:12:30', 0, 3, 'Material Released');

-- --------------------------------------------------------

--
-- Table structure for table `itemscreated`
--

CREATE TABLE `itemscreated` (
  `id` int NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `itemtype` varchar(255) NOT NULL,
  `itemvariant` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `itemscreated`
--

INSERT INTO `itemscreated` (`id`, `itemname`, `itemtype`, `itemvariant`) VALUES
(1, 'Drink Sample', 'Drink', 'Hot Coffee'),
(2, 'Drink Sample', 'Drink', 'Iced Coffee'),
(3, 'Drink Sample', 'Drink', 'Milkshake'),
(4, 'Drink Sample', 'Drink', 'Yakult Blend'),
(5, 'Drink Sample', 'Drink', 'Frappe'),
(6, 'food sample', 'Food', '1pc'),
(7, 'food sample', 'Food', '2pcs'),
(8, 'food sample', 'Food', 'Ala Carte'),
(9, 'food sample', 'Food', 'Regular'),
(10, 'food sample 2', 'Food', '1pc'),
(11, 'food sample 2', 'Food', '2pcs');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `conversationid` int NOT NULL,
  `userid` varchar(255) NOT NULL,
  `receiverid` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetimemess` datetime NOT NULL,
  `readstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversationid`, `userid`, `receiverid`, `state`, `message`, `datetimemess`, `readstatus`) VALUES
(1, 1, 'ASDZXCWEASDZC1234', 'Tql1gyNXU641', 'Receive', 'Hello, Testing I Message Store', '2023-10-03 12:29:00', 'Read'),
(2, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Hi Customer, This is my reply', '2023-10-03 12:30:58', 'Read'),
(3, 1, 'ASDZXCWEASDZC1234', 'Tql1gyNXU641', 'Receive', 'Very Long Message Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vitae dicta aut cupiditate? Voluptate aut quod voluptates a quia sapiente, fugiat odit laudantium ad earum iste explicabo rem, recusandae sed. Laboriosam?Lorem ipsum, dolor sit am', '2023-10-03 13:39:18', 'Read'),
(4, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'SAmple', '2023-10-03 14:21:44', 'Read'),
(5, 1, 'ASDZXCWEASDZC1234', 'Tql1gyNXU641', 'Receive', 'NEW MESSAGE REPLIED BY CUSTOMER', '2023-10-03 14:36:33', 'Read'),
(6, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'I know this is great ', '2023-10-03 14:36:52', 'Read'),
(7, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Happy to serve', '2023-10-03 14:38:14', 'Read'),
(8, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'New Message by Store to customer', '2023-10-03 14:40:12', 'Read'),
(9, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Hello', '2023-10-03 15:17:42', 'Read'),
(10, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Test Floater', '2023-10-03 15:57:05', 'Read'),
(11, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Test', '2023-10-03 15:57:27', 'Read'),
(12, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Test 2', '2023-10-03 16:01:30', 'Read'),
(13, 1, 'ASDZXCWEASDZC1234', 'Tql1gyNXU641', 'Receive', 'Test Reply for scroll button', '2023-10-03 16:10:30', 'Read'),
(14, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Hisadsad', '2023-10-03 16:11:09', 'Read'),
(15, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Hesadasda', '2023-10-03 16:11:34', 'Read'),
(16, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'ADZXCASDAS', '2023-10-03 21:41:06', 'Read'),
(17, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Pleasdwz', '2023-10-03 21:44:08', 'Read'),
(18, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'ZZZ', '2023-10-03 21:44:39', 'Read'),
(20, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Enter Reply', '2023-10-04 13:35:49', 'Read'),
(22, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Hello', '2023-10-04 13:36:40', 'Read'),
(23, 1, 'Tql1gyNXU641', 'ASDZXCWEASDZC1234', 'Sent', 'Long Time NO Chat', '2023-10-24 13:55:57', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `onlineaddon`
--

CREATE TABLE `onlineaddon` (
  `id` int NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `productorderid` varchar(255) NOT NULL,
  `addonname` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `orderdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `onlineorder`
--

CREATE TABLE `onlineorder` (
  `id` int NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `riderid` varchar(255) NOT NULL,
  `rfid` varchar(255) NOT NULL,
  `customername` varchar(255) NOT NULL,
  `foodins` varchar(255) NOT NULL,
  `productid` varchar(255) NOT NULL,
  `productorderid` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `totalprice` varchar(255) NOT NULL,
  `orderstatus` varchar(255) NOT NULL,
  `ordertype` varchar(255) NOT NULL,
  `orderdate` date DEFAULT NULL,
  `ordertime` time DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `rfid` varchar(255) NOT NULL,
  `customername` varchar(255) NOT NULL,
  `productid` varchar(255) NOT NULL,
  `productorderid` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `cardnumber` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `totalprice` varchar(255) NOT NULL,
  `changepay` varchar(255) NOT NULL,
  `orderstatus` varchar(255) NOT NULL,
  `ordertype` varchar(255) NOT NULL,
  `orderdate` date DEFAULT NULL,
  `ordertime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `orderid`, `userid`, `rfid`, `customername`, `productid`, `productorderid`, `quantity`, `subtotal`, `discount`, `cardnumber`, `payment`, `totalprice`, `changepay`, `orderstatus`, `ordertype`, `orderdate`, `ordertime`) VALUES
(1, '76', 'Tql1gyNXU641', '81592862502', 'test', '853281', '853281-1702259099773', '1', '55.00', '', '', '110', 'PHP 110.00', 'PHP 0.00', 'Dine-In', 'Dine-In', '2023-12-11', '09:45:28'),
(2, '76', 'Tql1gyNXU641', '81592862502', 'test', ' 503930 ', ' 503930 -1702259102365', '1', '55.00', '', '', '110', 'PHP 110.00', 'PHP 0.00', 'Dine-In', 'Dine-In', '2023-12-11', '09:45:28'),
(3, '86', 'Tql1gyNXU641', '29511847227', 'asd', '853281', '853281-1702260596682', '1', '55.00', '', '', '110', 'PHP 110.00', 'PHP 0.00', 'Dine-In', 'Dine-In', '2023-12-11', '10:10:05'),
(4, '86', 'Tql1gyNXU641', '29511847227', 'asd', ' 503930 ', ' 503930 -1702260599682', '1', '55.00', '', '', '110', 'PHP 110.00', 'PHP 0.00', 'Dine-In', 'Dine-In', '2023-12-11', '10:10:05'),
(5, '18', 'Tql1gyNXU641', '37010380350', '', '853281', '853281-1702260734977', '1', '55.00', '', '', '110', 'PHP 110.00', 'PHP 0.00', 'Dine-In', 'Dine-In', '2023-12-11', '10:12:30'),
(6, '18', 'Tql1gyNXU641', '37010380350', '', ' 503930 ', ' 503930 -1702260737777', '1', '55.00', '', '', '110', 'PHP 110.00', 'PHP 0.00', 'Dine-In', 'Dine-In', '2023-12-11', '10:12:30'),
(7, '65', 'Tql1gyNXU641', '27611145466', 'zxc', '853281', '853281-1702260932198', '1', '55.00', '', '', '60', 'PHP 55.00', 'PHP 5.00', 'Dine-In', 'Dine-In', '2023-12-11', '10:15:39');

-- --------------------------------------------------------

--
-- Table structure for table `productmaterials`
--

CREATE TABLE `productmaterials` (
  `id` int NOT NULL,
  `prodid` varchar(255) NOT NULL,
  `prodmatid` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `productmaterials`
--

INSERT INTO `productmaterials` (`id`, `prodid`, `prodmatid`, `quantity`) VALUES
(1, '853281', '23345', '1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prodid` int NOT NULL,
  `prodname` varchar(255) NOT NULL,
  `producttype` varchar(255) NOT NULL,
  `productvariant` varchar(255) NOT NULL,
  `productsize` varchar(255) NOT NULL,
  `productprice` varchar(255) NOT NULL,
  `productimg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prodid`, `prodname`, `producttype`, `productvariant`, `productsize`, `productprice`, `productimg`) VALUES
(23345, 'Chicken Wings', 'Inventory', 'Inventory', '211', '0', 'AdminLTELogo.png'),
(82987, '22Oz. Extra Large Cup', 'Inventory', 'Inventory', '46', '0', 'AdminLTELogo.png'),
(185749, 'Nachos', 'Inventory', 'Inventory', '100', '0', 'AdminLTELogo.png'),
(466016, 'Styro', 'Inventory', 'Inventory', '483', '0', 'AdminLTELogo.png'),
(503930, 'Mazagran', 'Drink', 'Iced Coffee', '16Oz.', '55', 'AdminLTELogo.png'),
(546586, 'Beef', 'Inventory', 'Inventory', '100', '0', 'AdminLTELogo.png'),
(597682, '12Oz. Small Cup', 'Inventory', 'Inventory', '546', '0', 'AdminLTELogo.png'),
(724860, 'Pasta', 'Inventory', 'Inventory', '100', '0', 'AdminLTELogo.png'),
(747141, 'Fries', 'Inventory', 'Inventory', '100', '0', 'AdminLTELogo.png'),
(853281, 'Delhi Chicken Masala Wings', 'Food', '1pc', '1pc', '55', 'AdminLTELogo.png'),
(867582, 'Parchment Paper', 'Inventory', 'Inventory', '941', '', 'parchmentpaper.jpg'),
(924049, '16Oz. Large Cup', 'Inventory', 'Inventory', '493', '0', 'AdminLTELogo.png'),
(932011, 'Tofu', 'Inventory', 'Inventory', '100', '0', 'AdminLTELogo.png'),
(982427, 'Pork', 'Inventory', 'Inventory', '100', '0', 'AdminLTELogo.png');

-- --------------------------------------------------------

--
-- Table structure for table `storecheck`
--

CREATE TABLE `storecheck` (
  `id` int NOT NULL,
  `activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `storecheck`
--

INSERT INTO `storecheck` (`id`, `activity`) VALUES
(1, 'Open'),
(2, 'Disabled');

-- --------------------------------------------------------

--
-- Table structure for table `ticketreply`
--

CREATE TABLE `ticketreply` (
  `id` int NOT NULL,
  `ticketid` varchar(255) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `issue` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetimetickrep` datetime NOT NULL,
  `readstatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ticketreply`
--

INSERT INTO `ticketreply` (`id`, `ticketid`, `userid`, `orderid`, `issue`, `state`, `message`, `datetimetickrep`, `readstatus`) VALUES
(1, '1', 'ASDZXCWEASDZC1234', '12521', 'Test Issue', 'Receive', 'Test message for ticket', '2023-10-03 23:32:43', 'Read'),
(2, '1', 'Tql1gyNXU641', '', '', 'Sent', 'Ticket Replied', '2023-10-04 13:33:22', 'Read'),
(3, '1', 'Tql1gyNXU641', '', '', 'Sent', 'Press Enter Reply ', '2023-10-04 13:34:52', 'Read'),
(5, '2', 'ASDZXCWEASDZC1234', 'kjksadAJ42', 'Wrong Order', 'Receive', 'Mali order', '2023-10-24 13:51:23', 'Read'),
(6, '2', 'Tql1gyNXU641', '', '', 'Sent', 'Bakit?', '2023-10-24 13:53:20', 'Read'),
(7, '2', 'Tql1gyNXU641', '', '', 'Sent', 'Bakit Kasi', '2023-10-24 13:53:51', 'Read'),
(8, '3', 'ASDZXCWEASDZC1234', 'asd123z', 'Test Badge', 'Receive', 'Badge Count', '2023-11-03 12:25:19', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketid` int NOT NULL,
  `userid` varchar(255) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `issue` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetimeticket` datetime NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketid`, `userid`, `orderid`, `issue`, `message`, `datetimeticket`, `status`) VALUES
(1, 'ASDZXCWEASDZC1234', '12521', 'Test Issue', 'Test message for ticket', '2023-10-03 23:32:43', 'Settled'),
(2, 'ASDZXCWEASDZC1234', 'kjksadAJ42', 'Wrong Order', 'Mali order', '2023-10-24 13:51:23', 'Settled'),
(3, 'ASDZXCWEASDZC1234', 'asd123z', 'Test Badge', 'Badge Count', '2023-11-03 12:25:19', 'Unsettled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `userid` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `accpassword` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactnum` varchar(255) NOT NULL,
  `accrole` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `userimg` varchar(255) NOT NULL,
  `verified` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userid`, `username`, `accpassword`, `fullname`, `email`, `contactnum`, `accrole`, `address`, `userimg`, `verified`) VALUES
(4, 'vFpjcnihHMv4', 'Ashlyn', 'cashier1', 'Ashlyn Kate Caburnay', 'ashlyn@gmail.com', '+63 9123456789', 'Cashier', 'Tabing Ilog Na Nakatira', 'avatar2.png', ''),
(5, 'Cyk5W0210IFz', 'Christine', 'cashier2', 'Christine Claire Bergado', 'christine@gmail.com', '+63 9123456788', 'Cashier', 'Taga Doon Sa Malayong Lugar', 'avatar3.png', ''),
(7, '8dzLtuNTvzGQ', 'Micko', 'deliver1', 'Micko Domingo', 'micko@gmail.com', '+63 9123456777', 'Delivery Person', 'Dito Doon Jan Ang Lugar Ko', 'avatar5.png', ''),
(8, 'Tql1gyNXU641', 'admin', 'admin', 'Aaron De guzman', '', '', 'Admin', '', '', ''),
(9, 'ASDZXCWEASDZC1234', 'Customer1', 'Customer1', 'Customer 1', 'Customer1@example.com', '+63 1234563333', 'Customer', 'Dito Doon Jan ', 'avatar2.png', 'Verified'),
(10, 'wE3mJ2AD68c2', 'Maria', 'Cashier3', 'Maria Makiling', 'mariamakiling@gmail.com', '+63 9966221135', 'Admin', 'Bahay Na Bato Hindi Kubo', 'avatar3.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addonorder`
--
ALTER TABLE `addonorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventoryrecords`
--
ALTER TABLE `inventoryrecords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itemscreated`
--
ALTER TABLE `itemscreated`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlineaddon`
--
ALTER TABLE `onlineaddon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlineorder`
--
ALTER TABLE `onlineorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productmaterials`
--
ALTER TABLE `productmaterials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prodid`);

--
-- Indexes for table `storecheck`
--
ALTER TABLE `storecheck`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticketreply`
--
ALTER TABLE `ticketreply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addonorder`
--
ALTER TABLE `addonorder`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventoryrecords`
--
ALTER TABLE `inventoryrecords`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `itemscreated`
--
ALTER TABLE `itemscreated`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `onlineaddon`
--
ALTER TABLE `onlineaddon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `onlineorder`
--
ALTER TABLE `onlineorder`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productmaterials`
--
ALTER TABLE `productmaterials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `storecheck`
--
ALTER TABLE `storecheck`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticketreply`
--
ALTER TABLE `ticketreply`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
