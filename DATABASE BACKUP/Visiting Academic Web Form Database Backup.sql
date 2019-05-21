-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 21, 2019 at 12:46 PM
-- Server version: 10.2.23-MariaDB
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u359278202_vawf`
--

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE `college` (
  `collegeId` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`collegeId`, `name`) VALUES
(1, 'College of Arts, Humanities and Business'),
(2, 'College of Environmental Sciences and Engineering'),
(3, 'College of Human Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `schoolId` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collegeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`schoolId`, `name`, `collegeId`) VALUES
(2, 'Bangor Business School', 1),
(3, 'School of History, Philosophy and Social Sciences', 1),
(4, 'School of Languages, Literatures and Linguistics', 1),
(5, 'School of Law', 1),
(6, 'School of Music and Media', 1),
(7, 'School of Welsh and Celtic Studies', 1),
(8, 'Centre for Research on Bilingualism', 1),
(9, 'School of Computer Science and Electronic Engineering', 2),
(10, 'School of Natural Sciences', 2),
(11, 'School of Ocean Sciences', 2),
(12, 'The BioComposites Centre', 2),
(13, 'School of Education and Human Development', 3),
(14, 'School of Health Sciences', 3),
(15, 'School of Medical Sciences', 3),
(16, 'School of Psychology', 3),
(17, 'School of Sport, Health and Exercise Sciences', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Academic','Head Of School','College Manager','Human Resources') COLLATE utf8mb4_unicode_ci NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `college_id` int(11) DEFAULT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `role`, `school_id`, `college_id`, `email`, `name`) VALUES
('eeaees', 'hr', 'Human Resources', NULL, NULL, 'spectre-nsx@outlook.com', 'Azhar Smith'),
('ees60f', 'cm', 'College Manager', NULL, 2, 'spectre-nsx@outlook.com', 'Jack Smith'),
('eeuaag', 'hos', 'Head Of School', 9, 2, 'spectre-nsx@outlook.com', 'Bedwyr Hughes'),
('eeuabb', 'academic', 'Academic', 9, 2, 'spectre-nsx@outlook.com', 'Mike Jones'),
('hosTest', 'hos2', 'Head Of School', 7, 1, 'spectre-nsx@outlook.com', 'HoS Welsh & Celtic'),
('welshman', 'academic', 'Academic', 7, 1, 'spectre-nsx@outlook.com', 'John Jones');

-- --------------------------------------------------------

--
-- Table structure for table `vaLogin`
--

CREATE TABLE `vaLogin` (
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vaLogin`
--

