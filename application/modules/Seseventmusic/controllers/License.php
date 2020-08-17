<?php

//folder name or directory name.
$module_name = 'seseventmusic';

//product title and module title.
$module_title = 'Advanced Music Albums, Songs & Playlists Plugin';

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
  $postdata['licenseKey'] = @base64_encode($_POST['seseventmusic_licensekey']);
  $postdata['module_title'] = @base64_encode($module_title);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "http://www.socialenginesolutions.com/licensecheck.php");
  curl_setopt($ch, CURLOPT_POST, 1);

// in real life you should use something like:
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

// receive server response ...
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec($ch);

  $error = 0;
  if (curl_error($ch)) {
    $error = 1;
  }
  curl_close($ch);

//here we can set some variable for checking in plugin files.
  if (1) {
  //if ($server_output == "OK" && $error != 1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventmusic.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
      ("seseventmusic.albumlink", \'a:2:{i:0;s:6:"report";i:1;s:5:"share";}\'),
      ("seseventmusic.songlink", \'a:2:{i:0;s:6:"report";i:1;s:5:"share";}\');');
      
      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      
      ("seseventmusic_admin_main_subalbumssettings", "seseventmusic", "Music Album Settings", "", \'{"route":"admin_default","module":"seseventmusic","controller":"settings", "action": "album-settings"}\', "seseventmusic_admin_main_globalsettings", "", 2),

      ("seseventmusic_admin_main_subsongssettings", "seseventmusic", "Song Settings", "", \'{"route":"admin_default","module":"seseventmusic","controller":"settings", "action": "song-settings"}\', "seseventmusic_admin_main_globalsettings", "", 3),

      ("seseventmusic_admin_main_manage", "seseventmusic", "Manage Music Albums", "", \'{"route":"admin_default","module":"seseventmusic","controller":"manage"}\', "seseventmusic_admin_main", "", 2),

      ("seseventmusic_admin_main_managesongs", "seseventmusic", "Manage Songs", "", \'{"route":"admin_default","module":"seseventmusic","controller":"managesongs"}\', "seseventmusic_admin_main", "", 3),

      ("seseventmusic_admin_main_level", "seseventmusic", "Member Level Settings", "", \'{"route":"admin_default","module":"seseventmusic","controller":"level"}\', "seseventmusic_admin_main", "", 6),

      ("seseventmusic_admin_main_statistic", "seseventmusic", "Statistics", "", \'{"route":"admin_default","module":"seseventmusic","controller":"settings","action":"statistic"}\', "seseventmusic_admin_main", "", 8),
      
      ("seseventmusic_admin_main_managewidgetizepage", "seseventmusic", "Manage Widgetize Pages", "", \'{"route":"admin_default","module":"seseventmusic","controller":"settings", "action":"manage-widgetize-page"}\', "seseventmusic_admin_main", "", 9);
      ');
      
      $db->query('INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`) VALUES
        ("seseventmusic_profile", "standard", "Advanced Events - Music Extension - Album Profile Options Menu"),
        ("seseventmusic_song_profile", "standard", "Advanced Events - Music Extension - Song Profile Options Menu");
      ');
       
      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("seseventmusic_profile_create", "seseventmusic", "Upload Album", "Seseventmusic_Plugin_Menus", "", "seseventmusic_profile", "", 1),
      ("seseventmusic_profile_edit", "seseventmusic", "Edit Album", "Seseventmusic_Plugin_Menus", "", "seseventmusic_profile", "", 2),
      ("seseventmusic_profile_delete", "seseventmusic", "Delete Album", "Seseventmusic_Plugin_Menus", "", "seseventmusic_profile", "", 3),
      ("seseventmusic_profile_report", "seseventmusic", "Report", "Seseventmusic_Plugin_Menus", "", "seseventmusic_profile", "", 5),
      ("seseventmusic_profile_share", "seseventmusic", "Share", "Seseventmusic_Plugin_Menus", "", "seseventmusic_profile", "", 6),

      ("seseventmusic_song_profile_edit", "seseventmusic", "Edit Song", "Seseventmusic_Plugin_Menus", "", "seseventmusic_song_profile", "", 1),
      ("seseventmusic_song_profile_delete", "seseventmusic", "Delete Song", "Seseventmusic_Plugin_Menus", "", "seseventmusic_song_profile", "", 2),
      ("seseventmusic_song_profile_print", "seseventmusic", "Print", "Seseventmusic_Plugin_Menus", "", "seseventmusic_song_profile", "", 4),
      ("seseventmusic_song_profile_report", "seseventmusic", "Report", "Seseventmusic_Plugin_Menus", "", "seseventmusic_song_profile", "", 5),
      ("seseventmusic_song_profile_share", "seseventmusic", "Share", "Seseventmusic_Plugin_Menus", "", "seseventmusic_song_profile", "", 6),
      ("seseventmusic_song_profile_download", "seseventmusic", "Download", "Seseventmusic_Plugin_Menus", "", "seseventmusic_song_profile", "", 7),       

      ("seseventmusic_main_home", "seseventmusic", "Music Home", "", \'{"route":"seseventmusic_general","action":"home"}\', "sesevent_main", "", 20),

      ("seseventmusic_quick_create", "seseventmusic", "New Music Album", "Seseventmusic_Plugin_Menus", \'{"route":"seseventmusic_general","action":"create","class":"buttonlink icon_seseventmusic_new"}\', "seseventmusic_quick", "", 1);
      ');
      
      $db->query('DROP TABLE IF EXISTS `engine4_seseventmusic_albums`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_seseventmusic_albums` (
      `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `owner_id` int(11) unsigned NOT NULL,
      `owner_type` varchar(24)  NOT NULL,      
      `title` varchar(63)  NOT NULL DEFAULT "",
      `description` text  NOT NULL,
      `ip_address` VARCHAR( 128 ) NOT NULL,
      `photo_id` int(11) unsigned NOT NULL DEFAULT "0",
      `album_cover` int(11) NOT NULL,
      `search` tinyint(1) NOT NULL DEFAULT "1",
      `profile` tinyint(1) NOT NULL DEFAULT "0",
      `special` enum("wall","message")  DEFAULT NULL,
      `creation_date` datetime NOT NULL,
      `modified_date` datetime NOT NULL,
      `view_count` int(11) unsigned NOT NULL DEFAULT "0",
      `like_count` int(11) NOT NULL,
      `comment_count` int(11) unsigned NOT NULL DEFAULT "0",  
      `song_count` int(11) NOT NULL,
      `rating` float NOT NULL,
      `favourite_count` int(11) NOT NULL,
      `featured` tinyint(1) NOT NULL,
      `sponsored` tinyint(1) NOT NULL,
      `hot` int(11) NOT NULL,
      `upcoming` tinyint(1) NOT NULL, 
      `offtheday` TINYINT( 1 ) NOT NULL,
      `starttime` DATE NOT NULL,
      `endtime` DATE NOT NULL,
      PRIMARY KEY (`album_id`),
      KEY `creation_date` (`creation_date`),
      KEY `owner_id` (`owner_type`,`owner_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_seseventmusic_albumsongs`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_seseventmusic_albumsongs` (
      `albumsong_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `album_id` int(11) unsigned NOT NULL,
      `title` varchar(60)  NOT NULL,
      `description` text  NOT NULL,
      `ip_address` VARCHAR( 128 ) NOT NULL,
      `photo_id` int(11) NOT NULL,
      `song_cover` int(11) NOT NULL,
      `file_id` int(11) unsigned NOT NULL,
      `lyrics` text  NOT NULL,
      `creation_date` datetime NOT NULL,
      `modified_date` datetime NOT NULL,
      `play_count` int(11) unsigned NOT NULL DEFAULT "0",
      `order` smallint(6) NOT NULL DEFAULT "0",
      `song_id` int(11) NOT NULL,
      `view_count` int(11) NOT NULL,
      `like_count` int(11) NOT NULL,  
      `comment_count` int(11) NOT NULL,
      `download_count` int(11) NOT NULL,
      `favourite_count` int(11) NOT NULL,
      `rating` float NOT NULL,
      `featured` tinyint(1) NOT NULL,
      `sponsored` tinyint(1) NOT NULL,
      `hot` tinyint(1) NOT NULL, 
      `upcoming` TINYINT( 1 ) NOT NULL,
      `track_id` int(11) NOT NULL,
      `song_url` text NOT NULL,
      `download` TINYINT( 1 ) NOT NULL DEFAULT "1",
      `offtheday` TINYINT( 1 ) NOT NULL,
      `starttime` DATE NOT NULL,
      `endtime` DATE NOT NULL,
      PRIMARY KEY (`albumsong_id`),
      KEY `album_id` (`album_id`,`file_id`),
      KEY `play_count` (`play_count`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

      $db->query('DROP TABLE IF EXISTS `engine4_seseventmusic_ratings`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_seseventmusic_ratings` (
      `rating_id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(9) unsigned NOT NULL,
      `resource_id` int(11) NOT NULL,
      `resource_type` varchar(128) NOT NULL,      
      `rating` tinyint(1) unsigned DEFAULT NULL,      
      PRIMARY KEY (`rating_id`),
      UNIQUE KEY `resource_id` (`resource_id`,`resource_type`,`user_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_seseventmusic_favourites`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_seseventmusic_favourites` (
      `favourite_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) unsigned NOT NULL,
      `resource_type` varchar(128) NOT NULL,
      `resource_id` int(11) NOT NULL,      
      PRIMARY KEY (`favourite_id`),
      KEY (`user_id`,`resource_type`,`resource_id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');
      
			$db->query('DROP TABLE IF EXISTS `engine4_seseventmusic_recentlyviewitems`;');
			$db->query('CREATE TABLE IF NOT EXISTS  `engine4_seseventmusic_recentlyviewitems` (
			`recentlyviewed_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`resource_id` INT NOT NULL ,
			`resource_type` VARCHAR( 65 ) NOT NULL DEFAULT "album",
			`owner_id` INT NOT NULL ,
			`creation_date` DATETIME NOT NULL,
			UNIQUE KEY `uniqueKey` (`resource_id`,`resource_type`, `owner_id`)
			) ENGINE = MYISAM ;');
      
      $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
      ("seseventmusic_album_new", "seseventmusic", \'{item:$subject} created a new music album {item:$object}:\', "1", "5", "1", "3", "1", 1);');
      
      $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES ("seseventmusic_favouritealbum", "seseventmusic", \'{item:$subject} added music album {item:$object} to favorite:\', 1, 5, 1, 1, 1, 1),
      ("seseventmusic_albumrating", "seseventmusic", \'{item:$subject} rated music album {item:$object}:\', 1, 5, 1, 1, 1, 1),
      ("seseventmusic_songrating", "seseventmusic", \'{item:$subject} rated song {item:$object}:\', 1, 5, 1, 1, 1, 1),
      ("seseventmusic_playedsong", "seseventmusic", \'{item:$subject} played song {item:$object}:\', 1, 5, 1, 1, 1, 1),
      ("seseventmusic_favouritealbumsong", "seseventmusic", \'{item:$subject} added song {item:$object} to favorite:\', 1, 5, 1, 1, 1, 1);');
      
      $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("seseventmusic_favourite_musicalbum", "seseventmusic", \'{item:$subject} has added your music album {item:$object} to favorite.\', 0, ""),
      ("seseventmusic_favourite_song", "seseventmusic", \'{item:$subject} has added your song {item:$object} to favorite.\', 0, "");');

      $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("seseventmusic_rated_musicalbum", "seseventmusic", \'{item:$subject} has rated your music album {item:$object}.\', 0, ""),
      ("seseventmusic_rated_song", "seseventmusic", \'{item:$subject} has rated your song {item:$object}.\', 0, "");');
      

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "seseventmusic_album" as `type`,
      "rating_album" as `name`,
      1 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "seseventmusic_album" as `type`,
      "rating_albumsong" as `name`,
      1 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "seseventmusic_album" as `type`,
      "addfavourite_album" as `name`,
      1 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "seseventmusic_album" as `type`,
      "addfavourite_albumsong" as `name`,
      1 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "seseventmusic_album" as `type`,
      "download_albumsong" as `name`,
      1 as `value`,
      NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');  
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
      level_id as `level_id`,
      "seseventmusic_album" as `type`,
      "addalbum_max" as `name`,
      3 as `value`,
      50 as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');

      include_once APPLICATION_PATH . "/application/modules/Seseventmusic/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.pluginactivated', 1);

      Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.licensekey', $_POST['seseventmusic_licensekey']);
    }
    Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.checkmusic', 1);
  } else {

    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.checkmusic', 0);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('seseventmusic.licensekey', $_POST['seseventmusic_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}