/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespagereview_admin_settings", "sespagereview", "Review Settings", "", '{"route":"admin_default","module":"sespagereview","controller":"manage", "action":"review-settings"}', "sespage_admin_main", "", 999),
("sespagereview_admin_main_reviewparametersettings", "sespagereview", "Global Settings", "", '{"route":"admin_default","module":"sespagereview","controller":"manage", "action":"review-settings"}', "sespagereview_admin_settings", "", 1),
("sespage_main_pagereviews", "sespagereview", "Reviews", "Sespagereview_Plugin_Menus::reviewEnable", '{"route":"sespagereview_review","action":"home"}', "sespage_main", "", 999),
("sespage_main_toppages", "sespage", "Top Rated Page", "Sespagereview_Plugin_Menus::reviewEnable", '{"route":"sespage_general","action":"top-pages"}', "sespage_main", "", 999);
