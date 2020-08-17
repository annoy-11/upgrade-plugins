<?php

//folder name or directory name.
$module_name = 'sesgroupforum';

//product title and module title.
$module_title = 'Group Forums Extension';

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
  $postdata['licenseKey'] = @base64_encode($_POST['sesgroupforum_licensekey']);
  $postdata['module_title'] = @base64_encode($module_title);

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, "https://socialnetworking.solutions/licensecheck.php");
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
  //if ($server_output == "OK" && $error != 1) {
  if (1) {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupforum.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
      
      $table_exist = $db->query("SHOW TABLES LIKE 'engine4_sesgroup_managegroupapps'")->fetch();
      if (!empty($table_exist)) {
        $forums = $db->query("SHOW COLUMNS FROM engine4_sesgroup_managegroupapps LIKE 'forums'")->fetch();
        if (empty($forums)) {
          $db->query('ALTER TABLE `engine4_sesgroup_managegroupapps` ADD COLUMN  `forums`  TINYINT(1) NOT NULL DEFAULT 1;');
        }
      }
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_reputations`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_reputations` (
        `reputation_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `resource_id` int(11) unsigned NOT NULL,
        `poster_id` int(11) NOT NULL,
        `post_id` int(11) NOT NULL,
        `reputation` tinyint(1) NOT NULL default "1",
        PRIMARY KEY (`reputation_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_subscribes`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_subscribes` (
        `subscribe_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `resource_id` int(11) unsigned NOT NULL,
        `poster_id` int(11) NOT NULL,
        PRIMARY KEY (`subscribe_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_thanks`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_thanks` (
        `thank_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `resource_id` int(11) unsigned NOT NULL,
        `poster_id` int(11) NOT NULL,
        `post_id` INT NOT NULL DEFAULT "0",
        PRIMARY KEY (`thank_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_ratings`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_ratings` (
        `forum_id` int(10) unsigned NOT NULL,
        `user_id` int(9) unsigned NOT NULL,
        `rating` tinyint(1) unsigned default NULL,
        PRIMARY KEY  (`forum_id`,`user_id`),
        KEY `INDEX` (`forum_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;');

      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_forums`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_forums` (
        `forum_id` int(11) unsigned NOT NULL auto_increment,
        `category_id` int(11) unsigned NOT NULL,
        `title` varchar(64) NOT NULL,
        `description` varchar(255) NOT NULL,
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        `order` smallint(6) NOT NULL default "999",
        `file_id` int(11) unsigned NOT NULL default "0",
        `view_count` int(11) unsigned NOT NULL default "0",
        `topic_count` int(11) unsigned NOT NULL default "0",
        `post_count` int(11) unsigned NOT NULL default "0",
        `lastpost_id` int(11) unsigned NOT NULL default "0",
        `lastposter_id` int(11) unsigned NOT NULL default "0",
        `forum_icon` INT(11) NULL DEFAULT "0",
        `like_count` INT(11) NOT NULL DEFAULT "0",
        PRIMARY KEY  (`forum_id`),
        KEY `category_id` (`category_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;');
      
      $db->query('INSERT INTO `engine4_sesgroupforum_forums` (`forum_id`, `category_id`, `title`, `description`, `creation_date`, `modified_date`, `order`, `topic_count`, `post_count`, `lastpost_id`) VALUES
      (1, 1, "News and Announcements", "", "2010-02-01 14:59:01", "2010-02-01 14:59:01", 1, 0, 0, 0);');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_posts`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_posts` (
        `post_id` int(11) unsigned NOT NULL auto_increment,
        `topic_id` int(11) unsigned NOT NULL,
        `forum_id` int(11) unsigned NOT NULL,
        `user_id` int(11) unsigned NOT NULL,
        `body` text NOT NULL,
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        `file_id` int(11) unsigned NOT NULL default "0",
        `edit_id` int(11) unsigned NOT NULL default "0",
        `like_count` INT(11) NOT NULL DEFAULT "0",
        `thanks_count` INT(11) NOT NULL DEFAULT "0",
        PRIMARY KEY  (`post_id`),
        KEY `topic_id` (`topic_id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_signatures`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_signatures` (
        `signature_id` int(11) unsigned NOT NULL auto_increment,
        `user_id` int(11) unsigned NOT NULL,
        `body` text NOT NULL,
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        `post_count` int(11) unsigned NOT NULL default "0",
        PRIMARY KEY  (`signature_id`),
        UNIQUE KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_topics`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_topics` (
        `topic_id` int(11) unsigned NOT NULL auto_increment,
        `forum_id` int(11) unsigned NOT NULL,
        `user_id` int(11) unsigned NOT NULL,
        `title` varchar(64) NOT NULL,
        `description` varchar(255) NOT NULL,
        `creation_date` datetime NOT NULL,
        `modified_date` datetime NOT NULL,
        `sticky` tinyint(4) NOT NULL default "0",
        `closed` tinyint(4) NOT NULL default "0",
        `post_count` int(11) unsigned NOT NULL default "0",
        `view_count` int(11) unsigned NOT NULL default "0",
        `lastpost_id` int(11) unsigned NOT NULL default "0",
        `lastposter_id` int(11) unsigned NOT NULL default "0",
        `like_count` INT(11) NOT NULL DEFAULT "0",
        `seo_keywords` VARCHAR(255) NULL DEFAULT NULL,
        `rating` FLOAT NOT NULL,
        `group_id` INT(11) NOT NULL DEFAULT "0",
        PRIMARY KEY  (`topic_id`),
        KEY `forum_id` (`forum_id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
      
      $db->query('DROP TABLE IF EXISTS `engine4_sesgroupforum_topicwatches`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_topicwatches` (
        `resource_id` int(10) unsigned NOT NULL,
        `topic_id` int(10) unsigned NOT NULL,
        `user_id` int(10) unsigned NOT NULL,
        `watch` tinyint(1) unsigned NOT NULL default "1",
        PRIMARY KEY  (`resource_id`,`topic_id`,`user_id`),
        KEY `user_id` (`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;');
      
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesgroupforum_topicviews` (
        `user_id` int(11) unsigned NOT NULL,
        `topic_id` int(11) unsigned NOT NULL,
        `last_view_date` datetime NOT NULL,
        PRIMARY KEY(`user_id`, `topic_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
      
      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sesgroupforum_admin_main_managetopics", "sesgroupforum", "Manage Topics", "", \'{"route":"admin_default","module":"sesgroupforum","controller":"manage-topics"}\', "sesgroupforum_admin_main", "", 3),
      ("sesgroupforum_admin_main_manageposts", "sesgroupforum", "Manage Posts", "", \'{"route":"admin_default","module":"sesgroupforum","controller":"manage-posts"}\', "sesgroupforum_admin_main", "", 4),
      ("sesgroupforum_admin_main_level", "sesgroupforum", "Member Level Settings", "", \'{"route":"admin_default","module":"sesgroupforum","controller":"level"}\', "sesgroupforum_admin_main", "", 5),
      ("sesgroupforum_admin_main_managepages", "sesgroupforum", "Widgetized Pages", "", \'{"route":"admin_default","module":"sesgroupforum","controller":"settings", "action":"manage-widgetize-page"}\', "sesgroupforum_admin_main", "", 999);');
      
      $db->query('INSERT IGNORE INTO `engine4_core_settings` VALUES 
      ("sesgroupforum.public", 1),
      ("sesgroupforum.topic.pagelength", 25),
      ("sesgroupforum.sesgroupforum.pagelength", 25),
      ("sesgroupforum.html", 1),
      ("sesgroupforum.bbcode", 1);');
      
      $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
      ("sesgroupforum_topic_create", "sesgroupforum", \'{item:$subject} posted a {var:$topictitle} in the forum {itemParent:$object:sesgroupforum_forum}: {body:$body}: {body:$body}\', 1, 3, 1, 1, 1, 1),
      ("sesgroupforum_topic_reply", "sesgroupforum", \'{item:$subject} replied to a {var:$topictitle} in the forum {itemParent:$object:sesgroupforum_forum}: {body:$body}\', 1, 3, 1, 1, 1, 1);');
      $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("sesgroupforum_topic_response", "sesgroupforum", \'{item:$subject} has {item:$postGuid:posted} on a {item:$object:forum topic} you created.\', 0, ""),
      ("sesgroupforum_topic_reply", "sesgroupforum", \'{item:$subject} has {item:$postGuid:posted} on a {item:$object:forum topic} you posted on.\', 0, "");');
      $db->query('INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
      ("sesgroupforum_like_topic", "sesgroupforum", \'{item:$subject} likes the topic {item:$object}:\', 1, 7, 1, 1, 1, 1),
      ("sesgroupforum_like_post", "sesgroupforum", \'{item:$subject} likes the post in topic {item:$object}:\', 1, 7, 1, 1, 1, 1),
      ("sesgroupforum_post_thanks", "sesgroupforum", \'{item:$subject} mark thanks to post in topic {item:$object}:\', 1, 7, 1, 1, 1, 1),
      ("sesgroupforum_post_reputation", "sesgroupforum", \'{item:$subject} added Reputation to post in topic {item:$object}:\', 1, 7, 1, 1, 1, 1);');
      $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
      ("sesgroupforum_like_topic", "sesgroupforum", \'{item:$subject} likes the topic {item:$object}:\', 0, ""),
      ("sesgroupforum_like_post", "sesgroupforum", \'{item:$subject} likes the post in topic {item:$object}:\', 0, ""),
      ("sesgroupforum_post_thanks", "sesgroupforum", \'{item:$subject} said thanks to a post in a topic {item:$subject}\', 0, ""),
      ("sesgroupforum_topicsubs", "sesgroupforum", \'{item:$subject} Subscribed your topic {item:$object}.\', 0, ""),
      ("sesgroupforum_rating", "sesgroupforum", \'{item:$subject} gives you ratings on forum topic {item:$object}.\', 0, ""),
      ("sesgroupforum_post_reputation", "sesgroupforum", \'{item:$subject} added Reputation to post in topic {item:$object}.\', 0, "");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_allow` (`resource_type`, `resource_id`, `action`, `role`, `role_id`, `value`, `params`) VALUES
      ("sesgroupforum", 1, "view", "everyone", 0, 1, NULL),
      ("sesgroupforum", 1, "topic.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 1, "post.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 1, "topic.edit", "sesgroupforum_list", 1, 1, NULL),
      ("sesgroupforum", 1, "topic.delete", "sesgroupforum_list", 1, 1, NULL),
      ("sesgroupforum", 2, "view", "everyone", 0, 1, NULL),
      ("sesgroupforum", 2, "topic.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 2, "post.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 2, "topic.edit", "sesgroupforum_list", 2, 1, NULL),
      ("sesgroupforum", 2, "topic.delete", "sesgroupforum_list", 2, 1, NULL),
      ("sesgroupforum", 3, "view", "everyone", 0, 1, NULL),
      ("sesgroupforum", 3, "topic.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 3, "post.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 3, "topic.edit", "sesgroupforum_list", 3, 1, NULL),
      ("sesgroupforum", 3, "topic.delete", "sesgroupforum_list", 3, 1, NULL),
      ("sesgroupforum", 4, "view", "everyone", 0, 1, NULL),
      ("sesgroupforum", 4, "topic.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 4, "post.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 4, "topic.edit", "sesgroupforum_list", 4, 1, NULL),
      ("sesgroupforum", 4, "topic.delete", "sesgroupforum_list", 4, 1, NULL),
      ("sesgroupforum", 5, "view", "everyone", 0, 1, NULL),
      ("sesgroupforum", 5, "topic.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 5, "post.create", "registered", 0, 1, NULL),
      ("sesgroupforum", 5, "topic.edit", "sesgroupforum_list", 5, 1, NULL),
      ("sesgroupforum", 5, "topic.delete", "sesgroupforum_list", 5, 1, NULL);');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "view" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "comment" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic.create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic.edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic.delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic_create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic_edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic_delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post.create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post.edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post.delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post_create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post_edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin"); ');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post_delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "move" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_po" as `type`,
        "create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_po" as `type`,
        "edit" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_po" as `type`,
        "delete" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "view" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "comment" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic.create" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic.edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic.delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic_create" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic_edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "topic_delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post.create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post.edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post.delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post_create" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post_edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "post_delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "create" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_topic" as `type`,
        "delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_po" as `type`,
        "create" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_po" as `type`,
        "edit" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum_po" as `type`,
        "delete" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "view" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("public");');
          $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroupforum" as `type`,
        "commentHtml" as `name`,
        3 as `value`,
        "blockquote, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe" as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroup_group" as `type`,
        "auth_forum" as `name`,
        5 as `value`,
        \'["everyone", "registered", "owner_network","owner_member_member","owner_member","owner"]\' as `params`
      FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");');
      
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroup_group" as `type`,
        "forum" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
      
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesgroup_group" as `type`,
        "forum" as `name`,
        1 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
      
      include_once APPLICATION_PATH . "/application/modules/Sesgroupforum/controllers/defaultsettings.php";
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupforum.pluginactivated', 1);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupforum.licensekey', $_POST['sesgroupforum_licensekey']);
    }
    $domain_name = @base64_encode(str_replace(array('http://','https://','www.'),array('','',''),$_SERVER['HTTP_HOST']));
    $licensekey = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupforum.licensekey');
    $licensekey = @base64_encode($licensekey);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupforum.sesdomainauth', $domain_name);
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupforum.seslkeyauth', $licensekey);
    $error = 1;
  } else {
    $error = $this->view->translate('Please enter correct License key for this product.');
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $error = 0;
    Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupforum.licensekey', $_POST['sesgroupforum_licensekey']);
    return;
    $this->_helper->redirector->gotoRoute(array());
  }
}
