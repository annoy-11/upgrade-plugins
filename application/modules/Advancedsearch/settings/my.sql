/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("advancedsearch_admin_main_advancedsearch", "advancedsearch", "SES - Professional Search Plugin", "", '{"route":"admin_default","module":"advancedsearch","controller":"settings"}', "core_admin_main_plugins", "", 800),
("advancedsearch_admin_main_settings", "advancedsearch", "Global Settings", "", '{"route":"admin_default","module":"advancedsearch","controller":"settings"}', "advancedsearch_admin_main", "", 1);
