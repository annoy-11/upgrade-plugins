<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Core.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Api_Core extends Core_Api_Abstract {

  public function getFileUrl($image) {
    
    $table = Engine_Api::_()->getDbTable('files', 'core');
    $result = $table->select()
                ->from($table->info('name'), 'storage_file_id')
                ->where('storage_path =?', $image)
                ->query()
                ->fetchColumn();
    if(!empty($result)) {
      $storage = Engine_Api::_()->getItem('storage_file', $result);
      return $storage->map();
    } else {
      return $image;
    }
  }
  
  public function getRow(Core_Model_Item_Abstract $resource, User_Model_User $user) {

    $id = $resource->getIdentity() . '_' . $user->getIdentity();
    $table = Engine_Api::_()->getDbTable('membership', 'user');
    $select = $table->select()
            ->where('resource_id = ?', $resource->getIdentity())
            ->where('user_id = ?', $user->getIdentity());
    $select = $select->limit(1);
    $row = $table->fetchRow($select);
    return $row;
  }
  
  public function getLanguages() {

    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    //$currentLocale = Zend_Registry::get('Locale')->__toString();
    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if (!in_array($defaultLanguage, $languageList)) {
      if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }

    // Prepare language name list
    $languageNameList = array();
    $languageDataList = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');

    foreach ($languageList as $localeCode) {
      $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
      if (empty($languageNameList[$localeCode])) {
        if (false !== strpos($localeCode, '_')) {
          list($locale, $territory) = explode('_', $localeCode);
        } else {
          $locale = $localeCode;
          $territory = null;
        }
        if (isset($territoryDataList[$territory]) && isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
        } else if (isset($territoryDataList[$territory])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory];
        } else if (isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $languageDataList[$locale];
        } else {
          continue;
        }
      }
    }
    return array_merge(array($defaultLanguage => $defaultLanguage), $languageNameList);
  }
  
  public function postCount($subject_id) {

    $actionTable = Engine_Api::_()->getDbTable('actions', 'activity');
    $actionTableName = $actionTable->info('name');

    $select = $actionTable->select()
                ->from($actionTable, array('action_id'))
                ->where('subject_id =?', $subject_id);
    $results = $actionTable->fetchAll($select);
    return $this->number_format_short(count($results));

  }
  
  public function number_format_short( $n, $precision = 1 ) {
    if ($n < 900) {
      // 0 - 900
      $n_format = number_format($n, $precision);
      $suffix = '';
    } else if ($n < 900000) {
      // 0.9k-850k
      $n_format = number_format($n / 1000, $precision);
      $suffix = 'K';
    } else if ($n < 900000000) {
      // 0.9m-850m
      $n_format = number_format($n / 1000000, $precision);
      $suffix = 'M';
    } else if ($n < 900000000000) {
      // 0.9b-850b
      $n_format = number_format($n / 1000000000, $precision);
      $suffix = 'B';
    } else {
      // 0.9t+
      $n_format = number_format($n / 1000000000000, $precision);
      $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ( $precision > 0 ) {
      $dotzero = '.' . str_repeat( '0', $precision );
      $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
  }

    
  public function setPhotoIcons($photo, $menuId = null) {

    $temp_path = dirname($photo['tmp_name']);
    $main_file_name = $temp_path . '/' . $photo['name'];
    $params = array('parent_id' => $menuId, 'parent_type' => "instaclone");
    $image = Engine_Image::factory();
    $image->open($photo['tmp_name']);
    $image->open($photo['tmp_name'])
            ->resample(0, 0, $image->width, $image->height, $image->width, $image->height)
            ->write($main_file_name)
            ->destroy();
    try {
      $photo_params = Engine_Api::_()->storage()->create($main_file_name, $params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }
    return $photo_params;
  }

  public function getContantValueXML($key) {
    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);
    $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
    $nodeName = @$xmlNodes[0];
    $value = @$nodeName->value;
    return $value;
  }

  public function readWriteXML($keys, $value, $default_constants = null) {

    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);

    if (!empty($keys) && !empty($value)) {
        $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys)) {
        $contactsThemeArray = array($keys => '');
    } elseif ($default_constants) {
        $contactsThemeArray = $default_constants;
    }

    foreach ($contactsThemeArray as $key => $value) {
      $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = @$xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      $paramsVal = @$params->value;
      if ($paramsVal && $paramsVal != '' && $paramsVal != null) {
          $nodeName->value = $value;
      } else {
          $entry = $results->addChild('constant');
          $entry->addChild('name', $key);
          $entry->addChild('value', $value);
      }
    }
    return $results->asXML($filePath);
  }

  public function hasCheckMessage($user) {

    // Not logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity() || $viewer->getGuid(false) === $user->getGuid(false)) {
      return false;
    }

    // Get setting?
    $permission = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'messages', 'create');
    if (Authorization_Api_Core::LEVEL_DISALLOW === $permission) {
      return false;
    }
    $messageAuth = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'messages', 'auth');
    if ($messageAuth == 'none') {
      return false;
    } else if ($messageAuth == 'friends') {
      // Get data
      $direction = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('user.friends.direction', 1);
      if (!$direction) {
        //one way
        $friendship_status = $viewer->membership()->getRow($user);
      } else
        $friendship_status = $user->membership()->getRow($viewer);

      if (!$friendship_status || $friendship_status->active == 0) {
        return false;
      }
    }
    return true;
  }
}
