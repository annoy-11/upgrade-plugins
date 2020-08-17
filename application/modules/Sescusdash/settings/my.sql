/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sescusdash', 'sescusdash', 'SES - Custom Dashboard', '', '{"route":"admin_default","module":"sescusdash","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sescusdash_admin_main_settings', 'sescusdash', 'Global Settings', '', '{"route":"admin_default","module":"sescusdash","controller":"settings"}', 'sescusdash_admin_main', '', 1);
