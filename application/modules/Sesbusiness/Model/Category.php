<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_Category extends Core_Model_Category {
  protected $_searchTriggers = false;
  //Get category title
  public function getTitle() {
    if (!$this)
      return 'Deleted Category';
    return $this->category_name;
  }

  //Get category table name
  public function getTable() {
    if (is_null($this->_table)) {
      $this->_table = Engine_Api::_()->getDbTable('categories', 'sesbusiness');
    }
    return $this->_table;
  }

  //Category href
  public function getHref($params = array()) {
    if (!$this)
      return 'javascript:;';
    if ($this->slug == '')
      return;
    $params = array_merge(array(
        'route' => 'sesbusiness_category_view',
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
        'route' => 'sesbusiness_general',
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
    if (!$this)
      return 'application/modules/Sesbusiness/externals/images/nophoto_business_thumb_profile.png';
    $thumbnail = $this->thumbnail;
    if ($thumbnail) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->thumbnail, $type);
      if ($file)
        return $file->map();
    }
    return 'application/modules/Sesbusiness/externals/images/nophoto_business_thumb_profile.png';
  }

  public function isOwner($owner) {

    if ($owner instanceof Core_Model_Item_Abstract) {
      return ( $this->getIdentity() == $owner->getIdentity() && $this->getType() == $owner->getType() );
    } else if (is_array($owner) && count($owner) === 2) {
      return ( $this->getIdentity() == $owner[1] && $this->getType() == $owner[0] );
    } else if (is_numeric($owner)) {
      return ( $owner == $this->getIdentity() );
    }

    return false;
  }

  public function getOwner($recurseType = NULL) {
    return $this;
  }

}
