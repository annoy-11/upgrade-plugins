<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Service.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_Service extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  public function getTitle() {
    return $this->title;
  }

  public function getPhotoUrl($type = NULL) {

    $photo_id = $this->photo_id;
    if (empty($photo_id)) {
      $path = Zend_Registry::get('Zend_View')->baseUrl() . '/' . 'application/modules/Eclassroom/externals/images/nophoto_service_thumb_profile.png';
      return $path;
    } elseif ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, '');
      return $file->map();
    }
  }

}
