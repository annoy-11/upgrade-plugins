<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Service.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_Service extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  public function getTitle() {
    return $this->title;
  }

  public function getPhotoUrl($type = NULL) {

    $photo_id = $this->photo_id;
    if (empty($photo_id)) {
      $path = Zend_Registry::get('Zend_View')->baseUrl() . '/' . 'application/modules/Sespage/externals/images/nophoto_service_thumb_profile.png';
      return $path;
    } elseif ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, '');
      return $file->map();
    }
  }

}