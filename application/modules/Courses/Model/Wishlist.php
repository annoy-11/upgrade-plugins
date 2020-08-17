<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Wishlist.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Courses_Model_Wishlist extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
  public function getParent($recurseType = NULL) {
    return $this->getOwner();
  }
  public function addCourse($file_id, $course_id = null) {
    $playlist_course = Engine_Api::_()->getDbtable('playlistcourses', 'courses')->createRow();
    $playlist_course->wishlist_id = $this->getIdentity();
    $playlist_course->file_id = $course_id;
    $playlist_course->order = 0;
    $playlist_course->save();
    return $playlist_course;
  }
  public function getCourses($params = array(), $paginator = true) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $user_id = $viewer->getIdentity();
    $playlistCourses = Engine_Api::_()->getDbtable('wishlists', 'courses');
		$playlistCoursesName = $playlistCourses->info('name');
		$courseTableName = Engine_Api::_()->getDbTable('courses', 'courses')->info('name');
    $select = $playlistCourses->select()
							->from($playlistCourses->info('name'))
            ->where('wishlist_id = ?', $this->getIdentity())
						 ->joinLeft($courseTableName, "$courseTableName.course_id = $playlistCoursesName.course_id", null)
						 ->where($courseTableName.'.course_id IS NOT NULL');
	  $select = $select->setIntegrityCheck(false);
    if (!isset($params) && !$params['order'])
      $select->order('order ASC');
    if ($paginator)
      return Zend_Paginator::factory($select);
    if (!empty($params['limit'])) {
      $select->limit($params['limit'])
              ->order('RAND() DESC');
    } 
    return $playlistCourses->fetchAll($select);
  }
  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array()) {
    $params = array_merge(array(
        'route' => 'courses_wishlist_view',
        'reset' => true,
        'wishlist_id' => $this->wishlist_id,
        'slug' => $this->getSlug(),
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }
  public function getPhotoUrl($type = NULL) {
    $photo_id = $this->photo_id;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, '');
      if ($file)
        return $file->map();
    }
    return	Engine_Api::_()->getApi('settings', 'core')->getSetting('courses_wishlist_default_image', Zend_Registry::get('StaticBaseUrl')."application/modules/Courses/externals/images/nophoto_wishlist_thumb_profile.png");
  }
  public function setPhoto($photo, $param = null) {
    if ($photo instanceof Zend_Form_Element_File){
      $file = $photo->getFileName();
      $name = basename($file);
    }
    else if (is_array($photo) && !empty($photo['tmp_name'])){
      $name = ($photo["name"]);
      $file = $photo['tmp_name'];
    }
    else if (is_string($photo) && file_exists($photo)){
      $file = $photo;
      $name = basename($file);
    }
    else
      throw new User_Model_Exception('Invalid argument passed to setPhoto: ' . print_r($photo, 1));

    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'courses_wishlist',
        'parent_id' => $this->getIdentity()
    );
    //Save
    $storage = Engine_Api::_()->storage();

    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(500, 500)
            ->write($path . '/m_' . $name)
            ->destroy();

    //Resize image (icon)
    $image = Engine_Image::factory();
    $image->open($file);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    $image->resample($x, $y, $size, $size, 48, 48)
            ->write($path . '/is_' . $name)
            ->destroy();

    //Course
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iSquare = $storage->create($path . '/is_' . $name, $params);
    $iMain->bridge($iMain, 'thumb.profile');
    $iMain->bridge($iSquare, 'thumb.icon');
    //Remove temp files
    @unlink($path . '/m_' . $name);
    @unlink($path . '/is_' . $name);

    if ($param == 'mainPhoto')
      $this->photo_id = $iMain->getIdentity();
    else
      $this->song_cover = $iMain->getIdentity();
    $this->save();
    return $this;
  }
/**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   * */
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   * */
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }
}
