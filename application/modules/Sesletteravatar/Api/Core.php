<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesletteravatar_Api_Core extends Core_Api_Abstract {

  public function getUsersData() {
  
    $table = Engine_Api::_()->getItemTable('user');
    $tableName = $table->info('name');
    $select = $table->select()->from($tableName, new Zend_Db_Expr('COUNT(user_id) as total'))->where('photo_id =?', 0);
    $data = $table->fetchRow($select);
    return (int) $data->total;
  }
  
  public function letterAvatar($user, $displayName = null) {
  
    require_once 'application/modules/Sesletteravatar/Api/LetterAvatar.php';

    /*get texts first letter and convert to uppercase*/

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $lettersSettings = $settings->getSetting('sesletteravatar.letters', 1);
    $countchar = $settings->getSetting('sesletteravatar.countchar', 1);
    
    $color = $settings->getSetting('sesletteravatar.textcolor', '#FFF'); 
    
    $bgColor = '';
    $imagbgcolor = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.imagbgcolor', 0);
    if($imagbgcolor) {
      $bgColor = $settings->getSetting('sesletteravatar.imagebackgroundcolor', '#ffffff');
    }

    $text = '';
    if($displayName) {
      $title = strtoupper(strip_tags($displayName));
    } else {
      $title = strtoupper(strip_tags($user->getTitle()));
    }
    
    if($lettersSettings == 1) {
      $name = explode(" ", $title);
      if(isset($name[0])) {
        $text .= substr($name[0], 0, 1);
      }
      if(isset($name[1])) {
        $text .= substr($name[1], 0, 1);
      }
    } else if($lettersSettings == 2) {
      $name = explode(" ", $title);
      if(isset($name[0])) {
        $text .= substr($name[0], 0, 1);
      }
    } else if($lettersSettings == 3) {
      $text .= substr($title, 0, $countchar);
    }

    /*create class object*/
    $phptextObj = new phptextClass();
    
    /*phptext function to genrate image with text*/
    $fileNew = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.time().'_'.".jpg";
    
    $file = $phptextObj->phptext($text,$color, $bgColor, $settings->getSetting('sesletteravatar.fontsize', 150),$settings->getSetting('sesletteravatar.imageheight', 400),$settings->getSetting('sesletteravatar.imagewidth', 400),$fileNew); 
    
    if(!empty($file)) {

      $storage = Engine_Api::_()->getItemTable('storage_file');
      $storageObject = $storage->createFile(@$fileNew, array(
        'parent_id' => $user->getIdentity(),
        'parent_type' => $user->getType(),
        'user_id' => $user->getIdentity(),
      ));
      
      // Remove temporary file
      @unlink($fileNew);
      Engine_Api::_()->getDbtable('users', 'user')->update(array('photo_id'=>  $storageObject->file_id), array('user_id =?' => $user->getIdentity()));
//       $user->photo_id = $storageObject->file_id;
//       $user->save();
    }
  }
  
  public function getprofileFieldValue($params = array()) {

    $valuesTable = Engine_Api::_()->fields()->getTable('user', 'values');
    $valuesTableName = $valuesTable->info('name');
    return $valuesTable->select()
                ->from($valuesTableName, array('value'))
                ->where($valuesTableName . '.item_id = ?', $params['user_id'])
                ->where($valuesTableName . '.field_id = ?', $params['field_id'])->query()
                ->fetchColumn();  
  }
  
  public function getFieldId($typeField = array(), $profile_type) {
  
    $metaTable = Engine_Api::_()->fields()->getTable('user', 'meta');
    $metaTableName = $metaTable->info('name');
    
    $mapsTable = Engine_Api::_()->fields()->getTable('user', 'maps');
    $mapsTableName = $mapsTable->info('name');

    return $metaTable->select()
              ->setIntegrityCheck(false)
              ->from($metaTableName, array('field_id'))
              ->joinLeft($mapsTableName, "$metaTableName.field_id = $mapsTableName.child_id", null)
              ->where($mapsTableName . '.option_id = ?', $profile_type)
              ->where($metaTableName . '.display = ?', '1')
              ->where($metaTableName . '.type IN (?)', (array) $typeField)
              ->query()
              ->fetchColumn();
  
  
  }
  
  
}