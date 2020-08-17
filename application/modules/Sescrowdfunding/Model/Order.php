<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Order.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_Order extends Core_Model_Item_Collection {

	protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
  protected $_user;
	protected $_product;
  protected $_gateway;
  protected $_source;

	public function onOrderRefund() {
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
		$this->save();
		return $this;
 }
}