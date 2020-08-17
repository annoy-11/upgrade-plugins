<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managebusinessapps.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_DbTable_Managebusinessapps extends Engine_Db_Table {

  protected $_rowClass = "Sesbusiness_Model_Managebusinessapp";
  protected $_name = "sesbusiness_managebusinessapps";

  public function isCheck($params = array()) {

    return $this->select()
            ->from($this->info('name'), $params['columnname'])
            ->where('business_id = ?', $params['business_id'])
            ->query()
            ->fetchColumn();
  }

  public function getManagebusinessId($params = array()) {

    return $this->select()
            ->from($this->info('name'), 'managebusinessapp_id')
            ->where('business_id = ?', $params['business_id'])
            ->query()
            ->fetchColumn();
  }
}
