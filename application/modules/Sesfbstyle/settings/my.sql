/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sesfbstyle', 'sesfbstyle', 'SES - Professional FB Clone', '', '{"route":"admin_default","module":"sesfbstyle","controller":"settings"}', 'core_admin_main', '', 888),
('sesfbstyle_admin_main_settings', 'sesfbstyle', 'Global Settings', '', '{"route":"admin_default","module":"sesfbstyle","controller":"settings"}', 'sesfbstyle_admin_main', '', 1);
