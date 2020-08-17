DROP TABLE IF EXISTS `engine4_sespage_claims` ;
CREATE TABLE `engine4_sespage_claims` (
  `claim_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `contact_number` varchar(128) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `creation_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL default "0",
  PRIMARY KEY (`claim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES 
("sespage_main_claim", "sespage", "Claim For Page", "Sespage_Plugin_Menus::canClaimSespages", '{"route":"sespage_general","action":"claim"}', "sespage_main", "", 999),
("sespage_admin_main_claim", "sespage", "Claim Requests", "", '{"route":"admin_default","module":"sespage","controller":"manage", "action":"claim"}', "sespage_admin_main", "", 777);

INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("sesuser_claim_page", "sespage", '{item:$subject} has claimed your page {item:$object}.', 0, ""),	
("sesuser_claimadmin_page", "sespage", '{item:$subject} has claimed a page {item:$object}.', 0, ""),	
("sespage_claim_approve", "sespage", 'Site admin has approved your claim request for the page: {item:$object}.', 0, ""),
("sespage_claim_declined", "sespage", 'Site admin has rejected your claim request for the page: {item:$object}.', 0, ""),
("sespage_owner_informed", "sespage", 'Site admin has been approved claim for your page: {item:$object}.', 0, "");

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
("sespage_page_owner_approve", "sespage", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_name],[sender_email],[sender_link],[sender_photo],[message]");

ALTER TABLE `engine4_sespage_dashboards` ADD `permission_name` VARCHAR(255) NOT NULL;

UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'edit' WHERE `engine4_sespage_dashboards`.`type` = 'edit_page';  
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_bgphoto' WHERE `engine4_sespage_dashboards`.`type` = 'backgroundphoto'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_edit_style' WHERE `engine4_sespage_dashboards`.`type` = 'style'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_choose_style' WHERE `engine4_sespage_dashboards`.`type` = 'layout_design'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_contactinfo' WHERE `engine4_sespage_dashboards`.`type` = 'contact_information'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_attribution' WHERE `engine4_sespage_dashboards`.`type` = 'post_attribution'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_allow_roles' WHERE `engine4_sespage_dashboards`.`type` = 'page_roles'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_overview' WHERE `engine4_sespage_dashboards`.`type` = 'overview'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_seo' WHERE `engine4_sespage_dashboards`.`type` = 'seo'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'sespage_allow_close' WHERE `engine4_sespage_dashboards`.`type` = 'open_hour'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_allow_announcement' WHERE `engine4_sespage_dashboards`.`type` = 'announcement'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'sespage_allow_multiple_location' WHERE `engine4_sespage_dashboards`.`type` = 'location'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_allow_changeowner' WHERE `engine4_sespage_dashboards`.`type` = 'change_owner'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'sespage_allow_link_page' WHERE `engine4_sespage_dashboards`.`type` = 'linked_pages'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_allow_insightreport' WHERE `engine4_sespage_dashboards`.`type` = 'insight'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_allow_insightreport' WHERE `engine4_sespage_dashboards`.`type` = 'report'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'sespage_allow_crosspost' WHERE `engine4_sespage_dashboards`.`type` = 'page_crosspost'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'sespage_allow_contact_page' WHERE `engine4_sespage_dashboards`.`type` = 'contact_page_owner'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_team' WHERE `engine4_sespage_dashboards`.`type` = 'pageteam'; 
UPDATE `engine4_sespage_dashboards` SET `permission_name` = 'page_service' WHERE `engine4_sespage_dashboards`.`type` = 'pageservices';