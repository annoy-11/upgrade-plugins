INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesarticle' as `type`,
    'continue_height' as `name`,
    3 as `value`,
    0 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('moderator', 'admin');
  
  
INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    'sesarticle' as `type`,
    'continue_height' as `name`,
    3 as `value`,
    0 as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN('user');
  
ALTER TABLE `engine4_sesarticle_articles` ADD `continue_height` INT(11) NOT NULL DEFAULT "0";
