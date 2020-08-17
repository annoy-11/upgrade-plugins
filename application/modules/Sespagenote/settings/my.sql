/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_main_sespagenote", "sespage", "Notes", "", '{"route":"admin_default","module":"sespagenote","controller":"settings"}', "sespage_admin_main", "", 800),
("sespagenote_admin_main_settings", "sespagenote", "Global Settings", "", '{"route":"admin_default","module":"sespagenote","controller":"settings"}', "sespagenote_admin_main", "", 1);
