/**
* SocialEngineSolutions
*
* @category   Application_Estore
* @package    Estore
* @copyright  Copyright 2017-2018 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: my.sql  2018-07-13 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_plugins_estore", "estore", "SES - Stores Marketplace", "", '{"route":"admin_default","module":"estore","controller":"settings"}', "core_admin_main_plugins", "", 999),
("estore_admin_main_setting", "estore", "Global Settings", "", '{"route":"admin_default","module":"estore","controller":"settings"}', "estore_admin_main", "", 1),

("estore_admin_main_storesetting", "estore", "Store Global Settings", "", '{"route":"admin_default","module":"estore","controller":"settings"}', "estore_admin_main_setting", "", 1),

("sesproduct_main_manage", "sesproduct", "My Products", "Sesproduct_Plugin_Menus::canCreateSesproducts", '{"route":"sesproduct_general","action":"manage"}', "sesproduct_main", "", 7),

("sesproduct_add_cart_dropdown", "sesproduct", "Add To Cart", "Sesproduct_Plugin_Menus::addtocart", '{"route":"sesproduct_cart","module":"sesproduct"}', "core_mini", "", '6'),

("sesproduct_admin_main_currency", "sesproduct", "Manage Currency", "Sesproduct_Plugin_Menus::canViewMultipleCurrency", '{"route":"admin_default","module":"sesbasic","controller":"settings","action":"currency","target":"_blank"}', "sesproduct_admin_main_manageorde", "", 4);

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("estore_quick_create", "estore", "Create New Store", "Estore_Plugin_Menus::canCreateStores", '{"route":"estore_general","action":"create","class":"buttonlink icon_estore_new"}', "estore_quick", "", 1),

("sesproduct_main_browse", "sesproduct", "Browse Products", "Sesproduct_Plugin_Menus::canViewSesproducts", '{"route":"sesproduct_general","action":"browse"}', "estore_main", "", 6),

("sesproduct_main_location", "sesproduct", "Product Locations", "Sesproduct_Plugin_Menus::locationEnable", '{"route":"sesproduct_general","action":"locations"}', "estore_main", "", 11);

