-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 01:56 PM
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
  `BusinessArchive` tinyint(1) NOT NULL DEFAULT 0,
  `qr_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`AccountID`, `ApplicationID`, `Email`, `PasswordHash`, `FirstLoginRequired`, `LastLogin`, `CreatedAt`, `role`, `BusinessStatus`, `BusinessArchive`, `qr_code`) VALUES
(134, 185, 'karlokatigbak@shurua.xyz', '$2y$10$q3BVfMYBY/2sHuB10teL7uAxfqw7ajIAyNw1K1goJM3.S40T4Mhbi', 0, '2025-01-10 14:27:51', '2025-01-10 14:27:16', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67812e4549128.png'),
(135, 186, 'karloskatigbak@shurua.xyz', '$2y$10$t9yKg4J90hDg3sVnsj0hM.yur1o3JY2GMzSmVQeJqPcEtlkISfn8u', 0, '2025-01-11 10:52:53', '2025-01-11 10:51:58', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67824d5001265.png'),
(136, 187, 'eaanives04@gmail.com', '$2y$10$/YQZ20rrNuMYrqw8I6gXCu9CBCtfref2cEHEdsymMlQd8NFGNeih6', 0, '2025-01-13 06:40:50', '2025-01-13 06:38:30', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6784b4e9c966c.png');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `passcode`, `role`) VALUES
(1, 'majayjaytourist4005@gmail.com', 'majayjayadmin', '$2y$10$EjICfiBXe4iXPjd85sBpVesNSGRfUxcVHhufh4f9J05TZIIpsdVAq', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_accounts`
--

