/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbusinessreview_admin_settings", "sesbusinessreview", "Review Settings", "", '{"route":"admin_default","module":"sesbusinessreview","controller":"manage", "action":"review-settings"}', "sesbusiness_admin_main", "", 999),
("sesbusinessreview_admin_main_reviewparametersettings", "sesbusinessreview", "Global Settings", "", '{"route":"admin_default","module":"sesbusinessreview","controller":"manage", "action":"review-settings"}', "sesbusinessreview_admin_settings", "", 1),
("sesbusiness_main_businessreviews", "sesbusinessreview", "Reviews", "Sesbusinessreview_Plugin_Menus::reviewEnable", '{"route":"sesbusinessreview_review","action":"home"}', "sesbusiness_main", "", 999),
("sesbusiness_main_topbusinesses", "sesbusiness", "Top Rated Business", "Sesbusinessreview_Plugin_Menus::reviewEnable", '{"route":"sesbusiness_general","action":"top-businesses"}', "sesbusiness_main", "", 999);
