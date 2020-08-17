<?php

class Estore_Model_Offer extends Core_Model_Item_Abstract {

    protected $_searchTriggers = false;

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
        $defaultPhoto = Zend_Registry::get('StaticBaseUrl').Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct_product_default_photo', 'application/modules/Sesproduct/externals/images/nophoto_product_thumb_profile.png');
        return $defaultPhoto;
    }
}
