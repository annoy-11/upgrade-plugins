/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_seslinkedin', 'seslinkedin', 'Professional Linkedin Clone', '', '{"route":"admin_default","module":"seslinkedin","controller":"settings"}', 'core_admin_main', '', 888),
('seslinkedin_admin_main_settings', 'seslinkedin', 'Global Settings', '', '{"route":"admin_default","module":"seslinkedin","controller":"settings"}', 'seslinkedin_admin_main', '', 1);
