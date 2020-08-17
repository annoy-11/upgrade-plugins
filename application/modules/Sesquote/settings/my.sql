
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("core_admin_main_settings_sesquote", "sesquote", "SES - Quotes", "", '{"route":"admin_default","module":"sesquote","controller":"settings","action":"index"}', "core_admin_main_plugins", "", 1),
("sesquote_admin_main_settings", "sesquote", "Global Settings", "", '{"route":"admin_default","module":"sesquote","controller":"settings","action":"index"}', "sesquote_admin_main", "", 1),
("sesquote_main_create", "sesquote", "Write New Quote", "Sesquote_Plugin_Menus::canCreateQuotes", '{"route":"sesquote_general","action":"create", "class":"smoothbox"}', "sesquote_main", "", 3);
