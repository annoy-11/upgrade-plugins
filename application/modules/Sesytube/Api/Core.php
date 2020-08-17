<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Api_Core extends Core_Api_Abstract {

  public function getCategory($limit) {

    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) {
        $catTable = Engine_Api::_()->getDbTable('categories', 'sesvideo');
    } else {
        $catTable = Engine_Api::_()->getDbTable('categories', 'video');
    }

    $catTableName = $catTable->info('name');

    $category_select = $catTable->select()
            ->from($catTableName, array('*'))->limit($limit);
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) {
        $category_select->where($catTableName . '.subcat_id = ?', 0)
                        ->where($catTableName . '.subsubcat_id = ?', 0);
        $category_select->order('order DESC');
    }


    return $catTable->fetchAll($category_select);
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

  public function getActiveMenuIcon($menuName) {

    $table = Engine_Api::_()->getDbTable('menuitems', 'core');
    $menuId =  $table->select()
                    ->from($table, 'id')
                    ->where('name =?', $menuName)
                    ->query()
                    ->fetchColumn();
    if($menuId){
      $row = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menuId);
    if($row)
      return $row->activeicon;
    }
   return false;
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
        'parent_type' => "sesytube_slideshow_image",
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
    $contactsThemeArray = array();
    if (!empty($keys) && !empty($value) && ($keys != 'ytube_body_background_image' || $keys != 'ytube_footer_background_image')) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'ytube_body_background_image' || $keys == 'ytube_footer_background_image')) {
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
}
