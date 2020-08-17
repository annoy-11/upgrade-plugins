<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Footerlinks.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Model_DbTable_Footerlinks extends Engine_Db_Table {

  protected $_rowClass = "Sessportz_Model_Footerlink";

  public function getInfo($params = array()) {

    $socialTable = Engine_Api::_()->getDbTable('footerlinks', 'sessportz');
    $select = $socialTable->select()->order('footerlink_id ASC');

    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }

    if (isset($params['sublink'])) {
      $select = $select->where('sublink = ?', $params['sublink']);
    }

    return $socialTable->fetchAll($select);
  }

  public function getFooterName($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('name'))
                    ->where('enabled = ?', 1)
                    ->where('footerlink_id =?', $params['footerlink_id'])
                    ->query()
                    ->fetchColumn();
  }

}
