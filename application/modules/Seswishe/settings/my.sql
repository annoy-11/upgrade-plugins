
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_settings_seswishe", "seswishe", "SES - Wishes", "", '{"route":"admin_default","module":"seswishe","controller":"settings","action":"index"}', "core_admin_main_plugins", "", 1),
("seswishe_admin_main_settings", "seswishe", "Global Settings", "", '{"route":"admin_default","module":"seswishe","controller":"settings","action":"index"}', "seswishe_admin_main", "", 1),
("seswishe_main_create", "seswishe", "Write New Wishe", "Seswishe_Plugin_Menus::canCreateWishes", '{"route":"seswishe_general","action":"create", "class":"smoothbox"}', "seswishe_main", "", 3);