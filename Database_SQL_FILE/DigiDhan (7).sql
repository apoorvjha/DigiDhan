-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2020 at 01:32 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DigiDhan`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `Bank_Account_Number` varchar(20) NOT NULL,
  `Balance` float NOT NULL,
  `Account_Type` varchar(10) NOT NULL,
  `IFSC` varchar(100) NOT NULL,
  `Current_Cheque_Number` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`Bank_Account_Number`, `Balance`, `Account_Type`, `IFSC`, `Current_Cheque_Number`) VALUES
('0', 1000000000, 'current', 'DDID0000001', 2),
('1111231210234512', 40000, 'savings', 'SBID0132222', 236);

-- --------------------------------------------------------

--
-- Table structure for table `activation`
--

CREATE TABLE `activation` (
  `User_Mail` varchar(100) NOT NULL,
  `Activation_Link` varchar(300) NOT NULL,
  `Bank_Name` varchar(100) NOT NULL,
  `Response` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activation`
--

INSERT INTO `activation` (`User_Mail`, `Activation_Link`, `Bank_Name`, `Response`) VALUES
('akash@gmail.com', 'localhost:8080/signature/activate.php?mail=akash@gmail.com&acc=1234567890123455', 'Bank of India', 1),
('anil@gmail.com', 'localhost:8080/signature/activate.php?mail=anil@gmail.com&acc=0123456789011111', 'Bank of India', 1),
('lemar@gmail.com', 'localhost:8080/signature/activate.php?mail=lemar@gmail.com&acc=0101010101010101', 'State Bank of India', 0);

-- --------------------------------------------------------

--
-- Table structure for table `card_request`
--

CREATE TABLE `card_request` (
  `User_Id` int(11) NOT NULL,
  `Card_Type` varchar(15) NOT NULL,
  `Embossing_Name` varchar(50) NOT NULL,
  `P_Address` varchar(100) NOT NULL,
  `M_Address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `Name` varchar(50) NOT NULL,
  `Permanent_Address` varchar(200) NOT NULL,
  `Mailing_Address` varchar(200) NOT NULL,
  `Email_Address` varchar(50) NOT NULL,
  `Education_Level` varchar(20) NOT NULL,
  `Education_Stream` varchar(20) NOT NULL,
  `Percentage_Marks` float NOT NULL,
  `Resume` varchar(200) NOT NULL,
  `DOB` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `career`
--

INSERT INTO `career` (`Name`, `Permanent_Address`, `Mailing_Address`, `Email_Address`, `Education_Level`, `Education_Stream`, `Percentage_Marks`, `Resume`, `DOB`) VALUES
('kaushal', 'ADA colony', 'ADA colony', 'kaushal@gmail.com', 'bachlor', 'Engineering', 67, 'RESUME/kaushal@gmail.com.pdf', '1998-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `User_Id` int(11) NOT NULL,
  `Message` longtext NOT NULL,
  `To_User` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Read_Message` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`User_Id`, `Message`, `To_User`, `Timestamp`, `Read_Message`) VALUES
