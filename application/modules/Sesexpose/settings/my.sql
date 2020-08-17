/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesexpose', 'sesexpose', 'SES - Responsive Expose', '', '{"route":"admin_default","module":"sesexpose","controller":"settings"}', 'core_admin_main', '', 888),
('sesexpose_admin_main_settings', 'sesexpose', 'Global Settings', '', '{"route":"admin_default","module":"sesexpose","controller":"settings"}', 'sesexpose_admin_main', '', 1);
