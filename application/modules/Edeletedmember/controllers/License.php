<?php

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {


  //here we can set some variable for checking in plugin files.
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('edeletedmember.pluginactivated')) {

        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        
        $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("edeletedmember_admin_main_members", "edeletedmember", "Deleted Members", "", \'{"route":"admin_default","module":"edeletedmember","controller":"manage"}\', "edeletedmember_admin_main", "", 2);');
        
        $db->query('DROP TABLE IF EXISTS `engine4_edeletedmember_members`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_edeletedmember_members` (
          `member_id` int(11) unsigned NOT NULL auto_increment,
          `email` varchar(128) NOT NULL,
          `username` varchar(128) default NULL,
          `displayname` varchar(128) NOT NULL default "",
          `creation_date` datetime NOT NULL,
          `creation_ip` varbinary(16) NOT NULL,
          `modified_date` datetime NOT NULL,
          `deletion_date` datetime NOT NULL,
          PRIMARY KEY  (`member_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;');

        include_once APPLICATION_PATH . "/application/modules/edeletedmember/controllers/defaultsettings.php";

        Engine_Api::_()->getApi('settings', 'core')->setSetting('edeletedmember.pluginactivated', 1);
    }
    $error = 1;
  } 
}
