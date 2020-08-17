<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Socialicons.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Model_DbTable_Socialicons extends Engine_Db_Table {

  protected $_rowClass = "Sessportz_Model_Socialicon";

  public function getSocialInfo($params = array()) {

    $socialTable = Engine_Api::_()->getDbTable('socialicons', 'sessportz');
    $select = $socialTable->select()->order('order ASC');
    if (isset($params['enabled']) && !empty($params['enabled'])) {
      $select = $select->where('enabled = ?', 1);
    }
    return $socialTable->fetchAll($select);
  }

}
