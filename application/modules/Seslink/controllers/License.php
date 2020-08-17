<?php

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {
  if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslink.pluginactivated')) {
  
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();


    include_once APPLICATION_PATH . "/application/modules/Seslink/controllers/defaultsettings.php";

    Engine_Api::_()->getApi('settings', 'core')->setSetting('seslink.pluginactivated', 1);
  }
}