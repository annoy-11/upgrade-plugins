<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesprayer_Model_Category extends Core_Model_Item_Abstract {
  
  protected $_searchTriggers = false;
  
  //Get category title
  public function getTitle() {
		if(!$this)
			return 'Deleted Category';
    return $this->category_name;
  }

	public function getPhotoUrl($type = NULL) {
		if(!$this)
			return 'application/modules/Sesprayer/externals/images/nophoto_prayer_thumb_profile.png';
    $thumbnail = $this->thumbnail;
    if ($thumbnail) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->thumbnail, $type);
			if($file)
      	return $file->map();
    } 
		return 'application/modules/Sesprayer/externals/images/nophoto_prayer_thumb_profile.png';
  }
}