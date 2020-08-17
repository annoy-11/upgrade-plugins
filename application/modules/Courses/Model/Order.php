<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Order.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Model_Order extends Core_Model_Item_Abstract {
    protected $_searchTriggers = false;
    protected $_statusChanged;
    protected $_modifiedTriggers = false;
    protected $_fromadmin = false;
    function fromAdmin(){
        $this->_fromadmin = true;
    }
    function getTransation($state = "pending"){
        $table = Engine_Api::_()->getDbTable('transactions','courses');
        if($this->_fromadmin) {
            $select = $table->select()->where('order_id =?', $this->getIdentity());
            $transaction = $table->fetchRow($select);
            return $transaction;
        }else{
            $this->state = $state;
        }
    }
    public function onOrderRefund(){
        $this->_statusChanged = false;
        if( $this->state == 'pending' ) {
            $this->state = 'refunded';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'refunded'), array('order_id = ?' => $this->getIdentity()));
            $transaction = $this->getTransation('refund');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();
        return $this;
    }
    public function didStatusChange() {
        return (bool) $this->_statusChanged;
    }
    // Cntests
    public function clearStatusChanged() {
        $this->_statusChanged = null;
        return $this;
    }
    public function onOrderPending()
    {
        $this->_statusChanged = false;
        if( $this->state != 'pending' ) {
            $this->state = 'pending';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'pending'), array('order_id = ?' => $this->getIdentity()));
            $transaction = $this->getTransation('pending');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();
        return $this;
    }
    public function onCancel()
    {
        $this->_statusChanged = false;
        if( $this->state != 'pending' ) {
            $this->state = 'cancelled';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'cancelled'), array('order_id = ?' => $this->getIdentity()));
            $transaction = $this->getTransation('cancelled');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();
        return $this;
    }

    public function onFailure()
    {
        $this->_statusChanged = false;
        if( $this->state != 'pending' ) {
            $this->state = 'failed';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'failed'), array('order_id = ?' => $this->getIdentity()));
            $transaction = $this->getTransation('failed');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();
        return $this;
    }
    public function onExpiration()
    {
        $this->_statusChanged = false;
        if( $this->state != 'pending' ) {
            $this->state = 'expire';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'expire'), array('order_id = ?' => $this->getIdentity()));
            $transaction = $this->getTransation('expire');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();
        return $this;
    }
    public function onOrderIncomplete()
    {
        $this->_statusChanged = false;
        if( $this->state != 'pending' ) {
            $this->state = 'incomplete';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'incomplete'), array('order_id = ?' => $this->getIdentity()));
            $transaction = $this->getTransation('incomplete');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();
        return $this;
    }

    public function onOrderComplete()
    {
        $this->_statusChanged = false;
        if( $this->state != 'pending' ) {
            $this->state = 'complete';
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','courses')->update(array('state' => 'complete'), array('order_id = ?' => $this->getIdentity()));
            $this->_statusChanged = true;
            $transaction = $this->getTransation('complete');
//            if($transaction){
//                $transaction->state = '';
//                $transaction->save();
//            }
        }
        $this->save();



        return $this;
    }
}
