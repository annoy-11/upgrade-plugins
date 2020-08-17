<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Teams.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_Model_DbTable_Teams extends Engine_Db_Table {

  protected $_rowClass = "Sessportz_Model_Team";

  public function getTeamMemers($params = array()) {

    $select = $this->select()->from($this->info('name'));

    if (!empty($params)) {

      if (isset($params['type']) && $params['type'] == 'widget')
        $select = $select->where('enabled = ?', 1);

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

  public function getTeamId($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('team_id'))
                    ->where('user_id =?', $params['user_id'])
                    ->where('enabled = ?', 1)
                    ->query()
                    ->fetchColumn();
  }
}
