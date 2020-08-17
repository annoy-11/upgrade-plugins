/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageurl
 * @package    Sespageurl
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('sespage_admin_main_sespageurl', 'sespageurl', 'Short URL', '', '{"route":"admin_default","module":"sespageurl","controller":"settings"}', 'sespage_admin_main', '', 999),
('sespageurl_admin_main_settings', 'sespageurl', 'Global Settings', '', '{"route":"admin_default","module":"sespageurl","controller":"settings"}', 'sespageurl_admin_main', '', 1);
