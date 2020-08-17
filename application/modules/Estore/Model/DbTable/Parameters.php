<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id Parameters.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Parameters extends Engine_Db_Table {

  protected $_rowClass = 'Estore_Model_Parameter';
  protected $_name = 'estore_parameters';

  function getParameterResult($params = array()) {
    if (isset($params['column_name']))
      $columnName = $params['column_name'];
    else
      $columnName = '*';
        $select = $this->select()->where('category_id =?', $params['category_id']);

    return $select->query()->fetchAll();
  }

}
