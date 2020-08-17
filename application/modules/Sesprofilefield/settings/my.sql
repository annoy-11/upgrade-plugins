
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_plugins_sesprofilefield", "sesprofilefield", "SES - Professional Profile Fields", "", '{"route":"admin_default","module":"sesprofilefield","controller":"settings","action":"index"}', "core_admin_main_plugins", "", 999),
("sesprofilefield_admin_global", "sesprofilefield", "Global Settings", "", '{"route":"admin_default","module":"sesprofilefield","controller":"settings","action":"index"}', "sesprofilefield_admin_main", "", 2);
