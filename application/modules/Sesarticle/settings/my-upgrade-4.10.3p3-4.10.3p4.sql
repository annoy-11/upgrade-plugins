UPDATE `engine4_activity_stream` SET `object_type` = 'sesarticle' WHERE `engine4_activity_stream`.`object_type` = 'sesarticle_article';

UPDATE `engine4_activity_attachments` SET `type` = 'sesarticle' WHERE `engine4_activity_attachments`.`type` = 'sesarticle_article'; 

UPDATE `engine4_activity_actions` SET `object_type` = 'sesarticle' WHERE `engine4_activity_actions`.`object_type` = 'sesarticle_article'; 

UPDATE `engine4_activity_notifications` SET `object_type` = 'sesarticle' WHERE `engine4_activity_notifications`.`object_type` = 'sesarticle_article'; 

UPDATE `engine4_core_likes` SET `resource_type` = 'sesarticle' WHERE `engine4_core_likes`.`resource_type` = 'sesarticle_article'; 

UPDATE `engine4_core_comments` SET `resource_type` = 'sesarticle' WHERE `engine4_core_comments`.`resource_type` = 'sesarticle_article'; 

UPDATE `engine4_sesarticle_favourites` SET `resource_type` = 'sesarticle' WHERE `engine4_sesarticle_favourites`.`resource_type` = 'sesarticle_article';  

UPDATE `engine4_authorization_allow` SET `resource_type` = 'sesarticle' WHERE `engine4_authorization_allow`.`resource_type` = 'sesarticle_article';

UPDATE `engine4_authorization_permissions` SET `type` = 'sesarticle' WHERE `engine4_authorization_permissions`.`type` = 'sesarticle_article';

UPDATE `engine4_core_search` SET `type` = 'sesarticle' WHERE `engine4_core_search`.`type` = 'sesarticle_article';

UPDATE `engine4_core_tagmaps` SET `resource_type` = 'sesarticle' WHERE `engine4_core_tagmaps`.`resource_type` = 'sesarticle_article';

UPDATE `engine4_storage_files` SET `parent_type` = 'sesarticle' WHERE `engine4_storage_files`.`parent_type` = 'sesarticle_article';


RENAME TABLE `engine4_sesarticle_article_fields_maps` TO `engine4_sesarticle_fields_maps`;
RENAME TABLE `engine4_sesarticle_article_fields_meta` TO `engine4_sesarticle_fields_meta`;
RENAME TABLE `engine4_sesarticle_article_fields_options` TO `engine4_sesarticle_fields_options`;
RENAME TABLE `engine4_sesarticle_article_fields_search` TO `engine4_sesarticle_fields_search`;
RENAME TABLE `engine4_sesarticle_article_fields_values` TO `engine4_sesarticle_fields_values`;


UPDATE `engine4_core_menuitems` SET `name` = 'sesarticle_admin_main_rvwsetings' WHERE `engine4_core_menuitems`.`name` = 'sesarticle_admin_main_reviewsettings';
UPDATE `engine4_core_menuitems` SET `menu` = 'sesarticle_admin_main_rvwsetings' WHERE `engine4_core_menuitems`.`menu` = 'sesarticle_admin_main_reviewsettings';
UPDATE `engine4_core_menuitems` SET `name` = 'sesarticle_admin_main_revwcat' WHERE `engine4_core_menuitems`.`name` = 'sesarticle_admin_main_review_categories';
UPDATE `engine4_core_menuitems` SET `menu` = 'sesarticle_admin_main_revwcat' WHERE `engine4_core_menuitems`.`menu` = 'sesarticle_admin_main_review_categories';


UPDATE `engine4_authorization_permissions` SET `type` = 'sesarticlereview' WHERE `engine4_authorization_permissions`.`type` = 'sesarticle_review';
UPDATE `engine4_core_likes` SET `resource_type` = 'sesarticlereview' WHERE `engine4_core_likes`.`resource_type` = 'sesarticle_review'; 
UPDATE `engine4_core_comments` SET `resource_type` = 'sesarticlereview' WHERE `engine4_core_comments`.`resource_type` = 'sesarticle_review';
RENAME TABLE `engine4_sesarticle_review_fields_maps` TO `engine4_sesarticlereview_fields_maps`;
RENAME TABLE `engine4_sesarticle_review_fields_meta` TO `engine4_sesarticlereview_fields_meta`;
RENAME TABLE `engine4_sesarticle_review_fields_options` TO `engine4_sesarticlereview_fields_options`;
RENAME TABLE `engine4_sesarticle_review_fields_search` TO `engine4_sesarticlereview_fields_search`;
RENAME TABLE `engine4_sesarticle_review_fields_values` TO `engine4_sesarticlereview_fields_values`;
