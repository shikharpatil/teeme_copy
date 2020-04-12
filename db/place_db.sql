CREATE TABLE `teeme_activity_completion_status` (
  `activityId` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `userId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_applied_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urlId` int(11) NOT NULL,
  `artifactId` int(11) NOT NULL,
  `artifactType` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `appliedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` float NOT NULL,
  `createdDate` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: Active 0:Inactive',
  `remoteServer` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `result` VARCHAR(512) NULL DEFAULT NULL,
  `execution_time` VARCHAR(512) NULL DEFAULT NULL,
  `creator_user_id` INT NULL DEFAULT NULL,
  `type` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_bookmark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bookmark_date` datetime NOT NULL,
  `bookmarked` int(11) NOT NULL DEFAULT '1' COMMENT '1 -> Yes, 0-> No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_chat_info` (
  `treeid` int(255) NOT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `activity_detail` mediumtext COLLATE utf8_unicode_ci,
  `chat_member` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `treeTypeId` int(11) NOT NULL,
  `allowStatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
)AUTO_INCREMENT=2 ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_configuration` (`id`, `treeTypeId`, `allowStatus`) VALUES
(1, 6, 0);

CREATE TABLE `teeme_contact_info` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `treeId` int(255) NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middlename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `landline` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `predecessor` int(255) DEFAULT NULL,
  `succesor` int(255) DEFAULT NULL,
  `comments` mediumtext COLLATE utf8_unicode_ci,
  `sharedStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Public, 2: Private',
  `workplaceId` int(11) DEFAULT NULL,
  `other` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_object_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=7 ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_object_types` (`id`, `name`) VALUES
(0, 'Post'),
(1, 'Document'),
(2, 'Talk'),
(3, 'Discussion'),
(4, 'Task'),
(5, 'Contact');

CREATE TABLE `teeme_create_tag_date` (
  `tagId` int(11) NOT NULL AUTO_INCREMENT,
  `taskCreateDate` date DEFAULT NULL,
  PRIMARY KEY (`tagId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_discussion_view` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `leafId` int(255) NOT NULL,
  `UserId` int(255) NOT NULL,
  `view_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_external_docs` (
  `docId` int(255) NOT NULL AUTO_INCREMENT,
  `workSpaceId` int(255) NOT NULL,
  `workSpaceType` tinyint(1) NOT NULL,
  `userId` int(255) NOT NULL,
  `folderId` int(11) NOT NULL DEFAULT '0',
  `docCaption` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `docName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_order` int(11) DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdDate` datetime NOT NULL,
  `orig_modified_date` DATETIME NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`docId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `workSpaceId` int(11) NOT NULL,
  `workSpaceType` tinyint(4) NOT NULL,
  `userId` int(11) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_group_shared` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postId` int(11) NOT NULL,
  `groupIds` varchar(100) CHARACTER SET latin1 NOT NULL,
  `groupUsers` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_language_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_option` varchar(22) CHARACTER SET latin1 NOT NULL,
  `config_value` varchar(512) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_leaf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leafParentId` int(11) NOT NULL DEFAULT '0',
  `type` tinyint(2) DEFAULT NULL,
  `authors` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedDate` datetime NOT NULL,
  `contents` longtext COLLATE utf8_unicode_ci,
  `latestContent` tinyint(1) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '1',
  `lockedStatus` tinyint(4) NOT NULL DEFAULT '0',
  `userLocked` int(11) DEFAULT NULL,
  `nodeId` int(255) DEFAULT NULL,
  `newVersionLeafId` int(11) NOT NULL DEFAULT '0',
  `leafStatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'publish',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `contents` (`contents`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_leaf_objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leaf_id` int(11) NOT NULL,
  `object_type` varchar(255) CHARACTER SET latin1 NOT NULL,
  `object_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_leaf_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leafId` int(11) NOT NULL,
  `treeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_leaf_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leaf_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1->seed, 2->leaf',
  `tree_id` int(11) NOT NULL,
  `updates` bigint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_leaf_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_leaf_unread` (
  `id` int(255) NOT NULL,
  `leafId` int(255) NOT NULL,
  `UserId` int(255) NOT NULL,
  `workPlaceId` int(255) NOT NULL,
  `workSpaceId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_links` (
  `linkId` bigint(20) NOT NULL,
  `treeId` bigint(20) NOT NULL,
  `artifactId` bigint(20) NOT NULL,
  `artifactType` tinyint(1) NOT NULL,
  `createdDate` datetime NOT NULL,
  `ownerId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_links_external` (
  `linkId` bigint(20) NOT NULL,
  `linkedDocId` bigint(20) NOT NULL,
  `artifactId` bigint(20) NOT NULL,
  `artifactType` tinyint(4) NOT NULL,
  `createdDate` datetime NOT NULL,
  `ownerId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_links_folder` (
  `linkId` bigint(20) NOT NULL,
  `linkedFolderId` bigint(20) NOT NULL,
  `artifactId` bigint(20) NOT NULL,
  `artifactType` tinyint(4) NOT NULL,
  `createdDate` datetime NOT NULL,
  `ownerId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_links_url` (
  `id` int(11) NOT NULL,
  `workSpaceId` int(11) NOT NULL,
  `workSpaceType` int(11) NOT NULL COMMENT '1:seed and 2:node',
  `ownerId` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_login_users` (
  `loginId` int(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `sessionId` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `loginTime` int(11) DEFAULT NULL,
  `loginStatus` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_managers` (
  `placeId` int(11) NOT NULL,
  `managerId` int(11) NOT NULL,
  `placeType` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_metering_place` (
  `id` int(11) NOT NULL,
  `lastUpdate` datetime NOT NULL,
  `dbSize` decimal(8,2) NOT NULL COMMENT 'size=MB',
  `importedFileSize` decimal(8,2) NOT NULL COMMENT 'size=MB',
  `membersCount` int(4) NOT NULL,
  `month` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_node` (
  `id` int(11) NOT NULL,
  `predecessor` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `successors` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `leafId` int(11) DEFAULT NULL,
  `tag` mediumtext COLLATE utf8_unicode_ci,
  `treeIds` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nodeOrder` int(11) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `nodeTitle` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `viewCalendar` tinyint(1) NOT NULL DEFAULT '0',
  `userId` int(11) NOT NULL DEFAULT '0',
  `workSpaceId` int(11) NOT NULL DEFAULT '0',
  `workSpaceType` int(11) NOT NULL DEFAULT '0',
  `chatSession` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1-> Started 2-> Stopeed 0->Default (Nothing)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notes_info` (
  `notesId` int(11) NOT NULL,
  `periodicOption` tinyint(2) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notes_users` (
  `notesId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `notification_type_id` int(11) NOT NULL,
  `notification_action_type_id` int(11) NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_action` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_notification_action` (`id`, `name`) VALUES
(1, 'add'),
(2, 'edit'),
(3, 'delete'),
(4, 'apply'),
(5, 'start'),
(6, 'stop'),
(7, 'activate'),
(8, 'suspend'),
(9, 'assign'),
(10, 'unassign'),
(11, 'move'),
(12, 'import'),
(13, 'comment'),
(14, 'new version'),
(15, 'share'),
(16, 'unshare'),
(17, 'reserve'),
(18, 'unreserve'),
(19, 'create');

CREATE TABLE `teeme_notification_data` (
  `id` int(11) NOT NULL,
  `notification_event_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `notification_data` varchar(512) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_dispatch` (
  `id` int(11) NOT NULL,
  `recepient_id` int(11) NOT NULL,
  `sent` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 -> Yes 0 -> No',
  `seen` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 -> Yes 0 -> No',
  `create_time` datetime NOT NULL,
  `sent_time` datetime NOT NULL,
  `notification_mode_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_events` (
  `id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `parent_tree_id` INT NOT NULL DEFAULT '0',
  `parent_object_id` int(11) NOT NULL DEFAULT '0',
  `object_id` int(11) NOT NULL,
  `object_instance_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `action_user_id` int(11) NOT NULL,
  `workSpaceId` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `workSpaceType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `notification_data_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_event_has_dispatch` (
  `id` int(11) NOT NULL,
  `notification_event_id` int(11) NOT NULL,
  `notification_dispatch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_follow` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_instance_id` int(11) NOT NULL,
  `preference` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1 -> Yes, 0-> No',
  `subscribed_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_language` (
  `id` int(11) NOT NULL,
  `language_full` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `language_short` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_notification_language` (`id`, `language_full`, `language_short`) VALUES
(1, 'english', 'eng'),
(2, 'japanese', 'jpn');

CREATE TABLE `teeme_notification_modes_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type_id` int(11) NOT NULL,
  `notification_priority_id` int(11) NOT NULL,
  `preference` tinyint(4) NOT NULL COMMENT '1 -> Yes, 0 -> No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_object` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_notification_object` (`id`, `name`) VALUES
(1, 'tree'),
(2, 'leaf'),
(3, 'post'),
(4, 'simple tag'),
(5, 'action tag'),
(6, 'contact tag'),
(7, 'link'),
(8, 'talk'),
(9, 'file'),
(10, 'space'),
(11, 'subspace'),
(12, 'place'),
(13, 'admin'),
(14, 'contributor'),
(15, 'user'),
(16, 'place manager'),
(17, 'folder');

CREATE TABLE `teeme_notification_object_meta` (
  `id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_instance_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_notification_priority` (
  `id` int(11) NOT NULL,
  `notification_priority` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_notification_priority` (`id`, `notification_priority`) VALUES
(1, 'Application'),
(2, 'Never'),
(3, '1 hour'),
(4, '24 hours');

CREATE TABLE `teeme_notification_template` (
  `id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `template_type_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_notification_template` (`id`, `object_id`, `action_id`, `template_id`, `template_type_id`) VALUES
(1, 1, 1, 1, 3),
(2, 1, 2, 2, 3),
(3, 1, 14, 3, 3),
(4, 1, 5, 4, 3),
(5, 1, 6, 5, 3),
(6, 1, 11, 6, 3),
(7, 14, 9, 7, 3),
(8, 14, 10, 8, 3),
(9, 2, 1, 9, 3),
(10, 2, 2, 10, 3),
(11, 3, 1, 11, 3),
(12, 3, 13, 12, 3),
(13, 4, 1, 13, 3),
(14, 4, 4, 14, 3),
(15, 4, 3, 15, 3),
(16, 5, 4, 16, 3),
(17, 5, 2, 17, 3),
(18, 5, 3, 18, 3),
(19, 6, 4, 19, 3),
(20, 6, 3, 20, 3),
(21, 7, 4, 21, 3),
(22, 7, 3, 22, 3),
(23, 8, 13, 23, 3),
(24, 9, 12, 24, 3),
(25, 9, 3, 25, 3),
(26, 10, 1, 26, 3),
(27, 10, 2, 27, 3),
(28, 10, 8, 28, 3),
(29, 10, 7, 29, 3),
(30, 11, 1, 30, 3),
(31, 11, 2, 31, 3),
(32, 11, 8, 32, 3),
(33, 11, 7, 33, 3),
(34, 12, 1, 34, 3),
(35, 12, 2, 35, 3),
(36, 12, 8, 36, 3),
(37, 12, 7, 37, 3),
(38, 16, 1, 38, 3),
(39, 16, 2, 39, 3),
(40, 16, 8, 40, 3),
(41, 16, 7, 41, 3),
(42, 15, 1, 42, 3),
(43, 15, 2, 43, 3),
(44, 15, 8, 44, 3),
(45, 15, 7, 45, 3),
(46, 15, 3, 46, 3),
(47, 13, 1, 47, 3),
(48, 13, 2, 48, 3),
(49, 13, 3, 49, 3),
(50, 5, 13, 50, 3),
(51, 1, 15, 51, 3),
(52, 1, 16, 52, 3),
(53, 2, 13, 53, 3),
(54, 2, 9, 54, 3),
(55, 2, 10, 55, 3),
(56, 3, 15, 56, 3),
(57, 3, 16, 57, 3),
(58, 2, 3, 58, 3),
(59, 2, 11, 59, 3),
(60, 17, 19, 60, 3),
(61, 3, 3, 61, 3),
(62, 2, 17, 62, 3),
(63, 2, 18, 63, 3),
(64, 1, 1, 1, 4),
(65, 1, 2, 73, 4),
(66, 1, 14, 64, 4),
(67, 1, 5, 4, 4),
(68, 1, 6, 5, 4),
(69, 1, 11, 6, 4),
(70, 14, 9, 65, 4),
(71, 14, 10, 66, 4),
(72, 2, 1, 67, 4),
(73, 2, 2, 68, 4),
(74, 3, 1, 11, 4),
(75, 3, 13, 12, 4),
(76, 4, 1, 78, 4),
(77, 4, 4, 14, 4),
(78, 4, 3, 15, 4),
(79, 5, 4, 16, 4),
(80, 5, 2, 17, 4),
(81, 5, 3, 18, 4),
(82, 6, 4, 19, 4),
(83, 6, 3, 20, 4),
(84, 7, 4, 21, 4),
(85, 7, 3, 22, 4),
(86, 8, 13, 74, 4),
(87, 9, 12, 24, 4),
(88, 9, 3, 25, 4),
(89, 10, 1, 26, 4),
(90, 10, 2, 27, 4),
(91, 10, 8, 28, 4),
(92, 10, 7, 29, 4),
(93, 11, 1, 30, 4),
(94, 11, 2, 31, 4),
(95, 11, 8, 32, 4),
(96, 11, 7, 33, 4),
(97, 12, 1, 34, 4),
(98, 12, 2, 35, 4),
(99, 12, 8, 36, 4),
(100, 12, 7, 37, 4),
(101, 16, 1, 38, 4),
(102, 16, 2, 39, 4),
(103, 16, 8, 40, 4),
(104, 16, 7, 41, 4),
(105, 15, 1, 42, 4),
(106, 15, 2, 43, 4),
(107, 15, 8, 44, 4),
(108, 15, 7, 45, 4),
(109, 15, 3, 46, 4),
(110, 13, 1, 47, 4),
(111, 13, 2, 48, 4),
(112, 13, 3, 49, 4),
(113, 5, 13, 50, 4),
(114, 1, 15, 51, 4),
(115, 1, 16, 77, 4),
(116, 2, 13, 72, 4),
(117, 2, 9, 54, 4),
(118, 2, 10, 75, 4),
(119, 3, 15, 56, 4),
(120, 3, 16, 57, 4),
(121, 2, 3, 69, 4),
(122, 2, 11, 70, 4),
(123, 17, 19, 60, 4),
(124, 3, 3, 61, 4),
(125, 2, 17, 62, 4),
(126, 2, 18, 71, 4),
(127, 17, 3, 76, 3),
(128, 17, 3, 76, 4);

CREATE TABLE `teeme_notification_type` (
  `id` int(11) NOT NULL,
  `notification_type` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_notification_type` (`id`, `notification_type`) VALUES
(1, 'All'),
(2, 'Personalized'),
(3, 'Notification'),
(4, 'Timeline'),
(5, 'Feed');

CREATE TABLE `teeme_place_collaboration` (
  `id` int(11) NOT NULL,
  `requestStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Pending -> 1, Finished -> 2',
  `authCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `requestDate` datetime NOT NULL,
  `collaborationStatus` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Pending -> , Approved -> 1, Rejected -> 2, Deactive -> 3',
  `lastActionDate` datetime NOT NULL,
  `originatorPlaceId` int(11) NOT NULL,
  `collaboratingPlaceId` int(11) NOT NULL,
  `requesterId` int(11) NOT NULL,
  `actionPerformerId` int(11) NOT NULL,
  `collaborationActiveDate` datetime NOT NULL,
  `collaborationDeactiveDate` datetime NOT NULL,
  `collaborationUserRequest` int(11) NOT NULL DEFAULT '0' COMMENT 'Not receive -> 0, Receive -> 1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_place_collaboration_users` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `collaborationWorkPlaceId` int(11) NOT NULL,
  `collaborationId` int(11) NOT NULL,
  `userName` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `tagName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `requestDate` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 -> Not Approve, 1 -> Approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_posts_shared` (
  `id` bigint(20) NOT NULL,
  `postId` bigint(20) NOT NULL,
  `members` mediumtext CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_post_change` (
  `id` int(11) NOT NULL,
  `change_type` varchar(512) COLLATE utf8_unicode_ci NOT NULL COMMENT '''2 -> new comment''',
  `change_date` datetime NOT NULL,
  `node_id` int(255) NOT NULL,
  `change_user_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `space_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_selection_tag` (
  `selectionId` int(255) NOT NULL,
  `tagId` int(255) NOT NULL,
  `selectionOptions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_simple_tag` (
  `tagId` int(11) NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `selectedOption` int(255) NOT NULL DEFAULT '0',
  `createdDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_sub_work_space` (
  `subWorkSpaceId` int(11) NOT NULL,
  `workSpaceId` int(11) NOT NULL,
  `subWorkSpaceManagerId` int(11) NOT NULL,
  `subWorkSpaceName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subWorkSpaceCreatedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `status1` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_sub_work_space_members` (
  `subWorkSpaceMembersId` int(11) NOT NULL,
  `subWorkSpaceId` int(11) NOT NULL,
  `subWorkSpaceUserId` int(11) NOT NULL,
  `subWorkSpaceUserAccess` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_tag` (
  `tagId` int(255) NOT NULL,
  `tagType` tinyint(4) NOT NULL,
  `tag` int(11) NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ownerId` int(255) NOT NULL,
  `artifactId` int(255) NOT NULL,
  `artifactType` tinyint(2) NOT NULL,
  `createdDate` datetime NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `sequenceTagId` int(11) NOT NULL DEFAULT '0',
  `sequenceOrder` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_tagged_users` (
  `tagId` int(255) NOT NULL,
  `userId` int(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_tag_category` (
  `categoryId` int(11) NOT NULL,
  `categoryName` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_tag_category` (`categoryId`, `categoryName`) VALUES
(1, 'Time'),
(2, 'View'),
(3, 'Act'),
(4, 'Create'),
(5, 'Contact'),
(6, 'User');

CREATE TABLE `teeme_tag_types` (
  `tagTypeId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `tagType` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `systemTag` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `workPlaceId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `teeme_tag_types` (`tagTypeId`, `categoryId`, `tagType`, `systemTag`, `workPlaceId`) VALUES
(1, 2, 'red', '1', 0),
(2, 2, 'green', '1', 0),
(3, 2, 'yellow', '1', 0),
(4, 2, 'blue', '1', 0),
(5, 2, 'gray', '1', 0);

CREATE TABLE `teeme_tasks` (
  `tagId` int(11) NOT NULL,
  `noteId` int(11) NOT NULL,
  `createdDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_task_history` (
  `id` int(11) NOT NULL,
  `treeId` int(11) NOT NULL,
  `workSpaceId` int(11) NOT NULL,
  `workSpaceType` int(11) NOT NULL,
  `nodeId` int(11) NOT NULL,
  `contents` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `assignedTo` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `complitionStatus` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(11) NOT NULL,
  `editTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_templates` (
  `id` int(11) NOT NULL,
  `template` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `teeme_templates` (`id`, `template`) VALUES
(1, 'txt_new_tree_is_created_by'),
(2, 'txt_tree_edited_by'),
(3, 'txt_tree_new_version_created_by'),
(4, 'txt_tree_started_by'),
(5, 'txt_tree_stopped_by'),
(6, 'txt_tree_moved_by'),
(7, 'txt_contributor_assigned_by '),
(8, 'txt_contributor_removed_by '),
(9, 'txt_leaf_created_by'),
(10, 'txt_leaf_edited_by'),
(11, 'txt_post_added_by '),
(12, 'txt_post_comment_added_by '),
(13, 'txt_simple_tag_created_by '),
(14, 'txt_simple_tag_applied_by '),
(15, 'txt_simple_tag_removed_by '),
(16, 'txt_action_tag_applied_by '),
(17, 'txt_action_tag_edited_by '),
(18, 'txt_action_tag_deleted_by '),
(19, 'txt_contact_tag_applied_by '),
(20, 'txt_contact_tag_removed_by'),
(21, 'txt_link_applied_by'),
(22, 'txt_link_removed_by'),
(23, 'txt_talk_comment_added_by '),
(24, 'txt_file_imported_by '),
(25, 'txt_file_deleted_by '),
(26, 'txt_space_created_by'),
(27, 'txt_space_edited_by '),
(28, 'txt_space_suspended_by '),
(29, 'txt_space_activated_by '),
(30, 'txt_subspace_created_by'),
(31, 'txt_subspace_edited_by '),
(32, 'txt_subspace_suspended_by '),
(33, 'txt_subspace_activated_by '),
(34, 'txt_place_created_by '),
(35, 'txt_place_edited_by'),
(36, 'txt_place_suspended_by '),
(37, 'txt_place_activated_by '),
(38, 'txt_place_manager_created_by '),
(39, 'txt_place_manager_edited_by '),
(40, 'txt_place_manager_suspended_by '),
(41, 'txt_place_manager_activated_by'),
(42, 'txt_member_created_by '),
(43, 'txt_member_edited_by'),
(44, 'txt_member_suspended_by '),
(45, 'txt_member_activated_by'),
(46, 'txt_member_deleted_by '),
(47, 'txt_admin_added_by'),
(48, 'txt_admin_edited_by '),
(49, 'txt_admin_deleted_by '),
(50, 'txt_action_tag_response_added_by'),
(51, 'txt_tree_shared_by'),
(52, 'txt_tree_unshared_by'),
(53, 'txt_leaf_comment_added_by'),
(54, 'txt_leaf_task_assigned_by'),
(55, 'txt_leaf_task_unassigned_by'),
(56, 'txt_post_shared_by'),
(57, 'txt_post_unshared_by'),
(58, 'txt_leaf_deleted_by'),
(59, 'txt_leaf_moved_by'),
(60, 'txt_folder_created_by'),
(61, 'txt_post_deleted_by'),
(62, 'txt_leaf_reserve_by'),
(63, 'txt_leaf_unreserve_by'),
(64, 'timeline_txt_tree_new_version_created_by'),
(65, 'timeline_txt_contributor_assigned_by'),
(66, 'timeline_txt_contributor_removed_by'),
(67, 'timeline_txt_leaf_created_by'),
(68, 'timeline_txt_leaf_edited_by'),
(69, 'timeline_txt_leaf_deleted_by'),
(70, 'timeline_txt_leaf_moved_by'),
(71, 'timeline_txt_leaf_unreserve_by'),
(72, 'timeline_txt_leaf_comment_added_by'),
(73, 'timeline_txt_tree_edited_by'),
(74, 'timeline_txt_talk_comment_added_by'),
(75, 'timeline_txt_leaf_task_unassigned_by'),
(76, 'txt_folder_deleted_by'),
(77, 'timeline_txt_tree_unshared_by'),
(78, 'timeline_txt_simple_tag_created_by');

CREATE TABLE `teeme_timezones` (
  `timezoneid` int(11) NOT NULL DEFAULT '0',
  `gmt_offset` double DEFAULT '0',
  `dst_offset` double DEFAULT NULL,
  `timezone_code` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

CREATE TABLE `teeme_tree` (
  `id` int(11) NOT NULL,
  `parentTreeId` int(255) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(2) NOT NULL,
  `userId` int(11) NOT NULL,
  `createdDate` datetime NOT NULL,
  `editedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `workspaces` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workSpaceType` tinyint(1) NOT NULL DEFAULT '0',
  `nodes` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nodeType1` tinyint(1) NOT NULL DEFAULT '0',
  `nodeType` tinyint(1) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '1',
  `latestVersion` tinyint(1) NOT NULL DEFAULT '1',
  `treeVersion` int(11) NOT NULL DEFAULT '1',
  `viewCalendar` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `old_name1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `embedded` tinyint(4) NOT NULL DEFAULT '0',
  `updateCount` int(11) NOT NULL DEFAULT '0',
  `isShared` tinyint(4) NOT NULL DEFAULT '0',
  `autonumbering` tinyint(4) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '1' COMMENT '1 for anywhere, 2 for top, 3 for bottom, 4 for top and bottom'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_trees_shared` (
  `id` bigint(20) NOT NULL,
  `treeId` bigint(20) NOT NULL,
  `members` mediumtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_tree_enabled` (
  `id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `space_type` int(11) NOT NULL COMMENT '1 -> space, 2 -> subspace',
  `tree_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_users` (
  `userId` int(11) NOT NULL,
  `workPlaceId` int(11) NOT NULL DEFAULT '0',
  `userName` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `needPasswordReset` tinyint(4) DEFAULT '0',
  `tagName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userCommunityId` tinyint(2) NOT NULL,
  `userTitle` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstName` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastName` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `skills` varchar(512) CHARACTER SET utf8 NOT NULL,
  `department` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `emailSent` tinyint(1) NOT NULL DEFAULT '0',
  `registeredDate` datetime NOT NULL,
  `activation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastLoginTime` datetime DEFAULT NULL,
  `currentLoginTime` datetime DEFAULT NULL,
  `passwordreset` int(1) NOT NULL DEFAULT '1',
  `photo` varchar(512) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noimage.jpg',
  `statusUpdate` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `other` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `userGroup` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0->Guests,1->Normal Members',
  `isPlaceManager` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `notification_language_id` int(11) NOT NULL,
  `defaultSpace` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `userTimezone` smallint(6) DEFAULT NULL,
  `nickName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `terms` tinyint(4) NOT NULL DEFAULT '0',
  `isChildPlace` tinyint(4) NOT NULL DEFAULT '0',
  `parentPlaceId` int(11) NOT NULL,
  `loggedInToken` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_user_configuration` (
  `id` int(11) NOT NULL,
  `userId` int(255) NOT NULL,
  `editorOption` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `defaultSpace` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `teeme_vote_tag` (
  `votingTopicId` int(255) NOT NULL,
  `tagId` int(255) NOT NULL,
  `votingTopic` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_work_space` (
  `workSpaceId` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `workPlaceId` int(11) NOT NULL,
  `workSpaceName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `workSpaceCreatedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `treeAccess` int(11) NOT NULL DEFAULT '0' COMMENT '0 for space manages, and 1 for all users(space manages+member)',
  `defaultPlaceManagerSpace` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes',
  `workSpaceCreatorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `teeme_work_space_members` (
  `workSpaceMembersId` int(255) NOT NULL,
  `workSpaceId` int(255) NOT NULL,
  `workSpaceUserId` int(255) NOT NULL,
  `workSpaceUserAccess` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `teeme_chat_info`
  ADD PRIMARY KEY (`treeid`);

ALTER TABLE `teeme_leaf_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_leaf_unread`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_links`
  ADD PRIMARY KEY (`linkId`);

ALTER TABLE `teeme_links_external`
  ADD PRIMARY KEY (`linkId`);

ALTER TABLE `teeme_links_folder`
  ADD PRIMARY KEY (`linkId`);

ALTER TABLE `teeme_links_url`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_login_users`
  ADD PRIMARY KEY (`loginId`);

ALTER TABLE `teeme_metering_place`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_node`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_action`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_data`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_dispatch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recepient_mode_index` (`recepient_id`,`notification_mode_id`);

ALTER TABLE `teeme_notification_events`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_event_has_dispatch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dispatch_index` (`notification_dispatch_id`);

ALTER TABLE `teeme_notification_follow`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_language`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_modes_user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_object`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_object_meta`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_priority`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_template`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_notification_type`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_place_collaboration`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_place_collaboration_users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_posts_shared`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_post_change`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_selection_tag`
  ADD PRIMARY KEY (`selectionId`);

ALTER TABLE `teeme_sub_work_space`
  ADD PRIMARY KEY (`subWorkSpaceId`);

ALTER TABLE `teeme_sub_work_space_members`
  ADD PRIMARY KEY (`subWorkSpaceMembersId`);

ALTER TABLE `teeme_tag`
  ADD PRIMARY KEY (`tagId`);

ALTER TABLE `teeme_tag_category`
  ADD PRIMARY KEY (`categoryId`);

ALTER TABLE `teeme_tag_types`
  ADD PRIMARY KEY (`tagTypeId`);

ALTER TABLE `teeme_task_history`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_templates`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_timezones`
  ADD PRIMARY KEY (`timezoneid`);

ALTER TABLE `teeme_tree`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `teeme_tree` ADD FULLTEXT KEY `name` (`name`);

ALTER TABLE `teeme_trees_shared`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_tree_enabled`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_users`
  ADD PRIMARY KEY (`userId`);
ALTER TABLE `teeme_users` ADD FULLTEXT KEY `userName` (`userName`,`tagName`,`firstName`,`lastName`,`department`,`address1`,`address2`,`city`,`state`,`country`,`other`,`statusUpdate`);

ALTER TABLE `teeme_user_configuration`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `teeme_vote_tag`
  ADD PRIMARY KEY (`votingTopicId`);

ALTER TABLE `teeme_work_space`
  ADD PRIMARY KEY (`workSpaceId`);

ALTER TABLE `teeme_work_space_members`
  ADD PRIMARY KEY (`workSpaceMembersId`);

ALTER TABLE `teeme_leaf_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_leaf_unread`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_links`
  MODIFY `linkId` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_links_external`
  MODIFY `linkId` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_links_folder`
  MODIFY `linkId` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_links_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_login_users`
  MODIFY `loginId` int(255) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_metering_place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
ALTER TABLE `teeme_notification_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_dispatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_event_has_dispatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_follow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `teeme_notification_modes_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
ALTER TABLE `teeme_notification_object_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_notification_priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `teeme_notification_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
ALTER TABLE `teeme_notification_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `teeme_place_collaboration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_place_collaboration_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_posts_shared`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_post_change`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_selection_tag`
  MODIFY `selectionId` int(255) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_sub_work_space`
  MODIFY `subWorkSpaceId` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_sub_work_space_members`
  MODIFY `subWorkSpaceMembersId` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_tag`
  MODIFY `tagId` int(255) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_tag_category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `teeme_tag_types`
  MODIFY `tagTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `teeme_task_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
ALTER TABLE `teeme_tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_trees_shared`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_tree_enabled`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_user_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_vote_tag`
  MODIFY `votingTopicId` int(255) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_work_space`
  MODIFY `workSpaceId` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `teeme_work_space_members`
  MODIFY `workSpaceMembersId` int(255) NOT NULL AUTO_INCREMENT;

CREATE TABLE `teeme_post_web_groups` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(512) NULL DEFAULT NULL , `description` VARCHAR(512) NULL DEFAULT NULL , `profile_pic` VARCHAR(512) NULL DEFAULT 'noimage.jpg' , `creator_id` INT NULL DEFAULT NULL , `created_timestamp` DATETIME NULL DEFAULT CURRENT_TIMESTAMP , `status` TINYINT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `teeme_post_web_group_participants` ( `id` INT NOT NULL AUTO_INCREMENT , `group_id` INT NOT NULL DEFAULT '0' , `participant_id` INT NOT NULL DEFAULT '0' , `added_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP , `creator_id` INT NULL DEFAULT '0' , `status_id` TINYINT NULL DEFAULT '1' , `is_admin` TINYINT NULL DEFAULT '0', PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `teeme_post_web_group_status` ( `id` TINYINT NOT NULL AUTO_INCREMENT , `status` VARCHAR(256) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `teeme_post_web_post_types` ( `id` INT NOT NULL AUTO_INCREMENT , `post_type` VARCHAR(256) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `teeme_post_web_post_store` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `post_id` INT NULL DEFAULT NULL , `post_type_id` INT NULL DEFAULT NULL , `post_type_object_id` INT NULL DEFAULT NULL , `participant_id` INT NULL DEFAULT NULL , `sender_id` INT NULL DEFAULT NULL , `delivery_status_id` TINYINT NULL DEFAULT NULL , `seen_status` BOOLEAN NULL DEFAULT FALSE , `sent_timestamp` DATETIME NULL DEFAULT CURRENT_TIMESTAMP , `data` TEXT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
CREATE TABLE `teeme_post_web_delivery_status` ( `id` TINYINT NOT NULL AUTO_INCREMENT , `status` VARCHAR(256) NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
INSERT INTO `teeme_post_web_group_status` (`id`, `status`) VALUES ('1', 'joined'), ('2', 'left'), ('3', 'suspended');
INSERT INTO `teeme_post_web_post_types` (`id`, `post_type`) VALUES ('1', 'one-to-one'), ('2', 'space'), ('3', 'subspace'), ('4', 'group');
INSERT INTO `teeme_post_web_delivery_status` (`id`, `status`) VALUES ('1', 'delivered'), ('2', 'received');