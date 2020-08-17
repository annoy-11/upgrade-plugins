<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Category.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Model_Category extends Core_Model_Item_Abstract {
	protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
  public function getTitle() {
    return $this->category_name;
  }

  public function getTable() {
    if (is_null($this->_table)) {
      $this->_table = Engine_Api::_()->getDbtable('categories', 'sesarticle');
    }

    return $this->_table;
  }

  public function getHref($params = array()) {
    if ($this->slug == '') {
      return;
    }
    $params = array_merge(array(
        'route' => 'sesarticle_category_view',
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

  public function getBrowseArticleHref($params = array()) {
    $params = array_merge(array(
        'route' => 'sesarticle_general',
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
    $table = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle');
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
