<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Manageclassroomapps.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Model_DbTable_Manageclassroomapps extends Engine_Db_Table {

  protected $_rowClass = "Eclassroom_Model_Manageclassroomapp";
  protected $_name = "eclassroom_manageclassroomapps";

  public function isCheck($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['columnname'])
            ->where('classroom_id = ?', $params['classroom_id']);

    if(isset($params['limit']) && !empty($params['limit']))
        $select->limit($params['limit']);

    return   $select->query()
                ->fetchColumn();
  }

  public function getManageclassroomId($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'manageclassroomapp_id')
            ->where('classroom_id = ?', $params['classroom_id'])
            ->query()
            ->fetchColumn();
  }
}
