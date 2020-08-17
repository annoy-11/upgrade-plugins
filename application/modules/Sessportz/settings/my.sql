/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sessportz', 'sessportz', 'SES - Responsive Sportz Theme', '', '{"route":"admin_default","module":"sessportz","controller":"settings"}', 'core_admin_main', '', 888),
('sessportz_admin_main_settings', 'sessportz', 'Global Settings', '', '{"route":"admin_default","module":"sessportz","controller":"settings"}', 'sessportz_admin_main', '', 1);
