<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Demousers.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdemouser_Model_DbTable_Demousers extends Engine_Db_Table {

  protected $_rowClass = "Sesdemouser_Model_Demouser";
  
  public function getDemoUserId($user_id = '' ) {
		if(!$user_id || $user_id == '')
			 return null;
    return $this->select()
                    ->from($this->info('name'), array('demouser_id'))
                    ->where('user_id =?', $user_id)
                    ->where('enabled =?', 1)
                    ->query()
                    ->fetchColumn();
  }
  
  public function getDemoUsers($params = array()) {

    $select = $this->select()->from($this->info('name'));

    if (!empty($params)) {

      if (isset($params['widgettype']) && $params['widgettype'] == 'widget')
        $select = $select->where('enabled = ?', 1);

      if (isset($params['limit']))
        $select = $select->limit($params['limit']);
    }

    $select->order("order ASC");

    if (isset($params['widgettype']) && $params['widgettype'] == 'widget')
      return $this->fetchAll($select);
    else
      return $paginator = Zend_Paginator::factory($select);
  }

  public function getUserId($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('demouser_id'))
                    ->where('user_id =?', $params['user_id'])
                    ->query()
                    ->fetchColumn();
  }

}
