<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managestoreapps.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Managestoreapps extends Engine_Db_Table {

  protected $_rowClass = "Estore_Model_Managestoreapp";
  protected $_name = "estore_managestoreapps";

  public function isCheck($params = array()) {

    $select = $this->select()
            ->from($this->info('name'), $params['columnname'])
            ->where('store_id = ?', $params['store_id']);

    if(isset($params['limit']) && !empty($params['limit']))
        $select->limit($params['limit']);

    return   $select->query()
                ->fetchColumn();
  }

  public function getManagestoreId($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'managestoreapp_id')
            ->where('store_id = ?', $params['store_id'])
            ->query()
            ->fetchColumn();
  }
}
