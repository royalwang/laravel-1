-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-10-31 03:10:12
-- 服务器版本： 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- 表的结构 `ad_accounts`
--

CREATE TABLE `ad_accounts` (
  `id` int(10) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `idkey` varchar(255) NOT NULL,
  `note` text,
  `binded` tinyint(1) DEFAULT '0',
  `code` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ad_accounts`
--

INSERT INTO `ad_accounts` (`id`, `money`, `username`, `password`, `birthday`, `idkey`, `note`, `binded`, `code`, `created_at`, `updated_at`) VALUES
(1, '0.00', '1215616gasdfas', '156a1sdf155', '1231651651', '1ad51f6s51df', NULL, 1, 'asdfsd113', '2016-09-05 02:35:32', '2016-09-05 02:39:20'),
(2, '20.00', 'asdfadsf23r', '2341341', '2452111', '1651651615213615213', NULL, 1, 'adfsdf1123', '2016-09-09 02:09:51', '2016-09-09 02:09:51');

-- --------------------------------------------------------

--
-- 表的结构 `ad_binds`
--

CREATE TABLE `ad_binds` (
  `id` int(5) NOT NULL,
  `users_id` int(5) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `vps_id` int(5) NOT NULL,
  `sites_id` int(5) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `money` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ad_binds`
--

INSERT INTO `ad_binds` (`id`, `users_id`, `accounts_id`, `vps_id`, `sites_id`, `status`, `money`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '5300.00', '2016-09-05 02:39:48', '2016-09-05 02:47:28'),
(2, 1, 2, 4, 2, 0, '111.00', '2016-09-09 02:12:24', '2016-09-09 02:12:24');

--
-- 触发器 `ad_binds`
--
DELIMITER $$
CREATE TRIGGER `ad_binds_delete` BEFORE DELETE ON `ad_binds` FOR EACH ROW DELETE FROM ad_records WHERE ad_binds_id = old.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ad_on_bind` AFTER INSERT ON `ad_binds` FOR EACH ROW BEGIN
UPDATE ad_accounts set `binded` = 1 WHERE id= new.accounts_id;
UPDATE ad_vps set `binded` = 1 WHERE id= new.vps_id;
UPDATE sites set `binded` = 1 WHERE id= new.sites_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ad_un_bind` AFTER UPDATE ON `ad_binds` FOR EACH ROW if new.status = -1 then
	UPDATE ad_vps set `binded` = 0 where id = new.vps_id;
end if
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `ad_records`
--

CREATE TABLE `ad_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` int(32) NOT NULL,
  `cost` decimal(10,2) DEFAULT '0.00',
  `click_amount` int(15) DEFAULT '0',
  `orders_money` float NOT NULL DEFAULT '0',
  `orders_amount` int(10) NOT NULL DEFAULT '0',
  `recharge` decimal(10,2) DEFAULT '0.00',
  `ad_binds_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `ad_records`
--

INSERT INTO `ad_records` (`id`, `date`, `cost`, `click_amount`, `orders_money`, `orders_amount`, `recharge`, `ad_binds_id`) VALUES
(5, 1473264000, '50.00', 50, 50, 50, '50.00', 1),
(6, 1473177600, '40.00', 40, 40, 40, '40.00', 1),
(8, 1473177600, '12.00', 123, 123, 123, '123.00', 2),
(4, 1473004800, '500.00', 5000, 3000, 100, '999.00', 1),
(9, 1473350400, '22.00', 22, 22, 22, '22.00', 2),
(10, 1473264000, '222.00', 22, 222, 22, '222.00', 2),
(11, 1473091200, '49.00', 50, 49, 50, '50.00', 1),
(12, 1470153600, '50.00', 50, 50, 50, '50.00', 1),
(13, 1473350400, '20.00', 20, 20, 20, '20.00', 1),
(14, 1473436800, '10.00', 10, 10, 10, '10.00', 1),
(15, 1472918400, '100.00', 100, 100, 100, '100.00', 1),
(16, 1473696000, '200.00', 2000, 500, 10, '5000.00', 1);

--
-- 触发器 `ad_records`
--
DELIMITER $$
CREATE TRIGGER `ad_money_delete` BEFORE DELETE ON `ad_records` FOR EACH ROW update ad_binds set `money` = `money`-(old.recharge - old.cost) where `id` = old.ad_binds_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ad_money_insert` AFTER INSERT ON `ad_records` FOR EACH ROW update ad_binds set `money` = `money`+(new.recharge - new.cost) where `id` = new.ad_binds_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ad_money_update` AFTER UPDATE ON `ad_records` FOR EACH ROW update ad_binds set `money` = `money`+((new.recharge-old.recharge)- (new.cost-old.cost)) where `id` = new.ad_binds_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `ad_vps`
--

CREATE TABLE `ad_vps` (
  `id` int(10) NOT NULL,
  `users_id` int(5) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `binded` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `ad_vps`
--

INSERT INTO `ad_vps` (`id`, `users_id`, `username`, `password`, `ip`, `binded`, `status`) VALUES
(1, 1, 'testvps1', 'testvps1', '127.15.151.15', 1, 1),
(4, 1, '51sdf165a', '1651df1sdf', '132.54.89.41', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `banners`
--

CREATE TABLE `banners` (
  `id` int(4) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `banners`
--

INSERT INTO `banners` (`id`, `name`) VALUES
(7, 'mk2'),
(4, 'mk'),
(5, 'coach');

--
-- 触发器 `banners`
--
DELIMITER $$
CREATE TRIGGER `banners_delete` AFTER DELETE ON `banners` FOR EACH ROW UPDATE sites SET banners_id = 0 WHERE banners_id = old.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `express`
--

CREATE TABLE `express` (
  `id` int(10) NOT NULL,
  `code` int(20) NOT NULL,
  `express_type_id` int(5) NOT NULL,
  `name` varchar(48) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `express_business`
--

CREATE TABLE `express_business` (
  `id` int(5) NOT NULL,
  `name` varchar(10) NOT NULL,
  `telephone` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `express_business`
--

INSERT INTO `express_business` (`id`, `name`, `telephone`) VALUES
(1, '小吴的快递', '');

-- --------------------------------------------------------

--
-- 表的结构 `express_type`
--

CREATE TABLE `express_type` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `express_type`
--

INSERT INTO `express_type` (`id`, `name`) VALUES
(1, 'DHL'),
(2, 'EMS快递'),
(3, '邮政小包');

-- --------------------------------------------------------

--
-- 表的结构 `money_accounts`
--

CREATE TABLE `money_accounts` (
  `id` int(3) NOT NULL,
  `name` varchar(128) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `note` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `money_accounts`
--

INSERT INTO `money_accounts` (`id`, `name`, `money`, `note`) VALUES
(1, '我的账户1', '720.00', '管理账户4'),
(35, '222', '104.00', 'sdfs1'),
(22, 'bbbb', '80.00', '1234'),
(24, 'dddd', '120.00', 'dddd');

--
-- 触发器 `money_accounts`
--
DELIMITER $$
CREATE TRIGGER `money_accounts_delete` AFTER DELETE ON `money_accounts` FOR EACH ROW DELETE FROM `money_records` where money_accounts_id = old.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `money_records`
--

CREATE TABLE `money_records` (
  `id` int(15) NOT NULL,
  `money_accounts_id` int(3) NOT NULL,
  `money_type_id` int(3) DEFAULT NULL,
  `value` decimal(10,2) NOT NULL,
  `note` text NOT NULL,
  `date` date NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `money_records`
--

INSERT INTO `money_records` (`id`, `money_accounts_id`, `money_type_id`, `value`, `note`, `date`, `updated_at`, `created_at`) VALUES
(1, 1, 3, '50.00', '还欠40', '2016-09-22', '2016-09-22 09:47:19', '2016-09-22 09:47:19'),
(2, 22, 1, '10.00', '账号我的账户1转入', '2016-09-22', '2016-09-22 09:47:47', '2016-09-22 09:47:47'),
(3, 1, 2, '-10.00', '转入账号bbb', '2016-09-22', '2016-09-22 09:47:47', '2016-09-22 09:47:47'),
(4, 1, 4, '-20.00', '这是备注测试', '2016-09-23', '2016-09-22 16:05:33', '2016-09-22 09:48:41'),
(5, 35, 5, '40.00', '外快赚钱了', '2016-09-01', '2016-09-22 09:52:03', '2016-09-22 09:52:03'),
(6, 22, 5, '10.00', '', '2016-09-22', '2016-09-22 09:56:00', '2016-09-22 09:56:00'),
(7, 35, 6, '-14.00', '这是备注测试2', '2016-09-09', '2016-09-22 16:34:22', '2016-09-22 10:02:54'),
(8, 1, 5, '20.00', '又来外快了', '2016-09-21', '2016-09-23 13:42:53', '2016-09-22 16:51:21'),
(9, 24, 5, '50.00', '第一次外快', '2016-09-22', '2016-09-22 16:52:12', '2016-09-22 16:52:12'),
(10, 24, 5, '70.00', '第一次外快', '2016-09-19', '2016-09-23 13:42:36', '2016-09-22 16:52:27'),
(11, 1, 4, '-20.00', '又 要还钱了', '2016-09-24', '2016-09-22 16:52:58', '2016-09-22 16:52:58'),
(12, 1, 1, '50.00', '账号dddd转入', '2016-09-20', '2016-09-22 16:53:22', '2016-09-22 16:53:22'),
(13, 24, 2, '-50.00', '转入账号我的账户1', '2016-09-20', '2016-09-22 16:53:22', '2016-09-22 16:53:22'),
(14, 24, 5, '50.00', '第一次外快', '2016-08-02', '2016-09-22 16:55:00', '2016-09-22 16:55:00'),
(15, 1, 3, '10.00', '', '2016-08-29', '2016-09-22 17:10:28', '2016-09-22 17:10:28'),
(16, 1, 3, '10.00', '', '2016-10-09', '2016-09-22 17:10:57', '2016-09-22 17:10:57'),
(17, 22, NULL, '20.00', '账户金额变更', '0000-00-00', '2016-09-23 15:53:55', '2016-09-23 15:53:55'),
(18, 1, NULL, '90.00', '账户金额变更', '0000-00-00', '2016-09-26 16:21:10', '2016-09-26 16:21:10'),
(19, 35, NULL, '26.00', '账户金额变更', '0000-00-00', '2016-09-26 16:21:30', '2016-09-26 16:21:30'),
(20, 1, NULL, '180.00', '账户金额变更', '0000-00-00', '2016-09-26 16:25:02', '2016-09-26 16:25:02'),
(21, 1, NULL, '360.00', '账户金额变更', '0000-00-00', '2016-09-26 16:25:49', '2016-09-26 16:25:49'),
(22, 22, NULL, '40.00', '账户金额变更', '0000-00-00', '2016-09-26 16:26:21', '2016-09-26 16:26:21'),
(23, 35, NULL, '52.00', '账户金额变更', '0000-00-00', '2016-09-26 16:28:32', '2016-09-26 16:28:32');

--
-- 触发器 `money_records`
--
DELIMITER $$
CREATE TRIGGER `money_records_delete` AFTER DELETE ON `money_records` FOR EACH ROW update `money_accounts` set `money` = `money`  - old.value where id = old.money_accounts_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `money_records_insert` AFTER INSERT ON `money_records` FOR EACH ROW update `money_accounts` set `money` = `money` + new.value where id = new.money_accounts_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `money_records_update` AFTER UPDATE ON `money_records` FOR EACH ROW update `money_accounts` set `money` = `money` + (new.value - old.value) where id = new.money_accounts_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `money_type`
--

CREATE TABLE `money_type` (
  `id` int(5) NOT NULL,
  `name` varchar(64) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `money_type`
--

INSERT INTO `money_type` (`id`, `name`, `parent_id`) VALUES
(1, '转入', 0),
(2, '转出', 0),
(3, '我的工资1', 1),
(4, '房贷', 2),
(5, '我的外快1', 1),
(6, '车贷款', 2);

--
-- 触发器 `money_type`
--
DELIMITER $$
CREATE TRIGGER `money_type_delete` AFTER DELETE ON `money_type` FOR EACH ROW UPDATE `money_records` set money_records_id = old.parent_id,note = note+ '类型已删除'
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `pay_id` varchar(64) NOT NULL,
  `order_id` int(11) NOT NULL,
  `sites_id` int(10) NOT NULL,
  `pay_info` text NOT NULL,
  `site_info` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `trade_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `pay_id`, `order_id`, `sites_id`, `pay_info`, `site_info`, `email`, `trade_date`) VALUES
