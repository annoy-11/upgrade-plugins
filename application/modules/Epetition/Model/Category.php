<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Category.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Model_Category extends Core_Model_Item_Abstract
{
  protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
  public function getTitle()
  {
    return $this->category_name;
  }

  public function getTable()
  {
    if (is_null($this->_table)) {
      $this->_table = Engine_Api::_()->getDbtable('categories', 'epetition');
    }

    return $this->_table;
  }

  public function getHref($params = array())
  {
    if ($this->slug == '') {
      return;
    }
    $params = array_merge(array(
      'route' => 'epetition_category_view',
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

  public function getBrowsePetitionHref($params = array())
  {
    $params = array_merge(array(
      'route' => 'epetition_general',
      'action' => 'browse',
      'reset' => true,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
  public function getUsedCount()
  {
    $table = Engine_Api::_()->getDbTable('epetition', 'epetition');
    $rName = $table->info('name');
    $select = $table->select()
      ->from($rName)
      ->where($rName . '.category_id = ?', $this->category_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }
  public function getPhotoUrl($type = NULL)
  {

    $photo_id = $this->thumbnail;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->thumbnail, '');
      if ($file)
        return $file->map();
    }
		return 'application/modules/Epetition/externals/images/blank-img.gif';
  }
}
