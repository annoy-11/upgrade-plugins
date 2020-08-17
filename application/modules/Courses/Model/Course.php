<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Course.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Course extends Core_Model_Item_Abstract
{
  // Properties
  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_searchTriggers = array('title', 'body', 'search');
  protected $_type = 'courses';
  protected $_statusChanged;
  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
   
  public function getShortType($inflect = false){
        return "course";
  }
  public function getHref($params = array()) {
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'courses_profile',
      'reset' => true,
      'course_id' => $this->custom_url,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
  public function setPhoto($photo, $isShareContent = false, $phototype = null) {
    $this->photo_id = Engine_Api::_()->sesbasic()->setPhoto($photo, false,false,'courses','courses','',$this,true,true, 'watermark_photo');
    $this->save();
    // Add to album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('coursesalbum_photo');
    $courseAlbum = $this->getSingletonAlbum($phototype);
    if ($phototype == 'profile') {
      $courseAlbum->title = Zend_Registry::get('Zend_Translate')->_('Profile Photos');
    }
    $courseAlbum->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $courseAlbum->save();
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
        'course_id' => $this->getIdentity(),
        'album_id' => $courseAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'file_id' => $this->photo_id,
        'collection_id' => $courseAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
    ));
    $photoItem->save();
    $courseAlbum->photo_id = $photoItem->getIdentity();
    $courseAlbum->save();
    return $this;
  }
  public function getSingletonAlbum($type = null) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getItemTable('coursesalbum_album');
    $select = $table->select()
            ->where('course_id = ?', $this->getIdentity())
            ->where('type =?', $type)
            ->order('album_id ASC')
            ->limit(1);
    $album = $table->fetchRow($select);
    if (null === $album) {
      $album = $table->createRow();
      $album->setFromArray(array(
          'title' => $this->getTitle(),
          'course_id' => $this->getIdentity(),
          'owner_id' => $viewer->getIdentity(),
      ));
      $album->type = $type;
      $album->save();
    }
    return $album;
  }
  public function setCoverPhoto($photo) {
    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if ($photo instanceof Storage_Model_File) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id)) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $fileName = $photo;
      $unlink = false;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');

    if (!$fileName) {
      $fileName = $file;
    }
    $filesTable = Engine_Api::_()->getDbTable('files', 'storage');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => $this->getType(),
        'parent_id' => $this->getIdentity(),
        'user_id' => $this->owner_id,
        'name' => $fileName,
    );
    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(1400, 1400)
            ->write($mainPath)
            ->destroy();
    $enableWatermark = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.photos.watermark', 0);
    if($enableWatermark == 1){
      $watermarkImage = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id,'courses', 'watermark_cphoto');
      if(is_file($watermarkImage)){
        $mainFileUploaded =   APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.$name;
        $fileName = current(explode('.',$fileName));
        $fileNew = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.time().'_'.$fileName.".jpg";
        $watemarkImageResult = Engine_Api::_()->sesbasic()->watermark_image($mainPath, $fileNew,$extension,$watermarkImage,'courses');
        if($watemarkImageResult){
          @unlink($mainPath);
          $image->open($fileNew)
                ->autoRotate()
                ->resize(1400, 1400)
                ->write($mainPath)
                ->destroy();
          @unlink($fileNew);
        }
      }
    }
    // Classroom
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch (Exception $e) {
      @unlink($file);
      // Remove temp files
      @unlink($mainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Courses_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    if (!isset($unlink))
      @unlink($file);
    // Remove temp files
    @unlink($mainPath);

    // Update row
    $this->cover = $iMain->file_id;
    $this->save();
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    // Add to album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('coursesalbum_photo');
    $courseAlbum = $this->getSingletonAlbum('cover');
    $courseAlbum->title = Zend_Registry::get('Zend_Translate')->_('Cover Photos');

    $courseAlbum->save();
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
        'course_id' => $this->getIdentity(),
        'album_id' => $courseAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'file_id' => $iMain->getIdentity(),
        'collection_id' => $courseAlbum->getIdentity(),
    ));
    $photoItem->save();
    $courseAlbum->photo_id = $photoItem->getIdentity();
    $courseAlbum->save();
    return $this;
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
    //$settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultPhoto = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->getItem('user', $this->owner_id), 'courses', 'bsdefaultphoto');
    if(!$defaultPhoto){
      $defaultPhoto = Zend_Registry::get('StaticBaseUrl'). 'application/modules/Courses/externals/images/nophoto_course_thumb_profile.jpg';
    }
    return $defaultPhoto;
  }
  public function getDescription() {

    // @todo decide how we want to handle multibyte string functions
    $tmpBody = strip_tags($this->description);
    return ( Engine_String::strlen($tmpBody) > 255 ? Engine_String::substr($tmpBody, 0, 255) . '...' : $tmpBody );
  }
  public function getDuration() {
    $lectureTable = Engine_Api::_()->getItemTable('courses_lecture');
    $lectureTableName = $lectureTable->info('name');
    $select = $lectureTable->select()->from($lectureTableName, new Zend_Db_Expr('SUM('.$lectureTableName.'.duration) as duration'))
      ->where($lectureTableName.".course_id = ? ",$this->course_id);
    return $lectureTable->fetchRow($select);
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
  
  function canDeleteComment($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('courseroles', 'courses')->toCheckUserCourseRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_delete_comment');
    return $permission;
  }
  function canEditComment($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('courseroles', 'courses')->toCheckUserCourseRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_delete_comment');
    return $permission;
  }
  function canEditActivity($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('courseroles', 'courses')->toCheckUserCourseRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_edit_delete');
    return $permission;
  }
  
}
