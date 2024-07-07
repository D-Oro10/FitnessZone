-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 03:59 PM
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
-- Database: `dba_gym`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `new_procedure` (IN `MemberID` INT)   BEGIN
    DECLARE PaymentStatus VARCHAR(15);
    DECLARE FeeInterval VARCHAR(10);
    DECLARE due_date DATE;

    SELECT PaymentStatus, FeeInterval INTO PaymentStatus, FeeInterval
    FROM Members
    WHERE MemberID = MemberID;

    IF PaymentStatus = 'Paid' THEN
        IF FeeInterval = 'Monthly' THEN
            SET due_date = DATE_ADD(NOW(), INTERVAL 1 MONTH);
        ELSEIF FeeInterval = '3 Months' THEN
            SET due_date = DATE_ADD(NOW(), INTERVAL 3 MONTH);
        ELSEIF FeeInterval = 'Annually' THEN
            SET due_date = DATE_ADD(NOW(), INTERVAL 1 YEAR);
        END IF;
        
        UPDATE Members
        SET due_date = due_date
        WHERE MemberID = MemberID;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checkduplicate` (IN `in_MemberID` INT(5), `in_ClassID` VARCHAR(5), `in_CoachID` INT(5), `in_Schedule` DATE)   BEGIN
   DECLARE appointment_count INT;
    
    -- Check if the appointment already exists
    SELECT COUNT(*) INTO appointment_count
    FROM appointment
    WHERE MemberID = in_MemberID 
        AND ClassID = in_ClassID
        AND CoachID = in_CoachID
        AND Schedule = in_Schedule;
        
    IF appointment_count > 0 THEN
        SELECT 'Appointment already exists' AS Message;
    ELSE
		INSERT INTO appointment (MemberID, ClassID, CoachID, Schedule)
        VALUES (in_MemberID, in_ClassID, in_CoachID, in_Schedule);
        SELECT 'Appointment set successfully' AS Message;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateDues` (IN `MemberIDParam` INT)   BEGIN
    DECLARE PaymentStatus VARCHAR(15);
    DECLARE FeeInterval VARCHAR(10);
    DECLARE duedate DATE;

    -- Fetch PaymentStatus and FeeInterval for the given MemberID
    SELECT PaymentStatus, FeeInterval INTO @PaymentStatus, @FeeInterval
    FROM Members
    WHERE MemberID = MemberIDParam;

    -- Check if PaymentStatus is 'Paid' and calculate due_date accordingly
    IF PaymentStatus = 'Paid' THEN
        IF FeeInterval = 'Monthly' THEN
            SET duedate = DATE_ADD(NOW(), INTERVAL 1 MONTH);
        ELSEIF FeeInterval = '3 Months' THEN
            SET duedate = DATE_ADD(NOW(), INTERVAL 3 MONTH);
        ELSEIF FeeInterval = 'Annual' THEN
            SET duedate = DATE_ADD(NOW(), INTERVAL 1 YEAR);
        END IF;
        
        -- Update due_date for the corresponding MemberID
        UPDATE Members
        SET due_date = duedate
        WHERE MemberID = MemberIDParam;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Username` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Username`, `Name`, `password`) VALUES
('[dha', 'darryl', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `AppointmentID` int(5) NOT NULL,
  `MemberID` int(5) NOT NULL,
  `ClassID` varchar(5) NOT NULL,
  `CoachID` int(5) NOT NULL,
  `Schedule` date NOT NULL,
  `ClassDay` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`AppointmentID`, `MemberID`, `ClassID`, `CoachID`, `Schedule`, `ClassDay`) VALUES
