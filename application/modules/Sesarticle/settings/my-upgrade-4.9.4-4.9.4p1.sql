INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('sesarticle_main_import', 'sesarticle', 'Import Articles', 'Sesarticle_Plugin_Menus::canCreateSesarticles', '{"route":"sesarticle_import"}', 'sesarticle_main', '', 1, 0, 999),
('sesarticle_main_rss', 'sesarticle', 'RSS Feed', 'Sesarticle_Plugin_Menus::canViewRssarticles', '{"route":"sesarticle_general", "action":"rss-feed","target":"_blank"}', 'sesarticle_main', '', 1, 0, 999);

DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesarticle_link_article';
DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesarticle_link_event';
DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesarticle_reject_article_request';
DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesarticle_reject_event_request';
DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesuser_claimadmin_article';

INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesarticle" as `type`,
    "article_approve" as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` NOT IN("public");
  
UPDATE `engine4_activity_actiontypes` SET `type` = 'sesarticle_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesarticle_like_article';

UPDATE `engine4_activity_actions` SET `type` = 'sesarticle_like' WHERE `engine4_activity_actions`.`type` = 'sesarticle_like';

UPDATE `engine4_activity_actiontypes` SET `type` = 'sesarticle_album_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesarticle_like_articlealbum';

UPDATE `engine4_activity_actions` SET `type` = 'sesarticle_album_like' WHERE `engine4_activity_actions`.`type` = 'sesarticle_like_articlealbum';

UPDATE `engine4_activity_actiontypes` SET `type` = 'sesarticle_photo_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesarticle_like_articlephoto';

UPDATE `engine4_activity_actions` SET `type` = 'sesarticle_photo_like' WHERE `engine4_activity_actions`.`type` = 'sesarticle_like_articlephoto';

UPDATE `engine4_activity_actiontypes` SET `type` = 'sesarticle_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'sesarticle_favourite_article';

UPDATE `engine4_activity_actions` SET `type` = 'sesarticle_favourite' WHERE `engine4_activity_actions`.`type` = 'sesarticle_favourite_article';
