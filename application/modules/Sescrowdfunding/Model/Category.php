<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_Category extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
  //Get category title
  public function getTitle() {
		if(!$this)
			return 'Deleted Category';
    return $this->category_name;
  }

  public function isOwner($owner)
  {
    return false;
  }

  //Get category table name
  public function getTable() {
    if (is_null($this->_table)) {
      $this->_table = Engine_Api::_()->getDbtable('categories', 'sescrowdfunding');
    }

    return $this->_table;
  }

  //Category href
  public function getHref($params = array()) {
		if(!$this)
			return 'javascript:;';
    if ($this->slug == '')
      return;

    $params = array_merge(array(
        'route' => 'sescrowdfunding_category_view',
        'reset' => true,
        'category_id' => $this->slug,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

  public function getBrowseCategoryHref($params = array()) {

    $params = array_merge(array(
        'route' => 'sescrowdfunding_general',
        'action' => 'browse',
        'reset' => true,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

	public function getPhotoUrl($type = NULL) {
		if(!$this)
			return 'application/modules/Sescrowdfunding/externals/images/category-thumb.png';
    $thumbnail = $this->colored_icon;
    if ($thumbnail) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->colored_icon, $type);
			if($file)
      	return $file->map();
    }
		return 'application/modules/Sescrowdfunding/externals/images/category-thumb.png';
  }

	public function getCategoryIconUrl($type = NULL) {
		if(!$this)
			return 'application/modules/Sescrowdfunding/externals/images/nophoto_crowdfunding_thumb_icon.png';
    $cat_icon = $this->cat_icon;
    if ($cat_icon) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->cat_icon, $type);
			if($file)
      	return $file->map();
    }
		return 'application/modules/Sescrowdfunding/externals/images/nophoto_crowdfunding_thumb_icon.png';
  }

  public function getOwner($recurseType = NULL) {
    return $this;
  }

}
