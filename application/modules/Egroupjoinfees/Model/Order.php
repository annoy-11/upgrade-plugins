<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Order.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Egroupjoinfees_Model_Order extends Core_Model_Item_Collection {
	protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
  protected $_user;
	protected $_product;
  protected $_gateway;
  protected $_source;
	
	// Events
	public function onOrderRefund(){
	if( $this->state == 'pending' ) {
			$this->state = 'refunded';
		}
		$this->save();
		return $this;
	}
	public function onOrderPending()
	{
		if( $this->state != 'pending' ) {
			$this->state = 'pending';
		}
		$this->save();
		return $this;
	}
	public function onOrderCancel()
	{
		if( $this->state != 'pending' ) {
			$this->state = 'cancelled';
		}
		$this->save();
		return $this;
	}
	
	public function onOrderFailure()
	{
		if( $this->state != 'pending' ) {
			$this->state = 'failed';
		}
		$this->save();
		return $this;
	}
	
	public function onOrderIncomplete()
	{
		if( $this->state != 'pending' ) {
			$this->state = 'incomplete';
		}
		$this->save();
		return $this;
	}
	
 public function onOrderComplete()
	{
		if( $this->state != 'pending' ) {
			$this->state = 'complete';
		}
		
		 // Process form
    $viewer = Engine_Api::_()->user()->getViewer();
    $subject = Engine_Api::_()->getItem('sesgroup_group', $this->group_id);//Engine_Api::_()->core()->getSubject();
    $db = $subject->membership()->getReceiver()->getTable()->getAdapter();
    $subject->membership()->addMember($viewer)->setUserApproved($viewer);
    $db->beginTransaction();
    try {
      $membership_status = $subject->membership()->getRow($viewer)->active;
      $subject->membership()->setUserApproved($viewer);
      $row = $subject->membership()->getRow($viewer);
      $row->save();
      // Add activity
      if (!$membership_status) {
        $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
        $action = $activityApi->addActivity($viewer, $subject, 'sesgroup_group_join');
      }
      $db->commit();
      $dbObj = Engine_Db_Table::getDefaultAdapter();
      $members = $subject->membership()->getMembers();
      foreach($members as $user){
        if(!$viewer->isSelf($user) ) {
          if(!$user->membership()->isMember($viewer) ) {
            if(!$viewer->isBlocked($user) ) {
              $dbObj->query("INSERT INTO `engine4_user_membership`(`resource_id`, `user_id`, `active`, `resource_approved`, `user_approved`) VALUES (".$viewer->getIdentity().",".$user->getIdentity().",1,1,1)");
              $dbObj->query("INSERT INTO `engine4_user_membership`( `user_id`,`resource_id`, `active`, `resource_approved`, `user_approved`) VALUES (".$viewer->getIdentity().",".$user->getIdentity().",1,1,1)");
            }
          }
        }
      }
      //for auto approve group
      Engine_Api::_()->sesgroup()->approveGroup($subject);
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
		$this->save();
		return $this;
 }
 public function getProduct() {
		if (null === $this->_product) {
			$productTable = Engine_Api::_()->getDbtable('products', 'payment');
			$this->_product = $productTable->fetchRow($productTable->select()
											->where('extension_type = ?', 'egroupjoinfees_order')
											->where('extension_id = ?', $this->getIdentity())
											->limit(1));
			// Create a new product?
			if (!$this->_product) {
					$this->_product = $productTable->createRow();
					$this->_product->setFromArray($this->getProductParams());
					$this->_product->save();
			}
		}
		return $this->_product;
	}
	public function getProductParams() {
			$viewer = Engine_Api::_()->user()->getViewer();
			$commissionType = Engine_Api::_()->authorization()->getPermission($viewer,'group','group_admcosn');
			$commissionTypeValue = Engine_Api::_()->authorization()->getPermission($viewer,'group','group_commival');
			$orderAmount = round(($this->total_amount), 2);
			$total_price = round($this->total_amount,1);
			//%age wise
			$currentCurrency = Engine_Api::_()->egroupjoinfees()->getCurrentCurrency();
			$defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency();
			$settings = Engine_Api::_()->getApi('settings', 'core');
			$currencyValue = 1;
			if($currentCurrency != $defaultCurrency){
					$currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
			}
			if($commissionType == 1 && $commissionTypeValue > 0){
					$this->commission_amount = round(($total_price/$currencyValue) * ($commissionTypeValue/100),2);
			}else if($commissionType == 2 && $commissionTypeValue > 0){
					$this->commission_amount = $commissionTypeValue;
			}
			$this->save();
			return array(
					'title' => 'order',
					'description' => 'egroupjoinfees_order',
					'price' => @round(($this->total_amount), 2),
					'extension_id' => $this->getIdentity(),
					'extension_type' => 'egroupjoinfees_order',
			);
    }
	public function getGatewayIdentity() {
				return $this->getProduct()->sku;
	}
	public function getGatewayParams($params = array()) {
		//get site community title
		$title = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title', '');
		$params['name'] = $title . ' Order No #' . $this->order_id;
		$params['price'] = @round(($this->total_amount), 2);
		$params['description'] = 'Orders #' . $this->order_id . ' on ' . $title;
		$params['vendor_product_id'] = $this->getProduct()->sku;
		$params['recurring'] = false;
		$params['tangible'] = false;
		return $params;
    }
}
