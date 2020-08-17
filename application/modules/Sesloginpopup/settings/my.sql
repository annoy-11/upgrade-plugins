/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesloginpopup', 'sesloginpopup', 'SES - Login & Singup Popup', '', '{"route":"admin_default","module":"sesloginpopup","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesloginpopup_admin_main_settings', 'sesloginpopup', 'Global Settings', '', '{"route":"admin_default","module":"sesloginpopup","controller":"settings"}', 'sesloginpopup_admin_main', '', 1);
