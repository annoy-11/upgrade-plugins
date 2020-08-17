INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('coursesalbum', 'Courses Album Extension ', '', '4.10.5', 1, 'extra') ;


INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("coursesalbum_admin_main_malm", "coursesalbum", "Courses Albums", "", '{"route":"admin_default","module":"coursesalbum","controller":"manage-album"}', "courses_admin_main", "", 11),
("coursesalbum_admin_main_mgphlbm", "coursesalbum", "Manage Albums", "", '{"route":"admin_default","module":"coursesalbum","controller":"manage-album"}', "coursesalbum_admin_main_malm", "", 1),
("coursesalbum_admin_main_mngpts", "coursesalbum", "Manage Photos", "", '{"route":"admin_default","module":"coursesalbum","controller":"manage-album","action":"photos"}', "coursesalbum_admin_main_malm", "", 2);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("coursesalbum_main_albumhome", "coursesalbum", "Courses Albums Home", "", '{"route":"coursesalbum_general","action":"home"}', "courses_main", "", 20),
("coursesalbum_main_albumbrowse", "coursesalbum", "Courses Browse Albums", "", '{"route":"coursesalbum_general","action":"browse"}', "courses_main", "", 21);

DROP TABLE IF EXISTS `engine4_courses_albums`;
CREATE TABLE `engine4_courses_albums` (
      `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `course_id` int(11) unsigned NOT NULL,
      `owner_id` int(11) UNSIGNED NOT NULL,
      `title` varchar(128) NOT NULL,
      `description` mediumtext NOT NULL,
      `type` VARCHAR(255) NULL,
      `creation_date` datetime NOT NULL,
      `modified_date` datetime NOT NULL,
      `search` tinyint(1) NOT NULL default "1",
      `photo_id` int(11) unsigned NOT NULL default "0",
      `view_count` int(11) unsigned NOT NULL default "0",
      `comment_count` int(11) unsigned NOT NULL default "0",
      `collectible_count` int(11) unsigned NOT NULL default "0",
      `like_count` int(11) NOT NULL DEFAULT "0",
      `position_cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `art_cover` int(11) NOT NULL DEFAULT "0",
      `featured` TINYINT(1) NOT NULL DEFAULT "0",
      `sponsored` TINYINT(1) NOT NULL DEFAULT "0",
      `favourite_count` int(11) UNSIGNED NOT NULL DEFAULT "0",
      PRIMARY KEY (`album_id`),
      KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `engine4_courses_photos`;
CREATE TABLE `engine4_courses_photos` (
    `photo_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `album_id` int(11) unsigned NOT NULL,
    `course_id` int(11) unsigned NOT NULL,
    `user_id` int(11) unsigned NOT NULL,
    `title` varchar(128) NOT NULL,
    `description` varchar(255) NOT NULL,
    `collection_id` int(11) unsigned NOT NULL,
    `file_id` int(11) unsigned NOT NULL,
    `creation_date` datetime NOT NULL,
    `modified_date` datetime NOT NULL,
    `view_count` int(11) UNSIGNED NOT NULL DEFAULT "0",
    `comment_count` int(11) UNSIGNED NOT NULL DEFAULT "0",
    `like_count` int(11) UNSIGNED NOT NULL DEFAULT "0",
    `order` int(11) NOT NULL DEFAULT "0",
    `position_cover` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `art_cover` int(11) NOT NULL DEFAULT "0",
    `favourite_count` int(11) UNSIGNED NOT NULL DEFAULT "0",
    `featured` TINYINT(1) NOT NULL DEFAULT "0",
    `sponsored` TINYINT(1) NOT NULL DEFAULT "0",
    PRIMARY KEY (`photo_id`),
    KEY `album_id` (`album_id`),
    KEY `course_id` (`course_id`),
    KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
  
