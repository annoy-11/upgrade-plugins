/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sesspectromedia', 'sesspectromedia', 'Responsive SpectroMedia', '', '{"route":"admin_default","module":"sesspectromedia","controller":"settings"}', 'core_admin_main', '', 888),
('sesspectromedia_admin_main_settings', 'sesspectromedia', 'Global Settings', '', '{"route":"admin_default","module":"sesspectromedia","controller":"settings"}', 'sesspectromedia_admin_main', '', 1);
