
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sesbody', 'sesbody', 'Responsive Body Theme', '', '{"route":"admin_default","module":"sesbody","controller":"settings"}', 'core_admin_main', '', 888),
('sesbody_admin_main_settings', 'sesbody', 'Global Settings', '', '{"route":"admin_default","module":"sesbody","controller":"settings"}', 'sesbody_admin_main', '', 1);
