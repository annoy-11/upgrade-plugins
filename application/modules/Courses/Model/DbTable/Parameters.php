<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Parameters.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Courses_Model_Parameter';
  protected $_name = 'courses_parameters';

  function getParameterResult($params = array()) {
    if (isset($params['column_name']))
      $columnName = $params['column_name'];
    else
      $columnName = '*';
    $select = $this->select();
    if(isset($params['category_id']) && !empty($params['category_id']))
        $select->where('category_id =?', $params['category_id']);
    return $select->query()->fetchAll();
  }

}
