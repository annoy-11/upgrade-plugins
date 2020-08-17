/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_main_sespagevideo", "sespage", "Videos", "", '{"route":"admin_default","module":"sespagevideo","controller":"settings"}', "sespage_admin_main", "", 800),
("sespagevideo_admin_main_settings", "sespagevideo", "Global Settings", "", '{"route":"admin_default","module":"sespagevideo","controller":"settings"}', "sespagevideo_admin_main", "", 1);
