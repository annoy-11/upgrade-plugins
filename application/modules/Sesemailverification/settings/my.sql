/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesemailverification', 'sesemailverification', 'SES - Email Verification...', '', '{"route":"admin_default","module":"sesemailverification","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesemailverification_admin_main_settings', 'sesemailverification', 'Global Settings', '', '{"route":"admin_default","module":"sesemailverification","controller":"settings"}', 'sesemailverification_admin_main', '', 1);
