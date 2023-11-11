-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2023 at 06:52 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `acadamicyear`
--

CREATE TABLE `acadamicyear` (
  `id` int(10) NOT NULL,
  `year` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acadamicyear`
--

INSERT INTO `acadamicyear` (`id`, `year`) VALUES
(1, '2022/2023'),
(5, '2023/2024');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class`) VALUES
(1, 'SHS1'),
(2, 'SHS 2'),
(3, 'SHS 3');

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `id` int(11) NOT NULL,
  `acadamicyear` varchar(150) NOT NULL,
  `term` varchar(100) NOT NULL,
  `amount` decimal(11,0) NOT NULL,
  `class` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`id`, `acadamicyear`, `term`, `amount`, `class`) VALUES
(7, '2022/2023', '3', '400', 'SHS1'),
(6, '2022/2023', '2', '500', 'SHS1'),
(5, '2022/2023', '1', '500', 'SHS1'),
(8, '2022/2023', '1', '400', 'SHS 2');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `studentid` varchar(20) NOT NULL,
  `acadamicyear` varchar(50) NOT NULL,
  `term` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `mop` varchar(100) NOT NULL,
  `amount` decimal(11,0) NOT NULL,
  `date` date NOT NULL,
  `adminid` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `studentid`, `acadamicyear`, `term`, `class`, `mop`, `amount`, `date`, `adminid`) VALUES
(3, '20210404028', '2022/2023', 1, 'SHS1', 'Momo', '400', '2023-04-12', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` varchar(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` varchar(20) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `password` varchar(250) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `telephone` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `fullname`, `role`, `subject`, `password`, `gender`, `telephone`) VALUES
('0001', 'Teacher Kofi', 'Administrator', '', '12345', 'Male', '0200'),
('0002', 'Teacher Sanda', 'Administrator', '', '12345', 'Male', '02000');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `studentid` varchar(20) DEFAULT NULL,
  `studentfullname` varchar(150) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `class` varchar(10) DEFAULT NULL,
  `year` varchar(100) DEFAULT NULL,
  `hostel` varchar(50) DEFAULT NULL,
  `guidianname` varchar(100) DEFAULT NULL,
  `guidiannumber` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `studentid`, `studentfullname`, `gender`, `address`, `dob`, `class`, `year`, `hostel`, `guidianname`, `guidiannumber`) VALUES
(1, '0001', 'Inusah Mustapha', 'Male', 'Ax52', '2023-04-21', 'SHS 2', '2022/2023', 'Glory Land', 'Abubakari Mustapha', '687693844'),
(2, '20210404028', 'Inusah Mustapha', 'Male', 'Ax53', '2023-05-26', 'SHS1', '2022/2023', 'Ecowas', 'Adam Inusah', '0256670618');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acadamicyear`
--
ALTER TABLE `acadamicyear`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acadamicyear`
--
ALTER TABLE `acadamicyear`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
