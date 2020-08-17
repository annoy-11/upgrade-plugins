<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Remainingpayments.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_DbTable_Remainingpayments extends Engine_Db_Table {

  protected $_name = 'sescrowdfunding_remainingpayments';

  public function getCrowdfundingRemainingAmount($params = array()) {
  
    $tabeleName = $this->info('name');
    $select = $this->select()->from($tabeleName);
    if(isset($params['crowdfunding_id']))
      $select->where('crowdfunding_id =?',$params['crowdfunding_id']);	 
    return $this->FetchRow($select);
	}
}
