/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sespagebuilder', 'sespagebuilder', 'SES - Page Builder and Shortcodes', '', '{"route":"admin_default","module":"sespagebuilder","controller":"settings"}', 'core_admin_main_plugins', '', 1),
('sespagebuilder_admin_main_settings', 'sespagebuilder', 'Global Settings', '', '{"route":"admin_default","module":"sespagebuilder","controller":"settings", "action":"index"}', 'sespagebuilder_admin_main', '', 1);