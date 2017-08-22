-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql9.freemysqlhosting.net
-- Generation Time: Aug 21, 2017 at 08:42 AM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql9190960`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_log`
--

CREATE TABLE `chat_log` (
  `id` int(11) NOT NULL,
  `type` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `reply_token` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `source_type` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `source_user_id` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `source_group_id` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `message_time` bigint(20) DEFAULT NULL,
  `message_type` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `message_id` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `message_text` varchar(5000) DEFAULT NULL,
  `message_ref` varchar(5000) DEFAULT NULL,
  `step` tinyint(1) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chat_log`
--

INSERT INTO `chat_log` (`id`, `type`, `reply_token`, `source_type`, `source_user_id`, `source_group_id`, `message_time`, `message_type`, `message_id`, `message_text`, `message_ref`, `step`, `created`) VALUES
(277, 'message', '7506d60e6104427d935292e7c0175b98', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304699988, 'text', '6576824265358', '予約する', '', 1, '2017-08-21 08:38:02'),
(278, 'message', '7506d60e6104427d935292e7c0175b98', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304699988, 'text', '6576824265358', '予約する', '', 1, '2017-08-21 08:38:02'),
(279, 'message', 'a2085e56f0a54b01822f0f004b8ba1be', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304703866, 'text', '6576824546137', 'M', 'M', 2, '2017-08-21 08:38:06'),
(280, 'message', 'f407a14da71f45fcb62bd2888a46ab99', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304717326, 'text', '6576825527263', '08041320468', 'mobile: M, password: 08041320468', 3, '2017-08-21 08:38:21'),
(281, 'message', 'e59de80f6043416dbd65ca6297f5fd01', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304726059, 'text', '6576826160054', 'T新宿本店', '', 4, '2017-08-21 08:38:29'),
(282, 'message', '3ec9562ecca745e4a8937c150ec05787', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304734466, 'text', '6576826774925', 'T新宿本店', '', 1, '2017-08-21 08:38:37'),
(283, 'postback', 'f77b7f4c4b45458398c43e5f959585ec', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304734468, NULL, NULL, NULL, NULL, 5, '2017-08-21 08:38:37'),
(284, 'message', '856bf178d5f14db894effefa1ef39fea', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304777397, 'text', '6576829896663', 'T新宿マルイ', '', 6, '2017-08-21 08:39:21'),
(285, 'message', '6baf0c477b8946e181a1b466d734634b', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304787067, 'text', '6576830602658', '福本', '', 7, '2017-08-21 08:39:30'),
(286, 'postback', '897b7d179b8c4682a736dec8c540e391', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304791023, NULL, NULL, NULL, '', 8, '2017-08-21 08:39:33'),
(287, 'message', 'eb63307f7678490b8464541b06635f26', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304791021, 'text', '6576830886809', '福本', '', 9, '2017-08-21 08:39:34'),
(288, 'message', '3cc5b11ab82b44958883114ba69f931b', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304802605, 'text', '6576831733541', 'ハーモニック 80', '', 10, '2017-08-21 08:39:45'),
(289, 'postback', 'e7c3c76d4a124e3b8db418ce1c3b6c0e', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304806455, NULL, NULL, NULL, '', 11, '2017-08-21 08:39:48'),
(290, 'message', 'f68d5720d4df494fa9dd8115bc4a5c83', 'user', 'U1b3204f97941cef5de9bab6d572104e5', NULL, 1503304806453, 'text', '6576832018730', 'ハーモニック 80', '', 12, '2017-08-21 08:39:49');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `key_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `key_value` text CHARACTER SET utf8,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `key_name`, `key_value`, `created`) VALUES
(425, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"7506d60e6104427d935292e7c0175b98\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304699988,\"message\":{\"type\":\"text\",\"id\":\"6576824265358\",\"text\":\"予約する\"}}]}', '2017-08-21 08:38:02'),
(426, '{}', '{\"replyToken\":\"7506d60e6104427d935292e7c0175b98\",\"messages\":[{\"type\":\"text\",\"text\":\"\\u643a\\u5e2f\\u756a\\u53f7\\u3092\\u5165\\u529b\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002?\"},{\"type\":\"text\",\"text\":\"start\"}]}', '2017-08-21 08:38:03'),
(427, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"a2085e56f0a54b01822f0f004b8ba1be\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304703866,\"message\":{\"type\":\"text\",\"id\":\"6576824546137\",\"text\":\"M\"}}]}', '2017-08-21 08:38:06'),
(428, '{}', '{\"replyToken\":\"a2085e56f0a54b01822f0f004b8ba1be\",\"messages\":[{\"type\":\"text\",\"text\":\"\\u30d1\\u30b9\\u30ef\\u30fc\\u30c9\\u3092\\u5165\\u529b\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002?\"},{\"type\":\"text\",\"text\":\"step 1\"}]}', '2017-08-21 08:38:06'),
(429, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"f407a14da71f45fcb62bd2888a46ab99\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304717326,\"message\":{\"type\":\"text\",\"id\":\"6576825527263\",\"text\":\"08041320468\"}}]}', '2017-08-21 08:38:19'),
(430, '{}', '{\"replyToken\":\"f407a14da71f45fcb62bd2888a46ab99\",\"messages\":[{\"type\":\"text\",\"text\":\"\\u5e97\\u8217\\u3092\\u5165\\u529b\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002\"},{\"type\":\"text\",\"text\":\"\\n\\nT\\u30b3\\u30ec\\u30c3\\u30c8\\u30de\\u30fc\\u30ec\\n\\nT\\u65b0\\u5bbf\\u672c\\u5e97\\n\\nT\\u30d7\\u30e9\\u30f3\\u30bf\\u30f3\\u9280\\u5ea7\\n\\nT\\u5317\\u5343\\u4f4f\\u30de\\u30eb\\u30a4\\n\\nT\\u30d4\\u30a8\\u30b9\\u6e0b\\u8c37\\n\\nT\\u65b0\\u5bbf\\u30de\\u30eb\\u30a4\\n\\nT\\u516d\\u672c\\u6728\\n\\nT\\u5357\\u9752\\u5c71(\\u4e88\\u7d04\\u4e0d\\u53ef)\\n\\n\"}]}', '2017-08-21 08:38:21'),
(431, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"e59de80f6043416dbd65ca6297f5fd01\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304726059,\"message\":{\"type\":\"text\",\"id\":\"6576826160054\",\"text\":\"T新宿本店\"}}]}', '2017-08-21 08:38:28'),
(432, '{}', '{\"replyToken\":\"e59de80f6043416dbd65ca6297f5fd01\",\"messages\":[{\"type\":\"template\",\"altText\":\"\\u5e97\\u8217\\u3092\\u5165\\u529b\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002\",\"template\":{\"type\":\"buttons\",\"title\":\"\\u5e97\\u8217\",\"text\":\"\\u9078\\u629e\\u3057\\u3066\\u306d\",\"actions\":[{\"type\":\"postback\",\"label\":\"T\\u65b0\\u5bbf\\u672c\\u5e97\",\"data\":\"key=store&value=9\",\"text\":\"T\\u65b0\\u5bbf\\u672c\\u5e97\"}]}}]}', '2017-08-21 08:38:29'),
(433, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"3ec9562ecca745e4a8937c150ec05787\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304734466,\"message\":{\"type\":\"text\",\"id\":\"6576826774925\",\"text\":\"T新宿本店\"}}]}', '2017-08-21 08:38:37'),
(434, '{\"message\":\"The request body has 1 error(s)\",\"deta', '{\"replyToken\":\"3ec9562ecca745e4a8937c150ec05787\",\"messages\":null}', '2017-08-21 08:38:37'),
(435, 'jsonString', '{\"events\":[{\"type\":\"postback\",\"replyToken\":\"f77b7f4c4b45458398c43e5f959585ec\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304734468,\"postback\":{\"data\":\"key=store&value=9\"}}]}', '2017-08-21 08:38:37'),
(436, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"856bf178d5f14db894effefa1ef39fea\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304777397,\"message\":{\"type\":\"text\",\"id\":\"6576829896663\",\"text\":\"T新宿マルイ\"}}]}', '2017-08-21 08:39:20'),
(437, '{}', '{\"replyToken\":\"856bf178d5f14db894effefa1ef39fea\",\"messages\":[{\"type\":\"text\",\"text\":\"\\u62c5\\u5f53\\u8005\\u3092\\u5165\\u529b\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002\"},{\"type\":\"text\",\"text\":\"\\u4f50\\u85e4\\n\\u5ddd\\u53e3\\n\\u7b52\\u4e95\\n\\u5c0f\\u5742\\n\\u6a4b\\u672c\\n\\u77f3\\u4e95\\n\\u9234\\u6728\\n\\u798f\\u672c\\n\\u9ad8\\u6a4b\\n\\u5927\\u5cf6\"}]}', '2017-08-21 08:39:21'),
(438, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"6baf0c477b8946e181a1b466d734634b\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304787067,\"message\":{\"type\":\"text\",\"id\":\"6576830602658\",\"text\":\"福本\"}}]}', '2017-08-21 08:39:29'),
(439, '{}', '{\"replyToken\":\"6baf0c477b8946e181a1b466d734634b\",\"messages\":[{\"type\":\"template\",\"altText\":\"\\u62c5\\u5f53\\u8005\\u3092\\u5165\\u529b\\u3057\\u3066\\u304f\\u3060\\u3055\\u3044\\u3002\",\"template\":{\"type\":\"buttons\",\"title\":\"\\u62c5\\u5f53\\u8005\",\"text\":\"\\u9078\\u629e\\u3057\\u3066\\u306d\",\"actions\":[{\"type\":\"postback\",\"label\":\"\\u798f\\u672c\",\"data\":\"key=staff&value=194\",\"text\":\"\\u798f\\u672c\"}]}}]}', '2017-08-21 08:39:31'),
(440, 'jsonString', '{\"events\":[{\"type\":\"postback\",\"replyToken\":\"897b7d179b8c4682a736dec8c540e391\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304791023,\"postback\":{\"data\":\"key=staff&value=194\"}}]}', '2017-08-21 08:39:33'),
(441, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"eb63307f7678490b8464541b06635f26\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304791021,\"message\":{\"type\":\"text\",\"id\":\"6576830886809\",\"text\":\"福本\"}}]}', '2017-08-21 08:39:33'),
(442, '{}', '{\"replyToken\":\"eb63307f7678490b8464541b06635f26\",\"messages\":[{\"type\":\"text\",\"text\":\"\\u65bd\\u8853\\u4e00\\u89a7\\u304b\\u3089\\u30bf\\u30c3\\u30d7\"},{\"type\":\"text\",\"text\":\"BRK\\n\\u30ea\\u30da\\u30a2\\n\\u4e0b\\u307e\\u3064\\u6bdb\\nEX40\\nEX50\\nEX60\\nEX80\\nEX90\\nEX100\\n\\u304a\\u8a66\\u3057Ex\\n\\u30aa\\u30d5\\u306e\\u307f(\\u5f53\\u5e97)\\n\\u30aa\\u30d5\\u306e\\u307f(\\u4ed6\\u5e97)\\n\\u30b3\\u30eb\\u30c6\\n\\u4e0b\\u307e\\u3064\\u6bdb\\u306e\\u307f\\n\\u30ea\\u30da\\u30a2+\\u4e0b\\nEx40+\\u4e0b\\nEx50+\\u4e0b\\nEx60+\\u4e0b\\nEx70+\\u4e0b\\nEx80+\\u4e0b\\nEx90+\\u4e0b\\nEx100+\\u4e0b\\n\\u65b0\\u898fEX40\\n\\u65b0\\u898fEX60\\n\\u65b0\\u898fEX80\\n\\u65b0\\u898fEX40+\\u4e0b\\n\\u65b0\\u898fEX60+\\u4e0b\\n\\u65b0\\u898fEX80+\\u4e0b\\n\\u30cf\\u30fc\\u30e2\\u30cb\\u30c3\\u30af 60\\n\\u30cf\\u30fc\\u30e2\\u30cb\\u30c3\\u30af 80\\n\\u798f\\u888b\\u300040\\n\\u7269\\u8ca9\\u306e\\u307f\\n\\u4fdd\\u969c\\nIDL\\n\\u58f2\\u4e0a\\u4fee\\u6b63\\n\\u30d5\\u30a1\\u30b9\\u30c6\\u30c3\\u30d7\\u30b9\\u793e\\u5272\\n\\u30d7\\u30ec\\u30bc\\u30f3\\u30c8(10\\u00d710)\"}]}', '2017-08-21 08:39:35'),
(443, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"3cc5b11ab82b44958883114ba69f931b\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304802605,\"message\":{\"type\":\"text\",\"id\":\"6576831733541\",\"text\":\"ハーモニック 80\"}}]}', '2017-08-21 08:39:45'),
(444, '{}', '{\"replyToken\":\"3cc5b11ab82b44958883114ba69f931b\",\"messages\":[{\"type\":\"template\",\"altText\":\"\\u65bd\\u8853\\u4e00\\u89a7\\u304b\\u3089\\u30bf\\u30c3\\u30d7\",\"template\":{\"type\":\"buttons\",\"title\":\"\\u62c5\\u5f53\\u8005\",\"text\":\"\\u9078\\u629e\\u3057\\u3066\\u306d\",\"actions\":[{\"type\":\"postback\",\"label\":\"\\u30cf\\u30fc\\u30e2\\u30cb\\u30c3\\u30af 80\",\"data\":\"key=treatment&value=61\",\"text\":\"\\u30cf\\u30fc\\u30e2\\u30cb\\u30c3\\u30af 80\"}]}}]}', '2017-08-21 08:39:46'),
(445, 'jsonString', '{\"events\":[{\"type\":\"postback\",\"replyToken\":\"e7c3c76d4a124e3b8db418ce1c3b6c0e\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304806455,\"postback\":{\"data\":\"key=treatment&value=61\"}}]}', '2017-08-21 08:39:48'),
(446, 'jsonString', '{\"events\":[{\"type\":\"message\",\"replyToken\":\"f68d5720d4df494fa9dd8115bc4a5c83\",\"source\":{\"userId\":\"U1b3204f97941cef5de9bab6d572104e5\",\"type\":\"user\"},\"timestamp\":1503304806453,\"message\":{\"type\":\"text\",\"id\":\"6576832018730\",\"text\":\"ハーモニック 80\"}}]}', '2017-08-21 08:39:49'),
(447, '{}', '{\"replyToken\":\"f68d5720d4df494fa9dd8115bc4a5c83\",\"messages\":[{\"type\":\"text\",\"text\":\"\\u30bb\\u30c3\\u30c8\\u30e1\\u30cb\\u30e5\\u30fc\\u4e00\\u89a7\\u304b\\u3089\\u30bf\\u30c3\\u30d7\"},{\"type\":\"text\",\"text\":\"\\u4e8b\\u524d\\n\\u4e0b\\u307e\\u3064\\u6bdb\\uff08\\u30ea\\u30da\\u30a2\\uff09\\n\\u30b3\\u30eb\\u30c6\\u30c3\\u30af\\u30b9\\u30c8\\u30ea\\u30fc\\u30c8\\u30e1\\u30f3\\u30c8\\n\\u5f53\\u5e97\\u30aa\\u30d5\\n\\u4ed6\\u5e97\\u30aa\\u30d5\\n\\u30ab\\u30e9\\u30fc\\u30df\\u30c3\\u30af\\u30b9\\n\\u5f53\\u5e97\\u30aa\\u30d5\\u7121\\u6599\\n\\u4ed6\\u5e97\\u30aa\\u30d5\\u7121\\u6599\\n\\u5f53\\u5e97\\u30aa\\u30d5\\u534a\\u984d\\n\\u4ed6\\u5e97\\u30aa\\u30d5\\u534a\\u984d\\n\\u4ed6\\u5e97\\u30aa\\u30d51000\\u5186\\n\\u4e0b\\u307e\\u3064\\u6bdb\\u30aa\\u30d5\\n\\u30b9\\u30c8\\u30fc\\u30f3(3\\u500b)\\n\\u30b9\\u30c8\\u30fc\\u30f3(1\\u500b)\\n\\u30e9\\u30e1\\u30a8\\u30af\\u30b9\\u30c6(1\\u672c)\\n\\u30b3\\u30eb\\u30c6\\u30c3\\u30af\\u30b9\\u30c8\\u30ea\\u30fc\\u30c8\\u30e1\\u30f3\\u30c8\\u534a\\u984d\\n\\u304f\\u3058 (10x10)\\n\\u30ad\\u30e3\\u30f3\\u30da\\u30fc\\u30f3 (5x5)\"}]}', '2017-08-21 08:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE `order_info` (
  `id` int(11) NOT NULL,
  `source_user_id` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `treatment_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `store_name` varchar(50) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `step` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`id`, `source_user_id`, `username`, `password`, `store_id`, `treatment_id`, `menu_id`, `store_name`, `staff_id`, `staff_name`, `step`, `status`, `created`, `updated`) VALUES
(10, 'U1b3204f97941cef5de9bab6d572104e5', 'M', '08041320468', 9, 9, 9, NULL, NULL, NULL, 12, 1, '2017-08-21 08:38:20', '2017-08-21 08:38:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_log`
--
ALTER TABLE `chat_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_info`
--
ALTER TABLE `order_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_log`
--
ALTER TABLE `chat_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=448;
--
-- AUTO_INCREMENT for table `order_info`
--
ALTER TABLE `order_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
