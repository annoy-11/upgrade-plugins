<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Offer.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Model_Offer extends Core_Model_Item_Abstract {

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
        $defaultPhoto = Zend_Registry::get('StaticBaseUrl').Engine_Api::_()->getApi('settings', 'core')->getSetting('classroom.class.no.photo', 'application/modules/Courses/externals/images/nophoto_class_thumb_profile.png');
        return $defaultPhoto;
    }
}
