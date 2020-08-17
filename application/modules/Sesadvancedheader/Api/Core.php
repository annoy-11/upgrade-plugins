<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Api_Core extends Core_Api_Abstract {

  public function setPhotoIcons($photo, $menuId = null) {

    $temp_path = dirname($photo['tmp_name']);
    $main_file_name = $temp_path . '/' . $photo['name'];
    $params = array(
        'parent_id' => $menuId,
        'parent_type' => "sesadvancedheader_images",
    );
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

  public function getMenuIcon($menuName) {

    $table = Engine_Api::_()->getDbTable('menuitems', 'core');
    $menuId =  $table->select()
                    ->from($table, 'id')
                    ->where('name =?', $menuName)
                    ->query()
                    ->fetchColumn();
    if($menuId){
      $row = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menuId);
    if($row)
      return $row->icon_id;
    }
    return false;
  }

  public function setPhoto($photo, $menuId = null) {

    //GET PHOTO DETAILS
    $mainName = dirname($photo['tmp_name']) . '/' . $photo['name'];

    //GET VIEWER ID
    $photo_params = array(
        'parent_id' => $menuId,
        'parent_type' => "sesadvancedheader_slideshow_image",
    );
    copy($photo['tmp_name'], $mainName);
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }

    return $photoFile;
  }

  public function getContantValueXML($key,$defaultValue = "") {

    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);
    $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
    $nodeName = $xmlNodes[0];
    $value = $nodeName->value;
    if(is_null($value))
      return $defaultValue;
    return $value;
  }

  public function readWriteXML($keys, $value, $default_constants = null) {

    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);

    if (!empty($keys) && !empty($value) && ($keys != 'sesadvancedheader_body_background_image' || $keys != 'sesadvancedheader_footer_background_image')) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'sesadvancedheader_body_background_image' || $keys == 'sesadvancedheader_footer_background_image')) {
      $contactsThemeArray = array($keys => '');
    } elseif ($default_constants) {
      $contactsThemeArray = $default_constants;
    }

    foreach ($contactsThemeArray as $key => $value) {
      $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = $xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      $paramsVal = $params->value;
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

  public function getValue($key = "",$results = array()){

    if($key){
      foreach($results as $result){
        if(($result['column_key'] == $key))
        {
          return $result['value'];
        }
      }
    }
    return "";
  }

  public function getHeaderKeyValue($key = "",$result = array(),$defaultValue = ""){

    $value = $this->getValue($key,$result);
    if($key && !empty($value)) {
      return $value;
    } else if($defaultValue) {
        return $defaultValue;
    } else {
      //return own default value
    }
  }
}
