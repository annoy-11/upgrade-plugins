<?php

class Estore_Model_Slide extends Core_Model_Item_Abstract {
  protected $_searchTriggers = false;
  public function getFilePath($item = 'thumb_icon') {
    $file = Engine_Api::_()->getItem('storage_file', $this->{$item});
    if ($file)
      return $file->map();
  }
     public function getPhotoUrl($type = null) {
    $file_id = $this->file_id;
    if ($file_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id, $type);
			if($file)
      	return $file->map();
			else{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id,'thumb.profile');
				if($file)
					return $file->map();
			}
    }
		$settings = Engine_Api::_()->getApi('settings', 'core');
		$defaultPhoto = Zend_Registry::get('StaticBaseUrl').$settings->getSetting('sesproduct_product_default_photo', 'application/modules/Sesproduct/externals/images/nophoto_product_thumb_profile.png');
		return $defaultPhoto;
  }
}
