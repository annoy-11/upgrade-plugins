ALTER TABLE `engine4_sespopupbuilder_popups` ADD `popup_visibility_duration` INT(11) DEFAULT NULL;
ALTER TABLE `engine4_sespopupbuilder_visits` ADD `popup_visit_date` datetime DEFAULT NULL;
ALTER IGNORE TABLE `engine4_sespopupbuilder_visits` ADD UNIQUE (user_id,popup_id);