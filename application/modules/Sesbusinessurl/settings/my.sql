/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessurl
 * @package    Sesbusinessurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesbusiness_admin_main_sesbusinessurl', 'sesbusinessurl', 'Short URL', '', '{"route":"admin_default","module":"sesbusinessurl","controller":"settings"}', 'sesbusiness_admin_main', '', 999),
('sesbusinessurl_admin_main_settings', 'sesbusinessurl', 'Global Settings', '', '{"route":"admin_default","module":"sesbusinessurl","controller":"settings"}', 'sesbusinessurl_admin_main', '', 1);
