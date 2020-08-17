<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Socialicons.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Model_DbTable_Socialicons extends Engine_Db_Table {

  protected $_rowClass = "Sessocialtube_Model_Socialicon";

  public function getSocialInfo($params = array()) {

    $socialTable = Engine_Api::_()->getDbTable('socialicons', 'sessocialtube');
    $select = $socialTable->select()->order('order ASC');
    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }
    return $socialTable->fetchAll($select);
  }

}
