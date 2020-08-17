
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescompany
 * @package    Sescompany
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sescompany', 'sescompany', 'SES - Company Theme', '', '{"route":"admin_default","module":"sescompany","controller":"settings"}', 'core_admin_main', '', 888),
('sescompany_admin_main_settings', 'sescompany', 'Global Settings', '', '{"route":"admin_default","module":"sescompany","controller":"settings"}', 'sescompany_admin_main', '', 1);
