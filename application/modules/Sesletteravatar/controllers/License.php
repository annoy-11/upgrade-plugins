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

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.pluginactivated')) {

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sesletteravatar_admin_main_styling", "sesletteravatar", "Styling Settings", "", \'{"route":"admin_default","module":"sesletteravatar","controller":"settings", "action":"styling"}\', "sesletteravatar_admin_main", "", 2);');
      include_once APPLICATION_PATH . "/application/modules/Sesletteravatar/controllers/defaultsettings.php";
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesletteravatar.pluginactivated', 1);
    }
    $error = 1;
  }
}
