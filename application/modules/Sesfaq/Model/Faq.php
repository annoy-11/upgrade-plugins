<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Faq.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_Model_Faq extends Core_Model_Item_Abstract {
  
  public function getPhotoUrl($type = NULL) {
  
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
    } else {
      return 'application/modules/Sesfaq/externals/images/nophoto_faq_thumb_profile.png';
    }
//     $settings = Engine_Api::_()->getApi('settings', 'core');
//     $defaultPhoto = 'application/modules/Sesfaq/externals/images/nophoto_faq_thumb_profile.png';
//     return $defaultPhoto;
  }

	public function getTitle(){
		return $this->title;	
	}
	
  public function getHref($params = array()) {
    
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'sesfaq_profile',
      'reset' => true,
      'faq_id' =>  $this->faq_id,
      'slug' => $slug,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

  protected function _delete() {
    if ($this->_disableHooks)
      return;
    parent::_delete();
  }
  
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }

  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }
}