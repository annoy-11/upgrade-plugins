
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_settings_sesdiscussion", "sesdiscussion", "SES - Discussions", "", '{"route":"admin_default","module":"sesdiscussion","controller":"settings","action":"index"}', "core_admin_main_plugins", "", 1),
("sesdiscussion_admin_main_settings", "sesdiscussion", "Global Settings", "", '{"route":"admin_default","module":"sesdiscussion","controller":"settings","action":"index"}', "sesdiscussion_admin_main", "", 1),
("sesdiscussion_main_create", "sesdiscussion", "Write New Discussion", "Sesdiscussion_Plugin_Menus::canCreateDiscussions", '{"route":"sesdiscussion_general","action":"create", "class":"sessmoothbox"}', "sesdiscussion_main", "", 88);
