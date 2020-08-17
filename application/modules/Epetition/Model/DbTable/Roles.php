<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Roles.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Model_DbTable_Roles extends Engine_Db_Table
{

  public function getPetitionAdmins($params = array())
  {

    $select = $this->select()->where('epetition_id =?', $params['epetition_id']);
    return Zend_Paginator::factory($select);
  }

  public function getAllBlogAdmins($params = array())
  {
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()->where('epetition_id =?', $params['epetition_id'])->where('resource_approved =?', 1)->where('user_id <> ?', $viewer_id);
    return $this->fetchAll($select);
  }

  public function isPetitionAdmin($PetitionId = null, $petitionAdminId = null)
  {
    return $this->select()->from($this->info('name'), 'role_id')
      ->where('user_id =?', $petitionAdminId)
      ->where('epetition_id =?', $PetitionId)->query()->fetchColumn();
  }
}
