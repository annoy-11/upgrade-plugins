/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sesmaterial', 'sesmaterial', 'SES - Responsive Material Theme', '', '{"route":"admin_default","module":"sesmaterial","controller":"settings"}', 'core_admin_main', '', 888),
('sesmaterial_admin_main_settings', 'sesmaterial', 'Global Settings', '', '{"route":"admin_default","module":"sesmaterial","controller":"settings"}', 'sesmaterial_admin_main', '', 1);
