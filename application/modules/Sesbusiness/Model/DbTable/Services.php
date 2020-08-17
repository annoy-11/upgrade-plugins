<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Services.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Services extends Engine_Db_Table {

  protected $_rowClass = "Sesbusiness_Model_Service";

  public function getServicePaginator($params = array())
  {
    return Zend_Paginator::factory($this->getServiceMemers($params));
  }

  public function getServiceMemers($params = array()) {

    $select = $this->select()->from($this->info('name'));

    if (!empty($params)) {

      if (isset($params['type']) && $params['type'] == 'widget')
        $select = $select->where('enabled = ?', 1);

      if (isset($params['allService']))
        $select = $select->where('user_id IN(?)', $params['allService']);

      if (!empty($params['business_id']))
        $select->where($this->info('name') . '.business_id = ?', $params['business_id']);

      if (isset($params['limit']))
        $select = $select->limit($params['limit']);
    }

    $select->order("service_id DESC");

    if (isset($params['widgettype']) && $params['widgettype'] == 'widget')
      return $this->fetchAll($select);
    else
      return $paginator = Zend_Paginator::factory($select);
  }

  public function getUserId($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('service_id'))
                    ->where('user_id =?', $params['user_id'])
                    ->query()
                    ->fetchColumn();
  }

  public function getServiceId($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('service_id'))
                    ->where('user_id =?', $params['user_id'])
                    ->where('enabled = ?', 1)
                    ->query()
                    ->fetchColumn();
  }

}
