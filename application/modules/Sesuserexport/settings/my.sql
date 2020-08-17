/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesuserexport
 * @package    Sesuserexport
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesuserexport', 'sesuserexport', 'SES - User Export Information', '', '{"route":"admin_default","module":"sesuserexport","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesuserexport_admin_main_settings', 'sesuserexport', 'Global Settings', '', '{"route":"admin_default","module":"sesuserexport","controller":"settings"}', 'sesuserexport_admin_main', '', 1);
