 /**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupurl
 * @package    Sesgroupurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sesgroup_admin_main_sesgroupurl', 'sesgroupurl', 'Short URL', '', '{"route":"admin_default","module":"sesgroupurl","controller":"settings"}', 'sesgroup_admin_main', '', 999),
('sesgroupurl_admin_main_settings', 'sesgroupurl', 'Global Settings', '', '{"route":"admin_default","module":"sesgroupurl","controller":"settings"}', 'sesgroupurl_admin_main', '', 1);
