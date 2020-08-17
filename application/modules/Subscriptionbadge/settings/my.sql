/**
 * SocialEngineSolutions
 *
 * @category   Application_Subscriptionbadge
 * @package    Subscriptionbadge
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_subscriptionbadge', 'subscriptionbadge', 'SES - Membership Subscription Badge', '', '{"route":"admin_default","module":"subscriptionbadge","controller":"settings"}', 'core_admin_main_plugins', '', 999),
("subscriptionbadge_admin_main_settings", "subscriptionbadge", "Global Settings", "", '{"route":"admin_default","module":"subscriptionbadge","controller":"settings"}', "subscriptionbadge_admin_main", "", 1);
