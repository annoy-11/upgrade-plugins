<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_Category extends Core_Model_Item_Abstract {
	protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
  public function getTitle() {
    return $this->category_name;
  }

  public function getTable() {
    if (is_null($this->_table)) {
      $this->_table = Engine_Api::_()->getDbtable('categories', 'sesproduct');
    }

    return $this->_table;
  }

  public function getHref($params = array()) {
    if ($this->slug == '') {
      return;
    }
    $params = array_merge(array(
        'route' => 'sesproduct_category_view',
        'reset' => true,
        'category_id' => $this->slug,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }

  public function getBrowseProductHref($params = array()) {
    $params = array_merge(array(
        'route' => 'sesproduct_general',
	'action'=>'browse',
        'reset' => true,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }
  public function getUsedCount() {
    $table = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
    $rName = $table->info('name');
    $select = $table->select()
            ->from($rName)
            ->where($rName . '.category_id = ?', $this->category_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }
	public function getPhotoUrl($type = NULL) {

    $photo_id = $this->thumbnail;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->thumbnail, '');
			if($file)
      return $file->map();
    }
  }
}
