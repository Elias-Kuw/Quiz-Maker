-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 05:39 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions1`
--

CREATE TABLE `questions1` (
  `ID` int(5) NOT NULL,
  `quizid` int(5) NOT NULL,
  `question` varchar(500) NOT NULL,
  `opt1` varchar(100) NOT NULL,
  `opt2` varchar(100) NOT NULL,
  `opt3` varchar(100) NOT NULL,
  `opt4` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions1`
--

INSERT INTO `questions1` (`ID`, `quizid`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `answer`) VALUES
(32, 17, '2+1 =', '4', '1', '3', '2', '3'),
(33, 17, '2+2 = ', '5', '4', '3', '2', '4'),
(34, 17, '3+2 =', '5', '6', '3', '9', '5'),
(35, 18, '4+5', '9', '10', '6', '8', '9'),
(36, 18, '6+5 =', '11', '9', '10', '1', '11'),
(37, 19, '2-1 =', '2', '1', '3', '4', '1'),
(38, 19, '0-1 =', '1', '3', '2', '5', '1'),
(39, 20, '9-2 =', '7', '9', '5', '1', '7'),
(40, 20, '9-5 = ', '7', '4', '5', '9', '4'),
(41, 21, '1x1 = ', '1', '3', '2', '11', '1'),
(42, 21, '1x2 = ', '3', '2', '4', '1', '2'),
(43, 22, '4x4 =', '16', '12', '15', '18', '16'),
(44, 22, '6x6 =', '36', '63', '23', '54', '36'),
(45, 23, '5/5 =', '1', '5', '4', '2', '1'),
(46, 23, '4/2 = ', '4', '2', '6', '9', '2');

-- --------------------------------------------------------

--
-- Table structure for table `questions2`
--

CREATE TABLE `questions2` (
  `ID` int(11) NOT NULL,
  `quizid` int(5) NOT NULL,
  `question` varchar(500) NOT NULL,
  `opt1` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions2`
--

INSERT INTO `questions2` (`ID`, `quizid`, `question`, `opt1`, `answer`) VALUES
(14, 17, '1+2 = ', '3', '3'),
(15, 17, '3+1 =', '4', '4'),
(16, 18, '5+3 =', '8', '8'),
(17, 19, '4-2 = ', '2', '2'),
(18, 20, '6-4 =', '2', '2'),
(19, 20, '8-0 = ', '8', '8'),
(20, 21, '3x2 =', '6', '6'),
(21, 21, '2x2 =', '4', '4'),
(22, 22, '5x9 =', '45', '45'),
(23, 22, '5x7 =', '35', '35'),
(24, 23, '6/3 = ', '2', '2'),
(25, 23, '9/3 = ', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `questions3`
--

CREATE TABLE `questions3` (
  `ID` int(5) NOT NULL,
  `quizid` int(5) NOT NULL,
  `question` varchar(500) NOT NULL,
  `op1` varchar(100) NOT NULL,
  `op2` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions3`
--

INSERT INTO `questions3` (`ID`, `quizid`, `question`, `op1`, `op2`, `answer`) VALUES
(11, 17, '1+1 = 2', 'T', 'F', 'T'),
(12, 18, '4+3 = 6', 'T', 'F', 'F'),
(13, 18, '5+5 = 10', 'F', 'T', 'T'),
(14, 19, '3-1 = 2', 'T', 'F', 'T'),
(15, 20, '8-7 = 1', 'F', 'T', 'T'),
(16, 20, '8-2 = 5', 'T', 'F', 'F'),
(17, 21, '3x3 = 6', 'T', 'F', 'F'),
(18, 21, '2x3 = 5', 'F', 'T', 'F'),
(19, 22, '7x4 = 27', 'T', 'F', 'F'),
(20, 22, '8x4 = 32', 'F', 'T', 'T'),
(21, 23, '8/4 = 2', 'F', 'T', 'T'),
(22, 23, '9/1 = 9', 'T', 'F', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `QuizID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Title` varchar(150) NOT NULL,
  `Description` text NOT NULL,
  `Prerequisites` varchar(50) NOT NULL,
  `category` varchar(255) NOT NULL,
  `display_questions` int(11) NOT NULL,
  `Age` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`QuizID`, `UserID`, `Title`, `Description`, `Prerequisites`, `category`, `display_questions`, `Age`) VALUES
(17, 13, 'Simple addition', 'The quiz is made for the beginners to know how to add simple numbers with each other to get the right answer and that will improve your skills to reach the next level   ', '', '+', 6, '4'),
(18, 2, 'Medium Addition', 'In this quiz you will continue upgrading your skills to have better performance in answering the questions in the quizzes.', '', '+', 3, '6'),
(19, 2, 'Simple Subtraction', 'The quiz is made for the beginners to know how to subtract simple numbers with each other to get the right answer and that will improve your skills to reach the higher level. ', '', '-', 3, '4'),
(20, 2, 'Medium Subtraction', 'In this quiz you will continue upgrading your skills to have better performance in answering the questions in the subtraction quizzes.', '', '-', 3, '6'),
(21, 2, 'Simple Multiplication', 'This quiz is made for beginners in multiplication to know how to multiply simple numbers with each other to get the right answer and that will improve their skills to be at a better level.', '', '*', 3, '5'),
(22, 7, 'Medium Multiplication', 'In this quiz you will continue upgrading your skills to have better performance in answering the questions in the quizzes.', '', '*', 3, '6'),
(23, 7, 'Simple Division', 'The quiz is made for the beginners to know how to divide simple numbers with each other to get the right answer and that will improve your skills to reach the next level.', '', '/', 3, '5');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `ID` int(11) NOT NULL,
  `QuizID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`ID`, `QuizID`, `UserID`, `Score`) VALUES
(10, 17, 13, 3),
(21, 18, 2, 2),
(22, 18, 2, 3),
(23, 17, 2, 2),
(24, 19, 2, 2),
(25, 19, 2, 0),
(26, 20, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `SessionID` int(11) NOT NULL,
  `QuizID` int(11) NOT NULL,
  `StartTime` datetime(6) NOT NULL,
  `EndTime` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(20) NOT NULL,
  `Username` varchar(150) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`) VALUES
