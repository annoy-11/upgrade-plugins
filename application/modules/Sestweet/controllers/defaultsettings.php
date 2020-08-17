<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$select = new Zend_Db_Select($db);
$select->from('engine4_core_modules', 'version')
        ->where('name = ?', 'core');
$results = $select->query()->fetchObject();
Engine_Api::_()->getApi('settings', 'core')->setSetting('sestweet.coreversion', $results->version);
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sestweet_admin_main_faq", "sestweet", "FAQ", "", \'{"route":"admin_default","module":"sestweet","controller":"settings","action":"faq"}\', "sestweet_admin_main", "", 568);');