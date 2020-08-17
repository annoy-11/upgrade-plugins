/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_sespagethm', 'sespagethm', 'SES - Page Theme', '', '{"route":"admin_default","module":"sespagethm","controller":"settings"}', 'core_admin_main', '', 888),
('sespagethm_admin_main_settings', 'sespagethm', 'Global Settings', '', '{"route":"admin_default","module":"sespagethm","controller":"settings"}', 'sespagethm_admin_main', '', 1);
