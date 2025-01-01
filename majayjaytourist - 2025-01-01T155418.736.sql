-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 08:54 AM
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
(38, 65, 'markopornasa99@shurua.xyz', '$2y$10$NyHy.lcH6T5oDR5heLhrcODGdiHLrg2rUbo3MJ2USlKp2ufi7CMFy', 0, '2024-10-03 14:51:46', '2024-10-03 07:27:58', 'subadmin', 'Active', 0, NULL),
(39, 77, 'rigordimagiba87@shurua.xyz', '$2y$10$vNJuWjEJXf0Ll3bgrHs9CeeDHKEHmXRlApasIO4D/xH2aaPwCXldK', 0, '2024-10-03 15:39:57', '2024-10-03 10:53:23', 'subadmin', 'Active', 0, NULL),
(40, 76, 'pahiyangkanaman87@shurua.xyz', '$2y$10$BuzUte9D1UY8iSWskA5wXOvxOKw1PHopErCCW8XQmDa4Zo1GNrEnO', 0, '2024-10-04 23:09:04', '2024-10-03 13:24:40', 'subadmin', 'Active', 0, NULL),
(41, 79, 'mijaysilog@shurua.xyz', '$2y$10$IDz7JK9I9gb3w2sNrO733.jr3dric66frMw/VoEp61RFUKww7DKM2', 0, '2024-12-26 03:30:15', '2024-10-03 14:54:03', 'subadmin', 'Active', 0, NULL),
(42, 78, 'jasperbibon@shurua.xyz', '$2y$10$I0jGwS52djnzFfMRTLqXUe0P2xG0uXjvVRkquN2obXeXe8Fd1tXvi', 1, '2024-12-23 11:53:21', '2024-10-03 15:40:18', 'subadmin', 'Active', 0, NULL),
(43, 80, 'lenierob@shurua.xyz', '$2y$10$JymhynXoeSn1ltapM1BzLOqeHZe8z/kiOM4EPp.k4Jduce3KcawZ6', 0, '2024-10-04 15:37:13', '2024-10-04 15:34:43', 'subadmin', 'Active', 0, NULL),
(44, 81, 'ri55fin3@duckmail.club', '$2y$10$wXLDKRuyj/Df4WM.GLbU4e02noT.BDfsc/yK1Amd1OWwQoIWe1hZa', 0, '2024-10-05 10:44:27', '2024-10-05 10:42:45', 'subadmin', 'Active', 0, NULL),
(45, 82, '669ia3yl@duckmail.club', '$2y$10$YCW.UxbRzqZCSeDLS32m7esmhseNJmVTL4ei9xFH7y6R5qsqobxOK', 1, '2024-10-06 08:37:00', '2024-10-06 08:37:00', 'subadmin', 'Active', 0, NULL),
(46, 99, 'loretomanalo@shurua.xyz', '$2y$10$I7f0HsM3j1uSt0FsLL9.8exImJf3/W1YC6UYEFGbox.6uSnwrpM6O', 0, '2024-10-09 01:50:43', '2024-10-09 01:49:59', 'subadmin', 'Active', 0, NULL),
(47, 100, '4rm9canf@duckmail.club', '$2y$10$B5FmEacry5zCaSbUZ/k/0ui5hC4j9H9eSTorc2r7xRJat3AY9XSS.', 1, '2024-10-10 09:01:10', '2024-10-10 09:01:10', 'subadmin', 'Active', 0, NULL),
(48, 104, 'dasehidq@duckmail.club', '$2y$10$GXJ.iy5OR9EoEIcM.KJ5k.ry9Iy9syZ/1J6OnAuLQS8ZebUcKZW/y', 0, '2024-10-10 16:25:05', '2024-10-10 14:34:33', 'subadmin', 'Active', 0, NULL),
(49, 106, 'whdw2uyt@duckmail.club', '$2y$10$awvcg.cPz9afG5ZxjdiriOCTVeSFK0Yp7kQYIb8TBk/tCtsnaAKlK', 0, '2024-10-11 10:28:12', '2024-10-11 10:19:27', 'subadmin', 'Active', 0, NULL),
(50, 107, 't43l3so0@duckmail.club', '$2y$10$q.Q8PrrboYW09fljhovHkOoh4EAWJYzshKeZhN0LdSQRw1r3dGy2O', 0, '2024-10-14 02:29:50', '2024-10-14 02:28:15', 'subadmin', 'Active', 0, NULL),
(51, 108, '4tztcwbj@duckmail.club', '$2y$10$uVWuIih7aic8uJ1VsXQOFepIDH9Hk3o5MXFl/hxWju9qqECu4p.Fq', 0, '2024-10-14 06:03:25', '2024-10-14 05:34:40', 'subadmin', 'Active', 0, NULL),
(52, 109, 'iq7eej58@duckmail.club', '$2y$10$96589gBNNcfQTKPoFi1NVOszATQYhm2IvwSoDHxsgVqC.EK.1aAhK', 0, '2024-10-22 07:09:57', '2024-10-14 07:26:15', 'subadmin', 'Active', 0, NULL),
(53, 110, '70f2pmax@duckmail.clu', '$2y$10$zLEvGcaKRYmyU/e1iQA3X.d.VS/TjXSr75foEEUe5w9lrh.7c6G8e', 1, '2024-11-02 22:38:47', '2024-11-02 22:38:47', 'subadmin', 'Active', 0, NULL),
(54, 111, 'vn3rbhp9@duckmail.club', '$2y$10$zsbqOx/XiM3BI8DM2fgs7Oq.eYLCKix3CFVyLRisIZdd/C9HhQZMq', 1, '2024-11-02 22:42:41', '2024-11-02 22:42:41', 'subadmin', 'Active', 0, NULL),
(62, 112, '037j7xo4@duckmail.club', '$2y$10$J3ZEG5Y2KtB5P7c0xjbz9u37Y29p4s.pUeMEp5mjPU19EFvsWDVLq', 1, '2024-11-02 23:13:03', '2024-11-02 23:13:03', 'subadmin', 'Active', 0, '../../admin/qrCode/6726b1ff3fa66.png'),
(63, 113, '8uz384bp@duckmail.club', '$2y$10$jHLpYdIJ6/N4vZBw3DU7oOc46pX1J4x2Wb9do8AWSk1B3vo1v0bzW', 1, '2024-11-02 23:17:37', '2024-11-02 23:17:37', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6726b311acc8e.png'),
(64, 114, 'k463smrl@duckmail.club', '$2y$10$vjMJKBXx9hLuQ4hjOZ5you1Gs3DjfQrfEJ.C.7T0sqiPNKTypbcla', 1, '2024-11-02 23:32:29', '2024-11-02 23:32:29', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6726b68db1d39.png'),
(65, 115, '0tt17dbp@duckmail.club', '$2y$10$43d8MBwut2EGEGHL5mopt.IGQqGx0reKNmjoM.UAd1jML4YtOeTAG', 1, '2024-11-02 23:44:50', '2024-11-02 23:44:50', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6726b9722f7e1.png'),
(68, 116, 'ghro15z3@duckmail.club', '$2y$10$67cOoXYGzT9QlDi5vwCiH.QkBKz9SZVFKETBhGon1Cft51xixSOsa', 1, '2024-11-02 23:57:16', '2024-11-02 23:57:16', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6726bc5cebc01.png'),
(69, 117, 'magkanosila98@shurua.xyz', '$2y$10$iuSpnizcJvl9rtCCE3hkR.EQ4DSMXE8JhYNuthWHcAzHdXJMj1sd2', 1, '2024-11-02 23:59:10', '2024-11-02 23:59:10', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6726bccea6231.png'),
(70, 118, 'akosimon87@shurua.xyz', '$2y$10$vt8JgblSpB716aeOqbT57u.cqn8fMSDVuzaE1E1wQm2N1iD.6XWqS', 0, '2024-11-03 01:29:59', '2024-11-03 00:03:40', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6726bddc6fbf0.png'),
(71, 119, 'batodelarosa98@shurua.xyz', '$2y$10$BlXaMquLBkIH147WDfVEh.bjBsLeiJX5k9PzvGsJ/GOjsoKCWi48K', 1, '2024-11-07 21:14:52', '2024-11-07 21:14:52', 'subadmin', 'Active', 0, '../../businessowner/qrCode/672d2dcc1df63.png'),
(72, 121, 'japiyukiopisd98@shurua.xyz', '$2y$10$iPs3gammBEXop0zLt7WaluwgJN32IAC9anhopgtGEYyQ2NobtF5l6', 1, '2024-11-12 03:08:31', '2024-11-12 03:08:30', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6732c6afdf3f2.png'),
(73, 122, 'pokwangboang98@shurua.xyz', '$2y$10$FzNYF198lGkTVrqKMksmAu1Qax5yRjUeRoyVss1BunrHJuwPcGQi6', 1, '2024-11-12 03:39:58', '2024-11-12 03:39:58', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6732ce0eb0158.png'),
(74, 123, 'mavsphonekj98@shurua.xyz', '$2y$10$tdV2TIEq2cBfXufTyDXv4euEuZ1qWIgQ9pn59v/qV5FH8FReS674K', 1, '2024-11-12 05:47:21', '2024-11-12 05:47:21', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6732ebe926267.png'),
(75, 124, 'ajkshd897@shurua.xyz', '$2y$10$uWlS1afB/MmoNysOCgJYw.Wc07nJWRQ72J6m.gpAX2nprvlLo8QkK', 1, '2024-11-12 05:52:42', '2024-11-12 05:52:41', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6732ed2a1fb11.png'),
(76, 125, 'saaraherrerajh87@shurua.xyz', '$2y$10$6paxVQUan536XSEcvrJjXuwuCzEFaTbhiNx2yo15tdJT/aTBFdN9a', 1, '2024-11-12 06:00:07', '2024-11-12 06:00:07', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6732eee7a8f16.png'),
(77, 126, 'TimothyDiolala234@shurua.xyz', '$2y$10$1uu7TGLFfw7Wasfjk.EMiOTg9ZJV/8LYjwpMGwQFmB8Dqj5HSajlG', 1, '2024-11-12 06:02:42', '2024-11-12 06:02:41', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6732ef822aa55.png'),
(78, 127, 'joelsigfredd98@shurua.xyz', '$2y$10$XK6Kfj24SyO2MN8KHGamK.1UZdxeDK9jhaSoapPiVw0I2D4cm9tH6', 1, '2024-11-12 07:18:37', '2024-11-12 07:18:37', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6733014d4fd88.png'),
(79, 128, 'mariotupar76@shurua.xyz', '$2y$10$6rCypFEFqWzYLhzpHrVk.O4xMOHvppwXAbOLzoVMT5KpiewBMtbJG', 0, '2024-11-14 13:24:54', '2024-11-14 13:23:03', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6735f9b97c8b2.png'),
(80, 130, 'angelorsmanalo98@shurua.xyz', '$2y$10$uLv5n4RH01u8loeUrOPlmeWmtH70LXeHuEeBcKbV6SpHRxK47FIyy', 0, '2024-11-18 10:40:50', '2024-11-18 10:39:51', 'subadmin', 'Active', 0, '../../businessowner/qrCode/673b19793f567.png'),
(81, 131, 'johncyrilarganosa12@shurua.xyz', '$2y$10$mxbNxBfLorlfvcvJsKJnxe44ezmtkm51vYFLLLcn/Y1rS0lciPcg6', 0, '2024-11-19 06:49:01', '2024-11-19 06:47:32', 'subadmin', 'Active', 0, '../../businessowner/qrCode/673c34841d232.png'),
(82, 133, 'eaanives04@gmail.com', '$2y$10$mHWFjpbY6hREGvELALFsb.m6cFrgoF2ropq8s5Y1qYUfgiDJgE/eK', 0, '2024-12-17 07:16:42', '2024-12-17 07:15:15', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676125052bd75.png'),
(84, 75, 'makhilsila87@shurua.xyz', '$2y$10$qOJfFHxJXPpnG3J/RWhs9..De6IVmo60LwtRT4nxDIbo15WXd607e', 1, '2024-12-19 00:27:50', '2024-12-19 00:27:49', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6763688601db1.png'),
(95, 139, 'johnalcohol@shurua.xyz', '$2y$10$jIqVG1LoH5artFVU8SpLdeTF2BoHgOboKUVtUY6IatDwnvrICCqHW', 1, '2024-12-20 10:21:21', '2024-12-20 10:21:21', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67654521e996b.png'),
(96, 140, 'pulsosaya@shurua.xyz', '$2y$10$OxOzKjzbDszQoPp4Kb7iFusJ/S4wmU.5xLkUerK5qrbioUkg7rnoG', 1, '2024-12-21 03:08:59', '2024-12-21 03:08:57', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6766314b47087.png'),
(97, 141, 'kapelomi@shurua.xyz', '$2y$10$BZIgB.zeCNyksDLcXoPv8.U5VgsBZe23OsZOMTy0w.yw.Z99l7ivG', 1, '2024-12-21 09:38:27', '2024-12-21 09:38:25', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67668c9315e47.png'),
(98, 143, 'maharlikahighway@shurua.xyz', '$2y$10$4lkPjcpHlD8c2iokZi3MXOo29uA9iXAm3PbVbRQmnPbaqWogL42Re', 1, '2024-12-21 13:24:27', '2024-12-21 13:24:27', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6766c18ba2db6.png'),
(100, 144, 'joyperez00@shurua.xyz', '$2y$10$RyXSU/mqKIXlJW/Tzv9SDeUO.v4pdFAqipT9WxtZhSWy0wqAhC4eq', 1, '2024-12-22 10:12:40', '2024-12-22 10:12:38', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6767e6184b5c3.png'),
(101, 145, 'lumienmanalo@shurua.xyz', '$2y$10$u2BspeMTvwRFqk2rmuXyQ.tUQMxrk82P/YUkU3px0FskUKg2ulmJe', 0, '2024-12-23 02:14:40', '2024-12-23 02:11:23', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6768c6cc90c6b.png'),
(102, 146, 'asomanalo@shurua.xyz', '$2y$10$4uLtgww0pG5FLEUYi1FHMutnOfEJQHa/KtrDTyO22OiUTvfIFQMlO', 0, '2024-12-23 02:38:39', '2024-12-23 02:36:57', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6768ccc97b67b.png'),
(103, 147, 'inhalermanalo@shurua.xyz', '$2y$10$kb3AJ5/DK8U/FiXWJq9NLeScu1ZShXJKPwLez5NOvSKbsS/CXR/jG', 1, '2024-12-23 06:48:12', '2024-12-23 06:48:10', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676907ac9bef2.png'),
(104, 148, '1k2t7r70@duckmail.club', '$2y$10$ZD8ZhqoLdQTKBmH2W0dkiOtwnYhQ4VA4la5Z.G37mgm3WPSi0aA1e', 0, '2024-12-29 04:31:38', '2024-12-23 10:42:49', 'subadmin', 'Inactive', 0, '../../businessowner/qrCode/67693ea9da41a.png'),
(106, 149, 'taytayfalls@duckmail.club', '$2y$10$hy7m.6bORuuE4Hlad6cwA.c5xvm4NSeFbW6s4vAT7WBIwyOsb13ky', 0, '2024-12-26 02:15:09', '2024-12-23 11:26:53', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676948fd421ee.png'),
(107, 150, 'latriccia@duckmail.club', '$2y$10$m6Vk16XsWX4QpP7..QYMuejcFkC1/Q/TdFm6RKZWgYhOIoKMC9MBu', 1, '2024-12-23 12:44:08', '2024-12-23 12:44:08', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67695b1846dd5.png'),
(108, 151, 'dalitawan@duckmail.club', '$2y$10$L3cVanTtFi5KkScXewUvV.Xa0zvSLYZmhAo6ffWmCCxkTQ0Qq371i', 1, '2024-12-23 13:00:51', '2024-12-23 13:00:51', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67695f038320c.png'),
(109, 152, 'lasfamilias@duckmail.club', '$2y$10$OyvDB4huXpfnbYZwaWsz8.uG9lZ1MX.X0gUWNWTABWcz2spiXoTQK', 1, '2024-12-23 13:06:04', '2024-12-23 13:06:03', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6769603c1cdb3.png'),
(110, 153, 'goyamalinao@duckmail.club', '$2y$10$GJoDWyj4NTFEGiXvT41xmeKdxgrmp3/D7.1aYPJ6bEb.BzMrKLfMS', 1, '2024-12-23 13:17:58', '2024-12-23 13:17:58', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67696306758fa.png'),
(111, 154, 'boying@duckmail.club', '$2y$10$QAg.2kNKSD7I5NGuM96b6O3eE9/JKKbfrBrPQpOTqinhfBhKQypZS', 0, '2024-12-23 13:26:12', '2024-12-23 13:23:52', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6769646825c10.png'),
(112, 155, 'duck@duckmail.club', '$2y$10$.0v6Tdlm/EULuV9b3CMVuOdIFvnM0YrdHpLzXLvid7LG41udkVPqC', 1, '2024-12-23 13:32:03', '2024-12-23 13:32:03', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67696653410ff.png'),
(113, 156, 'morax@duckmail.club', '$2y$10$QnNJ/ztwmn8W0bWRjRsqPeZCMQRK0Ozl75Cdj0K62yhckddYQQZ4e', 1, '2024-12-26 03:30:19', '2024-12-23 13:57:36', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67696c50d2d08.png'),
(114, 157, 'chaldea@duckmail.club', '$2y$10$.pspUn0BsuS3q3bAGicF6.fPJYy5K6dSyZguPIEWTOFf9c8Px2uWa', 1, '2024-12-23 14:20:05', '2024-12-23 14:20:05', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676971955738b.png'),
(115, 158, 'favonius@duckmail.club', '$2y$10$rCopENE9hnbHdrwSotv8UOAadN9XGLt6HhldtsEXZZZTWdbMEiqgy', 1, '2024-12-23 15:07:56', '2024-12-23 15:07:56', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67697ccca8ff9.png'),
(116, 159, 'quj639jd@duckmail.club', '$2y$10$eoEfP9MgvSqDLRrs29VmSu8J2Z3XCDLpm/M843MC9UVZCl2L7O4KO', 1, '2024-12-24 00:57:49', '2024-12-24 00:57:47', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676a070d3c33a.png'),
(117, 160, 'raneukqk@duckmail.club', '$2y$10$AJ5nyy/oSr14mcPlY7zkYuj9XjXOAGCGeoHSlSKuXlIcs4ue0qY3.', 1, '2024-12-24 02:00:14', '2024-12-24 02:00:13', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676a15ae00ad7.png'),
(118, 162, '9fz9lq8z@duckmail.club', '$2y$10$om8PEnXfHkn2C3shYfc0Juclpym.KEw7CrrVp8fV/h0zkc6QM/V2W', 1, '2024-12-26 02:38:56', '2024-12-24 23:20:27', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676b41bc729ce.png'),
(119, 163, 'ubokmarabe@shurua.xyz', '$2y$10$oYsTIQ6FySCBQp9e7iWGeeWjoFRgIJ3BoEkAhWl5nWRAr3NgJRzqq', 1, '2024-12-26 03:28:57', '2024-12-26 02:58:33', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676cc65b2a134.png'),
(120, 164, 'tisoypanget@shurua.xyz', '$2y$10$WgU2eP5pknF21k1NEyzg5eFYGJePuvjQgMJOK7CvIhFnMxv6UUzy2', 0, '2024-12-26 05:59:32', '2024-12-26 05:58:17', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676cf07b09f11.png'),
(121, 165, 'geraldmarabe@shurua.xyz', '$2y$10$y0Yv.U0T9wm5ygYpurowN.wfDmnWPC5u7mV7S04EiLBsNA1dZrryS', 1, '2024-12-26 06:36:30', '2024-12-26 06:36:30', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676cf96e56482.png'),
(122, 166, 'aikeanderson@shurua.xyz', '$2y$10$6z9vrUYT7C0t1iDrB3RAduHfZh2YKteVz8tO8o19o81PwI5YBOgD2', 0, '2024-12-28 11:43:39', '2024-12-28 11:42:26', 'subadmin', 'Active', 0, '../../businessowner/qrCode/676fe423da6b6.png'),
(123, 167, 'majayjaytaytay@shurua.xyz', '$2y$10$XdEo0vu9Q.xmVKmamywgReHjsPahTw3JfD33Zwrr91Ew/Q1/xj0iu', 0, '2024-12-29 02:48:27', '2024-12-29 02:47:06', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6770b82c2fd8e.png'),
(124, 168, 'jamesyap@shurua.xyz', '$2y$10$f8bx3zzmbwEkPOIahdNvBeVl21JV0XO8Ao7s3grGTVg0T1sALBkea', 0, '2024-12-29 03:27:14', '2024-12-29 03:25:14', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6770c11a605d0.png'),
(125, 169, 'devineerikavitasa@gmail.com', '$2y$10$iFlFeZKn9M1Q0kndP.mmYOQHUNfjHB56/OPP3bo956mxbml6CHXf2', 0, '2024-12-29 04:44:18', '2024-12-29 04:42:11', 'subadmin', 'Active', 0, '../../businessowner/qrCode/6770d323b2524.png'),
(126, 170, 'boxmega884@gmail.com', '$2y$10$ZK5Zw/O39t17Pw0zA3vEsOAe1QA77sop4Sbtq/xD5PB2AkhUCEWb6', 0, '2024-12-30 03:34:36', '2024-12-30 03:32:48', 'subadmin', 'Active', 0, '../../businessowner/qrCode/677214620ccdd.png'),
(127, 171, 'angingay@shurua.xyz', '$2y$10$Urk.P5U17a4DCura4xeknOje2tFHci5c1LiyeDOgVXCgxhelNZvKG', 0, '2024-12-30 07:45:45', '2024-12-30 07:43:04', 'subadmin', 'Active', 0, '../../businessowner/qrCode/67724f091d980.png');

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
  `qr_code` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `BusinessTypeID` int(11) NOT NULL DEFAULT 21
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_accounts`
--

INSERT INTO `barangay_accounts` (`barangayId`, `email`, `password`, `establishment`, `qr_code`, `created_at`, `BusinessTypeID`) VALUES
(21, 'jordanbarangay@shurua.xyz', '$2y$10$R9KfFSXysZNzB1.uTumImuL0XPkH09rr6fu.9I8ZDikmsbVOCtdB6', 'Jordan Falls', 'qrCode/6773638bb1ad1.png', '2024-12-31 03:22:50', 21);

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

--
-- Dumping data for table `bownerdemographics`
--

INSERT INTO `bownerdemographics` (`bOwnerId`, `ApplicationID`, `name`, `sex`, `location`, `created_at`, `totalnumAttendees`, `totalmale`, `totalfemale`, `thisCity`, `otherCity`, `otherProvince`, `foreignCountry`) VALUES
(112, 128, 'Rev Smith, Rev Smith, Rev Smith, Rev Smith', 'Male, Female, Male, Female', 'This City/Municipality, This City/Municipality, Other City/Municipality, Other City/Municipality', '2024-12-30 10:07:30', 4, 2, 2, 2, 2, 0, 0),
(113, 128, 'Jajaja, Hdhdhdhd, Hdhdhd, Hdhdhd', 'Male, Female, Male, Female', 'Other Province, Other Province, Foreign Country, Foreign Country', '2024-12-30 10:07:49', 4, 2, 2, 0, 0, 2, 2),
(114, 128, 'Hshds, Hdhdhdhd, Udhdhd, Udhdhdhd, Hdhdhdhd', 'Male, Male, Male, Male, Male', 'This City/Municipality, This City/Municipality, This City/Municipality, This City/Municipality, This City/Municipality', '2024-12-30 10:09:03', 5, 5, 0, 5, 0, 0, 0),
(115, 128, 'Rev Smith, Rev Smith, Rev Smith, Rev Smith', 'Male, Female, Male, Female', 'This City/Municipality, This City/Municipality, Other City/Municipality, Other City/Municipality', '2024-12-30 10:20:43', 4, 2, 2, 2, 2, 0, 0),
(116, 128, 'Rev Smith, Rev Smith, Rev Smith, Rev Smith', 'Male, Male, Female, Female', 'Other Province, Other Province, Other Province, Other Province', '2024-12-30 10:21:27', 4, 2, 2, 0, 0, 4, 0),
(117, 128, 'Jolina, Kalojs', 'Female, Male', 'Foreign Country, Other City/Municipality', '2024-12-31 02:28:50', 2, 1, 1, 0, 1, 0, 1),
(118, 128, 'Jskd, Udhdjd, Jdjdjd, Udjsjs, Hdhdjd', 'Female, Male, Female, Female, Male', 'Other Province, This City/Municipality, Other City/Municipality, Foreign Country, Foreign Country', '2024-12-31 02:30:17', 5, 2, 3, 1, 1, 1, 2),
(119, 128, 'Xnxnz, Udjdhd', 'Female, Female', 'This City/Municipality, This City/Municipality', '2024-12-31 03:12:22', 2, 0, 2, 2, 0, 0, 0);

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
(63, 'Ime', '', 'Villiar', '+633924234623', 'krms5r8i@duckmail.club', '2024-10-03 06:19:56', 'Rejected', '66fe42d833585-photo_6305211990431352169_y.jpg', '2026-01-03', NULL, 1, 'REF-66FE378C', 0, 0, 0, 0, NULL, 0),
(64, 'John Rev', '', 'Baliton', '+638237642738', 'tura6s6h@duckmail.club', '2024-10-03 07:10:52', 'Rejected', '66fe44527e4d5-PLSP logo.png', '2025-09-03', NULL, 1, 'REF-66FE437C', 0, 0, 0, 0, NULL, 0),
(65, 'Marko', '', 'Pornasa', '+633684672345', 'markopornasa99@shurua.xyz', '2024-10-03 07:18:03', 'Approved', '66fe476299f21-ITS 2005.png', '2027-09-03', NULL, 0, 'REF-66FE452B', 0, 0, 0, 0, NULL, 0),
(66, 'Jowell', '', 'Molina', '+632637812361', 'joeillmolinas87@shurua.xyz', '2024-10-03 07:56:02', 'Pending', '66fe55a0bba37-CCST Logo.png', '2027-09-01', NULL, 0, 'REF-66FE4E12', 1, 0, 0, 0, NULL, 0),
(67, 'Jholiver', '', 'Boctil', '+639023489234', 'jholiverboctiliu890@shurua.xyz', '2024-10-03 09:39:14', 'Pending', '66fe664278988-CCST Logo.png', '2025-10-01', NULL, 0, 'REF-66FE6642', 1, 0, 0, 0, NULL, 0),
(68, 'Angelo', '', 'Manalo', '+637823467823', 'angelomanalo87872@shurua.xyz', '2024-10-03 09:55:17', 'Pending', '66fe6a05cfc99-CCST Logo.png', '2025-09-03', NULL, 0, 'REF-66FE6A05', 1, 0, 0, 0, NULL, 0),
(69, 'Erish', '', 'Ibias', '+633926742783', 'erishibias87@shurua.xyz', '2024-10-03 10:00:40', 'Pending', '66fe6b4884080-CCST_Council_Logo (1).png', '2025-01-04', NULL, 0, 'REF-66FE6B48', 1, 0, 0, 0, NULL, 0),
(70, 'Manila', '', 'Zoo', '+637823467823', 'manilazoo976@shurua.xyz', '2024-10-03 10:06:49', 'Pending', '66fe6cb94a1eb-CCST_Council_Logo (1).png', '2025-01-03', NULL, 0, 'REF-66FE6CB9', 1, 0, 0, 0, NULL, 0),
(71, 'Karen', '', 'Agapay', '+638236747826', 'karenagayaoi87@shurua.xyz', '2024-10-03 10:08:31', 'Pending', '66fe6d1f02b04-ITS 2005.png', '2025-09-03', NULL, 0, 'REF-66FE6D1F', 1, 0, 0, 0, NULL, 0),
(72, 'Doglas', '', 'Arthur', '+632364783462', 'doglasarthur87@shurua.xyz', '2024-10-03 10:18:10', 'Pending', '66fe6f626dff1-CCST Logo.png', '2026-12-09', NULL, 0, 'REF-66FE6F62', 1, 0, 0, 0, NULL, 0),
(73, 'Robin', '', 'Batumbakal', '+633784623784', 'robinbatumbakal87@shurua.xyz', '2024-10-03 10:25:34', 'Pending', '66fe711ebf472-CCST_Council_Logo (1).png', '2025-09-09', NULL, 0, 'REF-66FE711E', 1, 0, 0, 0, NULL, 0),
(74, 'Robin', '', 'Padilla', '+631287361278', 'robinpadillau76@shurua.xyz', '2024-10-03 10:33:22', 'Rejected', '66fe72f2acdaf-PLSP logo.png', '2026-09-09', NULL, 1, 'REF-66FE72F2', 1, 0, 0, 0, NULL, 0),
(75, 'Makhil', '', 'Sila', '+637891236437', 'makhilsila87@shurua.xyz', '2024-10-03 10:36:31', 'Approved', '66fe73afb6b10-photo_6305211990431352169_y (2).jpg', '2026-09-09', NULL, 0, 'REF-66FE73AF', 1, 0, 0, 0, NULL, 0),
(76, 'Pahiyang', '', 'Kanaman', '+637823634783', 'pahiyangkanaman87@shurua.xyz', '2024-10-03 10:41:05', 'Approved', '66fe74c1ecc4e-photo_6305211990431352169_y (2).jpg', '2026-09-09', NULL, 0, 'REF-66FE74C1', 1, 0, 0, 0, NULL, 0),
(77, 'Rigor', '', 'Dimagiba', '+632376487236', 'rigordimagiba87@shurua.xyz', '2024-10-03 10:50:51', 'Approved', '66fe770bcbfb8-photo_6305211990431352169_y (2).jpg', '2026-09-09', NULL, 0, 'REF-66FE770B', 1, 0, 0, 0, NULL, 0),
(78, 'Jasper', '', 'Bibon', '+633789246327', 'jasperbibon@shurua.xyz', '2024-10-03 14:22:02', 'Approved', '66fea88aa31ed-bgggg.jpg', '2029-09-09', NULL, 0, 'REF-66FEA88A', 1, 0, 0, 0, NULL, 0),
(79, 'Mijay', '', 'Silog', '+637123642783', 'mijaysilog@shurua.xyz', '2024-10-03 14:38:34', 'Approved', '66feaed53b36a-IS CLUB.png', '2026-01-07', NULL, 0, 'REF-66FEAC6A', 1, 0, 0, 0, NULL, 0),
(80, 'Lenie', '', 'Rob', '+632387468123', 'lenierob@shurua.xyz', '2024-10-04 15:34:08', 'Approved', '67000af08c0b5-Size Information.png', '2025-09-09', NULL, 0, 'REF-67000AF0', 1, 0, 0, 0, NULL, 0),
(81, 'Marlou', '', 'Sinag', '+633247474799', 'ri55fin3@duckmail.club', '2024-10-05 10:36:07', 'Approved', '670117c9872b2-Graduation new honors_page-0001.jpg', '2026-09-09', NULL, 0, 'REF-67011697', 1, 0, 0, 0, NULL, 0),
(82, 'Mang', '', 'Kanor', '+638923745892', '669ia3yl@duckmail.club', '2024-10-06 08:33:49', 'Approved', '67024c15a96c9-pattern vp coco.jpeg', '2025-09-09', NULL, 0, 'REF-67024B6D', 1, 0, 0, 0, NULL, 0),
(83, 'Whamoz', '', 'Cruz', '+639832749238', 'bomex7yy@duckmail.club', '2024-10-06 08:57:54', 'Pending', '6702511299f97-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-67025112', 1, 0, 0, 0, NULL, 0),
(84, 'Lenie', '', 'Robredo', '+639287412893', '6s3w0cmz@duckmail.club', '2024-10-07 15:05:23', 'Pending', '6703f8b3bf731-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-6703F8B3', 1, 0, 0, 0, NULL, 0),
(86, 'Kiko', '', 'Pangilinan', '+633248723647', 'vq9ltr4y@duckmail.club', '2024-10-07 15:11:51', 'Pending', '6703fa37d9db6-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-6703FA37', 1, 0, 0, 0, NULL, 0),
(87, 'Naruto ', '', 'Shipuden', '+639382748923', 'mxhuhhvb@duckmail.club', '2024-10-07 15:18:47', 'Pending', '6703fbd797030-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-6703FBD7', 1, 0, 0, 0, NULL, 0),
(88, 'Manyaman', '', 'Keni', '+638236478326', 'rzdgx54k@duckmail.club', '2024-10-07 15:25:49', 'Pending', '6703fd7d338a8-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-6703FD7D', 1, 0, 0, 0, NULL, 0),
(89, 'Json', '', 'Pahirap', '+637892347982', 'lidalihl@duckmail.club', '2024-10-07 15:30:09', 'Pending', '6703fe81b4807-pattern vp coco.jpeg', '2025-09-09', NULL, 0, 'REF-6703FE81', 1, 0, 0, 0, NULL, 0),
(90, 'Santrix', '', 'Tv', '+633784623784', 'dp2wt4lk@duckmail.club', '2024-10-07 15:50:27', 'Pending', '670403436e26e-pattern vp coco.jpeg', '2025-09-09', NULL, 0, 'REF-67040343', 1, 0, 0, 0, NULL, 0),
(97, 'Anshe', '', 'Manalo', '+639823745238', 'xplw50cc@duckmail.club', '2024-10-07 16:13:51', 'Pending', '670408bf3a661-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-670408BF', 1, 0, 0, 0, NULL, 0),
(98, 'Robin', '', 'Padilla', '+639387452893', 'jiijxxtp@duckmail.club', '2024-10-07 16:25:01', 'Rejected', '67040b5d733b2-pattern vp coco.jpeg', '2025-09-09', NULL, 1, 'REF-67040B5D', 1, 0, 0, 0, NULL, 0),
(99, 'Loreto', '', 'Manalo', '+638376482374', 'loretomanalo@shurua.xyz', '2024-10-09 01:49:41', 'Approved', '6705e13599ccd-pattern vp coco.jpeg', '2025-09-09', NULL, 0, 'REF-6705E135', 1, 0, 0, 0, NULL, 0),
(100, 'Aldwin', '', 'Flores', '+637216341278', '4rm9canf@duckmail.club', '2024-10-10 08:51:03', 'Approved', '6707957716db8-pool.jpeg', '2025-09-09', NULL, 0, 'REF-67079577', 0, 0, 0, 0, NULL, 0),
(101, 'Lauren', '', 'Swelba', '+637823647823', 'lsq9a1zt@duckmail.club', '2024-10-10 09:44:30', 'Rejected', '6707b30875981-pool.jpeg', '2025-09-09', NULL, 1, 'REF-6707A1FE', 1, 1, 0, 0, NULL, 0),
(102, 'Jasper', '', 'Bibon', '+632387462387', 'jogqlb38@duckmail.club', '2024-10-10 10:58:47', 'Pending', '6707b367a6efd-pattern vp coco.jpeg', '2025-09-09', NULL, 0, 'REF-6707B367', 1, 0, 0, 0, NULL, 0),
(103, 'Julisa', '', 'Rosales', '+637823647823', 'uueevdrn@duckmail.club', '2024-10-10 11:30:28', 'Pending', '6707d1e7a0c1e-pool.jpeg', '2025-09-09', NULL, 0, 'REF-6707BAD4', 1, 1, 0, 0, NULL, 0),
(104, 'John Angel', '', 'Locsin', '+637832647823', 'dasehidq@duckmail.club', '2024-10-10 14:34:01', 'Approved', '6707e5d9dba99-CLAMDev (1).png', '2026-09-09', NULL, 0, 'REF-6707E5D9', 1, 0, 0, 0, NULL, 0),
(105, 'Boy', '', 'Abunda', '+637836427834', 'lp0m1d4f@duckmail.club', '2024-10-10 16:26:57', 'Pending', '67080051d83bc-pool.jpeg', '2026-09-09', NULL, 0, 'REF-67080051', 1, 0, 0, 0, NULL, 0),
(106, 'Jose', '', 'Lapid', '+632472914789', 'whdw2uyt@duckmail.club', '2024-10-11 10:17:47', 'Approved', '6708fb8cdb501-pattern vp coco.jpeg', '2026-09-09', NULL, 0, 'REF-6708FB4B', 1, 1, 0, 0, NULL, 0),
(107, 'Jomar ', '', 'Silog', '+637893456347', 't43l3so0@duckmail.club', '2024-10-14 02:27:32', 'Approved', '670c8194701d2-pattern vp coco.jpeg', '2025-09-09', NULL, 0, 'REF-670C8194', 1, 0, 0, 0, NULL, 0),
(108, 'Jolibog', '', 'Silog', '+633764237423', '4tztcwbj@duckmail.club', '2024-10-14 05:33:47', 'Approved', '670cad3bb5dff-pattern vp coco.jpeg', '2025-01-01', NULL, 0, 'REF-670CAD3B', 1, 0, 0, 0, NULL, 0),
(109, 'Keny', '', 'Smith', '+639382579278', 'iq7eej58@duckmail.club', '2024-10-14 07:23:04', 'Approved', '670cc77c1d75b-resort-landscape-design.jpg', '2025-01-01', NULL, 0, 'REF-670CC6D8', 1, 1, 0, 0, NULL, 0),
(110, 'Bago', '', 'Panganak', '+639732984792', '70f2pmax@duckmail.clu', '2024-11-02 22:31:38', 'Approved', '6726a84a17f5c-QRCode (3).png', '2025-01-01', NULL, 0, 'REF-6726A84A', 1, 0, 0, 0, NULL, 0),
(111, 'Hannabi', '', 'Manlababi', '+633746237842', 'vn3rbhp9@duckmail.club', '2024-11-02 22:42:31', 'Approved', '6726aad7c8d38-QRCode (3).png', '2025-01-01', NULL, 0, 'REF-6726AAD7', 0, 0, 0, 0, NULL, 0),
(112, 'Trial', '', 'Testing', '+638974892174', '037j7xo4@duckmail.club', '2024-11-02 22:43:55', 'Approved', '6726ab2b3e73f-QRCode (3).png', '2025-09-09', NULL, 0, 'REF-6726AB2B', 0, 0, 0, 0, NULL, 0),
(113, 'Test', '', 'Unit', '+633782647823', '8uz384bp@duckmail.club', '2024-11-02 23:17:12', 'Approved', '6726b2f822010-QRCode (3).png', '2025-01-04', NULL, 0, 'REF-6726B2F8', 1, 0, 0, 0, NULL, 0),
(114, 'gatotkatcha', '', 'asiud', '+634534543543', 'k463smrl@duckmail.club', '2024-11-02 23:32:15', 'Approved', '6726b67f2f6e0-QRCode (3).png', '2025-09-09', NULL, 0, 'REF-6726B67F', 0, 0, 0, 0, NULL, 0),
(115, 'Karmila', '', 'Malabmot', '+637832647823', '0tt17dbp@duckmail.club', '2024-11-02 23:44:25', 'Approved', '6726b959cb5ec-QRCode (3).png', '2025-09-09', NULL, 0, 'REF-6726B959', 1, 0, 0, 0, NULL, 0),
(116, 'kaligaod', '', 'asdhas', '+639823749823', 'ghro15z3@duckmail.club', '2024-11-02 23:48:54', 'Approved', '6726ba6600c13-QRCode (3).png', '2025-09-09', NULL, 0, 'REF-6726BA66', 0, 0, 0, 0, NULL, 0),
(117, 'magkano', '', 'sila', '+632389745389', 'magkanosila98@shurua.xyz', '2024-11-02 23:58:34', 'Approved', '6726bcaa0f160-QRCode (3).png', '2025-09-09', NULL, 0, 'REF-6726BCAA', 0, 0, 0, 0, NULL, 0),
(118, 'Ako', '', 'Simon', '+633278462783', 'akosimon87@shurua.xyz', '2024-11-03 00:03:29', 'Approved', '6726bdd12bf70-QRCode (3).png', '2025-09-09', NULL, 0, 'REF-6726BDD1', 0, 0, 0, 0, NULL, 0),
(119, 'Batol ', '', 'Delarosa', '+638923479283', 'batodelarosa98@shurua.xyz', '2024-11-07 21:14:37', 'Approved', '672d2dbd0df14-QRCode (4).png', '2025-01-01', NULL, 0, 'REF-672D2DBD', 0, 0, 0, 0, NULL, 0),
(120, 'Joel', '', 'Cruz', '+638934789237', 'joelcruz908@shurua.xyz', '2024-11-12 01:42:57', 'Rejected', '6732b2a162ba1-tatlo.jpg', '2025-01-01', NULL, 1, 'REF-6732B2A1', 1, 0, 0, 0, NULL, 0),
(121, 'Japiyukizz', '', 'Karne', '+638937462378', 'japiyukiopisd98@shurua.xyz', '2024-11-12 03:08:19', 'Approved', '6732c6a3073a4-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6732C6A3', 0, 0, 0, 0, NULL, 0),
(122, 'Pokwang', '', 'Boang', '+639237864728', 'pokwangboang98@shurua.xyz', '2024-11-12 03:39:45', 'Approved', '6732ce01d33c5-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6732CE01', 1, 0, 0, 0, NULL, 0),
(123, 'Mavs', '', 'Phone', '+637923647823', 'mavsphonekj98@shurua.xyz', '2024-11-12 05:47:09', 'Approved', '6732ebdd66157-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6732EBDD', 0, 0, 0, 0, NULL, 0),
(124, 'Jhon', '', 'Castillio', '+637821634781', 'ajkshd897@shurua.xyz', '2024-11-12 05:52:33', 'Approved', '6732ed21bea62-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6732ED21', 0, 0, 0, 0, NULL, 0),
(125, 'Saara ', '', 'herrera', '+637812367812', 'saaraherrerajh87@shurua.xyz', '2024-11-12 05:59:50', 'Approved', '6732eed614f0e-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6732EED6', 0, 0, 0, 0, NULL, 0),
(126, 'Timothy', '', 'Diolala', '+637812648712', 'TimothyDiolala234@shurua.xyz', '2024-11-12 06:02:33', 'Approved', '6732ef78f3f3e-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6732EF79', 0, 0, 0, 0, NULL, 0),
(127, 'Jeol', '', 'Sigfred', '+639237649238', 'joelsigfredd98@shurua.xyz', '2024-11-12 07:18:28', 'Approved', '67330143f4143-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-67330144', 0, 0, 0, 0, NULL, 0),
(128, 'Mario', '', 'Tupar', '+632378462378', 'mariotupar76@shurua.xyz', '2024-11-14 13:22:43', 'Approved', '6735f9a32f856-tatlo.jpg', '2025-01-01', NULL, 0, 'REF-6735F9A3', 0, 0, 0, 0, NULL, 0),
(129, 'Palya', '', 'kalaoi', '+639823748923', 'palyadoi97@shurua.xyz', '2024-11-14 16:50:53', 'Rejected', '67362a6d9f728-daaya.jpg', '2025-09-09', NULL, 1, 'REF-67362A6D', 0, 0, 0, 0, NULL, 0),
(130, 'Angelors', '', 'Manalo', '+633764237864', 'angelorsmanalo98@shurua.xyz', '2024-11-18 10:39:28', 'Approved', '673b1960c79f6-daaya.jpg', '2025-01-01', NULL, 0, 'REF-673B1960', 0, 0, 0, 0, NULL, 0),
(131, 'John Cyril', '', 'Arganosa', '+639823748932', 'johncyrilarganosa12@shurua.xyz', '2024-11-19 06:41:57', 'Approved', '673c34655c2ef-dalawa.jpg', '2025-01-01', NULL, 0, 'REF-673C3335', 1, 1, 0, 0, NULL, 0),
(132, 'Amang ', '', 'Pulo', '+631234324234', 'nbsad7896@shurua.xyz', '2024-11-20 06:43:54', 'Pending', '673d852acdcbc-QRCode (5).png', '2025-01-01', NULL, 0, 'REF-673D852A', 1, 0, 0, 0, NULL, 0),
(133, 'Nein', '', 'Chen', '+639065417074', 'eaanives04@gmail.com', '2024-12-17 07:13:30', 'Approved', '6761249a2096e-20241223-FB_IMG_1733835948751.jpg', '2025-12-31', NULL, 0, 'REF-6761249A', 1, 0, 0, 1, NULL, 0),
(139, 'John', '', 'Alcohol', '+633289573293', 'johnalcohol@shurua.xyz', '2024-12-20 10:20:02', 'Approved', '676544d22cb73-cps6.png', '2024-12-31', NULL, 0, 'REF-676544D2', 0, 0, 1, 0, NULL, 0),
(140, 'Pulso', '', 'Saya', '+633523523523', 'pulsosaya@shurua.xyz', '2024-12-21 03:08:32', 'Approved', '67663130df9fc-emaillogo.png', '2024-12-31', NULL, 0, 'REF-67663130', 1, 0, 1, 0, NULL, 0),
(141, 'Kape', '', 'Lomi', '+639623796423', 'kapelomi@shurua.xyz', '2024-12-21 08:05:09', 'Approved', '676676b5eee9b-20241221-emaillogo.png', '2024-12-30', NULL, 0, 'REF-676676B5', 0, 0, 0, 0, NULL, 0),
(142, 'Aurora', '', 'Marabe', '+639823748923', 'auroramarabe@shurua.xyz', '2024-12-21 13:20:07', 'Pending', '6766c08719af4-20241221-QRCode (1).png', '2024-12-31', NULL, 0, 'REF-6766C087', 1, 0, 0, 0, NULL, 0),
(144, 'Joy', '', 'Perez', '+638927364712', 'joyperez00@shurua.xyz', '2024-12-22 10:11:35', 'Approved', '6767e5d7165d6-20241222-daaya.jpg', '2024-12-31', '2025-12-31', 0, 'REF-6767E5D7', 1, 0, 1, 0, '2024-12-22', 0),
(145, 'Lumien', '', 'Manalo', '+633276423784', 'lumienmanalo@shurua.xyz', '2024-12-23 02:10:20', 'Approved', '6768c68c89add-20241223-emaillogo.png', '2024-12-31', NULL, 0, 'REF-6768C68C', 1, 0, 1, 0, NULL, 0),
(146, 'Aso', '', 'Manalo', '+639823749837', 'asomanalo@shurua.xyz', '2024-12-23 02:36:22', 'Approved', '6768cca61d70c-20241223-emaillogo.png', '2022-12-31', NULL, 0, 'REF-6768CCA6', 1, 0, 1, 0, NULL, 0),
(147, 'Inhaler', '', 'Manalo', '+639823748923', 'inhalermanalo@shurua.xyz', '2024-12-23 06:47:41', 'Approved', '6769078d593a1-20241223-Marabe_JordanRae.jpg', '2025-12-31', NULL, 0, 'REF-6769078D', 1, 0, 0, 1, NULL, 0),
(148, 'John Trie', '', 'Sistine', '+639585588574', '1k2t7r70@duckmail.club', '2024-12-23 10:40:40', 'Approved', '67693e284b72e-20241223-images (1).jpeg', '2025-12-31', NULL, 0, 'REF-67693E28', 1, 0, 0, 0, NULL, 0),
(149, 'Solomon', '', 'Grundy', '+639828736391', 'taytayfalls@duckmail.club', '2024-12-23 11:26:06', 'Approved', '676948cdf3259-20241223-images (1).jpeg', '2024-12-31', NULL, 0, 'REF-676948CE', 1, 0, 1, 0, NULL, 0),
(150, 'Artoria', '', 'Pendragon', '+639817265522', 'latriccia@duckmail.club', '2024-12-23 12:43:31', 'Approved', '67695af3d3f1c-images (1).jpeg', '2025-12-31', NULL, 0, 'REF-67695AF3', 1, 0, 0, 1, NULL, 0),
(151, 'Shirou', '', 'Emiya', '+639272769908', 'dalitawan@duckmail.club', '2024-12-23 13:00:19', 'Approved', '67695ee365807-20241223-images (2).jpeg', '2025-12-31', NULL, 0, 'REF-67695EE3', 0, 0, 0, 0, NULL, 0),
(152, 'John Tree', '', 'Sistine', '+639727276990', 'lasfamilias@duckmail.club', '2024-12-23 13:05:27', 'Approved', '67696017bb4db-20241223', '2025-12-31', NULL, 0, 'REF-67696017', 1, 0, 0, 1, NULL, 0),
(153, 'Peter', '', 'Parking', '+639123456789', 'goyamalinao@duckmail.club', '2024-12-23 13:17:11', 'Approved', '676962d78b236-20241223', '2025-12-31', NULL, 0, 'REF-676962D7', 1, 0, 0, 1, NULL, 0),
(154, 'Mario', '', 'Kart', '+639277829929', 'boying@duckmail.club', '2024-12-23 13:22:57', 'Approved', '676964318f09d-20241223-download.png', '2025-12-31', NULL, 0, 'REF-67696431', 1, 0, 0, 1, NULL, 0),
(155, 'Donald', '', 'Duck', '+639876543210', 'duck@duckmail.club', '2024-12-23 13:31:40', 'Approved', '6769663ce222e-20241223-download.png', '2025-12-31', NULL, 0, 'REF-6769663C', 1, 0, 0, 1, NULL, 0),
(156, 'John', '', 'Li', '+639946645400', 'morax@duckmail.club', '2024-12-23 13:40:21', 'Approved', '676968457f159-20241223-images (1).jpeg', '2025-12-31', NULL, 0, 'REF-67696845', 1, 0, 0, 1, NULL, 0),
(157, 'Mash', '', 'Kyrielight', '+639988776655', 'chaldea@duckmail.club', '2024-12-23 14:19:17', 'Approved', '6769716592a48-20241223-download.png', '2025-12-31', NULL, 0, 'REF-67697165', 1, 0, 0, 1, NULL, 0),
(158, 'Furina', '', 'Focalors', '+639112233445', 'favonius@duckmail.club', '2024-12-23 14:27:46', 'Approved', '6769736242786-20241223-download.png', '2024-12-31', '2025-12-31', 0, 'REF-67697362', 1, 0, 1, 0, '2024-12-23', 0),
(159, 'Jenna', '', 'Bond', '+637836874627', 'quj639jd@duckmail.club', '2024-12-24 00:57:31', 'Approved', '676a06fbc751f-20241224-1.png', '2024-12-31', NULL, 0, 'REF-676A06FB', 0, 0, 1, 0, NULL, 0),
(160, 'Juan ', '', 'Tamad', '+638912349167', 'raneukqk@duckmail.club', '2024-12-24 01:59:58', 'Approved', '676a159ec690b-20241225-1.png', '2024-12-31', '2025-12-31', 0, 'REF-676A159E', 0, 0, 1, 0, '2024-12-25', 0),
(161, 'Jose', '', 'Rizal', '+639287730003', 'fontaine@duckmail.club', '2024-12-24 03:04:59', 'Pending', '676a24db97293-20241224-download.png', '2024-12-31', NULL, 0, 'REF-676A24DB', 1, 0, 0, 0, NULL, 0),
(162, 'Uso', '', 'Maligo', '+631929182749', '9fz9lq8z@duckmail.club', '2024-12-24 23:20:11', 'Approved', '676b41abe5ce7-20241225-1.png', '2024-12-31', NULL, 0, 'REF-676B41AB', 0, 0, 1, 0, NULL, 0),
(163, 'Ubok', '', 'Marabe', '+638923749823', 'ubokmarabe@shurua.xyz', '2024-12-26 02:32:35', 'Approved', '676cc04344abc-20241226-1.png', '2023-12-31', NULL, 0, 'REF-676CC043', 1, 0, 0, 0, NULL, 0),
(164, 'Tisoy', '', 'Panget', '+637126478124', 'tisoypanget@shurua.xyz', '2024-12-26 05:57:50', 'Approved', '676cf05e9493b-20241226-1.png', '2025-12-31', NULL, 0, 'REF-676CF05E', 1, 0, 0, 1, NULL, 0),
(165, 'Gerald', '', 'Marabe', '+639723468923', 'geraldmarabe@shurua.xyz', '2024-12-26 06:35:20', 'Approved', '676cf928549c2-20241226-1.png', '2024-12-31', NULL, 0, 'REF-676CF928', 1, 0, 1, 0, NULL, 0),
(166, 'Aike', '', 'Anderson', '+632781641278', 'aikeanderson@shurua.xyz', '2024-12-28 11:41:05', 'Approved', '676fe3d128add-20241228-1.png', '2025-12-31', NULL, 0, 'REF-676FE3D1', 1, 0, 0, 1, NULL, 0),
(167, 'Majayjay ', '', 'Taytay', '+632347862347', 'majayjaytaytay@shurua.xyz', '2024-12-29 02:46:28', 'Approved', '6770b8041c991-20241229-Final pubmats.png', '2025-12-31', NULL, 0, 'REF-6770B804', 1, 0, 0, 1, NULL, 0),
(168, 'James', 'Manalo', 'Yap', '+637823648723', 'jamesyap@shurua.xyz', '2024-12-29 03:24:08', 'Approved', '6770c0d8cfce6-20241229-1.png', '2025-12-31', NULL, 0, 'REF-6770C0D8', 1, 0, 0, 1, NULL, 0),
(169, 'Divine', '', 'Vitasa', '+632321361298', 'devineerikavitasa@gmail.com', '2024-12-29 04:40:19', 'Approved', '6770d2b32dda7-20241229-462573124_1266134101253710_6157056838875988565_n.png', '2025-12-31', NULL, 0, 'REF-6770D2B3', 1, 0, 0, 1, NULL, 0),
(170, 'Mega', '', 'Box', '+637295982759', 'boxmega884@gmail.com', '2024-12-30 03:32:23', 'Approved', '6772144720cc3-20241230-33.jpg', '2025-12-31', NULL, 0, 'REF-67721447', 1, 0, 0, 1, NULL, 0),
(171, 'Ang', '', 'Ingay', '+639837249832', 'angingay@shurua.xyz', '2024-12-30 07:42:45', 'Approved', '67724ef548738-20241230-1.png', '2023-12-31', NULL, 0, 'REF-67724EF5', 0, 0, 1, 0, NULL, 0);

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
(100, 109, 'Keny Resort', '1212 Street, San Isidro, Majayjay, Laguna', 19, '', '+634654654654', 'wala lang'),
(101, 110, 'Bago Panganak Resort', '1212 Street, Gagalot, Majayjay, Laguna', 19, '', '+636378216312', 'buraot hahaha'),
(102, 111, 'Manlababo Habani', '121 Street, Suba, Majayjay, Laguna', 19, '', '+632353252353', 'sadasdsadas asdasdsa'),
(103, 112, 'Trial Testing 1', '121 Street, Talortor, Majayjay, Laguna', 21, '', '+633253525235', 'sddfsdf sdfsdfs'),
(104, 113, 'Tumesting ka resort', '1231 Street, Malinao, Majayjay, Laguna', 19, '', '+632142143463', 'tuaslkjdasd asd'),
(105, 114, 'Gatot Gatcha', '131 Street, Talortor, Majayjay, Laguna', 20, '', '+632423423424', 'sadasd asdasdas'),
(106, 115, 'Malibunay Farm', '121 Street, San Miguel (Poblacion), Majayjay, Laguna', 20, '', '+634363646436', 'malibuy asdas'),
(107, 116, 'Koligaid Sds ', '213 Street, Suba, Majayjay, Laguna', 19, '', '+634643634636', 'dsfsdf sdfsdf sdfs'),
(108, 117, 'Magkano Sila', '1231 Street, Ilayang Banga, Majayjay, Laguna', 19, '', '+633252353252', 'asdasdasdsa'),
(109, 118, 'Sino Kaba', '121 Street, Ibabang Bayucain, Majayjay, Laguna', 20, '', '+632345236243', 'sdasdsadas'),
(110, 119, 'Bato Delarosa Resort', '121 Street, Ilayang Bayucain, Majayjay, Laguna', 19, '', '+634353453453', 'hgjhg hjkgkjhghkjg hjghj gghjghj hjghjg hjg hjgjhgh j'),
(111, 120, 'Joel Cruz Resort', '121 Street, San Miguel (Poblacion), Majayjay, Laguna', 19, '', '+634364363634', 'kdjsbhjsdfgfhsdfsdf sdfsd sdf sdf sdf sdfsd fsdf sdf sdfsd fsdfsd sdfsdf sdffsd fsdf sdfs dfsdfsd fsdfsd fsd fsd fsd fsdfsd sf'),
(112, 121, 'Japiyukizzz', '121 Street, Bakia, Majayjay, Laguna', 19, '', '+634578346578', 'hsgdhas dhjasghjd gashjdgashjgd jasd gjhasgd ashjdgas das dasd asda sd asdas dasda sdasdas'),
(113, 122, 'Pokwang Resort', '121 Street, Isabang, Majayjay, Laguna', 21, '', '+634598437895', 'hjsdkfjsd sdjkhf sdkfhkjsdhf sdf sdf sdfsdf sd'),
(114, 123, 'Mavs Pheno', '1232 Street, Ibabang Banga, Majayjay, Laguna', 19, '', '+634353453453', 'dsfdsfsdfds sd sdfsdfs'),
(115, 124, 'Jhon Bangin', '1231 Strreet, Tanawan, Majayjay, Laguna', 19, '', '+633298472398', 'ksadjkhas asd asdas da'),
(116, 125, 'Saara herrera resort', '236 Street, Talortor, Majayjay, Laguna', 19, '', '+632352352352', 'sdfsdfsdfsdfsd dsf sdfdsfsd'),
(117, 126, 'Timothyy Resoprt', '213 Street, Bakia, Majayjay, Laguna', 19, '', '+632353252352', 'sdasd asdas das asda'),
(118, 127, 'Joel Sigfred Resort', ', Suba, Majayjay, Laguna', 19, '', '+639874398237', 'kjhasd jkahsd kjha sdakjs haskdh askjdhas aksjhd askjh'),
(119, 128, 'Mario Tupar Resort', '2312 Street, San Miguel (Poblacion), Majayjay, Laguna', 19, '', '+632345345433', 'asdasda dasdasd asdsa'),
(120, 129, 'Palksiu Resoret', '131 Streeet, Ilayang Banga, Majayjay, Laguna', 19, '', '+633425623532', 'sadasdasdas sadasdas'),
(121, 130, 'Angelors Manalo Resort', '121 Street, Balanac, Majayjay, Laguna', 19, '', '+634356346346', '3dfsdfsd sdfsdfsdfsd fs'),
(122, 131, 'John Cyril Resort', '1212 Street, Balayong, Majayjay, Laguna', 19, '', '+637834783264', 'asdasd sadsaasdas'),
(123, 132, 'Amang Pulo Resort', '1212 Street, Balanac, Majayjay, Laguna', 19, '', '+632352379562', 'kshdkashdjkas djkashd jksahdjkashdjkas jkashd jkashjkdashjkdash jkhasjkdhasjkdhsajkdhaskjda'),
(124, 133, 'Carayan Resort', 'Lucban Rd., Majayjay, Laguna, Panglan, Majayjay, Laguna', 19, '', '+639065417074', 'Nearby attractions include Hulugan Falls (4.4 km), Taytay Falls (5.6 km), and Nagcarlan Underground Cemetery (6.1 km).'),
(130, 139, 'John Alcohol Resort', '1333131 Street, Ibabang Bayucain, Majayjay, Laguna', 19, '', '+637824657836', 'asdasdasd'),
(131, 140, 'Pulso Saya Resort', '2323 Street Pukls, Gagalot, Majayjay, Laguna', 19, 'pulsosaya9@shurua.xyz', '+631351351351', 'wala lang'),
(132, 141, 'Kape Lomi Resort', 'Banyaman Street 12, Ibabang Banga, Majayjay, Laguna', 19, 'kapelomi@shurua.xyz', '+638976279846', 'wala lang ito hahah an ka ba ahaha'),
(133, 142, 'Aurora Resort', '121 Street, Coralao, Majayjay, Laguna', 19, 'asdasds@gmail.com', '+632343242342', 'sdasdasdas'),
(135, 144, 'Perez Resort', 'Perez87 Street, Balayong, Majayjay, Laguna', 19, '', '+631245125125', 'wala na finish na hahahah'),
(136, 145, 'Lumien Resort', '1312 Street San Pedro, Ilayang Banga, Majayjay, Laguna', 19, 'lumienmanalo@shurua.xyz', '+637216478216', 'punta na kayo dali hahaha'),
(137, 146, 'Aso Manalo Resort', '1312 Street, Ibabang Bayucain, Majayjay, Laguna', 19, 'asomanalo@shurua.xyz', '+637823467823', 'punta na kayoo'),
(138, 147, 'Inhaler Resort', '23123 Street, San Roque, Majayjay, Laguna', 19, '', '+638947589375', 'punta kayo ?'),
(139, 148, 'Hilarion&#039;s Farm', 'Lucban Rd., Ilayang Banga, Majayjay, Laguna', 20, '1k2t7r70@duckmail.club', '+639575774333', 'About the Accommodation\r\nLocation\r\nHilarions Farm is located in area / city Majayjay.\r\n\r\nThere are plenty of tourist attractions nearby, such as Pagsawitan Elementary School within 14.75 km, and CBK Power Company Limited within 19 km.\r\n\r\nAbout Hilarions Farm\r\n\r\nHilarions Farm is highly recommended for backpackers who want to get an affordable stay yet comfortable'),
(140, 149, 'Taytay Falls', ', Taytay, Majayjay, Laguna', 21, '', '+639287373633', 'Taytay falls is 10-15 meters high waterfalls is located along the Dalitiwan River in Brgy. Taytay, Majayjay, Laguna. It has clear and cool water that falls in 1,000 sq. m. river channel area. Its surrounding is vegetated with various wild plants and trees. A natural Falls with irrigation on its'),
(141, 150, 'Latriccia&#039;s Resort', 'Purok 5, Piit, Majayjay, Laguna', 19, '', '+639727262542', 'Restaurant and Events Place. Purok 5 Brgy. Piit, Majayjay Laguna. Call us at 09171332240 or message us.'),
(142, 151, 'Dalitawan Resort', 'Lucban Rd., Ilayang Banga, Majayjay, Laguna', 19, '', '+639757829766', 'About 3 hours drive from Makati, the resort I can say can still improve its amenities but still, my family and I enjoyed our day tour. '),
(143, 152, 'Las Familias', 'Lucban Rd., Ilayang Banga, Majayjay, Laguna', 19, '', '+639776218900', 'Realtime driving directions to Las Familias Resort, Lucban Road, Majayjay, based on live traffic updates and road conditions'),
(144, 153, 'Goya Malinao', 'Lucban Rd., Ilayang Banga, Majayjay, Laguna', 19, '', '+639123456789', 'Realtime driving directions to Las Familias Resort, Lucban Road, Majayjay, based on live traffic updates and road conditions.'),
(145, 154, 'Boying', '123, Ilayang Banga, Majayjay, Laguna', 19, '', '+639272829008', 'The quick brown fox jumps over the lazy dog.'),
(146, 155, 'Duck Farm', 'Food, Villa Nogales, Majayjay, Laguna', 20, '', '+639876543210', 'The quick brown fox jumps over the lazy dog.'),
(147, 156, 'Wangshen FP', 'Liyue, Oobi, Majayjay, Laguna', 19, '', '+639946645400', 'It is just good business.'),
(148, 157, 'Chaldea Resort &amp; Restaurant', 'Magallanes, May-It, Majayjay, Laguna', 19, '', '+639988776655', '?'),
(149, 158, 'Favonius Resort', 'Mondstadt, Olla, Majayjay, Laguna', 19, '', '+639112233445', 'Oratice Mechanique D&#039;Analyse Cardinale'),
(150, 159, 'Jenna Resort', '23312 Street, Bakia, Majayjay, Laguna', 19, '', '+633252352353', 'hahahha'),
(151, 160, 'Juan Tamad Resort', '121 Tamad Street, Ibabang Banga, Majayjay, Laguna', 19, '', '+631274612678', 'Waka'),
(152, 161, 'Fontaine Resort', 'P-1, San Isidro, Majayjay, Laguna', 19, '', '+639028773800', 'Maximum of 50 words'),
(153, 162, 'Uso Maligo Resort', '1212 Street, Ibabang Bayucain, Majayjay, Laguna', 19, '', '+633551254215', 'aba ay uso naman matulog hajhjahjasdas asdasda'),
(154, 163, 'Ubok Resort Lakas', '12312 Street, Balanac, Majayjay, Laguna', 19, 'ubokmaster98@shurua.xyz', '+631241241241', 'wala na '),
(155, 164, 'Tisoy Panget Resort', '213123 Street, Botocan, Majayjay, Laguna', 19, '', '+633256237852', 'aba wala naman'),
(156, 165, 'Gerald Marabe Resort', '1212 Street, Balayong, Majayjay, Laguna', 19, '', '+637834623874', 'aba naman magtigil ka hahahah '),
(157, 166, 'Aike Resort', '232 Street, Coralao, Majayjay, Laguna', 19, 'aikeanderson@shurua.xyz', '+637821367812', 'Punta na kayo dito hehehe'),
(158, 167, 'Majayjay Taytay Resort', '123 Street, San Roque, Majayjay, Laguna', 19, 'majayjayresort@shurua.xyz', '+638923748923', 'Punta na kayo dito hahahaha'),
(159, 168, 'James Yap Resort', '1231 Street, Pook, Majayjay, Laguna', 19, 'jamesyap@shurua.xyz', '+633252353223', 'maganda ito hahhaha'),
(160, 169, 'Hilarions&#039; Farm', '12372 yewuew, Ilayang Banga, Majayjay, Laguna', 20, '', '+638721381273', 'halika na dito'),
(161, 170, 'Megabox Resort', 'Megabox street, Amonoy, Majayjay, Laguna', 19, '', '+637236487326', 'arat swimming'),
(162, 171, 'Ang Ingay Resort', '121 Street, Suba, Majayjay, Laguna', 19, 'angingayresort@shurua.xyz', '+639126798127', 'kjashdaksjhdasdasda');

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
(91, 159, 107, 1),
(92, 159, 108, 1),
(93, 119, 107, 0),
(94, 161, 107, 1),
(95, 161, 108, 1),
(96, 162, 108, 1);

-- --------------------------------------------------------

--
-- Table structure for table `business_media`
--

CREATE TABLE `business_media` (
  `MediaID` int(11) NOT NULL,
  `BusinessInfoID` int(11) DEFAULT NULL,
  `Thumbnail` varchar(255) NOT NULL,
  `Quotation` text NOT NULL,
  `Image1` varchar(255) NOT NULL,
  `Image2` varchar(255) NOT NULL,
  `Image3` varchar(255) NOT NULL,
  `Image4` varchar(255) NOT NULL,
  `Image5` varchar(255) NOT NULL,
  `Image6` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `barangayId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_media`
--

INSERT INTO `business_media` (`MediaID`, `BusinessInfoID`, `Thumbnail`, `Quotation`, `Image1`, `Image2`, `Image3`, `Image4`, `Image5`, `Image6`, `isActive`, `barangayId`) VALUES
(11, 79, '6705dce2c8c57.jpg', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...&#34;', '6705bf2b5ffe6.png', '6705bf2cb8b26.png', '6705bf2dd461a.png', '6705bf2e21783.png', '6705bf2e727b9.png', '6705bf2e876c7.png', 1, NULL),
(12, 90, '6705e1f9868bb.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam bibendum sit amet libero non volutpat. Mauris pretium dignissim porta. Vestibulum aliquet imperdiet enim, hendrerit placerat metus mattis vel. Aenean luctus.', '6705e1f9b5b3c.jpeg', '6705e1f9c8279.jpeg', '6705e1f9d7c95.jpeg', '6705e1f9e46d2.jpeg', '6705e1f9f3807.jpeg', '6705e1fa0c5a6.jpeg', 1, NULL),
(13, 95, '6707e7d07b75e.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin finibus sollicitudin eros sit amet egestas. Curabitur ut dolor quis sapien condimentum gravida tincidunt ac elit.', '6707e7d117d37.jpg', '6707e7d14bcd2.jpg', '6707e7d179e8c.jpg', '6707e7d19e96b.jpg', '6707e7d1bc494.jpg', '6707e7d1d5cbe.jpg', 1, NULL),
(14, 97, '6708feb04f2eb.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ante lobortis, sodales arcu eget, eleifend velit. Aenean congue suscipit orci, vitae vestibulum sapien rutrum et. Integer eleifend hendrerit urna.', '6708ff5a04a61.jpg', '6708feb09e392.jpg', '6708feb0c0f62.jpg', '6708feb0ed0dd.jpg', '6708feb121d45.jpg', '6708feb13f48f.jpg', 1, NULL),
(17, 100, '670cc8922c0d3.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam elementum dictum tempus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque at egestas risus, in gravida.', '670cc89251d14.jpeg', '670cc89263f30.jpg', '670cc89277fe9.jpg', '670cc8927e56b.jpeg', '670cc8927fd94.jpg', '670cc892dc25f.jpg', 1, NULL),
(18, 119, '676f579d1e926.jpeg', 'punta na kayo dito hahaha dali', '673d562c05397.webp', '673d562c4e816.jpg', '673d562c5813e.jpg', '673d562c681d7.jpg', '673d562c79959.jpg', '673d562c8ea66.jpg', 1, NULL),
(19, 124, '676126de89313.jpg', 'Piliin mo ang Carayan!', '676126dea49d2.jpg', '676126dea7f7b.jpg', '676126deab358.jpg', '676126deae3f7.jpg', '676126deb1247.jpg', '676132b101116.jpg', 1, NULL),
(20, 136, '6768c96d2f774.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu efficitur mauris. Duis luctus faucibus sem, non tristique nisi accumsan.', '6768c8587fa98.jpg', '6768c858993ed.jpg', '6768c858bcef5.jpg', '6768c858e07cf.jpg', '6768c85915b0b.jpg', '6768c8591ed52.jpg', 1, NULL),
(21, 137, '6768cdfbb1b72.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu efficitur mauris. Duis luctus faucibus sem, non tristique nisi accumsan.', '6768cdeb259ab.jpg', '6768cdeb2eb26.jpg', '6768cdeb3a84e.jpg', '6768cdeb48aea.jpg', '6768cdeb562e7.jpg', '6768cdeb5e219.jpg', 0, NULL),
(22, 139, '6769434ae3022.jpg', 'For you, travelers who wish to travel comfortably on a budget, Hilarions Farm is the perfect place to stay that provides decent facilities as well as great services.', '6769434b0f59a.jpg', '6769434b19fe8.jpg', '6769434b2112c.jpg', '6769434b26ff8.jpg', '6769434b2ddea.jpg', '6769434b357a8.jpg', 1, NULL),
(23, 155, '676cf21ba4c5a.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean pharetra quis arcu id malesuada. Aenean tincidunt lorem in ultrices venenatis. Duis a porta nisi, at cursus urna. Fusce eleifend commodo.', '676cf21bc4029.jpg', '676cf21bc798e.jpg', '676cf21bd37ea.jpg', '676cf21bd8a53.jpg', '676cf21bdc587.png', '676cf21f2169f.jpg', 1, NULL),
(24, 158, '6770ba0ebd876.jpg', 'maganda dito punta na kayo haha', '6770ba0ed41f5.jpg', '6770ba0ed742a.jpg', '6770ba0eda5db.jpg', '6770ba0edd604.jpg', '6770ba0edff8c.png', '6770ba114ba8a.jpg', 1, NULL),
(25, 159, '6770c376693cd.png', 'maganda itoo punta na kayo', '6770c3e42edd5.jpg', '6770c3770b241.png', '6770c3775c031.png', '6770c377b1df6.png', '6770c37b1b8ad.png', '6770c37b5631d.png', 1, NULL),
(41, NULL, '6774ecc666755.png', 'aaaaa', '6773a11c0e32a.jpg', '6773a11c0e605.jpg', '6773a11c0e7fb.jpg', '6773a11c0ea19.jpg', '6773a11c0f146.jpg', '6773a11c0f369.png', 1, 21);

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
(108, 'Garden'),
(107, 'Pool');

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
(1, 'Majayjay, Laguna is a charming rural town nestled at the foot of Mt. Banahaw, renowned for its stunning natural beauty, including the iconic Taytay Falls. With its cool climate, historical churches, and lush greenery, Majayjay offers a tranquil retreat for the nature lovers and those seeking a peaceful, sdfgsd dsfsdf', 'IMG_20241003_224046.jpg', 'Where to Stay', 'For a comfortable stay in Majayjay, Laguna, choose from cozy homestays, charming cottages, resorts, offering scenic views and easy access to attractions like Taytay Falls.', 'landscape-view-of-the-warm-relax-swimming-pool-with-tropical-trees-in-modern-design-resort-with-moody-weather-time-video.jpg', 'Where to Go', 'In Majayjay, Laguna, visit Taytay Falls, hike lush forests, explore St. Gregory the Great Church, serene rivers, offering a perfect mix of adventure and history.', 'Futura-Thumbnail.jpg', 'Where to Eat', 'In Majayjay, Laguna, enjoy local cuisine at roadside eateries, cozy cafes, and old restaurants serving Filipino dishes, and regional delicacies in a charming setting.', '2024-07-31 04:05:16');

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

--
-- Dumping data for table `highlights`
--

INSERT INTO `highlights` (`HighlightID`, `HighlightName`, `BarangayID`, `IsActive`) VALUES
(1, 'Splash', 21, 1),
(3, 'Garden', 21, 1);

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
(22, 1, 500.00),
(23, 3, 300.00),
(24, 8, 500.00),
(25, 9, 500.00),
(26, 10, 2500.00),
(27, 11, 1000.00),
(28, 13, 1000.00);

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
(22, 119, '09123456789', 'Jordan Rae Marabesss', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363734393961386238666137642e706e67),
(23, 124, '09999999999', 'JO*N R** B.', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363736323762616139356562652e6a706567),
(24, 136, '09674654234', 'Lumien Manalo', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363736386362356531383532352e706e67),
(25, 158, '09504073109', 'Jordan Manalo', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363737306263303639626662642e706e67),
(26, 159, '09504073109', 'Jordan Rae Marabe', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363737306335313065633434632e706e67),
(27, 160, '09872817211', 'Devine Vitasa', 0x2e2e2f2e2e2f627573696e6573736f776e65722f7061796d656e7451722f363737306437623563616261332e706e67);

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
  `status` enum('Pending','Accepted','Ongoing','Rejected','Cancel','Complete') NOT NULL DEFAULT 'Pending',
  `reasonCancel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`revID`, `roomID`, `userID`, `fullname`, `regadd`, `regemail`, `regnum`, `checkin`, `departure`, `referenceNum`, `datetime`, `status`, `reasonCancel`) VALUES
(151, 2, 69, 'John Rev Baliton', '1042 Yukos', 'johnrevgamingyt@gmail.com', '+639127272828', '2025-01-01', '2025-01-02', 'REF-UQUE4T', '2024-12-30 18:37:50', 'Ongoing', NULL);

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
(2, 119, 'Resort na Talaga', 2000.00, 1, 1, '* Bawal lahat\r\n* Bawal nga aba\r\n* Bawal hindi naligo', '../../businessowner/roomImages/Mario Tupar Resort/Resort na Talaga/Falls_67579e2c2693d.jpg', '../../businessowner/roomImages/Mario Tupar Resort/Resort na Talaga/maxresdefault_67579e2c26b18.jpg', '../../businessowner/roomImages/Mario Tupar Resort/Resort na Talaga/resort-sea_67579e2c26c5f.jpg', '../../businessowner/roomImages/Mario Tupar Resort/Resort na Talaga/wallpaper2_67579e4985c28.jpg', NULL, NULL, '22:00:00', '22:00:00'),
(3, 124, 'Samantha Room', 1200.00, 6, 3, '* Always check your belongings\r\n* Maintain cleanliness\r\n* Observe silence', '../../businessowner/roomImages/Carayan Resort/Samantha Room/FB_IMG_1733835241570_67612ad25e478.jpg', '../../businessowner/roomImages/Carayan Resort/Samantha Room/FB_IMG_1733835250027_67612ad25e6c7.jpg', NULL, NULL, NULL, NULL, '14:00:00', '12:00:00'),
(4, 124, 'Vincent Room', 1200.00, 6, 4, '* Maintain cleanliness\r\n* Observe silence', '../../businessowner/roomImages/Carayan Resort/Vincent Room/FB_IMG_1733835367292_67612ec9033e1.jpg', '../../businessowner/roomImages/Carayan Resort/Vincent Room/FB_IMG_1733835370411_67612ec9035a9.jpg', NULL, NULL, NULL, NULL, '14:00:00', '12:00:00'),
(5, 124, 'Rosalyn Room', 1250.00, 2, 1, '* No leaving the aircon on.\r\n* Maintain cleanliness\r\n* Observe silence', '../../businessowner/roomImages/Carayan Resort/Rosalyn Room/FB_IMG_1733835503381_6761309e68bcf.jpg', '../../businessowner/roomImages/Carayan Resort/Rosalyn Room/FB_IMG_1733835505873_6761309e68e3c.jpg', '../../businessowner/roomImages/Carayan Resort/Rosalyn Room/FB_IMG_1733835508220_6761309e68faf.jpg', NULL, NULL, NULL, '14:00:00', '12:00:00'),
(6, 124, 'Rosalyn 2 Room', 1250.00, 2, 1, '* Dont leave aircon running.\r\n* Maintain cleanliness\r\n* Observe silence', '../../businessowner/roomImages/Carayan Resort/Rosalyn 2 Room/FB_IMG_1733835634447_676131b653838.jpg', '../../businessowner/roomImages/Carayan Resort/Rosalyn 2 Room/FB_IMG_1733835638640_676131b653a20.jpg', '../../businessowner/roomImages/Carayan Resort/Rosalyn 2 Room/FB_IMG_1733835641145_676131b653be8.jpg', NULL, NULL, NULL, '14:00:00', '12:00:00'),
(7, 124, 'Krista Room', 1000.00, 2, 1, '* Maintain cleanliness\r\n* Observe silence', '../../businessowner/roomImages/Carayan Resort/Krista Room/FB_IMG_1733835745776_6761324675045.jpg', '../../businessowner/roomImages/Carayan Resort/Krista Room/FB_IMG_1733835747601_67613246752ac.jpg', NULL, NULL, NULL, NULL, '14:00:00', '12:00:00'),
(8, 136, 'Boctil Deluxe', 5000.00, 5, 4, '* Bawal Tumalon\r\n* Bawal Sumigaw\r\n* Bawal Kumanta', '../../businessowner/roomImages/Lumien Resort/Boctil Deluxe/IMG_20241003_223935_6768cb333b2dc.jpg', '../../businessowner/roomImages/Lumien Resort/Boctil Deluxe/IMG_20241003_224312 (1)_6768cb333b4d1.jpg', '../../businessowner/roomImages/Lumien Resort/Boctil Deluxe/IMG_20241003_224155_6768cb333b62d.jpg', '../../businessowner/roomImages/Lumien Resort/Boctil Deluxe/IMG_20241003_224331_6768cb333b7a4.jpg', NULL, NULL, '14:00:00', '12:00:00'),
(9, 158, 'Bahy Kubo', 1500.00, 4, 2, '* Bawal mag inom\r\n* Bawal tumalon sa pool', '../../businessowner/roomImages/Majayjay Taytay Resort/Bahy Kubo/1_6770bafea9729.jpg', '../../businessowner/roomImages/Majayjay Taytay Resort/Bahy Kubo/2_6770bafea996a.jpg', '../../businessowner/roomImages/Majayjay Taytay Resort/Bahy Kubo/4_6770bafea9abe.jpg', NULL, NULL, NULL, '14:00:00', '10:00:00'),
(10, 159, 'Mahogani Isa', 5000.00, 5, 3, '* Bawal manira ng gamit\r\n* Bawal mag uwi ng gamit', '../../businessowner/roomImages/James Yap Resort/Mahogani Isa/1_6770c4cd1c83e.jpg', '../../businessowner/roomImages/James Yap Resort/Mahogani Isa/2_6770c4cd1c9d8.jpg', '../../businessowner/roomImages/James Yap Resort/Mahogani Isa/4_6770c4cd1cb29.jpg', NULL, NULL, NULL, '14:00:00', '10:00:00'),
(11, 160, 'Uyang', 2500.00, 2, 1, '* bawal huminga', '../../businessowner/roomImages/Hilarions&amp;#039; Farm/Uyang/Screenshot (2)_6770d690dc442.png', '../../businessowner/roomImages/Hilarions&amp;#039; Farm/Uyang/FLUTTER 5_6770d690dcdf7.png', '../../businessowner/roomImages/Hilarions&amp;#039; Farm/Uyang/Screenshot (1)_6770d540aafcd.png', '../../businessowner/roomImages/Hilarions&amp;#039; Farm/Uyang/462570702_1241902200429044_493460265565231887_n_6770d564088fe.jpg', NULL, NULL, '14:00:00', '12:00:00'),
(12, 159, 'Malay Balay', 100.00, 5, 1, '* Bawal lahat', '../../businessowner/roomImages/James Yap Resort/Malay Balay/1_6770f3e84a0ac.jpg', '../../businessowner/roomImages/James Yap Resort/Malay Balay/2_6770f3e84a26f.jpg', '../../businessowner/roomImages/James Yap Resort/Malay Balay/4_6770f3e84a38f.jpg', NULL, NULL, NULL, '14:00:00', '10:00:00'),
(13, 124, 'quwyetwqe', 4500.00, 2, 2, '* no smoking', '../../businessowner/roomImages/Carayan Resort/quwyetwqe/Screenshot (1)_6770f7a9a23ac.png', '../../businessowner/roomImages/Carayan Resort/quwyetwqe/Screenshot (1)_6770f7a9a25a2.png', NULL, NULL, NULL, NULL, '14:00:00', '12:00:00'),
(14, 161, 'Ejay Resort', 5000.00, 5, 4, '* Bawal Magkalat\r\n* Bawal Maginom', '../../businessowner/roomImages/Megabox Resort/Ejay Resort/1_6772186ea1e89.jpg', '../../businessowner/roomImages/Megabox Resort/Ejay Resort/2_6772186ea207d.jpg', '../../businessowner/roomImages/Megabox Resort/Ejay Resort/3_6772186ea2203.jpg', '../../businessowner/roomImages/Megabox Resort/Ejay Resort/5_6772186ea2335.jpg', NULL, NULL, '14:00:00', '10:00:00');

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
(16, 121, 'Silog'),
(22, 122, 'Spaaa'),
(23, 119, 'Keme'),
(24, 119, 'Tv'),
(30, 124, 'Cottage'),
(31, 124, 'Table'),
(32, 124, 'Pool'),
(33, 124, 'Air conditioned room'),
(34, 124, 'Fan room'),
(35, 136, 'Balcony'),
(36, 136, 'Kitchen'),
(37, 158, 'Aircon'),
(38, 159, 'Basketball court'),
(39, 160, 'Pool'),
(40, 161, 'Aircon');

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
(1, 23, 119, 1),
(1, 24, 119, 1),
(2, 23, 119, 1),
(2, 24, 119, 1),
(3, 34, 124, 1),
(4, 34, 124, 1),
(5, 33, 124, 1),
(6, 33, 124, 1),
(7, 34, 124, 1),
(8, 35, 136, 1),
(8, 36, 136, 1),
(9, 37, 158, 1),
(10, 38, 159, 1),
(11, 39, 160, 1),
(12, 38, 159, 1),
(13, 30, 124, 1),
(13, 31, 124, 1),
(13, 32, 124, 1),
(13, 33, 124, 1),
(14, 40, 161, 1),
(69, 23, 119, 1),
(69, 24, 119, 1),
(77, 23, 119, 1),
(77, 24, 119, 1);

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
(3, 119, 'Tv'),
(4, 119, 'Kamote'),
(5, 124, 'Air conditioned'),
(6, 124, 'Fan'),
(7, 124, 'Toilet'),
(8, 124, 'Bathroom'),
(9, 124, 'Hot & cold shower'),
(10, 124, 'Double deck'),
(11, 124, 'King size bed'),
(12, 124, 'Bed'),
(13, 136, 'Pool'),
(14, 136, 'Wifi'),
(15, 158, 'Garden'),
(16, 159, '3rd floor'),
(17, 160, 'Wifi'),
(18, 161, 'Lights');

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
(1, 3, 119, 1),
(2, 3, 119, 1),
(2, 4, 119, 1),
(3, 6, 124, 1),
(3, 7, 124, 1),
(3, 8, 124, 1),
(3, 10, 124, 1),
(4, 6, 124, 1),
(4, 7, 124, 1),
(4, 8, 124, 1),
(4, 10, 124, 1),
(4, 12, 124, 1),
(5, 5, 124, 1),
(5, 7, 124, 1),
(5, 9, 124, 1),
(5, 11, 124, 1),
(6, 5, 124, 1),
(6, 7, 124, 1),
(6, 9, 124, 1),
(6, 10, 124, 1),
(7, 6, 124, 1),
(7, 7, 124, 1),
(7, 8, 124, 1),
(7, 11, 124, 1),
(8, 13, 136, 1),
(8, 14, 136, 1),
(9, 15, 158, 1),
(10, 16, 159, 1),
(11, 17, 160, 1),
(12, 16, 159, 1),
(13, 7, 124, 1),
(13, 10, 124, 1),
(13, 11, 124, 1),
(14, 18, 161, 1),
(69, 3, 119, 1),
(70, 3, 119, 1),
(71, 3, 119, 1),
(76, 3, 119, 1),
(77, 3, 119, 1);

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
(26, 52, 'kuyajason00@shurua.xyz', '$2y$10$20W.xDeaEISDA4UGQbiYcOfRSdILtY2eatK8FbHH2B1EinWsfYW72', '2024-11-18 09:14:43', 1),
(28, 53, 'kuyajason01@shurua.xyz', '$2y$10$oANOsjJewR0zNspkQcN/jenoLq6oZmtTvtK/5F3ANbXX5.i0MSbE2', '2024-12-10 11:55:11', 1),
(31, 56, 'angelo.manalo009@gmail.com', '$2y$10$loqKqCyUsEh/xI7Ohg5.KOfCY5H1ldPQfZ60b.U28hz8.r9Kw8obe', '2024-12-15 14:17:00', 1),
(33, 58, 'johnrevbaliton@shurua.xyz', '$2y$10$5Ji7MJvz09B8UfQ/vfDEaO55U8j74kf.u5S1fJZT7Th.FaKgxZqh.', '2024-12-15 14:48:59', 1),
(34, 59, 'lyraleigesmundo@gmail.com', '$2y$10$6xkFTMxo0ViUwroMMvzXBesZEi89NtGgVaTrk2EQWXfT8cht3xPbS', '2024-12-15 14:50:57', 1),
(35, 60, 'verbctl@gmail.com', '$2y$10$IuFxu5QdVXufAmavdXy1Zehyw9l632aqwiwcuAVJ8AN.FTrohl6Rq', '2024-12-15 14:55:44', 1),
(36, 61, '5o7xke4c@duckmail.club', '$2y$10$a3uWCwiinh9UbzFoHsjdwuhw/l3ZvJogeiDgN3lajdn7QcPvedw7i', '2024-12-17 06:57:51', 1),
(37, 62, 'naruto0205@gmail.com', '', '2024-12-17 07:01:19', 0),
(38, 63, '4a0b8fs7@duckmail.club', '$2y$10$Iq7BAUar6BeWUEExCZifKet44BqSx.oH5nLxmXuf3w1qYzbu85Yai', '2024-12-17 07:04:15', 1),
(39, 64, 'naruto0205uzumaki@gmail.com', '$2y$10$bcMeR5eVknPCWZYe4FcqbejPS1axycIT2p5wOFkl7bG9jILc6D5Hy', '2024-12-17 07:07:34', 1),
(40, 65, 'eaanives04@gmail.com', '$2y$10$6zJfOBmvQxEuy8PmPDoY9OsEFIzxnnPvCmV6FU590..DSSQcshsbS', '2024-12-17 07:48:13', 1),
(41, 66, 'sherwinquizon@shurua.xyz', '$2y$10$BPkpg.O1nHZH44IjApHi8uxz4qgSHXwDQGARNg5xNQCDPuEuusTG6', '2024-12-23 02:04:25', 1),
(42, 67, 'ci123@duckmail.club', '', '2024-12-30 03:24:14', 0),
(43, 68, 'ci234@duckmail.club', '$2y$10$/CrXWtuutvq1ygW4okPHQOY1j7BG4jI7AXBq5KILGV3AXpopXY3pi', '2024-12-30 03:26:39', 1),
(44, 69, 'johnrevgamingyt@gmail.com', '$2y$10$S9Kc/hipqyaREbprUqRbHegOtAUVDtA2ljEiuiS7fO3Q.jIcZefZO', '2024-12-30 10:26:54', 1);

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
(152, 68, 4, 124, 'Crisostomo Ibarra, Maria Clara', 'Male, Female', 'Other City/Municipality, Other Province', '2024-12-30 07:57:07', 2, 1, 1, 0, 1, 1, 0, 'Pending'),
(153, 69, 2, 119, 'John Rev Baliton, Jordan Rae Marabe', 'Male, Male', 'Other City/Municipality, Foreign Country', '2024-12-30 10:37:50', 2, 2, 0, 0, 1, 0, 1, 'Accepted');

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

--
-- Dumping data for table `userpayment`
--

INSERT INTO `userpayment` (`userpayID`, `roomID`, `businessinfoID`, `userID`, `IsPaid`, `proofOfPayment`, `gcashReference`) VALUES
(6, 1, 119, 53, 0, '../../businessowner/userPaymentProof/Graduation new honors_page-0001.jpg', '6578 568 658556'),
(7, 1, 119, 52, 0, '../../businessowner/userPaymentProof/Graduation new honors_page-0002.jpg', '2345 325 325325'),
(8, 3, 124, 53, 0, '../../businessowner/userPaymentProof/1705729928483.jpg', '3253 523 523252'),
(9, 8, 136, 66, 0, '../../businessowner/userPaymentProof/cps6.png', '9823 748 927349'),
(10, 8, 136, 66, 0, '../../businessowner/userPaymentProof/emaillogo.png', '3423 532 523452'),
(11, 8, 136, 59, 0, '../../businessowner/userPaymentProof/2017-02-17 (7).jpg', '7373 737 377473'),
(12, 9, 158, 53, 0, '../../businessowner/userPaymentProof/2.jpeg', '6432 684 762384'),
(13, 10, 159, 53, 0, '../../businessowner/userPaymentProof/2.jpeg', '8236 478 267836'),
(14, 11, 160, 59, 0, '../../businessowner/userPaymentProof/Screenshot_2024-12-26-07-28-01-50_f69139cffc4d135a71392e13634f144a.jpg', '7373 737 377473');

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
(52, 'Una Jason', 'kuyajason00@shurua.xyz', '+638937249872', '1212 Street', 'Other City/Municipality', 'Female', 'Postal ID', '../../user/userID/Jason/Jason_52_front.jpg', NULL, '2024-11-18 01:14:43'),
(53, 'Kuya Jason', 'kuyajason01@shurua.xyz', '+635656756753', '299 San Pedro Street Brgy I, Alaminos Laguna', 'Other City/Municipality', 'Male', 'passport', '../../user/userID/Jason/Jason_53_front.jpg', NULL, '2024-12-10 11:55:11'),
(55, 'Jack Kline', 'rs0puljv@duckmail.club', '+639917847770', 'Street Barangay Municipality Province', 'Other City/Municipality', 'Male', 'voter_id', '../../user/userID/Kline/Kline_55_front.jpg', '../../user/userID/Kline/Kline_55_back.jpg', '2024-12-15 14:13:23'),
(56, 'Angelo Manalo', 'angelo.manalo009@gmail.com', '+639669454033', 'San Miguel, Alaminos, Laguna', '', 'Male', 'driver_license', '../../user/userID/Manalo/Manalo_56_front.jpeg', '../../user/userID/Manalo/Manalo_56_back.jpeg', '2024-12-15 14:17:00'),
(58, 'John Rev Baliton', 'johnrevbaliton@shurua.xyz', '+637812364237', '121 Street', 'Other City/Municipality', 'Male', 'Voter ID', '../../user/userID/Baliton/Baliton_58_front.png', NULL, '2024-12-15 14:48:59'),
(59, 'Jane Doe', 'lyraleigesmundo@gmail.com', '+639065417074', 'Street Barangay Municipality Province', 'Other City/Municipality', 'Female', 'Bagong ID', '../../user/userID/Doe/Doe_59_front.jpg', '../../user/userID/Doe/Doe_59_back.jpg', '2024-12-15 14:50:57'),
(60, 'Jholiver Boctil', 'verbctl@gmail.com', '+639274790285', 'brgy.Boctocan,majayjay.laguna', 'This City/Municipality', 'Male', 'Driver&#39;s License', '../../user/userID/Boctil/Boctil_60_front.jpg', '../../user/userID/Boctil/Boctil_60_back.jpg', '2024-12-15 14:55:44'),
(61, 'Juan Tu', '5o7xke4c@duckmail.club', '+639999999999', '123 St., Brgy. Barangay, Municipality City, Province province', 'Other Province', 'Male', 'Student ID', '../../user/userID/Tu/Tu_61_front.jpg', '../../user/userID/Tu/Tu_61_back.jpg', '2024-12-17 06:57:51'),
(62, 'Naruto Uzumaki', 'naruto0205@gmail.com', '+630493939383', 'Bahay ni rev', 'Other City/Municipality', 'Male', 'Student ID', '../../user/userID/Uzumaki/Uzumaki_62_front.jpg', '../../user/userID/Uzumaki/Uzumaki_62_back.jpg', '2024-12-17 07:01:19'),
(63, 'Payb Siks', '4a0b8fs7@duckmail.club', '+638888888888', '123 Brgy. city province', 'Foreign Country', 'Female', 'Social Security ID', '../../user/userID/Siks/Siks_63_front.jpg', '../../user/userID/Siks/Siks_63_back.jpg', '2024-12-17 07:04:15'),
(64, 'Naruto Uzumaki', 'naruto0205uzumaki@gmail.com', '+630493939383', 'Bahay ni rev', 'Other City/Municipality', 'Male', 'Student ID', '../../user/userID/Uzumaki/Uzumaki_64_front.jpg', '../../user/userID/Uzumaki/Uzumaki_64_back.jpg', '2024-12-17 07:07:34'),
(65, 'John Doe', 'eaanives04@gmail.com', '+639917847770', 'Street Barangay Municipality Province', 'This City/Municipality', 'Male', 'Tunay na Valid ID', '../../user/userID/Doe/Doe_65_front.jpg', '../../user/userID/Doe/Doe_65_back.jpg', '2024-12-17 07:48:13'),
(66, 'Sherwin Quizon', 'sherwinquizon@shurua.xyz', '+633632623624', '2131 Street, San Pablo Laguna', 'Other City/Municipality', 'Male', 'Postal ID', '../../user/userID/Quizon/Quizon_66_front.png', NULL, '2024-12-23 02:04:25'),
(67, 'Crisostomo Ibarra', 'ci123@duckmail.club', '+639065417074', 'Street Barangay Municipality Province', 'Other City/Municipality', 'Male', 'Sorcerer ID', '../../user/userID/Ibarra/Ibarra_67_front.jpeg', '../../user/userID/Ibarra/Ibarra_67_back.png', '2024-12-30 03:24:14'),
(68, 'Crisostomo Ibarra', 'ci234@duckmail.club', '+639065417074', 'Street Barangay Municipality Province', 'Other City/Municipality', 'Male', 'Some ID', '../../user/userID/Ibarra/Ibarra_68_front.jpeg', '../../user/userID/Ibarra/Ibarra_68_back.png', '2024-12-30 03:26:39'),
(69, 'John Rev Baliton', 'johnrevgamingyt@gmail.com', '+639127272828', '1042 Yukos', 'Other City/Municipality', 'Male', 'Passport', '../../user/userID/Baliton/Baliton_69_front.jpg', '../../user/userID/Baliton/Baliton_69_back.jpg', '2024-12-30 10:26:54');

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
  MODIFY `AccountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barangay_accounts`
--
ALTER TABLE `barangay_accounts`
  MODIFY `barangayId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bownerdemographics`
--
ALTER TABLE `bownerdemographics`
  MODIFY `bOwnerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `businessapplicationform`
--
ALTER TABLE `businessapplicationform`
  MODIFY `ApplicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `businessinformationform`
--
ALTER TABLE `businessinformationform`
  MODIFY `BusinessInfoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `businesstype`
--
ALTER TABLE `businesstype`
  MODIFY `BusinessTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `business_features`
--
ALTER TABLE `business_features`
  MODIFY `BusinessFeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `business_media`
--
ALTER TABLE `business_media`
  MODIFY `MediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `demographics`
--
ALTER TABLE `demographics`
  MODIFY `demogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `FeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `frontpagecontent`
--
ALTER TABLE `frontpagecontent`
  MODIFY `frontpageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `highlights`
--
ALTER TABLE `highlights`
  MODIFY `HighlightID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `paymentMethodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `qcashpayment`
--
ALTER TABLE `qcashpayment`
  MODIFY `bgcashID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `revID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `roominfotable`
--
ALTER TABLE `roominfotable`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `FacilityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `FeatureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `userAccID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `userdemographics`
--
ALTER TABLE `userdemographics`
  MODIFY `userdemogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `userpayment`
--
ALTER TABLE `userpayment`
  MODIFY `userpayID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
