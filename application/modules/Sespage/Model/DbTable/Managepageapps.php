<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Managepageapps.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Managepageapps extends Engine_Db_Table {

  protected $_rowClass = "Sespage_Model_Managepageapp";
  protected $_name = "sespage_managepageapps";

  public function isCheck($params = array()) {
  
    return $this->select()
            ->from($this->info('name'), $params['columnname'])
            ->where('page_id = ?', $params['page_id'])
            ->query()
            ->fetchColumn();
  }
  
  public function getManagepageId($params = array()) {
  
    return $this->select()
            ->from($this->info('name'), 'managepageapp_id')
            ->where('page_id = ?', $params['page_id'])
            ->query()
            ->fetchColumn();
  }
}