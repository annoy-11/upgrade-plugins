/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbusiness_admin_main_sesbusinessoffer", "sesbusiness", "Offers", "", '{"route":"admin_default","module":"sesbusinessoffer","controller":"settings"}', "sesbusiness_admin_main", "", 800),
("sesbusinessoffer_admin_main_settings", "sesbusinessoffer", "Global Settings", "", '{"route":"admin_default","module":"sesbusinessoffer","controller":"settings"}', "sesbusinessoffer_admin_main", "", 1);
