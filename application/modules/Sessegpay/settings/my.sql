/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sessegpay', 'sessegpay', 'SES - SegPay Member...', '', '{"route":"admin_default","module":"sessegpay","controller":"settings","action":"index"}', 'core_admin_main_plugins', '', 999),
('sessegpay_admin_main_settings', 'sessegpay', 'Global Settings', '', '{"route":"admin_default","module":"sessegpay","controller":"settings"}', 'sessegpay_admin_main', '', 1);
