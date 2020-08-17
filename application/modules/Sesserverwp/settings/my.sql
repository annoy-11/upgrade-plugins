/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
( 'core_admin_main_plugins_sesserverwp', 'sesserverwp', 'SES - SSO for WP', '', '{"route":"admin_default","module":"sesserverwp","controller":"settings"}', 'core_admin_main_plugins', '', 1, 0, 800),
( 'sesserverwp_admin_main_index', 'sesserverwp', 'Global Settings', '', '{"route":"admin_default","module":"sesserverwp","controller":"settings", "action":"index"}', 'sesserverwp_admin_main', '', 1, 0, 1);
