-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 08, 2024 at 04:50 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `bk_auth_admin`
--

DROP TABLE IF EXISTS `bk_auth_admin`;
CREATE TABLE IF NOT EXISTS `bk_auth_admin` (
  `adm_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ดูแล',
  `stf_id` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสพนักงาน',
  PRIMARY KEY (`adm_id`),
  UNIQUE KEY `stf_id` (`stf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ผู้ดูแล';

--
-- Dumping data for table `bk_auth_admin`
--

INSERT INTO `bk_auth_admin` (`adm_id`, `stf_id`) VALUES
(62, 'NjA='),
(66, 'Njc='),
(67, 'Njk='),
(63, 'NjQ='),
(64, 'NjU='),
(65, 'NjY='),
(68, 'NzE='),
(70, 'Nzg='),
(69, 'NzM=');

-- --------------------------------------------------------

--
-- Table structure for table `bk_auth_member`
--

DROP TABLE IF EXISTS `bk_auth_member`;
CREATE TABLE IF NOT EXISTS `bk_auth_member` (
  `mmb_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสมาชิก',
  `mmb_username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อผู้ใช้สมาชิก',
  `mmb_password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสผ่านสมาชิก',
  `mmb_firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อจริงสมาชิก',
  `mmb_lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'นามสกุลสมาชิก',
  `mmb_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'อีเมลสมาชิก',
  `mmb_coin` int NOT NULL DEFAULT '0' COMMENT 'เหรียญสมาชิก',
  `mmb_profile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png' COMMENT 'รูปประจำตัวสมาชิก',
  PRIMARY KEY (`mmb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='สมาชิก';

--
-- Dumping data for table `bk_auth_member`
--

INSERT INTO `bk_auth_member` (`mmb_id`, `mmb_username`, `mmb_password`, `mmb_firstname`, `mmb_lastname`, `mmb_email`, `mmb_coin`, `mmb_profile`) VALUES
(106, 'member2', '$2y$10$SuWAv9J1IAbqohah3Xlp/OnUKYh2sVc295g1zagaLB3w9jLa.nt5i', 'member', 'membe', 'member@member.com', 101, 'avatar.png'),
(107, 'member3', '$2y$10$PBVq7f4dJk9SVYfAfyhCjOxwLfiayF7hQOUn6ZcC1KpJ72rabCTF2', 'member', 'member', 'mmrber@mm.com', 1, 'avatar.png'),
(108, 'member5', '$2y$10$BGkzYTABSC25Oh4i6L3WnuSPUtlueL1jeInBJHdh4UrMxSXovvFH.', 'mm', 'mm', '1233@123.com', 0, 'avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `bk_auth_sale`
--

DROP TABLE IF EXISTS `bk_auth_sale`;
CREATE TABLE IF NOT EXISTS `bk_auth_sale` (
  `sle_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสเซล',
  `stf_id` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสพนักงาน',
  PRIMARY KEY (`sle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ฝ่ายขาย';

--
-- Dumping data for table `bk_auth_sale`
--

INSERT INTO `bk_auth_sale` (`sle_id`, `stf_id`) VALUES
(81, 'NjI='),
(83, 'NzI='),
(85, 'NzU='),
(87, 'Nzc=');

-- --------------------------------------------------------

--
-- Table structure for table `bk_auth_staff`
--

DROP TABLE IF EXISTS `bk_auth_staff`;
CREATE TABLE IF NOT EXISTS `bk_auth_staff` (
  `stf_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสพนักงาน',
  `stf_username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อผู้ใช้หนักงาน',
  `stf_password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสผ่านพนักงาน',
  `stf_firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อจริงพนักงาน',
  `stf_lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'นามสกุลพนักงาน',
  `stf_email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'อีเมลพนักงาน',
  `stf_coin` int NOT NULL DEFAULT '0' COMMENT 'เหรียญพนักงาน##',
  `stf_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png' COMMENT 'รูปประจำตัวพนักงาน',
  `stf_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'สถานะพนักงาน',
  PRIMARY KEY (`stf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='พนักงาน';

--
-- Dumping data for table `bk_auth_staff`
--

INSERT INTO `bk_auth_staff` (`stf_id`, `stf_username`, `stf_password`, `stf_firstname`, `stf_lastname`, `stf_email`, `stf_coin`, `stf_profile`, `stf_active`) VALUES
(41, 'superadmin', '$2y$10$QIEgXKkeEqzrU010coWS6u2DGy6Tl7kBHIsCYB5M5JLyILRjBCl82', 'ผู้ดูแลระบบสูงสุด', '.', 'superadmin@sup.sup', 0, '65e2e14c64af1_MV5BNGJmMWEzOGQtMWZkNS00MGNiLTk5NGEtYzg1YzAyZTgzZTZmXkEyXkFqcGdeQXVyMTE1MTYxNDAw._V1_.', 1),
(73, 'admin2', '$2y$10$RndCEdNiZhChnN4bnyJBleL2zSNWvjhIsNeUCfC7NGSG3qOZnXps6', 'admin3', 'admin3', 'admin2@admin.com3', 0, '65e91544dec41_ln0591-01.jpg', 1),
(76, 'staff3', '$2y$10$5cyk9gvi7EFhhMu66F.SReykR0jgQZHT1kE0PUHnFeRSnHHY7czZq', 'Staff1', 'satff1', 'stt@staff.com1', 0, '65e32fd4db4a4_ln0611-01.jpg', 1),
(77, 'saler2', '$2y$10$/K06Eeox1ps7Lhs3HqdMpOnDU3gXQPYEaML0KND6shS7assKkto2G', 'saler2', 'saler', 'saler@sale.com', 0, 'avatar.png', 1),
(78, 'admin3', '$2y$10$iUqbZIgp2JIjULxkT44KpeEZfIsCGLrWYBrXAEpnB1LrOfDvloGY2', 'adminadmi', 'admin', 'admin@aa.com', 0, 'avatar.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_auth_super_admin`
--

DROP TABLE IF EXISTS `bk_auth_super_admin`;
CREATE TABLE IF NOT EXISTS `bk_auth_super_admin` (
  `supadm_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ดูแลขั้นสูง',
  `stf_id` int NOT NULL COMMENT 'รหัสพนักงาน',
  PRIMARY KEY (`supadm_id`),
  UNIQUE KEY `stf_id` (`stf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ผู้ดูแลขั้นสูง';

--
-- Dumping data for table `bk_auth_super_admin`
--

INSERT INTO `bk_auth_super_admin` (`supadm_id`, `stf_id`) VALUES
(3, 41);

-- --------------------------------------------------------

--
-- Table structure for table `bk_fnd_finder`
--

DROP TABLE IF EXISTS `bk_fnd_finder`;
CREATE TABLE IF NOT EXISTS `bk_fnd_finder` (
  `fnd_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการหาหนังสือ',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `fnd_date` datetime NOT NULL COMMENT 'วันที่รายการหาหนังสือ',
  `fnd_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ชื่อหนังสือรายการหาหนังสือ',
  `fnd_author` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ชื่อผู้แต่งรายการหาหนังสือ',
  `fnd_publisher` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'สำนักพิมพ์รายการหาหนังสือ',
  `fnd_volumn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'หมายเลขเล่มรายการหาหนังสือ',
  `fnd_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รูปประกอบรายการหาหนังสือ',
  `fnd_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'รอการตรวจสอบ' COMMENT 'สถานะรายการหาหนังสือ',
  `fnd_price` int NOT NULL DEFAULT '0' COMMENT 'ราคารายการหาหนังสือ',
  `pay_id` tinyint NOT NULL COMMENT 'รหัสช่องทางชำระเงิน',
  `shp_id` tinyint NOT NULL COMMENT 'รหัสช่องทางขนส่ง',
  `fnd_address` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ที่อยู่จัดส่งรายการหาหนังสือ',
  `fnd_totalprice` decimal(10,2) DEFAULT NULL COMMENT 'ราคารวมรายการหาหนังสือ',
  `fnd_track` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT 'หมายเลขติดตามพัสดุรายการหาหนังสือ',
  PRIMARY KEY (`fnd_id`),
  KEY `mmb_id` (`mmb_id`),
  KEY `pay_id` (`pay_id`),
  KEY `ship_id` (`shp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='รายการตามหาหนังสือ';

--
-- Dumping data for table `bk_fnd_finder`
--

INSERT INTO `bk_fnd_finder` (`fnd_id`, `mmb_id`, `fnd_date`, `fnd_name`, `fnd_author`, `fnd_publisher`, `fnd_volumn`, `fnd_img`, `fnd_status`, `fnd_price`, `pay_id`, `shp_id`, `fnd_address`, `fnd_totalprice`, `fnd_track`) VALUES
(49, 106, '2024-03-02 10:17:44', 'aaaa', 'kml', '', '', '', 'จัดส่งสำเร็จ', 400, 19, 20, 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '450.00', '123456'),
(50, 106, '2024-03-06 19:31:38', 'aaaa', '', '', '', '', 'ไม่พบสินค้าที่ต้องการ', 0, 19, 20, NULL, NULL, '-'),
(51, 106, '2024-03-06 20:47:17', '', 'kml', '', '', '', 'จัดส่งสำเร็จ', 500, 19, 20, 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '550.00', '15926'),
(52, 106, '2024-03-07 11:03:59', 'หนังสือ', 'บันลือ', '', '', '', 'cancel', 200, 19, 20, NULL, NULL, '-'),
(53, 106, '2024-03-07 11:21:13', 'aa', '', '', '', '', 'ไม่พบสินค้าที่ต้องการ', 0, 19, 20, NULL, NULL, '-'),
(54, 106, '2024-03-07 11:21:55', 'หนังสือaa', 'aaa', 'bbb', 'ccc', '1000226853_front_XXL.jpg', 'ไม่พบสินค้าที่ต้องการ', 500, 19, 20, NULL, NULL, '-'),
(55, 106, '2024-03-07 14:09:30', 'aa', 'aa', 'lok', '', '1000226853_front_XXL_1.jpg', 'รอการตรวจสอบการชำระเงิน', 500, 19, 20, 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '550.00', '-'),
(56, 106, '2024-03-07 14:23:04', 'aaaa', 'bb', 'bb', 'bb', '1000221176_front_XXL.jpg', 'เลือกช่องทางส่งและช่องทางชำระ', 500, 19, 20, NULL, NULL, '-'),
(57, 106, '2024-03-07 14:26:30', 'aa', 'cc', 'cc', 'cc', '', 'ไม่พบสินค้าที่ต้องการ', 500, 19, 20, NULL, NULL, '-'),
(58, 106, '2024-03-07 14:30:01', 'aa', 'bb', '', '', '_ln_kusuriya_vol.jpg', 'รอสมาชิกตรวจสอบ', 500, 19, 20, NULL, NULL, '-');

-- --------------------------------------------------------

--
-- Table structure for table `bk_fnd_item`
--

DROP TABLE IF EXISTS `bk_fnd_item`;
CREATE TABLE IF NOT EXISTS `bk_fnd_item` (
  `fdit_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสตอบกลับการหาหนังสือ',
  `fnd_id` int NOT NULL COMMENT 'รหัสรานการหาหนังสือ',
  `fdit_detail` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดตอบกลับการหาหนังสือ',
  `fdit_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'สถานะตอบกลับการหาหนังสือ',
  `fdit_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อหนังสือตอบกลับการหาหนังสือ',
  `fdit_author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ผู้เขียนตอบกลับการหาหนังสือ',
  `fdit_publisher` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'สำนักพิมพ์ตอบกลับการหาหนังสือ',
  `fdit_volumn` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'หมายเลขเล่มตอบกลับการหาหนังสือ',
  `fdit_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รูปประกอบตอบกลับการหาหนังสือ',
  PRIMARY KEY (`fdit_id`),
  KEY `fnd_id` (`fnd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตอบกลับการหาหนังสือ';

--
-- Dumping data for table `bk_fnd_item`
--

INSERT INTO `bk_fnd_item` (`fdit_id`, `fnd_id`, `fdit_detail`, `fdit_status`, `fdit_name`, `fdit_author`, `fdit_publisher`, `fdit_volumn`, `fdit_img`) VALUES
(52, 49, 'รายละเอียด', 'ยืนยัน', 'Jujutsu', 'Siam Inter', 'Akira', '2', '1000223316_front_XXL_1709695134.jpg'),
(53, 51, 'bbbb', 'ปฏิเสธ', 'bbb', 'bbb', 'bbbb', 'bbb', '1000221176_front_XXL_1709732874.jpg'),
(54, 51, 'bbb', 'ยืนยัน', 'bbb', 'bbb', 'bbbb', 'bbb', '1000223316_front_XXL_1709732909.jpg'),
(55, 52, 'aaaa', 'ยืนยัน', 'sss', 'aaa', 'aaa', 'aa', '1000221176_front_XXL_1709784268.jpg'),
(56, 54, 'ขอข่อมูลเพิ่มเติม', 'ปฏิเสธ', 'หนังสือ', 'aaa', 'aaaa', 'aaa', '1000221176_front_XXL_1709785370.jpg'),
(57, 54, 'aaaa', 'ปฏิเสธ', 'aaa', 'aaa', 'aaa', 'aaa', '1000226853_front_XXL_1709795122.jpg'),
(58, 55, 'aa', 'ปฏิเสธ', 'aa', 'aa', 'aa', 'aa', '1000223316_front_XXL_1709795391.jpg'),
(59, 55, 'aa', 'ยืนยัน', 'aa', 'aa', 'aaa', 'aa', '1000226853_front_XXL_1709795432.jpg'),
(60, 56, 'aaa', 'ยืนยัน', 'aaa', 'aa', 'aa', 'aa', '1000219403_front_XXXL_1709796206.jpg'),
(61, 57, 'aa', 'ปฏิเสธ', 'aa', 'aa', 'aa', 'aa', '1000223316_front_XXL_1709796407.jpg'),
(62, 58, 'aa', 'ปฏิเสธ', 'aaa', 'aa', 'aa', 'aa', 'ln0591-01_1709796633.jpg'),
(63, 58, 'aaa', 'รอการยืนยัน', 'aaa', 'aaa', 'aaa', 'aaa', '_ln_kusuriya_vol_1709796936.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bk_fnd_notification`
--

DROP TABLE IF EXISTS `bk_fnd_notification`;
CREATE TABLE IF NOT EXISTS `bk_fnd_notification` (
  `fdnf_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสการชำระหารหาหนังสือ',
  `fnd_id` int NOT NULL COMMENT 'รหัสรายการหาหนังสือ',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `pay_id` tinyint NOT NULL COMMENT 'รหัสชำระเงิน',
  `fdnf_date` date NOT NULL COMMENT 'วันที่ชำระหารหาหนังสือ',
  `fdnf_amount` int NOT NULL COMMENT 'จำนวนเงินการชำระหารหาหนังสือ',
  `fdnf_status` tinyint NOT NULL DEFAULT '1' COMMENT 'สถานะการชำระหารหาหนังสือ',
  PRIMARY KEY (`fdnf_id`),
  KEY `pay_id` (`pay_id`),
  KEY `fnd_id` (`fnd_id`),
  KEY `mmb_id` (`mmb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='แจ้งชำระรายการหาหนังสือ';

--
-- Dumping data for table `bk_fnd_notification`
--

INSERT INTO `bk_fnd_notification` (`fdnf_id`, `fnd_id`, `mmb_id`, `pay_id`, `fdnf_date`, `fdnf_amount`, `fdnf_status`) VALUES
(18, 49, 106, 19, '2024-03-02', 450, 0),
(19, 51, 106, 19, '2024-03-06', 550, 0),
(20, 51, 106, 19, '2024-03-06', 550, 1),
(21, 55, 106, 19, '2024-03-07', 550, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_fnd_ntf_image`
--

DROP TABLE IF EXISTS `bk_fnd_ntf_image`;
CREATE TABLE IF NOT EXISTS `bk_fnd_ntf_image` (
  `fnimg_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสหลักฐานการชำระ',
  `fdnf_id` int NOT NULL COMMENT 'รหัสราการหาหนังสือ',
  `fnimg_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รูปภาพหลักฐานการชำระเงิน',
  PRIMARY KEY (`fnimg_id`),
  KEY `fdnf_id` (`fdnf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='หลักฐานการชำระเงินการหาหนังสือ';

--
-- Dumping data for table `bk_fnd_ntf_image`
--

INSERT INTO `bk_fnd_ntf_image` (`fnimg_id`, `fdnf_id`, `fnimg_image`) VALUES
(11, 18, '65e7e0b76cacc.png'),
(12, 19, '65e87443c5eab.png'),
(13, 20, '65e8745a1ae5e.png'),
(14, 21, '65e96b1d50f7e.png');

-- --------------------------------------------------------

--
-- Table structure for table `bk_mmb_address`
--

DROP TABLE IF EXISTS `bk_mmb_address`;
CREATE TABLE IF NOT EXISTS `bk_mmb_address` (
  `addr_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสที่อยู่สมาชิก',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `addr_detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดที่อยู่',
  `addr_provin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'จังหวัด',
  `addr_amphu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'อำเภอ',
  `addr_postal` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสไปรษณีย์',
  `addr_phone` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'เบอร์ติดต่อ',
  `addr_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อผู้รับ',
  `addr_lastname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'นามสกุลผู้รับ',
  `addr_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'สถานะที่อยู่สมาชิก',
  PRIMARY KEY (`addr_id`),
  UNIQUE KEY `addr_id` (`addr_id`),
  KEY `mmb_id` (`mmb_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ที่อยู่สมาชิก';

--
-- Dumping data for table `bk_mmb_address`
--

INSERT INTO `bk_mmb_address` (`addr_id`, `mmb_id`, `addr_detail`, `addr_provin`, `addr_amphu`, `addr_postal`, `addr_phone`, `addr_name`, `addr_lastname`, `addr_active`) VALUES
(51, 106, '2/2 หมู่ 7 ต.หนองแก', 'นครนายก', 'หัวหิน', '84130', '123456789', 'ธฤต', 'อ่างทอง', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_mmb_coin_history`
--

DROP TABLE IF EXISTS `bk_mmb_coin_history`;
CREATE TABLE IF NOT EXISTS `bk_mmb_coin_history` (
  `cnh_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสประวัติการโอนเหรียญ',
  `mmb_id` int DEFAULT NULL COMMENT 'รหัสสมาชิก',
  `cnh_income` int DEFAULT NULL COMMENT 'จำนวนเหรียญที่ได้รับ',
  `cnh_outcome` int DEFAULT NULL COMMENT 'จำนวนเหรียญที่ใช้',
  `cnh_coin` int NOT NULL COMMENT 'จำเหรียญคงเหลือ',
  `cnh_detail` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดการโอนเหรียญ',
  `cnh_date` datetime NOT NULL COMMENT 'วันที่โอนเหรียญ',
  PRIMARY KEY (`cnh_id`),
  KEY `mmb_id` (`mmb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ประวัติการโอนและได้รับเหรียญ';

--
-- Dumping data for table `bk_mmb_coin_history`
--

INSERT INTO `bk_mmb_coin_history` (`cnh_id`, `mmb_id`, `cnh_income`, `cnh_outcome`, `cnh_coin`, `cnh_detail`, `cnh_date`) VALUES
(55, 106, 50, 0, 50, 'ได้รับเหรียญจากรายการสั่งซื้อ 74', '2024-03-06 10:13:58'),
(56, 106, 0, 10, -10, 'ใช้เหรียญเป็นส่วนลดในการสั่งซื้อ', '2024-03-06 10:15:45'),
(57, 106, 8, 0, 48, 'ได้รับเหรียญจากรายการสั่งซื้อ 75', '2024-03-06 10:16:11'),
(58, 106, 10, 0, 58, 'ได้รับเหรียญจากรายการสั่งซื้อ 77', '2024-03-06 13:37:35'),
(59, 106, 18, 0, 76, 'ได้รับเหรียญจากรายการสั่งซื้อ 79', '2024-03-06 13:38:55'),
(60, 106, 0, 1, 75, 'โอนเหรียญไปยังสมาชิก member3', '2024-03-06 19:40:28'),
(61, 106, 8, 0, 83, 'ได้รับเหรียญจากรายการสั่งซื้อ 80', '2024-03-06 19:45:19'),
(62, 106, 10, 0, 93, 'ได้รับเหรียญจากรายการสั่งซื้อ 81', '2024-03-07 10:59:46'),
(63, 106, 8, 0, 101, 'ได้รับเหรียญจากรายการสั่งซื้อ 82', '2024-03-07 11:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `bk_mmb_wishlist`
--

DROP TABLE IF EXISTS `bk_mmb_wishlist`;
CREATE TABLE IF NOT EXISTS `bk_mmb_wishlist` (
  `wsl_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสิ่งที่อยากได้',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`wsl_id`),
  KEY `mmb_id` (`mmb_id`),
  KEY `prd_id` (`prd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='สิ่งที่อยากได้';

--
-- Dumping data for table `bk_mmb_wishlist`
--

INSERT INTO `bk_mmb_wishlist` (`wsl_id`, `mmb_id`, `prd_id`) VALUES
(11, 106, 88);

-- --------------------------------------------------------

--
-- Table structure for table `bk_ord_item`
--

DROP TABLE IF EXISTS `bk_ord_item`;
CREATE TABLE IF NOT EXISTS `bk_ord_item` (
  `ordi_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสไอเท็ม',
  `ord_id` int NOT NULL COMMENT 'รหัสรายการซื้อ',
  `ordi_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รูปภาพไอเท็ม',
  `ordi_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อไอเท็ม',
  `ordi_detail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดไอเท็ม',
  `ordi_quan` int NOT NULL COMMENT 'จำนวนไอเท็ม',
  `ordi_total` decimal(10,2) NOT NULL COMMENT 'ราคารวมไอเท็ม',
  `ordi_coin` int NOT NULL DEFAULT '0' COMMENT 'จำนวนเหรียญไอเท็ม',
  PRIMARY KEY (`ordi_id`),
  KEY `ord_id` (`ord_id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='สินค้าในรายการสั่งซื้อ';

--
-- Dumping data for table `bk_ord_item`
--

INSERT INTO `bk_ord_item` (`ordi_id`, `ord_id`, `ordi_image`, `ordi_name`, `ordi_detail`, `ordi_quan`, `ordi_total`, `ordi_coin`) VALUES
(175, 74, '87.jpg', 'มหาเวทย์ผนึกมาร เล่ม 2', 'ความทุกข์ ความเสียใจ ความอับอาย พลังอัปมงคล\r\nที่เกิดขึ้นจากความรู้สึกลบของมนุษย์นั้น จะนำผู้คนไปสุ่ค', 5, '400.00', 50),
(176, 75, '88.jpg', 'มหาเวทย์ผนึกมาร เล่ม 3', 'โทโด อาโออิกับเซนอิง ไมแห่งโรงเรียนเฉพาะทางอาคม\r\nเกียวโตปรากฏตัวขึ้นต่อหน้าฟุชิงุโระและคุกิซาคิ! โทโ', 1, '80.00', 8),
(177, 76, '88.jpg', 'มหาเวทย์ผนึกมาร เล่ม 3', 'โทโด อาโออิกับเซนอิง ไมแห่งโรงเรียนเฉพาะทางอาคม\r\nเกียวโตปรากฏตัวขึ้นต่อหน้าฟุชิงุโระและคุกิซาคิ! โทโ', 1, '80.00', 8),
(178, 77, '95.jpg', '(พรีออเดอร์) สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 5', 'สินค้า Pre-Order จะถูกจัดส่งภายในเดือนตุลาคม 2565', 1, '325.00', 10),
(179, 78, '87.jpg', 'มหาเวทย์ผนึกมาร เล่ม 2', 'ความทุกข์ ความเสียใจ ความอับอาย พลังอัปมงคล\r\nที่เกิดขึ้นจากความรู้สึกลบของมนุษย์นั้น จะนำผู้คนไปสุ่ค', 5, '400.00', 50),
(180, 79, '89.jpg', 'มหาเวทย์ผนึกมาร เล่ม 4', 'มาฮิโตะใช้ประโยชน์จากจุนเปและวางแผนให้สู้กับอิตาโดริ ซึ่งจุนเปตกหลุมแผนการนั้น...', 1, '80.00', 8),
(181, 79, '95.jpg', '(พรีออเดอร์) สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 5', 'สินค้า Pre-Order จะถูกจัดส่งภายในเดือนตุลาคม 2565', 1, '325.00', 10),
(182, 80, '90.jpg', 'มหาเวทย์ผนึกมาร เล่ม 5', 'กลุ่มเกียวโตคนอื่นๆ กลับมาร่วมต่อสู้เพื่อลอบสังหาร อิตาโดริทำให้อิตาโดริอยู่ในวิกฤติ!!', 1, '80.00', 8),
(183, 81, '95.jpg', '(พรีออเดอร์) สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 5', 'สินค้า Pre-Order จะถูกจัดส่งภายในเดือนตุลาคม 2565', 1, '325.00', 10),
(184, 82, '89.jpg', 'มหาเวทย์ผนึกมาร เล่ม 4', 'มาฮิโตะใช้ประโยชน์จากจุนเปและวางแผนให้สู้กับอิตาโดริ ซึ่งจุนเปตกหลุมแผนการนั้น...', 1, '80.00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `bk_ord_notification`
--

DROP TABLE IF EXISTS `bk_ord_notification`;
CREATE TABLE IF NOT EXISTS `bk_ord_notification` (
  `ntf_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสการแจ้งชำระเงิน',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `pay_id` tinyint NOT NULL COMMENT 'รหัสช่องทางการชำระ',
  `ntf_date` datetime NOT NULL COMMENT 'วันที่ชำระ',
  `ntf_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'หลักฐานการชำระ',
  `ntf_amount` int NOT NULL COMMENT 'ยอดเงินการชำระ',
  `ord_id` int NOT NULL COMMENT 'รหัสรายการซื้อ',
  `ntf_status` tinyint NOT NULL DEFAULT '1' COMMENT 'สถานะการแจ้งชำระ',
  PRIMARY KEY (`ntf_id`),
  KEY `mmb_id` (`mmb_id`),
  KEY `ord_id` (`ord_id`),
  KEY `pay_id` (`pay_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='รายละเอียดการชำระเงิน';

--
-- Dumping data for table `bk_ord_notification`
--

INSERT INTO `bk_ord_notification` (`ntf_id`, `mmb_id`, `pay_id`, `ntf_date`, `ntf_img`, `ntf_amount`, `ord_id`, `ntf_status`) VALUES
(86, 106, 19, '2024-03-06 10:10:00', NULL, 450, 74, 0),
(87, 106, 19, '2024-03-06 10:15:00', NULL, 120, 75, 0),
(88, 106, 19, '2024-03-06 13:36:00', NULL, 375, 77, 0),
(89, 106, 19, '2024-03-06 13:36:00', NULL, 455, 79, 1),
(90, 106, 19, '2024-03-06 13:38:00', NULL, 455, 79, 0),
(91, 106, 19, '2024-03-06 19:45:00', NULL, 130, 80, 0),
(92, 106, 19, '2024-03-07 10:59:00', NULL, 375, 81, 0),
(93, 106, 20, '2024-03-07 11:12:00', NULL, 114, 82, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bk_ord_ntf_image`
--

DROP TABLE IF EXISTS `bk_ord_ntf_image`;
CREATE TABLE IF NOT EXISTS `bk_ord_ntf_image` (
  `nimg_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสหลักฐานชำระเงิน',
  `ntf_id` int NOT NULL COMMENT 'รหัสการแจ้งชำระ',
  `nimg_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รูปหลักฐานการชำระ',
  PRIMARY KEY (`nimg_id`),
  KEY `ntf_id` (`ntf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='รูปภาพหละกฐานการชำระเงิน';

--
-- Dumping data for table `bk_ord_ntf_image`
--

INSERT INTO `bk_ord_ntf_image` (`nimg_id`, `ntf_id`, `nimg_img`) VALUES
(77, 86, '65e7deb813f1d.png'),
(78, 87, '65e7dfebbcf74.png'),
(79, 88, '65e80ee18070d.png'),
(80, 89, '65e80f0c462d5.png'),
(81, 90, '65e80f7679e07.png'),
(82, 91, '65e865576c35a.png'),
(83, 92, '65e93baad5315.png'),
(84, 93, '65e93ebf2357f.png');

-- --------------------------------------------------------

--
-- Table structure for table `bk_ord_orders`
--

DROP TABLE IF EXISTS `bk_ord_orders`;
CREATE TABLE IF NOT EXISTS `bk_ord_orders` (
  `ord_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการซื้อ',
  `ord_date` datetime NOT NULL COMMENT 'เวลาสั่งซื้อ',
  `ord_amount` decimal(10,2) NOT NULL COMMENT 'ราคารายการสั่งซื้อ',
  `ord_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ที่อยู่จัดส่งราการซื้อ',
  `ord_payment` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสช่องทางชำระ',
  `ord_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'สถานะรายการสั่งซื้อ',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `ord_detail` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดรายการสั่งซื้อ',
  `ord_coin` int NOT NULL COMMENT 'เหรียญที่ได้รับ',
  `shp_id` tinyint NOT NULL COMMENT 'รหัสช่องทางชำระ',
  PRIMARY KEY (`ord_id`),
  KEY `mmb_id` (`mmb_id`),
  KEY `shp_id` (`shp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='รายการสั่งซื้อ';

--
-- Dumping data for table `bk_ord_orders`
--

INSERT INTO `bk_ord_orders` (`ord_id`, `ord_date`, `ord_amount`, `ord_address`, `ord_payment`, `ord_status`, `mmb_id`, `ord_detail`, `ord_coin`, `shp_id`) VALUES
(74, '2024-02-08 03:10:38', '450.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'จัดส่งสำเร็จ', 106, '12345678', 50, 20),
(75, '2024-02-15 03:15:45', '120.00', 'aaa aaa aaaa กาฬสินธุ์ aaaa 77110 0956861917', '19', 'จัดส่งสำเร็จ', 106, '12345678', 8, 20),
(76, '2024-03-06 05:05:52', '130.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'cancel', 106, '-', 8, 20),
(77, '2024-03-06 06:36:07', '375.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'จัดส่งสำเร็จ', 106, '3333333', 10, 20),
(78, '2024-03-06 06:36:33', '450.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'cancel', 106, '-', 50, 20),
(79, '2024-03-06 06:36:52', '455.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'จัดส่งสำเร็จ', 106, '123456', 18, 20),
(80, '2024-03-06 12:44:59', '130.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'จัดส่งสำเร็จ', 106, '123465', 8, 20),
(81, '2024-03-07 03:59:30', '375.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '19', 'เตรียมจัดส่งสินค้า', 106, '-', 10, 20),
(82, '2024-03-07 04:12:27', '114.00', 'ธฤต อ่างทอง 2/2 หมู่ 7 ต.หนองแก นครนายก หัวหิน 84130 123456789', '20', 'จัดส่งสำเร็จ', 106, '12345', 8, 20);

-- --------------------------------------------------------

--
-- Table structure for table `bk_ord_payment`
--

DROP TABLE IF EXISTS `bk_ord_payment`;
CREATE TABLE IF NOT EXISTS `bk_ord_payment` (
  `pay_id` tinyint NOT NULL AUTO_INCREMENT COMMENT 'รหัสช่องทางชำระเงิน',
  `pay_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อช่องทางชำระเงิน',
  `pay_detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดช่องทางชำระเงิน',
  `pay_logo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'โลโก้ช่องทางชำระเงิน',
  `pay_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'รูปช่องทางชำระเงิน',
  `pay_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงช่องทางชำระเงิน',
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ช่องทางการชำระเงิน';

--
-- Dumping data for table `bk_ord_payment`
--

INSERT INTO `bk_ord_payment` (`pay_id`, `pay_name`, `pay_detail`, `pay_logo`, `pay_img`, `pay_show`) VALUES
(19, 'Paypal', 'นายธฤต อ่างทอง, 098-765-4321', 'download.png', '9948648137252e9edf393c02ff0a5fca.jpg', 1),
(20, 'กสิกรณ์', 'นายธฤต อ่างทอง | 098-765-4321', '_ln_kusuriya_no_hitorigoto_vol7_jacket_cover.jpg', '9948648137252e9edf393c02ff0a5fca.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_ord_shipping`
--

DROP TABLE IF EXISTS `bk_ord_shipping`;
CREATE TABLE IF NOT EXISTS `bk_ord_shipping` (
  `shp_id` tinyint NOT NULL AUTO_INCREMENT COMMENT 'รหัสช่องทางขนส่ง',
  `shp_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อช่องทางขนส่ง',
  `shp_detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดช่องทางขนส่ง',
  `shp_price` int NOT NULL COMMENT 'ราคาช่องทางขนส่ง',
  `shp_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงช่องทางขนส่ง',
  PRIMARY KEY (`shp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ช่องทางการขนส่ง';

--
-- Dumping data for table `bk_ord_shipping`
--

INSERT INTO `bk_ord_shipping` (`shp_id`, `shp_name`, `shp_detail`, `shp_price`, `shp_show`) VALUES
(20, 'Flash', 'บริการขนส่ง Flash', 50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_password_reset`
--

DROP TABLE IF EXISTS `bk_password_reset`;
CREATE TABLE IF NOT EXISTS `bk_password_reset` (
  `prs_id` tinyint NOT NULL AUTO_INCREMENT,
  `mmb_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prs_token` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prs_date` datetime NOT NULL,
  PRIMARY KEY (`prs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bk_password_reset`
--

INSERT INTO `bk_password_reset` (`prs_id`, `mmb_email`, `prs_token`, `prs_date`) VALUES
(1, 'www.bookba@gmail.com', 'c9a229e0fdddab29505704d3ad6e8ea045fd81aa2c0ed971d6affcc642b5e1ba', '2024-02-19 20:21:25'),
(2, 'www.bookba@gmail.com', '004392d0bbde11af864197b8c5c0553e96470252e8e196007e9b7343b3754c03', '2024-02-19 20:29:40'),
(3, 'www.bookba@gmail.com', 'd434dcde2f4deb09ea93f97b2924da7ac2ee67ec933b7c5967542c21b3b1e22b', '2024-02-19 22:33:50'),
(4, 'www.bookba@gmail.com', '7f527c0806a8d904aa26a8eca181e9efde28ac0d9c5b43e55ec02dba1433e1c6', '2024-02-19 22:34:39'),
(5, 'www.bookba@gmail.com', 'cd4711f9fe6d8f02e9c8a627c2ee1a561b96de0f249a5a42ce6c2d7984cd349a', '2024-02-19 22:35:27'),
(6, 'www.bookba@gmail.com', '6ca11ad4545c3b319f4ca8740f58cb40f0576d8ea490761f86d8867f61614c09', '2024-02-19 22:36:27'),
(7, 'www.bookba@gmail.com', '94daaad801a420ab69dcafd0d02943030c61f9d0b2780b50c4917c138300460f', '2024-02-19 22:38:04'),
(8, 'www.bookba@gmail.com', '561c2269fe651580c3779a6a1441c1a0722dfcd82b04683938f1ba69e8449b9a', '2024-02-19 22:40:12'),
(9, 'www.bookba@gmail.com', 'cce19059e44ad8e0341fca103c0d20e496464faf62d3b8ac54db6a73d9f8ed7e', '2024-02-19 22:42:53'),
(10, 'www.bookba@gmail.com', '8b517bb6924823e26dccad213a7e7f949505d052ceb4783a2f4fc6cd9271bdc9', '2024-02-20 16:29:15'),
(11, 'www.bookba@gmail.com', '89b73583aaa4e27f444c0fd40b35cd0223e3293ad2c74403d3d85d1cdd431f12', '2024-02-20 16:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `bk_prd_comment`
--

DROP TABLE IF EXISTS `bk_prd_comment`;
CREATE TABLE IF NOT EXISTS `bk_prd_comment` (
  `cmm_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสรีวิว',
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า',
  `mmb_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `cmm_rating` int NOT NULL DEFAULT '5' COMMENT 'คะแนนรีวิว',
  `cmm_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'รายละเอียดรีวิว',
  `cmm_date` datetime NOT NULL COMMENT 'วันที่รีวิว',
  `cmm_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงรีวิว',
  PRIMARY KEY (`cmm_id`),
  KEY `prd_id` (`prd_id`) USING BTREE,
  KEY `mmb_id` (`mmb_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ความคิดเห็นสินค้่า';

--
-- Dumping data for table `bk_prd_comment`
--

INSERT INTO `bk_prd_comment` (`cmm_id`, `prd_id`, `mmb_id`, `cmm_rating`, `cmm_detail`, `cmm_date`, `cmm_show`) VALUES
(40, 87, 106, 4, '5555', '2024-03-01 10:06:54', 1),
(41, 89, 106, 4, '2222', '2024-03-07 11:07:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_prd_image`
--

DROP TABLE IF EXISTS `bk_prd_image`;
CREATE TABLE IF NOT EXISTS `bk_prd_image` (
  `prim_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสรูปสินค้า***',
  `prim_name` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รูปสินค้า***',
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า***',
  PRIMARY KEY (`prim_id`),
  KEY `prd_id` (`prd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='รูปสินค้า';

-- --------------------------------------------------------

--
-- Table structure for table `bk_prd_product`
--

DROP TABLE IF EXISTS `bk_prd_product`;
CREATE TABLE IF NOT EXISTS `bk_prd_product` (
  `prd_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสินค้า',
  `prd_img` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'book.jpg' COMMENT 'รูปสินค้า',
  `prd_name` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อสินค้า',
  `prd_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดสินค้า',
  `prd_price` int NOT NULL COMMENT 'ราคาสินค้า',
  `prd_coin` int NOT NULL COMMENT 'เหรียญสินค้า',
  `prd_qty` int NOT NULL COMMENT 'จำนวนสินค้า',
  `prd_discount` int NOT NULL DEFAULT '0' COMMENT 'ส่วนลดสินค้า',
  `prd_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงสินค้า',
  `prd_preorder` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'สินค้าพรีออเดอร์',
  `pty_id` int NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `publ_id` int NOT NULL COMMENT 'รหัสสำนักพิมพ์',
  `prp_id` int NOT NULL COMMENT 'รหัสสำนักพิมพ์',
  PRIMARY KEY (`prd_id`),
  KEY `pty_id` (`pty_id`) USING BTREE,
  KEY `publ_id` (`publ_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='สินค้า';

--
-- Dumping data for table `bk_prd_product`
--

INSERT INTO `bk_prd_product` (`prd_id`, `prd_img`, `prd_name`, `prd_detail`, `prd_price`, `prd_coin`, `prd_qty`, `prd_discount`, `prd_show`, `prd_preorder`, `pty_id`, `publ_id`, `prp_id`) VALUES
(86, '86.jpg', 'มหาเวทย์ผนึกมาร เล่ม 1', 'วัตถุต้องสาป ที่หลับอยู่ในโรงเรียนก็ถูกปลดออกทำให้สัตว์ประหลาดปรากฏตัว อิตาโดริจึงจะบุกเข้าไปในอาคารเรียนเพื่อช่วยรุ่นพี่', 60, 10, 10, 0, 1, 0, 131, 28, 0),
(87, '87.jpg', 'มหาเวทย์ผนึกมาร เล่ม 2', 'ความทุกข์ ความเสียใจ ความอับอาย พลังอัปมงคล\r\nที่เกิดขึ้นจากความรู้สึกลบของมนุษย์นั้น จะนำผู้คนไปสุ่ความตาย\r\nนักเรียนม.ปลาย ที่มีความสามารถทางด้านร่างกายอันน่าตกใจ', 80, 10, 70, 0, 1, 0, 131, 28, 0),
(88, '88.jpg', 'มหาเวทย์ผนึกมาร เล่ม 3', 'โทโด อาโออิกับเซนอิง ไมแห่งโรงเรียนเฉพาะทางอาคม\r\nเกียวโตปรากฏตัวขึ้นต่อหน้าฟุชิงุโระและคุกิซาคิ! โทโดถามถึง\r\nสเป็คผู้หญิงที่ชอบ แล้วคำตอบที่ฟุชิงุโระพูดออกมาคือ', 80, 8, 78, 0, 0, 0, 131, 28, 0),
(89, '89.jpg', 'มหาเวทย์ผนึกมาร เล่ม 4', 'มาฮิโตะใช้ประโยชน์จากจุนเปและวางแผนให้สู้กับอิตาโดริ ซึ่งจุนเปตกหลุมแผนการนั้น...', 80, 8, 78, 0, 1, 0, 131, 28, 0),
(90, '90.jpg', 'มหาเวทย์ผนึกมาร เล่ม 5', 'กลุ่มเกียวโตคนอื่นๆ กลับมาร่วมต่อสู้เพื่อลอบสังหาร อิตาโดริทำให้อิตาโดริอยู่ในวิกฤติ!!', 80, 8, 79, 0, 1, 0, 131, 28, 0),
(91, '91.jpg', 'สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 1', 'ณ อาณาจักรใหญ่ยักษ์แห่งหนึ่งซึ่งตั้งอยู่ใจกลางทวีป เด็กสาวนางหนึ่งผู้ทำงานเป็นหมอยาในสถานเริงรมย์ย่านโคมแดงอันมีนามว่า ‘เมาเมา’ บัดนี้เกิดจับพลัดจับผลูต้องมาทำงานรับใช้อยู่ในวังหลัง', 295, 3, 50, 5, 1, 0, 132, 29, 0),
(92, '92.jpg', 'สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 2', 'เมาเมาได้กลับไปยังย่านเริงรมย์อีกครั้งหลังถูกเลิกจ้างจากการทำงานรับใช้ในวังหลัง หากไม่ทันไรก็กลายเป็นว่าเธอต้องไปทำงานที่ราชสำนักฝ่ายนอกในฐานะผู้ติดตามรับใช้ของจินชิ ขันทีผู้งดงามปานนางฟ้านางสวรรค์', 315, 3, 50, 5, 1, 0, 132, 29, 0),
(93, '93.jpg', 'สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 3', 'การตั้งครรภ์ของพระสนมเกียคุโยทำให้เมาเมาได้กลับมายังวังหลังอีกครั้ง ด้วยความที่พระนางเป็นสนมคนโปรดขององค์จักรพรรดิ เรื่องนี้จึงต้องปิดเป็นความลับ ทว่าการหยั่งเชิงกันในหมู่สตรีก็ยังเกิดขึ้นอย่างไม่ว่าง', 345, 5, 50, 0, 1, 0, 132, 29, 0),
(94, '94.jpg', 'สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 4', 'เมามารู้มาว่าเสี่ยวหลันสหายของเธอกำลังหางานทำเผื่อไว้ตอนออกจากวังหลัง และเพื่อช่วยเสี่ยวหลัน เมาเมากับชิซุยจึงมุ่งหน้าไปหาเส้นสายที่โรงอาบน้ำรวม ตอนนั้นเอง เมาเมาก็ได้ยินว่าพระสนมหลีชู่ผู้อ่อนไหวเจอผี', 325, 5, 5, 0, 1, 0, 132, 29, 0),
(95, '95.jpg', '(พรีออเดอร์) สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 5', 'สินค้า Pre-Order จะถูกจัดส่งภายในเดือนตุลาคม 2565', 325, 10, 47, 0, 1, 1, 132, 29, 0),
(96, '96.jpg', 'สืบคดีปริศนา หมอยาตำรับโคมแดง เล่ม 6', 'เมาเมาถูกจินชิขอแต่งงานที่เมืองตะวันตก ความสัมพันธ์ที่คลุมเครือมาตลอดกำลังจะเปลี่ยนแปลงไปอย่างมาก จินชิร้อนรนเพราะเมาเมาอยากคบหากันเหมือนเดิม', 325, 3, 50, 0, 1, 0, 132, 29, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bk_prd_promotion`
--

DROP TABLE IF EXISTS `bk_prd_promotion`;
CREATE TABLE IF NOT EXISTS `bk_prd_promotion` (
  `ppm_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสินค้าโปรโมชัน',
  `prp_id` int NOT NULL COMMENT 'รหัสโปรโมชัน',
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า',
  PRIMARY KEY (`ppm_id`),
  KEY `prp_id` (`prp_id`),
  KEY `prd_id` (`prd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='สินค้าโปรโมชัน';

-- --------------------------------------------------------

--
-- Table structure for table `bk_prd_publisher`
--

DROP TABLE IF EXISTS `bk_prd_publisher`;
CREATE TABLE IF NOT EXISTS `bk_prd_publisher` (
  `publ_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสำนักพิมพ์',
  `publ_name` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อสำนักพิมพ์',
  `publ_detail` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดสำนักพิมพ์',
  PRIMARY KEY (`publ_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='สำนักพิมพ์';

--
-- Dumping data for table `bk_prd_publisher`
--

INSERT INTO `bk_prd_publisher` (`publ_id`, `publ_name`, `publ_detail`) VALUES
(28, 'Saim Inter', 'สยามอินเตอร์'),
(29, 'Phoenixnext', 'สำนักพิมพ์ฟีนิกซ์เน็กซ์');

-- --------------------------------------------------------

--
-- Table structure for table `bk_prd_type`
--

DROP TABLE IF EXISTS `bk_prd_type`;
CREATE TABLE IF NOT EXISTS `bk_prd_type` (
  `pty_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทสินค้า',
  `pty_name` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อประเภทสินค้า',
  `pty_detail` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดประเภทสินค้า',
  `pty_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงประเภทสินค้า',
  PRIMARY KEY (`pty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ประเภทสินค้า';

--
-- Dumping data for table `bk_prd_type`
--

INSERT INTO `bk_prd_type` (`pty_id`, `pty_name`, `pty_detail`, `pty_show`) VALUES
(131, 'มังงะ', 'หนังสือการ์ตูน, มังงะ', 1),
(132, 'นิยาย', 'หนังสือนวนิยาย นิยาย ไลท์โนเวล', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_promotion`
--

DROP TABLE IF EXISTS `bk_promotion`;
CREATE TABLE IF NOT EXISTS `bk_promotion` (
  `prp_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสโปรโมชัน',
  `prp_name` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อโปรโมชัน',
  `prp_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดโปรโมชัน',
  `prp_discount` int NOT NULL COMMENT 'ส่วนลดโปรโมชัน',
  `prp_start` date NOT NULL COMMENT 'วันที่เริ่มโปรโมชัน',
  `prp_end` date NOT NULL COMMENT 'วันที่สิ้นสุดโปรโมชัน',
  `prp_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงโปรโมชัน',
  PRIMARY KEY (`prp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='โปรโมชันสินค้า';

--
-- Dumping data for table `bk_promotion`
--

INSERT INTO `bk_promotion` (`prp_id`, `prp_name`, `prp_detail`, `prp_discount`, `prp_start`, `prp_end`, `prp_show`) VALUES
(69, 'ไม่เลือกโปรโมชัน', 'ไม่มีโปรโมชัน', 0, '2000-02-21', '4000-02-05', 1),
(123, '3.3', 'โปรโมชันวันที่ 3 เดือน 3', 20, '2024-03-01', '2024-03-06', 1),
(124, '2.2', '222', 20, '2024-02-28', '2024-03-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bk_province`
--

DROP TABLE IF EXISTS `bk_province`;
CREATE TABLE IF NOT EXISTS `bk_province` (
  `prov_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสจังหวัด',
  `prov_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อจังหวัด',
  PRIMARY KEY (`prov_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='จังหวัด';

--
-- Dumping data for table `bk_province`
--

INSERT INTO `bk_province` (`prov_id`, `prov_name`) VALUES
(1, 'กรุงเทพมหานคร'),
(2, 'กระบี่'),
(3, 'กาญจนบุรี'),
(4, 'กาฬสินธุ์'),
(5, 'กำแพงเพชร'),
(6, 'ขอนแก่น'),
(7, 'จันทบุรี'),
(8, 'ฉะเชิงเทรา'),
(9, 'ชลบุรี'),
(10, 'ชัยนาท'),
(11, 'ชัยภูมิ'),
(12, 'ชุมพร'),
(13, 'เชียงราย'),
(14, 'เชียงใหม่'),
(15, 'ตรัง'),
(16, 'ตราด'),
(17, 'ตาก'),
(18, 'นครนายก'),
(19, 'นครปฐม'),
(20, 'นครพนม'),
(21, 'นครราชสีมา'),
(22, 'นครศรีธรรมราช'),
(23, 'นครสวรรค์'),
(24, 'นนทบุรี'),
(25, 'นราธิวาส'),
(26, 'น่าน'),
(27, 'บึงกาฬ'),
(28, 'บุรีรัมย์'),
(29, 'ปทุมธานี'),
(30, 'ประจวบคีรีขันธ์'),
(31, 'ปราจีนบุรี'),
(32, 'ปัตตานี'),
(33, 'พระนครศรีอยุธยา'),
(34, 'พังงา'),
(35, 'พัทลุง'),
(36, 'พิจิตร'),
(37, 'พิษณุโลก'),
(38, 'เพชรบุรี'),
(39, 'เพชรบูรณ์'),
(40, 'แพร่'),
(41, 'พะเยา'),
(42, 'ภูเก็ต'),
(43, 'มหาสารคาม'),
(44, 'มุกดาหาร'),
(45, 'แม่ฮ่องสอน'),
(46, 'ยะลา'),
(47, 'ยโสธร'),
(48, 'ร้อยเอ็ด'),
(49, 'ระนอง'),
(50, 'ระยอง'),
(51, 'ราชบุรี'),
(52, 'ลพบุรี'),
(53, 'ลำปาง'),
(54, 'ลำพูน'),
(55, 'เลย'),
(56, 'ศรีสะเกษ'),
(57, 'สกลนคร'),
(58, 'สงขลา'),
(59, 'สตูล'),
(60, 'สมุทรปราการ'),
(61, 'สมุทรสงคราม'),
(62, 'สมุทรสาคร'),
(63, 'สระแก้ว'),
(64, 'สระบุรี'),
(65, 'สิงห์บุรี'),
(66, 'สุโขทัย'),
(67, 'สุพรรณบุรี'),
(68, 'สุราษฎร์ธานี'),
(69, 'สุรินทร์'),
(70, 'หนองคาย'),
(71, 'หนองบัวลำภู'),
(72, 'อ่างทอง'),
(73, 'อำนาจเจริญ'),
(74, 'อุดรธานี'),
(75, 'อุตรดิตถ์'),
(76, 'อุทัยธานี'),
(77, 'อุบลราชธานี'),
(78, 'อ่างทอง');

-- --------------------------------------------------------

--
-- Table structure for table `bk_setting`
--

DROP TABLE IF EXISTS `bk_setting`;
CREATE TABLE IF NOT EXISTS `bk_setting` (
  `set_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสตังค่า',
  `set_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อการตั้งค่า',
  `set_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'ชื่อรูปภาพ, ข้อความที่แสดง',
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตั้งค่าเว็บไซต์';

--
-- Dumping data for table `bk_setting`
--

INSERT INTO `bk_setting` (`set_id`, `set_name`, `set_detail`) VALUES
(1, 'titleweb', 'bookstore'),
(2, 'logo', '2.png'),
(3, 'titlemain', ' '),
(4, 'banner_1', '4.jpg'),
(5, 'banner_1_text', '<h1>Hi</h1><h2>Hello</h2>'),
(6, 'banner_2', '6.png'),
(7, 'banner_3', '7.png'),
(8, 'banner_4', '8.png'),
(9, 'url_banner_1', '#'),
(10, 'url_banner_2', 'https://www.google.co.th/'),
(11, 'url_banner_3', '#'),
(12, 'url_banner_4', '#'),
(13, 'banner_5', '13.jpg'),
(14, 'banner_5_text', '<h3>Hello</h3>\r\n<h2>Sawasdee</h2>'),
(15, 'url_banner_5', '#'),
(16, 'cancel_time', '7'),
(17, 'map_location', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62325.91422394478!2d99.91606557441406!3d12.491641041417692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30fdab967039cfcb%3A0x6e306f65b12b5972!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Lij4Liy4LiK4Lih4LiH4LiE4Lil4Lij4Lix4LiV4LiZ4LmC4LiB4Liq4Li04LiZ4LiX4Lij4LmMIOC4p-C4tOC4l-C4ouC4suC5gOC4guC4leC4p-C4seC4h-C5hOC4geC4peC4geC4seC4h-C4p-C4pQ!5e0!3m2!1sth!2sth!4v1708679451136!5m2!1sth!2sth\" width=\"600\" height=\"600\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>'),
(18, 'conntact_address', 'ถ. เพชรเกษม ตำบล หนองแก อำเภอหัวหิน ประจวบคีรีขันธ์ 77110'),
(19, 'contact_phone', '2651032341310@rmutr.ac.th'),
(20, 'contact_mail', '101-101-1101'),
(21, 'favicon', 'favicon.ico'),
(22, 'remain_quantity', '100');

-- --------------------------------------------------------

--
-- Table structure for table `bk_set_banner`
--

DROP TABLE IF EXISTS `bk_set_banner`;
CREATE TABLE IF NOT EXISTS `bk_set_banner` (
  `bnn_id` tinyint NOT NULL AUTO_INCREMENT COMMENT 'ไอดีบานเนอร์',
  `bnn_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อบานเนอร์',
  `bnn_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รายละเอียดรูปภาพ',
  `bnn_link` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#' COMMENT 'ลิ้งค์บานเนอร์',
  `bnn_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดงบานเนอร์',
  `bnn_order` int NOT NULL DEFAULT '0' COMMENT 'ลำดับการเรียงสไลด์โชว์',
  PRIMARY KEY (`bnn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='บานเนอร์โฆษณา';

--
-- Dumping data for table `bk_set_banner`
--

INSERT INTO `bk_set_banner` (`bnn_id`, `bnn_name`, `bnn_image`, `bnn_link`, `bnn_show`, `bnn_order`) VALUES
(21, 'แบนเนอร์ 1', 'bnn_65e6b4c23c815.jpg', 'https://www.google.com', 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bk_prd_product`
--
ALTER TABLE `bk_prd_product`
  ADD CONSTRAINT `bk_prd_product_ibfk_1` FOREIGN KEY (`pty_id`) REFERENCES `bk_prd_type` (`pty_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bk_prd_product_ibfk_2` FOREIGN KEY (`publ_id`) REFERENCES `bk_prd_publisher` (`publ_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `bk_prd_promotion`
--
ALTER TABLE `bk_prd_promotion`
  ADD CONSTRAINT `bk_prd_promotion_ibfk_1` FOREIGN KEY (`prp_id`) REFERENCES `bk_promotion` (`prp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bk_prd_promotion_ibfk_2` FOREIGN KEY (`prd_id`) REFERENCES `bk_prd_product` (`prd_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