(2, 'hasan12', 'hasan@hotmail.com', '$2y$10$z9DNM2eidzbcJ7Qoj2s0I.z5zvxkNcH3wzCi0707Dq9G2GqBOSpHO'),
(7, 'moosa', 'moosa200@hotmail.com', '$2y$10$F9QyXo2M6JTZwo6CvUT.7uMBnBINNZtUObt9CcqwdY.bQW8mrvp8a'),
(8, 'moosa12', 'moosa2000@hotmail.com', '$2y$10$OJWgu1i3kntWLQa8gNvak.ILmTWiqHDLyvo.DLSz/FgCVo2goWqfu'),
(9, 'ali', 'ali@hotmail.com', '$2y$10$ohd/5niH/dSNRzoCRuW5a.ghUICKhrSykl6eSd5SVWCTff6.AB7hu'),
(13, 'hasan123', 'h@hotmail.com', '$2y$10$OIlrudAv7QnEdZD9o.q0gOQ.J0FLKa8F9plAqHz6lEjf57DGBPIgS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions1`
--
ALTER TABLE `questions1`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForgenKey` (`quizid`);

--
-- Indexes for table `questions2`
--
ALTER TABLE `questions2`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForgenKey2` (`quizid`);

--
-- Indexes for table `questions3`
--
ALTER TABLE `questions3`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForgenKey3` (`quizid`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`QuizID`),
  ADD UNIQUE KEY `QuizID` (`QuizID`),
  ADD KEY `Quiz&UserID` (`UserID`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Score&User` (`UserID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`SessionID`),
  ADD UNIQUE KEY `SessionID` (`SessionID`),
  ADD KEY `Session&Quiz` (`QuizID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions1`
--
ALTER TABLE `questions1`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `questions2`
--
ALTER TABLE `questions2`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `questions3`
--
ALTER TABLE `questions3`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `QuizID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `SessionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions1`
--
ALTER TABLE `questions1`
  ADD CONSTRAINT `ForgenKey` FOREIGN KEY (`quizid`) REFERENCES `quizzes` (`QuizID`);

--
-- Constraints for table `questions2`
--
ALTER TABLE `questions2`
  ADD CONSTRAINT `ForgenKey2` FOREIGN KEY (`quizid`) REFERENCES `quizzes` (`QuizID`);

--
-- Constraints for table `questions3`
--
ALTER TABLE `questions3`
  ADD CONSTRAINT `ForgenKey3` FOREIGN KEY (`quizid`) REFERENCES `quizzes` (`QuizID`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `Quiz&UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `Session&Quiz` FOREIGN KEY (`QuizID`) REFERENCES `quizzes` (`QuizID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
