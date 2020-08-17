
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmetatag
 * @package    Sesmetatag
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesmetatag', 'sesmetatag', 'SES - Social Meta Tags', '', '{"route":"admin_default","module":"sesmetatag","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesmetatag_admin_main_settings', 'sesmetatag', 'Global Settings', '', '{"route":"admin_default","module":"sesmetatag","controller":"settings"}', 'sesmetatag_admin_main', '', 1);
