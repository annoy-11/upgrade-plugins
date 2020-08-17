<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessocialtube_Api_Core extends Core_Api_Abstract {

  public function setPhoto($photo, $menuId = null) {

    $temp_path = dirname($photo['tmp_name']);
    $main_file_name = $temp_path . '/' . $photo['name'];
    $params = array(
        'parent_id' => $menuId,
        'parent_type' => "Sessocialtube_images",
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

  public function getContantValueXML($key) {
    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);
    $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
    $nodeName = $xmlNodes[0];
    $value = $nodeName->value;
    return $value;
  }

  public function readWriteXML($keys, $value, $default_constants = null) {

    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);

    if (!empty($keys) && !empty($value) && ($keys != 'socialtube_body_background_image' || $keys != 'socialtube_footer_background_image')) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'socialtube_body_background_image' || $keys == 'socialtube_footer_background_image')) {
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
}