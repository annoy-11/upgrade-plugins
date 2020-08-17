<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Transactions.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_Model_DbTable_Transactions extends Engine_Db_Table {

  protected $_rowClass = 'Sesbusinesspackage_Model_Transaction';

  public function getItemTransaction($params = array()) {
    $tableName = $this->info('name');
    $select = $this->select()->from($tableName)->where('orderspackage_id =?', $params['order_package_id'])->where('gateway_profile_id !=?', '')->limit(1);
    if (empty($params['noCondition'])) {
      $select->where('state = "pending" || state = "complete" || state = "okay" || state = "active" ');
    }
    return $this->fetchRow($select);
  }

  public function getBenefitStatus(User_Model_User $user = null) {
    // Get benefit setting
    $benefitSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.payment.mod.enable');
    if (!in_array($benefitSetting, array('all', 'some', 'none'))) {
      $benefitSetting = 'all';
    }

    switch ($benefitSetting) {
      default:
      case 'all':
        return true;
        break;

      case 'some':
        if (!$user) {
          return false;
        }
        return (bool) $this->select()
                        ->from($this, new Zend_Db_Expr('TRUE'))
                        ->where('owner_id = ?', $user->getIdentity())
                        ->where('status = ?', 'okay')
                        ->limit(1);
        break;

      case 'none':
        return false;
        break;
    }

    return false;
  }

}
