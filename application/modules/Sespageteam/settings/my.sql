/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_main_sespageteam", "sespage", "Team", "", '{"route":"admin_default","module":"sespageteam","controller":"settings"}', "sespage_admin_main", "", 800),
("sespageteam_admin_main_settings", "sespageteam", "Global Settings", "", '{"route":"admin_default","module":"sespageteam","controller":"settings"}', "sespageteam_admin_main", "", 1);
