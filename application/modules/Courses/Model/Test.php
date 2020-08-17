<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Test.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Test extends Core_Model_Item_Abstract
{
  // Properties
	protected $_searchTriggers = true;
  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
   
    public function getHref($params = array()) {
        $slug = $this->getSlug();
        $params = array_merge(array(
        'route' => 'tests_general',
        'reset' => true,
        'test_id' => $this->test_id,
        'action'=>'view',
        ), $params);
        $route = $params['route'];
        $reset = $params['reset'];
        unset($params['route']);
        unset($params['reset']);
        return Zend_Controller_Front::getInstance()->getRouter()
        ->assemble($params, $route, $reset);
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
   return "";
  }
  public function delete(){
    $this->is_delete = 1;
    $this->save();
  }
//   public function getOwner() {
//    return Engine_Api::_()->getItem('user', $this->owner_id);
//   }
  public function getDescription() {
    // @todo decide how we want to handle multibyte string functions
    $tmpBody = strip_tags($this->description);
    return ( Engine_String::strlen($tmpBody) > 255 ? Engine_String::substr($tmpBody, 0, 255) . '...' : $tmpBody );
  }
  public function fields() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getApi('core', 'fields'));
  }
  public function getKeywords($separator = ' ') {
    $keywords = array();
    foreach( $this->tags()->getTagMaps() as $tagmap ) {
      $tag = $tagmap->getTag();
      if($tag) {
        $keywords[] = $tag->getTitle();
      }
    }
    if( null === $separator ) {
      return $keywords;
    }
    return join($separator, $keywords);
  }
  // Interfaces
  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   **/
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   **/
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }
  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   **/
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }
}
