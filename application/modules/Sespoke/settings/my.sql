
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sespoke', 'sespoke', 'SES- Advanced Poke, Wink, Slap, etc & Gifts', '', '{"route":"admin_default","module":"sespoke","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sespoke_admin_main_settings', 'sespoke', 'Global Settings', '', '{"route":"admin_default","module":"sespoke","controller":"settings"}', 'sespoke_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
("sespoke_gutter_create_1", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "1"}', "user_profile", NULL, 1, 0, 1),
("sespoke_gutter_create_2", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "2"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_3", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "3"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_4", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "4"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_5", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "5"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_6", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "6"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_7", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "7"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_8", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "8"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_9", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "9"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_10", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "10"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_11", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "11"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_12", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "12"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_13", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "13"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_14", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "14"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_15", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "15"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_16", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "16"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_17", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "17"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_18", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "18"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_19", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "19"}', "user_profile", NULL, 0, 0, 1),
("sespoke_gutter_create_20", "sespoke", "", "Sespoke_Plugin_Menus::sespokeGutterCreate", '{"route":"default", "module":"sespoke", "controller":"index", "action":"poke", "manageaction_id": "20"}', "user_profile", NULL, 0, 0, 1);
