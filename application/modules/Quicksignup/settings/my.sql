/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("quicksignup_admin_main_quicksignup", "quicksignup", "SES - Quick & One Step Signup", "", '{"route":"admin_default","module":"quicksignup","controller":"settings"}', "core_admin_main_plugins", "", 800),
("quicksignup_admin_main_settings", "quicksignup", "Global Settings", "", '{"route":"admin_default","module":"quicksignup","controller":"settings"}', "quicksignup_admin_main", "", 1);
