<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Usersponssorshippayrequests.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Usersponsorshippayrequests extends Engine_Db_Table {

  protected $_name = 'sesproduct_usersponsorshippayrequests';
  protected $_rowClass = "Sesproduct_Model_Usersponsorshippayrequest";

  public function getPaymentRequests($params = array()) {
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if (isset($params['event_id']))
      $select->where('event_id =?', $params['event_id']);

    if (isset($params['state']) && $params['state'] == 'complete')
      $select->where('state =?', $params['state']);

    $select->where('is_delete	= ?', '0');
    return $this->fetchAll($select);
  }

}
