<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Parameters.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessreview_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Sesbusinessreview_Model_Parameter';
  protected $_name = 'sesbusinessreview_parameters';

  function getParameterResult($params = array()) {
    if (isset($params['column_name']))
      $columnName = $params['column_name'];
    else
      $columnName = '*';
    $select = $this->select()->from($this->info('name'), $columnName)->where('category =?', $params['category']);
    return $select->query()->fetchAll();
  }

}