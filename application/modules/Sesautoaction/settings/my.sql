/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesautoaction', 'sesautoaction', 'SES - Auto Bot Actions', '', '{"route":"admin_default","module":"sesautoaction","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesautoaction_admin_main_settings', 'sesautoaction', 'Global Settings', '', '{"route":"admin_default","module":"sesautoaction","controller":"settings"}', 'sesautoaction_admin_main', '', 1);
