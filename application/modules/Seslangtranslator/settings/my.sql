/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslangtranslator
 * @package    Seslangtranslator
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-08-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_seslangtranslator', 'seslangtranslator', 'SES - Multiple Language...', '', '{"route":"admin_default","module":"seslangtranslator","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('seslangtranslator_admin_main_settings', 'seslangtranslator', 'Global Settings', '', '{"route":"admin_default","module":"seslangtranslator","controller":"settings"}', 'seslangtranslator_admin_main', '', 1);
