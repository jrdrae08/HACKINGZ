-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 06:24 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `majayjaytourist`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `AccountID` int(11) NOT NULL,
  `ApplicationID` int(11) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `FirstLoginRequired` tinyint(1) DEFAULT 1,
  `LastLogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'subadmin',
  `BusinessStatus` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `BusinessArchive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`AccountID`, `ApplicationID`, `Email`, `PasswordHash`, `FirstLoginRequired`, `LastLogin`, `CreatedAt`, `role`, `BusinessStatus`, `BusinessArchive`) VALUES
(38, 65, 'markopornasa99@shurua.xyz', '$2y$10$NyHy.lcH6T5oDR5heLhrcODGdiHLrg2rUbo3MJ2USlKp2ufi7CMFy', 0, '2024-10-03 14:51:46', '2024-10-03 07:27:58', 'subadmin', 'Active', 0),
(39, 77, 'rigordimagiba87@shurua.xyz', '$2y$10$vNJuWjEJXf0Ll3bgrHs9CeeDHKEHmXRlApasIO4D/xH2aaPwCXldK', 0, '2024-10-03 15:39:57', '2024-10-03 10:53:23', 'subadmin', 'Active', 0),
(40, 76, 'pahiyangkanaman87@shurua.xyz', '$2y$10$BuzUte9D1UY8iSWskA5wXOvxOKw1PHopErCCW8XQmDa4Zo1GNrEnO', 0, '2024-10-04 23:09:04', '2024-10-03 13:24:40', 'subadmin', 'Active', 0),
(41, 79, 'mijaysilog@shurua.xyz', '$2y$10$IDz7JK9I9gb3w2sNrO733.jr3dric66frMw/VoEp61RFUKww7DKM2', 0, '2024-10-10 16:25:01', '2024-10-03 14:54:03', 'subadmin', 'Active', 0),
(42, 78, 'jasperbibon@shurua.xyz', '$2y$10$I0jGwS52djnzFfMRTLqXUe0P2xG0uXjvVRkquN2obXeXe8Fd1tXvi', 1, '2024-10-03 15:40:18', '2024-10-03 15:40:18', 'subadmin', 'Active', 0),
(43, 80, 'lenierob@shurua.xyz', '$2y$10$JymhynXoeSn1ltapM1BzLOqeHZe8z/kiOM4EPp.k4Jduce3KcawZ6', 0, '2024-10-04 15:37:13', '2024-10-04 15:34:43', 'subadmin', 'Active', 0),
(44, 81, 'ri55fin3@duckmail.club', '$2y$10$wXLDKRuyj/Df4WM.GLbU4e02noT.BDfsc/yK1Amd1OWwQoIWe1hZa', 0, '2024-10-05 10:44:27', '2024-10-05 10:42:45', 'subadmin', 'Active', 0),
(45, 82, '669ia3yl@duckmail.club', '$2y$10$YCW.UxbRzqZCSeDLS32m7esmhseNJmVTL4ei9xFH7y6R5qsqobxOK', 1, '2024-10-06 08:37:00', '2024-10-06 08:37:00', 'subadmin', 'Active', 0),
(46, 99, 'loretomanalo@shurua.xyz', '$2y$10$I7f0HsM3j1uSt0FsLL9.8exImJf3/W1YC6UYEFGbox.6uSnwrpM6O', 0, '2024-10-09 01:50:43', '2024-10-09 01:49:59', 'subadmin', 'Active', 0),
(47, 100, '4rm9canf@duckmail.club', '$2y$10$B5FmEacry5zCaSbUZ/k/0ui5hC4j9H9eSTorc2r7xRJat3AY9XSS.', 1, '2024-10-10 09:01:10', '2024-10-10 09:01:10', 'subadmin', 'Active', 0),
(48, 104, 'dasehidq@duckmail.club', '$2y$10$GXJ.iy5OR9EoEIcM.KJ5k.ry9Iy9syZ/1J6OnAuLQS8ZebUcKZW/y', 0, '2024-10-10 16:25:05', '2024-10-10 14:34:33', 'subadmin', 'Active', 0),
(49, 106, 'whdw2uyt@duckmail.club', '$2y$10$awvcg.cPz9afG5ZxjdiriOCTVeSFK0Yp7kQYIb8TBk/tCtsnaAKlK', 0, '2024-10-11 10:28:12', '2024-10-11 10:19:27', 'subadmin', 'Active', 0),
(50, 107, 't43l3so0@duckmail.club', '$2y$10$q.Q8PrrboYW09fljhovHkOoh4EAWJYzshKeZhN0LdSQRw1r3dGy2O', 0, '2024-10-14 02:29:50', '2024-10-14 02:28:15', 'subadmin', 'Active', 0),
(51, 108, '4tztcwbj@duckmail.club', '$2y$10$uVWuIih7aic8uJ1VsXQOFepIDH9Hk3o5MXFl/hxWju9qqECu4p.Fq', 0, '2024-10-14 06:03:25', '2024-10-14 05:34:40', 'subadmin', 'Active', 0),
(52, 109, 'iq7eej58@duckmail.club', '$2y$10$96589gBNNcfQTKPoFi1NVOszATQYhm2IvwSoDHxsgVqC.EK.1aAhK', 0, '2024-10-14 08:06:37', '2024-10-14 07:26:15', 'subadmin', 'Inactive', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passcode` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `passcode`, `role`) VALUES
(1, 'majayjaytourist4005@gmail.com', 'majayjayadmin', '$2y$10$EjICfiBXe4iXPjd85sBpVesNSGRfUxcVHhufh4f9J05TZIIpsdVAq', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `businessapplicationform`
--

CREATE TABLE `businessapplicationform` (
  `ApplicationID` int(11) NOT NULL,
  `RegistrantFirstName` varchar(100) NOT NULL,
  `RegistrantMiddleName` varchar(100) DEFAULT NULL,
  `RegistrantLastName` varchar(100) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `BusinessPermitImage` varchar(255) DEFAULT NULL,
  `PermitExpDate` date DEFAULT NULL,
  `IsReject` tinyint(1) DEFAULT 0,
  `RefNum` varchar(12) NOT NULL,
  `IsRead` tinyint(1) DEFAULT 0,
  `isReapply` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `businessapplicationform`
--

INSERT INTO `businessapplicationform` (`ApplicationID`, `RegistrantFirstName`, `RegistrantMiddleName`, `RegistrantLastName`, `ContactNumber`, `Email`, `CreatedAt`, `Status`, `BusinessPermitImage`, `PermitExpDate`, `IsReject`, `RefNum`, `IsRead`, `isReapply`) VALUES
(63, 'Ime', '', 'Villiar', '+633924234623', 'krms5r8i@duckmail.club', '2024-10-03 06:19:56', 'Rejected', '66fe42d833585-photo_6305211990431352169_y.jpg', '2026-01-03', 1, 'REF-66FE378C', 0, 0),
(64, 'John Rev', '', 'Baliton', '+638237642738', 'tura6s6h@duckmail.club', '2024-10-03 07:10:52', 'Rejected', '66fe44527e4d5-PLSP logo.png', '2025-09-03', 1, 'REF-66FE437C', 0, 0),
(65, 'Marko', '', 'Pornasa', '+633684672345', 'markopornasa99@shurua.xyz', '2024-10-03 07:18:03', 'Approved', '66fe476299f21-ITS 2005.png', '2027-09-03', 0, 'REF-66FE452B', 0, 0),
(66, 'Jowell', '', 'Molina', '+632637812361', 'joeillmolinas87@shurua.xyz', '2024-10-03 07:56:02', 'Pending', '66fe55a0bba37-CCST Logo.png', '2027-09-01', 0, 'REF-66FE4E12', 1, 0),
(67, 'Jholiver', '', 'Boctil', '+639023489234', 'jholiverboctiliu890@shurua.xyz', '2024-10-03 09:39:14', 'Pending', '66fe664278988-CCST Logo.png', '2025-10-01', 0, 'REF-66FE6642', 1, 0),
(68, 'Angelo', '', 'Manalo', '+637823467823', 'angelomanalo87872@shurua.xyz', '2024-10-03 09:55:17', 'Pending', '66fe6a05cfc99-CCST Logo.png', '2025-09-03', 0, 'REF-66FE6A05', 1, 0),
(69, 'Erish', '', 'Ibias', '+633926742783', 'erishibias87@shurua.xyz', '2024-10-03 10:00:40', 'Pending', '66fe6b4884080-CCST_Council_Logo (1).png', '2025-01-04', 0, 'REF-66FE6B48', 1, 0),
(70, 'Manila', '', 'Zoo', '+637823467823', 'manilazoo976@shurua.xyz', '2024-10-03 10:06:49', 'Pending', '66fe6cb94a1eb-CCST_Council_Logo (1).png', '2025-01-03', 0, 'REF-66FE6CB9', 1, 0),
(71, 'Karen', '', 'Agapay', '+638236747826', 'karenagayaoi87@shurua.xyz', '2024-10-03 10:08:31', 'Pending', '66fe6d1f02b04-ITS 2005.png', '2025-09-03', 0, 'REF-66FE6D1F', 1, 0),
(72, 'Doglas', '', 'Arthur', '+632364783462', 'doglasarthur87@shurua.xyz', '2024-10-03 10:18:10', 'Pending', '66fe6f626dff1-CCST Logo.png', '2026-12-09', 0, 'REF-66FE6F62', 1, 0),
(73, 'Robin', '', 'Batumbakal', '+633784623784', 'robinbatumbakal87@shurua.xyz', '2024-10-03 10:25:34', 'Pending', '66fe711ebf472-CCST_Council_Logo (1).png', '2025-09-09', 0, 'REF-66FE711E', 1, 0),
(74, 'Robin', '', 'Padilla', '+631287361278', 'robinpadillau76@shurua.xyz', '2024-10-03 10:33:22', 'Pending', '66fe72f2acdaf-PLSP logo.png', '2026-09-09', 0, 'REF-66FE72F2', 1, 0),
(75, 'Makhil', '', 'Sila', '+637891236437', 'makhilsila87@shurua.xyz', '2024-10-03 10:36:31', 'Pending', '66fe73afb6b10-photo_6305211990431352169_y (2).jpg', '2026-09-09', 0, 'REF-66FE73AF', 1, 0),
(76, 'Pahiyang', '', 'Kanaman', '+637823634783', 'pahiyangkanaman87@shurua.xyz', '2024-10-03 10:41:05', 'Approved', '66fe74c1ecc4e-photo_6305211990431352169_y (2).jpg', '2026-09-09', 0, 'REF-66FE74C1', 1, 0),
(77, 'Rigor', '', 'Dimagiba', '+632376487236', 'rigordimagiba87@shurua.xyz', '2024-10-03 10:50:51', 'Approved', '66fe770bcbfb8-photo_6305211990431352169_y (2).jpg', '2026-09-09', 0, 'REF-66FE770B', 1, 0),
(78, 'Jasper', '', 'Bibon', '+633789246327', 'jasperbibon@shurua.xyz', '2024-10-03 14:22:02', 'Approved', '66fea88aa31ed-bgggg.jpg', '2029-09-09', 0, 'REF-66FEA88A', 1, 0),
(79, 'Mijay', '', 'Silog', '+637123642783', 'mijaysilog@shurua.xyz', '2024-10-03 14:38:34', 'Approved', '66feaed53b36a-IS CLUB.png', '2026-01-07', 0, 'REF-66FEAC6A', 1, 0),
(80, 'Lenie', '', 'Rob', '+632387468123', 'lenierob@shurua.xyz', '2024-10-04 15:34:08', 'Approved', '67000af08c0b5-Size Information.png', '2025-09-09', 0, 'REF-67000AF0', 1, 0),
(81, 'Marlou', '', 'Sinag', '+633247474799', 'ri55fin3@duckmail.club', '2024-10-05 10:36:07', 'Approved', '670117c9872b2-Graduation new honors_page-0001.jpg', '2026-09-09', 0, 'REF-67011697', 1, 0),
(82, 'Mang', '', 'Kanor', '+638923745892', '669ia3yl@duckmail.club', '2024-10-06 08:33:49', 'Approved', '67024c15a96c9-pattern vp coco.jpeg', '2025-09-09', 0, 'REF-67024B6D', 1, 0),
(83, 'Whamoz', '', 'Cruz', '+639832749238', 'bomex7yy@duckmail.club', '2024-10-06 08:57:54', 'Pending', '6702511299f97-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-67025112', 1, 0),
(84, 'Lenie', '', 'Robredo', '+639287412893', '6s3w0cmz@duckmail.club', '2024-10-07 15:05:23', 'Pending', '6703f8b3bf731-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-6703F8B3', 1, 0),
(86, 'Kiko', '', 'Pangilinan', '+633248723647', 'vq9ltr4y@duckmail.club', '2024-10-07 15:11:51', 'Pending', '6703fa37d9db6-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-6703FA37', 1, 0),
(87, 'Naruto ', '', 'Shipuden', '+639382748923', 'mxhuhhvb@duckmail.club', '2024-10-07 15:18:47', 'Pending', '6703fbd797030-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-6703FBD7', 1, 0),
(88, 'Manyaman', '', 'Keni', '+638236478326', 'rzdgx54k@duckmail.club', '2024-10-07 15:25:49', 'Pending', '6703fd7d338a8-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-6703FD7D', 1, 0),
(89, 'Json', '', 'Pahirap', '+637892347982', 'lidalihl@duckmail.club', '2024-10-07 15:30:09', 'Pending', '6703fe81b4807-pattern vp coco.jpeg', '2025-09-09', 0, 'REF-6703FE81', 1, 0),
(90, 'Santrix', '', 'Tv', '+633784623784', 'dp2wt4lk@duckmail.club', '2024-10-07 15:50:27', 'Pending', '670403436e26e-pattern vp coco.jpeg', '2025-09-09', 0, 'REF-67040343', 1, 0),
(97, 'Anshe', '', 'Manalo', '+639823745238', 'xplw50cc@duckmail.club', '2024-10-07 16:13:51', 'Pending', '670408bf3a661-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-670408BF', 1, 0),
(98, 'Robin', '', 'Padilla', '+639387452893', 'jiijxxtp@duckmail.club', '2024-10-07 16:25:01', 'Rejected', '67040b5d733b2-pattern vp coco.jpeg', '2025-09-09', 1, 'REF-67040B5D', 1, 0),
(99, 'Loreto', '', 'Manalo', '+638376482374', 'loretomanalo@shurua.xyz', '2024-10-09 01:49:41', 'Approved', '6705e13599ccd-pattern vp coco.jpeg', '2025-09-09', 0, 'REF-6705E135', 1, 0),
(100, 'Aldwin', '', 'Flores', '+637216341278', '4rm9canf@duckmail.club', '2024-10-10 08:51:03', 'Approved', '6707957716db8-pool.jpeg', '2025-09-09', 0, 'REF-67079577', 0, 0),
(101, 'Lauren', '', 'Swelba', '+637823647823', 'lsq9a1zt@duckmail.club', '2024-10-10 09:44:30', 'Rejected', '6707b30875981-pool.jpeg', '2025-09-09', 1, 'REF-6707A1FE', 1, 1),
(102, 'Jasper', '', 'Bibon', '+632387462387', 'jogqlb38@duckmail.club', '2024-10-10 10:58:47', 'Pending', '6707b367a6efd-pattern vp coco.jpeg', '2025-09-09', 0, 'REF-6707B367', 1, 0),
(103, 'Julisa', '', 'Rosales', '+637823647823', 'uueevdrn@duckmail.club', '2024-10-10 11:30:28', 'Pending', '6707d1e7a0c1e-pool.jpeg', '2025-09-09', 0, 'REF-6707BAD4', 1, 1),
(104, 'John Angel', '', 'Locsin', '+637832647823', 'dasehidq@duckmail.club', '2024-10-10 14:34:01', 'Approved', '6707e5d9dba99-CLAMDev (1).png', '2026-09-09', 0, 'REF-6707E5D9', 1, 0),
(105, 'Boy', '', 'Abunda', '+637836427834', 'lp0m1d4f@duckmail.club', '2024-10-10 16:26:57', 'Pending', '67080051d83bc-pool.jpeg', '2026-09-09', 0, 'REF-67080051', 1, 0),
(106, 'Jose', '', 'Lapid', '+632472914789', 'whdw2uyt@duckmail.club', '2024-10-11 10:17:47', 'Approved', '6708fb8cdb501-pattern vp coco.jpeg', '2026-09-09', 0, 'REF-6708FB4B', 1, 1),
(107, 'Jomar ', '', 'Silog', '+637893456347', 't43l3so0@duckmail.club', '2024-10-14 02:27:32', 'Approved', '670c8194701d2-pattern vp coco.jpeg', '2025-09-09', 0, 'REF-670C8194', 1, 0),
(108, 'Jolibog', '', 'Silog', '+633764237423', '4tztcwbj@duckmail.club', '2024-10-14 05:33:47', 'Approved', '670cad3bb5dff-pattern vp coco.jpeg', '2025-01-01', 0, 'REF-670CAD3B', 1, 0),
(109, 'Keny', '', 'Smith', '+639382579278', 'iq7eej58@duckmail.club', '2024-10-14 07:23:04', 'Approved', '670cc77c1d75b-resort-landscape-design.jpg', '2025-01-01', 0, 'REF-670CC6D8', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `businessinformationform`
--

CREATE TABLE `businessinformationform` (
  `BusinessInfoID` int(11) NOT NULL,
  `ApplicationID` int(11) DEFAULT NULL,
  `BusinessName` varchar(100) NOT NULL,
  `BusinessAddress` varchar(255) NOT NULL,
  `BusinessTypeID` int(11) NOT NULL,
  `BusinessEmail` varchar(100) NOT NULL,
  `BusinessContactNumber` varchar(15) NOT NULL,
  `BusinessDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `businessinformationform`
--

INSERT INTO `businessinformationform` (`BusinessInfoID`, `ApplicationID`, `BusinessName`, `BusinessAddress`, `BusinessTypeID`, `BusinessEmail`, `BusinessContactNumber`, `BusinessDescription`) VALUES
(61, 63, 'Ime Villiar Resort', '1212 Street', 19, '', '+637867846237', 'mabago sa resort namin punta na kayo'),
(62, 64, 'John Rev Resort', '1212 Street', 19, '', '+639237497462', 'jhdjkashdjkasdas asdsad'),
(63, 65, 'Pornasa Farm', '1212 Street', 20, '', '+637892364782', 'mabait ako'),
(64, 66, 'Joel Molina Resort', '232 Street', 19, '', '+638923748923', 'jkashdjkasdasdas asdas das'),
(65, 67, 'Jholiver Boctol Resort', '1212 Street', 19, '', '+638263412874', 'ljshdaskjdhas asjkdhaskjda'),
(66, 68, 'Angelo Manalo Resort', '2313 Street', 19, '', '+632387467238', 'kumalma ka '),
(67, 69, 'Erish Resort', '1212 Street', 19, '', '+639823478923', 'ksdjhfskdjfsd'),
(68, 70, 'Mani Zoo Resort', '236125 Street', 19, '', '+637236478236', 'khasdkjasdasd asdas'),
(69, 71, 'Karen Resort', '12321 Streety', 19, '', '+637231647823', 'sdfsadfsadsad'),
(70, 72, 'Doglas Arthur Resort', '123612 Street', 19, '', '+631238746782', 'sdfsdfsdfsd fsdf'),
(71, 73, 'Batumbakal Resort', '2312 Street', 19, '', '+632178637812', 'khsadkjhasdas'),
(72, 74, 'Robin Resort Padilla', '121 Street', 19, '', '+632167351267', 'sdfasdasdas'),
(73, 75, 'Makhil Sila Resort', '2312 Street', 19, '', '+636732874623', 'dfsdfsdfsd'),
(74, 76, 'Pahiyang Kanamn Resort', '123123 Street', 19, '', '+637836478236', 'hkgsadasdasdas'),
(75, 77, 'Rigor Dimagiba Farm', '12312 Street', 20, '', '+631231231231', 'sadasdasd'),
(76, 78, 'Jasper Bibon Resort', '121 Street', 19, '', '+637832647823', 'Wala'),
(77, 79, 'Milog Silog', '76123 Street', 20, '', '+638932467823', 'wala langgg'),
(78, 80, 'Lennie Rob Resort', '1212 Street', 19, '', '+638372467832', 'ksdhfksdjhfsdf'),
(79, 81, 'Marlou Resort', '1212 Street', 19, '', '+639384798237', 'jhjkasdhas jahsdkjashdkajsdh '),
(80, 82, 'Mang Kanor Farm', '1212 Street', 19, '', '+639034839028', 'pa accept po pleaseee'),
(81, 83, 'Whamoz Cruz Resort', '121 Street', 19, '', '+638123672813', 'Whamos Cruizz'),
(82, 84, 'Lenie Resort', '', 19, '', '+634356346436', 'sdfsdrfsdfsdfsdfsd'),
(83, 86, 'Kiko Resort', '', 19, '', '+632335235325', 'adasdsadsa'),
(84, 87, 'Naruto Resort', '', 19, '', '+638372423784', 'sadasdasdas'),
(85, 88, 'Manyaman Resort', '', 19, '', '+633253532532', 'sdfcsdafasfasfasfas'),
(86, 89, 'Lakas Farm', '', 20, '', '+633452353252', 'sdfdsfsdfdsfs'),
(87, 90, 'Santrix Farm', '', 20, '', '+631223124124', 'sdasdsadasdasda'),
(88, 97, 'Anshe Farm', 'Gagalot', 20, '', '+632345235123', 'asdasdsadas asdasdas'),
(89, 98, 'Robin Resort', '121 Pudot, San Roque, Majayjay, Laguna', 19, '', '+632342342343', 'asdasdasdasd'),
(90, 99, 'Loreto Resort', '121 Pudong, San Isidro, Majayjay, Laguna', 19, '', '+634353453453', 'eyy eyy ka muna'),
(91, 100, 'Alwin Resort', '1212 Street, San Miguel (Poblacion), Majayjay, Laguna', 19, '', '+633125235325', 'slag vaue'),
(92, 101, 'Lauren Resort', '12 Pudyawan, Pangil, Majayjay, Laguna', 19, '', '+633564356463', 'dfgdgdfgdfgdfg'),
(93, 102, 'Bibon Resort', '121 Panyawan, San Isidro, Majayjay, Laguna', 19, '', '+636451267451', 'sadasdasdsadasdas'),
(94, 103, 'Julisa Resort', '12312 Street, San Isidro, Majayjay, Laguna', 19, '', '+631343145315', 'hvscacsacas'),
(95, 104, 'Angel Farms', 'Bundok Ibokibok Street, Pook, Majayjay, Laguna', 20, '', '+633456345345', 'asdasdasdasd'),
(96, 105, 'Boy Abunda Resort', '121 Puhod, Talortor, Majayjay, Laguna', 19, '', '+634626436346', 'hi po'),
(97, 106, 'Lito Farm', '121 Street, San Isidro, Majayjay, Laguna', 19, '', '+634379237432', 'kjshdsadsadsad'),
(98, 107, 'Jomar Silog Resort', '212 Street, Santa Catalina (Poblacion), Majayjay, Laguna', 19, '', '+634738564365', 'asdasdasd sadasdas'),
(99, 108, 'Jolibog Resort', '121 Street, Burol, Majayjay, Laguna', 19, '', '+635456456456', 'SHDKAJSHDKAJSDAS'),
(100, 109, 'Keny Resort', '1212 Street, San Isidro, Majayjay, Laguna', 19, '', '+634654654654', 'wala lang');

-- --------------------------------------------------------

--
-- Table structure for table `businesstype`
--

CREATE TABLE `businesstype` (
  `BusinessTypeID` int(11) NOT NULL,
  `TypeName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `businesstype`
--

INSERT INTO `businesstype` (`BusinessTypeID`, `TypeName`) VALUES
(19, 'Resort'),
(20, 'Farm'),
(21, 'Falls');

-- --------------------------------------------------------

--
-- Table structure for table `business_features`
--

CREATE TABLE `business_features` (
  `BusinessFeatureID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `FeatureID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `business_media`
--

CREATE TABLE `business_media` (
  `MediaID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `Thumbnail` varchar(255) NOT NULL,
  `Quotation` text NOT NULL,
  `Image1` varchar(255) NOT NULL,
  `Image2` varchar(255) NOT NULL,
  `Image3` varchar(255) NOT NULL,
  `Image4` varchar(255) NOT NULL,
  `Image5` varchar(255) NOT NULL,
  `Image6` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `business_media`
--

INSERT INTO `business_media` (`MediaID`, `BusinessInfoID`, `Thumbnail`, `Quotation`, `Image1`, `Image2`, `Image3`, `Image4`, `Image5`, `Image6`) VALUES
(11, 79, '6705dce2c8c57.jpg', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...&#34;', '6705bf2b5ffe6.png', '6705bf2cb8b26.png', '6705bf2dd461a.png', '6705bf2e21783.png', '6705bf2e727b9.png', '6705bf2e876c7.png'),
(12, 90, '6705e1f9868bb.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam bibendum sit amet libero non volutpat. Mauris pretium dignissim porta. Vestibulum aliquet imperdiet enim, hendrerit placerat metus mattis vel. Aenean luctus.', '6705e1f9b5b3c.jpeg', '6705e1f9c8279.jpeg', '6705e1f9d7c95.jpeg', '6705e1f9e46d2.jpeg', '6705e1f9f3807.jpeg', '6705e1fa0c5a6.jpeg'),
(13, 95, '6707e7d07b75e.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin finibus sollicitudin eros sit amet egestas. Curabitur ut dolor quis sapien condimentum gravida tincidunt ac elit.', '6707e7d117d37.jpg', '6707e7d14bcd2.jpg', '6707e7d179e8c.jpg', '6707e7d19e96b.jpg', '6707e7d1bc494.jpg', '6707e7d1d5cbe.jpg'),
(14, 97, '6708feb04f2eb.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ante lobortis, sodales arcu eget, eleifend velit. Aenean congue suscipit orci, vitae vestibulum sapien rutrum et. Integer eleifend hendrerit urna.', '6708ff5a04a61.jpg', '6708feb09e392.jpg', '6708feb0c0f62.jpg', '6708feb0ed0dd.jpg', '6708feb121d45.jpg', '6708feb13f48f.jpg'),
(17, 100, '670cc8922c0d3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam elementum dictum tempus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque at egestas risus, in gravida.', '670cc89251d14.jpeg', '670cc89263f30.jpg', '670cc89277fe9.jpg', '670cc8927e56b.jpeg', '670cc8927fd94.jpg', '670cc892dc25f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `FeatureID` int(11) NOT NULL,
  `FeatureName` varchar(100) NOT NULL,
  `IsActive` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `frontpagecontent`
--

CREATE TABLE `frontpagecontent` (
  `frontpageid` int(11) NOT NULL,
  `description` text NOT NULL,
  `slider_image_1` varchar(255) NOT NULL,
  `slider_title_1` varchar(255) NOT NULL,
  `slider_content_1` text NOT NULL,
  `slider_image_2` varchar(255) NOT NULL,
  `slider_title_2` varchar(255) NOT NULL,
  `slider_content_2` text NOT NULL,
  `slider_image_3` varchar(255) NOT NULL,
  `slider_title_3` varchar(255) NOT NULL,
  `slider_content_3` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `frontpagecontent`
--

INSERT INTO `frontpagecontent` (`frontpageid`, `description`, `slider_image_1`, `slider_title_1`, `slider_content_1`, `slider_image_2`, `slider_title_2`, `slider_content_2`, `slider_image_3`, `slider_title_3`, `slider_content_3`, `created_at`) VALUES
(1, 'Majayjay, Laguna is a charming rural town nestled at the foot of Mt. Banahaw, renowned for its stunning natural beauty, including the iconic Taytay Falls. With its cool climate, historical churches, and lush greenery, Majayjay offers a tranquil retreat for the nature lovers and those seeking a peaceful, scenic haha.', 'IMG_20241003_224046.jpg', 'Where to Stay', 'For a comfortable stay in Majayjay, Laguna, choose from cozy homestays, charming cottages, resorts, offering scenic views and easy access to attractions like Taytay Falls.', 'landscape-view-of-the-warm-relax-swimming-pool-with-tropical-trees-in-modern-design-resort-with-moody-weather-time-video.jpg', 'Where to Go', 'In Majayjay, Laguna, visit Taytay Falls, hike lush forests, explore St. Gregory the Great Church, serene rivers, offering a perfect mix of adventure and history.', 'Futura-Thumbnail.jpg', 'Where to Eat', 'In Majayjay, Laguna, enjoy local cuisine at roadside eateries, cozy cafes, and old restaurants serving Filipino dishes, and regional delicacies in a charming setting.', '2024-07-31 04:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `revID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `regadd` varchar(255) NOT NULL,
  `regemail` varchar(255) NOT NULL,
  `regnum` varchar(20) NOT NULL,
  `numadult` int(11) NOT NULL,
  `numchild` int(11) NOT NULL,
  `nummale` int(11) NOT NULL,
  `numfemale` int(11) NOT NULL,
  `thiscity` int(11) NOT NULL DEFAULT 0,
  `othercity` int(11) NOT NULL DEFAULT 0,
  `otherprovince` int(11) NOT NULL DEFAULT 0,
  `foreigncountry` int(11) NOT NULL DEFAULT 0,
  `checkin` date NOT NULL,
  `departure` date NOT NULL,
  `referenceNum` varchar(10) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `status` enum('Pending','Accepted','Ongoing') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`revID`, `roomID`, `fullname`, `regadd`, `regemail`, `regnum`, `numadult`, `numchild`, `nummale`, `numfemale`, `thiscity`, `othercity`, `otherprovince`, `foreigncountry`, `checkin`, `departure`, `referenceNum`, `datetime`, `status`) VALUES
(31, 52, 'Jopay Kanaba', '121 Street', 'w3vuocte@duckmail.club', '09758647651', 1, 0, 1, 0, 1, 0, 0, 0, '2024-11-07', '2024-11-08', 'REF-R078VG', '2024-10-14 00:16:53', 'Accepted'),
(32, 58, 'John Rev Baliton', '1212 Street', 'u7kn44w2@duckmail.club', '09568759852', 5, 0, 3, 2, 2, 1, 1, 1, '2024-10-15', '2024-10-16', 'REF-2URWXU', '2024-10-14 15:38:25', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roominfotable`
--

CREATE TABLE `roominfotable` (
  `roomID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `roomName` varchar(255) NOT NULL,
  `roomPrice` decimal(10,2) NOT NULL,
  `adultMax` int(11) NOT NULL,
  `ChildrenMax` int(11) NOT NULL,
  `RoomDescriptions` text NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `image5` varchar(255) DEFAULT NULL,
  `image6` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roominfotable`
--

INSERT INTO `roominfotable` (`roomID`, `BusinessInfoID`, `roomName`, `roomPrice`, `adultMax`, `ChildrenMax`, `RoomDescriptions`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`) VALUES
(43, 90, 'John Rev kubo', '12.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet non risus quis elementum. Aenean imperdiet commodo ante, vitae pretium ligula convallis vitae. Nullam gravida, lorem id aliquam congue, est lacus pulvinar elit, at tincidunt eros massa in urna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac.', '../../businessowner/roomImages/Loreto Resort/John Rev kubo/pool_6705fb5e41642.jpeg', '../../businessowner/roomImages/Loreto Resort/John Rev kubo/pool_6705fb5edcae5.jpeg', '../../businessowner/roomImages/Loreto Resort/John Rev kubo/pool_6705fb5f610c4.jpeg', '../../businessowner/roomImages/Loreto Resort/John Rev kubo/pool_6705fb5fe168e.jpeg', '../../businessowner/roomImages/Loreto Resort/John Rev kubo/pool_6705fb6076c8c.jpeg', '../../businessowner/roomImages/Loreto Resort/John Rev kubo/pool_6705fb6102d8b.jpeg'),
(44, 79, 'Bunot na Dahon', '6000.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc facilisis elit non ex ullamcorper ultrices. Sed pulvinar ex in interdum ultricies. Sed at porta tellus. Etiam commodo posuere mollis. Duis accumsan interdum leo eget porta. Aliquam hendrerit libero auctor lorem egestas malesuada. Donec ullamcorper luctus accumsan. Praesent consequat lacus blandit.', '../../businessowner/roomImages/Marlou Resort/Bunot na Dahon/we-do-creative-films-WT6ug4AzKUo-unsplash_67078c7311570.jpg', '../../businessowner/roomImages/Marlou Resort/Bunot na Dahon/zoshua-colah-LZiErjGyaYQ-unsplash_67078c7424abf.jpg', '../../businessowner/roomImages/Marlou Resort/Bunot na Dahon/zoshua-colah-MPCcoBQkVyg-unsplash_67078c74d1619.jpg', '../../businessowner/roomImages/Marlou Resort/Bunot na Dahon/zoshua-colah-OBW7Ag4Da-4-unsplash_67078c7594431.jpg', '../../businessowner/roomImages/Marlou Resort/Bunot na Dahon/zoshua-colah-XE4TRyh4g7k-unsplash_67078c763d6f2.jpg', NULL),
(45, 95, 'Farm Pool', '12000.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas consectetur elit sed erat semper, sit amet vulputate est facilisis. Duis porta dui vitae odio fermentum, sit amet egestas nulla imperdiet. Praesent leo nibh, mattis vel orci eget, volutpat suscipit dui. Ut eget elit commodo, dignissim lorem ut, volutpat orci. Praesent.', '../../businessowner/roomImages/Angel Farms/Farm Pool/we-do-creative-films-WT6ug4AzKUo-unsplash_6707f7ddb51c1.jpg', '../../businessowner/roomImages/Angel Farms/Farm Pool/zoshua-colah-LZiErjGyaYQ-unsplash_6707f7de6d1e9.jpg', '../../businessowner/roomImages/Angel Farms/Farm Pool/zoshua-colah-MPCcoBQkVyg-unsplash_6707f7df18485.jpg', '../../businessowner/roomImages/Angel Farms/Farm Pool/zoshua-colah-OBW7Ag4Da-4-unsplash_6707f7dfbcd0f.jpg', '../../businessowner/roomImages/Angel Farms/Farm Pool/zoshua-colah-XE4TRyh4g7k-unsplash_6707f7e079ad6.jpg', '../../businessowner/roomImages/Angel Farms/Farm Pool/we-do-creative-films-WT6ug4AzKUo-unsplash_6707f7e13b099.jpg'),
(50, 95, 'Vista de Laiya', '3500.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas consectetur elit sed erat semper, sit amet vulputate est facilisis. Duis porta dui vitae odio fermentum, sit amet egestas nulla imperdiet. Praesent leo nibh, mattis vel orci eget, volutpat suscipit dui. Ut eget elit commodo, dignissim lorem ut, volutpat orci. Praesent.', '../../businessowner/roomImages/Angel Farms/Vista de Laiya/pool_670859ccb3c34.jpeg', '../../businessowner/roomImages/Angel Farms/Vista de Laiya/pool_670859cd50d8d.jpeg', '../../businessowner/roomImages/Angel Farms/Vista de Laiya/pool_670859cdc18cf.jpeg', '../../businessowner/roomImages/Angel Farms/Vista de Laiya/pool_670859ce52246.jpeg', '../../businessowner/roomImages/Angel Farms/Vista de Laiya/pool_670859cebd6ad.jpeg', '../../businessowner/roomImages/Angel Farms/Vista de Laiya/pool_670859cf50464.jpeg'),
(51, 97, 'Crispy Pata', '100000.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec finibus sapien ac est auctor euismod non eget quam. Nunc dictum tristique erat, sed sollicitudin urna consequat in. Sed eu placerat dui. Cras vel porttitor tortor. Pellentesque at odio eget risus malesuada condimentum eget id lacus. Suspendisse nisi elit, mattis quis.', '../../businessowner/roomImages/Lito Farm/Crispy Pata/we-do-creative-films-WT6ug4AzKUo-unsplash_6708ff9d173ef.jpg', '../../businessowner/roomImages/Lito Farm/Crispy Pata/zoshua-colah-LZiErjGyaYQ-unsplash_6708ff9da1e4d.jpg', '../../businessowner/roomImages/Lito Farm/Crispy Pata/zoshua-colah-MPCcoBQkVyg-unsplash_6708ff9e2d448.jpg', '../../businessowner/roomImages/Lito Farm/Crispy Pata/zoshua-colah-OBW7Ag4Da-4-unsplash_6708ff9ebce04.jpg', '../../businessowner/roomImages/Lito Farm/Crispy Pata/zoshua-colah-XE4TRyh4g7k-unsplash_6708ff9f809b6.jpg', '../../businessowner/roomImages/Lito Farm/Crispy Pata/zoshua-colah-LZiErjGyaYQ-unsplash_6708ffa0388c1.jpg'),
(52, 97, 'Casa de Playa', '12000.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pretium nunc massa, vel blandit ex gravida vel. Duis sollicitudin sodales ante vel lobortis. Quisque eget quam scelerisque, tempor nisl et, dictum ex. Suspendisse eget magna nunc. Nunc placerat felis nec lacus dictum, at condimentum sapien venenatis. Nam malesuada libero id.', '../../businessowner/roomImages/Lito Farm/Casa de Playa/pool_6709e93d42f5f.jpeg', '../../businessowner/roomImages/Lito Farm/Casa de Playa/pool_6709e93dbd654.jpeg', NULL, NULL, NULL, NULL),
(55, 97, 'Silog', '120.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis faucibus faucibus libero, a maximus nulla aliquet et. Suspendisse potenti. Quisque nec tellus quis nisi ultrices ullamcorper. Proin quis sem commodo mauris fermentum porta vel in metus. Nunc lectus lorem, eleifend vitae augue ut, pretium ornare lacus. Sed vel rhoncus dui.', '../../businessowner/roomImages/Lito Farm/Silog/pool_6709fcf2f2822.jpeg', '../../businessowner/roomImages/Lito Farm/Silog/pool_6709fcf391317.jpeg', NULL, NULL, NULL, NULL),
(56, 97, 'Lirins', '1.00', 12, 12, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis faucibus faucibus libero, a maximus nulla aliquet et. Suspendisse potenti. Quisque nec tellus quis nisi ultrices ullamcorper. Proin quis sem commodo mauris fermentum porta vel in metus. Nunc lectus lorem, eleifend vitae augue ut, pretium ornare lacus. Sed vel rhoncus dui.', '../../businessowner/roomImages/Lito Farm/Lirins/pool_6709fd2cbfe90.jpeg', NULL, NULL, NULL, NULL, NULL),
(58, 100, 'Delluxx', '5000.00', 8, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mattis, odio quis fermentum ultrices, purus lectus lobortis augue, in ultricies sem ex sit amet purus. Suspendisse vitae pharetra nisl. Etiam molestie tortor massa. Morbi sed luctus lacus. Nulla facilisi. Nam iaculis et mi ac finibus. Sed a semper mauris, a.', '../../businessowner/roomImages/Keny Resort/Delluxx/IMG_20241003_223935_670cc94f7c5cb.jpg', '../../businessowner/roomImages/Keny Resort/Delluxx/IMG_20241003_224155_670cc94ff2be3.jpg', '../../businessowner/roomImages/Keny Resort/Delluxx/landscape-view-of-a-pristine-resort-golf-course-bathed-in-the-glow-of-perfect-weather-ai-generated-photo_670cc9505ebf1.jpg', '../../businessowner/roomImages/Keny Resort/Delluxx/Cover_authentic-conversations-with-travelers-help-kingsmill-resort-drive-conversion-and-deliver-higher-revenue_670cc95155e1e.jpg', '../../businessowner/roomImages/Keny Resort/Delluxx/resort-landscape-design_670cc98a55428.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `FacilityID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `FacilityName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`FacilityID`, `BusinessInfoID`, `FacilityName`) VALUES
(10, 74, 'Pool');

-- --------------------------------------------------------

--
-- Table structure for table `room_facility_connections`
--

CREATE TABLE `room_facility_connections` (
  `ConnectionID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subadmin`
--

CREATE TABLE `subadmin` (
  `SubAdminID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `RoleID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`AccountID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `ApplicationID` (`ApplicationID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `businessapplicationform`
--
ALTER TABLE `businessapplicationform`
  ADD PRIMARY KEY (`ApplicationID`);

--
-- Indexes for table `businessinformationform`
--
ALTER TABLE `businessinformationform`
  ADD PRIMARY KEY (`BusinessInfoID`),
  ADD KEY `ApplicationID` (`ApplicationID`),
  ADD KEY `BusinessTypeID` (`BusinessTypeID`);

--
-- Indexes for table `businesstype`
--
ALTER TABLE `businesstype`
  ADD PRIMARY KEY (`BusinessTypeID`);

--
-- Indexes for table `business_features`
--
ALTER TABLE `business_features`
  ADD PRIMARY KEY (`BusinessFeatureID`),
  ADD KEY `FeatureID` (`FeatureID`),
  ADD KEY `fk_businessinfoid` (`BusinessInfoID`);

--
-- Indexes for table `business_media`
--
ALTER TABLE `business_media`
  ADD PRIMARY KEY (`MediaID`),
  ADD KEY `BusinessInfoID` (`BusinessInfoID`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`FeatureID`),
  ADD UNIQUE KEY `FeatureName` (`FeatureName`);

--
-- Indexes for table `frontpagecontent`
--
ALTER TABLE `frontpagecontent`
  ADD PRIMARY KEY (`frontpageid`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`revID`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `roominfotable`
--
ALTER TABLE `roominfotable`
  ADD PRIMARY KEY (`roomID`),
  ADD KEY `BusinessInfoID` (`BusinessInfoID`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`FacilityID`),
  ADD KEY `BusinessInfoID` (`BusinessInfoID`);

--
-- Indexes for table `room_facility_connections`
--
ALTER TABLE `room_facility_connections`
  ADD PRIMARY KEY (`ConnectionID`),
  ADD KEY `roomID` (`roomID`),
  ADD KEY `FacilityID` (`FacilityID`);

--
-- Indexes for table `subadmin`
--
ALTER TABLE `subadmin`
  ADD PRIMARY KEY (`SubAdminID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `businessapplicationform`
--
ALTER TABLE `businessapplicationform`
  MODIFY `ApplicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `businessinformationform`
--
ALTER TABLE `businessinformationform`
  MODIFY `BusinessInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `businesstype`
--
ALTER TABLE `businesstype`
  MODIFY `BusinessTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `business_features`
--
ALTER TABLE `business_features`
  MODIFY `BusinessFeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `business_media`
--
ALTER TABLE `business_media`
  MODIFY `MediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `FeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `frontpagecontent`
--
ALTER TABLE `frontpagecontent`
  MODIFY `frontpageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `revID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roominfotable`
--
ALTER TABLE `roominfotable`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `FacilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `room_facility_connections`
--
ALTER TABLE `room_facility_connections`
  MODIFY `ConnectionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `subadmin`
--
ALTER TABLE `subadmin`
  MODIFY `SubAdminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`ApplicationID`) REFERENCES `businessapplicationform` (`ApplicationID`);

--
-- Constraints for table `businessinformationform`
--
ALTER TABLE `businessinformationform`
  ADD CONSTRAINT `businessinformationform_ibfk_1` FOREIGN KEY (`ApplicationID`) REFERENCES `businessapplicationform` (`ApplicationID`),
  ADD CONSTRAINT `businessinformationform_ibfk_2` FOREIGN KEY (`BusinessTypeID`) REFERENCES `businesstype` (`BusinessTypeID`);

--
-- Constraints for table `business_features`
--
ALTER TABLE `business_features`
  ADD CONSTRAINT `business_features_ibfk_1` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`),
  ADD CONSTRAINT `business_features_ibfk_2` FOREIGN KEY (`FeatureID`) REFERENCES `features` (`FeatureID`),
  ADD CONSTRAINT `fk_businessinfoid` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`);

--
-- Constraints for table `business_media`
--
ALTER TABLE `business_media`
  ADD CONSTRAINT `business_media_ibfk_1` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`roomID`) REFERENCES `roominfotable` (`roomID`);

--
-- Constraints for table `roominfotable`
--
ALTER TABLE `roominfotable`
  ADD CONSTRAINT `roominfotable_ibfk_1` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`) ON DELETE CASCADE;

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `room_facilities_ibfk_1` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`);

--
-- Constraints for table `room_facility_connections`
--
ALTER TABLE `room_facility_connections`
  ADD CONSTRAINT `room_facility_connections_ibfk_1` FOREIGN KEY (`roomID`) REFERENCES `roominfotable` (`roomID`),
  ADD CONSTRAINT `room_facility_connections_ibfk_2` FOREIGN KEY (`FacilityID`) REFERENCES `room_facilities` (`FacilityID`);

--
-- Constraints for table `subadmin`
--
ALTER TABLE `subadmin`
  ADD CONSTRAINT `subadmin_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `admin` (`id`),
  ADD CONSTRAINT `subadmin_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
