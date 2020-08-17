<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Order.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_Order extends Core_Model_Item_Abstract {
    protected $_searchTriggers = false;
    protected $_statusChanged;
    protected $_modifiedTriggers = false;
    protected $_fromadmin = false;
    function fromAdmin(){
        $this->_fromadmin = true;
    }
    function getTransation($state = "pending"){
        $table = Engine_Api::_()->getDbTable('transactions','sesproduct');
        if($this->_fromadmin) {
            $select = $table->select()->where('order_id =?', $this->getIdentity());
            $transaction = $table->fetchRow($select);
            return $transaction;
        }else{
            $orderTableName = Engine_Api::_()->getDbTable('orders','sesproduct');
            $select = $orderTableName->select($orderTableName->info('name'),'order_id')->where('parent_order_id =?',$this->getIdentity());
            $orders = $orderTableName->fetchAll($select);
            $orderIds = array();
            foreach ($orders as $order) {
                $orderIds[] = $order->getIdentity();
            }
            $selectTransaction = $table->select()->where('order_id IN (?)', $orderIds);
            $transactions = $table->fetchAll($selectTransaction);
            foreach ($transactions as $transaction){
                $transaction->state = $state;
                $transaction->save();
            }
        }
    }
    public function onOrderRefund(){
        $this->_statusChanged = false;
        if( $this->state == 'pending' ) {
            $this->state = 'refunded';
            $this->_statusChanged = true;
            if(!$this->_fromadmin)
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'refunded'), array('parent_order_id = ?' => $this->getIdentity()));
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
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'pending'), array('parent_order_id = ?' => $this->getIdentity()));
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
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'cancelled'), array('parent_order_id = ?' => $this->getIdentity()));
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
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'failed'), array('parent_order_id = ?' => $this->getIdentity()));
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
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'expire'), array('parent_order_id = ?' => $this->getIdentity()));
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
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'incomplete'), array('parent_order_id = ?' => $this->getIdentity()));
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
                Engine_Api::_()->getDbTable('orders','sesproduct')->update(array('state' => 'complete'), array('parent_order_id = ?' => $this->getIdentity()));
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