(1, 'YKF1608300008077740', 4, 10, 'a:12:{s:6:"pay_id";s:19:"YKF1608300008077740";s:8:"order_id";s:1:"4";s:8:"currency";s:3:"MYR";s:5:"money";s:6:"341.64";s:9:"card_type";s:6:"master";s:10:"trade_date";s:9:"2016/8/30";s:8:"batch_id";s:8:"1.61E+17";s:4:"host";s:18:"127.0.0.1/zencart3";s:9:"card_name";s:10:"Joyce Khor";s:9:"telephone";s:9:"122287860";s:9:"post_code";s:5:"52100";s:10:"card_email";s:20:"me.n.i83@hotmail.com";}', 'a:55:{s:9:"orders_id";s:1:"4";s:12:"customers_id";s:1:"2";s:14:"customers_name";s:14:"sadfsf asdfsdf";s:17:"customers_company";s:0:"";s:24:"customers_street_address";s:7:"asdfsdf";s:16:"customers_suburb";s:7:"asdfsdf";s:14:"customers_city";s:7:"asdfsdf";s:18:"customers_postcode";s:7:"asdfsdf";s:15:"customers_state";s:9:" asdfsdf";s:17:"customers_country";s:14:"American Samoa";s:19:"customers_telephone";s:9:"524545454";s:23:"customers_email_address";s:16:"595856668@qq.com";s:27:"customers_address_format_id";s:1:"1";s:13:"delivery_name";s:14:"sadfsf asdfsdf";s:16:"delivery_company";s:0:"";s:23:"delivery_street_address";s:7:"asdfsdf";s:15:"delivery_suburb";s:7:"asdfsdf";s:13:"delivery_city";s:7:"asdfsdf";s:17:"delivery_postcode";s:7:"asdfsdf";s:14:"delivery_state";s:9:" asdfsdf";s:16:"delivery_country";s:14:"American Samoa";s:26:"delivery_address_format_id";s:1:"1";s:12:"billing_name";s:14:"sadfsf asdfsdf";s:15:"billing_company";s:0:"";s:22:"billing_street_address";s:7:"asdfsdf";s:14:"billing_suburb";s:7:"asdfsdf";s:12:"billing_city";s:7:"asdfsdf";s:16:"billing_postcode";s:7:"asdfsdf";s:13:"billing_state";s:9:" asdfsdf";s:15:"billing_country";s:14:"American Samoa";s:25:"billing_address_format_id";s:1:"1";s:14:"payment_method";s:11:"Credit Card";s:19:"payment_module_code";s:10:"Fristonecc";s:15:"shipping_method";s:37:"Free Shipping Options (Fast Shipping)";s:20:"shipping_module_code";s:11:"freeoptions";s:11:"coupon_code";s:0:"";s:7:"cc_type";s:0:"";s:8:"cc_owner";s:0:"";s:9:"cc_number";s:0:"";s:10:"cc_expires";s:0:"";s:6:"cc_cvv";N;s:13:"last_modified";N;s:14:"date_purchased";s:19:"2016-04-13 02:17:26";s:13:"orders_status";s:3:"519";s:20:"orders_date_finished";N;s:8:"currency";s:3:"CAD";s:14:"currency_value";s:8:"1.409415";s:11:"order_total";s:5:"83.90";s:9:"order_tax";s:4:"0.00";s:13:"paypal_ipn_id";s:1:"0";s:10:"ip_address";s:31:"112.111.185.21 - 112.111.185.21";s:8:"dropdown";N;s:12:"gift_message";N;s:8:"checkbox";N;s:11:"COWOA_order";s:1:"0";}', 'me.n.i83@hotmail.com', '2016-08-30'),
(2, 'YKF1608300003530383', 20, 10, 'a:12:{s:6:"pay_id";s:19:"YKF1608300003530383";s:8:"order_id";s:2:"20";s:8:"currency";s:3:"USD";s:5:"money";s:3:"209";s:9:"card_type";s:4:"visa";s:10:"trade_date";s:9:"2016/8/30";s:8:"batch_id";s:8:"1.61E+17";s:4:"host";s:18:"127.0.0.1/zencart3";s:9:"card_name";s:9:"Rehab Suh";s:9:"telephone";s:8:"9.67E+11";s:9:"post_code";s:5:"31411";s:10:"card_email";s:19:"Rehab.suh@gmail.com";}', 'a:55:{s:9:"orders_id";s:2:"20";s:12:"customers_id";s:2:"17";s:14:"customers_name";s:11:"Jane Gamble";s:17:"customers_company";s:0:"";s:24:"customers_street_address";s:29:"335/7 Defries avenue, Zetland";s:16:"customers_suburb";s:0:"";s:14:"customers_city";s:6:"Sydney";s:18:"customers_postcode";s:4:"2017";s:15:"customers_state";s:3:"NSW";s:17:"customers_country";s:9:"Australia";s:19:"customers_telephone";s:10:"0402751763";s:23:"customers_email_address";s:24:"Jane_setiadi@hotmail.com";s:27:"customers_address_format_id";s:1:"1";s:13:"delivery_name";s:11:"Jane Gamble";s:16:"delivery_company";s:0:"";s:23:"delivery_street_address";s:29:"335/7 Defries avenue, Zetland";s:15:"delivery_suburb";s:0:"";s:13:"delivery_city";s:6:"Sydney";s:17:"delivery_postcode";s:4:"2017";s:14:"delivery_state";s:3:"NSW";s:16:"delivery_country";s:9:"Australia";s:26:"delivery_address_format_id";s:1:"1";s:12:"billing_name";s:11:"Jane Gamble";s:15:"billing_company";s:0:"";s:22:"billing_street_address";s:29:"335/7 Defries avenue, Zetland";s:14:"billing_suburb";s:0:"";s:12:"billing_city";s:6:"Sydney";s:16:"billing_postcode";s:4:"2017";s:13:"billing_state";s:3:"NSW";s:15:"billing_country";s:9:"Australia";s:25:"billing_address_format_id";s:1:"1";s:14:"payment_method";s:11:"Credit Card";s:19:"payment_module_code";s:10:"Fristonecc";s:15:"shipping_method";s:37:"Free Shipping Options (Fast Shipping)";s:20:"shipping_module_code";s:11:"freeoptions";s:11:"coupon_code";s:0:"";s:7:"cc_type";s:0:"";s:8:"cc_owner";s:0:"";s:9:"cc_number";s:0:"";s:10:"cc_expires";s:0:"";s:6:"cc_cvv";N;s:13:"last_modified";N;s:14:"date_purchased";s:19:"2016-06-07 14:48:46";s:13:"orders_status";s:3:"518";s:20:"orders_date_finished";N;s:8:"currency";s:3:"AUD";s:14:"currency_value";s:8:"1.480815";s:11:"order_total";s:6:"149.00";s:9:"order_tax";s:4:"0.00";s:13:"paypal_ipn_id";s:1:"0";s:10:"ip_address";s:29:"123.51.69.203 - 123.51.69.203";s:8:"dropdown";N;s:12:"gift_message";N;s:8:"checkbox";N;s:11:"COWOA_order";s:1:"0";}', 'Rehab.suh@gmail.com', '2016-08-30'),
(3, 'YKF1608300020285855', 24, 10, 'a:12:{s:6:"pay_id";s:19:"YKF1608300020285855";s:8:"order_id";s:2:"24";s:8:"currency";s:3:"USD";s:5:"money";s:3:"229";s:9:"card_type";s:4:"visa";s:10:"trade_date";s:9:"2016/8/30";s:8:"batch_id";s:8:"1.61E+17";s:4:"host";s:18:"127.0.0.1/zencart3";s:9:"card_name";s:11:"noura saeed";s:9:"telephone";s:9:"509392913";s:9:"post_code";s:5:"29115";s:10:"card_email";s:20:"nora@boundary.gov.ae";}', 'a:55:{s:9:"orders_id";s:2:"24";s:12:"customers_id";s:2:"22";s:14:"customers_name";s:11:"Sharon Naes";s:17:"customers_company";s:0:"";s:24:"customers_street_address";s:21:"1054 s hwy 47 apt 108";s:16:"customers_suburb";s:0:"";s:14:"customers_city";s:9:"Warrenton";s:18:"customers_postcode";s:5:"63383";s:15:"customers_state";s:8:"Missouri";s:17:"customers_country";s:13:"United States";s:19:"customers_telephone";s:10:"6364876449";s:23:"customers_email_address";s:22:"sharonsammie2015@gmail";s:27:"customers_address_format_id";s:1:"2";s:13:"delivery_name";s:11:"Sharon Naes";s:16:"delivery_company";s:0:"";s:23:"delivery_street_address";s:21:"1054 s hwy 47 apt 108";s:15:"delivery_suburb";s:0:"";s:13:"delivery_city";s:9:"Warrenton";s:17:"delivery_postcode";s:5:"63383";s:14:"delivery_state";s:8:"Missouri";s:16:"delivery_country";s:13:"United States";s:26:"delivery_address_format_id";s:1:"2";s:12:"billing_name";s:11:"Sharon Naes";s:15:"billing_company";s:0:"";s:22:"billing_street_address";s:21:"1054 s hwy 47 apt 108";s:14:"billing_suburb";s:0:"";s:12:"billing_city";s:9:"Warrenton";s:16:"billing_postcode";s:5:"63383";s:13:"billing_state";s:8:"Missouri";s:15:"billing_country";s:13:"United States";s:25:"billing_address_format_id";s:1:"2";s:14:"payment_method";s:11:"Credit Card";s:19:"payment_module_code";s:10:"Fristonecc";s:15:"shipping_method";s:37:"Free Shipping Options (Fast Shipping)";s:20:"shipping_module_code";s:11:"freeoptions";s:11:"coupon_code";s:0:"";s:7:"cc_type";s:0:"";s:8:"cc_owner";s:0:"";s:9:"cc_number";s:0:"";s:10:"cc_expires";s:0:"";s:6:"cc_cvv";N;s:13:"last_modified";N;s:14:"date_purchased";s:19:"2016-06-08 02:31:02";s:13:"orders_status";s:3:"519";s:20:"orders_date_finished";N;s:8:"currency";s:3:"USD";s:14:"currency_value";s:8:"1.000000";s:11:"order_total";s:5:"80.00";s:9:"order_tax";s:4:"0.00";s:13:"paypal_ipn_id";s:1:"0";s:10:"ip_address";s:31:"68.189.193.104 - 68.189.193.104";s:8:"dropdown";N;s:12:"gift_message";N;s:8:"checkbox";N;s:11:"COWOA_order";s:1:"0";}', 'nora@boundary.gov.ae', '2016-08-30'),
(4, 'YKF1608300012517214', 115, 10, 'a:12:{s:6:"pay_id";s:19:"YKF1608300012517214";s:8:"order_id";s:3:"115";s:8:"currency";s:3:"USD";s:5:"money";s:5:"55.47";s:9:"card_type";s:4:"visa";s:10:"trade_date";s:9:"2016/8/30";s:8:"batch_id";s:8:"1.61E+17";s:4:"host";s:18:"127.0.0.1/zencart3";s:9:"card_name";s:15:"chahrazed zaoui";s:9:"telephone";s:10:"2025175990";s:9:"post_code";s:5:"22311";s:10:"card_email";s:25:"zaoui.chahrazed@gmail.com";}', 'a:55:{s:9:"orders_id";s:3:"115";s:12:"customers_id";s:2:"91";s:14:"customers_name";s:13:"Nancy cherrez";s:17:"customers_company";s:0:"";s:24:"customers_street_address";s:23:"314. East. 141. Street.";s:16:"customers_suburb";s:0:"";s:14:"customers_city";s:8:"New York";s:18:"customers_postcode";s:5:"10454";s:15:"customers_state";s:8:"New York";s:17:"customers_country";s:13:"United States";s:19:"customers_telephone";s:10:"3476847274";s:23:"customers_email_address";s:23:"nancy_tysha@hotmail.com";s:27:"customers_address_format_id";s:1:"2";s:13:"delivery_name";s:13:"Nancy cherrez";s:16:"delivery_company";s:0:"";s:23:"delivery_street_address";s:23:"314. East. 141. Street.";s:15:"delivery_suburb";s:0:"";s:13:"delivery_city";s:8:"New York";s:17:"delivery_postcode";s:5:"10454";s:14:"delivery_state";s:8:"New York";s:16:"delivery_country";s:13:"United States";s:26:"delivery_address_format_id";s:1:"2";s:12:"billing_name";s:13:"Keyla Laborde";s:15:"billing_company";s:0:"";s:22:"billing_street_address";s:23:"314. East. 141. Street.";s:14:"billing_suburb";s:0:"";s:12:"billing_city";s:5:"Bronx";s:16:"billing_postcode";s:5:"10454";s:13:"billing_state";s:8:"New York";s:15:"billing_country";s:13:"United States";s:25:"billing_address_format_id";s:1:"2";s:14:"payment_method";s:11:"Credit Card";s:19:"payment_module_code";s:10:"Fristonecc";s:15:"shipping_method";s:29:"Shipping Cost (Shipping Cost)";s:20:"shipping_module_code";s:11:"freeoptions";s:11:"coupon_code";s:0:"";s:7:"cc_type";s:0:"";s:8:"cc_owner";s:0:"";s:9:"cc_number";s:0:"";s:10:"cc_expires";s:0:"";s:6:"cc_cvv";N;s:13:"last_modified";N;s:14:"date_purchased";s:19:"2016-07-02 12:12:00";s:13:"orders_status";s:3:"518";s:20:"orders_date_finished";N;s:8:"currency";s:3:"USD";s:14:"currency_value";s:8:"1.000000";s:11:"order_total";s:6:"129.72";s:9:"order_tax";s:4:"0.00";s:13:"paypal_ipn_id";s:1:"0";s:10:"ip_address";s:29:"200.7.247.110 - 200.7.247.110";s:8:"dropdown";N;s:12:"gift_message";N;s:8:"checkbox";N;s:11:"COWOA_order";s:1:"0";}', 'zaoui.chahrazed@gmail.com', '2016-08-30'),
(5, 'YKF1608300029352561', 120, 10, 'a:12:{s:6:"pay_id";s:19:"YKF1608300029352561";s:8:"order_id";s:3:"120";s:8:"currency";s:3:"USD";s:5:"money";s:5:"41.98";s:9:"card_type";s:6:"master";s:10:"trade_date";s:9:"2016/8/30";s:8:"batch_id";s:8:"1.61E+17";s:4:"host";s:18:"127.0.0.1/zencart3";s:9:"card_name";s:10:"Susan Alba";s:9:"telephone";s:20:"+639177002522 or 082";s:9:"post_code";s:4:"8000";s:10:"card_email";s:20:"susancalba@yahoo.com";}', 'a:55:{s:9:"orders_id";s:3:"120";s:12:"customers_id";s:2:"95";s:14:"customers_name";s:13:"zied aissaoui";s:17:"customers_company";s:0:"";s:24:"customers_street_address";s:19:"ecole libre el amel";s:16:"customers_suburb";s:0:"";s:14:"customers_city";s:11:"sidi bouzid";s:18:"customers_postcode";s:4:"9100";s:15:"customers_state";s:11:"sidi bouzid";s:17:"customers_country";s:7:"Tunisia";s:19:"customers_telephone";s:13:"0021653430034";s:23:"customers_email_address";s:24:"aissaoui_zied@hotmail.fr";s:27:"customers_address_format_id";s:1:"1";s:13:"delivery_name";s:13:"zied aissaoui";s:16:"delivery_company";s:0:"";s:23:"delivery_street_address";s:19:"ecole libre el amel";s:15:"delivery_suburb";s:0:"";s:13:"delivery_city";s:11:"sidi bouzid";s:17:"delivery_postcode";s:4:"9100";s:14:"delivery_state";s:11:"sidi bouzid";s:16:"delivery_country";s:7:"Tunisia";s:26:"delivery_address_format_id";s:1:"1";s:12:"billing_name";s:13:"zied aissaoui";s:15:"billing_company";s:0:"";s:22:"billing_street_address";s:19:"ecole libre el amel";s:14:"billing_suburb";s:0:"";s:12:"billing_city";s:11:"sidi bouzid";s:16:"billing_postcode";s:4:"9100";s:13:"billing_state";s:11:"sidi bouzid";s:15:"billing_country";s:7:"Tunisia";s:25:"billing_address_format_id";s:1:"1";s:14:"payment_method";s:11:"Credit Card";s:19:"payment_module_code";s:10:"Fristonecc";s:15:"shipping_method";s:29:"Shipping Cost (Shipping Cost)";s:20:"shipping_module_code";s:11:"freeoptions";s:11:"coupon_code";s:0:"";s:7:"cc_type";s:0:"";s:8:"cc_owner";s:0:"";s:9:"cc_number";s:0:"";s:10:"cc_expires";s:0:"";s:6:"cc_cvv";N;s:13:"last_modified";N;s:14:"date_purchased";s:19:"2016-07-02 19:47:46";s:13:"orders_status";s:3:"519";s:20:"orders_date_finished";N;s:8:"currency";s:3:"USD";s:14:"currency_value";s:8:"1.000000";s:11:"order_total";s:5:"25.99";s:9:"order_tax";s:4:"0.00";s:13:"paypal_ipn_id";s:1:"0";s:10:"ip_address";s:31:"197.28.185.115 - 197.28.185.115";s:8:"dropdown";N;s:12:"gift_message";N;s:8:"checkbox";N;s:11:"COWOA_order";s:1:"0";}', 'susancalba@yahoo.com', '2016-08-30'),
(6, 'YKF1608300012549557', 137, 10, 'a:12:{s:6:"pay_id";s:19:"YKF1608300012549557";s:8:"order_id";s:3:"137";s:8:"currency";s:3:"EUR";s:5:"money";s:5:"39.98";s:9:"card_type";s:4:"visa";s:10:"trade_date";s:9:"2016/8/30";s:8:"batch_id";s:8:"1.61E+17";s:4:"host";s:18:"127.0.0.1/zencart3";s:9:"card_name";s:20:"Franco de paz Esther";s:9:"telephone";s:9:"697573015";s:9:"post_code";s:4:"8033";s:10:"card_email";s:22:"Estheraxel@hotmail.com";}', 'a:55:{s:9:"orders_id";s:3:"137";s:12:"customers_id";s:3:"110";s:14:"customers_name";s:13:"Goran Novakov";s:17:"customers_company";s:0:"";s:24:"customers_street_address";s:15:"Gunduliceva 104";s:16:"customers_suburb";s:0:"";s:14:"customers_city";s:13:"Backa Palanka";s:18:"customers_postcode";s:5:"21400";s:15:"customers_state";s:6:"Srbija";s:17:"customers_country";s:6:"Serbia";s:19:"customers_telephone";s:10:"0645992396";s:23:"customers_email_address";s:19:"Pegas92@hotmail.com";s:27:"customers_address_format_id";s:1:"1";s:13:"delivery_name";s:13:"Goran Novakov";s:16:"delivery_company";s:0:"";s:23:"delivery_street_address";s:15:"Gunduliceva 104";s:15:"delivery_suburb";s:0:"";s:13:"delivery_city";s:13:"Backa Palanka";s:17:"delivery_postcode";s:5:"21400";s:14:"delivery_state";s:6:"Srbija";s:16:"delivery_country";s:6:"Serbia";s:26:"delivery_address_format_id";s:1:"1";s:12:"billing_name";s:13:"Goran Novakov";s:15:"billing_company";s:0:"";s:22:"billing_street_address";s:15:"Gunduliceva 104";s:14:"billing_suburb";s:0:"";s:12:"billing_city";s:13:"Backa Palanka";s:16:"billing_postcode";s:5:"21400";s:13:"billing_state";s:6:"Srbija";s:15:"billing_country";s:6:"Serbia";s:25:"billing_address_format_id";s:1:"1";s:14:"payment_method";s:11:"Credit Card";s:19:"payment_module_code";s:10:"Fristonecc";s:15:"shipping_method";s:29:"Shipping Cost (Shipping Cost)";s:20:"shipping_module_code";s:11:"freeoptions";s:11:"coupon_code";s:0:"";s:7:"cc_type";s:0:"";s:8:"cc_owner";s:0:"";s:9:"cc_number";s:0:"";s:10:"cc_expires";s:0:"";s:6:"cc_cvv";N;s:13:"last_modified";N;s:14:"date_purchased";s:19:"2016-07-03 11:11:24";s:13:"orders_status";s:3:"518";s:20:"orders_date_finished";N;s:8:"currency";s:3:"USD";s:14:"currency_value";s:8:"1.000000";s:11:"order_total";s:5:"40.98";s:9:"order_tax";s:4:"0.00";s:13:"paypal_ipn_id";s:1:"0";s:10:"ip_address";s:27:"46.17.121.56 - 46.17.121.56";s:8:"dropdown";N;s:12:"gift_message";N;s:8:"checkbox";N;s:11:"COWOA_order";s:1:"0";}', 'Estheraxel@hotmail.com', '2016-08-30');