INSERT INTO `vaLogin` (`username`, `password`, `visitorId`) VALUES
('AJones', 'test', 48),
('BDRoberts', 'test', 59),
('CJones', 'test', 56),
('MRouse', 'test', 57);

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `visitId` int(11) NOT NULL,
  `visitorId` int(11) NOT NULL,
  `visitAddedDate` datetime NOT NULL,
  `visitCompletedDate` datetime DEFAULT NULL,
  `hostAcademic` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `status` enum('pending','denied','approved','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `summary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financialImplications` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `induction` tinyint(1) NOT NULL DEFAULT 0,
  `iprIssues` tinyint(1) NOT NULL DEFAULT 0,
  `iprFile` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisorApproved` tinyint(1) DEFAULT 0,
  `supervisorUsername` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisorApprovedDate` datetime DEFAULT NULL,
  `supervisorComment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hrApproved` tinyint(1) DEFAULT 0,
  `hrUsername` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hrApprovedDate` datetime DEFAULT NULL,
  `hrComment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Status might not be needed...';

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`visitId`, `visitorId`, `visitAddedDate`, `visitCompletedDate`, `hostAcademic`, `startDate`, `endDate`, `status`, `summary`, `financialImplications`, `induction`, `iprIssues`, `iprFile`, `supervisorApproved`, `supervisorUsername`, `supervisorApprovedDate`, `supervisorComment`, `hrApproved`, `hrUsername`, `hrApprovedDate`, `hrComment`, `cancelTime`) VALUES
(28, 44, '2019-04-02 09:13:00', NULL, 'eeuaag', '2019-04-12 00:00:00', '2019-04-21 00:00:00', 'pending', 'learn python', 'none', 0, 0, NULL, 2, 'ees60f', '2019-04-22 14:12:18', NULL, 0, 'eeaees', '2019-04-22 14:12:49', 'cds', '0000-00-00 00:00:00'),
(29, 45, '2019-04-02 09:21:03', NULL, 'eeuaag', '2019-06-07 00:00:00', '2019-06-21 00:00:00', 'pending', 'Need a large hall', 'Need equipment', 0, 0, NULL, 3, 'ees60f', '2019-04-25 13:36:19', NULL, 1, 'eeaees', NULL, NULL, '0000-00-00 00:00:00'),
(30, 46, '2019-04-26 14:49:58', NULL, 'ees60f', '2019-04-28 00:00:00', '2019-04-30 00:00:00', 'pending', 'Workshops', '  £1000 to cover fees  ', 0, 0, '', 4, NULL, NULL, NULL, 4, NULL, NULL, NULL, '2019-04-26 14:53:07'),
(31, 47, '2019-04-26 13:33:12', NULL, 'ees60f', '2019-05-01 00:00:00', '2019-05-03 00:00:00', 'pending', 'Research partnership', ' £30 p/hour please', 0, 0, NULL, 4, NULL, NULL, NULL, 4, NULL, NULL, NULL, '2019-04-30 21:54:38'),
(123, 59, '2019-04-26 14:55:51', NULL, 'ees60f', '2019-04-28 00:00:00', '2019-05-01 00:00:00', 'pending', 'Aim to keep youth skills local', 'None - since it\'s a recruitememt event', 0, 0, NULL, 3, 'ees60f', '2019-04-26 14:55:51', NULL, 3, 'eeaees', '2019-04-26 16:17:13', NULL, '0000-00-00 00:00:00'),
(155, 62, '2019-04-30 22:03:24', NULL, 'ees60f', '2019-04-30 00:00:00', '2019-04-30 00:00:00', 'pending', 'hello is this working', ' cvbnm ', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(159, 56, '2019-04-30 21:32:53', NULL, 'eeuaag', '2019-06-30 00:00:00', '2019-06-30 00:00:00', 'pending', 'asdasdasd', 'asdasdasd', 0, 0, NULL, 3, 'ees60f', '2019-04-30 21:33:42', NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(160, 65, '2019-04-30 22:06:16', NULL, 'eeuabb', '2019-05-03 00:00:00', '2019-06-14 00:00:00', 'pending', 'To visit a museum', 'Bus to see museum £500\r\nentry per student £20 x 32students', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(162, 66, '2019-04-30 23:07:02', NULL, 'eeuaag', '2019-05-03 00:00:00', '2019-06-05 00:00:00', 'pending', 'to teach chemistry', 'No financial implications', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(163, 67, '2019-04-30 23:10:04', NULL, 'eeuaag', '2019-05-03 00:00:00', '2019-09-12 00:00:00', 'pending', 'Teaching', 'Books for class cost : Unknown', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(164, 62, '2019-04-30 23:10:43', NULL, 'ees60f', '2019-04-30 00:00:00', '2019-04-30 00:00:00', 'pending', 'Doing practicals', 'Doing practicals', 0, 0, NULL, 3, 'ees60f', '2019-04-30 23:10:43', NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(165, 65, '2019-04-30 23:11:15', NULL, 'eeuabb', '2019-04-30 00:00:00', '2019-05-04 00:00:00', 'pending', 'Teaching', 'N/A', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(166, 44, '2019-04-30 23:26:25', NULL, 'eeuaag', '2019-05-04 00:00:00', '2019-05-31 00:00:00', 'pending', 'Assisting lecturer', 'Assisting lecturer', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(167, 68, '2019-04-30 23:29:42', NULL, 'eeuaag', '2019-05-05 00:00:00', '2019-07-11 00:00:00', 'pending', 'Teaching', 'Maths books for students\r\nGraphical calculators', 0, 0, NULL, 3, 'ees60f', '2019-05-09 11:38:07', NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(168, 61, '2019-04-30 23:30:22', NULL, 'ees60f', '2019-04-30 00:00:00', '2019-07-19 00:00:00', 'pending', 'Assisting', 'N/A', 0, 0, NULL, 3, 'ees60f', '2019-04-30 23:30:22', NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(181, 57, '2019-05-09 11:37:28', NULL, 'ees60f', '2019-06-13 00:00:00', '2019-06-14 00:00:00', 'pending', 'asdasdasd', 'wdaas', 0, 0, NULL, 3, 'ees60f', '2019-05-09 11:37:28', NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00'),
(182, 48, '2019-05-09 11:43:05', NULL, 'eeuabb', '2019-05-15 00:00:00', '2019-05-16 00:00:00', 'pending', 'Lecture regarding a brief history of Computer Science.', 'Costs for handouts', 0, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `visitingAcademic`
--

CREATE TABLE `visitingAcademic` (
  `visitorId` int(11) NOT NULL,
  `hostAcademic` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fName` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lName` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitorType` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visitorTypeExt` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `homeInstitution` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `county` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `visitingAcademic`
--

INSERT INTO `visitingAcademic` (`visitorId`, `hostAcademic`, `title`, `fName`, `lName`, `visitorType`, `visitorTypeExt`, `homeInstitution`, `department`, `street`, `city`, `county`, `postcode`, `email`, `phoneNumber`) VALUES
(44, 'eeuaag', 'Mr', 'Bed', 'Wyr', 'Undergraduate', '', 'Bangor Uni', NULL, 'Ffordd y Llan', 'Edern', 'Gwynedd', 'LL53 8YS', NULL, NULL),
(45, 'eeuaag', 'Mr', 'M', 'Rouse', 'Undergraduate', '', 'Aberystwyth Uni', 'phycology', 'Morfa', 'Pwllheli', 'Gwynedd', 'LL53 8TS', NULL, NULL),
(46, 'ees60f', 'Miss', 'Made up', 'Name', 'Other', '', 'Wrexham University', 'clai', 'Glyndwr Building', 'Wrexham', 'hhb', 'LL75 8uh', 'madeup@name.com', '01758965421'),
(47, 'ees60f', 'Dr', 'Jack', 'Tiggs', 'Undergraduate', 'Head of Research', 'Swansea University', 'de', '43', 'Rhyl', 'hj', 'LL88 7DG', 'jack@tiggs.com', '07785655244'),
(48, 'eeuabb', 'Mr', 'Adam', 'Jones', 'Undergraduate', '', 'Cardiff Met', 'cleaning', 'Millenium Lane', 'Cardiff', 'Crdiff', 'CF10 8fj', 'adam.j@mail.co', '07785355977'),
(49, 'eeuabb', 'Colonel', 'Dafydd', 'Williams', 'Visiting Academic', 'supervisor', 'supervising authority', '', 'Supervise Lane', 'Corwen', 'jjhhj', 'CO10 9RW', '', ''),
(50, 'welshman', 'Mr', 'John', 'Bala', 'Other', 'Representitive', 'Cofio Tryweryn', NULL, 'Llys Tegid', 'Bala', 'Gwynedd', 'BA71 7AS', NULL, NULL),
(52, 'ees60f', 'Mr', 'colonel', 'something', 'Undergraduate', '', 'place', NULL, 'place', 'fce', 'lancs', 'TR5 6YT', '.@t.b', NULL),
(56, 'eeuaag', 'Mr', 'Chris ', 'Jones', 'Other', 'manager', 'Nefyn UTD', 'Management', 'Cae\'r Delyn', 'Nefyn', 'Gwynedd', 'LL53 6th', 'manager@nefyn.com', '01286666554'),
(57, 'ees60f', 'Mr', 'Mike', 'Rouse', 'Other', 'Business Man (Crook)', 'Rouse International', 'IT', 'Rouse Lane,', 'Leslieville', 'St Andrews', 'LL78 8hy', 'm.rouse@rouseInt.com', '01758764890'),
(58, 'ees60f', 'Mr', 'Bedwyr', 'Williams', 'Undergraduate', '', 'Beds Global', 'Management', 'Prys Lane,', 'Williamsville', 'Conwy', 'b14nt', 'bp@bg.com', '0175872110'),
(59, 'ees60f', 'Mr', 'Big Dolla', 'ROberts', 'Undergraduate', '', 'Gwynedd Council', 'Finance', 'HQ', 'Caernarfon', 'Gwynedd', 'LL56 2DG', 'finance@gwynedd.com', '01286 678876'),
(60, 'ees60f', 'Dr', 'Smart', 'Ass', 'PhD Student', '', 'Oz', 'Wizadry', 'sdadsad', 'dsadsda', 'dasdasd', 'RH10 6BW', 'mr_made_up@whatever.com', '01758721067'),
(61, 'ees60f', 'Mr', 'ADAM', 'PARRY', 'Undergraduate', '', 'place', 'clai', '7, Willow field', 'chorley', 'lancashire  ', 'PR67JQ', 'MrAds@gmail.com', '7419842844'),
(62, 'ees60f', 'Mr', 'Adam', 'parry', 'Undergraduate', '', 'place', 'clai', 'CY106, Cybi,', 'St Mary\'s Village,', 'Lon Pobty,', 'LL57 1DZ', 'parryadam154@gmail.com', '7419842844'),
(65, 'eeuabb', 'Mr', 'Leon', 'Smith', 'Undergraduate', '', '42 North west street', 'Physics', '19 Willmoten drive', 'Derby', 'Bedfordshire', 'LL52 9SD', 'Smithy@gmail.com', '01267 338 422'),
(66, 'eeuaag', 'Mr', 'Dan', 'Peters', 'Undergraduate', '', '42 elk place', 'Chemistry', '3 Mellowholly way', 'wilkshire', 'Bedfordshire', 'LL52 9SD', 'Pete@gmail.com', '01253122311'),
(67, 'eeuaag', 'Mrs', 'diane', 'mogonson', 'PhD Student', '', 'house', 'Philosophy', '14 milky way', 'donstanter', 'Lancs', 'PR6 7RE', 'Sonny@gmail.com', '01276543897'),
(68, 'eeuaag', 'Dr', 'Adam', 'Parry', 'Undergraduate', '', 'St marys', 'Maths', 'Willow field', 'Preston', 'Lancs', 'PR6 7RE', '43aparry@gmail.com', '07419842855');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `college`
--
ALTER TABLE `college`
  ADD PRIMARY KEY (`collegeId`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`schoolId`),
  ADD KEY `College To School` (`collegeId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `User to School` (`school_id`),
  ADD KEY `User to college` (`college_id`);

--
-- Indexes for table `vaLogin`
--
ALTER TABLE `vaLogin`
  ADD PRIMARY KEY (`username`),
  ADD KEY `visitorId` (`visitorId`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`visitId`),
  ADD KEY `Visitor` (`visitorId`),
  ADD KEY `HR Username` (`hrUsername`),
  ADD KEY `Supervisor Username` (`supervisorUsername`),
  ADD KEY `Host Username` (`hostAcademic`);

--
-- Indexes for table `visitingAcademic`
--
ALTER TABLE `visitingAcademic`
  ADD PRIMARY KEY (`visitorId`),
  ADD KEY `Visitor Creator` (`hostAcademic`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `college`
--
ALTER TABLE `college`
  MODIFY `collegeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `schoolId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `visitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `visitingAcademic`
--
ALTER TABLE `visitingAcademic`
  MODIFY `visitorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `College To School` FOREIGN KEY (`collegeId`) REFERENCES `college` (`collegeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `User to School` FOREIGN KEY (`school_id`) REFERENCES `school` (`schoolId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `User to college` FOREIGN KEY (`college_id`) REFERENCES `college` (`collegeId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `vaLogin`
--
ALTER TABLE `vaLogin`
  ADD CONSTRAINT `vaLogin_ibfk_1` FOREIGN KEY (`visitorId`) REFERENCES `visitingAcademic` (`visitorId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `HR Username` FOREIGN KEY (`hrUsername`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Host Username` FOREIGN KEY (`hostAcademic`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Supervisor Username` FOREIGN KEY (`supervisorUsername`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Visitor` FOREIGN KEY (`visitorId`) REFERENCES `visitingAcademic` (`visitorId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visitingAcademic`
--
ALTER TABLE `visitingAcademic`
  ADD CONSTRAINT `Visitor Creator` FOREIGN KEY (`hostAcademic`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
