-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2014 at 07:57 PM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cscbanki_csc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ac_detail`
--

CREATE TABLE IF NOT EXISTS `ac_detail` (
  `ac_no` int(10) NOT NULL,
  `ac_type` varchar(250) NOT NULL,
  `ac_bal` float NOT NULL,
  `ac_cdate` datetime NOT NULL,
  `username` varchar(250) NOT NULL,
  `ac_status` varchar(250) NOT NULL,
  PRIMARY KEY (`ac_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ac_detail`
--

INSERT INTO `ac_detail` (`ac_no`, `ac_type`, `ac_bal`, `ac_cdate`, `username`, `ac_status`) VALUES
(15140000, 'bank_account', 9.99721e+06, '2014-01-01 00:00:00', 'admin@cscbanking.com', 'active'),
(15140001, 'cheuqing', 30, '2014-04-08 18:11:53', 'r.kikani@yahoo.com', 'active'),
(15140002, 'cheuqing', 930, '2014-04-08 19:58:03', 'rahulk.kikani@yahoo.com', 'active'),
(15140003, 'company_account', 810, '2014-04-08 23:09:09', 'billpay@bell.ca', 'active'),
(15140004, 'company_account', 145, '2014-04-08 23:10:44', 'paybill@hydroquebec.com', 'active'),
(15140005, 'credit', 0, '2014-04-08 23:52:55', 'r.kikani@yahoo.com', 'active'),
(15140006, 'investment', 67.92, '2014-04-09 00:42:22', 'r.kikani@yahoo.com', 'active'),
(15140007, 'cheuqing', 789.4, '2014-04-12 21:05:37', 'nassim.eghtesadi@gmail.com', 'active'),
(15140008, 'investment', 0, '2014-04-13 15:02:13', 'nassim.eghtesadi@gmail.com', 'active'),
(15140009, 'credit', 0, '2014-04-13 15:22:59', 'nassim.eghtesadi@gmail.com', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE IF NOT EXISTS `admin_login` (
  `uemail` varchar(255) NOT NULL,
  `pswd` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uemail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`uemail`, `pswd`, `status`, `cdate`, `counter`) VALUES
('admin@cscbanking.com', 'e19d5cd5af0378da05f63f891c7467af', 'active', '2014-04-01 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `billing_detail`
--

CREATE TABLE IF NOT EXISTS `billing_detail` (
  `ac_no` bigint(20) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `uemail` varchar(255) NOT NULL,
  `bill_amount` float NOT NULL,
  `company_no` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing_detail`
--