(3, 'hello!', 9, '2020-03-05 03:28:56', 0),
(9, 'hello', 3, '2020-03-05 03:30:49', 0),
(9, 'hi', 1, '2020-03-05 04:09:11', 1),
(9, ',ds', 1, '2020-03-05 04:09:16', 1),
(9, 'hello', 3, '2020-03-12 20:20:43', 0),
(3, 'hi\n', 9, '2020-03-12 20:21:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Signature_Dataset`
--

CREATE TABLE `Signature_Dataset` (
  `Bank_Account_Number` bigint(20) NOT NULL,
  `Location` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Signature_Dataset`
--

INSERT INTO `Signature_Dataset` (`Bank_Account_Number`, `Location`) VALUES
(0, 'SIGNATURE_PIC/01.jpg'),
(0, 'SIGNATURE_PIC/02.jpg'),
(0, 'SIGNATURE_PIC/03.jpg'),
(0, 'SIGNATURE_PIC/04.jpg'),
(0, 'SIGNATURE_PIC/05.jpg'),
(0, 'SIGNATURE_PIC/06.jpg'),
(0, 'SIGNATURE_PIC/07.jpg'),
(0, 'SIGNATURE_PIC/08.jpg'),
(0, 'SIGNATURE_PIC/09.jpg'),
(0, 'SIGNATURE_PIC/010.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345121.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345122.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345123.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345124.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345125.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345126.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345127.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345128.jpg'),
(1111231210234512, 'SIGNATURE_PIC/11112312102345129.jpg'),
(1111231210234512, 'SIGNATURE_PIC/111123121023451210.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `To_Bank_Account_Number` bigint(20) NOT NULL,
  `From_Bank_Account_Number` bigint(20) NOT NULL,
  `Amount` float NOT NULL,
  `mode` varchar(10) NOT NULL,
  `Transaction_Id` int(11) NOT NULL,
  `Current_Cheque_Number` int(11) NOT NULL,
  `Date_Of_Transaction` date NOT NULL,
  `Signature` varchar(200) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`To_Bank_Account_Number`, `From_Bank_Account_Number`, `Amount`, `mode`, `Transaction_Id`, `Current_Cheque_Number`, `Date_Of_Transaction`, `Signature`, `Status`) VALUES
(1111231210234512, 0, 10000, 'ONLINE', 5, 1, '2020-03-27', 'TRANSACTION_PIC/01.jpeg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_Id` int(11) NOT NULL,
  `User_Active_Status` int(1) NOT NULL DEFAULT '0',
  `User_Mail` varchar(100) NOT NULL,
  `User_Name` varchar(50) NOT NULL,
  `User_Password` varchar(50) NOT NULL,
  `User_Profile` varchar(400) NOT NULL,
  `User_Type` varchar(10) NOT NULL,
  `Bank_Name` varchar(50) NOT NULL,
  `Bank_Account_Number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_Id`, `User_Active_Status`, `User_Mail`, `User_Name`, `User_Password`, `User_Profile`, `User_Type`, `Bank_Name`, `Bank_Account_Number`) VALUES
(1, 0, 'ganesh@gmail.com', 'Goku', 'Ganesh@123', 'PROFILE_PIC//Ganesh.jpg', 'user', 'Bank of India', '9981101010234512'),
(3, 1, 'akscrown26@gmail.com', 'Arjun', 'Arjun@123', 'PROFILE_PIC//Arjun.jpeg', 'admin', 'State Bank of India', '1111231210234512'),
(9, 1, 'otbsinfra@gmail.com', 'DigiDhan', 'DigiDhan@123', 'SUPPORT_PIC/anonymous.png', 'super', 'DigiDhan', '0'),
(10, 0, 'lemar@gmail.com', 'Lemar', 'Lemar@123', 'PROFILE_PIC/Lemar.png', 'user', 'State Bank of India', '101010101010101'),
(11, 0, 'anil@gmail.com', 'Anil', 'Anil@123', 'PROFILE_PIC/Anil.png', 'user', 'State Bank of India', '1111231210234657'),
(12, 0, 'garima@yahoo.com', 'Garima', 'Garima@123', 'PROFILE_PIC/Garima.jpeg', 'user', 'Bank of India', '2222222201234567'),
(13, 0, 'john@gmail.com', 'John', 'John@123', 'PROFILE_PIC/John.jpeg', 'user', 'Bank of India', '2222222201234521');

-- --------------------------------------------------------

--
-- Table structure for table `ventures`
--

CREATE TABLE `ventures` (
  `Bank_Name` varchar(50) NOT NULL,
  `Venture_Id` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Bank_Logo` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ventures`
--

INSERT INTO `ventures` (`Bank_Name`, `Venture_Id`, `Email`, `Bank_Logo`) VALUES
('Bank of India', 1, 'akash@boi.com', 'VENTURES_PIC/Bank of India.png'),
('State Bank of India', 2, 'arjun11@sbi.com', 'VENTURES_PIC/State Bank of India.png'),
('DigiDhan', 3, 'otbsinfra@gmail.com', 'VENTURES_PIC/DigiDhan.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`Bank_Account_Number`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_Id`);

--
-- Indexes for table `ventures`
--
ALTER TABLE `ventures`
  ADD PRIMARY KEY (`Venture_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Transaction_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ventures`
--
ALTER TABLE `ventures`
  MODIFY `Venture_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
