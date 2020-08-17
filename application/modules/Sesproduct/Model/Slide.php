<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Slide.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_Slide extends Core_Model_Item_Abstract{
	protected $_searchTriggers = false;

  protected $_modifiedTriggers = false;
  function getPhotoUrl($type = null){
    $photo_id = $this->file_id;
   
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id, $type);
			if($file)
      	return $file->map();
			else{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id,'thumb.profile');
				if($file)
					return $file->map();
			}
    }
    return "";
    
  }
}