--
-- 触发器 `orders`
--
DELIMITER $$
CREATE TRIGGER `orders_insert` AFTER INSERT ON `orders` FOR EACH ROW INSERT `orders_to_type` (`orders_id`,`orders_type_id`) VALUES (new.id ,1)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(20) NOT NULL,
  `orders_id` int(10) NOT NULL,
  `products_name` varchar(255) NOT NULL,
  `products_image` varchar(255) DEFAULT NULL,
  `products_attribute` varchar(64) DEFAULT NULL,
  `products_quantity` int(10) NOT NULL DEFAULT '1',
  `express_id` int(20) DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `orders_products_type_id` int(3) NOT NULL DEFAULT '1',
  `supplier_id` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders_products`
--

INSERT INTO `orders_products` (`id`, `orders_id`, `products_name`, `products_image`, `products_attribute`, `products_quantity`, `express_id`, `locked`, `orders_products_type_id`, `supplier_id`) VALUES
(1, 1, 'Coach Outlet Turnlock Tote In Bicolor Crossgrain Leather', 'rb/RB107-1.png', NULL, 1, NULL, 1, 1, 0),
(2, 2, 'Prairie Satchel In Pebble Leather', NULL, NULL, 1, NULL, 1, 1, 0),
(3, 2, 'Nolita Satchel In Pebble Leather', NULL, NULL, 1, NULL, 1, 1, 0),
(4, 3, 'Prairie Satchel In Signature Canvas', NULL, NULL, 1, NULL, 1, 1, 0),
(5, 4, 'RB3183 Verde Clásica', 'rb/RB013-1.png', NULL, 1, NULL, 1, 1, 0),
(6, 4, 'AVIATOR CLASSIC Verde Clásica G-15', 'rb/RB055-1.jpg', NULL, 1, NULL, 1, 1, 0),
(7, 4, 'AVIATOR FLASH LENSES Azul Espejada', 'rb/RB111-1.png', NULL, 1, NULL, 1, 1, 0),
(8, 4, 'AVIATOR FLASH LENSES Violeta Espejada', 'rb/RB161-1.png', NULL, 1, NULL, 1, 1, 0),
(9, 4, 'AVIATOR FLASH LENSES GRADIENT Naranja Gradient Flash', 'rb/RB177.jpg', NULL, 1, NULL, 1, 1, 0),
(10, 4, 'AVIATOR FOLDING Verde Clásica G-15', 'rb/RB091-1.png', NULL, 1, NULL, 1, 1, 0),
(11, 4, 'AVIATOR CLASSIC Polarizadas Verde Clásica G-15', NULL, NULL, 1, NULL, 1, 1, 0),
(12, 4, 'AVIATOR CARBON FIBRE Polarizadas Verde Clásica G-15', NULL, NULL, 1, NULL, 1, 1, 0),
(13, 5, 'AVIATOR GRADIENT Marrón Degradada', 'rb/RB050.png', NULL, 1, NULL, 1, 1, 0),
(14, 6, 'JUSTIN CLASSIC Plata Degradada espejada', NULL, NULL, 1, NULL, 1, 1, 0),
(15, 6, 'NEW WAYFARER JUNIOR Rojo Espejada', NULL, NULL, 1, NULL, 1, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `orders_products_type`
--

CREATE TABLE `orders_products_type` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders_products_type`
--

