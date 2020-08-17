
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("sespage_admin_main_sespageveroth", "sespage", "Pages Verification", "", '{"route":"admin_default","module":"sespageveroth","controller":"settings"}', "sespage_admin_main", "", 999),
("sespageveroth_admin_main_settings", "sespageveroth", "Global Settings", "", '{"route":"admin_default","module":"sespageveroth","controller":"settings"}', "sespageveroth_admin_main", "", 1);
