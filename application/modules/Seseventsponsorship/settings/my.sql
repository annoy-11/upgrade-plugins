INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('seseventsponsorship', 'Advanced Events Sponsorship Extension', 'Advanced Events Sponsorship Extension', '4.8.12', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seseventsponsorship', 'seseventsponsorship', 'SES - Advanced Events Sponsorship Extension', '', '{"route":"admin_default","module":"sesevent","controller":"settings", "action":"eventsponsorship"}', 'core_admin_main_plugins', '', 1);

INSERT IGNORE INTO `engine4_activity_actiontypes` (`type`, `module`, `body`, `enabled`, `displayable`, `attachable`, `commentable`, `shareable`, `is_generated`) VALUES
('sesevent_event_createsponsorship', 'sesevent', '{item:$subject} has created a sponsorship {var:$sponsorshipName} in event {item:$object}.', 1, 5, 1, 1, 1, 1),
('sesevent_event_sponsorshippurchased', 'sesevent', '{item:$subject} has purchased sponsorship {var:$sponsorshipName} from event {item:$object}:', 1, 5, 1, 1, 1, 1);


INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("sesevent_event_sponsorshippurchased", "sesevent", '{item:$subject} has purchased sponsorship {var:$sponsorshipName} from event {item:$object}.', 0, ""),
("sesevent_event_sponsorshippaymentrequest", "sesevent", '{item:$subject} request payment {var:$requestAmount} for event {item:$object}.', 0, ""),
("sesevent_event_adminsponsorshippaymentcancel", "sesevent", '{item:$subject} cancel your payment request for event {item:$object}.', 0, ""),
("sesevent_event_adminsponsorshippaymentapprove", "sesevent", '{item:$subject} apporved your payment request for event {item:$object}.', 0, "");