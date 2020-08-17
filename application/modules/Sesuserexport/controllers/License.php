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
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserexport.pluginactivated')) {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
      include_once APPLICATION_PATH . "/application/modules/Sesuserexport/controllers/defaultsettings.php";
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesuserexport.pluginactivated', 1);
    }
    $error = 1;
  }
}
