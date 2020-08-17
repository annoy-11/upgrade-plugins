<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Categories.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Categories extends Engine_Db_Table {

  protected $_rowClass = 'Courses_Model_Category';
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
  public function getBreadcrumb($params = array()) {
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

  public function getCategory($params = array())
  {
    if (isset($params['column_name'])) {
      $column = $params['column_name'];
    } else
      $column = '*';
    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($tableName, $column)
            ->where($tableName . '.subcat_id = ?', 0)
            ->where($tableName . '.subsubcat_id = ?', 0);

    if (isset($params['criteria']) && $params['criteria'] == 'alphabetical')
      $category_select->order($tableName . '.category_name');

    if (isset($params['criteria']) && $params['criteria'] == 'admin_order')
      $category_select->order($tableName . '.order');

    if (isset($params['category_id']) && !empty($params['category_id']))
      $category_select = $category_select->where($tableName . '.category_id = ?', $params['category_id']);

    $courseTableName = Engine_Api::_()->getDbTable('courses', 'courses')->info('name');
    $category_select = $category_select->setIntegrityCheck(false);
    $category_select = $category_select->joinLeft($courseTableName, "$courseTableName.category_id=$tableName.category_id AND (".$courseTableName.".`is_approved` = 1 AND `" . $courseTableName . "`.`draft` != 0)", array("total_courses_categories" => "COUNT($courseTableName.course_id)"));
    $category_select = $category_select->group("$tableName.category_id");
    if (isset($params['criteria']) && $params['criteria'] == 'most_course')
        $category_select->order('total_courses_categories DESC');
    if (isset($params['criteria']) && $params['criteria'] != 'most_course')
        $category_select = $category_select->order('order DESC');
    if (isset($params['category_id']) && !empty($params['category_id']))
        $category_select = $category_select->where($tableName . '.category_id = ?', $params['category_id']);

    if (isset($params['hasCourse'])) {
    
      
        $currentTime = date('Y-m-d H:i:s');
        $tomorrow_date = date("Y-m-d H:i:s", strtotime("+ 1 day"));
        $nextWeekDate = date("Y-m-d H:i:s", strtotime("+ 7 day"));
        $category_select = $category_select->having('total_courses_categories > 0');
        if (isset($params['order']) && !empty($params['order'])) {
            if ($params['order'] == 'featured')
            $category_select->where('featured = ?', '1');
            elseif ($params['order'] == 'sponsored')
            $category_select->where('sponsored = ?', '1');
            elseif ($params['order'] == 'hot')
            $category_select->where('hot = ?', '1');
        }
    }
    if (isset($params['courseRequired'])) {
      $category_select = $category_select->having("COUNT($courseTableName.category_id) > 0")
              ->group("$courseTableName.category_id");
    }

    if ( !empty($params['paginator'])) {
      return Zend_Paginator::factory($category_select);
    }
    if (isset($params['limit']))
      $category_select->limit($params['limit']);
    $category_select->order('order DESC');
    return $this->fetchAll($category_select);
  }

  public function getCoursePaginator($params = array())
  {
        return Zend_Paginator::factory($this->getCategory($params));
  }
  public function order($categoryType = 'category_id', $categoryTypeId) {
    // Get a list of all corresponding category, by order
    $table = Engine_Api::_()->getItemTable('courses_category');
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
  public function getMapId($categoryId = '', $type = 'profile_type') {
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
  public function getSubCatMapId($subcategoryId = '', $type = 'profile_type') {
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

  public function getSubSubCatMapId($subsubcategoryId = '', $type = 'profile_type') {
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
//     if (isset($params['module'])) {
//       $stmt = $stmt->where('resource_type = ?', $params['module']);
//     }
    $stmt = $stmt->order('order DESC')
            ->query()
            ->fetchAll();
    $data = array();
    if (isset($params['module']) && $params['module'] == 'courses') {
      $data[] = '';
    }


    foreach ($stmt as $category) {
      if (!$category['category_id'] && !isset($params['uncategories']))
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
    else if (isset($params['getcategory0']))
      $category_select = $category_select->where($tableName . '.subcat_id = ?', '-1');
    if (isset($params['countCourses'])) {
      $courseTable = Engine_Api::_()->getDbTable('courses', 'courses')->info('name');
      $category_select = $category_select->setIntegrityCheck(false);
      $category_select = $category_select->joinLeft($courseTable, "$courseTable.subcat_id=$tableName.category_id", array("total_courses_categories" => "COUNT($courseTable.photo_id)"));
      $category_select = $category_select->group("$tableName.category_id");
      $category_select->order('total_courses_categories DESC');
    }

    $category_select = $category_select->order('order DESC');
    if (isset($params['limit']))
      $category_select->limit($params['limit']);
    return $this->fetchAll($category_select);
  }
  public function getCourseSubcategory($params = array()) {
    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($tableName, $params['column_name']);
    if (isset($params['category_id']) && !empty($params['category_id']))
      $category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);
    else if (isset($params['getcategory0']))
      $category_select = $category_select->where($tableName . '.subcat_id = ?', '-1');
    if (isset($params['countCourses'])) {
      $courseTable = Engine_Api::_()->getDbTable('courses', 'courses')->info('name');
      $category_select = $category_select->setIntegrityCheck(false);
      $category_select = $category_select->joinLeft($courseTable, "$courseTable.subcat_id=$tableName.category_id", array("total_courses_categories" => "COUNT($courseTable.photo_id)"));
      $category_select = $category_select->group("$tableName.category_id");
      $category_select->order('total_courses_categories DESC');
    }

    $category_select = $category_select->order('order DESC');
    if (isset($params['limit']))
      $category_select->limit($params['limit']);
    return $this->fetchAll($category_select);
  }
  public function getModuleCategory($params = array()) {

    $category_select = $this->select()
            ->from($this->info('name'), $params['column_name']);
    if (isset($params['category_id']))
      $category_select->where('category_id = ?', $params['category_id']);
    if (isset($params['category']) && !empty($params['category'])) {
      $category_select->where('subcat_id = ?', 0)->where('subsubcat_id = ?', 0);
    }
    $category_select = $category_select->order('order DESC');
    return $this->fetchAll($category_select);
  }

  public function getModuleSubsubcategory($params = array()) {

    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($this->info('name'), $params['column_name']);
    if (isset($params['category_id']))
      $category_select = $category_select->where($tableName . '.subsubcat_id = ?', $params['category_id']);
    else if (isset($params['getcategory0']))
      $category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);
    if (isset($params['countCourses'])) {
      $courseTable = Engine_Api::_()->getDbTable('courses', 'courses')->info('name');
      $category_select = $category_select->setIntegrityCheck(false);
      $category_select = $category_select->joinLeft($courseTable, "$courseTable.subsubcat_id= $tableName.category_id", array("total_courses_categories" => "COUNT($courseTable.course_id)"));

      $category_select = $category_select->group("$tableName.category_id");
      $category_select->order('total_courses_categories DESC');
    }
    $category_select = $category_select->order('order DESC');
    if (isset($params['limit']))
      $category_select->limit($params['limit']);
    return $this->fetchAll($category_select);
  }
   public function getCourseSubsubcategory($params = array()) {

    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($this->info('name'), $params['column_name']);
    if (isset($params['category_id']))
      $category_select = $category_select->where($tableName . '.subsubcat_id = ?', $params['category_id']);
    else if (isset($params['getcategory0']))
      $category_select = $category_select->where($tableName . '.subcat_id = ?', $params['category_id']);
    if (isset($params['countCourses'])) {
      $courseTable = Engine_Api::_()->getDbTable('courses', 'courses')->info('name');
      $category_select = $category_select->setIntegrityCheck(false);
      $category_select = $category_select->joinLeft($courseTable, "$courseTable.subsubcat_id= $tableName.category_id", array("total_courses_categories" => "COUNT($courseTable.course_id)"));

      $category_select = $category_select->group("$tableName.category_id");
      $category_select->order('total_courses_categories DESC');
    }

    $category_select = $category_select->order('order DESC');
    if (isset($params['limit']))
      $category_select->limit($params['limit']);
    return $this->fetchAll($category_select);
  }
  public function getCloudCategory($params = array()) {
    $courseTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $courseTableName = $courseTable->info('name');
    if (isset($params['column_name']))
      $column = $params['column_name'];
    else
      $column = '*';
    $tableName = $this->info('name');
    $category_select = $this->select()
            ->from($tableName, $column)
            ->setIntegrityCheck(false)
            ->joinLeft($courseTableName, "$courseTableName.category_id=$tableName.category_id", array("total_courses_categories" => "COUNT(course_id)"))
            ->where($tableName . '.subcat_id = ?', 0)
            ->where($tableName . '.subsubcat_id = ?', 0)
            ->group("$courseTableName.category_id")
            ->order('order DESC');
    if (isset($params['course_required']) && $params['course_required'] == 1)
      $category_select = $category_select->where($courseTableName . '.category_id IS NOT NULL');
    if (count($params) && isset($params['paginator']))
      return Zend_Paginator::factory($category_select);
    return $this->fetchAll($category_select);
  }
}
