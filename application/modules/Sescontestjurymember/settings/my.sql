
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontestjurymember
 * @package    Sescontestjurymember
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sescontestjurymember_admin_main", "sescontestjurymember", "Voting by Jury Members", "", '{"route":"admin_default","module":"sescontestjurymember","controller":"settings"}', "sescontest_admin_main", "", 996),
('sescontestjurymember_admin_main_settings', 'sescontestjurymember', 'Global Settings', '', '{"route":"admin_default","module":"sescontestjurymember","controller":"settings"}', 'sescontestjurymember_admin_main', '', 1);