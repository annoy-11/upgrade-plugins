<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesdiscussion_Model_Category extends Core_Model_Item_Abstract {
  
  protected $_searchTriggers = false;
  
  //Get category title
  public function getTitle() {
		if(!$this)
			return 'Deleted Category';
    return $this->category_name;
  }

	public function getPhotoUrl($type = NULL) {
		if(!$this)
			return 'application/modules/Sesdiscussion/externals/images/nophoto_discussion_thumb_profile.png';
    $thumbnail = $this->thumbnail;
    if ($thumbnail) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->thumbnail, $type);
			if($file)
      	return $file->map();
    } 
		return 'application/modules/Sesdiscussion/externals/images/nophoto_discussion_thumb_profile.png';
  }
}