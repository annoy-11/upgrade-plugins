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

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.pluginactivated')) {

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
      ("sesmembershorturl_admin_main_level", "sesmembershorturl", "Member Level Settings", "", \'{"route":"admin_default","module":"sesmembershorturl","controller":"level"}\', "sesmembershorturl_admin_main", "", 4);');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesmembershorturl" as `type`,
        "enablecustomurl" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');

      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesmembershorturl" as `type`,
        "enablecustomurl" as `name`,
        2 as `value`,
        NULL as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesmembershorturl" as `type`,
        "customurltext" as `name`,
        3 as `value`,
        "profile" as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
      $db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
      SELECT
        level_id as `level_id`,
        "sesmembershorturl" as `type`,
        "customurltext" as `name`,
        3 as `value`,
        "profile" as `params`
      FROM `engine4_authorization_levels` WHERE `type` IN("user");');
      include_once APPLICATION_PATH . "/application/modules/Sesmembershorturl/controllers/defaultsettings.php";\
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesmembershorturl.pluginactivated', 1);
    }
    $error = 1;
  }
}
