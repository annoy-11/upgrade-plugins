/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesssoserver', 'sesssoserver', 'SES - SSO Server', '', '{"route":"admin_default","module":"sesssoserver","controller":"settings", "action":"globalsettings"}', 'core_admin_main_plugins', '', 999),
('sesssoserver_admin_main_generalsettings', 'sesssoserver', 'Global Settings', '', '{"route":"admin_default","module":"sesssoserver","controller":"settings", "action":"globalsettings"}', 'sesssoserver_admin_main', '', 1);