(1031, 1, 'MB1', 5002, '2024-02-20', ''),
(1032, 2, 'HIC1', 5003, '2024-02-21', ''),
(1033, 4, 'CD2', 5004, '2024-02-14', ''),
(1034, 5, 'CD2', 5003, '2024-03-02', ''),
(1035, 3, 'HIC1', 5004, '2024-02-20', ''),
(1036, 4, 'SC3', 5001, '2024-02-18', ''),
(1037, 5, 'SC3', 5001, '2024-02-18', ''),
(1038, 2, 'DD1', 5003, '2024-02-21', ''),
(1039, 1, 'DD1', 5003, '2024-02-21', ''),
(1040, 9, 'MB1', 5002, '2024-02-23', ''),
(1041, 10, 'SC3', 5001, '2024-02-18', ''),
(1042, 21, 'SC3', 5001, '2024-02-18', ''),
(1043, 18, 'CC1', 5004, '2024-02-20', ''),
(1044, 15, 'SC3', 5001, '2024-02-18', ''),
(1045, 12, 'SC3', 5001, '2024-02-18', ''),
(1046, 19, 'MB1', 5002, '2024-02-23', ''),
(1047, 24, 'CD2', 5004, '2024-02-14', ''),
(1048, 1, 'MB1', 5003, '2024-02-20', ''),
(1049, 20, 'CD2', 5004, '2024-02-25', ''),
(1050, 2, 'CD2', 5001, '2024-02-13', ''),
(1051, 1, 'CD2', 5001, '2024-02-13', ''),
(1056, 12, 'HIC1', 5002, '2024-07-18', ''),
(1057, 12, 'HIC1', 5002, '2024-07-18', '');

--
-- Triggers `appointment`
--
DELIMITER $$
CREATE TRIGGER `appointment_AFTER_DELETE` AFTER DELETE ON `appointment` FOR EACH ROW BEGIN
    DELETE FROM attendance
    WHERE AppointmentID = OLD.AppointmentID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AppointmentID` int(5) NOT NULL,
  `AttendanceCode` char(5) NOT NULL,
  `MemberID` int(5) NOT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AppointmentID`, `AttendanceCode`, `MemberID`, `Date`) VALUES
(1031, 'Y', 1, '2024-02-13'),
(1032, 'Y', 2, '2024-02-21'),
(1033, 'Y', 4, '2024-02-14'),
(1034, 'Y', 5, '2024-03-02'),
(1057, 'Y', 12, '2024-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `ClassID` char(10) NOT NULL,
  `ClassName` varchar(45) DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `ClassDay` varchar(15) NOT NULL,
  `CoachName` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`ClassID`, `ClassName`, `Duration`, `ClassDay`, `CoachName`) VALUES
('DD1', 'Weightlifting', 168, 'Wednesday, Frid', NULL),
('SC3', 'Strength and Conditioning Class', 168, 'Sched', NULL),
('TA1', 'Taekwondo', 2, 'Saturday', NULL),
('TA1', 'Taekwondo', 2, 'Sunday', NULL),
('TA1', 'Taekwondo', 2, 'Thursday', NULL),
('TA1', 'Taekwondo', 2, 'Tuesday', NULL),
('ZU1', 'Zumba Class', 2, 'Friday', NULL),
('ZU1', 'Zumba Class', 2, 'Monday', NULL),
('ZU1', 'Zumba Class', 2, 'Wednesday', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `CoachID` int(11) DEFAULT NULL,
  `CoachName` text DEFAULT NULL,
  `Nickname` text DEFAULT NULL,
  `BIrthDate` text DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `FBlink` text DEFAULT NULL,
  `ContactNo` bigint(20) DEFAULT NULL,
  `Weight` double DEFAULT NULL,
  `Height` int(11) DEFAULT NULL,
  `Status` text DEFAULT NULL,
  `Spouse` text DEFAULT NULL,
  `SContactNo` text DEFAULT NULL,
  `ContactPerson` text DEFAULT NULL,
  `CPContactNo` bigint(20) DEFAULT NULL,
  `RTC` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`CoachID`, `CoachName`, `Nickname`, `BIrthDate`, `Address`, `FBlink`, `ContactNo`, `Weight`, `Height`, `Status`, `Spouse`, `SContactNo`, `ContactPerson`, `CPContactNo`, `RTC`) VALUES
