/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES

('sesgroup_admin_main_sesgrouppoll', 'sesgroup', 'Polls', '', '{"route":"admin_default","module":"sesgrouppoll","controller":"settings"}', 'sesgroup_admin_main', '', 999),

('sesgrouppoll_admin_main_settings', 'sesgrouppoll', 'Global Settings', '', '{"route":"admin_default","module":"sesgrouppoll","controller":"settings"}', 'sesgrouppoll_admin_main', '', 1);
