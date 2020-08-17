/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesariana', 'sesariana', 'SES - Responsive Vertical Theme', '', '{"route":"admin_default","module":"sesariana","controller":"settings"}', 'core_admin_main', '', 999),
('sesariana_admin_main_settings', 'sesariana', 'Global Settings', '', '{"route":"admin_default","module":"sesariana","controller":"settings"}', 'sesariana_admin_main', '', 1);