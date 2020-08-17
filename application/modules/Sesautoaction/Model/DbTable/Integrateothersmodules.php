<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Integrateothersmodules.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesautoaction_Model_DbTable_Integrateothersmodules extends Engine_Db_Table {

  protected $_rowClass = 'Sesautoaction_Model_Integrateothersmodule';

  public function getResults($params = array()) {

    if (isset($params['column_name']))
      $columnName = $params['column_name'];
    else
      $columnName = '*';
    $select = $this->select()
            ->from($this->info('name'), $columnName);

    if (isset($params['integrateothersmodule_id']))
      $select = $select->where('integrateothersmodule_id = ?', $params['integrateothersmodule_id']);

    if (isset($params['content_type']))
      $select = $select->where('content_type = ?', $params['content_type']);

    if (isset($params['module_name']))
      $select = $select->where('module_name = ?', $params['module_name']);

    if (isset($params['content_id']))
      $select = $select->where('content_id = ?', $params['content_id']);

    if (isset($params['enabled']))
      $select = $select->where('enabled = ?', $params['enabled']);

    if (isset($params['type']))
      $select = $select->where('type = ?', $params['type']);

    return $select->query()->fetchAll();
  }
}
