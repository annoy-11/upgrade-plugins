/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_main_sespageoffer", "sespage", "Offers", "", '{"route":"admin_default","module":"sespageoffer","controller":"settings"}', "sespage_admin_main", "", 800),
("sespageoffer_admin_main_settings", "sespageoffer", "Global Settings", "", '{"route":"admin_default","module":"sespageoffer","controller":"settings"}', "sespageoffer_admin_main", "", 1);
