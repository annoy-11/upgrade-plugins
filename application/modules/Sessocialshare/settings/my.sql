
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sessocialshare', 'sessocialshare', 'SES - Professional Share', '', '{"route":"admin_default","module":"sessocialshare","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sessocialshare_admin_main_settings', 'sessocialshare', 'Global Settings', '', '{"route":"admin_default","module":"sessocialshare","controller":"settings"}', 'sessocialshare_admin_main', '', 1);
