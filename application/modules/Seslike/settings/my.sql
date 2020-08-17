/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_seslike", "seslike", "SES - Professional Likes", "", '{"route":"admin_default","module":"seslike","controller":"settings"}', "core_admin_main_plugins", "", 999),
("seslike_admin_main_settings", "seslike", "Global Settings", "", '{"route":"admin_default","module":"seslike","controller":"settings"}', "seslike_admin_main", "", 1),
("seslike_admin_main_integrateothermodule", "seslike", "Integrated Plugins", "", '{"route":"admin_default","module":"seslike","controller":"integrateothermodules","action":"index"}', "seslike_admin_main", "", 2),
("seslike_admin_main_managepages", "seslike", "Widgetized Pages", "", '{"route":"admin_default","module":"seslike","controller":"settings", "action":"manage-widgetize-page"}', "seslike_admin_main", "", 999),
("core_main_seslike", "seslike", "Likes", "", '{"route":"seslike_general"}', "core_main", "", 4),
("seslike_main_home", "seslike", "Likes Home", "", '{"route":"seslike_general"}', "seslike_main", "", 1),
("seslike_main_manage", "seslike", "My Likes", "Seslike_Plugin_Menus::canLikeViewer", '{"route":"seslike_general","action":"mylikes"}', "seslike_main", "", 2),
("seslike_main_wholikeme", "seslike", "Who Likes Me", "Seslike_Plugin_Menus::canLikeViewer", '{"route":"seslike_general","action":"wholikeme"}', "seslike_main", "", 3),
("seslike_main_mycontent", "seslike", "My Content Likes", "Seslike_Plugin_Menus::canLikeViewer", '{"route":"seslike_general","action":"mycontentlike"}', "seslike_main", "", 4),
("seslike_main_myfriendcontent", "seslike", "My Friend\'s Likes", "Seslike_Plugin_Menus::canLikeViewer", '{"route":"seslike_general","action":"myfriendslike"}', "seslike_main", "", 5),
("seslike_main_mylikesettings", "seslike", "My Likes Settings", "Seslike_Plugin_Menus::canLikeViewerSettings", '{"route":"seslike_general","action":"mylikesettings"}', "seslike_main", "", 6);

INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
("seslike_main", "standard", "SES - Professional Likes Plugin - Main Navigation Menu");

