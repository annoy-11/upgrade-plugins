/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seselegant', 'seselegant', 'SES - Responsive Elegant', '', '{"route":"admin_default","module":"seselegant","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('seselegant_admin_main_settings', 'seselegant', 'Global Settings', '', '{"route":"admin_default","module":"seselegant","controller":"settings"}', 'seselegant_admin_main', '', 1);