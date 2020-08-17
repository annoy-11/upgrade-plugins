/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sesgroup_admin_main_sesgroupforum", "sesgroup", "Forums", "", '{"route":"admin_default","module":"sesgroupforum","controller":"settings"}', "sesgroup_admin_main", "", 802),
("sesgroupforum_admin_main_settings", "sesgroupforum", "Global Settings", "", '{"route":"admin_default","module":"sesgroupforum","controller":"settings"}', "sesgroupforum_admin_main", "", 1);
