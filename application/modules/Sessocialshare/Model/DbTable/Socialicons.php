<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Socialicons.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Model_DbTable_Socialicons extends Engine_Db_Table {

  protected $_rowClass = "Sessocialshare_Model_Socialicon";

  public function getSocialInfo($params = array()) {

    $socialTable = Engine_Api::_()->getDbTable('socialicons', 'sessocialshare');
    $select = $socialTable->select()->order('order ASC');
    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }
    if (isset($params['limit']) && !empty($params['limit'])) {
      $select = $select->limit($params['limit']);
    }

    return $socialTable->fetchAll($select);
  }
}