CREATE TABLE `barangay_accounts` (
  `barangayId` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `establishment` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `qr_code` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `BusinessTypeID` int(11) NOT NULL DEFAULT 21
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bownerdemographics`
--

CREATE TABLE `bownerdemographics` (
  `bOwnerId` int(11) NOT NULL,
  `ApplicationID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalnumAttendees` int(11) NOT NULL,
  `totalmale` int(11) NOT NULL,
  `totalfemale` int(11) NOT NULL,
  `thisCity` int(11) NOT NULL,
  `otherCity` int(11) NOT NULL,
  `otherProvince` int(11) NOT NULL,
  `foreignCountry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `newPermitDate` date DEFAULT NULL,
  `IsReject` tinyint(1) DEFAULT 0,
  `RefNum` varchar(12) NOT NULL,
  `IsRead` tinyint(1) DEFAULT 0,
  `isReapply` tinyint(4) DEFAULT 0,
  `ReminderSent` tinyint(1) DEFAULT 0,
  `isRenew` tinyint(1) DEFAULT 0,
  `reuploadDate` date DEFAULT NULL,
  `renewalReject` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `businessapplicationform`
--

INSERT INTO `businessapplicationform` (`ApplicationID`, `RegistrantFirstName`, `RegistrantMiddleName`, `RegistrantLastName`, `ContactNumber`, `Email`, `CreatedAt`, `Status`, `BusinessPermitImage`, `PermitExpDate`, `newPermitDate`, `IsReject`, `RefNum`, `IsRead`, `isReapply`, `ReminderSent`, `isRenew`, `reuploadDate`, `renewalReject`) VALUES
(186, 'Karlos', '', 'Katigbak', '+631278961273', 'karloskatigbak@shurua.xyz', '2025-01-11 10:51:37', 'Approved', '67824d394fa32-20250111.webp', '2025-12-31', NULL, 0, 'REF-67824D39', 1, 0, 0, 0, NULL, 0),
(187, 'John', '', 'Doe', '+639999999999', 'eaanives04@gmail.com', '2025-01-13 06:33:25', 'Approved', '6784b3b585cf6-20250113.webp', '2025-12-31', NULL, 0, 'REF-6784B3B5', 1, 0, 0, 0, NULL, 0),
(188, 'Marlou', '', 'Gabi', '+637346233784', 'marlougabi@shurua.xyz', '2025-01-14 02:09:58', 'Pending', '6785d1bde5bc5-20250114.webp', '2025-12-31', NULL, 0, 'REF-6785C776', 0, 1, 0, 0, NULL, 0),
(189, 'Malibu', '', 'Nights', '+639237648237', 'malibunights@shurua.xyz', '2025-01-14 02:52:23', 'Rejected', '6785d166eec95-20250114.webp', '2025-12-31', NULL, 1, 'REF-6785D167', 1, 0, 0, 0, NULL, 0),
(190, 'Kalapati', '', 'Manalo', '+630924791287', 'kalapatimanalo@shurua.xyz', '2025-01-14 02:56:43', 'Pending', '6785d2a76fd51-20250114.webp', '2025-12-31', NULL, 0, 'REF-6785D26B', 0, 1, 0, 0, NULL, 0),
(191, 'Patria', '', 'Manalo', '+639890908234', 'patriamanalo@shurua.xyz', '2025-01-14 03:02:44', 'Rejected', '6785d3d45d581-20250114.webp', '2025-12-31', NULL, 1, 'REF-6785D3D4', 0, 0, 0, 0, NULL, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `businessinformationform`
--

INSERT INTO `businessinformationform` (`BusinessInfoID`, `ApplicationID`, `BusinessName`, `BusinessAddress`, `BusinessTypeID`, `BusinessEmail`, `BusinessContactNumber`, `BusinessDescription`) VALUES
(177, 186, 'Karlos Resort', '121 Street, Balayong, Majayjay, Laguna', 19, '', '+634563634633', 'dfgdfgdfg dfgdfgdfg dfgdfgfdgdf dfgdf d'),
(178, 187, 'Last', 'Ex. Street, Barangay, Municipality/City, Province, Coralao, Majayjay, Laguna', 19, '', '+639999999999', 'Qwerty uiop asdfgh jkl zxcv bnm'),
(179, 188, 'Marlouga Kaba', '121 Street, Ibabang Bayucain, Majayjay, Laguna', 19, 'marluha98@shurua.xyz', '+636123123937', 'aba naman matulog ka naman hahahah '),
(180, 189, 'MalibuNights Resort', '1212 Street, Bitaoy, Majayjay, Laguna', 19, '', '+638273897243', 'kasndasdjk haskjdha kjshdajskh dkasjhdajskd hjkasdas'),
(181, 190, 'Kalapati Resort', '121 Street, Banti, Majayjay, Laguna', 19, '', '+632235125151', 'sadasdsadas'),
(182, 191, 'Patricia Manalo Resort', '112 Street, Coralao, Majayjay, Laguna', 19, '', '+633784627846', 'dsdgfdsfs dfsd fs');

-- --------------------------------------------------------

--
-- Table structure for table `businesstype`
--

CREATE TABLE `businesstype` (
  `BusinessTypeID` int(11) NOT NULL,
  `TypeName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `FeatureID` int(11) NOT NULL,
  `IsActive` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_features`
--

INSERT INTO `business_features` (`BusinessFeatureID`, `BusinessInfoID`, `FeatureID`, `IsActive`) VALUES
(103, 177, 114, 1),
(104, 178, 115, 1),
(105, 178, 116, 1),
(106, 178, 117, 1),
(107, 178, 118, 1);

-- --------------------------------------------------------

--
-- Table structure for table `business_media`
--

CREATE TABLE `business_media` (
  `MediaID` int(11) NOT NULL,
  `BusinessInfoID` int(11) DEFAULT NULL,
  `Thumbnail` varchar(255) NOT NULL,
  `Quotation` text NOT NULL,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) DEFAULT NULL,
  `Image3` varchar(255) DEFAULT NULL,
  `Image4` varchar(255) DEFAULT NULL,
  `Image5` varchar(255) DEFAULT NULL,
  `Image6` varchar(255) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `barangayId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_media`
--

INSERT INTO `business_media` (`MediaID`, `BusinessInfoID`, `Thumbnail`, `Quotation`, `Image1`, `Image2`, `Image3`, `Image4`, `Image5`, `Image6`, `isActive`, `barangayId`) VALUES
(69, 177, '6782740e04dca.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis pharetra tellus, et accumsan felis. Duis non efficitur risus. Pellentesque vel eros metus. Ut ultrices nisl sed consectetur auctor. Quisque.', '6782740e8a060.webp', '6782740f0b276.webp', '6782740f96381.webp', '6782741017e20.webp', '6782741087c88.webp', '6782741108727.webp', 1, NULL),
(70, 178, '6784b7de93051.webp', 'Come and visit this beautiful place!', '6784b7dec3aaa.webp', '6784b7deefb70.webp', '6784b7df347fb.webp', '6784b7df81bf1.webp', '6784b7dfc1340.webp', '6784b7e05145d.webp', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `demographics`
--

CREATE TABLE `demographics` (
  `demogId` int(11) NOT NULL,
  `barangayId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalnumAttendees` int(11) NOT NULL,
  `totalmale` int(11) NOT NULL,
  `totalfemale` int(11) NOT NULL,
  `thisCity` int(11) NOT NULL,
  `otherCity` int(11) NOT NULL,
  `otherProvince` int(11) NOT NULL,
  `foreignCountry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `FeatureID` int(11) NOT NULL,
  `FeatureName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`FeatureID`, `FeatureName`) VALUES
(115, 'Air conditioned room'),
(114, 'Aircon'),
(117, 'Pool'),
(118, 'Restaurant'),
(116, 'Wifi');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frontpagecontent`
--

INSERT INTO `frontpagecontent` (`frontpageid`, `description`, `slider_image_1`, `slider_title_1`, `slider_content_1`, `slider_image_2`, `slider_title_2`, `slider_content_2`, `slider_image_3`, `slider_title_3`, `slider_content_3`, `created_at`) VALUES
(1, 'Majayjay, Laguna is a charming rural town nestled at the foot of Mt. Banahaw, renowned for its stunning natural beauty, including the iconic Taytay Falls. With its cool climate, historical churches, and lush greenery, Majayjay offers a tranquil retreat for the nature lovers and those seeking a peaceful.', '678066eabcf1f-20250110.webp', 'Where to Stay', 'For a comfortable stay in Majayjay, Laguna, choose from cozy homestays, charming cottages, resorts, offering scenic views and easy access to attractions like Taytay Falls.', '678066ead04df-20250110.webp', 'Where to Go', 'In Majayjay, Laguna, visit Taytay Falls, hike lush forests, explore St. Gregory the Great Church, serene rivers, offering a perfect mix of adventure and history.', '678066eb18ec3-20250110.webp', 'Where to Eat', 'In Majayjay, Laguna, enjoy local cuisine at roadside eateries, cozy cafes, and old restaurants serving Filipino dishes, and regional delicacies in a charming setting.', '2024-07-31 04:05:16');

-- --------------------------------------------------------

--
-- Table structure for table `highlights`
--

CREATE TABLE `highlights` (
  `HighlightID` int(11) NOT NULL,
  `HighlightName` varchar(100) NOT NULL,
  `BarangayID` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `paymentMethodID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`paymentMethodID`, `roomID`, `amount`) VALUES
(37, 23, 500.00),
(40, 30, 0.00),
(42, 27, 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `qcashpayment`
--

CREATE TABLE `qcashpayment` (
  `bgcashID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `bgcashnum` varchar(50) NOT NULL,
  `bgcashname` varchar(100) NOT NULL,
  `bgcashQrImage` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qcashpayment`
--

INSERT INTO `qcashpayment` (`bgcashID`, `BusinessInfoID`, `bgcashnum`, `bgcashname`, `bgcashQrImage`) VALUES
(31, 177, '09504074109', 'Jordan', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363738323836336131613264352e706e67),
(32, 178, '09065417074', 'EJ*Y A.', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363738346238333239643036332e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `revID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `regadd` varchar(255) NOT NULL,
  `regemail` varchar(255) NOT NULL,
  `regnum` varchar(20) NOT NULL,
  `checkin` date NOT NULL,
  `departure` date NOT NULL,
  `referenceNum` varchar(10) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `status` enum('Pending','Accepted','Ongoing','Rejected','Canceled','Completed') NOT NULL DEFAULT 'Pending',
  `reasonCancel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`revID`, `roomID`, `userID`, `fullname`, `regadd`, `regemail`, `regnum`, `checkin`, `departure`, `referenceNum`, `datetime`, `status`, `reasonCancel`) VALUES
(184, 28, 72, 'John Doe', '123 St., Brgy. Barangay, Municipality City, Province province', 'eaanives04@gmail.com', '+639065417074', '2025-01-14', '2025-01-15', 'REF-OIG4SU', '2025-01-13 11:52:55', '', '...'),
(186, 28, 72, 'John Doe', '123 St., Brgy. Barangay, Municipality City, Province province', 'eaanives04@gmail.com', '+639065417074', '2025-01-17', '2025-01-18', 'REF-HF0KQ9', '2025-01-13 11:55:27', '', '😅'),
(187, 27, 72, 'John Doe', '123 St., Brgy. Barangay, Municipality City, Province province', 'eaanives04@gmail.com', '+639065417074', '2025-01-21', '2025-01-22', 'REF-XTB5J8', '2025-01-13 18:26:16', 'Canceled', 'Reservation has been canceled due to a delay in arrival.'),
(193, 27, 74, 'Jordan Rae Marabe', '21323 Street', 'jordanraemarabe@shurua.xyz', '+639812738912', '2025-01-23', '2025-01-24', 'REF-ZFEDNW', '2025-01-14 17:51:28', 'Canceled', 'Reservation has been canceled due to a delay in arrival.'),
(197, 27, 86, 'Jose Manalo', 'Jose', 'lasixe7819@nalwan.com', '+631221121212', '2025-02-11', '2025-02-12', 'REF-ZE4HBQ', '2025-01-14 20:44:39', 'Canceled', 'Reservation has been canceled due to a delay in arrival.');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_payments`
--

CREATE TABLE `reservation_payments` (
  `paymentID` int(11) NOT NULL,
  `revID` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `image6` varchar(255) DEFAULT NULL,
  `timeStart` time DEFAULT NULL,
  `timeEnd` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roominfotable`
--

INSERT INTO `roominfotable` (`roomID`, `BusinessInfoID`, `roomName`, `roomPrice`, `adultMax`, `ChildrenMax`, `RoomDescriptions`, `image1`, `image2`, `image3`, `image4`, `image5`, `image6`, `timeStart`, `timeEnd`) VALUES
(27, 177, 'Deluxi', 500.00, 1, 1, '* askndasdasasdasas\r\n* asdsa\r\n* dasdas\r\n* dasdsa\r\n* dasd\r\n* asasdasd', '../../businessowner/roomImages/Karlos Resort/Deluxi/1_67848123a2eb0.webp', '../../businessowner/roomImages/Karlos Resort/Deluxi/2_6784812489f52.webp', '../../businessowner/roomImages/Karlos Resort/Deluxi/3_6784812592384.webp', NULL, NULL, NULL, '13:00:00', '02:00:00'),
(28, 177, 'Room 1 Delux', 7000.00, 122, 1, '* aSDasAS\r\n* sdfsdf\r\n* sdvsdv', '../../businessowner/roomImages/Karlos Resort/Room 1 Delux/1_67848dc12710a.webp', '../../businessowner/roomImages/Karlos Resort/Room 1 Delux/2_67848dc1e744d.webp', '../../businessowner/roomImages/Karlos Resort/Room 1 Delux/6_67848dc2bb3c4.webp', NULL, NULL, NULL, '23:54:00', '01:53:00'),
(29, 178, 'X1', 1200.00, 4, 1, '* No littering', '../../businessowner/roomImages/Last/X1/antoninaA_6784b698be9c7.webp', '../../businessowner/roomImages/Last/X1/antoninaB_6784b698ce10b.webp', '../../businessowner/roomImages/Last/X1/AntoninaC_6784b698d17d9.webp', '../../businessowner/roomImages/Last/X1/AntoninaD_6784b6b881019.webp', NULL, NULL, '14:00:00', '12:00:00'),
(30, 178, 'X2', 1500.00, 5, 3, '* No Smoking', '../../businessowner/roomImages/Last/X2/VillaJulitaA_6784b8b5a1aa2.webp', '../../businessowner/roomImages/Last/X2/VillaJulitaB_6784b8b5b2cb0.webp', '../../businessowner/roomImages/Last/X2/VillaJulitaC_6784b8b5bb834.webp', NULL, NULL, NULL, '14:00:00', '12:00:00'),
(31, 178, 'X\'3', 1800.00, 6, 2, '* No Fighting', '../../businessowner/roomImages/Last/X3/villasophiaA_6784b952421c7.webp', '../../businessowner/roomImages/Last/X3/villasophiab_6784b95250656.webp', '../../businessowner/roomImages/Last/X3/villasophiac_6784b95255548.webp', NULL, NULL, NULL, '14:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `FacilityID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `FacilityName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`FacilityID`, `BusinessInfoID`, `FacilityName`) VALUES
(49, 177, 'Aircon'),
(50, 177, 'Free wifi'),
(51, 178, 'Restaurant'),
(52, 178, 'Pool'),
(53, 178, 'Aircon room');

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities_mapping`
--

CREATE TABLE `room_facilities_mapping` (
  `roomID` int(11) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities_mapping`
--

INSERT INTO `room_facilities_mapping` (`roomID`, `FacilityID`, `BusinessInfoID`, `IsActive`) VALUES
(23, 49, 177, 1),
(23, 50, 177, 1),
(24, 49, 177, 1),
(24, 50, 177, 1),
(25, 49, 177, 1),
(25, 50, 177, 1),
(26, 49, 177, 1),
(26, 50, 177, 1),
(27, 0, 177, 1),
(27, 49, 177, 1),
(27, 50, 177, 1),
(28, 0, 177, 1),
(28, 1, 177, 1),
(28, 49, 177, 1),
(28, 50, 177, 1),
(29, 0, 178, 1),
(29, 51, 178, 1),
(30, 53, 178, 1),
(31, 51, 178, 1),
(31, 52, 178, 1),
(31, 53, 178, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `FeatureID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `FeatureName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`FeatureID`, `BusinessInfoID`, `FeatureName`) VALUES
(26, 177, 'Garden'),
(28, 178, 'Toilet'),
(29, 178, 'King size bed'),
(30, 177, 'Bunot');

-- --------------------------------------------------------

--
-- Table structure for table `room_features_mapping`
--

CREATE TABLE `room_features_mapping` (
  `roomID` int(11) NOT NULL,
  `FeatureID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features_mapping`
--

INSERT INTO `room_features_mapping` (`roomID`, `FeatureID`, `BusinessInfoID`, `IsActive`) VALUES
(23, 26, 177, 1),
(24, 26, 177, 1),
(25, 26, 177, 1),
(26, 26, 177, 1),
(27, 0, 177, 1),
(27, 1, 177, 1),
(27, 26, 177, 1),
(27, 30, 177, 1),
(28, 0, 177, 1),
(28, 26, 177, 1),
(29, 0, 178, 1),
(29, 1, 178, 1),
(29, 27, 178, 1),
(29, 28, 178, 1),
(29, 29, 178, 1),
(30, 28, 178, 1),
(30, 29, 178, 1),
(31, 28, 178, 1),
(31, 29, 178, 1);

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `userAccID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passcode` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsConfirm` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`userAccID`, `userID`, `email`, `passcode`, `created_at`, `IsConfirm`) VALUES
(46, 71, 'michellepriamolina2016@gmail.com', '$2y$10$07WVKP/kKQJEm1TBhX7Go./iBFadDnk6u4SmaYc9WbmHG1CG9ECjm', '2025-01-11 13:57:04', 1),
(47, 72, 'eaanives04@gmail.com', '$2y$10$6BBL7WJYpA3JclItIer1JuOTyZf.9I1j4cUHu7kyoMxJnU0yzc4li', '2025-01-13 03:27:41', 1),
(49, 74, 'jordanraemarabe@shurua.xyz', '$2y$10$rMpPuvIooMN/UUV7FZwcdesdFF2k.BxNzs8c5tn2l7NUg8NAGUzsC', '2025-01-14 09:40:55', 1),
(61, 86, 'lasixe7819@nalwan.com', '$2y$10$2hzgwvqnm8H2l3oPGCPgAu59Ebw4eBL9bNv/CW1guVXok1TJ.6fCq', '2025-01-14 12:42:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userdemographics`
--

CREATE TABLE `userdemographics` (
  `userdemogId` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `BusinessInfoID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `totalnumAttendees` int(11) NOT NULL,
  `totalmale` int(11) NOT NULL,
  `totalfemale` int(11) NOT NULL,
  `thisCity` int(11) NOT NULL,
  `otherCity` int(11) NOT NULL,
  `otherProvince` int(11) NOT NULL,
  `foreignCountry` int(11) NOT NULL,
  `isAccepted` enum('Pending','Accepted') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdemographics`
--

INSERT INTO `userdemographics` (`userdemogId`, `userID`, `roomID`, `BusinessInfoID`, `name`, `sex`, `location`, `created_at`, `totalnumAttendees`, `totalmale`, `totalfemale`, `thisCity`, `otherCity`, `otherProvince`, `foreignCountry`, `isAccepted`) VALUES
(170, 71, 23, 177, 'Michelle Molina, Andrei Farinas', 'Female, Male', 'This City/Municipality, This City/Municipality', '2025-01-11 14:44:22', 2, 1, 1, 2, 0, 0, 0, 'Pending'),
(171, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other City/Municipality', '2025-01-13 03:03:24', 2, 1, 1, 1, 1, 0, 0, 'Pending'),
(172, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other Province', '2025-01-13 03:07:03', 2, 1, 1, 1, 0, 1, 0, 'Pending'),
(173, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other Province', '2025-01-13 03:09:35', 2, 1, 1, 1, 0, 1, 0, 'Pending'),
(174, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other Province', '2025-01-13 03:11:53', 2, 1, 1, 1, 0, 1, 0, 'Pending'),
(175, 71, 27, 177, 'Michelle Molina, Jordan Rae Marabes', 'Female, Male', 'This City/Municipality, Foreign Country', '2025-01-13 03:17:13', 2, 1, 1, 1, 0, 0, 1, 'Pending'),
(176, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other City/Municipality', '2025-01-13 03:18:14', 2, 1, 1, 1, 1, 0, 0, 'Pending'),
(177, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other Province', '2025-01-13 03:20:16', 2, 1, 1, 1, 0, 1, 0, 'Pending'),
(178, 71, 27, 177, 'Michelle Molina, Jordan Rae Marabes', 'Female, Male', 'This City/Municipality, Foreign Country', '2025-01-13 03:21:57', 2, 1, 1, 1, 0, 0, 1, 'Pending'),
(179, 71, 27, 177, 'Michelle Molina, Jordan Rae Marabes', 'Female, Female', 'This City/Municipality, Other City/Municipality', '2025-01-13 03:26:10', 2, 0, 2, 1, 1, 0, 0, 'Pending'),
(180, 72, 27, 177, 'John Doe, Jenniw Wigger', 'Male, Female', 'Other Province, Foreign Country', '2025-01-13 03:30:01', 2, 1, 1, 0, 0, 1, 1, 'Accepted'),
(181, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other City/Municipality', '2025-01-13 03:35:57', 2, 1, 1, 1, 1, 0, 0, 'Pending'),
(182, 72, 27, 177, 'John Doe, Jenniw Wigger', 'Male, Female', 'Other Province, Foreign Country', '2025-01-13 03:38:12', 2, 1, 1, 0, 0, 1, 1, 'Accepted'),
(183, 72, 27, 177, 'John Doe, Jenniw Wigger', 'Male, Female', 'Other Province, Foreign Country', '2025-01-13 03:43:26', 2, 1, 1, 0, 0, 1, 1, 'Accepted'),
(184, 72, 27, 177, 'John Doe, Jenniw Wigger', 'Male, Female', 'Other Province, Foreign Country', '2025-01-13 03:46:05', 2, 1, 1, 0, 0, 1, 1, 'Accepted'),
(185, 72, 27, 177, 'John Doe, Jenniw Wigger', 'Male, Female', 'Other Province, Foreign Country', '2025-01-13 03:47:05', 2, 1, 1, 0, 0, 1, 1, 'Accepted'),
(186, 72, 28, 177, 'Jack Kline', 'Male', 'Other City/Municipality', '2025-01-13 03:52:55', 1, 1, 0, 0, 1, 0, 0, 'Accepted'),
(187, 72, 28, 177, 'Jack Kline', 'Male', 'Other City/Municipality', '2025-01-13 03:54:03', 1, 1, 0, 0, 1, 0, 0, 'Accepted'),
(188, 72, 28, 177, 'Jack Kline', 'Male', 'Other City/Municipality', '2025-01-13 03:55:27', 1, 1, 0, 0, 1, 0, 0, 'Accepted'),
(189, 72, 27, 177, 'John Doe, Jane Doe', 'Male, Female', 'Other Province, Other Province', '2025-01-13 10:26:16', 2, 1, 1, 0, 0, 2, 0, 'Pending'),
(190, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, Other City/Municipality', '2025-01-13 10:41:48', 2, 1, 1, 1, 1, 0, 0, 'Pending'),
(191, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Male', 'This City/Municipality, This City/Municipality', '2025-01-13 10:44:15', 2, 1, 1, 2, 0, 0, 0, 'Pending'),
(192, 71, 27, 177, 'Michelle Molina, Jordan Rae Marabes', 'Female, Male', 'This City/Municipality, Other Province', '2025-01-13 10:55:35', 2, 1, 1, 1, 0, 1, 0, 'Pending'),
(193, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Female', 'This City/Municipality, Other City/Municipality', '2025-01-14 03:26:13', 2, 0, 2, 1, 1, 0, 0, 'Pending'),
(194, 71, 27, 177, 'Michelle Molina, John Rev Balitons', 'Female, Female', 'This City/Municipality, Other Province', '2025-01-14 09:31:09', 2, 0, 2, 1, 0, 1, 0, 'Pending'),
(195, 74, 27, 177, 'Jordan Rae Marabe, John Rev Balitons', 'Male, Male', 'Other City/Municipality, Other City/Municipality', '2025-01-14 09:51:28', 2, 2, 0, 0, 2, 0, 0, 'Pending'),
(196, 78, 27, 177, 'Jose Manalo, Wally Bayola', 'Male, Male', 'Other City/Municipality, Other City/Municipality', '2025-01-14 10:37:48', 2, 2, 0, 0, 2, 0, 0, 'Pending'),
(197, 80, 27, 177, 'Jose Manalo, Wally Bayola', 'Male, Male', 'Foreign Country, Foreign Country', '2025-01-14 10:49:12', 2, 2, 0, 0, 0, 0, 2, 'Pending'),
(198, 81, 27, 177, 'Jose Manalo, Wally Bayola', 'Male, Male', 'Foreign Country, Foreign Country', '2025-01-14 10:55:09', 2, 2, 0, 0, 0, 0, 2, 'Pending'),
(199, 86, 27, 177, 'Jose Manalo, John Rev Baliton', 'Male, Male', 'This City/Municipality, This City/Municipality', '2025-01-14 12:44:39', 2, 2, 0, 2, 0, 0, 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `userpayment`
--

CREATE TABLE `userpayment` (
  `userpayID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `businessinfoID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `IsPaid` tinyint(1) NOT NULL DEFAULT 0,
  `proofOfPayment` varchar(255) DEFAULT NULL,
  `gcashReference` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_contact` varchar(20) NOT NULL,
  `u_address` varchar(255) NOT NULL,
  `locationType` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `id_type` varchar(255) NOT NULL,
  `front_id` varchar(255) NOT NULL,
  `back_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `full_name`, `u_email`, `u_contact`, `u_address`, `locationType`, `sex`, `id_type`, `front_id`, `back_id`, `created_at`) VALUES
(71, 'Michelle Molina', 'michellepriamolina2016@gmail.com', '+639667742616', 'Sta monica, San Pablo City, laguna', 'This City/Municipality', 'Female', 'Voter ID', '../../user/userID/Molina/Molina_71_front.jpg', NULL, '2025-01-11 13:57:04'),
(72, 'John Doe', 'eaanives04@gmail.com', '+639065417074', '123 St., Brgy. Barangay, Municipality City, Province province', 'Other Province', 'Male', 'Bagong ID', '../../user/userID/Doe/Doe_72_front.jpeg', '../../user/userID/Doe/Doe_72_back.png', '2025-01-13 03:27:41'),
(74, 'Jordan Rae Marabe', 'jordanraemarabe@shurua.xyz', '+639812738912', '21323 Street', 'Other City/Municipality', 'Male', 'Passport', '../../user/userID/Marabe/Marabe_74_front.webp', NULL, '2025-01-14 09:40:55'),
(86, 'Jose Manalo', 'lasixe7819@nalwan.com', '+631221121212', 'Jose', 'This City/Municipality', 'Male', 'Passport', '../../user/userID/Manalo_86/Manalo_86_front.webp', '../../user/userID/Manalo_86/Manalo_86_back.webp', '2025-01-14 12:42:01');

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
-- Indexes for table `barangay_accounts`
--
ALTER TABLE `barangay_accounts`
  ADD PRIMARY KEY (`barangayId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bownerdemographics`
--
ALTER TABLE `bownerdemographics`
  ADD PRIMARY KEY (`bOwnerId`),
  ADD KEY `ApplicationID` (`ApplicationID`);

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
  ADD KEY `BusinessInfoID` (`BusinessInfoID`),
  ADD KEY `fk_barangay` (`barangayId`);

--
-- Indexes for table `demographics`
--
ALTER TABLE `demographics`
  ADD PRIMARY KEY (`demogId`),
  ADD KEY `barangayId` (`barangayId`);

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
-- Indexes for table `highlights`
--
ALTER TABLE `highlights`
  ADD PRIMARY KEY (`HighlightID`),
  ADD KEY `BarangayID` (`BarangayID`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`paymentMethodID`),
  ADD KEY `roomID` (`roomID`);

--
-- Indexes for table `qcashpayment`
--
ALTER TABLE `qcashpayment`
  ADD PRIMARY KEY (`bgcashID`),
  ADD KEY `BusinessInfoID` (`BusinessInfoID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`revID`),
  ADD KEY `roomID` (`roomID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `revID` (`revID`);

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
-- Indexes for table `room_facilities_mapping`
--
ALTER TABLE `room_facilities_mapping`
  ADD PRIMARY KEY (`roomID`,`FacilityID`),
  ADD KEY `fk_room_facilities_mapping_business` (`BusinessInfoID`),
  ADD KEY `fk_room_facilities_mapping_facility` (`FacilityID`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`FeatureID`);

--
-- Indexes for table `room_features_mapping`
--
ALTER TABLE `room_features_mapping`
  ADD PRIMARY KEY (`roomID`,`FeatureID`,`BusinessInfoID`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`userAccID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `userdemographics`
--
ALTER TABLE `userdemographics`
  ADD PRIMARY KEY (`userdemogId`),
  ADD KEY `userID` (`userID`),
  ADD KEY `roomID` (`roomID`),
  ADD KEY `BusinessInfoID` (`BusinessInfoID`);

--
-- Indexes for table `userpayment`
--
ALTER TABLE `userpayment`
  ADD PRIMARY KEY (`userpayID`),
  ADD KEY `roomID` (`roomID`),
  ADD KEY `businessinfoID` (`businessinfoID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barangay_accounts`
--
ALTER TABLE `barangay_accounts`
  MODIFY `barangayId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `bownerdemographics`
--
ALTER TABLE `bownerdemographics`
  MODIFY `bOwnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `businessapplicationform`
--
ALTER TABLE `businessapplicationform`
  MODIFY `ApplicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `businessinformationform`
--
ALTER TABLE `businessinformationform`
  MODIFY `BusinessInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `businesstype`
--
ALTER TABLE `businesstype`
  MODIFY `BusinessTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `business_features`
--
ALTER TABLE `business_features`
  MODIFY `BusinessFeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `business_media`
--
ALTER TABLE `business_media`
  MODIFY `MediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `demographics`
--
ALTER TABLE `demographics`
  MODIFY `demogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `FeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `frontpagecontent`
--
ALTER TABLE `frontpagecontent`
  MODIFY `frontpageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `HighlightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `paymentMethodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `qcashpayment`
--
ALTER TABLE `qcashpayment`
  MODIFY `bgcashID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `revID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roominfotable`
--
ALTER TABLE `roominfotable`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `FacilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `FeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `userAccID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `userdemographics`
--
ALTER TABLE `userdemographics`
  MODIFY `userdemogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `userpayment`
--
ALTER TABLE `userpayment`
  MODIFY `userpayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`ApplicationID`) REFERENCES `businessapplicationform` (`ApplicationID`);

--
-- Constraints for table `bownerdemographics`
--
ALTER TABLE `bownerdemographics`
  ADD CONSTRAINT `bownerdemographics_ibfk_1` FOREIGN KEY (`ApplicationID`) REFERENCES `businessinformationform` (`ApplicationID`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `business_media_ibfk_1` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_barangay` FOREIGN KEY (`barangayId`) REFERENCES `barangay_accounts` (`barangayId`),
  ADD CONSTRAINT `fk_businessinfo` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`);

--
-- Constraints for table `demographics`
--
ALTER TABLE `demographics`
  ADD CONSTRAINT `demographics_ibfk_1` FOREIGN KEY (`barangayId`) REFERENCES `barangay_accounts` (`barangayId`);

--
-- Constraints for table `highlights`
--
ALTER TABLE `highlights`
  ADD CONSTRAINT `highlights_ibfk_1` FOREIGN KEY (`BarangayID`) REFERENCES `barangay_accounts` (`barangayId`);

--
-- Constraints for table `qcashpayment`
--
ALTER TABLE `qcashpayment`
  ADD CONSTRAINT `qcashpayment_ibfk_1` FOREIGN KEY (`BusinessInfoID`) REFERENCES `businessinformationform` (`BusinessInfoID`);

--
-- Constraints for table `reservation_payments`
--
ALTER TABLE `reservation_payments`
  ADD CONSTRAINT `reservation_payments_ibfk_1` FOREIGN KEY (`revID`) REFERENCES `reservations` (`revID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
