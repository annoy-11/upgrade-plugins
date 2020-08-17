<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Epetition.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Epetition_Model_Epetition extends Core_Model_Item_Abstract
{
  //Properties
  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_searchTriggers = array('title', 'body', 'search');
  protected $_type = 'epetition';
  protected $_statusChanged;

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   **/
  public function getDescription($limit = '255') {
    $body = $this->body;
    $stringArray  =  Engine_Api::_()->sesbasic()->get_string_between($this->body);
    foreach ($stringArray as $array){
      if($array){
        $body = str_replace("[".$array."]","",$body);
      }
    }
    // @todo decide how we want to handle multibyte string functions
    $ro = preg_replace('/\s+/', ' ',$body);
    $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));
    return nl2br( Engine_String::strlen($tmpBody) > $limit ? Engine_String::substr($tmpBody, 0, $limit) . '...' : $tmpBody );
  }


  public function getHref($params = array()) {
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'epetition_entry_view',
      'reset' => true,
      // 'user_id' => $this->owner_id,
      'epetition_id' => $slug,
      //'slug' => $slug,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }


  public function fields()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getApi('core', 'fields'));
  }

  public function comments()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }



  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   **/
  public function likes()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }

  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   **/
  public function tags()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }

  public function getPhotoUrl($type = null) {
    $photo_id = $this->photo_id;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, $type);
      if($file)
        return $file->map();
      else{
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id,'thumb.profile');
        if($file)
          return $file->map();
      }
    }
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultPhoto = Zend_Registry::get('StaticBaseUrl').$settings->getSetting('epetition_default_photo', 'application/modules/Epetition/externals/images/nophoto_petition_thumb_profile.png');
    return $defaultPhoto;
  }
}