INSERT INTO `orders_products_type` (`id`, `name`, `code`) VALUES
(1, '已付款', 'already-pay'),
(2, '订货', 'already-get'),
(3, '缺货', 'lack-goods'),
(4, '退款', 'back-money'),
(5, '换货', 'change-goods');

-- --------------------------------------------------------

--
-- 表的结构 `orders_to_type`
--

CREATE TABLE `orders_to_type` (
  `id` int(30) NOT NULL,
  `orders_id` int(10) NOT NULL,
  `orders_type_id` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders_to_type`
--

INSERT INTO `orders_to_type` (`id`, `orders_id`, `orders_type_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1);

-- --------------------------------------------------------

--
-- 表的结构 `orders_type`
--

CREATE TABLE `orders_type` (
  `id` int(4) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `orders_type`
--

INSERT INTO `orders_type` (`id`, `name`, `code`) VALUES
(1, '待处理', ''),
(2, '待发货', ''),
(3, '待确认', ''),
(4, '待退款', ''),
(5, '已发货', ''),
(6, '已退款', '');

-- --------------------------------------------------------

--
-- 表的结构 `pay_channel`
--

CREATE TABLE `pay_channel` (
  `id` int(3) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `pay_channel`
--

INSERT INTO `pay_channel` (`id`, `name`) VALUES
(2, '速卖通'),
(3, 'MB支付');

--
-- 触发器 `pay_channel`
--
DELIMITER $$
CREATE TRIGGER `pey_channel_delete` AFTER DELETE ON `pay_channel` FOR EACH ROW UPDATE sites SET pay_channel_id = 0 WHERE pay_channel_id = old.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `code`) VALUES
(1, '页面-用户列表', 'setting.users.index'),
(2, '页面-用户详细', 'setting.users.show'),
(3, '页面-用户创建', 'setting.users.create'),
(4, '执行-新用户保存', 'setting.users.store'),
(5, '页面-用户编辑', 'setting.users.edit'),
(6, '执行-用户修改', 'setting.users.update'),
(7, '执行-用户删除', 'setting.users.destroy'),
(8, '页面-角色列表', 'setting.roles.index'),
(9, '页面-角色详细', 'setting.roles.show'),
(10, '页面-角色创建', 'setting.roles.create'),
(11, '执行-新角色保存', 'setting.roles.store'),
(12, '页面-角色编辑', 'setting.roles.edit'),
(13, '执行-角色修改', 'setting.roles.update'),
(14, '执行-角色删除', 'setting.roles.destroy'),
(15, '页面-权限列表', 'setting.permissions.index'),
(16, '页面-权限详细', 'setting.permissions.show'),
(17, '页面-权限添加', 'setting.permissions.create'),
(18, '执行-新权限保存', 'setting.permissions.store'),
(19, '页面-权限编辑', 'setting.permissions.edit'),
(20, '执行-权限', 'setting.permissions.update'),
(21, '执行-权限删除', 'setting.permissions.destroy'),
(22, '页面-网站信息列表', 'data.site.sites.index'),
(23, '页面-网站信息详细', 'data.site.sites.show'),
(24, '页面-网站创建', 'data.site.sites.create'),
(25, '执行-新网站保存', 'data.site.sites.store'),
(26, '页面-网站信息编辑', 'data.site.sites.edit'),
(27, '执行-网站信息修改', 'data.site.sites.update'),
(28, '执行-网站信息删除', 'data.site.sites.destroy'),
(29, '页面-品牌信息列表', 'data.site.banners.index'),
(30, '页面-品牌信息详细', 'data.site.banners.show'),
(31, '页面-品牌信息添加', 'data.site.banners.create'),
(32, '执行-新品牌信息保存', 'data.site.banners.store'),
(33, '页面-品牌信息编辑', 'data.site.banners.edit'),
(34, '执行-品牌信息修改', 'data.site.banners.update'),
(35, '执行-品牌信息删除', 'data.site.banners.destroy'),
(36, '页面-通道信息列表', 'data.site.paychannels.index'),
(37, '页面-通道信息详细', 'data.site.paychannels.show'),
(38, '页面-通道信息添加', 'data.site.paychannels.create'),
(39, '执行-新通道信息保存', 'data.site.paychannels.store'),
(40, '页面-通道信息编辑', 'data.site.paychannels.edit'),
(41, '执行-通道信息修改', 'data.site.paychannels.update'),
(42, '执行-通道信息删除', 'data.site.paychannels.destroy'),
(43, '页面-广告记录列表', 'data.ad.records.index'),
(44, '页面-广告记录详细', 'data.ad.records.show'),
(45, '页面-广告记录添加', 'data.ad.records.create'),
(46, '执行-新广告记录保存', 'data.ad.records.store'),
(47, '页面-广告记录编辑', 'data.ad.records.edit'),
(48, '执行-广告记录修改', 'data.ad.records.update'),
(49, '执行-广告记录删除', 'data.ad.records.destroy'),
(50, '页面-广告账号列表', 'data.ad.accounts.index'),
(51, '页面-广告账号详细', 'data.ad.accounts.show'),
(52, '页面-广告账号添加', 'data.ad.accounts.create'),
(53, '执行-新广告账号保存', 'data.ad.accounts.store'),
(54, '页面-广告账号编辑', 'data.ad.accounts.edit'),
(55, '执行-广告账号修改', 'data.ad.accounts.update'),
(56, '执行-广告账号删除', 'data.ad.accounts.destroy'),
(57, '页面-广告VPS列表', 'data.ad.vps.index'),
(58, '页面-广告VPS详细', 'data.ad.vps.show'),
(59, '页面-广告VPS添加', 'data.ad.vps.create'),
(60, '执行-新广告VPS保存', 'data.ad.vps.store'),
(61, '页面-广告VPS编辑', 'data.ad.vps.edit'),
(62, '执行-广告VPS修改', 'data.ad.vps.update'),
(63, '执行-广告VPS删除', 'data.ad.vps.destroy'),
(64, '页面-绑定账号列表', 'data.ad.binds.index'),
(65, '页面-绑定账号详细', 'data.ad.binds.show'),
(66, '页面-绑定账号创建', 'data.ad.binds.create'),
(67, '执行-新绑定账号保存', 'data.ad.binds.store'),
(68, '页面-绑定账号编辑', 'data.ad.binds.edit'),
(69, '执行-绑定账号修改', 'data.ad.binds.update'),
(70, '执行-绑定账号删除', 'data.ad.binds.destroy'),
(71, 'AJAX-广告账号列表', 'data.ad.accountsajax.index'),
(72, 'AJAX-广告VPS列表', 'data.ad.vpsajax.index'),
(73, 'AJAX-广告记录列表', 'data.ad.recordsajax.index'),
(74, '上传-权限信息', 'setting.permissions.upload'),
(75, '下载-权限信息', 'setting.permissions.download'),
(76, '上传-用户信息 ', 'setting.users.upload'),
(77, '下载-用户信息 ', 'setting.users.download'),
(78, '上传-角色信息 ', 'setting.roles.upload'),
(79, '下载-角色信息 ', 'setting.roles.download'),
(80, '上传-网站信息 ', 'data.site.sites.upload'),
(81, '下载-网站信息 ', 'data.site.sites.download'),
(82, '上传-品牌信息 ', 'data.site.banners.upload'),
(83, '下载-品牌信息 ', 'data.site.banners.download'),
(84, '上传-通道信息 ', 'data.site.paychannels.upload'),
(85, '下载-通道信息 ', 'data.site.paychannels.download'),
(86, '上传-广告记录 ', 'data.ad.records.upload'),
(87, '下载-广告记录 ', 'data.ad.records.download'),
(88, '上传-广告账号 ', 'data.ad.accounts.upload'),
(89, '下载-广告账号 ', 'data.ad.accounts.download'),
(90, '上传-广告VPS ', 'data.ad.vps.upload'),
(91, '下载-广告VPS ', 'data.ad.vps.download'),
(92, '上传-绑定账号信息 ', 'data.ad.binds.upload'),
(93, '下载-绑定账号信息 ', 'data.ad.binds.download'),
(94, 'AJAX-网站列表', 'data.site.sitesajax.index'),
(95, '页面-广告账号报表', 'chart.ad.records.table.index'),
(96, '执行-广告表样式保存', 'style.ad.chart.store'),
(97, '页面-广告表样式', 'style.ad.chart.index'),
(98, 'ajax-广告表详细配置', 'style.ad.chart.show'),
(99, '页面-广告走势图', 'chart.ad.lines.index'),
(100, '页面-广告总统计图', 'chart.ad.bars.index'),
(101, '页面-订单管理', 'data.logistics.orders.index'),
(102, '页面-财务管理页面', 'data.money.bills.index'),
(103, '执行-添加财务账户', 'data.money.accounts.store'),
(104, '执行- 更新财务账户', 'data.money.accounts.update'),
(105, '执行- 删除财务账户', 'data.money.accounts.destroy'),
(106, 'ajax- 财务数据', 'data.money.records.index'),
(107, 'ajax- 添加财务数据', 'data.money.records.store'),
(108, 'ajax-修改财务数据', 'data.money.records.update'),
(109, 'ajax-修改财务数据类型', 'data.money.type.update'),
(110, '执行-添加财务数据类型', 'data.money.type.stroe'),
(112, ' 页面-物流信息', 'data.logistics.express.index'),
(113, '页面-调货订货页面', 'data.logistics.supplier.index');

--
-- 触发器 `permissions`
--
DELIMITER $$
CREATE TRIGGER `permissions_delete` BEFORE DELETE ON `permissions` FOR EACH ROW DELETE FROM permissions_roles WHERE permissions_id = old.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `permissions_roles`
--

CREATE TABLE `permissions_roles` (
  `id` int(10) NOT NULL,
  `permissions_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `permissions_roles`
--

INSERT INTO `permissions_roles` (`id`, `permissions_id`, `roles_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1),
(20, 20, 1),
(21, 21, 1),
(22, 22, 1),
(23, 23, 1),
(24, 24, 1),
(25, 25, 1),
(26, 26, 1),
(27, 27, 1),
(28, 28, 1),
(29, 29, 1),
(30, 30, 1),
(31, 31, 1),
(32, 32, 1),
(33, 33, 1),
(34, 34, 1),
(35, 35, 1),
(36, 36, 1),
(37, 37, 1),
(38, 38, 1),
(39, 39, 1),
(40, 40, 1),
(41, 41, 1),
(42, 42, 1),
(43, 43, 1),
(44, 44, 1),
(45, 45, 1),
(46, 46, 1),
(47, 47, 1),
(48, 48, 1),
(49, 49, 1),
(50, 50, 1),
(51, 51, 1),
(52, 52, 1),
(53, 53, 1),
(54, 54, 1),
(55, 55, 1),
(56, 56, 1),
(57, 57, 1),
(58, 58, 1),
(59, 59, 1),
(60, 60, 1),
(61, 61, 1),
(62, 62, 1),
(63, 63, 1),
(64, 64, 1),
(65, 65, 1),
(66, 66, 1),
(67, 67, 1),
(68, 68, 1),
(69, 69, 1),
(70, 70, 1),
(71, 71, 1),
(72, 72, 1),
(73, 73, 1),
(74, 74, 1),
(75, 75, 1),
(76, 76, 1),
(77, 77, 1),
(78, 78, 1),
(79, 79, 1),
(80, 80, 1),
(81, 81, 1),
(82, 82, 1),
(83, 83, 1),
(84, 84, 1),
(85, 85, 1),
(86, 86, 1),
(87, 87, 1),
(88, 88, 1),
(89, 89, 1),
(90, 90, 1),
(91, 91, 1),
(92, 92, 1),
(93, 93, 1),
(94, 94, 1),
(95, 95, 1),
(96, 1, 2),
(97, 2, 2),
(98, 3, 2),
(99, 4, 2),
(100, 5, 2),
(101, 6, 2),
(102, 7, 2),
(103, 8, 2),
(104, 9, 2),
(105, 10, 2),
(106, 11, 2),
(107, 12, 2),
(108, 13, 2),
(109, 14, 2),
(110, 15, 2),
(111, 22, 2),
(112, 23, 2),
(113, 24, 2),
(114, 25, 2),
(115, 26, 2),
(116, 27, 2),
(117, 28, 2),
(118, 29, 2),
(119, 30, 2),
(120, 31, 2),
(121, 32, 2),
(122, 33, 2),
(123, 34, 2),
(124, 35, 2),
(125, 36, 2),
(126, 37, 2),
(127, 38, 2),
(128, 39, 2),
(129, 40, 2),
(130, 41, 2),
(131, 42, 2),
(132, 43, 2),
(133, 44, 2),
(134, 45, 2),
(135, 46, 2),
(136, 47, 2),
(137, 48, 2),
(138, 49, 2),
(139, 50, 2),
(140, 51, 2),
(141, 52, 2),
(142, 53, 2),
(143, 54, 2),
(144, 55, 2),
(145, 56, 2),
(146, 57, 2),
(147, 58, 2),
(148, 59, 2),
(149, 60, 2),
(150, 61, 2),
(151, 62, 2),
(152, 63, 2),
(153, 64, 2),
(154, 65, 2),
(155, 66, 2),
(156, 67, 2),
(157, 68, 2),
(158, 69, 2),
(159, 70, 2),
(160, 71, 2),
(161, 72, 2),
(162, 73, 2),
(163, 74, 2),
(164, 75, 2),
(165, 76, 2),
(166, 77, 2),
(167, 78, 2),
(168, 79, 2),
(169, 80, 2),
(170, 81, 2),
(171, 82, 2),
(172, 83, 2),
(173, 84, 2),
(174, 85, 2),
(175, 86, 2),
(176, 87, 2),
(177, 88, 2),
(178, 89, 2),
(179, 90, 2),
(180, 91, 2),
(181, 92, 2),
(182, 93, 2),
(183, 94, 2),
(184, 95, 2),
(185, 96, 1),
(186, 97, 1),
(187, 98, 1),
(188, 99, 1),
(189, 100, 1),
(190, 101, 1),
(194, 103, 1),
(193, 102, 1),
(195, 104, 1),
(196, 105, 1),
(197, 106, 1),
(198, 107, 1),
(199, 108, 1),
(200, 109, 1),
(201, 110, 1),
(203, 112, 1),
(204, 113, 1);

-- --------------------------------------------------------

--
-- 表的结构 `products_to_express`
--

CREATE TABLE `products_to_express` (
  `id` int(10) NOT NULL,
  `orders_id` int(10) NOT NULL,
  `express_id` int(3) NOT NULL,
  `code` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE `roles` (
  `id` int(5) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(64) NOT NULL,
  `users_id` int(11) NOT NULL,
  `default_page` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `roles`
--

INSERT INTO `roles` (`id`, `name`, `code`, `users_id`, `default_page`) VALUES
(1, '总管理员', 'root', 0, 'setting.users.index'),
(2, '管理员', 'admin.test', 1, 'setting.users.index');

--
-- 触发器 `roles`
--
DELIMITER $$
CREATE TRIGGER `roles_delete` BEFORE DELETE ON `roles` FOR EACH ROW BEGIN
DELETE FROM roles_users where roles_id = old.id;
DELETE FROM permissions_roles where roles_id = old.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `roles_users`
--

CREATE TABLE `roles_users` (
  `id` int(5) NOT NULL,
  `roles_id` int(5) NOT NULL,
  `users_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `roles_users`
--

INSERT INTO `roles_users` (`id`, `roles_id`, `users_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(5, 2, 4),
(9, 2, 5);

-- --------------------------------------------------------

--
-- 表的结构 `sites`
--

CREATE TABLE `sites` (
  `id` int(5) NOT NULL,
  `host` varchar(128) NOT NULL,
  `banners_id` int(3) NOT NULL,
  `pay_channel_id` int(5) NOT NULL,
  `users_id` int(5) NOT NULL,
  `note` text,
  `binded` tinyint(1) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sites`
--

INSERT INTO `sites` (`id`, `host`, `banners_id`, `pay_channel_id`, `users_id`, `note`, `binded`, `status`, `created_at`, `updated_at`) VALUES
(1, 'http://ba.dou.com', 4, 2, 1, NULL, 1, 1, '2016-09-05 02:34:09', '2016-09-27 01:38:31'),
(2, 'http://www.google123.com', 5, 3, 1, NULL, 1, 1, '2016-09-09 02:12:06', '2016-09-27 01:38:50'),
(3, 'http://hao123.com', 4, 2, 1, NULL, 0, 1, '2016-09-27 02:16:52', '2016-09-27 02:16:52'),
(6, 'http://hao124.com', 5, 3, 1, NULL, 0, 1, '2016-09-27 02:24:31', '2016-09-27 02:24:31'),
(7, 'http://hao1225.com', 5, 3, 1, NULL, 0, 1, '2016-09-27 02:25:50', '2016-09-27 02:35:10'),
(10, 'http://127.0.0.1/zencart3', 4, 2, 1, NULL, 0, 1, '2016-10-04 06:50:56', '2016-10-04 06:50:56'),
(9, 'http://test.ahbs123.com', 4, 3, 1, NULL, 0, 1, '2016-09-27 02:28:40', '2016-09-27 02:28:40');

-- --------------------------------------------------------

--
-- 表的结构 `style`
--

CREATE TABLE `style` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `style` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `style`
--

INSERT INTO `style` (`id`, `name`, `style`, `users_id`, `type`) VALUES
(4, '', 'a:6:{i:0;a:3:{s:4:"name";s:6:"充值";s:5:"total";s:3:"max";s:5:"value";s:8:"recharge";}i:1;a:3:{s:4:"name";s:17:"广告消费(USD)";s:5:"total";s:0:"";s:5:"value";s:4:"cost";}i:2;a:3:{s:4:"name";s:9:"点击量";s:5:"total";s:0:"";s:5:"value";s:12:"click_amount";}i:3;a:3:{s:4:"name";s:8:"IP成单";s:5:"total";s:3:"min";s:5:"value";s:13:"orders_amount";}i:4;a:3:{s:4:"name";s:21:"交易金额（RMB）";s:5:"total";s:3:"max";s:5:"value";s:12:"orders_money";}i:5;a:3:{s:4:"name";s:6:"比例";s:5:"total";s:3:"min";s:5:"value";s:26:"click_amount/orders_amount";}}', 1, 'ad.table'),
(5, 'Array', 'a:4:{i:0;a:3:{s:4:"name";s:17:"广告消费(USD)";s:5:"total";s:0:"";s:5:"value";s:4:"cost";}i:1;a:3:{s:4:"name";s:9:"点击量";s:5:"total";s:0:"";s:5:"value";s:12:"click_amount";}i:2;a:3:{s:4:"name";s:6:"单量";s:5:"total";s:0:"";s:5:"value";s:13:"orders_amount";}i:3;a:3:{s:4:"name";s:21:"成交金额（RMB）";s:5:"total";s:0:"";s:5:"value";s:12:"orders_money";}}', 0, 'ad.bars'),
(6, 'Array', 'a:6:{i:0;a:3:{s:4:"name";s:6:"充值";s:5:"total";s:3:"min";s:5:"value";s:8:"recharge";}i:1;a:3:{s:4:"name";s:17:"广告消费(USD)";s:5:"total";s:3:"avg";s:5:"value";s:4:"cost";}i:2;a:3:{s:4:"name";s:9:"点击量";s:5:"total";s:3:"sum";s:5:"value";s:12:"click_amount";}i:3;a:3:{s:4:"name";s:4:"test";s:5:"total";s:3:"sum";s:5:"value";s:17:"cost*orders_money";}i:4;a:3:{s:4:"name";s:6:"单量";s:5:"total";s:3:"max";s:5:"value";s:13:"orders_amount";}i:5;a:3:{s:4:"name";s:21:"成交金额（RMB）";s:5:"total";s:3:"min";s:5:"value";s:12:"orders_money";}}', 0, 'ad.lines');

-- --------------------------------------------------------

--
-- 表的结构 `supplier`
--

CREATE TABLE `supplier` (
  `id` int(4) NOT NULL,
  `name` varchar(32) NOT NULL,
  `address` varchar(255) NOT NULL,
  `telephone` int(11) NOT NULL,
  `qq` int(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `address`, `telephone`, `qq`) VALUES
(1, 'RB-黄石熊阿', '213213213aa a,asdf asd,asd f', 615615651, 276030348),
(2, 'OK-随碟附送', '阿斯蒂芬斯蒂芬', 1321321321, 19881891);

-- --------------------------------------------------------

--
-- 表的结构 `supplier_link`
--

CREATE TABLE `supplier_link` (
  `id` int(20) NOT NULL,
  `code` varchar(32) NOT NULL,
  `type` tinyint(1) DEFAULT '0',
  `supplier_id` int(3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `supplier_link`
--

INSERT INTO `supplier_link` (`id`, `code`, `type`, `supplier_id`, `created_at`, `updated_at`) VALUES
(13, 'fc2f7ec8f92f40d456a4ec1a6faac094', 0, 1, '2016-10-28 07:34:30', '2016-10-28 07:34:30'),
(12, '919fbbffea11c3abe3899296262234a8', 0, 2, '2016-10-28 07:33:26', '2016-10-28 07:33:26'),
(11, 'afa85dd9dc1fb411278f4c60244d2a03', 0, 1, '2016-10-28 06:05:24', '2016-10-28 06:05:24'),
(10, '9eee188ee12eb1a662d45e1dfae4ef1e', 1, 2, '2016-10-15 01:29:37', '2016-10-27 08:25:28'),
(9, 'adc51841b68104801f3d56d1983c4e7e', 1, 1, '2016-10-15 01:29:29', '2016-10-28 03:40:57');

-- --------------------------------------------------------

--
-- 表的结构 `supplier_to_products`
--

CREATE TABLE `supplier_to_products` (
  `id` int(20) NOT NULL,
  `supplier_link_id` int(10) NOT NULL,
  `orders_products_id` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `supplier_to_products`
--

INSERT INTO `supplier_to_products` (`id`, `supplier_link_id`, `orders_products_id`, `type`, `price`) VALUES
(22, 11, 1, 0, '0.00'),
(21, 10, 15, 1, '0.00'),
(20, 10, 14, 1, '0.00'),
(19, 10, 13, -1, '0.00'),
(18, 10, 12, -1, '0.00'),
(17, 10, 11, -1, '0.00'),
(16, 9, 10, -1, '0.00'),
(15, 9, 9, 1, '0.00'),
(14, 9, 8, -1, '0.00'),
(13, 9, 7, -1, '0.00'),
(12, 9, 6, -1, '0.00'),
(23, 11, 2, 0, '0.00'),
(24, 11, 3, 0, '0.00'),
(25, 12, 4, 0, '0.00'),
(26, 13, 5, 0, '0.00');

--
-- 触发器 `supplier_to_products`
--
DELIMITER $$
CREATE TRIGGER `supplier_to_products_delete` AFTER DELETE ON `supplier_to_products` FOR EACH ROW UPDATE `orders_products` SET `locked`=0 WHERE id = old.orders_products_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(5) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `remember_token`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '$2y$10$n/p6fQLZnS59sQwUt7JEmeBOU/pocHarhvJKWlWUJAx.p7.4g.g3e', '6m6jPxWJpzHp3DsbpVIIOWyPbL0XPwNrkEg1fvDkP5BzxLclMCJ91Br3S4Ec', 0, '2016-07-21 09:28:26', '2016-10-08 06:25:37'),
(2, ' 测试-小黄', 'test.xiaohuang', '$2y$10$yvijlvAF8ZRBzkKbv9nZ4uKD66WuSfQq4u.aIsfVeRTLu1rm3d2Lq', 'mLUGUGcnnicK64cQnjTK36kSZblFQUSKzWB3TXUywTXdmwcoEo9iIzCCXlXe', 1, '2016-09-05 02:01:49', '2016-09-05 02:23:59'),
(3, '测试小雨5', 'testtesttest', '$2y$10$xdzV4fy9rmVHVI6YGtXfLe5L2ywI4qllH2IrU6uYS5irq9yD78nJK', NULL, 1, '2016-09-26 03:30:24', '2016-09-26 09:02:09'),
(4, '厕所刷防水1', 'asdfasdfasdfas', '$2y$10$PilU9T0l7aJF4UILp3iLCu0.v7/ompumKDm3ecb0rvZ8YudJDgdj.', NULL, 1, '2016-09-26 03:39:56', '2016-09-26 08:44:45'),
(5, 'asdfasdfasdfas', 'asdfasdfasdfasdfwqeweev', '$2y$10$VZYOOHKo4QeylJ0lPxF0IOSLMOFNrc7mhhY909Xh9g083woaideMu', NULL, 1, '2016-09-26 03:40:22', '2016-09-26 08:48:53');

--
-- 触发器 `users`
--
DELIMITER $$
CREATE TRIGGER `users_delete` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM roles_users WHERE users_id = old.id
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_accounts`
--
ALTER TABLE `ad_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `ad_binds`
--
ALTER TABLE `ad_binds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_id` (`accounts_id`),
  ADD UNIQUE KEY `site_id` (`sites_id`);

--
-- Indexes for table `ad_records`
--
ALTER TABLE `ad_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_vps`
--
ALTER TABLE `ad_vps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `express`
--
ALTER TABLE `express`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `express_business`
--
ALTER TABLE `express_business`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `express_type`
--
ALTER TABLE `express_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_accounts`
--
ALTER TABLE `money_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `money_records`
--
ALTER TABLE `money_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_type`
--
ALTER TABLE `money_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `host` (`sites_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_products_type`
--
ALTER TABLE `orders_products_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders_to_type`
--
ALTER TABLE `orders_to_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_type`
--
ALTER TABLE `orders_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay_channel`
--
ALTER TABLE `pay_channel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `permissions_roles`
--
ALTER TABLE `permissions_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_to_express`
--
ALTER TABLE `products_to_express`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `host` (`host`);

--
-- Indexes for table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qq` (`qq`);

--
-- Indexes for table `supplier_link`
--
ALTER TABLE `supplier_link`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `code_2` (`code`);

--
-- Indexes for table `supplier_to_products`
--
ALTER TABLE `supplier_to_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `ad_accounts`
--
ALTER TABLE `ad_accounts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `ad_binds`
--
ALTER TABLE `ad_binds`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `ad_records`
--
ALTER TABLE `ad_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `ad_vps`
--
ALTER TABLE `ad_vps`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `express`
--
ALTER TABLE `express`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `express_business`
--
ALTER TABLE `express_business`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `express_type`
--
ALTER TABLE `express_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `money_accounts`
--
ALTER TABLE `money_accounts`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `money_records`
--
ALTER TABLE `money_records`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 使用表AUTO_INCREMENT `money_type`
--
ALTER TABLE `money_type`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- 使用表AUTO_INCREMENT `orders_products_type`
--
ALTER TABLE `orders_products_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `orders_to_type`
--
ALTER TABLE `orders_to_type`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `orders_type`
--
ALTER TABLE `orders_type`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `pay_channel`
--
ALTER TABLE `pay_channel`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- 使用表AUTO_INCREMENT `permissions_roles`
--
ALTER TABLE `permissions_roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;
--
-- 使用表AUTO_INCREMENT `products_to_express`
--
ALTER TABLE `products_to_express`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `roles_users`
--
ALTER TABLE `roles_users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `style`
--
ALTER TABLE `style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `supplier_link`
--
ALTER TABLE `supplier_link`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `supplier_to_products`
--
ALTER TABLE `supplier_to_products`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
