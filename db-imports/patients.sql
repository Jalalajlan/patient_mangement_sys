-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2021 at 08:26 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `covid19`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `age` int(12) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `mobileno` varchar(25) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '1',
  `admissiondate` datetime NOT NULL,
  `icuadmissiondate` datetime NOT NULL,
  `clinicaldeathdate` datetime NOT NULL,
  `dischargedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`, `gender`, `age`, `address`, `city`, `state`, `mobileno`, `status`, `admissiondate`, `icuadmissiondate`, `clinicaldeathdate`, `dischargedate`) VALUES
(1, 'Jalal Ali Abdullah Ahmed', 'male', 20, '03-204 M5L2 Melawis Apartment\njalan pendidikan 1', 'Johor Bahur', 'Skudai, Malaysia', '232323', 'Discharge', '2021-07-10 10:50:23', '2021-07-10 13:55:32', '0000-00-00 00:00:00', '2021-07-10 14:23:57'),
(2, 'Jalal Ali Abdullah Ahmed', 'female', 34, '03-204 M5L2 Melawis Apartment\njalan pendidikan 1', 'Johor Bahur', 'Skudai, Malaysia', '01160585017', 'Clinical Death', '2021-07-10 10:53:02', '0000-00-00 00:00:00', '2021-07-10 14:04:32', '2021-07-10 14:04:27'),
(6, 'Labs Layout', 'male', 60, 'melawis apartment, Taman uni, skudai, Johor Baru', 'Johor Baru', 'Skudai', '30', 'ICU', '2021-07-10 12:56:33', '2021-07-10 14:04:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Nuha Ajlan', 'female', 27, 'melawis apartment, Taman uni, skudai, Johor Baru', 'Johor Baru', 'Penange', '122323', 'ICU', '2021-07-10 13:07:20', '2021-07-10 14:04:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Jalal Ali Abdullah Ahmed', 'male', 90, '03-204 M5L2 Melawis Apartment\njalan pendidikan 1', 'Johor Bahur', 'Skudai, Malaysia', '2323', '1', '2021-07-10 14:06:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Jalal Ali Abdullah Ahmed', 'male', 20, '03-204 M5L2 Melawis Apartment\njalan pendidikan 1', 'Johor Bahur', 'Skudai, Malaysia', '232323', '1', '2021-07-10 14:22:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
