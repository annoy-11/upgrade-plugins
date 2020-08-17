<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Edeletedmember
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-11-04 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Edeletedmember_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onUserDeleteBefore($event) {

    $payload = $event->getPayload();
    if( $payload instanceof User_Model_User ) {
    
      $table = Engine_Api::_()->getDbTable('members', 'edeletedmember');
      $tableName = $table->info('name');
      
      $row = $table->createRow();
      $row->setFromArray($payload->toArray());
      $row->save();
      $row->deletion_date = date('Y-m-d H:i:s');
      $row->save();
      $row->creation_date = $payload->creation_date;
      $row->modified_date = $payload->creation_date;
      $row->save();
    }
  }
}
