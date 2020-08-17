<?php

class Sesemailverification_Plugin_Task_Autosuspend extends Core_Plugin_Task_Abstract {

  public function execute() {

    $db = Engine_Db_Table::getDefaultAdapter();
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.autoaccsuspend', 0)) {

      $pluginactivationdate = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.pluginactivationdate');

      if($pluginactivationdate) {
        $autoaccsuspendday = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.autoaccsuspendday', 20);

        $pastdate =  date('Y-m-d', strtotime('-'.$autoaccsuspendday.' days'));
        $todaydate =  date('Y-m-d');

        $db->query("UPDATE `engine4_users` SET approved = '0' WHERE `user_id` IN (select u.user_id FROM (SELECT * from engine4_users) as u left join engine4_sesemailverification_verifications on u.user_id=engine4_sesemailverification_verifications.user_id WHERE (creation_date >= '$pluginactivationdate') AND (sesemailverified ='0') AND (DATE(creation_date) between ('$pastdate') and ('$todaydate')));");
      }
    }
  }
}
