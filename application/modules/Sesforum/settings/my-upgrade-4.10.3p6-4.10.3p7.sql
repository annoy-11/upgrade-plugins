/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my-upgrade-4.10.3p6-4.10.3p7.sql 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
UPDATE `engine4_core_menuitems` SET `label` = 'Forums' WHERE `engine4_core_menuitems`.`name` = 'core_main_sesforum';
ALTER TABLE `engine4_sesforum_categories` ADD `slug` VARCHAR(255) NOT NULL;
ALTER TABLE `engine4_sesforum_categories` ADD `subsubcat_id` INT NOT NULL DEFAULT '0';
ALTER TABLE `engine4_sesforum_thanks` ADD `post_id` INT NOT NULL DEFAULT '0';
ALTER TABLE `engine4_sesforum_topics` ADD `seo_keywords` VARCHAR(255) NULL DEFAULT NULL;
UPDATE `engine4_core_menuitems` SET `label`='Manage Categories & Forums' WHERE `name` ='sesforum_admin_main_manage';
DELETE FROM `engine4_activity_actiontypes` WHERE `type` ='sesforum_topic_reply';
DELETE FROM `engine4_activity_actiontypes` WHERE `type` ='sesforum_topic_create';
DELETE FROM `engine4_activity_actiontypes` WHERE `type` ='sesforum_promote';
INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
('sesforum_topic_create', 'sesforum', '{item:$subject} posted a {var:$topictitle} in the forum {itemParent:$object:sesforum_forum}: {body:$body}: {body:$body}', 1, 3, 1, 1, 1, 1),
('sesforum_topic_reply', 'sesforum', '{item:$subject} replied to a {var:$topictitle} in the forum {itemParent:$object:sesforum_forum}: {body:$body}', 1, 3, 1, 1, 1, 1),
("sesforum_post_reputation", "sesforum", '{item:$subject} added Reputation to post in topic {item:$object}:', 1, 7, 1, 1, 1, 1),
("sesforum_post_thanks", "sesforum", '{item:$subject} mark thanks to post in topic {item:$object}:', 1, 7, 1, 1, 1, 1),
("sesforum_post_reputation", "sesforum", '{item:$subject} added Reputation to post in topic {item:$object}:', 1, 7, 1, 1, 1, 1);
INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("sesforum_post_thanks", "sesforum", '{item:$subject} said thanks to a post in a topic {item:$subject}', 0, ""),
("sesforum_topicsubs", "sesforum", '{item:$subject} Subscribed your topic {item:$object}.', 0, ""),
("sesforum_rating", "sesforum", '{item:$subject} gives you ratings on forum topic {item:$object}.', 0, ""),
("sesforum_post_reputation", "sesforum", '{item:$subject} added Reputation to post in topic {item:$object}.', 0, "");
UPDATE `engine4_core_menuitems` SET `label`='SES - Advanced Forums' WHERE `name`='core_admin_main_plugins_sesforum';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Forum Main Page',`title`='Forum Main',`description`='This is the main forum page.' WHERE `name` = 'sesforum_index_index';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - User Dashboard Page',`title`='User Dashboard Page',`description`='This is the user dashboard page.' WHERE `name` = 'sesforum_index_dashboard';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Topic Search Page',`title`='Topic Search Page',`description`='This is the topic search page.' WHERE `name` = 'sesforum_index_search';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Topic View Page',`title`='Topic View',`description`='This is the view topic page.' WHERE `name` = 'sesforum_topic_view';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Forum Category View Page',`title`='Forum Category View',`description`='This is theforum category view page.' WHERE `name` = 'sesforum_category_view';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Browse Tags Page',`title`='Browse Tags Page',`description`='This page displays the Topic tags.' WHERE `name` = 'sesforum_index_tags';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Topic Create Page',`title`='Post Topic',`description`='This is the sesforum topic create page.' WHERE `name` = 'sesforum_forum_topic-create';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Post Edit Page',`title`='Post Edit Page',`description`='This is the post edit page.' WHERE `name` = 'sesforum_post_edit';
UPDATE `engine4_core_pages` SET `displayname`='SES - Advanced Forums - Forum View Page',`title`='Forum View',`description`='This is the view forum page.' WHERE `name` = 'sesforum_forum_view';
UPDATE `engine4_sesforum_categories` SET slug = CASE WHEN slug = '' THEN category_id ELSE slug END;
UPDATE `engine4_sesforum_categories` SET privacy = CASE WHEN privacy = '' THEN '1,2,3,4,5' ELSE privacy END;

INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post_create' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');

INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post_edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post_delete' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'topic_create' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'topic_edit' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'topic_delete' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post_create' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post_edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin'); 
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post_delete' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'topic_create' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'topic_edit' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'topic_delete' as `name`,
    2 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesforum_forum' as `type`,
    'post' as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('public');
