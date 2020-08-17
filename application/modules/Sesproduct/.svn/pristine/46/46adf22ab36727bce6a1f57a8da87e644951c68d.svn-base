<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userpayrequest.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_Userpayrequest extends Core_Model_Item_Abstract {
	protected $_searchTriggers = false;
  protected $_modifiedTriggers = false;
  protected $_user;
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
		if( $this->state == 'pending' ) {
			$this->state = 'pending';
		}
		$this->save();
		return $this;
	}
	public function onOrderCancel()
	{
		if( $this->state == 'pending' ) {
			$this->state = 'cancelled';
		}
		$this->save();
		return $this;
	}
	
	public function onOrderFailure()
	{
		if( $this->state == 'pending' ) {
			$this->state = 'failed';
		}
		$this->save();
		return $this;
	}
	
	public function onOrderIncomplete()
	{
		if( $this->state == 'pending' ) {
			$this->state = 'incomplete';
		}
		$this->save();
		return $this;
	}
	
	public function onOrderComplete()
	{
		if( $this->state == 'pending' ) {
			$this->state = 'complete';
		}
		$this->save();
		return $this;
	}
}
