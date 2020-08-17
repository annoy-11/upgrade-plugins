
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sespopupbuilder', 'sespopupbuilder', 'SES - Popup Builder', '', '{"route":"admin_default","module":"sespopupbuilder","controller":"settings"}', 'core_admin_main_plugins', '', 999),
('sespopupbuilder_admin_main_settings', 'sespopupbuilder', 'Global Settings', '', '{"route":"admin_default","module":"sespopupbuilder","controller":"settings"}', 'sespopupbuilder_admin_main', '', 1);
