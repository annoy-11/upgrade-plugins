/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_sesjob", "sesjob", "SES - Advanced Job", "", '{"route":"admin_default","module":"sesjob","controller":"settings"}', "core_admin_main_plugins", "", 999),
("sesjob_admin_main_settings", "sesjob", "Global Settings", "", '{"route":"admin_default","module":"sesjob","controller":"settings"}', "sesjob_admin_main", "", 1);
