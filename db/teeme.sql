-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2015 at 04:17 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `instance`
--

-- --------------------------------------------------------

--
-- Table structure for table `teeme_admin`
--

CREATE TABLE IF NOT EXISTS `teeme_admin` (
`id` int(11) NOT NULL,
  `userName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `superAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `first_name` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `last_name` varchar(32) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teeme_backups`
--

CREATE TABLE IF NOT EXISTS `teeme_backups` (
`id` int(11) NOT NULL,
  `file_name` varchar(512) COLLATE latin1_general_ci NOT NULL,
  `file_size` float NOT NULL,
  `createdDate` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: Active 0:Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teeme_countries`
--

CREATE TABLE IF NOT EXISTS `teeme_countries` (
`countryId` int(11) NOT NULL,
  `countryName` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `countryCode` char(3) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `teeme_countries`
--

INSERT INTO `teeme_countries` (`countryId`, `countryName`, `countryCode`) VALUES
(1, 'Afghanistan', 'AFG'),
(2, 'Albania', 'ALB'),
(3, 'Algeria', 'DZA'),
(4, 'American Samoa', 'ASM'),
(5, 'Andorra', 'AND'),
(6, 'Angola', 'AGO'),
(7, 'Anguilla', 'AIA'),
(8, 'Antarctica', 'ATA'),
(9, 'Antigua and Barbuda', 'ATG'),
(10, 'Argentina', 'ARG'),
(11, 'Armenia', 'ARM'),
(12, 'Aruba', 'ABW'),
(13, 'Australia', 'AUS'),
(14, 'Austria', 'AUT'),
(15, 'Azerbaijan', 'AZE'),
(16, 'Bahamas', 'BHS'),
(17, 'Bahrain', 'BHR'),
(18, 'Bangladesh', 'BGD'),
(19, 'Barbados', 'BRB'),
(20, 'Belarus', 'BLR'),
(21, 'Belgium', 'BEL'),
(22, 'Belize', 'BLZ'),
(23, 'Benin', 'BEN'),
(24, 'Bermuda', 'BMU'),
(25, 'Bhutan', 'BTN'),
(26, 'Bolivia', 'BOL'),
(27, 'Bosnia and Herzegowina', 'BIH'),
(28, 'Botswana', 'BWA'),
(29, 'Bouvet Island', 'BVT'),
(30, 'Brazil', 'BRA'),
(31, 'British Indian Ocean Territory', 'IOT'),
(32, 'Brunei Darussalam', 'BRN'),
(33, 'Bulgaria', 'BGR'),
(34, 'Burkina Faso', 'BFA'),
(35, 'Burundi', 'BDI'),
(36, 'Cambodia', 'KHM'),
(37, 'Cameroon', 'CMR'),
(38, 'Canada', 'CAN'),
(39, 'Cape Verde', 'CPV'),
(40, 'Cayman Islands', 'CYM'),
(41, 'Central African Republic', 'CAF'),
(42, 'Chad', 'TCD'),
(43, 'Chile', 'CHL'),
(44, 'China', 'CHN'),
(45, 'Christmas Island', 'CXR'),
(46, 'Cocos (Keeling) Islands', 'CCK'),
(47, 'Colombia', 'COL'),
(48, 'Comoros', 'COM'),
(49, 'Congo', 'COG'),
(50, 'Cook Islands', 'COK'),
(51, 'Costa Rica', 'CRI'),
(52, 'Cote D''Ivoire', 'CIV'),
(53, 'Croatia', 'HRV'),
(54, 'Cuba', 'CUB'),
(55, 'Cyprus', 'CYP'),
(56, 'Czech Republic', 'CZE'),
(57, 'Denmark', 'DNK'),
(58, 'Djibouti', 'DJI'),
(59, 'Dominica', 'DMA'),
(60, 'Dominican Republic', 'DOM'),
(61, 'East Timor', 'TMP'),
(62, 'Ecuador', 'ECU'),
(63, 'Egypt', 'EGY'),
(64, 'El Salvador', 'SLV'),
(65, 'Equatorial Guinea', 'GNQ'),
(66, 'Eritrea', 'ERI'),
(67, 'Estonia', 'EST'),
(68, 'Ethiopia', 'ETH'),
(69, 'Falkland Islands (Malvinas)', 'FLK'),
(70, 'Faroe Islands', 'FRO'),
(71, 'Fiji', 'FJI'),
(72, 'Finland', 'FIN'),
(73, 'France', 'FRA'),
(74, 'France, Metropolitan', 'FXX'),
(75, 'French Guiana', 'GUF'),
(76, 'French Polynesia', 'PYF'),
(77, 'French Southern Territories', 'ATF'),
(78, 'Gabon', 'GAB'),
(79, 'Gambia', 'GMB'),
(80, 'Georgia', 'GEO'),
(81, 'Germany', 'DEU'),
(82, 'Ghana', 'GHA'),
(83, 'Gibraltar', 'GIB'),
(84, 'Greece', 'GRC'),
(85, 'Greenland', 'GRL'),
(86, 'Grenada', 'GRD'),
(87, 'Guadeloupe', 'GLP'),
(88, 'Guam', 'GUM'),
(89, 'Guatemala', 'GTM'),
(90, 'Guinea', 'GIN'),
(91, 'Guinea-bissau', 'GNB'),
(92, 'Guyana', 'GUY'),
(93, 'Haiti', 'HTI'),
(94, 'Heard and Mc Donald Islands', 'HMD'),
(95, 'Honduras', 'HND'),
(96, 'Hong Kong', 'HKG'),
(97, 'Hungary', 'HUN'),
(98, 'Iceland', 'ISL'),
(99, 'India', 'IND'),
(100, 'Indonesia', 'IDN'),
(101, 'Iran (Islamic Republic of)', 'IRN'),
(102, 'Iraq', 'IRQ'),
(103, 'Ireland', 'IRL'),
(104, 'Israel', 'ISR'),
(105, 'Italy', 'ITA'),
(106, 'Jamaica', 'JAM'),
(107, 'Japan', 'JPN'),
(108, 'Jordan', 'JOR'),
(109, 'Kazakhstan', 'KAZ'),
(110, 'Kenya', 'KEN'),
(111, 'Kiribati', 'KIR'),
(112, 'Korea, Democratic People''s Republic of', 'PRK'),
(113, 'Korea, Republic of', 'KOR'),
(114, 'Kuwait', 'KWT'),
(115, 'Kyrgyzstan', 'KGZ'),
(116, 'Lao People''s Democratic Republic', 'LAO'),
(117, 'Latvia', 'LVA'),
(118, 'Lebanon', 'LBN'),
(119, 'Lesotho', 'LSO'),
(120, 'Liberia', 'LBR'),
(121, 'Libyan Arab Jamahiriya', 'LBY'),
(122, 'Liechtenstein', 'LIE'),
(123, 'Lithuania', 'LTU'),
(124, 'Luxembourg', 'LUX'),
(125, 'Macau', 'MAC'),
(126, 'Macedonia', 'MKD'),
(127, 'Madagascar', 'MDG'),
(128, 'Malawi', 'MWI'),
(129, 'Malaysia', 'MYS'),
(130, 'Maldives', 'MDV'),
(131, 'Mali', 'MLI'),
(132, 'Malta', 'MLT'),
(133, 'Marshall Islands', 'MHL'),
(134, 'Martinique', 'MTQ'),
(135, 'Mauritania', 'MRT'),
(136, 'Mauritius', 'MUS'),
(137, 'Mayotte', 'MYT'),
(138, 'Mexico', 'MEX'),
(139, 'Micronesia, Federated States of', 'FSM'),
(140, 'Moldova, Republic of', 'MDA'),
(141, 'Monaco', 'MCO'),
(142, 'Mongolia', 'MNG'),
(143, 'Montserrat', 'MSR'),
(144, 'Morocco', 'MAR'),
(145, 'Mozambique', 'MOZ'),
(146, 'Myanmar', 'MMR'),
(147, 'Namibia', 'NAM'),
(148, 'Nauru', 'NRU'),
(149, 'Nepal', 'NPL'),
(150, 'Netherlands', 'NLD'),
(151, 'Netherlands Antilles', 'ANT'),
(152, 'New Caledonia', 'NCL'),
(153, 'New Zealand', 'NZL'),
(154, 'Nicaragua', 'NIC'),
(155, 'Niger', 'NER'),
(156, 'Nigeria', 'NGA'),
(157, 'Niue', 'NIU'),
(158, 'Norfolk Island', 'NFK'),
(159, 'Northern Mariana Islands', 'MNP'),
(160, 'Norway', 'NOR'),
(161, 'Oman', 'OMN'),
(162, 'Pakistan', 'PAK'),
(163, 'Palau', 'PLW'),
(164, 'Panama', 'PAN'),
(165, 'Papua New Guinea', 'PNG'),
(166, 'Paraguay', 'PRY'),
(167, 'Peru', 'PER'),
(168, 'Philippines', 'PHL'),
(169, 'Pitcairn', 'PCN'),
(170, 'Poland', 'POL'),
(171, 'Portugal', 'PRT'),
(172, 'Puerto Rico', 'PRI'),
(173, 'Qatar', 'QAT'),
(174, 'Reunion', 'REU'),
(175, 'Romania', 'ROM'),
(176, 'Russian Federation', 'RUS'),
(177, 'Rwanda', 'RWA'),
(178, 'Saint Kitts and Nevis', 'KNA'),
(179, 'Saint Lucia', 'LCA'),
(180, 'Saint Vincent and the Grenadines', 'VCT'),
(181, 'Samoa', 'WSM'),
(182, 'San Marino', 'SMR'),
(183, 'Sao Tome and Principe', 'STP'),
(184, 'Saudi Arabia', 'SAU'),
(185, 'Senegal', 'SEN'),
(186, 'Seychelles', 'SYC'),
(187, 'Sierra Leone', 'SLE'),
(188, 'Singapore', 'SGP'),
(189, 'Slovakia (Slovak Republic)', 'SVK'),
(190, 'Slovenia', 'SVN'),
(191, 'Solomon Islands', 'SLB'),
(192, 'Somalia', 'SOM'),
(193, 'South Africa', 'ZAF'),
(194, 'South Georgia', 'SGS'),
(195, 'Spain', 'ESP'),
(196, 'Sri Lanka', 'LKA'),
(197, 'St. Helena', 'SHN'),
(198, 'St. Pierre and Miquelon', 'SPM'),
(199, 'Sudan', 'SDN'),
(200, 'Suriname', 'SUR'),
(201, 'Svalbard and Jan Mayen Islands', 'SJM'),
(202, 'Swaziland', 'SWZ'),
(203, 'Sweden', 'SWE'),
(204, 'Switzerland', 'CHE'),
(205, 'Syrian Arab Republic', 'SYR'),
(206, 'Taiwan', 'TWN'),
(207, 'Tajikistan', 'TJK'),
(208, 'Tanzania, United Republic of', 'TZA'),
(209, 'Thailand', 'THA'),
(210, 'Togo', 'TGO'),
(211, 'Tokelau', 'TKL'),
(212, 'Tonga', 'TON'),
(213, 'Trinidad and Tobago', 'TTO'),
(214, 'Tunisia', 'TUN'),
(215, 'Turkey', 'TUR'),
(216, 'Turkmenistan', 'TKM'),
(217, 'Turks and Caicos Islands', 'TCA'),
(218, 'Tuvalu', 'TUV'),
(219, 'Uganda', 'UGA'),
(220, 'Ukraine', 'UKR'),
(221, 'United Arab Emirates', 'ARE'),
(222, 'United Kingdom', 'GBR'),
(223, 'United States', 'USA'),
(224, 'United States Minor Outlying Islands', 'UMI'),
(225, 'Uruguay', 'URY'),
(226, 'Uzbekistan', 'UZB'),
(227, 'Vanuatu', 'VUT'),
(228, 'Vatican City State (Holy See)', 'VAT'),
(229, 'Venezuela', 'VEN'),
(230, 'Viet Nam', 'VNM'),
(231, 'Virgin Islands (British)', 'VGB'),
(232, 'Virgin Islands (U.S.)', 'VIR'),
(233, 'Wallis and Futuna Islands', 'WLF'),
(234, 'Western Sahara', 'ESH'),
(235, 'Yemen', 'YEM'),
(236, 'Yugoslavia', 'YUG'),
(237, 'Zaire', 'ZAR'),
(238, 'Zambia', 'ZMB'),
(239, 'Zimbabwe', 'ZWE');

-- --------------------------------------------------------

--
-- Table structure for table `teeme_managers`
--

CREATE TABLE IF NOT EXISTS `teeme_managers` (
  `placeId` int(11) NOT NULL,
  `managerId` int(11) NOT NULL,
  `placeType` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teeme_timezones`
--

CREATE TABLE IF NOT EXISTS `teeme_timezones` ( 
	`timezoneid` int(11) NOT NULL DEFAULT '0', 
	`gmt_offset` double DEFAULT '0', 
	`dst_offset` double DEFAULT NULL,
 	`timezone_code` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL, 
	`timezone_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL, PRIMARY KEY (`timezoneid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `teeme_timezones`
--


INSERT INTO `teeme_timezones` (`timezoneid`, `gmt_offset`, `dst_offset`, `timezone_code`, `timezone_name`) VALUES 
(1, -12, 0, '', '(GMT-12:00) International Date Line West'),
(2, -11, 0, '', '(GMT-11:00) Midway Island Samoa'),
(3, -10, 0, 'H', '(GMT-10:00) Hawaii'),
(4, -9, 1, 'AK', '(GMT-09:00) Alaska'),
(5, -8, 1, 'P', '(GMT-08:00) Pacific Time (US & Canada) Tijuana'),
(6, -7, 0, 'M', '(GMT-07:00) Arizona'),
(7, -7, 1, '', '(GMT-07:00) Chihuahua, La Paz, Mazatlan'),
(8, -7, 1, 'M', '(GMT-07:00) Mountain Time (US & Canada)'),
(9, -6, 0, '', '(GMT-06:00) Central America'),
(10, -6, 1, 'C', '(GMT-06:00) Central Time (US & Canada)'),
(11, -6, 1, '', '(GMT-06:00) Guadalajara, Mexico City, Monterrey'),
(12, -6, 0, 'C', '(GMT-06:00) Saskatchewan'),
(13, -5, 0, '', '(GMT-05:00) Bogota, Lime, Quito'),
(14, -5, 1, 'E', '(GMT-05:00) Eastern Time (US & Canada)'),
(15, -5, 0, 'E', '(GMT-05:00) Indiana (East)'),
(16, -4, 1, 'A', '(GMT-04:00) Atlantic Time (Canada)'),
(17, -4, 0, '', '(GMT-04:00) Caracas, La Paz'),
(18, -4, 1, '', '(GMT-04:00) Santiago'),
(19, -3.5, 1, 'N', '(GMT-03:30) Newfoundland'),
(20, -3, 1, '', '(GMT-03:00) Brasilia'),
(21, -3, 0, '', '(GMT-03:00) Buenos Aires, Georgetown'),
(22, -3, 1, '', '(GMT-03:00) Greenland'),
(23, -2, 1, '', '(GMT-02:00) Mid-Atlantic'),
(24, -1, 1, '', '(GMT-01:00) Azores'),
(25, -1, 0, '', '(GMT-01:00) Cape Verde Is.'),
(26, 0, 0, '', '(GMT) Casablanca, Monrovia'),
(27, 0, 1, '', '(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London'),
(28, 1, 1, '', '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'),
(29, 1, 1, '', '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'),
(30, 1, 1, '', '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'),
(31, 1, 1, '', '(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb'),
(32, 1, 0, '', '(GMT+01:00) West Central Africa'),
(33, 2, 1, '', '(GMT+02:00) Athens, Istanbul, Minsk'),
(34, 2, 1, '', '(GMT+02:00) Bucharest'),
(35, 2, 1, '', '(GMT+02:00) Cairo'),
(36, 2, 0, '', '(GMT+02:00) Harare, Pretoria'),
(37, 2, 1, '', '(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius'),
(38, 2, 0, '', '(GMT+02:00) Jerusalem'),
(39, 3, 1, '', '(GMT+03:00) Baghdad'),
(40, 3, 0, '', '(GMT+03:00) Kuwait, Riyadh'),
(41, 3, 1, '', '(GMT+03:00) Moscow, St. Petersburg, Volgograd'),
(42, 3, 0, '', '(GMT+03:00) Nairobi'),
(43, 3.5, 1, '', '(GMT+03:30) Tehran'),
(44, 4, 0, '', '(GMT+04:00) Abu Dhabi, Muscat'),
(45, 4, 1, '', '(GMT+04:00) Baku, Tbilisi, Yerevan'),
(46, 4.5, 0, '', '(GMT+04:30) Kabul'),
(47, 5, 1, '', '(GMT+05:00) Ekaterinburg'),
(48, 5, 0, '', '(GMT+05:00) Islamabad, Karachi, Tashkent'),
(49, 5.5, 0, '', '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'),
(50, 5.75, 0, '', '(GMT+05.75) Kathmandu'),
(51, 6, 1, '', '(GMT+06:00) Almaty, Novosibirsk'),
(52, 6, 0, '', '(GMT+06:00) Astana, Dhaka'),
(53, 6, 0, '', '(GMT+06:00) Sri Jayawardenepura'),
(54, 6.5, 0, '', '(GMT+06:30) Rangoon'),
(55, 7, 0, '', '(GMT+07:00) Bangkok, Hanoi, Jakarta'),
(56, 7, 1, '', '(GMT+07:00) Krasnoyarsk'),
(57, 8, 0, '', '(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi'),
(58, 8, 1, '', '(GMT+08:00) Irkutsk, Ulaan Bataar'),
(59, 8, 0, '', '(GMT+08:00) Kuala Lumpur, Singapore'),
(60, 8, 0, '', '(GMT+08:00) Perth'),
(61, 8, 0, '', '(GMT+08:00) Taipei'),
(62, 9, 0, '', '(GMT+09:00) Osaka, Sapporo, Tokyo'),
(63, 9, 0, '', '(GMT+09:00) Seoul'),
(64, 9, 1, '', '(GMT+09:00) Yakutsk'),
(65, 9.5, 1, '', '(GMT+09:30) Adelaide'),
(66, 9.5, 0, '', '(GMT+09:30) Darwin'),
(67, 10, 0, '', '(GMT+10:00) Brisbane'),
(68, 10, 1, '', '(GMT+10:00) Canberra, Melbourne, Sydney'),
(69, 10, 0, '', '(GMT+10:00) Guam, Port Moresby'),
(70, 10, 1, '', '(GMT+10:00) Hobart'),
(71, 10, 1, '', '(GMT+10:00) Vladivostok'),
(72, 11, 0, '', '(GMT+11:00) Magadan, Solomon Is., New Caledonia'),
(73, 12, 1, '', '(GMT+12:00) Auckland, Wellington'),
(74, 12, 0, '', '(GMT+12:00) Figi, Kamchatka, Marshall Is.'),
(75, 13, 0, '', '(GMT+13:00) Nuku''alofa');

-- --------------------------------------------------------

--
-- Table structure for table `teeme_work_place`
--

CREATE TABLE IF NOT EXISTS `teeme_work_place` (
`workPlaceId` int(11) NOT NULL,
  `workPlaceManagerId` int(11) NOT NULL DEFAULT '0',
  `placeTimezone` smallint(6) DEFAULT NULL,
  `companyName` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `companyAddress1` varchar(512) COLLATE latin1_general_ci NOT NULL,
  `companyAddress2` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `companyCity` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `companyState` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `companyCountry` int(11) NOT NULL,
  `companyZip` int(11) NOT NULL,
  `companyPhone` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `companyFax` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `companyOther` text COLLATE latin1_general_ci,
  `companyStatus` tinyint(1) NOT NULL,
  `companyCreatedDate` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: Active 0: Suspended',
  `companyLogo` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'noimage.jpg',
  `server` varchar(512) COLLATE latin1_general_ci DEFAULT NULL,
  `server_username` varchar(512) COLLATE latin1_general_ci DEFAULT NULL,
  `server_password` varchar(512) COLLATE latin1_general_ci DEFAULT NULL,
  `instanceName` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teeme_admin`
--
ALTER TABLE `teeme_admin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teeme_backups`
--
ALTER TABLE `teeme_backups`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teeme_countries`
--
ALTER TABLE `teeme_countries`
 ADD PRIMARY KEY (`countryId`), ADD KEY `IDX_COUNTRIES_NAME` (`countryName`);

--
-- Indexes for table `teeme_timezones`
--

--
-- Indexes for table `teeme_work_place`
--
ALTER TABLE `teeme_work_place`
 ADD PRIMARY KEY (`workPlaceId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teeme_admin`
--
ALTER TABLE `teeme_admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teeme_backups`
--
ALTER TABLE `teeme_backups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teeme_countries`
--
ALTER TABLE `teeme_countries`
MODIFY `countryId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `teeme_work_place`
--
ALTER TABLE `teeme_work_place`
MODIFY `workPlaceId` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE IF NOT EXISTS `teeme_user_communities` (
`communityId` tinyint(2) NOT NULL,
  `communityName` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `teeme_user_communities` (`communityId`, `communityName`) VALUES
(1, 'Teeme'),
(2, 'Yahoo'),
(3, 'Gmail');

INSERT INTO `teeme_admin` (`id`, `userName`, `password`, `superAdmin`, `first_name`, `last_name`) VALUES 
('1', 'admin@teeme.net', '$2y$10$OX4ZTwKg0EJienk6jyf6qugFAiQD.6ko5AKjwaQ14CkwPBP6UJhoS', '1', 'admin', 'admin');

ALTER TABLE `teeme_work_place` ADD `NumOfUsers` VARCHAR(100) NOT NULL ;

ALTER TABLE `teeme_work_place` ADD `ExpireDate` DATE NOT NULL ;

CREATE TABLE `teeme_system_update` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `versionNumber` varchar(512) NOT NULL,
 `updateDate` datetime NOT NULL,
 `updateResult` varchar(20) NOT NULL,
 `notify_date` datetime NOT NULL,
 `notify` tinyint(11) NOT NULL DEFAULT '0' COMMENT '0: Off 1: On',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_config` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `config_option` varchar(22) NOT NULL,
 `config_value` VARCHAR(512) NOT NULL DEFAULT '0' COMMENT '0: Off 1: On',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `teeme_backups` ADD `remoteServer` VARCHAR(512) NOT NULL;

CREATE TABLE `teeme_users_trial` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `trial_request_time` datetime NOT NULL,
 `place_created_date` datetime NOT NULL,
 `place_expire_date` datetime NOT NULL,
 `ip` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
 `random_string` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `random_string_expire` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0->Not expire,1->Expired',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
