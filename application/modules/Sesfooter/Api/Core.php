<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Api.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Api_Core extends Core_Api_Abstract {

  public function getContantValueXML($key) {
    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);
    $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
    $nodeName = @$xmlNodes[0];
    $value = @$nodeName->value;
    return $value;
  }

  public function readWriteXML($keys, $value, $default_constants = array()) {

    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);

    if (!empty($keys) && !empty($value) && ($keys != 'sm_footer_background_image')) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'sm_footer_background_image')) {
      $contactsThemeArray = array($keys => '');
    } elseif ($default_constants) {
      $contactsThemeArray = $default_constants;
    }

    foreach ($contactsThemeArray as $key => $value) {
      $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = @$xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      if(@$params->value)
        $paramsVal = $params->value;
      if (@$paramsVal && @$paramsVal != '' && @$paramsVal != null) {
        $nodeName->value = $value;
      } else {
        $entry = $results->addChild('constant');
        $entry->addChild('name', $key);
        $entry->addChild('value', $value);
      }
    }
    return $results->asXML($filePath);
  }

  public function getModulesEnable(){

    $modules = Engine_Api::_()->getDbTable('modules','core')->getEnabledModuleNames();
    $moduleArray = array();
    if(in_array('user',$modules))
      $moduleArray['user'] = 'Members';
    if(in_array('album',$modules))
      $moduleArray['album'] = 'Albums';
    if(in_array('blog',$modules))
      $moduleArray['blog'] = 'Blogs';
    if(in_array('video',$modules))
      $moduleArray['video'] = 'Videos';
    if(in_array('classified',$modules))
      $moduleArray['classified'] = 'Classifieds';
    if(in_array('group',$modules))
      $moduleArray['group'] = 'Groups';
    if(in_array('event',$modules))
      $moduleArray['event'] = 'Events';
    if(in_array('music_playlist',$modules))
      $moduleArray['music'] = 'Music';
    if(in_array('sesalbum',$modules))
      $moduleArray['sesalbum_album'] = 'Advanced Photos & Albums Plugin';
    if(in_array('sesblog',$modules))
      $moduleArray['sesblog_blog'] = 'Advanced Blog Plugin';
    if(in_array('sesvideo',$modules))
      $moduleArray['sesvideo_video'] = 'Advanced Videos & Channels Plugin';
    if(in_array('sesevent',$modules))
      $moduleArray['sesevent_event'] = 'SES - Advanced Events Plugin';
    if(in_array('sesmusic',$modules))
      $moduleArray['sesmusic_album'] = 'Advanced Music Albums, Songs & Playlists Plugin';
    return $moduleArray;
  }
}