(5002, 'Abby Lorenzo', 'Abby', '2001-01-21', '987 Circumferential Rd., Antipolo City', 'https://www.facebook.com/123Abby', 9357888902, 68, 170, 'Single', '', '', 'Gina Lorenzo', 9573819383, 'Father'),
(5003, 'Darren Cruz', 'Da', '1999-05-19', '321 Cabrera Rd., Taytay City', 'https://www.facebook.com/darrencruz', 9428593723, 90.7, 178, 'Married', 'Fe Cruz', '9347829992', 'Fe Cruz', 9347829992, 'Wife'),
(5004, 'Aaron Santos', 'Ron', '1999-04-20', '987 JP Rizal St., Angono', 'https://www.facebook.com/43aaron', 9576898664, 72.6, 175, 'Married', 'Angel Cruz', '9475882212', 'Angel Cruz', 9475882212, 'Wife'),
(5005, 'Miguel Gonzaga', 'Migs', '1993-11-10', '789 Garden Heights, Marikina', 'https://www.facebook.com/migsgon143', 9683758555, 68.5, 169, 'Married', 'Rose Gonzaga', '9485727521', 'Rose Gonzaga', 9485727521, 'Wife');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `MemberID` int(5) NOT NULL,
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`MemberID`, `UserName`, `Password`) VALUES
(11, 'dha', '$2y$10$bHYgpB06W2QUyVvkGtV/CuNTn6LYGe0XJ9mB14hgLOdKhoImibCy.');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `MemberID` int(5) NOT NULL,
  `MemberName` varchar(50) DEFAULT NULL,
  `ContactNo` varchar(11) DEFAULT NULL,
  `Address` varchar(80) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
  `PostCode` varchar(4) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `EContactPerson` varchar(50) DEFAULT NULL,
  `EContactNo` varchar(11) DEFAULT NULL,
  `RTC` varchar(20) DEFAULT NULL,
  `MembershipCode` char(1) DEFAULT NULL,
  `FeeInterval` varchar(10) DEFAULT NULL,
  `MembershipDate` date DEFAULT NULL,
  `PaymentStatus` varchar(15) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `activation_til` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`MemberID`, `MemberName`, `ContactNo`, `Address`, `City`, `PostCode`, `Birthdate`, `Email`, `EContactPerson`, `EContactNo`, `RTC`, `MembershipCode`, `FeeInterval`, `MembershipDate`, `PaymentStatus`, `due_date`, `activation_til`) VALUES
