-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2021 at 08:45 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `App_ID` int(11) NOT NULL,
  `Post_ID` int(11) NOT NULL,
  `Emp_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`App_ID`, `Post_ID`, `Emp_ID`, `User_ID`, `Time`, `Status`) VALUES
(1, 2, 1, 1, '2021-02-01 13:30:52', 'Pending'),
(2, 3, 2, 2, '2021-02-01 13:51:03', 'Approved'),
(3, 2, 1, 2, '2021-02-01 13:51:15', 'Pending'),
(4, 2, 1, 2, '2021-02-01 16:51:14', 'Pending'),
(5, 5, 3, 1, '2021-02-01 17:49:56', 'Pending'),
(7, 6, 4, 1, '2021-02-01 19:03:46', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `employer_details`
--

CREATE TABLE `employer_details` (
  `Emp_ID` int(11) NOT NULL,
  `Name` varchar(47) NOT NULL,
  `Address` text NOT NULL,
  `Phone_Number` varchar(13) NOT NULL,
  `Logo` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employer_details`
--

INSERT INTO `employer_details` (`Emp_ID`, `Name`, `Address`, `Phone_Number`, `Logo`, `Email`, `Password`) VALUES
(1, 'Stanton Academy', '23 Colenbrander, Milton Park, Harare', '+263777991928', 'stanton gold.jpg', 'info@stanton.co.zw', 'stanton404'),
(2, 'Orbit Revolution', '401 Chibondo, Victoria Falls', '+263777991928', 'orbit.png', 'hello@orbitrev.tech', 'orbit123'),
(3, 'Harare Institute of Technology', '52 Ganges Rd., Belvedere, Harare', '+263777991928', 'hit.png', 'admin@hit.ac.zw', 'qwerty123'),
(4, 'Stanton Digital', '23 Colenbrander, Milton Park, Harare', '+263777991928', 'favicon.png', 'academy@stanton.co.zw', 'stanton404');

-- --------------------------------------------------------

--
-- Table structure for table `job_posts`
--

CREATE TABLE `job_posts` (
  `Post_ID` int(10) NOT NULL,
  `Emp_ID` int(10) NOT NULL,
  `Job_Title` varchar(100) NOT NULL,
  `Description` varchar(300) NOT NULL,
  `Post_Time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_posts`
--

INSERT INTO `job_posts` (`Post_ID`, `Emp_ID`, `Job_Title`, `Description`, `Post_Time`) VALUES
(1, 1, 'A-Level Maths Teacher', 'A fulltime Advanced Level High School Mathematics Teacher with at least 3 years of experience and a degree in education, or relevant qualification, from a recognized university.', '2021-01-30 11:37:09'),
(2, 1, 'ECD Teacher', 'Everyone is welcome!', '2021-01-30 11:44:40'),
(3, 2, 'A-Level Computer Science Teacher', 'A dedicated and enthusiastic individual willing to take fulltime employment as a Computer Science Teacher. Must have a degree in Computer Science, or relevant qualification from a recognized university or institute.', '2021-02-01 12:35:48'),
(5, 3, 'Biochemistry Lecturer', 'A minimum of 5 O Level passes, including Shona and History. ', '2021-02-01 19:48:43'),
(6, 4, 'Java Mentor', 'A young individual, preferably 22 - 32 years of age, well versed with JAVA programming language and related technologies. ', '2021-02-01 20:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `job_seekers`
--

CREATE TABLE `job_seekers` (
  `User_ID` int(11) NOT NULL,
  `Firstname` varchar(20) NOT NULL,
  `Lastname` varchar(30) NOT NULL,
  `Image` varchar(50) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Phone_Number` varchar(13) NOT NULL,
  `Skills` varchar(200) NOT NULL,
  `Qualifications` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_seekers`
--

INSERT INTO `job_seekers` (`User_ID`, `Firstname`, `Lastname`, `Image`, `Email`, `Password`, `Phone_Number`, `Skills`, `Qualifications`) VALUES
(1, 'Slim', 'Shady', 'slimshady.jpg', 'shade45@gmail.com', 'qwerty123', '+263777991928', 'Rapping, Freestyling, Elite Storytelling, Dissing,', 'Masters of Music in Dissing 1996, \r\nMasters of Music in Fast Rap 1999, \r\nPhD in Dissing 2000'),
(2, 'Stanley', 'Brikkz', 'bp2.jpg', 'stan13y@gmail.com', 'qwerty123', '+263777991928', 'Programming, Web & Software Development, ', 'Btech in Computer Science 2020,\r\nDiploma in C# Development 2019,\r\n\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`App_ID`);

--
-- Indexes for table `employer_details`
--
ALTER TABLE `employer_details`
  ADD PRIMARY KEY (`Emp_ID`);

--
-- Indexes for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`Post_ID`);

--
-- Indexes for table `job_seekers`
--
ALTER TABLE `job_seekers`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `App_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `employer_details`
--
ALTER TABLE `employer_details`
  MODIFY `Emp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `Post_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `job_seekers`
--
ALTER TABLE `job_seekers`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
