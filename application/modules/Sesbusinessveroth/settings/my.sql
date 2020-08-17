
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessveroth
 * @package    Sesbusinessveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesbusiness_admin_main_sesbusinessveroth", "sesbusiness", "Businesses Verification", "", '{"route":"admin_default","module":"sesbusinessveroth","controller":"settings"}', "sesbusiness_admin_main", "", 999),
("sesbusinessveroth_admin_main_settings", "sesbusinessveroth", "Global Settings", "", '{"route":"admin_default","module":"sesbusinessveroth","controller":"settings"}', "sesbusinessveroth_admin_main", "", 1);