(1, 'Benjie Thompson', '9123459742', '456 Marcos Highway', 'Antipolo', '1870', '2003-10-10', '', 'Olivia Thompson', '9189227831', 'Wife', 'M', 'Annual', '2021-09-11', 'Paid', '2024-09-11', '2025-09-11'),
(2, 'Ethan Martinez', '9839427024', '789 Garden Heights', 'Marikina', '1810', '2000-07-03', '', 'Sophia Martinez', '9111667987', 'Wife', 'M', 'Monthly', '2022-01-21', 'Unpaid', '2024-03-21', '2025-01-21'),
(3, 'Adrian Santos', '9777623411', '987 Meralco Ave', 'Marikina', '1810', '2001-05-16', '', 'Lyn Santos', '9991280236', 'Mother', 'S', 'Monthly', '2022-05-05', 'Unpaid', '2024-03-17', '2026-05-05'),
(4, 'John Bernardo', '9111898561', '789 Manila East Rd.', 'Taytay', '1920', '2000-04-20', '', 'Kath Bernardo', '9345411632', 'Wife', 'M', '3 Months', '2023-10-10', 'Unpaid', '2024-05-26', '2024-10-10'),
(5, 'Darwin Garcia', '9772219011', '876 Dela Paz St.', 'Antipolo', '1870', '2004-05-15', '', 'Hazel Garcia', '9999568210', 'Mother', 'S', 'Annual', '2023-02-14', 'unpaid', '2025-02-14', '2025-02-14'),
(6, 'Mike Dela Cruz', '9662123458', '654 Sumulong Park', 'Antipolo', '1870', '2004-06-23', '', 'Matthew Cruz', '9462628901', 'Father', 'S', '3 Months', '2021-06-06', 'unpaid', '2024-06-06', '2028-06-06'),
(7, 'Rosa Reyes', '9555527890', '987 JP Rizal St.', 'Angono', '1930', '1999-02-14', '', 'Carlos Reyes', '9123987890', 'Husband', 'M', '3 Months', '2021-05-16', 'unpaid', '2024-05-15', '2028-05-16'),
(8, 'Sofia Ramirez', '9190543823', '321 Cabrera Rd.', 'Taytay', '1920', '1996-09-10', '', 'Sandro Rarmirez', '9190072349', 'Husband', 'M', 'Monthly', '2022-01-19', 'Unpaid', '2024-04-19', '2026-01-19'),
(9, 'Luiz Dela Cruz', '9447878324', '987 Circumferential Rd.', 'Antipolo', '1870', '2000-11-20', '', 'Luisa Dela Cruz', '9243189034', 'Mother', 'M', 'Annual', '2022-10-21', 'unpaid', '2024-10-21', '2025-10-25'),
(10, 'Maria Santos', '9675837543', '654 Sumulong Park', 'Antipolo', '1870', '2004-05-07', '', 'Mario Santos', '9432190243', 'Father', 'S', '3 Months', '2023-09-22', 'unpaid', '2024-11-22', '2024-09-22'),
(11, 'Francesca Marcos', '09476839293', 'Sition Malanim', 'Antipolo', '1870', '2024-02-02', 'darryljhan76@gmail.com', 'gfgdf  dgdfdgf', '09284768432', 'Husband', 'S', 'Monthly', '2024-02-14', 'unpaid', '2024-05-14', '2026-02-14'),
(12, 'Darwin A Cornejo', '09223343243', 'Sitio Malanim', 'Antipolo', '1870', '1999-01-11', 'darwin@gmail.com', 'Rona  Cornejo', '09284768431', 'Mother', 'S', 'Daily', '2024-07-06', 'unpaid', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `MembershipCode` char(5) DEFAULT NULL,
  `MembershipType` char(10) DEFAULT NULL,
  `MembershipFee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`MembershipCode`, `MembershipType`, `MembershipFee`) VALUES
('S', 'Student', 500),
('M', 'Member', 500);

-- --------------------------------------------------------

--
-- Table structure for table `member_cycle`
--

CREATE TABLE `member_cycle` (
  `MemberID` int(5) NOT NULL,
  `MembershipCode` char(5) DEFAULT NULL,
  `FeeInterval` varchar(10) DEFAULT NULL,
  `ResubmitCycle_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(5) NOT NULL,
  `MemberID` int(5) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `PaymentAmount` int(11) DEFAULT NULL,
  `PaymentMode` char(10) DEFAULT NULL,
  `PaymentStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `MemberID`, `PaymentDate`, `PaymentAmount`, `PaymentMode`, `PaymentStatus`) VALUES
(1, 11, '2024-02-14', 1500, 'cash', 'unpaid'),
(2, 12, '2024-07-24', 3000, 'cash', 'unpaid'),
(3, 10, '2024-07-30', 1000, 'cash', 'unpaid'),
(4, 9, '2024-09-24', 1500, 'cash', 'unpaid'),
(7, 12, '2024-07-24', 3000, 'cash', 'unpaid'),
(10, 10, '2024-07-30', 1000, 'cash', 'unpaid'),
(12, 9, '2024-07-06', 1500, 'cash', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `pending_payment`
--

CREATE TABLE `pending_payment` (
  `Pay_DueID` int(5) NOT NULL,
  `MemberID` int(5) DEFAULT NULL,
  `MembershipType` char(5) DEFAULT NULL,
  `FeeInterval` char(10) DEFAULT NULL,
  `PaymentAmount` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `MembershipCode` text DEFAULT NULL,
  `FeeInterval` text DEFAULT NULL,
  `GymFee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`MembershipCode`, `FeeInterval`, `GymFee`) VALUES
