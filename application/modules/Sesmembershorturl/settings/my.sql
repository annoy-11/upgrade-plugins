/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesmerurl', 'sesmembershorturl', 'SES - Custom & Short Member...', '', '{"route":"admin_default","module":"sesmembershorturl","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesmembershorturl_admin_main_settings', 'sesmembershorturl', 'Global Settings', '', '{"route":"admin_default","module":"sesmembershorturl","controller":"settings"}', 'sesmembershorturl_admin_main', '', 1);
