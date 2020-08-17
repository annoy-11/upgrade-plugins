<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Codes.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Model_DbTable_Codes extends Engine_Db_Table {
  public function getCode($code = null) {
    $select = $this->select()
                   ->from($this->info('name'));
    $select->where('code =?',$code)->limit(1);
    return $this->fetchRow($select);
  }
  function generateCode($user,$type = "login"){
    $response['error'] = 0;
    $response['message'] = "";
    $response['code'] = "";
    $translate = Zend_Registry::get('Zend_Translate');
    if(!$user){
      $response['message'] = $translate->translate("Invalid User");
      $response['error'] = 1;
      return $response;
    }

    //get latest row
    $select = $this->select()->where('user_id = ?',$user->getIdentity())->where('type =?',$type);
    $row = $this->fetchRow($select);
    $resntAttemps = Engine_Api::_()->authorization()->getPermission($user->level_id, 'otpsms', 'resend');
    $resend_count = 0;
    //curent time

    $creationDate = date('Y-m-d H:i:s');
    if($row && !empty($resntAttemps)){
      $resend_count = $row->resend_count;
      $modifiedDate = $row->modified_date;
      $creationDate = $row->creation_date;

      if( $resend_count >= $resntAttemps ) {
        //check block duration
        $blockDuration = Engine_Api::_()->authorization()->getPermission($user->level_id, 'otpsms', 'black_duration') ?: 86400;
        $lastRequestedTime = time() - strtotime($modifiedDate);
        if( $blockDuration > $lastRequestedTime ) {
          $blocktime = $blockDuration - $lastRequestedTime;
          $pendingtime = Engine_Api::_()->otpsms()->secondsToTime($blocktime);
          $response['error'] = 1;
          $response['message'] = sprintf($translate->translate('You have reached limit of attempts via OTP. Please wait for %s and try again.'), $pendingtime);
          return $response;
        }
      }
      
      //check reset time
      $reset_attempt = Engine_Api::_()->authorization()->getPermission($user->level_id, 'otpsms', 'reset_attempt') ?: 86400;
      $wait = time() - strtotime($creationDate);
      if( $reset_attempt < $wait ) {
        $resend_count = 0;
        $creationDate = date('Y-m-d H:i:s');
      }      
    }
      
    //delete old record of user
    $this->delete(array(
      'user_id = ?' => $user->getIdentity(),
      'type = ?' => $type
    ));    
    
    //generate code
    $code = Engine_Api::_()->otpsms()->generateCode();

    //inser new record
    $this->insert(array(
      'code' => $code,
      'creation_date' => $creationDate,
      'user_id' => $user->getIdentity(),
      'modified_date' => date('Y-m-d H:i:s'),
      'resend_count' => $resend_count + 1,
      'type' => $type,
    ));
    
    $response['error'] = 0;
    $response['code'] = $code;
    return $response;
    
  }
}