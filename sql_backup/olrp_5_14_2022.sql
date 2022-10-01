-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2022 at 03:34 AM
-- Server version: 10.5.12-MariaDB-1:10.5.12+maria~focal
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `olrp`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_cbxwpbookmark`
--

DROP TABLE IF EXISTS `wp6c_cbxwpbookmark`;
CREATE TABLE `wp6c_cbxwpbookmark` (
  `id` mediumint(9) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modyfied_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_cbxwpbookmark`
--

INSERT INTO `wp6c_cbxwpbookmark` (`id`, `object_id`, `object_type`, `cat_id`, `user_id`, `created_date`, `modyfied_date`) VALUES
(1, 743, 'olrp_resource', 2, 2, '2022-05-09 00:30:55', '0000-00-00 00:00:00'),
(2, 735, 'olrp_resource', 2, 2, '2022-05-12 22:26:19', '0000-00-00 00:00:00'),
(3, 724, 'olrp_resource', 2, 2, '2022-05-12 22:26:39', '0000-00-00 00:00:00'),
(4, 656, 'olrp_resource', 3, 2, '2022-05-12 22:32:09', '0000-00-00 00:00:00'),
(6, 674, 'olrp_resource', 3, 2, '2022-05-12 22:33:42', '0000-00-00 00:00:00'),
(7, 731, 'olrp_resource', 2, 2, '2022-05-12 22:51:58', '0000-00-00 00:00:00'),
(8, 738, 'olrp_resource', 2, 2, '2022-05-12 22:52:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_cbxwpbookmarkcat`
--

DROP TABLE IF EXISTS `wp6c_cbxwpbookmarkcat`;
CREATE TABLE `wp6c_cbxwpbookmarkcat` (
  `id` mediumint(9) NOT NULL,
  `cat_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `privacy` tinyint(2) NOT NULL DEFAULT 1,
  `locked` tinyint(2) NOT NULL DEFAULT 0,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modyfied_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_cbxwpbookmarkcat`
--

INSERT INTO `wp6c_cbxwpbookmarkcat` (`id`, `cat_name`, `user_id`, `privacy`, `locked`, `created_date`, `modyfied_date`) VALUES
(1, 'My Favorites', 2, 0, 0, '2022-05-09 00:17:52', '0000-00-00 00:00:00'),
(2, 'Inspection', 2, 0, 0, '2022-05-09 00:30:41', '0000-00-00 00:00:00'),
(3, 'Manual 1 - Lathe', 2, 0, 0, '2022-05-12 22:31:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_commentmeta`
--

DROP TABLE IF EXISTS `wp6c_commentmeta`;
CREATE TABLE `wp6c_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_commentmeta`
--

INSERT INTO `wp6c_commentmeta` (`meta_id`, `comment_id`, `meta_key`, `meta_value`) VALUES
(1, 2, 'akismet_result', 'false'),
(2, 2, 'akismet_history', 'a:3:{s:4:\"time\";d:1650514442.611228;s:5:\"event\";s:9:\"check-ham\";s:4:\"user\";s:5:\"admin\";}'),
(4, 3, 'akismet_result', 'false'),
(5, 3, 'akismet_history', 'a:3:{s:4:\"time\";d:1650514636.220368;s:5:\"event\";s:9:\"check-ham\";s:4:\"user\";s:5:\"admin\";}'),
(7, 4, 'akismet_result', 'false'),
(8, 4, 'akismet_history', 'a:3:{s:4:\"time\";d:1650514815.10065;s:5:\"event\";s:9:\"check-ham\";s:4:\"user\";s:5:\"admin\";}'),
(10, 5, 'akismet_result', 'false'),
(11, 5, 'akismet_history', 'a:3:{s:4:\"time\";d:1650515615.303004;s:5:\"event\";s:9:\"check-ham\";s:4:\"user\";s:5:\"admin\";}'),
(13, 6, 'akismet_result', 'false'),
(14, 6, 'akismet_history', 'a:3:{s:4:\"time\";d:1650563647.60749;s:5:\"event\";s:9:\"check-ham\";s:4:\"user\";s:5:\"admin\";}');

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_comments`
--

DROP TABLE IF EXISTS `wp6c_comments`;
CREATE TABLE `wp6c_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_comments`
--

INSERT INTO `wp6c_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(2, 752, 'admin', 'admin@local.test', 'http://olrp.test', '192.168.50.1', '2022-04-21 04:14:02', '2022-04-21 04:14:02', 'I really like this resource. It stresses how important feel and practice is to the use of measuring tools and demonstrates an advantage of traditional vernier calipers over dial calipers in the measurement of IDs.', 0, '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'comment', 0, 1),
(3, 755, 'admin', 'admin@local.test', 'http://olrp.test', '192.168.50.1', '2022-04-21 04:17:16', '2022-04-21 04:17:16', 'Adam\'s technique on the correct hand position and motion while transferring the reading from the telescope gauge to the micrometer is great. It greatly improved my accuracy with telescoping gauges.', 0, '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'comment', 0, 1),
(4, 738, 'admin', 'admin@local.test', 'http://olrp.test', '192.168.50.1', '2022-04-21 04:20:15', '2022-04-21 04:20:15', 'Good practice exercise in reading a depth micrometer', 0, '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'comment', 0, 1),
(5, 724, 'admin', 'admin@local.test', 'http://olrp.test', '192.168.50.1', '2022-04-21 04:33:35', '2022-04-21 04:33:35', 'I like using this with my class. I use it to create practice slides and for quiz questions. I wish it were possible to turn off the display of the reading so I could use it dynamically in front of the class. One problem with it is that the micrometer doesn\'t look exactly like a real micrometer so some students have trouble transferring what they learn with this tool into the real world. Actual pictures of real micrometers are not as convenient but probably a better teaching tool. Check out the video by Adam Booth for a really good example of using a micrometer with a close up camera to teach this skill.', 0, '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'comment', 0, 1),
(6, 749, 'admin', 'admin@local.test', 'http://olrp.test', '192.168.50.1', '2022-04-21 17:54:07', '2022-04-21 17:54:07', 'Great up close shots as Adam walks through different micrometer readings', 0, '1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'comment', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_links`
--

DROP TABLE IF EXISTS `wp6c_links`;
CREATE TABLE `wp6c_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_postmeta`
--

DROP TABLE IF EXISTS `wp6c_postmeta`;
CREATE TABLE `wp6c_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_postmeta`
--

INSERT INTO `wp6c_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(4, 2, '_edit_lock', '1643595094:1'),
(1661, 654, 'olrp-resource-url', 'https://www.youtube.com/watch?v=cn05fX55pqc'),
(1662, 654, 'olrp-resource-summary', 'How to Square and Indicate a Vise on Your CNC Mill – Haas Automation Tip of the Day'),
(1663, 654, 'olrp-resource-comments', ''),
(1664, 655, 'olrp-resource-url', 'https://www.youtube.com/watch?v=XvlliZrEAow'),
(1665, 655, 'olrp-resource-summary', 'This is a motorcycle flywheel that is often brought to me by the bike shop to lighten. I thought you guys might enjoy seeing my way of doing it. \r\nHope ya\'ll enjoy!'),
(1666, 655, 'olrp-resource-comments', ''),
(1667, 656, 'olrp-resource-url', 'https://www.youtube.com/watch?v=Bs-CRzXEnM4'),
(1668, 656, 'olrp-resource-summary', 'It is about hand grinding your own HSS tool bits, and using them to make deep aggressive cuts in the lathe turning cold rold steel.'),
(1669, 656, 'olrp-resource-comments', ''),
(1670, 657, 'olrp-resource-url', 'https://www.youtube.com/watch?v=mCqxW-OwJTg'),
(1671, 657, 'olrp-resource-summary', 'In this weekday short, I show you a few more cuts with my chip breaker tool, making that beautiful curly cue I always strive to get when I\'m roughing out mild steel with a hss tool bit.'),
(1672, 657, 'olrp-resource-comments', ''),
(1673, 658, 'olrp-resource-url', 'https://www.youtube.com/watch?v=aA0suYN72SE'),
(1674, 658, 'olrp-resource-summary', 'Indicating Square Stock in a 4 Jaw Chuck'),
(1675, 658, 'olrp-resource-comments', ''),
(1676, 659, 'olrp-resource-url', 'https://www.youtube.com/playlist?list=PLF06SHGgSg4Fk5-yeh8DN3g6ZgaM0tbk7'),
(1677, 659, 'olrp-resource-summary', 'Series of videos produced at MIT on basic machining skills'),
(1678, 659, 'olrp-resource-comments', ''),
(1679, 660, 'olrp-resource-url', 'http://www.carbidedepot.com/formulas-insert-d.htm'),
(1680, 660, 'olrp-resource-summary', 'Insert Designation Chart'),
(1681, 660, 'olrp-resource-comments', ''),
(1682, 661, 'olrp-resource-url', 'https://www.wisc-online.com/GammaPlus/Apps/ViewLearningApp/579'),
(1683, 661, 'olrp-resource-summary', 'OER interactive activity teaching carbide tool geometry'),
(1688, 663, 'olrp-resource-url', 'https://www.wisc-online.com/GammaPlus/Apps/ViewLearningApp/593'),
(1689, 663, 'olrp-resource-summary', 'Using a Sine Bar'),
(1690, 663, 'olrp-resource-comments', ''),
(1691, 664, 'olrp-resource-url', 'https://www.wisc-online.com/GammaPlus/Apps/ViewLearningApp/595'),
(1692, 664, 'olrp-resource-summary', 'Using an Indicator'),
(1693, 664, 'olrp-resource-comments', ''),
(1694, 665, 'olrp-resource-url', 'https://www.wisc-online.com/GammaPlus/Apps/Category/machine_tool'),
(1695, 665, 'olrp-resource-summary', 'Learning Apps and Flashcard tests focued on machine tools at wisc-online.'),
(1696, 665, 'olrp-resource-comments', ''),
(1697, 666, 'olrp-resource-url', 'http://www.machinistblog.com/mit-techtv-machine-shop-videos/'),
(1698, 666, 'olrp-resource-summary', 'Here is a great resource for new machinists that almost seems like a secret because I have never seen it mentioned on any of the discussion groups or forums I belong to.'),
(1699, 666, 'olrp-resource-comments', ''),
(1700, 667, 'olrp-resource-url', 'https://www.youtube.com/watch?v=MkSJilGKB_A&t=502s'),
(1701, 667, 'olrp-resource-summary', 'In this video, I will explain why parts walk out of a chuck during steady rest operations, and share a easy little trick for getting your steady rest aligned properly. Take a look.'),
(1702, 667, 'olrp-resource-comments', ''),
(1703, 668, 'olrp-resource-url', 'https://www.youtube.com/watch?v=WCei5GlEZ5g'),
(1704, 668, 'olrp-resource-summary', 'This video shows an easy way of indicating the outside of a square part in a 4 jaw chuck without the need to continuously move your indicator. Take a look at this technique. It virtually eliminates the need to re-position the indicator for each side of your part.'),
(1705, 668, 'olrp-resource-comments', ''),
(1706, 669, 'olrp-resource-url', 'https://www.youtube.com/watch?v=1JcBphFxEe4'),
(1707, 669, 'olrp-resource-summary', 'If you want to see how to hold multiple parts of different thicknesses in a single vise, watch this video. I\'ll show you a simple jig you can build to increase your productivity. Take a look.'),
(1709, 670, 'olrp-resource-url', 'https://www.youtube.com/watch?v=6j05e5RE-WI&t=292s'),
(1710, 670, 'olrp-resource-summary', 'This video will show you a trick for holding wide plate vertically so you can drill and mill the edges. When you run out of room using a vise, you will want to see this.'),
(1711, 670, 'olrp-resource-comments', ''),
(1712, 671, 'olrp-resource-url', 'https://www.youtube.com/watch?v=be6Q9mm4vEQ'),
(1713, 671, 'olrp-resource-summary', 'Did you ever look at a thread chart in a machinist handbook and wonder what all the numbers are? Did you ever try to measure a thread and find out the guy before you lost a wire? Take a look at this video for some answers and tricks.'),
(1714, 671, 'olrp-resource-comments', ''),
(1715, 672, 'olrp-resource-url', 'https://www.youtube.com/watch?v=nLHXSXzQP3U'),
(1716, 672, 'olrp-resource-summary', 'This video illustrates the importance of a proper threading tool tip flat and will show you how to achieve your thread depth and length without the need for trig or conversions to compensate for different compound angle settings. Take a look.'),
(1717, 672, 'olrp-resource-comments', ''),
(1718, 673, 'olrp-resource-url', 'https://www.youtube.com/watch?v=1H9ei8-6tEM&t=586s'),
(1719, 673, 'olrp-resource-summary', 'Building Prototypes Dan Gelbart part 2 of 18 Safety'),
(1720, 673, 'olrp-resource-comments', ''),
(1721, 674, 'olrp-resource-url', 'https://www.sandvik.coromant.com/en-us/knowledge/general-turning/pages/how-to-choose-correct-turning-insert.aspx'),
(1722, 674, 'olrp-resource-summary', 'Good publication by Sandvik Cormorant on lathe insert selection for different cutting conditions. Lots of detailed information on chatter reduction, chip breaking and force vectors due to cutter geometry.'),
(1727, 676, 'olrp-resource-url', 'https://www.wisc-online.com/GammaPlus/Apps/Category/machine_tool'),
(1728, 676, 'olrp-resource-summary', 'Wisconsin Online Directory of e-learning videos on manufacturing topics,'),
(1729, 676, 'olrp-resource-comments', ''),
(1730, 677, 'olrp-resource-url', 'https://www.youtube.com/channel/UCi-1bvDwzwBq0OFKiF2atkg'),
(1731, 677, 'olrp-resource-summary', 'Haas Tip of the Day - Good entry level tips for CNC setup and operation.'),
(1733, 678, 'olrp-resource-url', 'https://www.youtube.com/watch?v=bga7y4infIo'),
(1734, 678, 'olrp-resource-summary', 'How to select the right Edge Finder for you'),
(1736, 679, 'olrp-resource-url', 'https://www.youtube.com/watch?v=t2Y6xR7iCto'),
(1737, 679, 'olrp-resource-summary', 'Setting a Work Zero with an Edge FInder'),
(1739, 680, 'olrp-resource-url', 'https://www.youtube.com/watch?v=AyMsFtwzrmI'),
(1740, 680, 'olrp-resource-summary', 'How to: Set a work offset with an edge finder and indicator – Haas Automation Tip of the Day'),
(1741, 680, 'olrp-resource-comments', ''),
(1742, 681, 'olrp-resource-url', 'https://www.youtube.com/watch?v=wxvI3r2YS48&list=PL0dIqHZC2c28HuaAoocdqZ0V_1YKMOq96&index=5'),
(1743, 681, 'olrp-resource-summary', 'Reaming - On a Mill'),
(1745, 682, 'olrp-resource-url', 'https://www.youtube.com/watch?v=X0jQ72_1ATI&index=6&list=PL0dIqHZC2c28HuaAoocdqZ0V_1YKMOq96'),
(1746, 682, 'olrp-resource-summary', 'Tapping'),
(1747, 682, 'olrp-resource-comments', ''),
(1748, 683, 'olrp-resource-url', 'https://www.youtube.com/playlist?list=PL0dIqHZC2c28HuaAoocdqZ0V_1YKMOq96'),
(1749, 683, 'olrp-resource-summary', 'This series of videos covers topics on the milling machine. The videos are short and cover a variety of topics. While not comprehensive they are worth watching for those with little to no experience on the mill as a brief introduction.'),
(1750, 683, 'olrp-resource-comments', ''),
(1751, 684, 'olrp-resource-url', 'https://www.youtube.com/watch?v=igfqYZPdQ78&t=188s'),
(1752, 684, 'olrp-resource-summary', 'How to square up stock on the milling machine, Good description of a process for squaring a piece of stock that is rough on all sides. There are other ways to do it but this is one good technique.'),
(1753, 684, 'olrp-resource-comments', ''),
(1754, 685, 'olrp-resource-url', 'https://www.youtube.com/watch?v=gIUS_0xfeGg'),
(1755, 685, 'olrp-resource-summary', 'Cutting Speed and RPM on the Lathe and Mill'),
(1756, 685, 'olrp-resource-comments', ''),
(1757, 686, 'olrp-resource-url', 'https://www.youtube.com/watch?v=b9gOWHQdrDs'),
(1758, 686, 'olrp-resource-summary', 'How to square the Bridgeport head with the table'),
(1760, 687, 'olrp-resource-url', 'https://www.youtube.com/watch?v=6T4IvUF8cYU'),
(1761, 687, 'olrp-resource-summary', 'How To Machine and Square 6 Sides of a Block Using Only 2 Setups'),
(1763, 688, 'olrp-resource-url', 'https://www.youtube.com/watch?v=zzzIpC39WUg'),
(1764, 688, 'olrp-resource-summary', 'CNC Speeds and feeds'),
(1766, 669, '_edit_lock', '1652394790:2'),
(1767, 688, '_edit_lock', '1650570422:1'),
(1768, 688, '_edit_last', '1'),
(1769, 724, '_edit_lock', '1643591767:1'),
(1770, 725, '_wp_attached_file', '2022/01/2022-01-14-08_56_38-Virtual-Micrometer-Thousandth-of-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanelli.png'),
(1771, 725, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:755;s:6:\"height\";i:575;s:4:\"file\";s:109:\"2022/01/2022-01-14-08_56_38-Virtual-Micrometer-Thousandth-of-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanelli.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:109:\"2022-01-14-08_56_38-Virtual-Micrometer-Thousandth-of-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanelli-300x228.png\";s:5:\"width\";i:300;s:6:\"height\";i:228;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:109:\"2022-01-14-08_56_38-Virtual-Micrometer-Thousandth-of-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanelli-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1772, 724, '_thumbnail_id', '725'),
(1773, 724, '_edit_last', '1'),
(1774, 724, 'olrp-resource-url', 'https://www.stefanelli.eng.br/en/virtual-micrometer-thousandth-inch-simulator/'),
(1775, 724, 'olrp-resource-summary', 'Online Micrometer Simulator. Useful tool for practicing micrometer readings'),
(1778, 728, '_edit_lock', '1643736553:1'),
(1779, 729, '_wp_attached_file', '2022/01/2022-01-14-09_03_23-Virtual-Dial-Caliper-in-Fractional-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanell.png'),
(1780, 729, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:739;s:6:\"height\";i:361;s:4:\"file\";s:110:\"2022/01/2022-01-14-09_03_23-Virtual-Dial-Caliper-in-Fractional-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanell.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:110:\"2022-01-14-09_03_23-Virtual-Dial-Caliper-in-Fractional-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanell-300x147.png\";s:5:\"width\";i:300;s:6:\"height\";i:147;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:110:\"2022-01-14-09_03_23-Virtual-Dial-Caliper-in-Fractional-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanell-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1781, 728, '_thumbnail_id', '729'),
(1782, 728, '_edit_last', '1'),
(1783, 728, 'olrp-resource-url', 'https://www.stefanelli.eng.br/en/simulator-virtual-dial-caliper-fractional-inch/'),
(1784, 728, 'olrp-resource-summary', 'Virtual Dial Caliper - Useful for teaching/practicing reading a dial caliper'),
(1786, 731, '_edit_lock', '1642179582:1'),
(1787, 732, '_wp_attached_file', '2022/01/2022-01-14-09_06_25-Virtual-Vernier-Caliper-Milesimal-Inch-25-Divisions-Simulator-_-Prof.-Eduardo-.png'),
(1788, 732, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:745;s:6:\"height\";i:375;s:4:\"file\";s:110:\"2022/01/2022-01-14-09_06_25-Virtual-Vernier-Caliper-Milesimal-Inch-25-Divisions-Simulator-_-Prof.-Eduardo-.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:110:\"2022-01-14-09_06_25-Virtual-Vernier-Caliper-Milesimal-Inch-25-Divisions-Simulator-_-Prof.-Eduardo--300x151.png\";s:5:\"width\";i:300;s:6:\"height\";i:151;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:110:\"2022-01-14-09_06_25-Virtual-Vernier-Caliper-Milesimal-Inch-25-Divisions-Simulator-_-Prof.-Eduardo--150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1789, 731, '_thumbnail_id', '732'),
(1790, 731, '_edit_last', '1'),
(1791, 731, 'olrp-resource-url', 'https://www.stefanelli.eng.br/en/virtual-vernier-caliper-milesimal-inch-25-simulator/'),
(1792, 731, 'olrp-resource-summary', 'Vernier Caliper Simulator - useful for teaching/practicing vernier reading skills'),
(1795, 735, '_edit_lock', '1642179809:1'),
(1796, 736, '_wp_attached_file', '2022/01/2022-01-14-09_10_55-Reading-a-Micrometer-Wisc-Online-OER.png'),
(1797, 736, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:719;s:6:\"height\";i:539;s:4:\"file\";s:68:\"2022/01/2022-01-14-09_10_55-Reading-a-Micrometer-Wisc-Online-OER.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:68:\"2022-01-14-09_10_55-Reading-a-Micrometer-Wisc-Online-OER-300x225.png\";s:5:\"width\";i:300;s:6:\"height\";i:225;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:68:\"2022-01-14-09_10_55-Reading-a-Micrometer-Wisc-Online-OER-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1798, 735, '_thumbnail_id', '736'),
(1799, 735, '_edit_last', '1'),
(1800, 735, 'olrp-resource-url', 'https://www.wisc-online.com/learn/career-clusters/manufacturing/mtl1902/reading-a-micrometer'),
(1801, 735, 'olrp-resource-summary', 'Reading an Inch Micrometer - Interactive learning activity'),
(1803, 738, '_edit_lock', '1642179964:1'),
(1804, 739, '_wp_attached_file', '2022/01/2022-01-14-09_13_47-Using-a-Depth-Micrometer-Wisc-Online-OER.png'),
(1805, 739, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:723;s:6:\"height\";i:541;s:4:\"file\";s:72:\"2022/01/2022-01-14-09_13_47-Using-a-Depth-Micrometer-Wisc-Online-OER.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:72:\"2022-01-14-09_13_47-Using-a-Depth-Micrometer-Wisc-Online-OER-300x224.png\";s:5:\"width\";i:300;s:6:\"height\";i:224;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:72:\"2022-01-14-09_13_47-Using-a-Depth-Micrometer-Wisc-Online-OER-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1806, 738, '_thumbnail_id', '739'),
(1807, 738, '_edit_last', '1'),
(1808, 738, 'olrp-resource-url', 'https://www.wisc-online.com/learn/career-clusters/manufacturing/mtl19415/using-a-depth-micrometer'),
(1809, 738, 'olrp-resource-summary', 'Interactive lesson'),
(1813, 743, '_edit_lock', '1652579321:2'),
(1814, 744, '_wp_attached_file', '2022/01/2022-01-14-09_17_28-Gage-Blocks-Wisc-Online-OER.png'),
(1815, 744, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:739;s:6:\"height\";i:625;s:4:\"file\";s:59:\"2022/01/2022-01-14-09_17_28-Gage-Blocks-Wisc-Online-OER.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:59:\"2022-01-14-09_17_28-Gage-Blocks-Wisc-Online-OER-300x254.png\";s:5:\"width\";i:300;s:6:\"height\";i:254;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:59:\"2022-01-14-09_17_28-Gage-Blocks-Wisc-Online-OER-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1816, 743, '_thumbnail_id', '744'),
(1817, 743, '_edit_last', '1'),
(1818, 743, 'olrp-resource-url', 'https://www.wisc-online.com/learn/manufacturing-engineering/man-eng-machine/msr301/gage-blocks'),
(1819, 743, 'olrp-resource-summary', 'In this learning activity you\'ll explore the history behind gage blocks.'),
(1821, 746, '_edit_lock', '1644427104:1'),
(1822, 747, '_wp_attached_file', '2022/01/2022-01-14-09_20_53-Using-an-Edge-Finder-Wisc-Online-OER.png'),
(1823, 747, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:741;s:6:\"height\";i:637;s:4:\"file\";s:68:\"2022/01/2022-01-14-09_20_53-Using-an-Edge-Finder-Wisc-Online-OER.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:68:\"2022-01-14-09_20_53-Using-an-Edge-Finder-Wisc-Online-OER-300x258.png\";s:5:\"width\";i:300;s:6:\"height\";i:258;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:68:\"2022-01-14-09_20_53-Using-an-Edge-Finder-Wisc-Online-OER-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1824, 746, '_thumbnail_id', '747'),
(1825, 746, '_edit_last', '1'),
(1826, 746, 'olrp-resource-url', 'https://www.wisc-online.com/learn/manufacturing-engineering/man-eng-machine/mtl19815/using-an-edge-finder'),
(1827, 746, 'olrp-resource-summary', 'The learner will use an edge finder to locate the edge of a workpiece.'),
(1829, 661, '_edit_lock', '1642180479:1'),
(1830, 661, '_edit_last', '1'),
(1842, 749, '_edit_lock', '1642180880:1'),
(1843, 750, '_wp_attached_file', '2022/01/2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube.png'),
(1844, 750, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1145;s:6:\"height\";i:651;s:4:\"file\";s:64:\"2022/01/2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:64:\"2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube-300x171.png\";s:5:\"width\";i:300;s:6:\"height\";i:171;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:65:\"2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube-1024x582.png\";s:5:\"width\";i:1024;s:6:\"height\";i:582;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:64:\"2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:64:\"2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube-768x437.png\";s:5:\"width\";i:768;s:6:\"height\";i:437;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1845, 749, '_thumbnail_id', '750'),
(1846, 749, '_edit_last', '1'),
(1847, 749, 'olrp-resource-url', 'https://www.youtube.com/watch?v=if6oOtOoVhw'),
(1848, 749, 'olrp-resource-summary', 'Good video with closeups of actual micrometer readings (12:25)'),
(1850, 752, '_edit_lock', '1642181046:1'),
(1851, 753, '_wp_attached_file', '2022/01/2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube.png'),
(1852, 753, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1149;s:6:\"height\";i:647;s:4:\"file\";s:87:\"2022/01/2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:87:\"2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube-300x169.png\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:88:\"2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube-1024x577.png\";s:5:\"width\";i:1024;s:6:\"height\";i:577;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:87:\"2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:87:\"2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube-768x432.png\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1853, 752, '_thumbnail_id', '753'),
(1854, 752, '_edit_last', '1'),
(1855, 752, 'olrp-resource-url', 'https://www.youtube.com/watch?v=rdFwZaRgO8s'),
(1856, 752, 'olrp-resource-summary', 'Good video on vernier caliper reading. Great coverage of accurately measuring hole ID\'s and the advantages of verniers in doing so.'),
(1858, 755, '_edit_lock', '1650516142:1'),
(1859, 756, '_wp_attached_file', '2022/01/2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube.png'),
(1860, 756, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1151;s:6:\"height\";i:645;s:4:\"file\";s:85:\"2022/01/2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:85:\"2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube-300x168.png\";s:5:\"width\";i:300;s:6:\"height\";i:168;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:86:\"2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube-1024x574.png\";s:5:\"width\";i:1024;s:6:\"height\";i:574;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:85:\"2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:85:\"2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube-768x430.png\";s:5:\"width\";i:768;s:6:\"height\";i:430;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1861, 755, '_thumbnail_id', '756'),
(1862, 755, '_edit_last', '1'),
(1863, 755, 'olrp-resource-url', 'https://www.youtube.com/watch?v=R6YLK0F3ytc'),
(1864, 755, 'olrp-resource-summary', 'Great video on accurately using telescoping gauges (15:35)'),
(1866, 678, '_edit_lock', '1642181484:1'),
(1867, 759, '_wp_attached_file', '2022/01/2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube.png'),
(1868, 759, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1149;s:6:\"height\";i:647;s:4:\"file\";s:83:\"2022/01/2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:83:\"2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube-300x169.png\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:84:\"2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube-1024x577.png\";s:5:\"width\";i:1024;s:6:\"height\";i:577;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:83:\"2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:83:\"2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube-768x432.png\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1869, 678, '_thumbnail_id', '759'),
(1870, 678, '_edit_last', '1'),
(1873, 687, '_edit_lock', '1642181957:1'),
(1874, 762, '_wp_attached_file', '2022/01/2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube.png'),
(1875, 762, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1147;s:6:\"height\";i:647;s:4:\"file\";s:104:\"2022/01/2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:104:\"2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube-300x169.png\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:105:\"2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube-1024x578.png\";s:5:\"width\";i:1024;s:6:\"height\";i:578;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:104:\"2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:104:\"2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube-768x433.png\";s:5:\"width\";i:768;s:6:\"height\";i:433;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1876, 687, '_thumbnail_id', '762'),
(1877, 687, '_edit_last', '1'),
(1878, 763, '_edit_lock', '1644520913:1'),
(1879, 764, '_wp_attached_file', '2022/01/2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube.png'),
(1880, 764, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1149;s:6:\"height\";i:645;s:4:\"file\";s:93:\"2022/01/2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:93:\"2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube-300x168.png\";s:5:\"width\";i:300;s:6:\"height\";i:168;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:94:\"2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube-1024x575.png\";s:5:\"width\";i:1024;s:6:\"height\";i:575;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:93:\"2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:93:\"2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube-768x431.png\";s:5:\"width\";i:768;s:6:\"height\";i:431;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1881, 763, '_thumbnail_id', '764'),
(1882, 763, '_edit_last', '1'),
(1883, 763, 'olrp-resource-url', 'https://www.youtube.com/watch?v=7FwL55ErfDI&list=PLO5YWJq2LzNvk67XZBUyXit_EedMoPflF&index=4'),
(1884, 763, 'olrp-resource-summary', 'Don Bailey - Owner of Suburban Tool Inc. shows how to excel at Surface Grinding. There is a follow up video titled \" Update to Surface grinding - How to grind fast and accurate\" where I will show you why this works.'),
(1886, 686, '_edit_lock', '1642182277:1'),
(1887, 767, '_wp_attached_file', '2022/01/2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube.png'),
(1888, 767, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1151;s:6:\"height\";i:649;s:4:\"file\";s:88:\"2022/01/2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:88:\"2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube-300x169.png\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:89:\"2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube-1024x577.png\";s:5:\"width\";i:1024;s:6:\"height\";i:577;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:88:\"2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:88:\"2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube-768x433.png\";s:5:\"width\";i:768;s:6:\"height\";i:433;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1889, 686, '_thumbnail_id', '767'),
(1890, 686, '_edit_last', '1'),
(1891, 679, '_edit_lock', '1642182484:1'),
(1892, 769, '_wp_attached_file', '2022/01/2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube.png'),
(1893, 769, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1147;s:6:\"height\";i:645;s:4:\"file\";s:79:\"2022/01/2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:79:\"2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube-300x169.png\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:80:\"2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube-1024x576.png\";s:5:\"width\";i:1024;s:6:\"height\";i:576;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:79:\"2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:79:\"2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube-768x432.png\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1894, 679, '_thumbnail_id', '769'),
(1895, 679, '_edit_last', '1'),
(1896, 681, '_edit_lock', '1642193262:1'),
(1897, 681, '_edit_last', '1'),
(1898, 677, '_edit_lock', '1651530997:1'),
(1899, 677, '_edit_last', '1'),
(1905, 775, '_wp_attached_file', '2022/01/2022-04-20-20_36_07-Haas-Automation-Inc.-YouTube.png'),
(1906, 775, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:733;s:6:\"height\";i:353;s:4:\"file\";s:60:\"2022/01/2022-04-20-20_36_07-Haas-Automation-Inc.-YouTube.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:60:\"2022-04-20-20_36_07-Haas-Automation-Inc.-YouTube-300x144.png\";s:5:\"width\";i:300;s:6:\"height\";i:144;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:60:\"2022-04-20-20_36_07-Haas-Automation-Inc.-YouTube-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1907, 775, '_wp_attachment_image_alt', 'Hass Tip of the Day Cover Image'),
(1908, 677, '_thumbnail_id', '775'),
(1911, 778, '_edit_lock', '1650512895:1'),
(1914, 778, '_edit_last', '1'),
(1915, 778, 'rmp_vote_count', '1'),
(1916, 778, 'rmp_rating_val_sum', '1'),
(1917, 778, 'rmp_avg_rating', '1'),
(1918, 778, '_wp_trash_meta_status', 'publish'),
(1919, 778, '_wp_trash_meta_time', '1650512895'),
(1920, 778, '_wp_desired_post_slug', 'test-post'),
(1921, 673, 'rmp_vote_count', '1'),
(1922, 673, 'rmp_rating_val_sum', '3'),
(1923, 673, 'rmp_avg_rating', '3'),
(1924, 743, 'rmp_vote_count', '1'),
(1925, 743, 'rmp_rating_val_sum', '4'),
(1926, 743, 'rmp_avg_rating', '4'),
(1927, 728, 'rmp_vote_count', '1'),
(1928, 728, 'rmp_rating_val_sum', '5'),
(1929, 728, 'rmp_avg_rating', '5'),
(1930, 752, 'rmp_vote_count', '1'),
(1931, 752, 'rmp_rating_val_sum', '5'),
(1932, 752, 'rmp_avg_rating', '5'),
(1933, 749, 'rmp_vote_count', '1'),
(1934, 749, 'rmp_rating_val_sum', '4'),
(1935, 749, 'rmp_avg_rating', '4'),
(1936, 738, 'rmp_vote_count', '1'),
(1937, 738, 'rmp_rating_val_sum', '4'),
(1938, 738, 'rmp_avg_rating', '4'),
(1939, 755, 'rmp_vote_count', '1'),
(1940, 755, 'rmp_rating_val_sum', '5'),
(1941, 755, 'rmp_avg_rating', '5'),
(1943, 724, 'rmp_vote_count', '2'),
(1944, 724, 'rmp_rating_val_sum', '9'),
(1945, 724, 'rmp_avg_rating', '4.5'),
(1946, 782, '_wp_attached_file', '2022/01/2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da.png'),
(1947, 782, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1277;s:6:\"height\";i:719;s:4:\"file\";s:108:\"2022/01/2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da.png\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:108:\"2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da-300x169.png\";s:5:\"width\";i:300;s:6:\"height\";i:169;s:9:\"mime-type\";s:9:\"image/png\";}s:5:\"large\";a:4:{s:4:\"file\";s:109:\"2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da-1024x577.png\";s:5:\"width\";i:1024;s:6:\"height\";i:577;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:108:\"2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:108:\"2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da-768x432.png\";s:5:\"width\";i:768;s:6:\"height\";i:432;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1949, 673, '_edit_lock', '1651516220:1'),
(1950, 787, '_edit_lock', '1652385575:2'),
(1951, 787, '_edit_last', '2'),
(1952, 785, '_edit_lock', '1652396429:2'),
(1953, 785, '_edit_last', '2'),
(1954, 669, '_edit_last', '2'),
(1955, 674, '_edit_lock', '1652394994:2'),
(1956, 801, '_wp_attached_file', '2022/01/2022-05-12-15_34_48-How-to-choose-correct-turning-insert.png'),
(1957, 801, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:695;s:6:\"height\";i:463;s:4:\"file\";s:68:\"2022/01/2022-05-12-15_34_48-How-to-choose-correct-turning-insert.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:68:\"2022-05-12-15_34_48-How-to-choose-correct-turning-insert-300x200.png\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:68:\"2022-05-12-15_34_48-How-to-choose-correct-turning-insert-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(1958, 801, '_wp_attachment_image_alt', 'Lathe Insert Tool'),
(1959, 674, '_thumbnail_id', '801'),
(1960, 674, '_edit_last', '2');

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_posts`
--

DROP TABLE IF EXISTS `wp6c_posts`;
CREATE TABLE `wp6c_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_posts`
--

INSERT INTO `wp6c_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(2, 1, '2021-11-06 21:34:50', '2021-11-06 21:34:50', '[olrp_display_table /]', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2021-12-16 04:39:44', '2021-12-16 04:39:44', '', 0, 'http://olrp.test/?page_id=2', 0, 'page', '', 0),
(3, 1, '2021-11-06 21:34:50', '2021-11-06 21:34:50', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Our website address is: http://olrp.test.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Comments</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Media</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Cookies</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Embedded content from other websites</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph -->', 'Privacy Policy', '', 'draft', 'closed', 'open', '', 'privacy-policy', '', '', '2021-11-06 21:34:50', '2021-11-06 21:34:50', '', 0, 'http://olrp.test/?page_id=3', 0, 'page', '', 0),
(16, 1, '2021-11-06 22:22:57', '2021-11-06 22:22:57', '[gdoc key=\"wordpress\" query=\"SELECT Title_with_link,Url,Date,Author,Summary,Tags,GUID FROM OLRP_Resources\" class=\"fix_links no-responsive\" datatables_auto_width=\"false\"]', 'Sample Page', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-11-06 22:22:57', '2021-11-06 22:22:57', '', 2, 'http://olrp.test/?p=16', 0, 'revision', '', 0),
(192, 1, '2021-12-16 04:39:44', '2021-12-16 04:39:44', '[olrp_display_table /]', 'Sample Page', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-12-16 04:39:44', '2021-12-16 04:39:44', '', 2, 'http://olrp.test/?p=192', 0, 'revision', '', 0),
(211, 1, '2022-01-02 00:09:05', '2022-01-02 00:09:05', '@media only screen and (min-width: 200px) {\n\n	:root {\n		--responsive--aligndefault-width: min(calc(100vw - 8 * var(--global--spacing-horizontal)), 1900px);\n		--responsive--alignwide-width: min(calc(100vw - 8 * var(--global--spacing-horizontal)), 1240px);\n	}\n}', 'twentytwentyone', '', 'publish', 'closed', 'closed', '', 'twentytwentyone', '', '', '2022-01-02 00:09:05', '2022-01-02 00:09:05', '', 0, 'http://olrp.test/?p=211', 0, 'custom_css', '', 0),
(212, 1, '2022-01-02 00:09:05', '2022-01-02 00:09:05', '@media only screen and (min-width: 200px) {\n\n	:root {\n		--responsive--aligndefault-width: min(calc(100vw - 8 * var(--global--spacing-horizontal)), 1900px);\n		--responsive--alignwide-width: min(calc(100vw - 8 * var(--global--spacing-horizontal)), 1240px);\n	}\n}', 'twentytwentyone', '', 'inherit', 'closed', 'closed', '', '211-revision-v1', '', '', '2022-01-02 00:09:05', '2022-01-02 00:09:05', '', 211, 'http://olrp.test/?p=212', 0, 'revision', '', 0),
(654, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to Square and Indicate a Vise on Your CNC Mill – Haas Automation Tip of the Day - YouTube', 'How to Square and Indicate a Vise on Your CNC Mill – Haas Automation Tip of the Day', 'publish', 'open', 'closed', '', 'how-to-square-and-indicate-a-vise-on-your-cnc-mill-haas-automation-tip-of-the-day-youtube', '', '', '2022-01-14 04:55:39', '2022-01-14 04:55:39', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=654', 0, 'olrp_resource', '', 0),
(655, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Flywheel Lightening - YouTube', 'This is a motorcycle flywheel that is often brought to me by the bike shop to lighten. I thought you guys might enjoy seeing my way of doing it. \r\nHope ya\'ll enjoy!', 'publish', 'open', 'closed', '', 'flywheel-lightening-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=655', 0, 'olrp_resource', '', 0),
(656, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Chip Control Part 1 - YouTube', 'It is about hand grinding your own HSS tool bits, and using them to make deep aggressive cuts in the lathe turning cold rold steel.', 'publish', 'open', 'closed', '', 'chip-control-part-1-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=656', 0, 'olrp_resource', '', 0),
(657, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Chip Control Part 2.5 - YouTube', 'In this weekday short, I show you a few more cuts with my chip breaker tool, making that beautiful curly cue I always strive to get when I\'m roughing out mild steel with a hss tool bit.', 'publish', 'open', 'closed', '', 'chip-control-part-2-5-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=657', 0, 'olrp_resource', '', 0),
(658, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Indicating Square Stock in a 4 Jaw Chuck - YouTube', 'Indicating Square Stock in a 4 Jaw Chuck', 'publish', 'open', 'closed', '', 'indicating-square-stock-in-a-4-jaw-chuck-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=658', 0, 'olrp_resource', '', 0),
(659, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'MIT Machine Shop Videos - YouTube', 'Series of videos produced at MIT on basic machining skills', 'publish', 'open', 'closed', '', 'mit-machine-shop-videos-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=659', 0, 'olrp_resource', '', 0),
(660, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Insert Designation Chart - provides ANSI and ISO designation code definitions for carbide insert shapes, relief angles, tolerances, chipbreaker codes, hole types, size values, thickness values, radius values, wiper lead angle, wiper clearance angle, cutti', 'Insert Designation Chart', 'publish', 'open', 'closed', '', 'insert-designation-chart-provides-ansi-and-iso-designation-code-definitions-for-carbide-insert-shapes-relief-angles-tolerances-chipbreaker-codes-hole-types-size-values-thickness-values-radius', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=660', 0, 'olrp_resource', '', 0),
(661, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'View Carbide Tool Geometry - GAMMA+', 'OER interactive activity teaching carbide tool geometry', 'publish', 'open', 'closed', '', 'view-carbide-tool-geometry-gamma', '', '', '2022-02-10 19:31:08', '2022-02-10 19:31:08', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=661', 0, 'olrp_resource', '', 0),
(663, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'View Using a Sine Bar - GAMMA+', 'Using a Sine Bar', 'publish', 'open', 'closed', '', 'view-using-a-sine-bar-gamma', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=663', 0, 'olrp_resource', '', 0),
(664, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'View Using an Indicator - GAMMA+', 'Using an Indicator', 'publish', 'open', 'closed', '', 'view-using-an-indicator-gamma', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=664', 0, 'olrp_resource', '', 0),
(665, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Machine Tool - GAMMA+', 'Learning Apps and Flashcard tests focued on machine tools at wisc-online.', 'publish', 'open', 'closed', '', 'machine-tool-gamma', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=665', 0, 'olrp_resource', '', 0),
(666, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'MIT TechTV Machine Shop Videos | MachinistBlog.com', 'Here is a great resource for new machinists that almost seems like a secret because I have never seen it mentioned on any of the discussion groups or forums I belong to.', 'publish', 'open', 'closed', '', 'mit-techtv-machine-shop-videos-machinistblog-com', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=666', 0, 'olrp_resource', '', 0),
(667, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Get Your Steady Rest Aligned - YouTube', 'In this video, I will explain why parts walk out of a chuck during steady rest operations, and share a easy little trick for getting your steady rest aligned properly. Take a look.', 'publish', 'open', 'closed', '', 'get-your-steady-rest-aligned-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=667', 0, 'olrp_resource', '', 0),
(668, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Clever way to indicate a square part in a 4 jaw chuck - SUPER EASY !! - YouTube', 'This video shows an easy way of indicating the outside of a square part in a 4 jaw chuck without the need to continuously move your indicator. Take a look at this technique. It virtually eliminates the need to re-position the indicator for each side of your part.', 'publish', 'open', 'closed', '', 'clever-way-to-indicate-a-square-part-in-a-4-jaw-chuck-super-easy-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=668', 0, 'olrp_resource', '', 0),
(669, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'How to Hold multiple parts of different sizes in a mill vise - YouTube', 'If you want to see how to hold multiple parts of different thicknesses in a single vise, watch this video. I\'ll show you a simple jig you can build to increase your productivity. Take a look.', 'publish', 'open', 'closed', '', 'how-to-hold-multiple-parts-of-different-sizes-in-a-mill-vise-youtube', '', '', '2022-05-12 22:33:10', '2022-05-12 22:33:10', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=669', 0, 'olrp_resource', '', 0),
(670, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Holding wide plate material vertically on the mill - YouTube', 'This video will show you a trick for holding wide plate vertically so you can drill and mill the edges. When you run out of room using a vise, you will want to see this.', 'publish', 'open', 'closed', '', 'holding-wide-plate-material-vertically-on-the-mill-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=670', 0, 'olrp_resource', '', 0),
(671, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Pitch Diameter, Wires and Numbers Galore. Threads in detail ! - YouTube', 'Did you ever look at a thread chart in a machinist handbook and wonder what all the numbers are? Did you ever try to measure a thread and find out the guy before you lost a wire? Take a look at this video for some answers and tricks.', 'publish', 'open', 'closed', '', 'pitch-diameter-wires-and-numbers-galore-threads-in-detail-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=671', 0, 'olrp_resource', '', 0),
(672, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Thread Depth, Tool Tip Width and Length of Cut NO TRIG NEEDED - YouTube', 'This video illustrates the importance of a proper threading tool tip flat and will show you how to achieve your thread depth and length without the need for trig or conversions to compensate for different compound angle settings. Take a look.', 'publish', 'open', 'closed', '', 'thread-depth-tool-tip-width-and-length-of-cut-no-trig-needed-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=672', 0, 'olrp_resource', '', 0),
(673, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Building Prototypes Dan Gelbart part 2 of 18 Safety - YouTube', 'Building Prototypes Dan Gelbart part 2 of 18 Safety', 'publish', 'open', 'closed', '', 'building-prototypes-dan-gelbart-part-2-of-18-safety-youtube', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=673', 0, 'olrp_resource', '', 0),
(674, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Sandvik Cormorant 1020-18', 'Good publication by Sandvik Cormorant on lathe insert selection for different cutting conditions. Lots of detailed information on chatter reduction, chip breaking and force vectors due to cutter geometry.', 'publish', 'open', 'closed', '', 'sandvik-cormorant-1020-18', '', '', '2022-05-12 22:36:33', '2022-05-12 22:36:33', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=674', 0, 'olrp_resource', '', 0),
(676, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Machine Tool - GAMMA+', 'Wisconsin Online Directory of e-learning videos on manufacturing topics,', 'publish', 'open', 'closed', '', 'machine-tool-gamma-2', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=676', 0, 'olrp_resource', '', 0),
(677, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Haas Tip of the Day - Main Channel Page', 'Haas Tip of the Day - Good entry level tips for CNC setup and operation.', 'publish', 'open', 'closed', '', 'haas-tip-of-the-day', '', '', '2022-04-21 03:38:06', '2022-04-21 03:38:06', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=677', 0, 'olrp_resource', '', 0),
(678, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to select the right Edge Finder for you', 'How to select the right Edge Finder for you', 'publish', 'open', 'closed', '', 'how-to-select-the-right-edge-finder-for-you', '', '', '2022-01-14 17:33:03', '2022-01-14 17:33:03', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=678', 0, 'olrp_resource', '', 0),
(679, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Setting a Work Zero with an Edge FInder', 'Setting a Work Zero with an Edge FInder', 'publish', 'open', 'closed', '', 'setting-a-work-zero-with-an-edge-finder', '', '', '2022-01-14 17:48:04', '2022-01-14 17:48:04', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=679', 0, 'olrp_resource', '', 0),
(680, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to: Set a work offset with an edge finder and indicator', 'How to: Set a work offset with an edge finder and indicator – Haas Automation Tip of the Day', 'publish', 'open', 'closed', '', 'how-to-set-a-work-offset-with-an-edge-finder-and-indicator', '', '', '2022-01-14 04:55:39', '2022-01-14 04:55:39', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=680', 0, 'olrp_resource', '', 0),
(681, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Reaming - On a Mill', 'Reaming - On a Mill', 'publish', 'open', 'closed', '', 'reaming-on-a-mill', '', '', '2022-01-14 20:47:42', '2022-01-14 20:47:42', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=681', 0, 'olrp_resource', '', 0),
(682, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Tapping', 'Tapping', 'publish', 'open', 'closed', '', 'tapping', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=682', 0, 'olrp_resource', '', 0),
(683, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Series of videos covers topics on the milling machine.', 'This series of videos covers topics on the milling machine. The videos are short and cover a variety of topics. While not comprehensive they are worth watching for those with little to no experience on the mill as a brief introduction.', 'publish', 'open', 'closed', '', 'series-of-videos-covers-topics-on-the-milling-machine', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=683', 0, 'olrp_resource', '', 0),
(684, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to square up stock on the milling machine', 'How to square up stock on the milling machine, Good description of a process for squaring a piece of stock that is rough on all sides. There are other ways to do it but this is one good technique.', 'publish', 'open', 'closed', '', 'how-to-square-up-stock-on-the-milling-machine', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=684', 0, 'olrp_resource', '', 0),
(685, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Cutting Speed and RPM on the Lathe and Mill', 'Cutting Speed and RPM on the Lathe and Mill', 'publish', 'open', 'closed', '', 'cutting-speed-and-rpm-on-the-lathe-and-mill', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=685', 0, 'olrp_resource', '', 0),
(686, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to square the Bridgeport head with the table', 'How to square the Bridgeport head with the table', 'publish', 'open', 'closed', '', 'how-to-square-the-bridgeport-head-with-the-table', '', '', '2022-01-14 17:44:37', '2022-01-14 17:44:37', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=686', 0, 'olrp_resource', '', 0),
(687, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How To Machine and Square 6 Sides of a Block Using Only 2 Setups', 'How To Machine and Square 6 Sides of a Block Using Only 2 Setups', 'publish', 'open', 'closed', '', 'how-to-machine-and-square-6-sides-of-a-block-using-only-2-setups', '', '', '2022-01-14 17:39:16', '2022-01-14 17:39:16', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=687', 0, 'olrp_resource', '', 0),
(688, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Haas Speeds and Feeds', 'CNC Speeds and feeds', 'publish', 'open', 'closed', '', 'haas-speeds-and-feeds', '', '', '2022-04-21 19:47:02', '2022-04-21 19:47:02', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=688', 0, 'olrp_resource', '', 0),
(689, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Haas Speeds and Feeds', 'CNC Speeds and feeds', 'inherit', 'closed', 'closed', '', '688-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 688, 'http://olrp.test/?p=689', 0, 'revision', '', 0),
(690, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'MIT TechTV Machine Shop Videos | MachinistBlog.com', 'Here is a great resource for new machinists that almost seems like a secret because I have never seen it mentioned on any of the discussion groups or forums I belong to.', 'inherit', 'closed', 'closed', '', '666-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 666, 'http://olrp.test/?p=690', 0, 'revision', '', 0),
(691, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Get Your Steady Rest Aligned - YouTube', 'In this video, I will explain why parts walk out of a chuck during steady rest operations, and share a easy little trick for getting your steady rest aligned properly. Take a look.', 'inherit', 'closed', 'closed', '', '667-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 667, 'http://olrp.test/?p=691', 0, 'revision', '', 0),
(692, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Clever way to indicate a square part in a 4 jaw chuck - SUPER EASY !! - YouTube', 'This video shows an easy way of indicating the outside of a square part in a 4 jaw chuck without the need to continuously move your indicator. Take a look at this technique. It virtually eliminates the need to re-position the indicator for each side of your part.', 'inherit', 'closed', 'closed', '', '668-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 668, 'http://olrp.test/?p=692', 0, 'revision', '', 0),
(693, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'How to Hold multiple parts of different sizes in a mill vise - YouTube', 'If you want to see how to hold multiple parts of different thicknesses in a single vise, watch this video. I\'ll show you a simple jig you can build to increase your productivity. Take a look.', 'inherit', 'closed', 'closed', '', '669-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 669, 'http://olrp.test/?p=693', 0, 'revision', '', 0),
(694, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Holding wide plate material vertically on the mill - YouTube', 'This video will show you a trick for holding wide plate vertically so you can drill and mill the edges. When you run out of room using a vise, you will want to see this.', 'inherit', 'closed', 'closed', '', '670-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 670, 'http://olrp.test/?p=694', 0, 'revision', '', 0),
(695, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Pitch Diameter, Wires and Numbers Galore. Threads in detail ! - YouTube', 'Did you ever look at a thread chart in a machinist handbook and wonder what all the numbers are? Did you ever try to measure a thread and find out the guy before you lost a wire? Take a look at this video for some answers and tricks.', 'inherit', 'closed', 'closed', '', '671-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 671, 'http://olrp.test/?p=695', 0, 'revision', '', 0),
(696, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Thread Depth, Tool Tip Width and Length of Cut NO TRIG NEEDED - YouTube', 'This video illustrates the importance of a proper threading tool tip flat and will show you how to achieve your thread depth and length without the need for trig or conversions to compensate for different compound angle settings. Take a look.', 'inherit', 'closed', 'closed', '', '672-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 672, 'http://olrp.test/?p=696', 0, 'revision', '', 0),
(697, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Building Prototypes Dan Gelbart part 2 of 18 Safety - YouTube', 'Building Prototypes Dan Gelbart part 2 of 18 Safety', 'inherit', 'closed', 'closed', '', '673-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 673, 'http://olrp.test/?p=697', 0, 'revision', '', 0),
(698, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Machine Tool - GAMMA+', 'Learning Apps and Flashcard tests focued on machine tools at wisc-online.', 'inherit', 'closed', 'closed', '', '665-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 665, 'http://olrp.test/?p=698', 0, 'revision', '', 0),
(699, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'View Using an Indicator - GAMMA+', 'Using an Indicator', 'inherit', 'closed', 'closed', '', '664-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 664, 'http://olrp.test/?p=699', 0, 'revision', '', 0),
(700, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'View Using a Sine Bar - GAMMA+', 'Using a Sine Bar', 'inherit', 'closed', 'closed', '', '663-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 663, 'http://olrp.test/?p=700', 0, 'revision', '', 0),
(701, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Flywheel Lightening - YouTube', 'This is a motorcycle flywheel that is often brought to me by the bike shop to lighten. I thought you guys might enjoy seeing my way of doing it. \r\nHope ya\'ll enjoy!', 'inherit', 'closed', 'closed', '', '655-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 655, 'http://olrp.test/?p=701', 0, 'revision', '', 0),
(702, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Chip Control Part 1 - YouTube', 'It is about hand grinding your own HSS tool bits, and using them to make deep aggressive cuts in the lathe turning cold rold steel.', 'inherit', 'closed', 'closed', '', '656-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 656, 'http://olrp.test/?p=702', 0, 'revision', '', 0),
(703, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Chip Control Part 2.5 - YouTube', 'In this weekday short, I show you a few more cuts with my chip breaker tool, making that beautiful curly cue I always strive to get when I\'m roughing out mild steel with a hss tool bit.', 'inherit', 'closed', 'closed', '', '657-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 657, 'http://olrp.test/?p=703', 0, 'revision', '', 0),
(704, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Indicating Square Stock in a 4 Jaw Chuck - YouTube', 'Indicating Square Stock in a 4 Jaw Chuck', 'inherit', 'closed', 'closed', '', '658-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 658, 'http://olrp.test/?p=704', 0, 'revision', '', 0),
(705, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'MIT Machine Shop Videos - YouTube', 'Series of videos produced at MIT on basic machining skills', 'inherit', 'closed', 'closed', '', '659-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 659, 'http://olrp.test/?p=705', 0, 'revision', '', 0),
(706, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'Insert Designation Chart - provides ANSI and ISO designation code definitions for carbide insert shapes, relief angles, tolerances, chipbreaker codes, hole types, size values, thickness values, radius values, wiper lead angle, wiper clearance angle, cutti', 'Insert Designation Chart', 'inherit', 'closed', 'closed', '', '660-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 660, 'http://olrp.test/?p=706', 0, 'revision', '', 0),
(707, 1, '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 'View Carbide Tool Geometry - GAMMA+', 'OER interactive activity teaching carbide tool geometry', 'inherit', 'closed', 'closed', '', '661-revision-v1', '', '', '2022-01-08 02:34:23', '2022-01-08 02:34:23', '', 661, 'http://olrp.test/?p=707', 0, 'revision', '', 0),
(709, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to Square and Indicate a Vise on Your CNC Mill – Haas Automation Tip of the Day - YouTube', 'How to Square and Indicate a Vise on Your CNC Mill – Haas Automation Tip of the Day', 'inherit', 'closed', 'closed', '', '654-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 654, 'http://olrp.test/?p=709', 0, 'revision', '', 0),
(710, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to square the Bridgeport head with the table', 'How to square the Bridgeport head with the table', 'inherit', 'closed', 'closed', '', '686-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 686, 'http://olrp.test/?p=710', 0, 'revision', '', 0),
(711, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Cutting Speed and RPM on the Lathe and Mill', 'Cutting Speed and RPM on the Lathe and Mill', 'inherit', 'closed', 'closed', '', '685-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 685, 'http://olrp.test/?p=711', 0, 'revision', '', 0),
(712, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to square up stock on the milling machine', 'How to square up stock on the milling machine, Good description of a process for squaring a piece of stock that is rough on all sides. There are other ways to do it but this is one good technique.', 'inherit', 'closed', 'closed', '', '684-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 684, 'http://olrp.test/?p=712', 0, 'revision', '', 0),
(713, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Series of videos covers topics on the milling machine.', 'This series of videos covers topics on the milling machine. The videos are short and cover a variety of topics. While not comprehensive they are worth watching for those with little to no experience on the mill as a brief introduction.', 'inherit', 'closed', 'closed', '', '683-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 683, 'http://olrp.test/?p=713', 0, 'revision', '', 0),
(714, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Tapping', 'Tapping', 'inherit', 'closed', 'closed', '', '682-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 682, 'http://olrp.test/?p=714', 0, 'revision', '', 0),
(715, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Reaming - On a Mill', 'Reaming - On a Mill', 'inherit', 'closed', 'closed', '', '681-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 681, 'http://olrp.test/?p=715', 0, 'revision', '', 0),
(716, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to: Set a work offset with an edge finder and indicator', 'How to: Set a work offset with an edge finder and indicator – Haas Automation Tip of the Day', 'inherit', 'closed', 'closed', '', '680-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 680, 'http://olrp.test/?p=716', 0, 'revision', '', 0),
(717, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Setting a Work Zero with an Edge FInder', 'Setting a Work Zero with an Edge FInder', 'inherit', 'closed', 'closed', '', '679-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 679, 'http://olrp.test/?p=717', 0, 'revision', '', 0),
(718, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How to select the right Edge Finder for you', 'How to select the right Edge Finder for you', 'inherit', 'closed', 'closed', '', '678-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 678, 'http://olrp.test/?p=718', 0, 'revision', '', 0),
(719, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Haas Tip of the Day', 'Haas Tip of the Day - Good entry level tips for CNC setup and operation.', 'inherit', 'closed', 'closed', '', '677-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 677, 'http://olrp.test/?p=719', 0, 'revision', '', 0),
(720, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Machine Tool - GAMMA+', 'Wisconsin Online Directory of e-learning videos on manufacturing topics,', 'inherit', 'closed', 'closed', '', '676-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 676, 'http://olrp.test/?p=720', 0, 'revision', '', 0),
(722, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'Sandvik Cormorant 1020-18', 'Good publication by Sandvik Cormorant on lathe insert selection for different cutting conditions. Lots of detailed information on chatter reduction, chip breaking and force vectors due to cutter geometry.', 'inherit', 'closed', 'closed', '', '674-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 674, 'http://olrp.test/?p=722', 0, 'revision', '', 0),
(723, 1, '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 'How To Machine and Square 6 Sides of a Block Using Only 2 Setups', 'How To Machine and Square 6 Sides of a Block Using Only 2 Setups', 'inherit', 'closed', 'closed', '', '687-revision-v1', '', '', '2022-01-08 02:34:49', '2022-01-08 02:34:49', '', 687, 'http://olrp.test/?p=723', 0, 'revision', '', 0),
(724, 1, '2022-01-14 16:51:58', '2022-01-14 16:51:58', '', 'Virtual Micrometer', '', 'publish', 'open', 'closed', '', 'virtual-micrometer', '', '', '2022-01-31 01:16:07', '2022-01-31 01:16:07', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=724', 0, 'olrp_resource', '', 1),
(725, 1, '2022-01-14 16:49:18', '2022-01-14 16:49:18', '', '2022-01-14 08_56_38-Virtual Micrometer - Thousandth of Inch Simulator _ Prof. Eduardo J. Stefanelli', '', 'inherit', 'open', 'closed', '', '2022-01-14-08_56_38-virtual-micrometer-thousandth-of-inch-simulator-_-prof-eduardo-j-stefanelli', '', '', '2022-01-14 16:49:18', '2022-01-14 16:49:18', '', 724, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-08_56_38-Virtual-Micrometer-Thousandth-of-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanelli.png', 0, 'attachment', 'image/png', 0),
(726, 1, '2022-01-14 16:51:58', '2022-01-14 16:51:58', '<!-- wp:image {\"id\":725,\"sizeSlug\":\"full\",\"linkDestination\":\"none\",\"className\":\"is-style-twentytwentyone-border\"} -->\n<figure class=\"wp-block-image size-full is-style-twentytwentyone-border\"><img src=\"http://olrp.test/wp-content/uploads/2022/01/2022-01-14-08_56_38-Virtual-Micrometer-Thousandth-of-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanelli.png\" alt=\"Example of Virtual Micrometer Display\" class=\"wp-image-725\"/></figure>\n<!-- /wp:image -->', 'Virtual Micrometer', '', 'inherit', 'closed', 'closed', '', '724-revision-v1', '', '', '2022-01-14 16:51:58', '2022-01-14 16:51:58', '', 724, 'http://olrp.test/?p=726', 0, 'revision', '', 0),
(727, 1, '2022-01-14 16:53:20', '2022-01-14 16:53:20', '', 'Virtual Micrometer', '', 'inherit', 'closed', 'closed', '', '724-revision-v1', '', '', '2022-01-14 16:53:20', '2022-01-14 16:53:20', '', 724, 'http://olrp.test/?p=727', 0, 'revision', '', 0),
(728, 1, '2022-01-14 16:56:31', '2022-01-14 16:56:31', '', 'Virtual Dial Caliper', '', 'publish', 'open', 'closed', '', 'virtual-dial-caliper', '', '', '2022-01-14 16:56:32', '2022-01-14 16:56:32', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=728', 0, 'olrp_resource', '', 0),
(729, 1, '2022-01-14 16:56:17', '2022-01-14 16:56:17', '', '2022-01-14 09_03_23-Virtual Dial Caliper in Fractional Inch - Simulator _ Prof. Eduardo J. Stefanell', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_03_23-virtual-dial-caliper-in-fractional-inch-simulator-_-prof-eduardo-j-stefanell', '', '', '2022-01-14 16:56:17', '2022-01-14 16:56:17', '', 728, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_03_23-Virtual-Dial-Caliper-in-Fractional-Inch-Simulator-_-Prof.-Eduardo-J.-Stefanell.png', 0, 'attachment', 'image/png', 0),
(730, 1, '2022-01-14 16:56:31', '2022-01-14 16:56:31', '', 'Virtual Dial Caliper', '', 'inherit', 'closed', 'closed', '', '728-revision-v1', '', '', '2022-01-14 16:56:31', '2022-01-14 16:56:31', '', 728, 'http://olrp.test/?p=730', 0, 'revision', '', 0),
(731, 1, '2022-01-14 16:59:41', '2022-01-14 16:59:41', '', 'Vernier Caliper Simulator', '', 'publish', 'open', 'closed', '', 'vernier-caliper-simulator', '', '', '2022-01-14 16:59:42', '2022-01-14 16:59:42', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=731', 0, 'olrp_resource', '', 0),
(732, 1, '2022-01-14 16:59:09', '2022-01-14 16:59:09', '', '2022-01-14 09_06_25-Virtual Vernier Caliper - Milesimal Inch 25 Divisions Simulator _ Prof. Eduardo', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_06_25-virtual-vernier-caliper-milesimal-inch-25-divisions-simulator-_-prof-eduardo', '', '', '2022-01-14 16:59:09', '2022-01-14 16:59:09', '', 731, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_06_25-Virtual-Vernier-Caliper-Milesimal-Inch-25-Divisions-Simulator-_-Prof.-Eduardo-.png', 0, 'attachment', 'image/png', 0),
(733, 1, '2022-01-14 16:59:41', '2022-01-14 16:59:41', '', 'Vernier Caliper Simulator', '', 'inherit', 'closed', 'closed', '', '731-revision-v1', '', '', '2022-01-14 16:59:41', '2022-01-14 16:59:41', '', 731, 'http://olrp.test/?p=733', 0, 'revision', '', 0),
(735, 1, '2022-01-14 17:03:29', '2022-01-14 17:03:29', '', 'Reading an Inch Micrometer', '', 'publish', 'open', 'closed', '', 'reading-an-inch-micrometer', '', '', '2022-02-10 19:31:08', '2022-02-10 19:31:08', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=735', 0, 'olrp_resource', '', 0),
(736, 1, '2022-01-14 17:03:07', '2022-01-14 17:03:07', '', '2022-01-14 09_10_55-Reading a Micrometer - Wisc-Online OER', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_10_55-reading-a-micrometer-wisc-online-oer', '', '', '2022-01-14 17:03:07', '2022-01-14 17:03:07', '', 735, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_10_55-Reading-a-Micrometer-Wisc-Online-OER.png', 0, 'attachment', 'image/png', 0),
(737, 1, '2022-01-14 17:03:29', '2022-01-14 17:03:29', '', 'Reading an Inch Micrometer', '', 'inherit', 'closed', 'closed', '', '735-revision-v1', '', '', '2022-01-14 17:03:29', '2022-01-14 17:03:29', '', 735, 'http://olrp.test/?p=737', 0, 'revision', '', 0),
(738, 1, '2022-01-14 17:06:03', '2022-01-14 17:06:03', '', 'Using a Depth Micrometer', '', 'publish', 'open', 'closed', '', 'using-a-depth-micrometer', '', '', '2022-02-10 19:31:08', '2022-02-10 19:31:08', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=738', 0, 'olrp_resource', '', 1),
(739, 1, '2022-01-14 17:05:55', '2022-01-14 17:05:55', '', '2022-01-14 09_13_47-Using a Depth Micrometer - Wisc-Online OER', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_13_47-using-a-depth-micrometer-wisc-online-oer', '', '', '2022-01-14 17:05:55', '2022-01-14 17:05:55', '', 738, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_13_47-Using-a-Depth-Micrometer-Wisc-Online-OER.png', 0, 'attachment', 'image/png', 0),
(740, 1, '2022-01-14 17:06:03', '2022-01-14 17:06:03', '', 'Using a Depth Micrometer', '', 'inherit', 'closed', 'closed', '', '738-revision-v1', '', '', '2022-01-14 17:06:03', '2022-01-14 17:06:03', '', 738, 'http://olrp.test/?p=740', 0, 'revision', '', 0),
(743, 1, '2022-01-14 17:09:53', '2022-01-14 17:09:53', '', 'Gage Blocks', '', 'publish', 'open', 'closed', '', 'gage-blocks', '', '', '2022-02-10 19:31:08', '2022-02-10 19:31:08', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=743', 0, 'olrp_resource', '', 0),
(744, 1, '2022-01-14 17:09:40', '2022-01-14 17:09:40', '', '2022-01-14 09_17_28-Gage Blocks - Wisc-Online OER', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_17_28-gage-blocks-wisc-online-oer', '', '', '2022-01-14 17:09:40', '2022-01-14 17:09:40', '', 743, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_17_28-Gage-Blocks-Wisc-Online-OER.png', 0, 'attachment', 'image/png', 0),
(745, 1, '2022-01-14 17:09:53', '2022-01-14 17:09:53', '', 'Gage Blocks', '', 'inherit', 'closed', 'closed', '', '743-revision-v1', '', '', '2022-01-14 17:09:53', '2022-01-14 17:09:53', '', 743, 'http://olrp.test/?p=745', 0, 'revision', '', 0),
(746, 1, '2022-01-14 17:13:33', '2022-01-14 17:13:33', '', 'Using an Edge Finder', '', 'publish', 'open', 'closed', '', 'using-an-edge-finder', '', '', '2022-02-10 19:31:08', '2022-02-10 19:31:08', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=746', 0, 'olrp_resource', '', 0),
(747, 1, '2022-01-14 17:13:18', '2022-01-14 17:13:18', '', '2022-01-14 09_20_53-Using an Edge Finder - Wisc-Online OER', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_20_53-using-an-edge-finder-wisc-online-oer', '', '', '2022-01-14 17:13:18', '2022-01-14 17:13:18', '', 746, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_20_53-Using-an-Edge-Finder-Wisc-Online-OER.png', 0, 'attachment', 'image/png', 0),
(748, 1, '2022-01-14 17:13:33', '2022-01-14 17:13:33', '', 'Using an Edge Finder', '', 'inherit', 'closed', 'closed', '', '746-revision-v1', '', '', '2022-01-14 17:13:33', '2022-01-14 17:13:33', '', 746, 'http://olrp.test/?p=748', 0, 'revision', '', 0),
(749, 1, '2022-01-14 17:21:20', '2022-01-14 17:21:20', '', 'How to Read an Inch Micrometer', '', 'publish', 'open', 'closed', '', 'how-to-read-an-inch-micrometer', '', '', '2022-02-10 19:30:00', '2022-02-10 19:30:00', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=749', 0, 'olrp_resource', '', 1),
(750, 1, '2022-01-14 17:21:00', '2022-01-14 17:21:00', '', '2022-01-14 09_28_47-How To Read a Micrometer - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_28_47-how-to-read-a-micrometer-youtube', '', '', '2022-01-14 17:21:00', '2022-01-14 17:21:00', '', 749, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_28_47-How-To-Read-a-Micrometer-YouTube.png', 0, 'attachment', 'image/png', 0),
(751, 1, '2022-01-14 17:21:20', '2022-01-14 17:21:20', '', 'How to Read an Inch Micrometer', '', 'inherit', 'closed', 'closed', '', '749-revision-v1', '', '', '2022-01-14 17:21:20', '2022-01-14 17:21:20', '', 749, 'http://olrp.test/?p=751', 0, 'revision', '', 0),
(752, 1, '2022-01-14 17:24:06', '2022-01-14 17:24:06', '', 'Shop Talk 11: Vernier Calipers & How To Read Them', '', 'publish', 'open', 'closed', '', 'shop-talk-11-vernier-calipers-how-to-read-them', '', '', '2022-02-10 19:30:00', '2022-02-10 19:30:00', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=752', 0, 'olrp_resource', '', 1),
(753, 1, '2022-01-14 17:23:56', '2022-01-14 17:23:56', '', '2022-01-14 09_30_21-Shop Talk 11_ Vernier Calipers & How To Read Them - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_30_21-shop-talk-11_-vernier-calipers-how-to-read-them-youtube', '', '', '2022-01-14 17:23:56', '2022-01-14 17:23:56', '', 752, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_30_21-Shop-Talk-11_-Vernier-Calipers-How-To-Read-Them-YouTube.png', 0, 'attachment', 'image/png', 0),
(754, 1, '2022-01-14 17:24:06', '2022-01-14 17:24:06', '', 'Shop Talk 11: Vernier Calipers & How To Read Them', '', 'inherit', 'closed', 'closed', '', '752-revision-v1', '', '', '2022-01-14 17:24:06', '2022-01-14 17:24:06', '', 752, 'http://olrp.test/?p=754', 0, 'revision', '', 0),
(755, 1, '2022-01-14 17:26:56', '2022-01-14 17:26:56', '', 'Shop Talk 10: Telescope Gages & How They\'re Used', '', 'publish', 'open', 'closed', '', 'shop-talk-10-telescope-gages-how-theyre-used', '', '', '2022-04-21 04:24:18', '2022-04-21 04:24:18', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=755', 0, 'olrp_resource', '', 1),
(756, 1, '2022-01-14 17:26:47', '2022-01-14 17:26:47', '', '2022-01-14 09_34_31-Shop Talk 10_ Telescope Gages & How They\'re Used - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_34_31-shop-talk-10_-telescope-gages-how-theyre-used-youtube', '', '', '2022-01-14 17:26:47', '2022-01-14 17:26:47', '', 755, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_34_31-Shop-Talk-10_-Telescope-Gages-How-Theyre-Used-YouTube.png', 0, 'attachment', 'image/png', 0),
(757, 1, '2022-01-14 17:26:56', '2022-01-14 17:26:56', '', 'Shop Talk 10: Telescope Gages & How They\'re Used', '', 'inherit', 'closed', 'closed', '', '755-revision-v1', '', '', '2022-01-14 17:26:56', '2022-01-14 17:26:56', '', 755, 'http://olrp.test/?p=757', 0, 'revision', '', 0),
(759, 1, '2022-01-14 17:29:27', '2022-01-14 17:29:27', '', '2022-01-14 09_37_17-How to select the right Edge Finder for you - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_37_17-how-to-select-the-right-edge-finder-for-you-youtube', '', '', '2022-01-14 17:29:27', '2022-01-14 17:29:27', '', 678, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_37_17-How-to-select-the-right-Edge-Finder-for-you-YouTube.png', 0, 'attachment', 'image/png', 0),
(762, 1, '2022-01-14 17:39:09', '2022-01-14 17:39:09', '', '2022-01-14 09_46_57-How To Machine and Square 6 Sides of a Block Using Only 2 Setups - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_46_57-how-to-machine-and-square-6-sides-of-a-block-using-only-2-setups-youtube', '', '', '2022-01-14 17:39:09', '2022-01-14 17:39:09', '', 687, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_46_57-How-To-Machine-and-Square-6-Sides-of-a-Block-Using-Only-2-Setups-YouTube.png', 0, 'attachment', 'image/png', 0),
(763, 1, '2022-01-14 17:42:16', '2022-01-14 17:42:16', '', 'Surface Grinder Basics - How to Grind Fast and Accurate', '', 'publish', 'open', 'closed', '', 'surface-grinder-basics-how-to-grind-fast-and-accurate', '', '', '2022-02-10 19:30:00', '2022-02-10 19:30:00', '', 0, 'http://olrp.test/?post_type=olrp_resource&#038;p=763', 0, 'olrp_resource', '', 0),
(764, 1, '2022-01-14 17:42:06', '2022-01-14 17:42:06', '', '2022-01-14 09_49_57-Surface Grinder Basics - How to Grind Fast and Accurate - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_49_57-surface-grinder-basics-how-to-grind-fast-and-accurate-youtube', '', '', '2022-01-14 17:42:06', '2022-01-14 17:42:06', '', 763, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_49_57-Surface-Grinder-Basics-How-to-Grind-Fast-and-Accurate-YouTube.png', 0, 'attachment', 'image/png', 0),
(765, 1, '2022-01-14 17:42:16', '2022-01-14 17:42:16', '', 'Surface Grinder Basics - How to Grind Fast and Accurate', '', 'inherit', 'closed', 'closed', '', '763-revision-v1', '', '', '2022-01-14 17:42:16', '2022-01-14 17:42:16', '', 763, 'http://olrp.test/?p=765', 0, 'revision', '', 0),
(767, 1, '2022-01-14 17:44:29', '2022-01-14 17:44:29', '', '2022-01-14 09_52_18-How to square the Bridgeport head with the table - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_52_18-how-to-square-the-bridgeport-head-with-the-table-youtube', '', '', '2022-01-14 17:44:29', '2022-01-14 17:44:29', '', 686, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_52_18-How-to-square-the-Bridgeport-head-with-the-table-YouTube.png', 0, 'attachment', 'image/png', 0),
(769, 1, '2022-01-14 17:47:57', '2022-01-14 17:47:57', '', '2022-01-14 09_55_46-Setting a Work Zero with an Edge FInder - YouTube', '', 'inherit', 'open', 'closed', '', '2022-01-14-09_55_46-setting-a-work-zero-with-an-edge-finder-youtube', '', '', '2022-01-14 17:47:57', '2022-01-14 17:47:57', '', 679, 'http://olrp.test/wp-content/uploads/2022/01/2022-01-14-09_55_46-Setting-a-Work-Zero-with-an-Edge-FInder-YouTube.png', 0, 'attachment', 'image/png', 0),
(771, 1, '2022-01-31 01:15:55', '2022-01-31 01:15:55', '{\"version\": 2, \"isGlobalStylesUserThemeJSON\": true }', 'Custom Styles', '', 'publish', 'closed', 'closed', '', 'wp-global-styles-olrp_subtheme', '', '', '2022-01-31 01:15:55', '2022-01-31 01:15:55', '', 0, 'http://olrp.test/?p=771', 0, 'wp_global_styles', '', 0);
INSERT INTO `wp6c_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(775, 1, '2022-04-21 03:37:23', '2022-04-21 03:37:23', 'Hass Tip of the Day Cover Image', '2022-04-20 20_36_07-Haas Automation, Inc. - YouTube', 'Hass Tip of the Day Cover Image', 'inherit', 'open', 'closed', '', '2022-04-20-20_36_07-haas-automation-inc-youtube', '', '', '2022-04-21 03:38:01', '2022-04-21 03:38:01', '', 677, 'http://olrp.test/wp-content/uploads/2022/01/2022-04-20-20_36_07-Haas-Automation-Inc.-YouTube.png', 0, 'attachment', 'image/png', 0),
(776, 1, '2022-04-21 03:38:05', '2022-04-21 03:38:05', '', 'Haas Tip of the Day - Main Channel Page', 'Haas Tip of the Day - Good entry level tips for CNC setup and operation.', 'inherit', 'closed', 'closed', '', '677-revision-v1', '', '', '2022-04-21 03:38:05', '2022-04-21 03:38:05', '', 677, 'http://olrp.test/?p=776', 0, 'revision', '', 0),
(778, 1, '2022-04-21 03:47:31', '2022-04-21 03:47:31', '', 'Test Post', '', 'trash', 'open', 'open', '', 'test-post__trashed', '', '', '2022-04-21 03:48:15', '2022-04-21 03:48:15', '', 0, 'http://olrp.test/?p=778', 0, 'post', '', 0),
(779, 1, '2022-04-21 03:47:31', '2022-04-21 03:47:31', '', 'Test Post', '', 'inherit', 'closed', 'closed', '', '778-revision-v1', '', '', '2022-04-21 03:47:31', '2022-04-21 03:47:31', '', 778, 'http://olrp.test/?p=779', 0, 'revision', '', 0),
(782, 1, '2022-04-21 04:45:15', '2022-04-21 04:45:15', '', '2022-04-20 21_44_29-How To Calculate Speeds and Feeds (Inch Version) - Haas Automation Tip of the Da', '', 'inherit', 'open', 'closed', '', '2022-04-20-21_44_29-how-to-calculate-speeds-and-feeds-inch-version-haas-automation-tip-of-the-da', '', '', '2022-04-21 04:45:15', '2022-04-21 04:45:15', '', 688, 'http://olrp.test/wp-content/uploads/2022/01/2022-04-20-21_44_29-How-To-Calculate-Speeds-and-Feeds-Inch-Version-Haas-Automation-Tip-of-the-Da.png', 0, 'attachment', 'image/png', 0),
(785, 1, '2022-05-09 00:15:58', '2022-05-09 00:15:58', '<p>[cbxwpbookmark-mycat title=\"\" allowedit=1 display=1][cbxwpbookmark cattitle=1 allowdelete=1]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'publish', 'closed', 'closed', '', 'mybookmarks', '', '', '2022-05-12 23:00:29', '2022-05-12 23:00:29', '', 0, 'http://olrp.test/?page_id=785', 0, 'page', '', 0),
(786, 2, '2022-05-12 19:27:08', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2022-05-12 19:27:08', '0000-00-00 00:00:00', '', 0, 'http://olrp.test/?p=786', 0, 'post', '', 0),
(787, 2, '2022-05-12 19:30:33', '2022-05-12 19:30:33', '<!-- wp:codeboxr/cbxwpbookmark-postgrid-block /-->\n\n<!-- wp:codeboxr/cbxwpbookmark-mycat-block /-->', 'Test Page', '', 'publish', 'closed', 'closed', '', 'test-page', '', '', '2022-05-12 19:30:34', '2022-05-12 19:30:34', '', 0, 'http://olrp.test/?page_id=787', 0, 'page', '', 0),
(788, 2, '2022-05-12 19:29:50', '2022-05-12 19:29:50', '<!-- wp:codeboxr/cbxwpbookmark-postgrid-block /-->\n\n<!-- wp:codeboxr/cbxwpbookmark-mycat-block /-->', 'Test Page', '', 'inherit', 'closed', 'closed', '', '787-revision-v1', '', '', '2022-05-12 19:29:50', '2022-05-12 19:29:50', '', 787, 'http://olrp.test/?p=788', 0, 'revision', '', 0),
(789, 2, '2022-05-12 19:37:36', '2022-05-12 19:37:36', '<!-- wp:codeboxr/cbxwpbookmark-mycat-block /-->\n\n<!-- wp:columns {\"align\":\"wide\",\"className\":\"is-style-default\"} -->\n<div class=\"wp-block-columns alignwide is-style-default\"><!-- wp:column {\"width\":\"100%\"} -->\n<div class=\"wp-block-column\" style=\"flex-basis:100%\"><!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:codeboxr/cbxwpbookmark-postgrid-block /--></div>\n<!-- /wp:group --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->', 'Test Page', '', 'inherit', 'closed', 'closed', '', '787-autosave-v1', '', '', '2022-05-12 19:37:36', '2022-05-12 19:37:36', '', 787, 'http://olrp.test/?p=789', 0, 'revision', '', 0),
(791, 2, '2022-05-12 20:03:52', '2022-05-12 20:03:52', '<p>[cbxwpbookmark-mycat allowedit=1 display=1][cbxwpbookmark]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 20:03:52', '2022-05-12 20:03:52', '', 785, 'http://olrp.test/?p=791', 0, 'revision', '', 0),
(792, 2, '2022-05-12 20:04:39', '2022-05-12 20:04:39', '<p>[cbxwpbookmark-mycat allowedit=1 display=1]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 20:04:39', '2022-05-12 20:04:39', '', 785, 'http://olrp.test/?p=792', 0, 'revision', '', 0),
(794, 2, '2022-05-12 20:06:13', '2022-05-12 20:06:13', '<p>[cbxwpbookmark-mycat allowedit=1 display=1][cbxwpbookmark]</p>\n<p>[cbxwpbookmarkgrid]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 20:06:13', '2022-05-12 20:06:13', '', 785, 'http://olrp.test/?p=794', 0, 'revision', '', 0),
(796, 2, '2022-05-12 22:09:19', '2022-05-12 22:09:19', '<p>[cbxwpbookmark-mycat allowedit=1][cbxwpbookmark]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 22:09:19', '2022-05-12 22:09:19', '', 785, 'http://olrp.test/?p=796', 0, 'revision', '', 0),
(797, 2, '2022-05-12 22:23:18', '2022-05-12 22:23:18', '<p>[cbxwpbookmark-mycat title=\"\" allowedit=1][cbxwpbookmark]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 22:23:18', '2022-05-12 22:23:18', '', 785, 'http://olrp.test/?p=797', 0, 'revision', '', 0),
(798, 2, '2022-05-12 22:24:23', '2022-05-12 22:24:23', '<p>[cbxwpbookmark-mycat title=\"\" allowedit=1 display=1][cbxwpbookmark cattitle=1]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 22:24:23', '2022-05-12 22:24:23', '', 785, 'http://olrp.test/?p=798', 0, 'revision', '', 0),
(800, 2, '2022-05-12 22:30:00', '2022-05-12 22:30:00', '<p>[cbxwpbookmark-mycat title=\"\" allowedit=1 display=1][cbxwpbookmarkgrid cattitle=1 allowdelete=0 ]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 22:30:00', '2022-05-12 22:30:00', '', 785, 'http://olrp.test/?p=800', 0, 'revision', '', 0),
(801, 2, '2022-05-12 22:35:57', '2022-05-12 22:35:57', '', '2022-05-12 15_34_48-How to choose correct turning insert', '', 'inherit', 'open', 'closed', '', '2022-05-12-15_34_48-how-to-choose-correct-turning-insert', '', '', '2022-05-12 22:36:21', '2022-05-12 22:36:21', '', 674, 'http://olrp.test/wp-content/uploads/2022/01/2022-05-12-15_34_48-How-to-choose-correct-turning-insert.png', 0, 'attachment', 'image/png', 0),
(802, 2, '2022-05-12 22:58:00', '2022-05-12 22:58:00', '<p>[cbxwpbookmark-mycat title=\"\" allowedit=1 display=1][cbxwpbookmarkgrid cattitle=1 allowdelete=1 ]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 22:58:00', '2022-05-12 22:58:00', '', 785, 'http://olrp.test/?p=802', 0, 'revision', '', 0),
(803, 2, '2022-05-12 23:00:29', '2022-05-12 23:00:29', '<p>[cbxwpbookmark-mycat title=\"\" allowedit=1 display=1][cbxwpbookmark cattitle=1 allowdelete=1]</p>\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'My Resource Lists', '', 'inherit', 'closed', 'closed', '', '785-revision-v1', '', '', '2022-05-12 23:00:29', '2022-05-12 23:00:29', '', 785, 'http://olrp.test/?p=803', 0, 'revision', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_rmp_analytics`
--

DROP TABLE IF EXISTS `wp6c_rmp_analytics`;
CREATE TABLE `wp6c_rmp_analytics` (
  `id` mediumint(9) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` smallint(5) NOT NULL,
  `post` mediumint(9) NOT NULL,
  `action` smallint(5) NOT NULL,
  `duration` smallint(5) NOT NULL,
  `average` decimal(2,1) NOT NULL,
  `votes` smallint(5) NOT NULL,
  `value` smallint(5) NOT NULL,
  `token` tinytext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_rmp_analytics`
--

INSERT INTO `wp6c_rmp_analytics` (`id`, `time`, `ip`, `country`, `user`, `post`, `action`, `duration`, `average`, `votes`, `value`, `token`) VALUES
(1, '2022-04-21 03:47:38', '-1', '0', -1, 778, 1, 3, '1.0', 1, 1, '-1'),
(2, '2022-04-21 04:09:51', '-1', '0', -1, 673, 1, 17, '3.0', 1, 3, '-1'),
(3, '2022-04-21 04:10:56', '-1', '0', -1, 743, 1, 16, '4.0', 1, 4, '-1'),
(4, '2022-04-21 04:11:37', '-1', '0', -1, 728, 1, 4, '5.0', 1, 5, '-1'),
(5, '2022-04-21 04:14:20', '-1', '0', -1, 752, 1, 16, '5.0', 1, 5, '-1'),
(6, '2022-04-21 04:18:17', '-1', '0', -1, 749, 1, 14, '4.0', 1, 4, '-1'),
(7, '2022-04-21 04:20:19', '-1', '0', -1, 738, 1, 3, '4.0', 1, 4, '-1'),
(8, '2022-04-21 04:21:29', '-1', '0', -1, 755, 1, 10, '5.0', 1, 5, '-1'),
(9, '2022-04-21 04:29:36', '-1', '0', -1, 724, 1, 13, '5.0', 1, 5, '-1'),
(10, '2022-05-12 22:26:46', '-1', '0', -1, 724, 1, 11, '4.5', 2, 4, '-1');

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_termmeta`
--

DROP TABLE IF EXISTS `wp6c_termmeta`;
CREATE TABLE `wp6c_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_terms`
--

DROP TABLE IF EXISTS `wp6c_terms`;
CREATE TABLE `wp6c_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_terms`
--

INSERT INTO `wp6c_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0),
(2, 'TAG1a', 'tag1a', 0),
(3, 'TAG1b', 'tag1b', 0),
(4, 'Tag2a', 'tag2a', 0),
(5, 'Tag2b', 'tag2b', 0),
(6, 'Machine Tool Technology', 'machine-tool-technology', 0),
(7, 'Mechatronics', 'mechatronics', 0),
(8, 'Welding', 'welding', 0),
(9, 'Non-Destructive Testing', 'non-destructive-testing', 0),
(10, 'CNC', 'cnc', 0),
(11, 'mill', 'mill', 0),
(12, 'setup', 'setup', 0),
(13, 'Video', 'video', 0),
(14, 'OLRP', 'olrp', 0),
(15, 'lathe', 'lathe', 0),
(16, 'manual machining', 'manual-machining', 0),
(17, 'jobs', 'jobs', 0),
(18, 'Manual Lathe', 'manual-lathe', 0),
(19, '4 jaw', '4-jaw', 0),
(20, 'indicating', 'indicating', 0),
(21, 'manual', 'manual', 0),
(22, 'insert', 'insert', 0),
(23, 'carbide', 'carbide', 0),
(24, 'training', 'training', 0),
(25, 'interactive', 'interactive', 0),
(26, 'OER', 'oer', 0),
(27, 'edge finder', 'edge-finder', 0),
(28, 'cnc sine bar', 'cnc-sine-bar', 0),
(29, 'testing', 'testing', 0),
(30, 'steady rest', 'steady-rest', 0),
(31, 'threads', 'threads', 0),
(32, 'threading', 'threading', 0),
(33, 'safety', 'safety', 0),
(34, 'cutting conditions', 'cutting-conditions', 0),
(35, 'micrometer', 'micrometer', 0),
(36, 'measurement', 'measurement', 0),
(37, 'e-learning', 'e-learning', 0),
(38, 'print reading', 'print-reading', 0),
(39, 'operation', 'operation', 0),
(40, 'work offset', 'work-offset', 0),
(41, 'reaming', 'reaming', 0),
(42, 'tapping', 'tapping', 0),
(43, 'videos', 'videos', 0),
(44, 'tutorial', 'tutorial', 0),
(45, 'speeds and feeds', 'speeds-and-feeds', 0),
(46, 'head tramming', 'head-tramming', 0),
(47, 'square stock', 'square-stock', 0),
(48, 'quick tip', 'quick-tip', 0),
(49, 'speed and feed', 'speed-and-feed', 0),
(50, 'Adam Booth', 'adam-booth', 0),
(51, 'Joe Piszyensky', 'joe-piszyensky', 0),
(52, 'Don Bailey', 'don-bailey', 0),
(53, 'Suburban Tool Video Series', 'suburban-tool', 0),
(54, 'Haas Tip of the Day', 'haas-tip-of-the-day', 0),
(56, 'CNC Mill 1', 'cnc-mill-1', 0),
(57, 'Joe Pieczynski', 'joe-pieczynski', 0),
(58, 'Nursing', 'nursing', 0),
(59, 'Haas Automation', 'haas-automation', 0),
(60, 'Carbide Depot', 'carbide-depot', 0),
(61, 'Kelly Curran', 'kelly-curran', 0),
(62, 'Janet Braun', 'janet-braun', 0),
(63, 'wisc-online', 'wisc-online', 0),
(64, 'Dan Gelbart', 'dan-gelbart', 0),
(65, 'Sandvik Cormorant', 'sandvik-cormorant', 0),
(67, 'Haas Automation Tip of the day', 'haas-automation-tip-of-the-day', 0),
(69, 'Charled Skeen', 'charled-skeen', 0),
(70, 'Charles Skeen', 'charles-skeen', 0),
(71, 'Tom\'s Techniques', 'toms-techniques', 0),
(73, '; Haas Automation, Inc. ; Haas Automation, Inc.;', 'haas-automation-inc-haas-automation-inc', 0),
(74, 'inspection', 'inspection', 0),
(75, 'Prof. Eduardo J. Stefanelli', 'prof-eduardo-j-stefanelli', 0),
(76, 'vernier', 'vernier', 0),
(77, 'Sue Silverstein', 'sue-silverstein', 0),
(78, 'WISC-Online', 'wisc-online', 0),
(79, 'Terry Fleischman', 'terry-fleischman', 0),
(80, 'metrology', 'metrology', 0),
(81, 'Barbara Anderegg', 'barbara-anderegg', 0),
(82, 'Youtube', 'youtube', 0),
(83, 'surface grinder', 'surface-grinder', 0),
(84, 'Inc. ; Haas Automation', 'inc-haas-automation', 0),
(85, 'Inc.;', 'inc', 0),
(86, 'olrp_subtheme', 'olrp_subtheme', 0),
(87, 'Commercial', 'commercial', 0),
(88, 'Free', 'free', 0),
(89, 'Open Educational Resource', 'oer', 0),
(90, 'Ad Supported', 'ads', 0),
(91, 'Machine Tool', 'machine-tool', 0),
(92, 'Mechatronics', 'mechatronics', 0),
(93, 'Welding', 'welding', 0),
(94, 'Non-Destructive Testing', 'ndt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_term_relationships`
--

DROP TABLE IF EXISTS `wp6c_term_relationships`;
CREATE TABLE `wp6c_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_term_relationships`
--

INSERT INTO `wp6c_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(654, 6, 0),
(654, 10, 0),
(654, 11, 0),
(654, 12, 0),
(654, 13, 0),
(654, 14, 0),
(654, 54, 0),
(654, 59, 0),
(655, 6, 0),
(655, 13, 0),
(655, 14, 0),
(655, 15, 0),
(655, 16, 0),
(655, 17, 0),
(655, 50, 0),
(656, 6, 0),
(656, 13, 0),
(656, 14, 0),
(656, 18, 0),
(656, 50, 0),
(657, 6, 0),
(657, 13, 0),
(657, 14, 0),
(657, 18, 0),
(657, 50, 0),
(658, 6, 0),
(658, 12, 0),
(658, 13, 0),
(658, 14, 0),
(658, 18, 0),
(658, 19, 0),
(658, 20, 0),
(658, 50, 0),
(659, 6, 0),
(659, 11, 0),
(659, 13, 0),
(659, 14, 0),
(659, 15, 0),
(659, 21, 0),
(660, 6, 0),
(660, 10, 0),
(660, 14, 0),
(660, 15, 0),
(660, 21, 0),
(660, 22, 0),
(660, 23, 0),
(660, 60, 0),
(661, 6, 0),
(661, 10, 0),
(661, 15, 0),
(661, 21, 0),
(661, 22, 0),
(661, 23, 0),
(661, 61, 0),
(661, 78, 0),
(661, 89, 0),
(661, 91, 0),
(661, 92, 0),
(662, 6, 0),
(663, 6, 0),
(663, 14, 0),
(663, 21, 0),
(663, 24, 0),
(663, 25, 0),
(663, 26, 0),
(663, 28, 0),
(663, 62, 0),
(664, 6, 0),
(664, 10, 0),
(664, 12, 0),
(664, 13, 0),
(664, 14, 0),
(664, 21, 0),
(664, 24, 0),
(664, 26, 0),
(664, 62, 0),
(665, 6, 0),
(665, 14, 0),
(665, 24, 0),
(665, 25, 0),
(665, 26, 0),
(665, 29, 0),
(665, 63, 0),
(666, 6, 0),
(666, 13, 0),
(666, 14, 0),
(667, 6, 0),
(667, 13, 0),
(667, 14, 0),
(667, 15, 0),
(667, 21, 0),
(667, 24, 0),
(667, 26, 0),
(667, 30, 0),
(667, 57, 0),
(668, 6, 0),
(668, 13, 0),
(668, 14, 0),
(668, 15, 0),
(668, 21, 0),
(668, 24, 0),
(668, 26, 0),
(668, 57, 0),
(669, 6, 0),
(669, 10, 0),
(669, 13, 0),
(669, 21, 0),
(669, 24, 0),
(669, 26, 0),
(669, 57, 0),
(670, 6, 0),
(670, 11, 0),
(670, 13, 0),
(670, 14, 0),
(670, 21, 0),
(670, 24, 0),
(670, 26, 0),
(670, 57, 0),
(671, 6, 0),
(671, 13, 0),
(671, 14, 0),
(671, 21, 0),
(671, 24, 0),
(671, 26, 0),
(671, 31, 0),
(671, 32, 0),
(671, 57, 0),
(672, 6, 0),
(672, 13, 0),
(672, 14, 0),
(672, 21, 0),
(672, 24, 0),
(672, 26, 0),
(672, 31, 0),
(672, 32, 0),
(672, 57, 0),
(673, 6, 0),
(673, 11, 0),
(673, 13, 0),
(673, 14, 0),
(673, 15, 0),
(673, 33, 0),
(673, 64, 0),
(674, 6, 0),
(674, 10, 0),
(674, 14, 0),
(674, 15, 0),
(674, 21, 0),
(674, 22, 0),
(674, 34, 0),
(674, 65, 0),
(675, 6, 0),
(676, 6, 0),
(676, 10, 0),
(676, 11, 0),
(676, 13, 0),
(676, 14, 0),
(676, 15, 0),
(676, 21, 0),
(676, 36, 0),
(676, 37, 0),
(676, 38, 0),
(677, 6, 0),
(677, 10, 0),
(677, 11, 0),
(677, 12, 0),
(677, 15, 0),
(677, 54, 0),
(677, 59, 0),
(677, 90, 0),
(677, 91, 0),
(678, 6, 0),
(678, 11, 0),
(678, 27, 0),
(678, 52, 0),
(678, 53, 0),
(679, 6, 0),
(679, 11, 0),
(679, 27, 0),
(679, 70, 0),
(679, 82, 0),
(680, 6, 0),
(680, 10, 0),
(680, 11, 0),
(680, 13, 0),
(680, 14, 0),
(680, 24, 0),
(680, 27, 0),
(680, 40, 0),
(680, 54, 0),
(680, 59, 0),
(681, 6, 0),
(681, 11, 0),
(681, 41, 0),
(681, 70, 0),
(681, 82, 0),
(682, 6, 0),
(682, 13, 0),
(682, 14, 0),
(682, 24, 0),
(682, 42, 0),
(682, 70, 0),
(683, 6, 0),
(683, 11, 0),
(683, 14, 0),
(683, 24, 0),
(683, 43, 0),
(683, 70, 0),
(684, 6, 0),
(684, 11, 0),
(684, 13, 0),
(684, 14, 0),
(684, 24, 0),
(684, 71, 0),
(685, 6, 0),
(685, 11, 0),
(685, 14, 0),
(685, 24, 0),
(685, 44, 0),
(685, 45, 0),
(685, 71, 0),
(686, 6, 0),
(686, 11, 0),
(686, 12, 0),
(686, 52, 0),
(687, 6, 0),
(687, 11, 0),
(687, 52, 0),
(687, 53, 0),
(688, 6, 0),
(688, 10, 0),
(688, 13, 0),
(688, 49, 0),
(688, 54, 0),
(688, 59, 0),
(688, 90, 0),
(688, 91, 0),
(688, 92, 0),
(724, 6, 0),
(724, 7, 0),
(724, 35, 0),
(724, 74, 0),
(724, 75, 0),
(728, 6, 0),
(728, 7, 0),
(728, 74, 0),
(728, 75, 0),
(731, 6, 0),
(731, 7, 0),
(731, 74, 0),
(731, 75, 0),
(731, 76, 0),
(735, 6, 0),
(735, 7, 0),
(735, 35, 0),
(735, 74, 0),
(735, 77, 0),
(735, 78, 0),
(735, 89, 0),
(735, 91, 0),
(735, 92, 0),
(738, 6, 0),
(738, 7, 0),
(738, 35, 0),
(738, 74, 0),
(738, 78, 0),
(738, 79, 0),
(738, 89, 0),
(738, 91, 0),
(738, 92, 0),
(743, 6, 0),
(743, 7, 0),
(743, 74, 0),
(743, 78, 0),
(743, 80, 0),
(743, 81, 0),
(743, 89, 0),
(743, 91, 0),
(743, 92, 0),
(746, 6, 0),
(746, 10, 0),
(746, 12, 0),
(746, 21, 0),
(746, 61, 0),
(746, 78, 0),
(746, 89, 0),
(746, 91, 0),
(746, 92, 0),
(749, 6, 0),
(749, 7, 0),
(749, 35, 0),
(749, 50, 0),
(749, 74, 0),
(749, 82, 0),
(749, 90, 0),
(749, 91, 0),
(749, 92, 0),
(752, 6, 0),
(752, 50, 0),
(752, 74, 0),
(752, 76, 0),
(752, 82, 0),
(752, 90, 0),
(752, 91, 0),
(752, 92, 0),
(755, 6, 0),
(755, 15, 0),
(755, 50, 0),
(755, 74, 0),
(755, 82, 0),
(755, 90, 0),
(755, 91, 0),
(755, 92, 0),
(763, 6, 0),
(763, 52, 0),
(763, 53, 0),
(763, 82, 0),
(763, 83, 0),
(763, 90, 0),
(763, 91, 0),
(763, 92, 0),
(771, 86, 0),
(778, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp6c_term_taxonomy`
--

DROP TABLE IF EXISTS `wp6c_term_taxonomy`;
CREATE TABLE `wp6c_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp6c_term_taxonomy`
--

INSERT INTO `wp6c_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 0),
(2, 2, 'post_tag', '', 0, 0),
(3, 3, 'post_tag', '', 0, 0),
(4, 4, 'post_tag', '', 0, 0),
(5, 5, 'post_tag', '', 0, 0),
(6, 6, 'category', '', 0, 44),
(7, 7, 'category', '', 0, 7),
(8, 8, 'category', '', 0, 0),
(9, 9, 'category', '', 0, 0),
(10, 10, 'post_tag', '', 0, 11),
(11, 11, 'post_tag', '', 0, 15),
(12, 12, 'post_tag', '', 0, 6),
(13, 13, 'post_tag', '', 0, 20),
(14, 14, 'post_tag', '', 0, 24),
(15, 15, 'post_tag', '', 0, 11),
(16, 16, 'post_tag', '', 0, 1),
(17, 17, 'post_tag', '', 0, 1),
(18, 18, 'post_tag', '', 0, 3),
(19, 19, 'post_tag', '', 0, 1),
(20, 20, 'post_tag', '', 0, 1),
(21, 21, 'post_tag', '', 0, 14),
(22, 22, 'post_tag', '', 0, 3),
(23, 23, 'post_tag', '', 0, 2),
(24, 24, 'post_tag', '', 0, 14),
(25, 25, 'post_tag', '', 0, 2),
(26, 26, 'post_tag', '', 0, 9),
(27, 27, 'post_tag', '', 0, 3),
(28, 28, 'post_tag', '', 0, 1),
(29, 29, 'post_tag', '', 0, 1),
(30, 30, 'post_tag', '', 0, 1),
(31, 31, 'post_tag', '', 0, 2),
(32, 32, 'post_tag', '', 0, 2),
(33, 33, 'post_tag', '', 0, 1),
(34, 34, 'post_tag', '', 0, 1),
(35, 35, 'post_tag', '', 0, 4),
(36, 36, 'post_tag', '', 0, 1),
(37, 37, 'post_tag', '', 0, 1),
(38, 38, 'post_tag', '', 0, 1),
(39, 39, 'post_tag', '', 0, 0),
(40, 40, 'post_tag', '', 0, 1),
(41, 41, 'post_tag', '', 0, 1),
(42, 42, 'post_tag', '', 0, 1),
(43, 43, 'post_tag', '', 0, 1),
(44, 44, 'post_tag', '', 0, 1),
(45, 45, 'post_tag', '', 0, 1),
(46, 46, 'post_tag', '', 0, 0),
(47, 47, 'post_tag', '', 0, 0),
(48, 48, 'post_tag', '', 0, 0),
(49, 49, 'post_tag', '', 0, 1),
(50, 50, 'creator', '', 0, 7),
(51, 51, 'creator', '', 0, 0),
(52, 52, 'creator', '', 0, 4),
(53, 53, 'collection', '', 0, 3),
(54, 54, 'collection', '', 0, 4),
(56, 56, 'resource_list', '', 0, 0),
(57, 57, 'creator', '', 0, 6),
(58, 58, 'category', '', 0, 0),
(59, 59, 'creator', '', 0, 4),
(60, 60, 'creator', '', 0, 1),
(61, 61, 'creator', '', 0, 2),
(62, 62, 'creator', '', 0, 2),
(63, 63, 'creator', '', 0, 1),
(64, 64, 'creator', '', 0, 1),
(65, 65, 'creator', '', 0, 1),
(67, 67, 'creator', '', 0, 0),
(69, 69, 'creator', '', 0, 0),
(70, 70, 'creator', '', 0, 4),
(71, 71, 'creator', '', 0, 2),
(73, 73, 'creator', '', 0, 0),
(74, 74, 'post_tag', '', 0, 9),
(75, 75, 'creator', '', 0, 3),
(76, 76, 'post_tag', '', 0, 2),
(77, 77, 'creator', '', 0, 1),
(78, 78, 'collection', '', 0, 5),
(79, 79, 'creator', '', 0, 1),
(80, 80, 'post_tag', '', 0, 1),
(81, 81, 'creator', '', 0, 1),
(82, 82, 'collection', '', 0, 6),
(83, 83, 'post_tag', '', 0, 1),
(84, 84, 'creator', '', 0, 0),
(85, 85, 'creator', '', 0, 0),
(86, 86, 'wp_theme', '', 0, 1),
(87, 87, 'licensing', 'Need to pay a fee to use the resource', 0, 0),
(88, 88, 'licensing', 'No fees, no ads, not OER', 0, 0),
(89, 89, 'licensing', 'Licensed for open use using one of the Creative Commons Licenses or other open source licenses such as GPL ', 0, 5),
(90, 90, 'licensing', 'Free to use but ads will display', 0, 6),
(91, 91, 'department', '', 0, 11),
(92, 92, 'department', '', 0, 10),
(93, 93, 'department', '', 0, 0),
(94, 94, 'department', '', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp6c_cbxwpbookmark`
--
ALTER TABLE `wp6c_cbxwpbookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp6c_cbxwpbookmarkcat`
--
ALTER TABLE `wp6c_cbxwpbookmarkcat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wp6c_commentmeta`
--
ALTER TABLE `wp6c_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp6c_comments`
--
ALTER TABLE `wp6c_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Indexes for table `wp6c_links`
--
ALTER TABLE `wp6c_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp6c_postmeta`
--
ALTER TABLE `wp6c_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp6c_posts`
--
ALTER TABLE `wp6c_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp6c_rmp_analytics`
--
ALTER TABLE `wp6c_rmp_analytics`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `wp6c_termmeta`
--
ALTER TABLE `wp6c_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp6c_terms`
--
ALTER TABLE `wp6c_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp6c_term_relationships`
--
ALTER TABLE `wp6c_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp6c_term_taxonomy`
--
ALTER TABLE `wp6c_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp6c_cbxwpbookmark`
--
ALTER TABLE `wp6c_cbxwpbookmark`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wp6c_cbxwpbookmarkcat`
--
ALTER TABLE `wp6c_cbxwpbookmarkcat`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wp6c_commentmeta`
--
ALTER TABLE `wp6c_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wp6c_comments`
--
ALTER TABLE `wp6c_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wp6c_links`
--
ALTER TABLE `wp6c_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp6c_postmeta`
--
ALTER TABLE `wp6c_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1961;

--
-- AUTO_INCREMENT for table `wp6c_posts`
--
ALTER TABLE `wp6c_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=804;

--
-- AUTO_INCREMENT for table `wp6c_rmp_analytics`
--
ALTER TABLE `wp6c_rmp_analytics`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wp6c_termmeta`
--
ALTER TABLE `wp6c_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wp6c_terms`
--
ALTER TABLE `wp6c_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `wp6c_term_taxonomy`
--
ALTER TABLE `wp6c_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
