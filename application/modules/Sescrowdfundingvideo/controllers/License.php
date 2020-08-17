<?php

//folder name or directory name.
$module_name = 'sescrowdfundingvideo';

//product title and module title.
$module_title = 'Crowdfunding Videos Extension';

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {

  $postdata = array();
//domain name
  $postdata['domain_name'] = $_SERVER['HTTP_HOST'];
//license key
  $postdata['licenseKey'] = @base64_encode($_POST['sescrowdfundingvideo_licensekey']);
  $postdata['module_name'] = @base64_encode($module_name);
  $postdata['module_title'] = @base64_encode($module_title);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "http://www.socialenginesolutions.com/licensenewcheck.php");


  curl_setopt($ch, CURLOPT_POST, 1);

// in real life you should use something like:
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

// receive server response ...
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec($ch);
  $output = explode(" sesquerysql ",$server_output);
  $error = 0;
  if (curl_error($ch)) {
    $error = 1;
  }
  curl_close($ch);

  //Here we can set some variable for checking in plugin files.
  //if ($output[0] == "OK" && $error != 1) {
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
      $sql = @$output[1];
      $results = explode(';', $sql);
      foreach ($results as $result) {
        if (!empty($result)) {
          $db->query($result);
        }
      }

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingvideo_ratings`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfundingvideo_ratings` (
        `rating_id`  int(11) unsigned NOT NULL auto_increment,
	      `crowdfundingvideo_id` INT( 11 ) NOT NULL,
        `resource_id` int(11) NOT NULL,
        `resource_type` varchar(128) NOT NULL,
        `user_id` int(9) unsigned NOT NULL,
        `rating` tinyint(1) unsigned DEFAULT NULL,
        `creation_date` DATETIME NOT NULL ,
        PRIMARY KEY  (`rating_id`),
        UNIQUE KEY `uniqueKey` (`user_id`,`resource_type`,`resource_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingvideo_videos`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfundingvideo_videos` (
        `crowdfundingvideo_id` int(11) unsigned NOT NULL auto_increment,
        `title` varchar(100) NOT NULL,
        `description` text NOT NULL,
        `search` tinyint(1) NOT NULL default 1,
        `owner_type` varchar(128) NOT NULL,
        `owner_id` int(11) NOT NULL,
        `parent_type` varchar(128) default NULL,
        `parent_id` int(11) unsigned default NULL,
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        `view_count` int(11) unsigned NOT NULL default 0,
        `favourite_count` int(11) unsigned NOT NULL default 0,
        `comment_count` int(11) unsigned NOT NULL default 0,
        `like_count` int(11) unsigned NOT NULL default 0,
        `type` varchar (255) default NULL,
        `code` text NOT NULL,
        `location` varchar (255) default NULL,
        `photo_id` int(11) unsigned default NULL,
        `rating` float NOT NULL,
        `thumbnail_id` int(11) unsigned default NULL,
        `is_locked` tinyint(1) unsigned  NULL default 0,
        `password` VARCHAR(255) default NULL,
        `status` tinyint(1) NOT NULL,
        `file_id` int(11) unsigned NOT NULL,
        `duration` int(9) unsigned NOT NULL,
        `approve` TINYINT(1) NOT NULL DEFAULT "1",
        `rotation` smallint unsigned NOT NULL DEFAULT 0,
        `is_sponsored` tinyint(1) unsigned NOT NULL DEFAULT 0,
        `is_featured` tinyint(1) unsigned NOT NULL DEFAULT 0,
        `is_hot` tinyint(1) unsigned NOT NULL DEFAULT 0,
        `offtheday` tinyint(1)	NOT NULL DEFAULT "0",
        `starttime` DATE DEFAULT NULL,
        `endtime` DATE DEFAULT NULL,
        `ip_address` VARCHAR(45)  NULL,
         PRIMARY KEY  (`crowdfundingvideo_id`),
         KEY `owner_id` (`owner_id`,`owner_type`),
         KEY `search` (`search`),
         KEY `creation_date` (`creation_date`),
         KEY `view_count` (`view_count`)
      )ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;');

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingvideo_watchlaters`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfundingvideo_watchlaters` (
				`watchlater_id` int(11) unsigned NOT NULL auto_increment,
				`crowdfundingvideo_id` int(11) unsigned NOT NULL,
				`owner_id` int(11) unsigned NOT NULL,
				`creation_date` datetime NOT NULL,
				`modified_date` datetime NOT NULL,
				PRIMARY KEY  (`watchlater_id`),
				UNIQUE KEY `uniqueKey` (`crowdfundingvideo_id`,`owner_id`),
				KEY `creation_date` (`creation_date`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;');

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingvideo_favourites`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sescrowdfundingvideo_favourites` (
				`favourite_id` int(11) unsigned NOT NULL auto_increment,
				`user_id` int(11) unsigned NOT NULL,
				`resource_type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
				`resource_id` int(11) NOT NULL,
				 PRIMARY KEY (`favourite_id`),
				 KEY `user_id` (`user_id`,`resource_type`,`resource_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

      $db->query('DROP TABLE IF EXISTS `engine4_sescrowdfundingvideo_recentlyviewitems`;');
      $db->query('CREATE TABLE IF NOT EXISTS  `engine4_sescrowdfundingvideo_recentlyviewitems` (
			`recentlyviewed_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`resource_id` INT NOT NULL ,
			`resource_type` VARCHAR(64) NOT NULL DEFAULT "album",
			`owner_id` INT NOT NULL ,
			`creation_date` DATETIME NOT NULL,
			UNIQUE KEY `uniqueKey` (`resource_id`,`resource_type`, `owner_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');


			$db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`,  `body`,  `enabled`,  `displayable`,  `attachable`,  `commentable`,  `shareable`, `is_generated`) VALUES
      ("sescrowdfundingvideo_new", "sescrowdfundingvideo", \'{item:$subject} posted a new video:\', "1", "5", "1", "3", "1", 0),
      ("comment_video", "sescrowdfundingvideo", \'{item:$subject} commented on {item:$owner}\'\'s {item:$object:video}: {body:$body}\', 1, 1, 1, 1, 1, 0);');
			$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("sescrowdfundingvideo_approved", "sescrowdfundingvideo", \'Your {item:$object:video} is approved by the administrator and is ready to be viewed.\', 0, ""),
      ("sescrowdfundingvideo_disapproved", "sescrowdfundingvideo", \'Your {item:$object:video} is disapproved by administrator.\', 0, "");');
			$db->query('INSERT IGNORE INTO `engine4_core_jobtypes` (`title`, `type`, `module`, `plugin`, `enabled`, `multi`, `priority`) VALUES
      ("Page Videos Extension", "sescrowdfundingvideo_encode", "sescrowdfundingvideo", "Sescrowdfundingvideo_Plugin_Job_Encode", 1, 2, 75),
      ("Page Videos Extension Rebuild Video Privacy", "sescrowdfundingvideo_maintenance_rebuild_privacy", "sescrowdfundingvideo", "Sescrowdfundingvideo_Plugin_Job_Maintenance_RebuildPrivacy", 1, 1, 50);');

			$db->query('INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
      ("sescrowdfundingvideo_main", "standard", "Page Videos Extension Main Navigation Menu");');

			$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sescrowdfundingvideo_main_browsehome", "sescrowdfundingvideo", "Videos", "", \'{"route":"sescrowdfundingvideo_general","action":"home"}\', "sescrowdfunding_main", "", 21),
      ("sescrowdfundingvideo_admin_main_utility", "sescrowdfundingvideo", "Video Utilities", "", \'{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings","action":"utility"}\',"sescrowdfundingvideo_admin_main", "", 2),
      ("sescrowdfundingvideo_admin_main_manage", "sescrowdfundingvideo", "Manage Videos", "", \'{"route":"admin_default","module":"sescrowdfundingvideo","controller":"manage"}\', "sescrowdfundingvideo_admin_main", "", 3),
      ("sescrowdfundingvideo_admin_main_level", "sescrowdfundingvideo", "Member Level Settings", "", \'{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings","action":"level"}\', "sescrowdfundingvideo_admin_main", "", 8),
      ("sescrowdfundingvideo_admin_main_level_video", "sescrowdfundingvideo", "Video Member Level Settings", "", \'{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings","action":"level"}\', "sescrowdfundingvideo_admin_level", "", 1),
      ("sescrowdfundingvideo_admin_main_statistic", "sescrowdfundingvideo", "Statistics", "", \'{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings","action":"statistic"}\', "sescrowdfundingvideo_admin_main", "", 11),
      ("sescrowdfundingvideo_admin_main_managepages", "sescrowdfundingvideo", "Widgetized Pages", "", \'{"route":"admin_default","module":"sescrowdfundingvideo","controller":"settings", "action":"manage-widgetize-page"}\', "sescrowdfundingvideo_admin_main", "", 12);');

			$db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`,  `body`,  `enabled`,  `displayable`,  `attachable`,  `commentable`,  `shareable`, `is_generated`) VALUES
      ("sespgvido_crte", "sescrowdfundingvideo", \'{item:$subject} posted a new video {item:$object}:\', "1", "5", "1", "3", "1", 0),
      ("sespgvido_fav", "sescrowdfundingvideo", \'{item:$subject} added video {item:$object} to favorite:\', 1, 5, 1, 1, 1, 1),
      ("sespgvido_rating", "sescrowdfundingvideo", \'{item:$subject} rated video {item:$object}:\', 1, 5, 1, 1, 1, 1),
      ("comment_video", "sescrowdfundingvideo", \'{item:$subject} commented on {item:$owner}\'\'s {item:$object:video}: {body:$body}\', 1, 1, 1, 1, 1, 0);');
			$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("sescrowdfundingvideo_processed", "sescrowdfundingvideo", \'Your {item:$object:video} is ready to be viewed.\', 0, ""),
      ("sespgvido_fav", "sescrowdfundingvideo", \'{item:$subject} has added your video {item:$object} to favorite.\', 0, ""),
      ("sespgvido_rating", "sescrowdfundingvideo", \'{item:$subject} has rated your video {item:$object}.\', 0, ""),
      ("sespgvido_pro_fail", "sescrowdfundingvideo", \'Your {item:$object:video} has failed to process.\', 0, "");');
      $db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
      ("notify_sescrowdfundingvideo_processed", "sescrowdfundingvideo", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]"),
      ("notify_sespgvido_pro_fail", "sescrowdfundingvideo", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]"),
      ("sescrowdfundingvideo_fav_rate_follow", "sescrowdfundingvideo", "[host],[email],[subject],[body],[recipient_title],[recipient_link],[recipient_photo],[object_link]"),
      ("notify_sescrowdfundingvideo_approve", "sescrowdfundingvideo", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]"),
      ("notify_sescrowdfundingvideo_disapprove", "sescrowdfundingvideo", "[host],[email],[recipient_title],[recipient_link],[recipient_photo], [sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo], [object_description]");');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
        SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "auth_view" as `name`,
        5 as `value`,
        \'["everyone","owner_network","owner_member_member","owner_member","owner","registered","owner"]\' as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "auth_comment" as `name`,
        5 as `value`,
        \'["everyone","owner_network","owner_member_member","owner_member","owner","registered","owner"]\' as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "max" as `name`,
        3 as `value`,
        "0" as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "view" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "create" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "comment" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "locked" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "upload" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "rating" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "imageviewer" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "view" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "create" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "comment" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "locked" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "upload" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "rating" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "imageviewer" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "view" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("public");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
        SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "sesvdeo_upld" as `name`,
        5 as `value`,
        \'["iframely","myComputer"]\' as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "sesvdeo_aprve" as `name`,
        0 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
			$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "crowdfundingvideo" as `type`,
        "sesvdeo_aprve" as `name`,
        0 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("public");');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
        SELECT
            level_id as `level_id`,
            "crowdfunding" as `type`,
            "auth_video" as `name`,
            5 as `value`,
            \'["everyone","registered","owner_network","owner_member_member","owner_member","owner", "member"]\' as `params`
        FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
        SELECT
            level_id as `level_id`,
            "crowdfunding" as `type`,
            "video" as `name`,
            2 as `value`,
            NULL as `params`
        FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
        SELECT
            level_id as `level_id`,
            "crowdfunding" as `type`,
            "video" as `name`,
            1 as `value`,
            NULL as `params`
        FROM `engine4_authorization_levels` WHERE `type` IN("user");');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
        SELECT
            level_id as `level_id`,
            "crowdfunding" as `type`,
            "video" as `name`,
            1 as `value`,
            NULL as `params`
        FROM `engine4_authorization_levels` WHERE `type` IN("public");');

      include_once APPLICATION_PATH . "/application/modules/Sescrowdfundingvideo/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingvideo.pluginactivated', 1);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingvideo.licensekey', $_POST['sescrowdfundingvideo_licensekey']);
      $error = 1;
    }
  } else {

    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sescrowdfundingvideo.licensekey', $_POST['sescrowdfundingvideo_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}
