<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbody_Api_Core extends Core_Api_Abstract {

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
    
    //For constant backup
    $filePath_sp = APPLICATION_PATH . "/application/modules/Sesbody/externals/styles/sesbody.xml";
    $results_sp = simplexml_load_file($filePath_sp);
    //For constant backup

    if ($keys == "sesbutton_effacts" || $keys == "sesbody_widget_background_image" || (!empty($keys) && !empty($value) && ($keys != 'sesbody_body_background_image' || $keys != 'sesbody_footer_background_image'))) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'sesbody_body_background_image' || $keys == 'sesbody_footer_background_image')) {
      $contactsThemeArray = array($keys => '');
    } elseif ($default_constants) {
      $contactsThemeArray = $default_constants;
    }
    
    //For constant backup at file path: /application/modules/Sesbody/externals/styles/sesbody.xml
    foreach ($contactsThemeArray as $key => $value) { 
      $xmlNodes = $results_sp->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = $xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      $paramsVal = $params->value;
      if ($paramsVal != null) {
        $nodeName->value = $value;
      } else {
        $entry_sp = $results_sp->addChild('constant');
        $entry_sp->addChild('name', $key);
        $entry_sp->addChild('value', $value);
      }
    }
    $results_sp->asXML($filePath_sp);
    //For constant backup

    foreach ($contactsThemeArray as $key => $value) {
      $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = $xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      $paramsVal = $params->value;
      if ($paramsVal != null) {
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