<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Manageactions.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Model_DbTable_Manageactions extends Engine_Db_Table {

  protected $_rowClass = 'Sespoke_Model_Manageaction';

  public function getResults($params = array()) {

    $select = $this->select();

    if (isset($params['manageaction_id']))
      $select->where('manageaction_id = ?', $params['manageaction_id']);

    if (isset($params['name']))
      $select->where('name = ?', $params['name']);

    if (isset($params['enabled']))
      $select->where('enabled = ?', $params['enabled']);


    return $select->query()->fetchAll();
  }

}