DROP TABLE IF EXISTS `engine4_seslike_likes`;
CREATE TABLE IF NOT EXISTS `engine4_seslike_likes` (
  `like_id` int(11) unsigned NOT NULL auto_increment,
  `corelike_id` int(11) unsigned NOT NULL,
  `resource_type` varchar(32) NOT NULL,
  `resource_id` int(11) unsigned NOT NULL,
  `poster_type` varchar(32)  NOT NULL,
  `poster_id` int(11) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY  (`like_id`),
  KEY `resource_type` (`resource_type`, `resource_id`),
  KEY `poster_type` (`poster_type`, `poster_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;

INSERT IGNORE INTO engine4_seslike_likes (`corelike_id`, `resource_type`, `resource_id`, `poster_type`, `poster_id`, `creation_date`) SELECT `like_id`, `resource_type`, `resource_id`, `poster_type`, `poster_id`, NOW() FROM engine4_core_likes;

DROP TABLE IF EXISTS `engine4_seslike_integrateothersmodules`;
CREATE TABLE IF NOT EXISTS `engine4_seslike_integrateothersmodules` (
`integrateothersmodule_id` int(11) unsigned NOT NULL auto_increment,
`module_name` varchar(64) NOT NULL,
`content_type` varchar(64) NOT NULL,
`content_url` varchar(255) NOT NULL,
`content_id` varchar(64) NOT NULL,
`enabled` tinyint(1) NOT NULL,
`module_title` VARCHAR(255) NOT NULL,
PRIMARY KEY (`integrateothersmodule_id`),
UNIQUE KEY `content_type` (`content_type`,`content_id`),
KEY `module_name` (`module_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("like_user", "user", '{item:$object} liked you.', 0, "");

INSERT IGNORE INTO `engine4_seslike_integrateothersmodules` (`integrateothersmodule_id`, `module_name`, `content_type`, `content_url`, `content_id`, `enabled`, `module_title`) VALUES
(1, "album", "album", "", "album_id", 1, "Albums"),
(2, "album", "album_photo", "", "photo_id", 1, "Photos"),
(3, "blog", "blog", "", "blog_id", 1, "Blogs"),
(4, "classified", "classified", "", "classified_id", 1, "Classifieds"),
(5, "classified", "classified_photo", "", "photo_id", 1, "Classified Photos"),
(6, "event", "event", "", "event_id", 1, "Events"),
(7, "event", "event_photo", "", "photo_id", 1, "Event Photos"),
(8, "group", "group", "", "group_id", 1, "Groups"),
(9, "group", "group_photo", "", "photo_id", 1, "Group Photos"),
(10, "forum", "forum_topic", "", "topic_id", 1, "Forum Topics"),
(11, "music", "music_playlist", "", "playlist_id", 1, "Music"),
(12, "poll", "poll", "", "poll_id", 1, "Polls"),
(13, "video", "video", "", "video_id", 1, "Videos"),
(14, "user", "user", "", "user_id", 1, "Members"),
(15, "sesbusiness", "businesses", "", "business_id", 1, "Businesses"),
(16, "sesbusinessvideo", "businessvideo", "", "video_id", 1, "Business Videos"),
(19, "sesevent", "sesevent_event", "", "event_id", 1, "Events"),
(21, "sespage", "sespage_page", "", "page_id", 1, "Pages"),
(22, "sesarticle", "sesarticle", "", "article_id", 1, "Articles"),
(24, "sesgroup", "sesgroup_group", "", "group_id", 1, "Groups"),
(25, "sesalbum", "sesalbum_photo", "", "photo_id", 1, "Photos"),
(26, "sesalbum", "sesalbum_album", "", "album_id", 1, "Albums"),
(28, "sesqa", "sesqa_question", "", "question_id", 1, "Questions"),
(30, "sespagevideo", "pagevideo", "", "video_id", 1, "Page Videos"),
(31, "sespagereview", "pagereview", "", "review_id", 1, "Page Review"),
(32, "sesgroupvideo", "groupvideo", "", "video_id", 1, "Group Videos"),
(33, "sesquote", "sesquote_quote", "", "quote_id", 1, "Quotes"),
(34, "sescontest", "contest", "", "contest_id", 1, "Contests"),
(35, "seseventvideo", "seseventvideo_video", "", "video_id", 1, "Event Videos"),
(36, "sesmusic", "sesmusic_artists", "", "artist_id", 1, "Music Artists"),
(37, "sesmusic", "sesmusic_albums", "", "album_id", 1, "Music Albums"),
(38, "sesmusic", "sesmusic_albumsongs", "", "albumsong_id", 1, "Songs"),
(40, "sesvideo", "sesvideo_video", "", "video_id", 1, "Videos"),
(41, "sesblog", "sesblog_blog", "", "blog_id", 1, "Blogs"),
(42, "sesrecipe", "sesrecipe_recipe", "", "recipe_id", 1, "Recipe with Reviews"),
(43, "sestestimonial", "testimonial", "", "testimonial_id", 1, "Testimonials"),
(44, "sesthought", "sesthought_thought", "", "thought_id", 1, "Thoughts"),
(45, "sesprayer", "sesprayer_prayer", "", "prayer_id", 1, "Prayers"),
(46, "seswishe", "seswishe_wishe", "", "wishe_id", 1, "Wishes");


DROP TABLE IF EXISTS `engine4_seslike_mylikesettings`;
CREATE TABLE `engine4_seslike_mylikesettings` ( 
	`mylikesetting_id` int(11) unsigned NOT NULL auto_increment,
	`user_id` int(11) unsigned NOT NULL,
	`mylikesetting` TINYINT(1) NOT NULL DEFAULT "0",
	PRIMARY KEY (`mylikesetting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci;
