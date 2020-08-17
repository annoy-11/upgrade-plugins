
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupveroth
 * @package    Sesgroupveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesgroup_admin_main_sesgroupveroth", "sesgroup", "Groups Verification", "", '{"route":"admin_default","module":"sesgroupveroth","controller":"settings"}', "sesgroup_admin_main", "", 999),
("sesgroupveroth_admin_main_settings", "sesgroupveroth", "Global Settings", "", '{"route":"admin_default","module":"sesgroupveroth","controller":"settings"}', "sesgroupveroth_admin_main", "", 1);
