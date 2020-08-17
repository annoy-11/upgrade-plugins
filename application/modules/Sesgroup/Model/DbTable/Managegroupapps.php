<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managegroupapps.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Model_DbTable_Managegroupapps extends Engine_Db_Table {

  protected $_rowClass = "Sesgroup_Model_Managegroupapp";
  protected $_name = "sesgroup_managegroupapps";

  public function isCheck($params = array()) {
  
    return $this->select()
            ->from($this->info('name'), $params['columnname'])
            ->where('group_id = ?', $params['group_id'])
            ->query()
            ->fetchColumn();
  }
  
  public function getManagegroupId($params = array()) {
  
    return $this->select()
            ->from($this->info('name'), 'managegroupapp_id')
            ->where('group_id = ?', $params['group_id'])
            ->query()
            ->fetchColumn();
  }
}