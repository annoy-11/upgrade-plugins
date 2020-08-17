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

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinviter.pluginactivated')) {

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesinviter_admin_main_managesocialmedia", "sesinviter", "Manage Social Media Keys", "", \'{"route":"admin_default","module":"sesinviter","controller":"settings","action":"social-media-key"}\', "sesinviter_admin_main", "", 999);');

      $db->query('INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES
      ("sesinviter_invitation", "sesinviter", "[host],[email],[sender_title],[subject],[message]");');

      $db->query('DROP TABLE IF EXISTS `engine4_sesinviter_invites`;');
      $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesinviter_invites` (
        `invite_id` int(10) unsigned NOT NULL auto_increment,
        `sender_id` int(11) unsigned NOT NULL,
        `recipient_email` varchar(255) NOT NULL,
        `creation_date` datetime NOT NULL,
        `subject` text NOT NULL,
        `message` text NOT NULL,
        `new_user_id` int(11) unsigned NOT NULL default "0",
        `import_method` VARCHAR(255) NOT NULL,
        PRIMARY KEY  (`invite_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_unicode_ci ;');

      include_once APPLICATION_PATH . "/application/modules/Sesinviter/controllers/defaultsettings.php";

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesinviter.pluginactivated', 1);
    }
    $error = 1;
  }
}
