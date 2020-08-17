<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_Api_Core extends Core_Api_Abstract {

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
  
    public function getUserId($email) {

        $table = Engine_Api::_()->getDbTable('users','user');
        return Engine_Api::_()->getDbTable('users','user')->select()
                        ->from($table, array('user_id'))
                        ->where('email =?', $email)
                        ->query()
                        ->fetchColumn();
    }
  public function getModulesEnable(){
    $modules = Engine_Api::_()->getDbTable('modules','core')->getEnabledModuleNames();
    $moduleArray = array();
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

    $temp_path = dirname($photo['tmp_name']);
    $main_file_name = $temp_path . '/' . $photo['name'];
    $params = array(
        'parent_id' => $menuId,
        'parent_type' => "Sessportz_images",
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

    //For constant backup
    $filePath_sp = APPLICATION_PATH . "/application/modules/Sessportz/externals/styles/sessportz.xml";
    $results_sp = simplexml_load_file($filePath_sp);
    //For constant backup

    if (!empty($keys) && !empty($value) && ($keys != 'sessportz_body_background_image' || $keys != 'sessportz_footer_background_image')) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'sessportz_body_background_image' || $keys == 'sessportz_footer_background_image')) {
      $contactsThemeArray = array($keys => '');
    } elseif ($default_constants) {
      $contactsThemeArray = $default_constants;
    }

    //For constant backup at file path: /application/modules/Sessportz/externals/styles/sessportz.xml
    foreach ($contactsThemeArray as $key => $value) {
      $xmlNodes = $results_sp->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = $xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      $paramsVal = $params->value;
      if ($paramsVal && $paramsVal != '' && $paramsVal != null) {
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