INSERT INTO `billing_detail` (`ac_no`, `bill_no`, `uemail`, `bill_amount`, `company_no`, `status`, `cdate`) VALUES
(15140001, '1234560', 'r.kikani@yahoo.com', 100, 15140003, 'Paid', '2014-04-08 23:25:29'),
(3222211110000, '112233', 'r.kikani@yahoo.com', 145, 15140004, 'Paid', '2014-04-08 23:26:08'),
(3222211110000, '115599', 'r.kikani@yahoo.com', 10, 15140003, 'Paid', '2014-04-08 23:29:27'),
(3222211110002, '114477', 'r.kikani@yahoo.com', 500, 15140003, 'Paid', '2014-04-09 00:04:32'),
(3222211110004, '22222', 'nassim.eghtesadi@gmail.com', 200, 15140003, 'Paid', '2014-04-13 15:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

CREATE TABLE IF NOT EXISTS `captcha` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(11) unsigned NOT NULL,
  `ip_add` varchar(16) NOT NULL,
  `word` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=268 ;

--
-- Dumping data for table `captcha`
--

INSERT INTO `captcha` (`id`, `time`, `ip_add`, `word`) VALUES
(267, 1397430210, '132.205.93.97', 'th8k90');

-- --------------------------------------------------------

--
-- Table structure for table `cheques_detail`
--

CREATE TABLE IF NOT EXISTS `cheques_detail` (
  `uemail` varchar(255) NOT NULL,
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `to_ac` int(10) NOT NULL,
  `from_ac` int(10) NOT NULL,
  `chq_no` int(10) NOT NULL,
  `bank_detail` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `cdate` datetime NOT NULL,
  `chq_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `attached_file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attached_file` (`attached_file`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cheques_detail`
--

INSERT INTO `cheques_detail` (`uemail`, `id`, `to_ac`, `from_ac`, `chq_no`, `bank_detail`, `amount`, `cdate`, `chq_date`, `status`, `msg`, `attached_file`) VALUES
('r.kikani@yahoo.com', 1, 15140001, 15140002, 100001, 'CSC Bank, Montreal', 100, '2014-04-08 20:00:25', '2014-03-21', 'Approved', 'none', '73691c73c208afed578d7db973715047.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `credit_card_type`
--

CREATE TABLE IF NOT EXISTS `credit_card_type` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `int_rate` float NOT NULL,
  `limit` float NOT NULL,
  `days` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `credit_card_type`
--

INSERT INTO `credit_card_type` (`cid`, `name`, `int_rate`, `limit`, `days`, `cdate`) VALUES
(1, 'Bronze', 19.99, 500, 30, '2014-04-01 00:00:00'),
(2, 'Silver', 20.99, 1000, 30, '2014-04-01 00:00:00'),
(3, 'Platinum', 22.99, 2000, 30, '2014-04-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `credit_e_statement_record`
--

CREATE TABLE IF NOT EXISTS `credit_e_statement_record` (
  `estateid` int(11) NOT NULL AUTO_INCREMENT,
  `card_no` bigint(20) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `amount` float NOT NULL,
  `tax` float NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`estateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inve_fixed_deposit`
--

CREATE TABLE IF NOT EXISTS `inve_fixed_deposit` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ac_no` bigint(20) NOT NULL,
  `amount` float NOT NULL,
  `issue_date` date NOT NULL,
  `last_date` date NOT NULL,
  `rate` float NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `inve_fixed_deposit`
--

INSERT INTO `inve_fixed_deposit` (`id`, `ac_no`, `amount`, `issue_date`, `last_date`, `rate`, `status`) VALUES
(1, 15140006, 101, '2014-04-11', '2016-04-11', 200, 'running');

-- --------------------------------------------------------

--
-- Table structure for table `manage_credit_card_request`
--

CREATE TABLE IF NOT EXISTS `manage_credit_card_request` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `uemail` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `annual_income` float NOT NULL,
  `annual_expe` float NOT NULL,
  `income_tax` float NOT NULL,
  `status` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `manage_credit_card_request`
--

INSERT INTO `manage_credit_card_request` (`id`, `uemail`, `type`, `annual_income`, `annual_expe`, `income_tax`, `status`, `cdate`) VALUES
(1, 'r.kikani@yahoo.com', '1', 150000, 50000, 30000, 'Active', '2014-04-08 23:45:29'),
(2, 'nassim.eghtesadi@gmail.com', '1', 44000, 30000, 10000, 'Active', '2014-04-12 21:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `secure_question`
--

CREATE TABLE IF NOT EXISTS `secure_question` (
  `q_id` int(3) NOT NULL,
  `detail` varchar(255) NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secure_question`
--

INSERT INTO `secure_question` (`q_id`, `detail`) VALUES
(1001, 'What was your childhood nickname?'),
(1002, 'What is the name of your favorite childhood friend?'),
(1003, 'In what city or town was your first job?'),
(1004, 'What is your pet''s name?'),
(1005, 'What was the color of your first car?');

-- --------------------------------------------------------

--
-- Table structure for table `stock_market`
--

CREATE TABLE IF NOT EXISTS `stock_market` (
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sales_price` float NOT NULL,
  `buy_price` float NOT NULL,
  `total_no` bigint(10) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_market`
--

INSERT INTO `stock_market` (`code`, `name`, `sales_price`, `buy_price`, `total_no`) VALUES
('ACB', 'Air Canada', 6, 7.59, 99993),
('BBB', 'BlackBerry Limited', 10.11, 8.99, 100000),
('BBD', 'Bombardier Inc.', 4.11, 4.5, 500000),
('ECA', 'Encana Corporation', 24.78, 24.9, 9998),
('OSK', 'Osisko Mining Corporation', 7.29, 7.44, 600000),
('YRI', 'Yamana Gold Inc.', 9.5, 11.22, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `stock_order`
--

CREATE TABLE IF NOT EXISTS `stock_order` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ac_no` bigint(20) NOT NULL,
  `code` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `amount` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `stock_order`
--

INSERT INTO `stock_order` (`id`, `ac_no`, `code`, `price`, `amount`, `type`, `status`, `cdate`) VALUES
(1, 15140006, 'ACB', 7.59, 10, 'Buy', 'NOT-SOLD', '2014-04-09 01:03:17'),
(2, 15140006, 'ACB', 7.15, 2, 'Sell', 'SOLD', '2014-04-09 01:07:13'),
(3, 15140006, 'BBB', 8.99, 10, 'Buy', 'NOT-SOLD', '2014-04-09 01:07:40'),
(4, 15140006, 'ACB', 8.1, 3, 'Sell', 'SOLD', '2014-04-09 01:08:53'),
(5, 15140006, 'BBB', 10.11, 10, 'Sell', 'SOLD', '2014-04-09 01:09:01'),
(6, 15140006, 'ECA', 24.9, 2, 'Buy', 'NOT-SOLD', '2014-04-09 01:16:29'),
(7, 15140006, 'ACB', 7.59, 1, 'Buy', 'NOT-SOLD', '2014-04-12 14:55:34'),
(8, 15140006, 'ACB', 7.59, 1, 'Buy', 'NOT-SOLD', '2014-04-12 14:55:42'),
(9, 15140008, 'ECA', 24.9, 5, 'Buy', 'NOT-SOLD', '2014-04-13 15:08:19'),
(10, 15140008, 'ECA', 24.78, 5, 'Sell', 'SOLD', '2014-04-13 15:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_detail`
--

CREATE TABLE IF NOT EXISTS `transaction_detail` (
  `trans_id` int(10) NOT NULL AUTO_INCREMENT,
  `ac_from` bigint(16) NOT NULL,
  `ac_to` bigint(16) NOT NULL,
  `amount` float NOT NULL,
  `bal_from` float NOT NULL,
  `bal_to` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `trans_date` datetime NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000000056 ;

--
-- Dumping data for table `transaction_detail`
--

INSERT INTO `transaction_detail` (`trans_id`, `ac_from`, `ac_to`, `amount`, `bal_from`, `bal_to`, `description`, `trans_date`) VALUES
(1000000000, 15140000, 15140000, 1e+07, 0, 1e+07, 'First Transaction when Bank was open.', '2014-01-01 00:00:00'),
(1000000003, 15140000, 15140001, 1000, 9.999e+06, 1000, 'This is gift from bank....', '2014-04-08 18:11:53'),
(1000000004, 15140001, 3222211110000, 100, 900, 100, 'Transfter made from Chequing account to Virtual Money Card', '2014-04-08 19:44:14'),
(1000000005, 15140001, 3222211110000, 100, 800, 200, 'Transfter made from Chequing account to Virtual Money Card', '2014-04-08 19:46:17'),
(1000000006, 15140001, 3222211110000, 100, 700, 300, 'Transfter made from Chequing account to Virtual Money Card', '2014-04-08 19:48:24'),
(1000000007, 15140000, 15140002, 1000, 9.998e+06, 1000, 'This is gift from bank....', '2014-04-08 19:58:03'),
(1000000010, 15140002, 15140001, 100, 900, 1000, '100001-Cheque approved. Amount Credited.', '2014-04-08 20:21:47'),
(1000000011, 15140001, 15140002, 10, 990, 910, 'Transfter made from A/c to A/c within same bank...', '2014-04-08 21:09:20'),
(1000000012, 15140001, 15140002, 10, 980, 920, 'Transfter made from A/c to A/c within same bank...', '2014-04-08 21:09:55'),
(1000000013, 15140001, 3222211110000, 100, 880, 400, 'Transfter made from Cheuquing account to Virtual Money Card', '2014-04-08 21:10:31'),
(1000000014, 15140001, 3222211110000, 20, 860, 420, 'Transfter made from Cheuquing account to Virtual Money Card', '2014-04-08 21:11:39'),
(1000000015, 3222211110000, 15140001, 220, 200, 1080, 'Transfter made from Virtual Money Card to your A/c', '2014-04-08 21:12:15'),
(1000000016, 15140001, 15140003, 100, 980, 100, 'Bill Paid by Account', '2014-04-08 23:25:29'),
(1000000017, 3222211110000, 15140004, 145, 55, 145, 'Bill Paid by Virtual Card', '2014-04-08 23:26:08'),
(1000000018, 3222211110000, 15140003, 10, 45, 110, 'Bill Paid by Virtual Card', '2014-04-08 23:29:27'),
(1000000019, 3222211110002, 15140003, 500, -500, 610, 'Bill Paid by Credit Card', '2014-04-09 00:04:29'),
(1000000020, 15140001, 3222211110002, 100, 880, -400, 'Transfter made from Cheuquing account to Credit Card', '2014-04-09 00:05:35'),
(1000000021, 3222211110000, 3222211110002, 10, 35, -390, 'Virtual Card --> Credit Card', '2014-04-09 00:05:40'),
(1000000022, 3222211110000, 3222211110002, 5, 30, -385, 'Virtual Card --> Credit Card', '2014-04-09 00:06:12'),
(1000000023, 15140001, 15140006, 380, 500, 380, 'Transfter made between Cheuquing account and Investment A/c', '2014-04-09 01:03:01'),
(1000000024, 15140006, 15140000, 75.9, 304.1, 9.99808e+06, 'Transfter made from Investment to Bank A/c [Buying Shares]', '2014-04-09 01:03:17'),
(1000000025, 15140000, 15140006, 14.3, 9.99807e+06, 318.4, 'Transfter made from Bank A/c to Investment [Selling Shares]', '2014-04-09 01:07:13'),
(1000000026, 15140006, 15140000, 89.9, 228.5, 9.99816e+06, 'Transfter made from Investment to Bank A/c [Buying Shares]', '2014-04-09 01:07:40'),
(1000000027, 15140000, 15140006, 24.3, 9.99814e+06, 252.8, 'Transfter made from Bank A/c to Investment [Selling Shares]', '2014-04-09 01:08:53'),
(1000000028, 15140000, 15140006, 101.1, 9.99804e+06, 353.9, 'Transfter made from Bank A/c to Investment [Selling Shares]', '2014-04-09 01:09:01'),
(1000000029, 15140006, 3222211110000, 353.9, 0, 383.9, 'Transfter made from Cheuquing account to Virtual Money Card', '2014-04-09 01:13:25'),
(1000000030, 3222211110000, 3222211110002, 100, 283.9, -285, 'Virtual Card --> Credit Card', '2014-04-09 01:14:48'),
(1000000031, 3222211110000, 15140006, 100, 183.9, 100, 'Transfter made from Virtual Money Card to your A/c', '2014-04-09 01:16:20'),
(1000000032, 15140006, 15140000, 49.8, 50.2, 9.99809e+06, 'Transfter made from Investment to Bank A/c [Buying Shares]', '2014-04-09 01:16:29'),
(1000000033, 15140001, 3222211110000, 10, 490, 193.9, 'Transfter made from Chequing account to Virtual Money Card', '2014-04-10 17:36:05'),
(1000000034, 3222211110000, 15140006, 53.9, 140, 104.1, 'Transfter made from Virtual Money Card to your A/c', '2014-04-11 14:25:49'),
(1000000035, 15140006, 15140000, 101, 3.1, 9.99819e+06, 'Transfter made from Investment to Bank A/c [Fixed Deposit]', '2014-04-11 14:39:50'),
(1000000036, 3222211110000, 15140006, 10, 130, 13.1, 'Transfter made from Virtual Money Card to your A/c', '2014-04-11 15:02:51'),
(1000000037, 3222211110000, 15140006, 1.1, 128.9, 14.2, 'Transfter made from Virtual Money Card to your A/c', '2014-04-11 15:03:35'),
(1000000038, 3222211110000, 15140006, 18.9, 110, 33.1, 'Transfter made from Virtual Money Card to your A/c', '2014-04-11 15:08:46'),
(1000000039, 15140001, 15140006, 90, 400, 123.1, 'Transfter made between Cheuquing account and Investment A/c', '2014-04-11 15:09:21'),
(1000000040, 15140001, 15140002, 10, 390, 930, 'Transfter made from A/c to A/c within same bank...', '2014-04-11 16:11:48'),
(1000000041, 15140001, 3222211110000, 10, 380, 120, 'Transfter made from Chequing account to Virtual Money Card', '2014-04-12 02:20:55'),
(1000000042, 15140006, 15140000, 7.59, 115.51, 9.9982e+06, 'Transfter made from Investment to Bank A/c [Buying Shares]', '2014-04-12 14:55:34'),
(1000000043, 15140006, 15140000, 7.59, 107.92, 9.99821e+06, 'Transfter made from Investment to Bank A/c [Buying Shares]', '2014-04-12 14:55:42'),
(1000000044, 15140001, 3222211110000, 140, 240, 260, 'Transfter made from Chequing account to Virtual Money Card', '2014-04-12 19:46:44'),
(1000000045, 15140006, 3222211110000, 40, 67.92, 300, 'Transfter made from Cheuquing account to Virtual Money Card', '2014-04-12 20:18:50'),
(1000000046, 15140000, 15140007, 1000, 9.99721e+06, 1000, 'This is gift from bank....', '2014-04-12 21:05:37'),
(1000000047, 15140007, 15140008, 200, 800, 200, 'Transfter made between Cheuquing account and Investment A/c', '2014-04-13 15:03:53'),
(1000000048, 15140008, 15140000, 124.5, 75.5, 9.99733e+06, 'Transfter made from Investment to Bank A/c [Buying Shares]', '2014-04-13 15:08:19'),
(1000000049, 15140000, 15140008, 123.9, 9.99721e+06, 199.4, 'Transfter made from Bank A/c to Investment [Selling Shares]', '2014-04-13 15:10:39'),
(1000000050, 15140008, 15140007, 199.4, 0, 999.4, 'Transfter made between Cheuquing account and Investment A/c', '2014-04-13 15:12:16'),
(1000000051, 3222211110004, 15140003, 200, -200, 810, 'Bill Paid by Credit Card', '2014-04-13 15:23:26'),
(1000000052, 15140001, 3222211110002, 10, 230, -275, 'Transfter made from Cheuquing account to Credit Card', '2014-04-13 15:29:16'),
(1000000053, 15140001, 3222211110002, 200, 30, -75, 'Transfter made from Cheuquing account to Credit Card', '2014-04-13 15:39:41'),
(1000000054, 15140007, 3222211110004, 200, 799.4, 0, 'Transfter made from Cheuquing account to Credit Card', '2014-04-13 15:41:06'),
(1000000055, 15140007, 3222211110004, 10, 789.4, 10, 'Transfter made from Cheuquing account to Credit Card', '2014-04-13 15:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_limit`
--

CREATE TABLE IF NOT EXISTS `transaction_limit` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ac_type` varchar(255) NOT NULL,
  `max_limit` float NOT NULL,
  `min_limit` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `uemail` varchar(255) NOT NULL,
  `pswd` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `cdate` datetime NOT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  `reset_code` varchar(255) DEFAULT NULL,
  `reset_time` datetime DEFAULT NULL,
  PRIMARY KEY (`uemail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`uemail`, `pswd`, `status`, `cdate`, `counter`, `reset_code`, `reset_time`) VALUES
('nassim.eghtesadi@gmail.com', 'f2a2d0430b892a59d3ba993eb50c5e37', 'active', '2014-04-12 21:05:28', 0, NULL, NULL),
('r.kikani@yahoo.com', 'e19d5cd5af0378da05f63f891c7467af', 'active', '2014-04-08 18:11:52', 0, 'None', '2014-04-09 01:58:24'),
('rahulk.kikani@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', 'active', '2014-04-08 19:58:00', 0, 'None', '2014-04-09 23:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_history`
--

CREATE TABLE IF NOT EXISTS `user_login_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `ldate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `user_login_history`
--

INSERT INTO `user_login_history` (`id`, `username`, `description`, `ldate`) VALUES
(1, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-09 01:46:32'),
(3, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-09 01:47:44'),
(4, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-09 01:52:25'),
(5, 'r.kikani@yahoo.com', 'Login Blocked', '2014-04-09 01:52:29'),
(6, 'r.kikani@yahoo.com', 'Login Blocked', '2014-04-09 01:55:59'),
(7, 'r.kikani@yahoo.com', 'Login Blocked', '2014-04-09 01:57:52'),
(8, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-09 01:59:02'),
(9, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-09 13:17:16'),
(10, 'admin@cscbanking.com', 'Login Successful', '2014-04-09 19:52:01'),
(11, 'admin@cscbanking.com', 'Login Successful', '2014-04-09 19:56:16'),
(12, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-09 23:02:53'),
(13, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-09 23:03:17'),
(14, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-09 23:41:29'),
(15, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-09 23:41:48'),
(16, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-09 23:42:00'),
(17, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-10 17:34:51'),
(18, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-11 01:02:46'),
(19, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-11 01:02:58'),
(20, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-11 13:03:18'),
(21, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-11 13:03:29'),
(22, 'admin@cscbanking.com', 'Login Successful', '2014-04-11 16:15:14'),
(23, 'admin@cscbanking.com', 'Login Failed', '2014-04-11 16:46:08'),
(24, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 00:28:01'),
(25, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 00:31:58'),
(26, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 00:40:42'),
(27, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 00:56:13'),
(28, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 02:20:24'),
(29, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 14:53:17'),
(30, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-12 15:22:18'),
(31, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 15:29:49'),
(32, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 15:33:16'),
(33, 'er.varma@gmail.com', 'Login Failed', '2014-04-12 15:35:16'),
(34, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-12 15:36:03'),
(35, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 15:36:25'),
(36, 'admin@csebanking.com', 'Login Failed', '2014-04-12 15:37:45'),
(37, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 15:38:16'),
(38, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 15:40:39'),
(39, 'admin@cscbanking.com', 'Login Failed', '2014-04-12 15:45:33'),
(40, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 15:54:56'),
(41, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 16:03:19'),
(42, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 16:05:47'),
(43, 'r.kikai@yahoo.com', 'Login Failed', '2014-04-12 16:07:23'),
(44, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-12 16:07:43'),
(45, 'r.kikai@yahoo.com', 'Login Failed', '2014-04-12 16:07:49'),
(46, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 16:08:05'),
(47, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-12 16:11:35'),
(48, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 17:23:04'),
(49, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 18:47:57'),
(50, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-12 19:17:33'),
(51, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-12 19:33:05'),
(52, 'r.kikani@yahoo.com', 'Login Failed', '2014-04-12 19:34:03'),
(53, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 20:05:12'),
(54, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 21:04:57'),
(55, 'nassim.eghtesadi@gmail.com', 'Login Successful', '2014-04-12 21:19:35'),
(56, 'admin@cscbanking.com', 'Login Successful', '2014-04-12 21:22:00'),
(57, 'nassim.eghtesadi@gmail.com', 'Login Successful', '2014-04-13 14:59:07'),
(58, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-13 15:21:22'),
(59, 'admin@cscbanking.com', 'Login Successful', '2014-04-13 15:22:31'),
(60, 'admin@cscbanking.com', 'Login Successful', '2014-04-13 15:23:24'),
(61, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-13 16:40:53'),
(62, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-13 16:48:43'),
(63, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-13 16:51:55'),
(64, 'r.kikani@yahoo.com', 'Login Successful', '2014-04-13 17:03:23'),
(65, 'admin@cscbanking.com', 'Login Successful', '2014-04-13 17:17:08'),
(66, 'admin@cscbanking.com', 'Login Successful', '2014-04-13 18:21:36'),
(67, 'abcd@cscbanking.com', 'Login Failed', '2014-04-13 19:03:30'),
(68, 'admin@cscbanking.com', 'Login Successful', '2014-04-13 19:03:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uemail` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip_code` varchar(255) NOT NULL,
  `mno` varchar(255) NOT NULL,
  `doc_file` varchar(255) NOT NULL,
  `doc_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uemail` (`uemail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `uemail`, `fname`, `lname`, `address`, `city`, `state`, `zip_code`, `mno`, `doc_file`, `doc_id`, `status`, `cdate`) VALUES
(1, 'r.kikani@yahoo.com', 'Rahul', 'Kikani', '1650, Rene-Levesques', 'Montreal', 'Quebec', 'H3H2S1', '+14384023891', '3e117f25c3ea62d5baca51b8be6621e1.jpg', 'ABCD1234', 'inactive', '2014-04-08 17:31:11'),
(2, 'rahulk.kikani@yahoo.com', 'Radhe', 'K', '1650, Rene-Levesque', 'Montreal', 'Quebec', 'H3H2S1', '+14384023891', 'a0e2de344f27410cd59dda202eb0b4a2.jpg', 'ABCD1234', 'inactive', '2014-04-08 19:56:50'),
(3, 'billpay@bell.ca', 'Bell', 'Telephone', 'Montreal', 'Montreal', 'Quebec', 'H3H2S1', '+12345678900', 'b0110140b003ba6ebfed5a29a7f649be.jpg', 'ABCDEFG', 'active', '2014-04-08 23:09:07'),
(4, 'paybill@hydroquebec.com', 'Hydro', 'Quebec', 'Montreal', 'Montreal', 'Quebec', 'H3H2S1', '+12345678999', '75547086c3707756b0dfd4e95ac1eace.jpg', 'ABC1234', 'active', '2014-04-08 23:10:44'),
(5, 'radhe.krishna@mailinator.com', 'asdfasdf', 'asdfasdf', 'asdfasdf', 'safsadf', 'asdfsdf', 'asdfasdf', 'asdfasdfsdf', '053ded9416e00f494081c820912adc81.png', 'asdfasdf', 'inactive', '2014-04-12 17:13:41'),
(6, 'abcd.abcd@mailinator.com', 'kl', 'kljkl', 'klj', 'klj', 'kljlk', 'jlkj', 'klj', '8b9f253980bb46ab36c21b05186d76be.png', 'klj', 'inactive', '2014-04-12 17:21:56'),
(7, 'nassim.eghtesadi@gmail.com', 'nassim', 'egh', '90 colpron', 'chateauguay', 'quebec', 'j6j5p9', '514 659 3227', '82ffebb9d433db9377cd2f8e042633bc.gif', '222', 'active', '2014-04-12 21:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_security`
--

CREATE TABLE IF NOT EXISTS `user_security` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `question_id` int(4) NOT NULL,
  `uemail` varchar(255) NOT NULL,
  `secure_ans` varchar(255) NOT NULL,
  PRIMARY KEY (`uemail`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_security`
--

INSERT INTO `user_security` (`id`, `question_id`, `uemail`, `secure_ans`) VALUES
(3, 1003, 'nassim.eghtesadi@gmail.com', 'montreal'),
(2, 1001, 'r.kikani@yahoo.com', 'Rick');

-- --------------------------------------------------------

--
-- Table structure for table `virtual_money_card`
--

CREATE TABLE IF NOT EXISTS `virtual_money_card` (
  `ac_no` int(10) NOT NULL,
  `card_no` bigint(16) NOT NULL,
  `card_pin` int(6) NOT NULL,
  `card_end_date` date NOT NULL,
  `cvc_code` int(5) NOT NULL,
  `amount` float NOT NULL,
  `max_limit` float NOT NULL,
  `card_type` varchar(250) NOT NULL,
  `card_tax` float NOT NULL,
  `name_on_card` varchar(255) NOT NULL,
  `card_cdate` datetime NOT NULL,
  PRIMARY KEY (`ac_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `virtual_money_card`
--

INSERT INTO `virtual_money_card` (`ac_no`, `card_no`, `card_pin`, `card_end_date`, `cvc_code`, `amount`, `max_limit`, `card_type`, `card_tax`, `name_on_card`, `card_cdate`) VALUES
(15140001, 3222211110000, 8942, '2015-04-08', 767, 300, 0, 'Debit', 0, 'Rahul Kikani', '2014-04-08 18:11:53'),
(15140002, 3222211110001, 3266, '2015-04-08', 284, 0, 0, 'Debit', 0, 'Radhe K', '2014-04-08 19:58:04'),
(15140005, 3222211110002, 5351, '2015-04-08', 869, -75, 1000, 'Credit', 20.99, 'Rahul Kikani', '2014-04-08 23:52:55'),
(15140007, 3222211110003, 6441, '2015-04-12', 237, 0, 0, 'Debit', 0, 'nassim egh', '2014-04-12 21:05:39'),
(15140009, 3222211110004, 9484, '2015-04-13', 275, 10, 500, 'Credit', 19.99, 'nassim egh', '2014-04-13 15:22:59');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
