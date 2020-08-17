<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Categories.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Model_DbTable_Categories extends Engine_Db_Table
{

	protected $_rowClass = 'Epetition_Model_Category';

	/**
	 * Get Category according Viewer
	 */
	public function getCategoriesAssoc($params = array())
	{
		$stmt = $this->select()
			->from($this, array('category_id', 'category_name'))
			->where('subcat_id = ?', 0)
			->where('subsubcat_id = ?', 0);
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		if ($viewerId && isset($params['member_levels']) && $params['member_levels'] == 1) {
			$levelId = Engine_Api::_()->user()->getViewer()->level_id;
			$stmt->where('CONCAT(engine4_epetition_categories.member_levels," ") LIKE "%' . $levelId . '%"');
		}
		$stmt = $stmt->order('order DESC')
			->query()
			->fetchAll();
		$data = array();
		if (isset($params['module']) && $params['module'] == 'group') {
			$data[] = '';
		}
		foreach ($stmt as $category) {
			$data[$category['category_id']] = $category['category_name'];
		}
		return $data;
	}

	public function getUserCategoriesAssoc($user)
	{
		if ($user instanceof User_Model_User) {
			$user = $user->getIdentity();
		} else if (!is_numeric($user)) {
			return array();
		}

		$stmt = $this->getAdapter()
			->select()
			->from('engine4_epetition_categories', array('category_id', 'category_name'))
			->joinLeft('engine4_epetition_petitions', "engine4_epetition_petitions.category_id = engine4_epetition_categories.category_id")
			->group("engine4_epetition_categories.category_id")
			->where('engine4_epetition_petitions.owner_id = ?', $user)
			->where('engine4_epetition_petitions.draft = ?', "0")
			->order('category_name ASC')
			->query();

		$data = array();
		foreach ($stmt->fetchAll() as $category) {
			$data[$category['category_id']] = $category['category_name'];
		}

		return $data;
	}

	/**
	 * Get Category id
	 */
	public function getCategoryId($slug = null)
	{
		if ($slug) {
			$tableName = $this->info('name');
			$select = $this->select()
				->from($tableName)
				->where($tableName . '.slug = ?', $slug);
			$row = $this->fetchRow($select);
			if (empty($row)) {
				$category_id = $slug;
			} else
				$category_id = $row->category_id;
		}
		if (isset($category_id))
			return $category_id;
		else
			return;
	}

	/**
	 * Get Category Delete
	 */
	public function deleteCategory($params = array())
	{
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

	/**
	 * Get Sub Category
	 */
	public function getModuleSubsubcategory($params = array())
	{
		$tableName = $this->info('name');
		$category_select = $this->select()
			->from($this->info('name'), $params['column_name']);
		if (isset($params['category_id']))
			$category_select = $category_select->where($tableName . '.subsubcat_id = ?', $params['category_id']);
		if (isset($params['countEpetitions'])) {
			$epetitionTable = Engine_Api::_()->getDbTable('epetitions', 'epetition')->info('name');
			$category_select = $category_select->setIntegrityCheck(false);
			$category_select = $category_select->joinLeft($epetitionTable, "$epetitionTable.subsubcat_id=$tableName.category_id", array("total_petitions_categories" => "COUNT(epetition_id)"));
			$category_select = $category_select->group("$tableName.category_id");
			$category_select->order('total_petitions_categories DESC');
		}
		$category_select = $category_select->order('order DESC');
		return $this->fetchAll($category_select);
	}

	public function getModuleSubcategory($params = array())
	{
		$tableName = $this->info('name');
		$category_select = $this->select()->from($tableName, $params['column_name']);
		if (isset($params['category_id']))
			$category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);
		if (isset($params['countPetitions'])) {
			$epetitionTable = Engine_Api::_()->getDbTable('epetitions', 'epetition')->info('name');
			$category_select = $category_select->setIntegrityCheck(false);
			$category_select = $category_select->joinLeft($epetitionTable, "$epetitionTable.subcat_id=$tableName.category_id", array("total_petitions_categories" => "COUNT(epetition_id)"));
			$category_select = $category_select->group("$tableName.category_id");
			$category_select->order('total_petitions_categories DESC');
		}
		$category_select = $category_select->order('order DESC');
		return $this->fetchAll($category_select);
	}

	public function getMapping($params = array())
	{
		$select = $this->select()->from($this->info('name'), $params);
		$mapping = $this->fetchAll($select);
		if (!empty($mapping)) {
			return $mapping->toArray();
		}
		return null;
	}

	public function getMapId($categoryId = '')
	{
		$tableName = $this->info('name');
		if ($categoryId) {
			$category_map_id = $this->select()
				->from($tableName, 'profile_type')
				->where('category_id = ?', $categoryId)
				->order('order DESC');
			$category_map_id = $this->fetchAll($category_map_id);
			if (isset($category_map_id[0]->profile_type)) {
				return $category_map_id[0]->profile_type;
			} else
				return 0;
		}
	}

	public function getSubCatMapId($subcategoryId = '')
	{
		$tableName = $this->info('name');
		if ($subcategoryId) {
			$category_map_id = $this->select()
				->from($tableName, 'profile_type')
				->where('category_id = ?', $subcategoryId)
				->order('order DESC');
			$category_map_id = $this->fetchAll($category_map_id);
			if (isset($category_map_id[0]->profile_type)) {
				return $category_map_id[0]->profile_type;
			} else
				return 0;
		}
	}

	public function getSubSubCatMapId($subsubcategoryId = '')
	{
		$tableName = $this->info('name');
		if ($subsubcategoryId) {
			$category_map_id = $this->select()
				->from($tableName, 'profile_type')
				->where('category_id = ?', $subsubcategoryId)
				->order('order DESC');
			$category_map_id = $this->fetchAll($category_map_id);
			if (isset($category_map_id[0]->profile_type)) {
				return $category_map_id[0]->profile_type;
			} else
				return 0;
		}
	}

	public function getColumnName($params = array())
	{
		$tableName = $this->info('name');
		$category_select = $this->select()
			->from($tableName, $params['column_name']);
		if (isset($params['category_id']))
			$category_select = $category_select->where('category_id = ?', $params['category_id']);
		if (isset($params['subcat_id']))
			$category_select = $category_select->where('subcat_id = ?', $params['subcat_id']);
		return $category_select = $category_select->query()->fetchColumn();
	}

	public function getCategory($params = array(), $customParams = array(), $searchParams = array())
	{
		if (isset($params['column_name']))
			$column = $params['column_name'];
		else
			$column = '*';

		$tableName = $this->info('name');
		$category_select = $this->select()
			->from($tableName, $column)
			->where($tableName . '.subcat_id = ?', 0)
			->where($tableName . '.subsubcat_id = ?', 0);
		if (isset($params['criteria']) && $params['criteria'] == 'alphabetical')
			$category_select->order($tableName . '.category_name');

		$petitionTable = Engine_Api::_()->getDbTable('epetitions', 'epetition')->info('name');
		if ((isset($params['hasPetition']) && $params['hasPetition']) || isset($params['countPetitions']) || (isset($params['criteria']) && $params['criteria'] == 'most_petition'))
		{
			$take = true;
			$category_select = $category_select->setIntegrityCheck(false);
			$category_select = $category_select->joinLeft($petitionTable, "$petitionTable.category_id=$tableName.category_id", array("total_petitions_categories" => "COUNT(epetition_id)"));
			if (empty($params['countPetitions'])) {
				$category_select = $category_select->having("COUNT($petitionTable.category_id) > 0")
					->group("$petitionTable.category_id");
				if (isset($params['petitionDesc'])) {
					if ($params['criteria'] && $params['criteria'] == 'most_petition') {
						$category_select->order('total_petitions_categories DESC');
					}
				}
			} else {
				$category_select = $category_select->group("$tableName.category_id");
				if ($params['criteria'] && $params['criteria'] == 'most_petition') {
					$category_select->order('total_petitions_categories DESC');
				}
			}
		}
		if (isset($params['petitionRequired'])) {
			if (empty($take)) {
				$category_select = $category_select->setIntegrityCheck(false);
				$category_select = $category_select->joinLeft($petitionTable, "$petitionTable.category_id=$tableName.category_id", array("total_petitions_categories" => "COUNT(epetition_id)"));
			}
			$category_select = $category_select->having("COUNT($petitionTable.category_id) > 0")
				->group("$petitionTable.category_id");
		}

		if (isset($params['image']) && !empty($params['image']))
			$category_select = $category_select->where($tableName . '.cat_icon !=?', '');
		// if (isset($params['param']) && !empty($params['param']))
		//  $category_select = $category_select->where('param =?', $params['param']);
		$category_select = $category_select->order('order DESC');
		if (isset($params['category_id']) && !empty($params['category_id']))
			$category_select = $category_select->where($tableName . '.category_id = ?', $params['category_id']);
		if (count($customParams)) {
			return Zend_Paginator::factory($category_select);
		}
		if (isset($params['limit']) && $params['limit'])
			$category_select->limit($params['limit']);
		return $this->fetchAll($category_select);
	}

	public function getCloudCategory($params = array())
	{

		$petitionTable = Engine_Api::_()->getDbTable('epetitions', 'epetition');
		$petitionTableName = $petitionTable->info('name');
		if (isset($params['column_name']))
			$column = $params['column_name'];
		else
			$column = '*';
		$tableName = $this->info('name');
		$category_select = $this->select()
			->from($tableName, $column)
			->setIntegrityCheck(false)
			->joinLeft($petitionTableName, "$petitionTableName.category_id=$tableName.category_id", array("total_petitions_categories" => "COUNT(epetition_id)"))
			->where($tableName . '.subcat_id = ?', 0)
			->where($tableName . '.subsubcat_id = ?', 0)
			->group("$petitionTableName.category_id")
			->order('order DESC');
		if (count($params) && isset($params['paginator']))
			return Zend_Paginator::factory($category_select);

		return $this->fetchAll($category_select);
	}

	public function slugExists($slug = '', $id = '')
	{
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

	public function orderNext($params = array())
	{
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

	public function order($categoryType = 'category_id', $categoryTypeId)
	{
		// Get a list of all corresponding category, by order
		$table = Engine_Api::_()->getItemTable('epetition_category');
		$currentOrder = $table->select()
			->from($table, 'category_id')
			->order('order DESC');
		if ($categoryType != 'category_id')
			$currentOrder = $currentOrder->where($categoryType . ' = ?', $categoryTypeId);
		else
			$currentOrder = $currentOrder->where('subcat_id = ?', 0)->where('subsubcat_id = ?', 0);
		return $currentOrder->query()->fetchAll(Zend_Db::FETCH_COLUMN);
	}

	public function getBreadcrumb($params = array())
	{
		$category = false;
		$Subcategory = false;
		$subSubcategory = false;
		if (count($params) > 0) {
			if ($params->subcat_id != 0) {
				$category = $this->getModuleCategory(array('column_name' => '*', 'category_id' => $params->subcat_id));
				$Subcategory = $this->getModuleCategory(array('column_name' => '*', 'category_id' => $params->category_id));
			} else if ($params->subsubcat_id != 0) {
				$subSubcategory = $this->getModuleCategory(array('column_name' => '*', 'category_id' => $params->category_id));
				$Subcategory = $this->getModuleCategory(array('column_name' => '*', 'category_id' => $params->subsubcat_id));
				$category = $this->getModuleCategory(array('column_name' => '*', 'category_id' => $Subcategory[0]['subcat_id']));
			} else
				$category = $this->getModuleCategory(array('column_name' => '*', 'category_id' => $params->category_id));
		}
		return array('category' => $category, 'subcategory' => $Subcategory, 'subSubcategory' => $subSubcategory);
	}

	public function getModuleCategory($params = array())
	{
		$category_select = $this->select()
			->from($this->info('name'), $params['column_name']);
		if (isset($params['category_id']))
			$category_select = $category_select->where('category_id = ?', $params['category_id']);
		$category_select = $category_select->order('order DESC');
		return $this->fetchAll($category_select);
	}

	public function hasCategory($params = array())
	{

		$tableName = $this->info('name');
		$category_select = $this->select()
			->from($tableName, 'category_id')
			->where('category_name = ?', $params['category_name']);
		return $category_select->query()->fetchColumn();
	}

	public function hasCategoryId($params = array())
	{

		$tableName = $this->info('name');
		$category_select = $this->select()
			->from($tableName, 'category_id')
			->where('epetition_categoryid = ?', $params['epetition_categoryid']);
		return $category_select->query()->fetchColumn();
	}

}
