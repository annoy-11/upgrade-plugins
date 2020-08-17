
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql 2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesseo', 'sesseo', 'SES - Advanced SEO...', '', '{"route":"admin_default","module":"sesseo","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sesseo_admin_main_settings', 'sesseo', 'Global Settings', '', '{"route":"admin_default","module":"sesseo","controller":"settings"}', 'sesseo_admin_main', '', 1);