('S', 'Daily', 80),
('S', 'Monthly', 1000),
('S', '3 Months', 2500),
('S', 'Annual', 8200),
('M', 'Daily', 110),
('M', 'Monthly', 1250),
('M', '3 Months', 3000),
('M ', 'Annual ', 9500);

-- --------------------------------------------------------

--
-- Table structure for table `registered`
--

CREATE TABLE `registered` (
  `MemberID` int(5) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered`
--

INSERT INTO `registered` (`MemberID`, `uname`, `password`) VALUES
(11, 'abcd', 'fitnessZon3'),
(12, 'Darwin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `MemberID` int(5) NOT NULL,
  `MemberName` varchar(50) DEFAULT NULL,
  `ContactNo` varchar(15) DEFAULT NULL,
  `Email` varchar(25) DEFAULT NULL,
  `Address` varchar(80) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
  `PostCode` varchar(4) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `EContactPerson` varchar(50) DEFAULT NULL,
  `EContactNo` varchar(11) DEFAULT NULL,
  `RTC` varchar(20) DEFAULT NULL,
  `MembershipCode` char(1) DEFAULT NULL,
  `FeeInterval` varchar(10) DEFAULT NULL,
  `MemberShipDate` date DEFAULT NULL,
  `PaymentStatus` varchar(15) DEFAULT 'unpaid',
  `UserName` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `SchedID` int(11) NOT NULL,
  `ClassID` varchar(50) NOT NULL,
  `SchedDate` date DEFAULT NULL,
  `CoachID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`SchedID`, `ClassID`, `SchedDate`, `CoachID`) VALUES
(14, 'PB1', '2024-02-13', NULL),
(15, 'PB1', '2024-02-13', NULL),
(16, 'TA1', '2024-02-13', NULL),
(17, 'TA1', '2024-02-13', NULL),
(18, 'TA1', '2024-02-13', NULL),
(19, 'TA1', '2024-02-13', NULL),
(20, 'ZU1', '2024-02-13', NULL),
(21, 'ZU1', '2024-02-13', NULL),
(22, 'ZU1', '2024-02-13', NULL),
(29, 'PB1', '2024-02-13', NULL),
(30, 'PB1', '2024-02-13', NULL),
(31, 'TA1', '2024-02-13', NULL),
(32, 'TA1', '2024-02-13', NULL),
(33, 'TA1', '2024-02-13', NULL),
(34, 'TA1', '2024-02-13', NULL),
(35, 'ZU1', '2024-02-13', NULL),
(36, 'ZU1', '2024-02-13', NULL),
(37, 'ZU1', '2024-02-13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AppointmentID`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`ClassID`,`ClassDay`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `member_cycle`
--
ALTER TABLE `member_cycle`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`);

--
-- Indexes for table `pending_payment`
--
ALTER TABLE `pending_payment`
  ADD PRIMARY KEY (`Pay_DueID`);

--
-- Indexes for table `registered`
--
ALTER TABLE `registered`
  ADD UNIQUE KEY `MemberID` (`MemberID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`MemberID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`SchedID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `AppointmentID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1059;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `MemberID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pending_payment`
--
ALTER TABLE `pending_payment`
  MODIFY `Pay_DueID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `MemberID` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `FK_attendance_appointment` FOREIGN KEY (`AppointmentID`) REFERENCES `appointment` (`AppointmentID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
