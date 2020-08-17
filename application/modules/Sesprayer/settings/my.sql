
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_settings_sesprayer", "sesprayer", "SES - Prayers", "", '{"route":"admin_default","module":"sesprayer","controller":"settings","action":"index"}', "core_admin_main_plugins", "", 1),
("sesprayer_admin_main_settings", "sesprayer", "Global Settings", "", '{"route":"admin_default","module":"sesprayer","controller":"settings","action":"index"}', "sesprayer_admin_main", "", 1),
("sesprayer_main_create", "sesprayer", "Write New Prayer", "Sesprayer_Plugin_Menus::canCreatePrayers", '{"route":"sesprayer_general","action":"create", "class":"smoothbox"}', "sesprayer_main", "", 3);
