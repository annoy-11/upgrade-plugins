
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontestjoinfees
 * @package    Sescontestjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sescontestjoinfees_admin_main", "sescontestjoinfees", "Contest Joining Fees", "", '{"route":"admin_default","module":"sescontestjoinfees","controller":"settings", "action":"extension"}', "sescontest_admin_main", "", 995),
('sescontestjoinfees_admin_main_settings', 'sescontestjoinfees', 'Global Settings', '', '{"route":"admin_default","module":"sescontestjoinfees","controller":"settings","action":"extension"}', 'sescontestjoinfees_admin_main', '', 1),
("sescontestjoinfees_admin_main_currency", "sescontestjoinfees", "Manage Currency", "Sescontestjoinfees_Plugin_Menus::canViewMultipleCurrency", '{"route":"admin_default","module":"sesmultiplecurrency","controller":"settings","action":"currency","target":"_blank"}', "sescontestjoinfees_admin_main", "", 5),
("sescontestjoinfees_main_myorders", "sescontestjoinfees", "My Orders", "Sescontestjoinfees_Plugin_Menus::canViewOrders", '{"route":"sescontestjoinfees_user_order","controller":"index","action":"view"}', "sescontest_main", "", 10);

