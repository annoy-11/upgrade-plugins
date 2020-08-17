<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Parameters.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagereview_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Sespagereview_Model_Parameter';
  protected $_name = 'sespagereview_parameters';

  function getParameterResult($params = array()) {
    if (isset($params['column_name']))
      $columnName = $params['column_name'];
    else
      $columnName = '*';
    $select = $this->select()->from($this->info('name'), $columnName)->where('category =?', $params['category']);
    return $select->query()->fetchAll();
  }

}