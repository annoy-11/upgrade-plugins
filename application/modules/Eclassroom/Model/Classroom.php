<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Classroom.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_Classroom extends Core_Model_Item_Abstract {

  protected $_type = 'classroom';
  protected $_parent_type = 'user';
  protected $_parent_is_owner = true;
  protected $_owner_type = 'user';
  protected $_statusChanged;

  public function membership() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbTable('membership', 'eclassroom'));
  }
  public function getKeywords(){
    return $this->seo_keywords ? trim($this->seo_keywords,',') : "";
  }
  public function getTitle() {
    return $this->title;
  }
  public function getHref($params = array()) {
    $params = array_merge(array(
        'route' => 'eclassroom_profile',
        'reset' => true,
        'id' => $this->custom_url,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    $route = Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
     return $route;
  }
  public function setPhoto($photo, $isShareContent = false, $phototype = null) {
    $this->photo_id = Engine_Api::_()->sesbasic()->setPhoto($photo, false,false,'eclassroom','eclassroom','',$this,true,true, 'watermark_photo');
    $this->save();

    // Add to album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('eclassroom_photo');
    $courseAlbum = $this->getSingletonAlbum($phototype);
    if ($phototype == 'profile') {
      $courseAlbum->title = Zend_Registry::get('Zend_Translate')->_('Profile Photos');
    }
    $courseAlbum->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $courseAlbum->save();
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
        'classroom_id' => $this->getIdentity(),
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
    $table = Engine_Api::_()->getItemTable('eclassroom_album');
    $select = $table->select()
            ->where('classroom_id = ?', $this->getIdentity())
            ->where('type =?', $type)
            ->order('album_id ASC')
            ->limit(1);
    $album = $table->fetchRow($select);
    if (null === $album) {
      $album = $table->createRow();
      $album->setFromArray(array(
          'title' => $this->getTitle(),
          'classroom_id' => $this->getIdentity(),
          'owner_id' => $viewer->getIdentity(),
      ));
      $album->type = $type;
      $album->save();
    }
    return $album;
  }
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
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

    $enableWatermark = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.photos.watermark', 0);
    if($enableWatermark == 1){
      $watermarkImage = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id,'eclassroom', 'watermark_cphoto');
      if(is_file($watermarkImage)){
        $mainFileUploaded =   APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.$name;
        $fileName = current(explode('.',$fileName));
        $fileNew = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.time().'_'.$fileName.".jpg";
        $watemarkImageResult = Engine_Api::_()->sesbasic()->watermark_image($mainPath, $fileNew,$extension,$watermarkImage,'eclassroom');
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
        throw new Sesevent_Model_Exception($e->getMessage(), $e->getCode());
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
    $photoTable = Engine_Api::_()->getItemTable('eclassroom_photo');
    $classroomAlbum = $this->getSingletonAlbum('cover');
    $classroomAlbum->title = Zend_Registry::get('Zend_Translate')->_('Cover Photos');

    $classroomAlbum->save();
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
        'classroom_id' => $this->getIdentity(),
        'album_id' => $classroomAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'file_id' => $iMain->getIdentity(),
        'collection_id' => $classroomAlbum->getIdentity(),
    ));
    $photoItem->save();
    $classroomAlbum->photo_id = $photoItem->getIdentity();
    $classroomAlbum->save();


    return $this;
  }
  public function getCoverPhotoUrl() {
    $photo_id = $this->cover;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->cover);
      if ($file)
        return $file->map();
    }
    $defaultPhoto = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->getItem('user', $this->owner_id), 'eclassroom', 'defaultCphoto');

    if (!$defaultPhoto) {
      $defaultPhoto = 'application/modules/eclassroom/externals/images/blank.png';
    }
    return $defaultPhoto;
  }
  function canApproveActivity($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'approve_disapprove_member');
    return $permission;
  }
  function canDeleteComment($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_delete_comment');
    return $permission;
  }
  function canEditComment($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_delete_comment');
    return $permission;
  }
  function canEditActivity($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_edit_delete');
    return $permission;
  }
  function activityComposerOptions($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $schedulePost = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->toCheckUserClassroomRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_schedult_post');
    $allowed = array('sesadvancedactivitylinkedin' => 'sesadvancedactivitylinkedin', 'sesadvancedactivityfacebookpostembed' => 'sesadvancedactivityfacebookpostembed', 'buysell' => 'buysell', 'fileupload' => 'fileupload', 'sesadvancedactivityfacebook' => 'sesadvancedactivityfacebook', 'sesadvancedactivitytwitter' => 'sesadvancedactivitytwitter', 'tagUseses' => 'tagUseses', 'shedulepost' => 'shedulepost', 'sesadvancedactivitytargetpost' => 'sesadvancedactivitytargetpost', 'sesfeedgif' => 'sesfeedgif', 'feelingssctivity' => 'feelingssctivity', 'emojisses' => 'emojisses');

    if (!$schedulePost) {
      unset($allowed['shedulepost']);
    }

    //Manage Apps
    $photos = Engine_Api::_()->getDbTable('manageclassroomapps', 'eclassroom')->isCheck(array('classroom_id' => $this->classroom_id, 'columnname' => 'photos'));
    if (empty($photos))
      unset($allowed['eclassroom_photo']);

    $fileupload = Engine_Api::_()->getDbTable('manageclassroomapps', 'eclassroom')->isCheck(array('classroom_id' => $this->classroom_id, 'columnname' => 'fileupload'));
    if (empty($fileupload))
      unset($allowed['fileupload']);

    return $allowed;
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
    $defaultPhoto = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->getItem('user', $this->owner_id), 'classroom', 'bsdefaultphoto');
    if(!$defaultPhoto){
      $defaultPhoto = Zend_Registry::get('StaticBaseUrl'). 'application/modules/Eclassroom/externals/images/nophoto_classroom_thumb_profile.png';
    }
    return $defaultPhoto;
  }
    public function setBackgroundPhoto($photo) {
    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $name = $photo->getFileName();
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $name = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $name = $photo;
    } else {
      throw new Estore_Model_Exception('invalid argument passed to setPhoto');
    }
    $name = basename($name);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_id' => $this->getIdentity(),
        'parent_type' => 'classroom'
    );
    // Save
    $storage = Engine_Api::_()->storage();
    // Resize image (main)
    copy($file, $path . '/m_' . $name);
    // Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    // Remove temp files
    @unlink($path . '/m_' . $name);
    // Update row
    $this->background_photo_id = $iMain->file_id;
    $this->save();
    return $this;
  }
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
}
