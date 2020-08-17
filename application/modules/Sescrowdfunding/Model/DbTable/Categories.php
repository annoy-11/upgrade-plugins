<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Categories.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_DbTable_Categories extends Engine_Db_Table {

  protected $_rowClass = 'Sescrowdfunding_Model_Category';
  protected $_searchTriggers = false;

  public function getCategoryId($slug = null) {

    if ($slug) {
      $tableName = $this->info('name');
      $select = $this->select()
              ->from($tableName)
              ->where($tableName . '.slug = ?', $slug);
      $row = $this->fetchRow($select);
      if (empty($row))
        $category_id = $slug;
      else
        $category_id = $row->category_id;
    }

    if (isset($category_id))
      return $category_id;
    else
      return;
  }

  public function deleteCategory($params = array()) {

    $isValid = false;
    if (count($params) > 0) {
      if ($params->subcat_id != 0) {
        $Subcategory = $this->getModuleSubsubcategory(array('column_name' => '*', 'category_id' => $params->category_id));
        if (count($Subcategory) > 0)
          $isValid = false;
        else
          $isValid = true;
      } else if ($params->subsubcat_id != 0) {
        $isValid = true;
      } else {
        $category = $this->getModuleSubcategory(array('column_name' => '*', 'category_id' => $params->category_id));
        if (count($category) > 0)
          $isValid = false;
        else
          $isValid = true;
      }
    }
    return $isValid;
  }

  public function slugExists($slug = '', $id = '') {

    if ($slug != '') {

      $tableName = $this->info('name');
      $select = $this->select()
              ->from($tableName)
              ->where($tableName . '.slug = ?', $slug);

      if ($id != '') {
        $select = $select->where('id != ?', $id);
      }

      $row = $this->fetchRow($select);
      if (empty($row)) {
        return true;
      } else
        return false;
    }
    return false;
  }

  public function orderNext($params = array()) {

    $category_select = $this->select()
            ->from($this->info('name'), '*')
            ->limit(1)
            ->order('order DESC');

    if (isset($params['category_id'])) {
      $category_select = $category_select->where('subcat_id = ?', 0)->where('subsubcat_id = ?', 0);
    } else if (isset($params['subsubcat_id'])) {
      $category_select = $category_select->where('subsubcat_id = ?', $params['subsubcat_id']);
    } else if (isset($params['subcat_id'])) {
      $category_select = $category_select->where('subcat_id = ?', $params['subcat_id']);
    }

    $category_select = $this->fetchRow($category_select);
    if (empty($category_select))
      $order = 1;
    else
      $order = $category_select['order'] + 1;
    return $order;
  }

  public function getCategory($params = array(), $customParams = array()) {

    if (isset($params['column_name'])) {
      $column = $params['column_name'];
    } else
      $column = '*';

    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($tableName, $column);

    //Category View Page Work
    if(isset($params['category_id']) && !empty($params['category_id']) && isset($params['subcat_id']) && !empty($params['subcat_id'])) {
      $category_select = $category_select->where($tableName . '.subsubcat_id = ?', $params['category_id']);
    } else if (isset($params['category_id']) && !empty($params['category_id'])) {
      $category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);
    } else {
      $category_select = $category_select->where($tableName . '.subcat_id = ?', 0)
                                        ->where($tableName . '.subsubcat_id = ?', 0);
    }

    if (isset($params['criteria']) && $params['criteria'] == 'alphabetical')
      $category_select = $category_select->order($tableName . '.category_name');

    $crowdfundingTable = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->info('name');
    $category_select = $category_select->setIntegrityCheck(false);
    $category_select = $category_select->joinLeft($crowdfundingTable, "$crowdfundingTable.category_id=$tableName.category_id", array("total_crowdfundings_categories" => "COUNT($crowdfundingTable.crowdfunding_id)"));

    $category_select  = $category_select->group("$tableName.category_id");

    if(isset($params['criteria']) && $params['criteria'] == 'most_crowdfunding')
      $category_select->order('total_crowdfundings_categories DESC');

		if(isset($params['criteria']) && $params['criteria'] != 'most_crowdfunding')
    	$category_select = $category_select->order('order DESC');

    if (isset($params['category_id']) && !empty($params['category_id']) && $params['widgetname'] != 'category-view')
      $category_select = $category_select->where($tableName . '.category_id = ?', $params['category_id']);

    if(isset($params['hasFaq'])){
      $category_select = $category_select->having('total_crowdfundings_categories > 0');
    }

    if (count($params) && isset($params['paginator'])) {
      return Zend_Paginator::factory($category_select);
    }

		if(isset($params['limit']))
			$category_select->limit($params['limit']);

		$category_select->order('order DESC');

    return $this->fetchAll($category_select);
  }

  public function order($categoryType = 'category_id', $categoryTypeId) {
    // Get a list of all corresponding category, by order
    $table = Engine_Api::_()->getItemTable('sescrowdfunding_category');
    $currentOrder = $table->select()
            ->from($table, 'category_id')
            ->order('order DESC');
    if ($categoryType != 'category_id')
      $currentOrder = $currentOrder->where($categoryType . ' = ?', $categoryTypeId);
    else
      $currentOrder = $currentOrder->where('subcat_id = ?', 0)->where('subsubcat_id = ?', 0);
    return $currentOrder->query()->fetchAll(Zend_Db::FETCH_COLUMN);
  }

  public function getMapping($params = array()) {

    $select = $this->select()->from($this->info('name'), $params);
    $mapping = $this->fetchAll($select);
    if (!empty($mapping)) {
      return $mapping->toArray();
    }
    return null;
  }

  public function getMapId($categoryId = '',$type = 'profile_type') {
    $tableName = $this->info('name');
    if ($categoryId) {
      $category_map_id = $this->select()
              ->from($tableName, $type)
              ->where('category_id = ?', $categoryId);
      $category_map_id = $this->fetchAll($category_map_id);

      if (isset($category_map_id[0]) && isset($category_map_id[0]->{$type})) {
        return $category_map_id[0]->{$type};
      } else
        return 0;
    }
  }

  public function getSubCatMapId($subcategoryId = '',$type = 'profile_type') {
    $tableName = $this->info('name');
    if ($subcategoryId != '') {
      $category_map_id = $this->select()
              ->from($tableName, $type)
              ->where('category_id = ?', $subcategoryId);
      $category_map_id = $this->fetchAll($category_map_id);
      if (isset($category_map_id[0]->{$type})) {
        return $category_map_id[0]->{$type};
      } else
        return 0;
    }
  }

  public function getSubSubCatMapId($subsubcategoryId = '',$type = 'profile_type') {
    $tableName = $this->info('name');
    if ($subsubcategoryId != '') {
      $category_map_id = $this->select()
              ->from($tableName, $type)
              ->where('category_id = ?', $subsubcategoryId);
      $category_map_id = $this->fetchAll($category_map_id);
      if (isset($category_map_id[0]->{$type})) {
        return $category_map_id[0]->{$type};
      } else
        return 0;
    }
  }

  public function getCategoriesAssoc($params = array()) {
    $stmt = $this->select()
            ->from($this, array('category_id', 'category_name'))
            ->where('subcat_id = ?', 0)
            ->where('subsubcat_id = ?', 0);
    if (isset($params['module'])) {
      $stmt = $stmt->where('resource_type = ?', $params['module']);
    }
    $stmt = $stmt->order('order ASC')
            ->query()
            ->fetchAll();
    $data = array();
    //if (isset($params['module']) && $params['module'] == 'group') {
      $data[] = 'Choose Category';
    //}
    foreach ($stmt as $category) {
			if(!$category['category_id'] && !isset($params['uncategories']))
				continue;
      $data[$category['category_id']] = $category['category_name'];
    }
    return $data;
  }

  public function getColumnName($params = array()) {
    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($tableName, $params['column_name']);
    if (isset($params['category_id']))
      $category_select = $category_select->where('category_id = ?', $params['category_id']);
    if (isset($params['subcat_id']))
      $category_select = $category_select->where('subcat_id = ?', $params['subcat_id']);
    return $category_select = $category_select->query()->fetchColumn();
  }

  public function getModuleSubcategory($params = array()) {

    $tableName = $this->info('name');
    $category_select = $this->select()
                            ->from($tableName, $params['column_name']);

    if (isset($params['category_id']) && !empty($params['category_id']))
      $category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);

		else if(isset($params['getcategory0']))
			$category_select = $category_select->where($tableName . '.subcat_id = ?', '-1');

    if (isset($params['countFaqs'])) {
      $crowdfundingTable = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->info('name');
      $category_select = $category_select->setIntegrityCheck(false);
      $category_select = $category_select->joinLeft($crowdfundingTable, "$crowdfundingTable.subcat_id=$tableName.category_id", array("total_crowdfundings_categories" => "COUNT($crowdfundingTable.photo_id)"));
      $category_select = $category_select->group("$tableName.category_id");
      $category_select->order('total_crowdfundings_categories DESC');
    }

		if(isset($params['limit']))
			$category_select = $category_select->limit($params['limit']);

    $category_select = $category_select->order('order DESC');
    return $this->fetchAll($category_select);
  }

  public function getModuleCategory($params = array()) {

    $category_select = $this->select()
            ->from($this->info('name'), $params['column_name']);
    if (isset($params['category_id']))
      $category_select = $category_select->where('category_id = ?', $params['category_id']);
    $category_select = $category_select->order('order DESC');
    return $this->fetchAll($category_select);
  }

  public function getModuleSubsubcategory($params = array()) {

    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($this->info('name'), $params['column_name']);

    if (isset($params['category_id']))
      $category_select = $category_select->where($tableName . '.subsubcat_id = ?', $params['category_id']);

		else if(isset($params['getcategory0']))
			$category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);

    if (isset($params['countFaqs'])) {
      $crowdfundingTable = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->info('name');
      $category_select = $category_select->setIntegrityCheck(false);
      $category_select = $category_select->joinLeft($crowdfundingTable, "$crowdfundingTable.subsubcat_id=$tableName.category_id", array("total_crowdfundings_categories" => "COUNT($crowdfundingTable.crowdfunding_id)"));

      $category_select = $category_select->group("$tableName.category_id");
      $category_select->order('total_crowdfundings_categories DESC');
    }

		if(isset($params['limit']))
			$category_select = $category_select->limit($params['limit']);

    $category_select = $category_select->order('order DESC');

    return $this->fetchAll($category_select);
  }

}
