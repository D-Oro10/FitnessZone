/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  Cheska-PC
 * Created: Jan 12, 2024
 */

-- Create a database if it doesn't exist
CREATE DATABASE IF NOT EXISTS dba_gym;

-- Use the created database
USE dba_gym;

-- Create the members table
CREATE TABLE IF NOT EXISTS members (
    MemberID INT(5) AUTO_INCREMENT PRIMARY KEY,
    MemberName varchar(50),
    ContactNo varchar(15),
    Email varchar(100),
    Address varchar(80),
    City varchar(30),
    PostCode varchar(4),
    Birthdate date,
    EContactPerson varchar(50),
    EContactNo varchar(11),
    RTC varchar(20),
    MembershipCode char(1),
    FeeInterval varchar(10),
    MemberShipDate date,
    PaymentStatus varchar(15),
    due_date DATE
);


CREATE TABLE IF NOT EXISTS request (
    MemberID INT(5) AUTO_INCREMENT PRIMARY KEY,
    MemberName varchar(50),
    ContactNo varchar(15),
    Email varchar(25),
    Address varchar(80),
    City varchar(30),
    PostCode varchar(4),
    Birthdate date,
    EContactPerson varchar(50),
    EContactNo varchar(11),
    RTC varchar(20),
    MembershipCode char(1),
    FeeInterval varchar(10),
    MemberShipDate date,
    PaymentStatus varchar(15) DEFAULT 'unpaid',
    UserName VARCHAR(50),
    Password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS login (
    MemberID INT(5) PRIMARY KEY,
    UserName VARCHAR(50),
    Password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS payment(
    PaymentID INT(5) AUTO_INCREMENT PRIMARY KEY,
    MemberID INT(5),
    PaymentDate DATE,
    PaymentAmount INT,
    PaymentMode CHAR(10)
);

CREATE TABLE IF NOT EXISTS pending_payment(
    Pay_DueID INT(5) AUTO_INCREMENT PRIMARY KEY,
    MemberID INT(5),
    MembershipType CHAR(5),
    FeeInterval CHAR(10),
    PaymentAmount INT,
    due_date DATE
);

CREATE TABLE IF NOT EXISTS member_cycle(
    MemberID INT(5) PRIMARY KEY,
    MembershipCode CHAR(5),
    FeeInterval VARCHAR (10),
    ResubmitCycle_Date DATE
);

CREATE TABLE IF NOT EXIST membership (
    MembershipCode CHAR(5),
    MembershipType CHAR(10),
    MembershipFee INT
);

CREATE TABLE IF NOT EXIST Schedule ( 
    SchedID INT PRIMARY KEY, 
    ClassID VARCHAR(50) NOT NULL, 
    SchedDate DATE,    
    CoachID INT 
);

CREATE TABLE classes (
    ClassID CHAR(10),
    ClassName VARCHAR(45),
    Duration INT,
    ClassDay VARCHAR(15),
    PRIMARY KEY (ClassID, ClassDay)
);

INSERT INTO classes (ClassID, ClassName, Duration, ClassDay)
VALUES 
('MB1', 'Mind And Body Class', 120, 'Sched'),
('HIC1', 'Hiit Class', 50, 'Sched'),
('CC1', 'Cycling', 30, 'Sched'),
('CD2', 'Cardio', 72, 'Sched'),
('SC3', 'Strength and Conditioning Class', 168, 'Sched'),
('DD1', 'Dance', 72, 'Sched'),
('ZU1', 'Zumba Class', 2, 'Monday'),
('ZU1', 'Zumba Class', 2, 'Wednesday'),
('ZU1', 'Zumba Class', 2, 'Friday'),
('PB1', 'Pre_Ballet Class', 1, 'Wednesday'),
('PB1', 'Pre_Ballet Class', 1, 'Saturday'),
('TA1', 'Taekwondo', 2, 'Tuesday'),
('TA1', 'Taekwondo', 2, 'Thursday'),
('TA1', 'Taekwondo', 2, 'Saturday'),
('TA1', 'Taekwondo', 2, 'Sunday');


CREATE TABLE IF NOT EXIST appointment (
    AppointmentID INT AUTO_INCREMENT PRIMARY KEY,
    MemberID INT,
    ClassID INT,
    CoachID INT,
    Schedule DATE,
    ClassDay VARCHAR(15)
);

CREATE TABLE IF NOT EXIST schedule (
    SchedID INT UTO_INCREMENT PRIMARY KEY,
    ClassID INT,
    SchedDate DATE,
    CoachID INT;
);

CREATE TABLE attendance(
    AppointmentID INT PRIMARY KEY,
    AttendanceCode CHAR(5),
    MemberID INT,
    Date DATE
);

CREATE TRIGGER deleteRequest
AFTER INSERT ON request
FOR EACH ROW
BEGIN
    IF TIMESTAMPDIFF(HOUR, NEW.MemberShipDate, NOW()) >= 48 THEN
        DELETE FROM request WHERE MemberID = NEW.MemberID;
    END IF;
END;


SELECT MemberName, ClassName, CoachName, AttendanceCode
FROM members m JOIN appointment a ON m.MemberID = a.MemberID 
JOIN classes c ON a.ClassID = c.ClassID 
JOIN coach ch ON ch.CoachID = a.CoachID 
JOIN attendance att ON att.AppointmentID = a.AppointmentID;